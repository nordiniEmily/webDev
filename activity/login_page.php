<?php
include 'config.php';
session_start();

$error = []; // Initialize the error array to store messages

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $adminPwd = $_POST['adminPwd']; // Password from form input

    if (empty($email) || empty($adminPwd)) {
        $error[] = 'Both email and password are required!';
    } else {
        $stmt = $conn->prepare("SELECT adminID, adminName, adminPwd FROM admin WHERE email = ?");
        if ($stmt === false) {
            $error[] = 'Database query failed. Error: ' . htmlspecialchars($conn->error);
        } else {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                if (password_verify($adminPwd, $row['adminPwd'])) {
                    $_SESSION['adminID'] = $row['adminID'];
                    $_SESSION['adminName'] = $row['adminName'];

                    header('Location: admin_page.php');
                    exit;
                } else {
                    $error[] = 'Incorrect password.';
                }
            } else {
                $error[] = 'No account found with that email address.';
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="form-container">
    <form action="" method="post">
        <h3>Login Now</h3>
        <?php if (!empty($error)) {
            foreach ($error as $errorMsg) {
                echo '<p class="error-msg">' . htmlspecialchars($errorMsg) . '</p>';
            }
        } ?>
        <input type="email" name="email" required placeholder="Enter your email">
        <input type="password" name="adminPwd" required placeholder="Enter your password">
        <input type="submit" name="submit" value="Login Now" class="form-btn">
        <p>Don't have an account? <a href="register_form.php">Register Now</a></p>
    </form>
</div>
</body>
</html>
