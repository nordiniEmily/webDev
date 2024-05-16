<?php
include 'config.php';
session_start();

if (!isset($_SESSION['adminID'])) {
    header('Location: login_page.php');
    exit;
}

$adminID = $_SESSION['adminID'];
$message = [];

// Update profile if form is submitted
if (isset($_POST['update_profile'])) {
    // Securely handle the input
    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

    // Update basic info
    $stmt = $conn->prepare("UPDATE admin SET adminName = ?, email = ? WHERE adminID = ?");
    $stmt->bind_param("ssi", $update_name, $update_email, $adminID);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        $message[] = 'Profile updated successfully!';
    }
    $stmt->close();

    // Handle password update
    if (!empty($_POST['old_pass']) && !empty($_POST['new_pass']) && !empty($_POST['confirm_pass'])) {
        $old_pass = $_POST['old_pass'];
        $new_pass = $_POST['new_pass'];
        $confirm_pass = $_POST['confirm_pass'];

        // Verify old password
        $stmt = $conn->prepare("SELECT adminPwd FROM admin WHERE adminID = ?");
        $stmt->bind_param("i", $adminID);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        if ($data && password_verify($old_pass, $data['adminPwd'])) {
            if ($new_pass == $confirm_pass) {
                $new_pass_hash = password_hash($new_pass, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE admin SET adminPwd = ? WHERE adminID = ?");
                $stmt->bind_param("si", $new_pass_hash, $adminID);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    $message[] = 'Password updated successfully!';
                }
            } else {
                $message[] = 'New password and confirm password do not match.';
            }
        } else {
            $message[] = 'Old password is incorrect.';
        }
        $stmt->close();
    }

    // Handle image update
    if (!empty($_FILES['update_image']['name'])) {
        $update_image = $_FILES['update_image']['name'];
        $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
        $update_image_size = $_FILES['update_image']['size'];
        $update_image_folder = 'uploaded_img/' . $update_image;

        if ($update_image_size > 2000000) {
            $message[] = 'Image size is too large. Maximum allowed size is 2MB.';
        } else {
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
            $stmt = $conn->prepare("UPDATE admin SET image = ? WHERE adminID = ?");
            $stmt->bind_param("si", $update_image, $adminID);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                $message[] = 'Image updated successfully!';
            }
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
    <title>Update Profile</title>
        <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .update-profile {
            width: 100%;
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .update-profile img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 20px;
            display: block;
        }
        .flex {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .inputBox {
            flex: 1 1 200px;
        }
        .inputBox span {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        .box {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        .box:focus {
            border-color: #5cb85c;
            outline: none;
        }
        .btn, .delete-btn {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn {
            background-color: #5cb85c;
            color: white;
        }
        .btn:hover {
            background-color: #4cae4c;
        }
        .delete-btn {
            background-color: #d9534f;
            color: white;
            text-decoration: none;
        }
        .delete-btn:hover {
            background-color: #c9302c;
        }
        .message {
            color: #31708f;
            background-color: #d9edf7;
            border-color: #bce8f1;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
        @media (max-width: 768px) {
            .flex {
                flex-direction: column;
            }
            .inputBox {
                width: 100%;
            }
        }
    </style>
    </style>
</head>
<body>
<div class="update-profile">
    <?php
    $stmt = $conn->prepare("SELECT * FROM admin WHERE adminID = ?");
    $stmt->bind_param("i", $adminID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $fetch = $result->fetch_assoc();
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <?php
        if (!empty($fetch['image'])) {
            echo '<img src="uploaded_img/' . htmlspecialchars($fetch['image']) . '" alt="Profile Image">';
        } else {
            echo '<img src="images/default-avatar.png" alt="Default Profile Image">';
        }
        foreach ($message as $msg) {
            echo '<div class="message">' . htmlspecialchars($msg) . '</div>';
        }
        ?>
        <div class="flex">
            <div class="inputBox">
                <span>Username:</span>
                <input type="text" name="update_name" value="<?php echo htmlspecialchars($fetch['adminName']); ?>" class="box">
                <span>Your Email:</span>
                <input type="email" name="update_email" value="<?php echo htmlspecialchars($fetch['email']); ?>" class="box">
                <span>Update Your Pic:</span>
                <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
            </div>
            <div class="inputBox">
                <span>Old Password:</span>
                <input type="password" name="old_pass" placeholder="Enter previous password" class="box">
                <span>New Password:</span>
                <input type="password" name="new_pass" placeholder="Enter new password" class="box">
                <span>Confirm Password:</span>
                <input type="password" name="confirm_pass" placeholder="Confirm new password" class="box">
            </div>
        </div>
        <input type="submit" value="Update Profile" name="update_profile" class="btn">
        <a href="admin_page.php" class="delete-btn">Go Back</a>
    </form>
    <?php }  ?>
</div>
</body>
</html>
