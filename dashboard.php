<?php include 'db.php';

if (!isset($_SESSION['user_id'])) header("Location: login.php");
$user_id = $_SESSION['user_id'];
$decks = $conn->query("SELECT * FROM decks WHERE user_id = $user_id");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Your Decks</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right,rgb(245, 216, 186), #ffffff); /* Light gradient background */
      padding: 20px;
      margin: 0;
    }

    h2 {
      color: #2c3e50;
    }

    .nav-links {
      margin-bottom: 20px;
    }

    .nav-links a {
      margin-right: 15px;
      text-decoration: none;
      color: white;
      background: #3498db;
      padding: 10px 16px;
      border-radius: 5px;
      transition: background 0.3s ease;
    }

    .nav-links a:hover {
      background: #2980b9;
    }

    .deck-card {
      background: #ffffff;
      border-radius: 10px;
      padding: 15px 20px;
      margin-bottom: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }

    .deck-card b {
      font-size: 20px;
      display: block;
      margin-bottom: 10px;
      color:rgb(102, 131, 160);
    }

    .deck-card a {
      text-decoration: none;
      color:rgb(116, 135, 148);
      margin-right: 12px;
      font-weight: 500;
      font-size: 15px;
    }

    .deck-card a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<h2>Your Decks</h2>

<div class="nav-links">
  <a href="add_deck.php">+ Add Deck</a>
  <a href="logout.php">Logout</a>
</div>

<?php while ($d = $decks->fetch_assoc()): ?>
  <div class="deck-card">
    <b><?= htmlspecialchars($d['name']) ?></b>
    <a href="view_deck.php?id=<?= $d['id'] ?>">View</a>
    <a href="quiz.php?id=<?= $d['id'] ?>">Quiz</a>
    <a href="delete_deck.php?id=<?= $d['id'] ?>" onclick="return confirm('Delete this deck?')">Delete Deck</a>
  </div>
<?php endwhile; ?>

</body>
</html>
