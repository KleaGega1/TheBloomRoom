<?php

namespace App\Controllers;

use App\Core\{Request, View, Session, CSRFToken};
use App\Models\{Cart, CartItem, Order, OrderItem, User};

class CheckoutController extends Controller
{
    public function index(): View
    {
        $user = get_logged_in_user();
        if (!$user) {
            return redirect('/login');
        }

        $cart = Cart::query()->where('user_id', $user->id)->first();
        if (!$cart) {
            Session::add('error', 'Your cart is empty');
            return redirect('/cart');
        }

        $items = CartItem::query()
            ->where('cart_id', $cart->id)
            ->with(['product', 'gift'])
            ->get();

        if ($items->isEmpty()) {
            Session::add('error', 'Your cart is empty');
            return redirect('/cart');
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
        // Debug: Log start of process method
        error_log('Starting process method in CheckoutController...');

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

        // Validate stock availability
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

        // Save order
        $order = \App\Models\Order::create([
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

        // Save order items
        foreach ($items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id ?? null,
                'gift_id' => $item->gift_id ?? null,
                'quantity' => $item->quantity,
                'unit_price' => $item->price,
                'total_price' => $item->price * $item->quantity,
            ]);
        }

        // Clear cart
        CartItem::query()->where('cart_id', $cart->id)->delete();
        $cart->delete();

        // Prepare data for confirmation view
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

        // Debug: Log order data and email address
        error_log('Order data: ' . json_encode($orderData));
        error_log('Sending email to: ' . $user->email);

        // Debug: Log start of email sending
        error_log('Starting to send order confirmation email...');

        // Send order confirmation email
        // (Removed)

        // Debug: Log end of email sending
        // (Removed)

        // Debug: Log start of confirmation view rendering
        error_log('Starting to render confirmation view...');

        // Return the confirmation view (alert is in the Blade file)
        return View::render()->view('client.checkout.confirmation', $orderData);

        // Debug: Log end of confirmation view rendering
        error_log('Confirmation view rendered successfully.');

        // Debug: Log end of process method
        error_log('Process method completed successfully.');

        return;
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