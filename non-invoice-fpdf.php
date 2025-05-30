<?php
include_once 'includes/config.php';
$order_id = $_GET['order_id'] ?? null;

if (!$order_id) {
    die("Invalid order ID.");
}

// Connect to DB and verify order status
// Assuming $conn is your DB connection
$query = "SELECT * FROM orders WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order || strtolower($order['orderStatus']) !== 'delivered') {
    die("Invoice not available for this order.");
}

// Generate or retrieve PDF invoice
$invoicePath = "invoices/invoice_" . $order_id . ".pdf";

if (file_exists($invoicePath)) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . basename($invoicePath) . '"');
    readfile($invoicePath);
    exit;
} else {
    die("Invoice file not found.");
}
?>
