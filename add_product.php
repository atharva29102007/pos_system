<?php
include("db.php");
session_start();
if (!isset($_SESSION['user'])) header("Location: login.php");

$success = "";
if (isset($_POST['add'])) {
    $n = $_POST['name'];
    $p = $_POST['price'];
    $q = $_POST['quantity'];
    $u = $_POST['unit'];

    if ($n && $p && $q  && $u) {
        $conn->query("INSERT INTO products (name, price, quantity, unit) 
                      VALUES ('$n', '$p', '$q',  '$u')");
        $success = "✅ Product added successfully!";
    } else {
        $success = "❌ Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Product</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background-image: url('back4.jpg'); /* 🔁 Replace with your background image */
      background-size: cover;
      background-position: center;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .box {
      background: rgba(245, 212, 243, 0.85);
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
      width: 400px;
      text-align: center;
      backdrop-filter: blur(8px);
    }

    h2 {
      margin-bottom: 25px;
      color: #333;
    }

    input, select {
      width: 100%;
      padding: 12px;
      margin-top: 12px;
      border: 1px solid #aaa;
      border-radius: 8px;
      font-size: 15px;
    }

    button {
      margin-top: 20px;
      padding: 12px 30px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      transition: background 0.3s;
    }

    button:hover {
      background-color: #388e3c;
    }

    .message {
      margin-top: 15px;
      font-weight: bold;
      color: green;
    }

    .back {
      margin-top: 20px;
      display: block;
      color: #333;
      text-decoration: none;
      font-weight: 500;
    }

    .back:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="box">
  <h2>🛒 Add Product</h2>

  <?php if ($success): ?>
    <div class="message"><?= $success ?></div>
  <?php endif; ?>

  <form method="post">
    <input type="text" name="name" placeholder="Product Name" required><br>
    <input type="number" name="price" step="0.01" placeholder="Price (₹)" required><br>
    <input type="number" name="quantity" placeholder="Quantity" required><br>
   

    <select name="unit" required>
      <option value="">-- Select Unit --</option>
      <?php
      $u = $conn->query("SELECT * FROM units ORDER BY unit_name");
      while ($row = $u->fetch_assoc()) {
          echo "<option value='{$row['unit_name']}'>{$row['unit_name']}</option>";
      }
      ?>
    </select><br>

    <button name="add">Add Product</button>
  </form>

  <a class="back" href="dashboard.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>
