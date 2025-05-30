<?php
/*session_start();
include_once 'includes/config.php';
$oid=intval($_GET['oid']);

$order_query = mysqli_query($con, "
  SELECT 
    orders.id AS order_id, 
    orders.orderStatus, 
    products.productName 
  FROM orders 
  JOIN products ON orders.productId = products.id 
  WHERE orders.id = '$oid'
");

$order_data = mysqli_fetch_assoc($order_query);
//$order_status = $order_data['orderStatus'];
//$order_id = $order_data['order_id'];
$product_name = $order_data['productName'];

 ?>
 include('includes/config.php');
 //$oid=intval($_GET['oid']);

$order_id = $_GET['oid'] ?? null;

if (!$order_id) {
    echo "<p>Invalid order ID.</p>";
    exit;
}

// Fetch order info
$orderQuery = "SELECT * FROM orders WHERE id = ?";
$stmt = $con->prepare($orderQuery);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$orderResult = $stmt->get_result();
$order = $orderResult->fetch_assoc();

if (!$order) {
    echo "<p>Order not found.</p>";
    exit;
}

// Fetch ordered products
$productQuery = "
    SELECT p.productName, p.productImage1, p.productPrice 
    FROM order_items oi 
    JOIN products p ON oi.productId = p.id 
    WHERE oi.orderId = ?
";
// Fetch product info using the productId from the order
$productId = $order['productId'];
$productQuery = "SELECT productName, productPrice, productImage1 FROM products WHERE id = ?";
$productStmt = $con->prepare($productQuery);
$productStmt->bind_param("i", $productId);
$productStmt->execute();
$productResult = $productStmt->get_result();
$product = $productResult->fetch_assoc();
?>
<script language="javascript" type="text/javascript">
function f2()
{
window.close();
}ser
function f3()
{
window.print(); 
}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Order Tracking Details</title>
<style>
        .product {
            border: 1px solid #ddd;
            margin-bottom: 15px;
            padding: 10px;
            display: flex;
            align-items: center;
        }
        .product img {
            width: 120px;
            height: auto;
            margin-right: 15px;
        }
        .product-details {
            font-family: Arial, sans-serif;
        }
        .product-details h4 {
            margin: 0 0 10px 0;
        }
        .product-details {
            line-height: 1.6;
        }
    </style>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="anuj.css" rel="stylesheet" type="text/css">
</head>
<body>

<div style="margin-left:50px;">
 <form name="updateticket" id="updateticket" method="post"> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr height="50">
      <td colspan="2" class="fontkink2" style="padding-left:0px;"><div class="fontpink2"> <b>Order Tracking Details !</b></div></td>
      
    </tr>
    <tr height="30">
      <td  class="fontkink1"><b>order Id:</b></td>
      <td  class="fontkink"><?php echo $oid;?></td>
    </tr>
    <?php 
$ret = mysqli_query($con,"SELECT * FROM ordertrackhistory WHERE orderId='$oid'");
$num=mysqli_num_rows($ret);
if($num>0)
{
while($row=mysqli_fetch_array($ret))
      {
        $imagePath = 'admin/productimages/' . $product['productName']  . '/' . $row['productImage1'];

        $order_status = $row['status']; // Assuming 'status' holds delivery state
        $order_id = $row['orderId'];   // Assuming order_id is available
     ?>

     <div class="product">
        <?php if (file_exists($imagePath)): ?>
            <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($product['productName']) ?>">
        <?php else: ?>
            <img src="placeholder.png" alt="No image">
        <?php endif; ?>

        <div class="product-details">
            <h4><?= htmlspecialchars($product['productName']) ?></h4>
            <p><strong>Price:</strong> ₹<?= number_format($product['productPrice'], 2) ?></p>
        </div>
    </div>
		
      <tr>
  
  <td><?= $product_name; ?></td>
  <td><?= $order_status; ?></td>
  <td>
    <?php if (strtolower($order_status) === 'delivered'): ?>
      <a href="generate-invoice.php?order_id=<?= $order_id ?>" target="_blank" class="btn btn-primary">Download Invoice</a>
    <?php else: ?>
      <span class="text-muted">Invoice available after delivery</span>
    <?php endif; ?>
  </td>
</tr>
    
      <tr height="20">
      <td class="fontkink1" ><b>At Date:</b></td>
      <td  class="fontkink"><?php echo $row['postingDate'];?></td>
    </tr>
     <tr height="20">
      <td  class="fontkink1"><b>Status:</b></td>
      <td  class="fontkink"><?php echo $row['status'];?></td>
    </tr>
     <tr height="20">
      <td  class="fontkink1"><b>Remark:</b></td>
      <td  class="fontkink"><?php echo $row['remark'];?></td>
    </tr>

   
    <tr>
      <td colspan="2"><hr /></td>
    </tr>
   <?php } }
else{
   ?>
   <tr>
   <td colspan="2">Order Not Process Yet</td>
   </tr>
   <?php  }
$st='Delivered';
   $rt = mysqli_query($con,"SELECT * FROM orders WHERE id='$oid'");
     while($num=mysqli_fetch_array($rt))
     {
     $currrentSt=$num['orderStatus'];
   }
     if($st==$currrentSt)
     { ?>
   <tr><td colspan="2"><b>
      Product Delivered successfully </b></td>
   <?php } 
 
  ?>
</table>
 </form>
</div>

</body>
</html>
*/

include('includes/config.php');

$order_id = $_GET['oid'] ?? null;

if (!$order_id) {
    echo "<p>Invalid order ID.</p>";
    exit;
}

// Fetch order info
$orderQuery = "SELECT * FROM orders WHERE id = ?";
$stmt = $con->prepare($orderQuery);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$orderResult = $stmt->get_result();
$order = $orderResult->fetch_assoc();

if (!$order) {
    echo "<p>Order not found.</p>";
    exit;
}

// Fetch product info
$productId = $order['productId'];
$productQuery = "SELECT productName, productPrice, productImage1 FROM products WHERE id = ?";
$productStmt = $con->prepare($productQuery);
$productStmt->bind_param("i", $productId);
$productStmt->execute();
$productResult = $productStmt->get_result();
$product = $productResult->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Track Order</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .product {
            border: 1px solid #ccc;
            padding: 15px;
            margin-top: 20px;
            display: flex;
            align-items: center;
        }
        .product img {
            width: 120px;
            height: auto;
            margin-right: 20px;
            border: 1px solid #ddd;
            padding: 5px;
        }
        .product-details h3 {
            margin: 0 0 10px;
        }
        .download-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<h2>Tracking Order #<?= htmlspecialchars($order_id) ?></h2>

<?php if ($product): ?>
    <div class="product">
        <?php
        $imagePath = 'admin/productimages/' . $productId . '/' . $product['productImage1'];
        if (file_exists($imagePath)): ?>
            <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($product['productName']) ?>">
        <?php else: ?>
            <img src="placeholder.png" alt="No image available">
        <?php endif; ?>

        <div class="product-details">
            <h3><?= htmlspecialchars($product['productName']) ?></h3>
            <p><strong>Price:</strong> ₹<?= number_format($product['productPrice'], 2) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($order['orderStatus']) ?></p>
        </div>
    </div>

    <a href="generate-invoice.php?order_id=<?= $order_id ?>" target="_blank" class="download-btn">Download Invoice PDF</a>
<?php else: ?>
    <p>Product details not found.</p>
<?php endif; ?>

</body>
</html>
