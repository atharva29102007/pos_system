<?php
include("db.php");
session_start();
if (!isset($_SESSION['user'])) header("Location: login.php");

$result = $conn->query("SELECT products.name, SUM(sales.quantity) as sold, SUM(sales.total) as revenue 
                        FROM sales 
                        JOIN products ON sales.product_id = products.id 
                        GROUP BY product_id");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Sales Report</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background-image: url('back4.jpg'); /* Replace with your image path */
      background-size: cover;
      background-position: center;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #333;
    }

    .report-box {
      background: rgba(247, 214, 241, 0.95);
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
      text-align: center;
    }

    h2 {
      margin-bottom: 20px;
      color: #222;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 12px 15px;
      border: 1px solid #ccc;
      text-align: center;
    }

    th {
      background-color: #2196F3;
      color: white;
    }

    tr:hover {
      background-color: #f2f2f2;
    }

    .back {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      color: #333;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="report-box">
  <h2>📊 Sales Report</h2>
  <table>
    <tr>
      <th>Product</th>
      <th>Sold</th>
      <th>Revenue</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= $row['sold'] ?></td>
        <td>₹<?= number_format($row['revenue'], 2) ?></td>
      </tr>
    <?php endwhile; ?>
  </table>

  <a class="back" href="dashboard.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>
