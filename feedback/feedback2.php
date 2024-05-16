<!-- backup -->
<?php
include("config.php");

$message = ''; // To hold success or error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['feedbackEmail'] ?? '');
    $feedback = trim($_POST['inputText'] ?? '');

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
<title>Simple Form Submission</title>
</head>
<body>
    <h1>Rate your experience</h1>
    <form action="" method="POST">
        <label for="feedbackEmail">Email:</label>
        <input type="text" id="feedbackEmail" name="feedbackEmail" placeholder="Enter your email here">
        <br><br>

        <label for="inputText">We highly value your feedback! <br> Kindly take a moment to rate your experience and provide us with your valuable feedback.</label>
        <br><br>
        <textarea id="inputText" name="inputText" placeholder="Tell about your experience!" rows="4" cols="50"></textarea>
        <br><br>
        <button type="submit" name="submit">Submit</button>
    </form>
    <br>
    <?php if (!empty($message)) echo $message; ?>
    <hr>

    <h2>All Feedback</h2>
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
