<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid deck ID.");
}

$deck_id = intval($_GET['id']);

// Check if deck belongs to user
$stmt = $conn->prepare("SELECT id FROM decks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $deck_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Deck not found or you don't have permission to delete it.");
}

// Delete all flashcards in this deck first
$conn->query("DELETE FROM flashcards WHERE deck_id = $deck_id");

// Delete the deck itself
$stmt = $conn->prepare("DELETE FROM decks WHERE id = ?");
$stmt->bind_param("i", $deck_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header("Location: dashboard.php");
    exit;
} else {
    die("Failed to delete deck.");
}
