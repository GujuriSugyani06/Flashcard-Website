<?php include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php");
    } else {
        echo "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <style>
    body {
      background: linear-gradient(to right, #c9ffbf, #ffafbd);
      font-family: 'Segoe UI', sans-serif;
      height: 100vh;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    form {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.2);
      width: 300px;
      text-align: center;
    }

    h2 {
      margin-bottom: 20px;
      color: #333;
    }

    input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
    }

    button {
      background-color: #00b894;
      color: white;
      border: none;
      padding: 10px;
      width: 100%;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 10px;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #019875;
    }

    .register-link {
      display: block;
      margin-top: 12px;
      text-decoration: none;
      color: #555;
      font-size: 14px;
    }

    .register-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<form method="post">
  <h2>Login</h2>
  <input name="username" placeholder="Username" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Login</button>
  <a class="register-link" href="index.php">Register</a>
</form>

</body>
</html>
