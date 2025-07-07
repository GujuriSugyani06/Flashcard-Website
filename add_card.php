<?php include 'db.php';
$deck_id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $q = $_POST['question'];
    $a = $_POST['answer'];
    $conn->query("INSERT INTO flashcards (deck_id, question, answer) VALUES ($deck_id, '$q', '$a')");
    header("Location: view_deck.php?id=$deck_id");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Card</title>
  <style>
    body {
      background: linear-gradient(to right, #fceabb, #f8b500);
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    form {
      background: white;
      padding: 30px 40px;
      border-radius: 10px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.2);
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
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 16px;
    }

    button {
      background-color: #e67e22;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: #d35400;
    }
  </style>
</head>
<body>

<form method="post">
  <h2>Add Card</h2>
  <input name="question" placeholder="Question" required><br>
  <input name="answer" placeholder="Answer" required><br>
  <button type="submit">Add</button>
</form>

</body>
</html>
