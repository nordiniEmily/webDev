<?php
include 'config.php'; 

session_start();

if (isset($_SESSION['adminID'])) {
    $adminID = $_SESSION['adminID'];

    // Update last logout time
    $updateLogoutTime = "UPDATE admin SET last_logout=NOW() WHERE adminID='$adminID'";
    $result = mysqli_query($conn, $updateLogoutTime);

    if (!$result) {
        echo "Error updating last logout time: " . mysqli_error($conn);
    }
}

session_unset();
session_destroy();

header('location: login_page.php');
exit;
?>
