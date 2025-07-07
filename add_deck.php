<?php include 'db.php';
if (!isset($_SESSION['user_id'])) header("Location: login.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $conn->query("INSERT INTO decks (user_id, name) VALUES ($_SESSION[user_id], '$name')");
    header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Create Deck</title>
  <style>
    body {
      background: linear-gradient(to right, #a1c4fd, #c2e9fb);
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      height: 100vh;
      align-items: center;
      justify-content: center;
    }

    form {
      background: #fff;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
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
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    button {
      background-color: #3498db;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: #2980b9;
    }
  </style>
</head>
<body>

<form method="post">
  <h2>Create Deck</h2>
  <input name="name" required>
  <button type="submit">Create</button>
</form>

</body>
</html>
