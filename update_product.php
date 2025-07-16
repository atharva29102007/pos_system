<?php
include("db.php");
session_start();
if (!isset($_SESSION['user'])) header("Location: login.php");

$msg = "";

/* ---------- 1. Delete Product ---------- */
if (isset($_GET['delete'])) {
    $deleteId = (int)$_GET['delete'];
    $conn->query("DELETE FROM products WHERE id=$deleteId");
    $msg = "🗑️ Product deleted!";
}

/* ---------- 2. Update Product ---------- */
if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $n  = $_POST['name'];
    $p  = $_POST['price'];
    $q  = $_POST['quantity'];
    $u  = $_POST['unit'];

    if ($n && $p && $q && $u) {
        $conn->query("UPDATE products 
                      SET name='$n', price='$p', quantity='$q', unit='$u'
                      WHERE id=$id");
        $msg = "✅ Product updated!";
    } else {
        $msg = "❌ Please fill all fields.";
    }
}

/* ---------- 3. Fetch product for edit form ---------- */
$editRow = null;
if (isset($_GET['edit'])) {
    $editId  = (int)$_GET['edit'];
    $editRow = $conn->query("SELECT * FROM products WHERE id=$editId")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Update Product</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-image: url('back4.jpg'); 
      background-size: cover;
      background-position: center;
      min-height: 100vh;
      color: #333;
    }

    .container {
      background: rgba(245, 210, 245, 0.95);
      margin: 30px auto;
      padding: 30px;
      max-width: 950px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }

    h2 {
      text-align: center;
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 12px;
      border: 1px solid #ccc;
      text-align: center;
    }

    th {
      background: #2196F3;
      color: #fff;
    }

    a.edit, a.delete {
      text-decoration: none;
      font-weight: bold;
      margin: 0 5px;
    }

    a.edit {
      color: #2196F3;
    }

    a.delete {
      color: red;
    }

    .box {
      background: #f9f9f9;
      padding: 25px;
      border-radius: 10px;
      margin: 30px auto;
      width: 320px;
      box-shadow: 0 0 10px #bbb;
    }

    input, select {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    button {
      margin-top: 15px;
      padding: 10px 22px;
      background: #4CAF50;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 15px;
    }

    button:hover {
      background: #45a049;
    }

    .msg {
      margin-top: 15px;
      text-align: center;
      font-weight: bold;
      color: green;
    }

    .back {
      display: block;
      text-align: center;
      margin-top: 25px;
      text-decoration: none;
      color: #333;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>📋 Update Product Information</h2>

  <?php if ($msg) echo "<div class='msg'>$msg</div>"; ?>

  <!-- 4. Edit Form -->
  <?php if ($editRow): ?>
    <div class="box">
      <h3>Edit “<?= htmlspecialchars($editRow['name']) ?>”</h3>
      <form method="post">
        <input type="hidden" name="id" value="<?= $editRow['id'] ?>">
        <input type="text" name="name" value="<?= $editRow['name'] ?>" placeholder="Product Name" required>
        <input type="number" name="price" value="<?= $editRow['price'] ?>" step="0.01" placeholder="Price" required>
        <input type="number" name="quantity" value="<?= $editRow['quantity'] ?>" placeholder="Quantity" required>
        <select name="unit" required>
          <option value="">-- Select Unit --</option>
          <?php
          $unitRes = $conn->query("SELECT * FROM units ORDER BY unit_name");
          while ($u = $unitRes->fetch_assoc()) {
              $selected = ($editRow['unit'] == $u['unit_name']) ? 'selected' : '';
              echo "<option value='{$u['unit_name']}' $selected>{$u['unit_name']}</option>";
          }
          ?>
        </select>
        <button name="update">Save Changes</button>
      </form>
    </div>
  <?php endif; ?>

  <!-- 5. Product List -->
  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Price (₹)</th>
      <th>Qty</th>
      <th>Unit</th>
      <th>Actions</th>
    </tr>
    <?php
    $rows = $conn->query("SELECT * FROM products ORDER BY id DESC");
    while ($row = $rows->fetch_assoc()) {
      echo "<tr>
              <td>{$row['id']}</td>
              <td>" . htmlspecialchars($row['name']) . "</td>
              <td>{$row['price']}</td>
              <td>{$row['quantity']}</td>
              <td>{$row['unit']}</td>
              <td>
                <a class='edit' href='update_product.php?edit={$row['id']}'>✏️ Edit</a>
                <a class='delete' href='update_product.php?delete={$row['id']}' onclick=\"return confirm('Are you sure you want to delete this product?')\">❌ Delete</a>
              </td>
            </tr>";
    }
    ?>
  </table>

  <a class="back" href="dashboard.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>
