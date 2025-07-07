<?php include 'db.php';

$deck_id = intval($_GET['id']);
$cards = $conn->query("SELECT * FROM flashcards WHERE deck_id = $deck_id");
?>
<h2>Deck Flashcards</h2>
<a href="add_card.php?id=<?= $deck_id ?>">+ Add Card</a> | <a href="dashboard.php">Back</a><br><br>
<?php while ($c = $cards->fetch_assoc()): ?>
  <div>
    Q: <?= htmlspecialchars($c['question']) ?><br>
    A: <?= htmlspecialchars($c['answer']) ?><br>
    <a href="edit_card.php?id=<?= $c['id'] ?>&deck=<?= $deck_id ?>">Edit</a>
    <a href="delete_card.php?id=<?= $c['id'] ?>&deck=<?= $deck_id ?>" onclick="return confirm('Delete this card?')">Delete Card</a>
  </div><br>
<?php endwhile; ?>
<a href="delete_deck.php?id=<?= $deck_id ?>" onclick="return confirm('Delete this deck?')">Delete Deck</a>
<style>
  body {
    background: linear-gradient(135deg,rgb(183, 198, 222),rgb(120, 142, 178));
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    padding: 20px;
  }
  h2 {
    color: #333;
  }
  a {
    color: #0077cc;
    text-decoration: none;
    margin-right: 15px;
  }
  a:hover {
    text-decoration: underline;
  }
  div {
    background: white;
    border-radius: 8px;
    padding: 15px 20px;
    margin-bottom: 15px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  }
</style>
