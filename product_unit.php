<?php
include("db.php");
session_start();
if (!isset($_SESSION['user'])) header("Location: login.php");

$msg = "";

// Add unit
if (isset($_POST['add'])) {
    $unit = trim($_POST['unit']);
    if ($unit) {
        $exists = $conn->query("SELECT * FROM units WHERE unit_name='$unit'");
        if ($exists->num_rows == 0) {
            $conn->query("INSERT INTO units (unit_name) VALUES ('$unit')");
            $msg = "✅ Unit added!";
        } else {
            $msg = "⚠️ Unit already exists!";
        }
    }
}

// Delete unit
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM units WHERE id=$id");
    $msg = "🗑️ Unit deleted!";
}

// Get units
$units = $conn->query("SELECT * FROM units ORDER BY unit_name");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Units</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-image: url('back4.jpg'); /* 🌄 Replace with your image path */
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      color: #333;
    }

    .box {
      background: rgba(247, 216, 244, 0.92);
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      width: 450px;
      max-height: 90vh;
      overflow-y: auto;
      text-align: center;
    }

    h2 {
      margin-bottom: 20px;
    }

    .msg {
      color: green;
      margin-bottom: 15px;
      font-weight: bold;
    }

    input {
      padding: 10px;
      width: 70%;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    button {
      padding: 10px 18px;
      background: #28a745;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      margin-left: 10px;
    }

    button:hover {
      background: #218838;
    }

    table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
    }

    th, td {
      padding: 10px;
      border: 1px solid #ccc;
    }

    th {
      background-color: #007BFF;
      color: white;
    }

    td a {
      text-decoration: none;
      color: red;
    }

    td a:hover {
      text-decoration: underline;
    }

    .back {
      display: inline-block;
      margin-top: 20px;
      color: #333;
      text-decoration: none;
      font-weight: bold;
    }

    .back:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="box">
  <h2>📦 Manage Product Units</h2>

  <?php if ($msg): ?>
    <div class="msg"><?= $msg ?></div>
  <?php endif; ?>

  <form method="post">
    <input type="text" name="unit" placeholder="e.g., kg, pcs, liter" required>
    <button name="add">Add Unit</button>
  </form>

  <table>
    <tr><th>ID</th><th>Unit</th><th>Action</th></tr>
    <?php while ($row = $units->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['unit_name']) ?></td>
        <td><a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this unit?')">❌ Delete</a></td>
      </tr>
    <?php endwhile; ?>
  </table>

  <a class="back" href="dashboard.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>
