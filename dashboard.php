<?php
session_start(); 
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include("db.php"); 

$productCount = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'];

$result = $conn->query("SELECT DISTINCT unit FROM products");
$unitList = "";

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $unitList .= "🔹 " . htmlspecialchars($row['unit']) . "<br>";
    }
} else {
    $unitList = "Error fetching units: " . $conn->error;
}
?>

<!DOCTYPE html>
<html>
<head>
  <head>
  <title>POS Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
    }
  </style>
</head>
<body>
  <h1>Welcome to POS Dashboard</h1>
  <p><strong>Total Products:</strong> <?= $productCount ?></p>
  <p><strong>Units:</strong><br><?= $unitList ?></p>
</body>
</html>

      margin: 0;
      padding: 0;
      background-image: url('back3.jpg'); /* Replace with your image path */
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    h2 {
      margin-top: 30px;
      color: black;
      text-shadow: 1px 1px 2px #000;
    }

    .container {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px;
      margin-top: 40px;
    }

    .card {
      width: 250px;
      background: rgba(231, 213, 226, 0.9);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px #444;
      transition: 0.3s;
    }

    .card:hover {
      transform: scale(1.05);
    }

    .card h3 {
      margin-bottom: 10px;
    }

    .card a {
      display: block;
      margin-top: 15px;
      font-weight: bold;
      text-decoration: none;
      color: blue;
    }

    .logout {
      margin-top: 40px;
    }

    .logout a {
      color: black;
      text-decoration: underline;
      font-size: 16px;
    }

    .unit-list {
      margin-top: 10px;
      font-weight: bold;
      color: #222;
    }
  </style>
</head>
<body>

<h2>Welcome, <?php echo $_SESSION['user']; ?></h2>

<div class="container">

  <div class="card">
    <h3>🛒 Add Products</h3>
    <p>With name, price, quantity, unit & category</p>
    <a href="add_product.php">Go to Add Product</a>
  </div>

  <div class="card">
    <h3>📦 Product Units</h3>
    <p>Total Products: <?= $productCount ?></p>
    <a href="product_unit.php">Manage Units </a>
  </div>

  <div class="card">
    <h3>💳 Make Sale</h3>
    <p>Select products → Cart → Payment → Invoice</p>
    <a href="make_sale.php">Go to Make Sale</a>
  </div>

  <div class="card">
    <h3>📦 Update Inventory</h3>
    <p>Auto update after every sale</p>
    <a href="update_product.php">Update Products</a>
  </div>

  <div class="card">
    <h3>📊 Generate Report</h3>
    <p>View analytics and performance</p>
    <a href="report.php">View Report</a>
  </div>

</div>

<div class="logout">
  <a href="logout.php">Logout</a>
</div>

</body>
</html>
