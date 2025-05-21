<?php

namespace App\Controllers;

use App\Core\{Request, View, Session, CSRFToken};
use App\Models\{Cart, CartItem, Order, OrderItem, User};

class CheckoutController extends Controller
{
 public function index()
{
    $user = get_logged_in_user();
    if (!$user) {
        redirect('/login');
        return;
    }

    $cart = Cart::query()->where('user_id', $user->id)->first();
    if (!$cart) {
        Session::add('error', 'Your cart is empty');
        redirect('/cart');
        return;
    }

    $items = CartItem::query()
        ->where('cart_id', $cart->id)
        ->with(['product', 'gift'])
        ->get();

    if ($items->isEmpty()) {
        Session::add('error', 'Your cart is empty');
        redirect('/cart');
        return;
    }

    $total = $this->calculateCartTotal($items);

    return View::render()->view('client.checkout.index', [
        'user' => $user,
        'items' => $items,
        'total' => $total
    ]);
}

    public function process()
    {
        $user = get_logged_in_user();
        if (!$user) {
            redirect('/login');
            return;
        }

        $cart = Cart::query()->where('user_id', $user->id)->first();
        if (!$cart) {
            Session::add('error', 'Your cart is empty');
            redirect('/cart');
            return;
        }

        $items = CartItem::query()
            ->where('cart_id', $cart->id)
            ->with(['product', 'gift'])
            ->get();

        if ($items->isEmpty()) {
            Session::add('error', 'Your cart is empty');
            redirect('/cart');
            return;
        }

        foreach ($items as $item) {
            $product = $item->product_id ? $item->product : $item->gift;
            if ($product->quantity < $item->quantity) {
                Session::add('error', "Not enough stock for {$product->name}. Only {$product->quantity} available.");
                redirect('/cart');
                return;
            }
        }

        $paymentMethod = $_POST['payment_method'] ?? 'cod';
        $refCode = $this->generateRefCode();
        $total = $this->calculateCartTotal($items);

        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $total,
            'status' => 'unpaid',
            'ref_code' => $refCode,
            'recipient_name' => $user->name . ' ' . $user->surname,
            'recipient_phone' => $user->telephone,
            'delivery_address' => $user->address,
            'delivery_date' => date('Y-m-d', strtotime('+2 days')),
            'payment_method' => $paymentMethod,
        ]);

        foreach ($items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id ?? null,
                'gift_id' => $item->gift_id ?? null,
                'quantity' => $item->quantity,
                'unit_price' => $item->price,
                'total_price' => $item->price * $item->quantity,
            ]);
        }

       if ($paymentMethod !== 'paypal') {
            CartItem::query()->where('cart_id', $cart->id)->delete();
            $cart->delete();
        }

        $orderData = [
            'user' => $user,
            'items' => $items,
            'total' => $total,
            'payment_method' => $paymentMethod,
            'ref_code' => $refCode,
            'recipient_name' => $user->name . ' ' . $user->surname,
            'recipient_phone' => $user->telephone,
            'delivery_address' => $user->address,
            'delivery_date' => date('Y-m-d', strtotime('+2 days')),
        ];

        if ($paymentMethod === 'paypal') {
            Session::add('paypal_order_id', $order->id);
            redirect('/paypal/create-payment');
            return;
        }

        return View::render()->view('client.checkout.confirmation', $orderData);
    }

    private function calculateCartTotal($items): float
    {
        $total = 0;
        foreach ($items as $item) {
            $total += $item->price * $item->quantity;
        }
        return $total;
    }

    private function generateRefCode(): string
    {
        return 'ORD-' . strtoupper(substr(uniqid(), -6));
    }
}
