<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
    <h2>Order placed!</h2>
    <p>Your order has been successfully placed. Thank you for shopping with us.</p>
    <h3>Order Summary</h3>
    <ul>
        <?php foreach ($items as $item): ?>
            <li>
                <strong><?= $item->product_id ? $item->product->name : $item->gift->name ?></strong><br>
                Quantity: <?= $item->quantity ?><br>
                Price: $<?= number_format($item->price, 2) ?><br>
                Subtotal: $<?= number_format($item->price * $item->quantity, 2) ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <h3>Delivery Information</h3>
    <p><strong>Recipient Name:</strong> <?= $recipient_name ?></p>
    <p><strong>Phone Number:</strong> <?= $recipient_phone ?></p>
    <p><strong>Delivery Address:</strong> <?= $delivery_address ?></p>
    <p><strong>Delivery Date:</strong> <?= $delivery_date ?></p>
    <h3>Payment Method</h3>
    <p><?= strtoupper($payment_method) ?></p>
    <h3>Order Total</h3>
    <p><strong>Total:</strong> $<?= number_format($total, 2) ?></p>
    <p>Best regards,<br>The Bloom Room Team</p>
</body>
</html> 