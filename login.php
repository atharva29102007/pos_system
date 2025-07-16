<?php
session_start();

// Set your own credentials here
$my_username = "atharva";
$my_password = "12345";

if (isset($_POST['login'])) {
    $u = $_POST['username'];
    $p = $_POST['password'];

    if ($u === $my_username && $p === $my_password) {
        $_SESSION['user'] = $u;
        header("Location: dashboard.php");
    } else {
        $error = "Invalid login!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      margin-top: 150px;
      background-image: url('back4.jpg'); /* Replace with your image path */
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
    }
    .login-box {
      background: rgba(212, 187, 187, 0.9);
      display: inline-block;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px #555;
    }
    input {
      padding: 10px;
      margin: 10px;
      width: 200px;
    }
    button {
      padding: 10px 20px;
      background: blue;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .error {
      color: red;
      margin-bottom: 10px;
    }
    .logo {
      width: 80px;
      height: auto;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

<div class="login-box">
  <!-- Logo Image -->
  <img src="login1.jpg" alt="POS Logo" class="logo">
  
  <h2>Login</h2>
  <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
  <form method="post">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button name="login">Login</button>
  </form>
</div>

</body>
</html>
