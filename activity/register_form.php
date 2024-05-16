<?php
include 'config.php';
session_start();

if(isset($_POST['submit'])){
    $adminName = mysqli_real_escape_string($conn, $_POST['adminName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $adminPwd = $_POST['adminPwd'];
    $cAdminPwd = $_POST['cAdminPwd'];
    $phoneNum = mysqli_real_escape_string($conn, $_POST['phoneNum']);
    $matrixNo = mysqli_real_escape_string($conn, $_POST['matrixNo']);
    $facultyName = mysqli_real_escape_string($conn, $_POST['facultyName']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/'.$image;

    if($adminPwd !== $cAdminPwd){
        $error[] = 'Passwords do not match!';
    } elseif ($image_size > 2000000){
        $error[] = 'Image size is too large! Maximum allowed size is 2MB.';
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT email FROM admin WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            $error[] = 'User already exists with this email!';
        } else {
            if(move_uploaded_file($image_tmp_name, $image_folder)){
                $hashedPwd = password_hash($adminPwd, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO admin (matrixNo, adminName, adminPwd, phoneNum, email, facultyName, role, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssss", $matrixNo, $adminName, $hashedPwd, $phoneNum, $email, $facultyName, $role, $image);
                $stmt->execute();
                if($stmt->affected_rows > 0){
                    $message[] = 'Registered successfully!';
                    header('location:login_page.php');
                    exit;
                } else {
                    $error[] = 'Registration failed!';
                }
            } else {
                $error[] = 'Failed to upload image.';
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="form-container">
    <form action="" method="post" enctype="multipart/form-data">
        <h3>Register now</h3>
        <?php if(isset($error)){ foreach($error as $error){ echo '<span class="error-msg">'.$error.'</span>'; }; } ?>
        <input type="text" name="adminName" required placeholder="Enter your name">
        <input type="text" name="matrixNo" required placeholder="Enter your matrix number">
        <input type="email" name="email" required placeholder="Enter your email">
        <input type="password" name="adminPwd" required placeholder="Enter your password">
        <input type="password" name="cAdminPwd" required placeholder="Confirm your password">
        <input type="number" name="phoneNum" required placeholder="Enter your phone number">
        <input type="text" name="facultyName" required placeholder="Enter your faculty name">
        <input type="text" name="role" required placeholder="Enter your role">
        <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
        <input type="submit" name="submit" value="Register now" class="form-btn">
        <p>Already have an account? <a href="login_page.php">Login now</a></p>
    </form>
</div>
</body>
</html>
