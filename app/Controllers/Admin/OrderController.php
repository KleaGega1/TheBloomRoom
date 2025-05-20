<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\View;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::query()->orderBy('created_at', 'desc')->with(['items.product', 'items.gift', 'user'])->get();
        return View::render()->view('admin.orders.index', compact('orders'));
    }

    public function updateStatus($orderId)
    {
        $order = Order::query()->where('id', $orderId)->first();
        if (!$order) {
            \App\Core\Session::add('invalids', ['Order not found.']);
            return redirect('/admin/orders');
        }

        $status = $_POST['status'] ?? '';
        if (!in_array($status, ['unpaid', 'paid', 'processing', 'shipped', 'delivered', 'cancelled'])) {
            \App\Core\Session::add('invalids', ['Invalid status.']);
            return redirect('/admin/orders');
        }

        $order->status = $status;
        $order->save();
        return redirect('/admin/orders');
    }

    public function confirm($orderId)
    {
        $order = \App\Models\Order::query()->where('id', $orderId)->first();
        if (!$order) {
            \App\Core\Session::add('invalids', ['Order not found.']);
            return redirect('/admin/orders');
        }
        $order->status = 'confirmed';
        $order->save();
        \App\Core\Session::add('message', 'Order confirmed successfully.');
        return redirect('/admin/orders');
    }

    public function reject($orderId)
    {
        $order = \App\Models\Order::query()->where('id', $orderId)->first();
        if (!$order) {
            \App\Core\Session::add('invalids', ['Order not found.']);
            return redirect('/admin/orders');
        }
        $reason = $_POST['reason'] ?? '';
        if (empty($reason)) {
            \App\Core\Session::add('invalids', ['Rejection reason is required.']);
            return redirect('/admin/orders');
        }
        $order->status = 'rejected';
        $order->rejection_reason = $reason;
        $order->save();
        \App\Core\Session::add('message', 'Order rejected.');
        return redirect('/admin/orders');
    }
} 