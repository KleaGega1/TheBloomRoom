<?php 

namespace App\Controllers;
use App\Core\{Request, View, Session, CSRFToken};
use App\Models\{Cart, CartItem, Order, OrderItem, User};

use FPDF;

class InvoiceController extends Controller
{
    public function download($id)
    {
       $order = Order::find($id);
        
        if (!$order) {
            Session::add('error', 'Invoice not found');
            return redirect('/account/orders');
        }
        
        $user = User::find(Session::get('user_id'));
        if ($order->user_id !== $user->id) {
            Session::add('error', 'You don\'t have permission to access this invoice');
            return redirect('/account/orders');
        }
        
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(190, 10, 'INVOICE', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(190, 10, 'Invoice #' . $order->id, 0, 1, 'R');
        $pdf->Cell(190, 10, 'Date: ' . date('Y-m-d', strtotime($order->created_at)), 0, 1, 'R');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(190, 10, 'Customer Information:', 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(190, 8, 'Name: ' . $user->name, 0, 1);
        $pdf->Cell(190, 8, 'Email: ' . $user->email, 0, 1);
        $pdf->Cell(190, 8, 'Address: ' . $user->address, 0, 1);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(190, 10, 'Order Details:', 0, 1);
        $pdf->SetFillColor(200, 220, 255);
        $pdf->Cell(90, 8, 'Product', 1, 0, 'L', true);
        $pdf->Cell(30, 8, 'Quantity', 1, 0, 'C', true);
        $pdf->Cell(30, 8, 'Unit Price', 1, 0, 'R', true);
        $pdf->Cell(40, 8, 'Subtotal', 1, 1, 'R', true);
        $pdf->SetFont('Arial', '', 12);
        $total = 0;
        foreach ($orderItems as $item) {
            $pdf->Cell(90, 8, $item->product_name, 1);
            $pdf->Cell(30, 8, $item->quantity, 1, 0, 'C');
            $pdf->Cell(30, 8, '$' . number_format($item->unit_price, 2), 1, 0, 'R');
            $subtotal = $item->quantity * $item->unit_price;
            $pdf->Cell(40, 8, '$' . number_format($subtotal, 2), 1, 1, 'R');
            $total += $subtotal;
        }
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(150, 8, 'Subtotal:', 1, 0, 'R');
        $pdf->Cell(40, 8, '$' . number_format($total, 2), 1, 1, 'R');
        $tax = $order->tax ?? ($total * 0.07); 
        $pdf->Cell(150, 8, 'Tax:', 1, 0, 'R');
        $pdf->Cell(40, 8, '$' . number_format($tax, 2), 1, 1, 'R');
        $shipping = $order->shipping_cost ?? 0;
        $pdf->Cell(150, 8, 'Shipping:', 1, 0, 'R');
        $pdf->Cell(40, 8, '$' . number_format($shipping, 2), 1, 1, 'R');
        $grandTotal = $total + $tax + $shipping;
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(150, 10, 'TOTAL:', 1, 0, 'R', true);
        $pdf->Cell(40, 10, '$' . number_format($grandTotal, 2), 1, 1, 'R', true);
        $pdf->SetY(-40);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(0, 10, 'Thank you for your business!', 0, 1, 'C');
        $pdf->Cell(0, 10, 'If you have any questions about this invoice, please contact customer support.', 0, 1, 'C');
        $filename = 'Invoice_' . $order->id . '_' . date('Y-m-d') . '.pdf';
        $pdf->Output('D', $filename);
        exit;
    }
}