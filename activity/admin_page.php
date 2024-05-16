<?php
include 'config.php';
session_start();

if (!isset($_SESSION['adminName']) || !isset($_SESSION['adminID'])) {
    header('location:login_page.php');
    exit;
}

// Handle logout
if (isset($_GET['logout'])) {
    session_unset(); 
    session_destroy(); 
    header('location:login_page.php');
    exit;
}

$adminID = $_SESSION['adminID'];

// Fetch user details from database
$stmt = $conn->prepare("SELECT * FROM `admin` WHERE adminID = ?");
$stmt->bind_param("i", $adminID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $fetch = $result->fetch_assoc();
} else {
    die('Failed to retrieve user data.');
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <div class="content">
        <h3>Hi, <span>admin</span></h3>
        <h1>Welcome <span><?php echo htmlspecialchars($_SESSION['adminName']); ?></span></h1>
        <?php
        if (empty($fetch['image'])) {
            echo '<img src="images/default-avatar.png" alt="Default Avatar">';
        } else {
            echo '<img src="uploaded_img/' . htmlspecialchars($fetch['image']) . '" alt="Profile Image">';
        }
        ?>
        <h3><?php echo htmlspecialchars($fetch['adminName']); ?></h3>
        <a href="update_profile.php" class="btn">Update Profile</a>
        <a href="logout.php" class="btn">Logout</a>
        <p>New <a href="login_form.php">login</a> or <a href="register_form.php">register</a></p>
    </div>
</div>
</body>
</html>
