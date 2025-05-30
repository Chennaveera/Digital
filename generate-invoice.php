<?php
/*
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
*/


/*include_once 'includes/config.php';
require('includes/fpdf.php'); // ✅ Include FPDF library (place it in the project folder)

$order_id = $_GET['order_id'] ?? null;

if (!$order_id) {
    die("Invalid order ID.");
}

// Fetch order and product details
$query = "SELECT orders.*, products.productName FROM orders
          JOIN products ON orders.productId = products.id 
          WHERE orders.id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order || strtolower($order['orderStatus']) !== 'delivered') {
    die("Invoice not available for this order.");
}

//  Generate PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Invoice');
$pdf->Ln(10);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,'Order ID: ' . $order['id'], 0, 1);
$pdf->Cell(0,10,'Product: ' . $order['productName'], 0, 1);
$pdf->Cell(0,10,'Quantity: ' . $order['quantity'], 0, 1);
$pdf->Cell(0,10,'Payment Method: ' . $order['paymentMethod'], 0, 1);
$pdf->Cell(0,10,'Order Date: ' . $order['orderDate'], 0, 1);
$pdf->Cell(0,10,'Status: ' . $order['orderStatus'], 0, 1);

// Output PDF to browser
$pdf->Output('I', 'invoice_' . $order_id . '.pdf');
?>
*/

ob_start();
include_once 'includes/config.php';
require('includes/fpdf.php');

//$order_id = $_GET['oid'] ?? null;
if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    die("Invalid order ID.");
}
$order_id = (int)$_GET['order_id'];
// Fetch order info
$query = "SELECT orders.*, products.productName FROM orders
          JOIN products ON orders.productId = products.id 
          WHERE orders.id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order || strtolower($order['orderStatus']) !== 'delivered') {
    die("Invoice not available for this order.");
}

// Fetch product info
$productId = $order['productId'];
$productQuery = "SELECT productName, productPrice, productImage1 FROM products WHERE id = ?";
$productStmt = $con->prepare($productQuery);
$productStmt->bind_param("i", $productId);
$productStmt->execute();
$productResult = $productStmt->get_result();
$product = $productResult->fetch_assoc();

$invoicePath = "invoices/invoice_" . $order_id . ".pdf";

// If invoice already exists
if (file_exists($invoicePath)) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . basename($invoicePath) . '"');
    readfile($invoicePath);
    exit;
}

// Generate new PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Invoice for Order ID: ' . $order_id, 0, 1);
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 12);

// Product Info
$pdf->Cell(0, 10, 'Product Name: ' . $product['productName'], 0, 1);
//$pdf->Cell(0, 10, 'Price: ' . number_format($product['productPrice'], 1), 0, 1);
$pdf->Cell(0, 10, 'Price: Rs. ' . number_format($product['productPrice'], 1), 0, 1);

$pdf->Cell(0, 10, 'Status: ' . $order['orderStatus'], 0, 1);
$pdf->Ln(5);

// Add product image if available
$imagePath = 'admin/productimages/' . $productId . '/' . $product['productImage1'];
if (file_exists($imagePath)) {
    $pdf->Image($imagePath, 10, $pdf->GetY(), 60); // width: 60 mm
    $pdf->Ln(65); // push next content down
} else {
    $pdf->Cell(0, 10, 'Image not available.', 0, 1);
}

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Thank you for your purchase!', 0, 1, 'C');

// Save PDF
$pdf->Output('F', $invoicePath);
ob_end_clean(); // clean any buffered output
$pdf->Output('I', 'invoice_' . $order_id . '.pdf');
exit;
?>
