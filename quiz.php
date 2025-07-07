<?php
include 'db.php';





if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Validate deck_id from URL
if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid deck ID.");
}
$deck_id = intval($_GET['id']);

// Fetch questions from flashcards table
$stmt = $conn->prepare("SELECT question, answer FROM flashcards WHERE deck_id = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $deck_id);
$stmt->execute();
$result = $stmt->get_result();

$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
}

if (count($questions) === 0) {
    die("No flashcards found in this deck.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Flashcard Quiz</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            padding: 20px; 
            max-width: 600px; 
            margin: auto; 
            background-color:rgb(86, 135, 178); /* added background color */
        }
        .question-box { border: 1px solid #ccc; padding: 20px; border-radius: 10px; margin-bottom: 10px; }
        input[type="text"] { padding: 8px; width: 100%; box-sizing: border-box; margin-top: 10px; }
        button { padding: 10px 20px; margin-top: 10px; cursor: pointer; }
        .result { margin-top: 10px; font-weight: bold; }
    </style>
</head>

<body>

<h2>Quiz: Your Flashcards</h2>

<div class="question-box" id="quiz-box"></div>
<div class="result" id="result"></div>

<script>
const questions = <?php echo json_encode($questions); ?>;
let current = 0;

function showQuestion() {
    const q = questions[current];
    document.getElementById('quiz-box').innerHTML = `
        <p><strong>Question ${current + 1}:</strong> ${q.question}</p>
        <input type="text" id="userAnswer" placeholder="Type your answer here" autofocus>
        <button onclick="checkAnswer()">Submit</button>
    `;
    document.getElementById('result').innerHTML = "";
}

function checkAnswer() {
    const userAnswer = document.getElementById('userAnswer').value.trim().toLowerCase();
    const correctAnswer = questions[current].answer.trim().toLowerCase();

    if (userAnswer === "") {
        alert("Please enter your answer!");
        return;
    }

    if (userAnswer === correctAnswer) {
        document.getElementById('result').innerHTML = "✅ Correct!";
    } else {
        document.getElementById('result').innerHTML = `❌ Wrong. Correct answer: <strong>${questions[current].answer}</strong>`;
    }

    // Disable input and button
    document.getElementById('userAnswer').disabled = true;
    document.querySelector('button').disabled = true;

    // Move to next question after 2 seconds
    setTimeout(() => {
        current++;
        if (current < questions.length) {
            showQuestion();
        } else {
            document.getElementById('quiz-box').innerHTML = "<h3>🎉 Quiz Completed!</h3>";
            document.getElementById('result').innerHTML = "";
        }
    }, 2000);
}

// Start quiz
showQuestion();
</script>

</body>
</html>
