<?php

namespace App\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\CartItem;
use App\Core\Session;
use App\Core\View;

class PaypalController extends Controller
{
    private $clientId = '#your_client_id#';
    private $secret = '#your_secret#';

    private function getAccessToken(): ?string
    {
        $ch = curl_init('https://api-m.sandbox.paypal.com/v1/oauth2/token');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD => "$this->clientId:$this->secret",
            CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
            CURLOPT_HTTPHEADER => ['Accept: application/json']
        ]);
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $res['access_token'] ?? null;
    }

    public function createPayment()
    {
        $orderId = Session::get('paypal_order_id');
        $order = Order::find($orderId);

        if (!$order) {
            echo "Order not found.";
            return;
        }

        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            echo "Unable to get PayPal access token.";
            return;
        }

        $amount = $order->total_price;

        $data = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => "USD",
                    "value" => number_format($amount, 2, '.', '')
                ]
            ]],
            "application_context" => [
                "return_url" => "http://yourdomain.com/paypal/success",
                "cancel_url" => "http://yourdomain.com/paypal/cancel"
            ]
        ];

        $ch = curl_init("https://api-m.sandbox.paypal.com/v2/checkout/orders");
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: Bearer $accessToken"
            ],
            CURLOPT_POSTFIELDS => json_encode($data)
        ]);
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if (!isset($res['links'])) {
            echo "Failed to create PayPal payment.";
            return;
        }

        foreach ($res['links'] as $link) {
            if ($link['rel'] === 'approve') {
                redirect($link['href']);
                return;
            }
        }

        echo "Could not redirect to PayPal.";
    }

    public function success()
    {
        $token = $_GET['token'] ?? null;
        if (!$token) {
            echo "Missing PayPal token.";
            return;
        }

        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            echo "Unable to get PayPal access token.";
            return;
        }

        $ch = curl_init("https://api-m.sandbox.paypal.com/v2/checkout/orders/$token/capture");
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: Bearer $accessToken"
            ]
        ]);
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if (($res['status'] ?? '') !== 'COMPLETED') {
            echo "Payment failed or was not completed.";
            return;
        }

        $orderId = Session::get('paypal_order_id');
        $order = Order::find($orderId);

        if (!$order) {
            echo "Order not found.";
            return;
        }

        $order->status = 'paid';
        $order->save();

        $cart = Cart::query()->where('user_id', $order->user_id)->first();
        if ($cart) {
            CartItem::query()->where('cart_id', $cart->id)->delete();
            $cart->delete();
        }

        Session::remove('paypal_order_id');

        return View::render()->view('client.checkout.confirmation', [
            'user' => $order->user,
            'items' => $order->items,
            'total' => $order->total_price,
            'payment_method' => 'paypal',
            'ref_code' => $order->ref_code,
            'recipient_name' => $order->recipient_name,
            'recipient_phone' => $order->recipient_phone,
            'delivery_address' => $order->delivery_address,
            'delivery_date' => $order->delivery_date,
        ]);
    }

    public function cancel()
    {
        return View::render()->view('client.checkout.payment_cancel', [
            'message' => 'You cancelled the PayPal payment.'
        ]);
    }
}
