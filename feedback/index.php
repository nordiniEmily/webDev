<?php
include("config.php");

$message = ''; // To hold success or error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $feedback = trim($_POST['feedback'] ?? '');

    if (!empty($email) && !empty($feedback)) {
        $stmt = $mysqli->prepare("INSERT INTO feedback (email, feedback) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("ss", $email, $feedback);
            if ($stmt->execute()) {
                $message = "<p>Thank you for your feedback! We highly value your feedback!</p>";
            } else {
                $message = "<p>Failed to save feedback: " . htmlspecialchars($stmt->error) . "</p>";
            }
            $stmt->close();
        } else {
            $message = "<p>Error preparing statement: " . htmlspecialchars($mysqli->error) . "</p>";
        }
    } else {
        $message = "<p>Please fill in all fields.</p>";
    }
}

$result = $mysqli->query("SELECT * FROM feedback");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="stylesheet" href="StyleSheet.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Feedback</h2>
            <p>Tell us about your feedback:</p>
        </div>
        <div class="row">
            <div class="column">
                <img src="image_url.jpg" alt="Feedback Image">
            </div>
            <div class="column">
                <form action="" method="POST">
                    <input type="email" name="email" id="email" placeholder="Email" required>
                    <textarea name="feedback" cols="30" rows="10" placeholder="Your feedback...." required></textarea>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <br><br><hr>

    <?php if (!empty($message)) echo $message; ?>
    <hr>

    <h2>List of feedback</h2>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "<br>";
            echo "<strong>Feedback:</strong> " . nl2br(htmlspecialchars($row['feedback'])) . "</p>";
        }
    } else {
        echo "<p>No feedback has been submitted yet.</p>";
    }
    ?>
</body>
</html>
