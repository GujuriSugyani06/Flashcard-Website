<?php
include 'db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid card ID.");
}

$card_id = intval($_GET['id']);

// Fetch existing card
$stmt = $conn->prepare("SELECT question, answer, deck_id FROM flashcards WHERE id = ?");
$stmt->bind_param("i", $card_id);
$stmt->execute();
$result = $stmt->get_result();
$card = $result->fetch_assoc();

if (!$card) {
    die("Card not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $q = $_POST['question'];
    $a = $_POST['answer'];

    $update = $conn->prepare("UPDATE flashcards SET question = ?, answer = ? WHERE id = ?");
    $update->bind_param("ssi", $q, $a, $card_id);
    $update->execute();

    header("Location: view_deck.php?id=" . $card['deck_id']);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Flashcard</title>
  <style>
    body {
      background: linear-gradient(to right, #e0c3fc, #8ec5fc);
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }

    form {
      background-color: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
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
      background-color: #7b2cbf;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #5a189a;
    }
  </style>
</head>
<body>

<form method="post">
  <h2>Edit Flashcard</h2>
  <input name="question" value="<?= htmlspecialchars($card['question']) ?>" required><br>
  <input name="answer" value="<?= htmlspecialchars($card['answer']) ?>" required><br>
  <button type="submit">Update</button>
</form>

</body>
</html>
