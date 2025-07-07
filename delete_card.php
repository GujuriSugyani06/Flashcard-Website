<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid card ID.");
}

$card_id = intval($_GET['id']);

// Verify card belongs to a deck owned by user
$stmt = $conn->prepare("
    SELECT flashcards.id FROM flashcards
    JOIN decks ON flashcards.deck_id = decks.id
    WHERE flashcards.id = ? AND decks.user_id = ?
");
$stmt->bind_param("ii", $card_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Card not found or you don't have permission to delete it.");
}

// Delete the card
$stmt = $conn->prepare("DELETE FROM flashcards WHERE id = ?");
$stmt->bind_param("i", $card_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Redirect back to the deck view if deck ID passed, else dashboard
    $deck_id = isset($_GET['deck']) && is_numeric($_GET['deck']) ? intval($_GET['deck']) : null;
    if ($deck_id) {
        header("Location: view_deck.php?id=$deck_id");
    } else {
        header("Location: dashboard.php");
    }
    exit;
} else {
    die("Failed to delete card.");
}
