<?php
include("db.php");
session_start();
if (!isset($_SESSION['user'])) header("Location: login.php");

$totalInvoice = "";
if (isset($_POST['sell'])) {
    $items = $_POST['item'];
    $total = 0;
    foreach ($items as $id => $qty) {
        if ($qty > 0) {
            $res = $conn->query("SELECT * FROM products WHERE id=$id");
            $row = $res->fetch_assoc();
            $price = $row['price'];
            $subtotal = $price * $qty;
            $conn->query("INSERT INTO sales (product_id, quantity, total) VALUES ($id, $qty, $subtotal)");
            $conn->query("UPDATE products SET quantity = quantity - $qty WHERE id=$id");
            $total += $subtotal;
        }
    }
    $totalInvoice = "<div class='invoice'>🧾 <strong>Total Invoice Amount: ₹$total</strong></div>";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Make Sale</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background-image: url('back4.jpg');
      background-size: cover;
      background-position: center;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      color: #333;
    }

    .box {
      background: rgba(246, 215, 247, 0.9);
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
      width: 450px;
      text-align: center;
      max-height: 85vh;
      overflow-y: auto;
    }

    h3 {
      margin-bottom: 15px;
    }

    input[type="number"], input[type="text"] {
      padding: 8px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    input[type="text"] {
      width: 90%;
      margin-bottom: 15px;
    }

    button {
      margin-top: 15px;
      padding: 10px 25px;
      background-color: #2196F3;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: #1976D2;
    }

    .invoice {
      margin-top: 20px;
      font-size: 18px;
      color: green;
      font-weight: bold;
      background: #fff;
      padding: 10px;
      border-radius: 8px;
      box-shadow: 0 0 10px #ccc;
    }

    .back {
      margin-top: 20px;
      display: inline-block;
      text-decoration: none;
      color: #333;
    }

    .product-line {
      margin-bottom: 10px;
    }

    .hidden {
      display: none;
    }
  </style>
</head>
<body>

<div class="box">
  <h3>🛍️ Make a Sale</h3>

  <!-- 🔍 Search Bar -->
  <input type="text" id="search" placeholder="🔎 Search product name...">

  <form method="post">
    <div id="productList">
      <?php
      $result = $conn->query("SELECT * FROM products");
      while ($row = $result->fetch_assoc()) {
          echo "<div class='product-line'>";
          echo "<strong class='product-name'>" . $row['name'] . "</strong> ₹" . $row['price'] .
               " (Stock: " . $row['quantity'] . " " . $row['unit'] . ") ";
          echo "<input type='number' name='item[" . $row['id'] . "]' min='0' max='" . $row['quantity'] . "'>";
          echo "</div>";
      }
      ?>
    </div>

    <button name="sell">🧾 Generate Invoice</button>
  </form>

  <?= $totalInvoice ?>

  <a class="back" href="dashboard.php">⬅ Back to Dashboard</a>
</div>

<!-- 🔧 JavaScript for live search -->
<script>
  const searchInput = document.getElementById("search");
  const productLines = document.querySelectorAll(".product-line");

  searchInput.addEventListener("keyup", () => {
    const searchText = searchInput.value.toLowerCase();
    productLines.forEach(line => {
      const productName = line.querySelector(".product-name").textContent.toLowerCase();
      line.style.display = productName.includes(searchText) ? "block" : "none";
    });
  });
</script>

</body>
</html>
