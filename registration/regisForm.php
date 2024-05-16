<?php
include ('config.php');

// Initialize variables for the alert messages
$alertClass = '';
$alertMessage = '';

if(isset($_POST['submit'])){
    $uName=$_POST['uName'];
    $uMatrixNo=$_POST['uMatrixNo'];
    $phoneNum=$_POST['phoneNum'];
    $email=$_POST['email'];
    $facultyName=$_POST['facultyName'];
    $reason=$_POST['reason'];

    $query=mysqli_query($con, "INSERT INTO user (uName,uMatrixNo,phoneNum,email,facultyName,reason) VALUES ('$uName','$uMatrixNo','$phoneNum','$email','$facultyName','$reason')");
    if($query)
    {
        // Success message
        $alertClass = 'alert alert-success';
        $alertMessage = 'Data inserted successfully';
    }else{
        // Error message
        $alertClass = 'alert alert-danger';
        $alertMessage = 'There was an error inserting data';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration form</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <!-- Display the alert message based on the condition -->
        <?php if (!empty($alertMessage)) { ?>
            <div class="<?php echo $alertClass; ?>" role="alert">
                <?php echo $alertMessage; ?>
            </div>
        <?php } ?>

        <form method="POST" >
            <br><br>
            <h2>Registration Club Members</h2><br><hr><br>
            <label for="uName">Full name:</label>
            <input type="text" name="uName" placeholder="Enter name" required/>
            <br> <br>
            <label for="uMatrixNo">Matrix no:</label>
            <input type="text" name="uMatrixNo" placeholder="Enter matrix no" required/>
            <br> <br>
            <label for="phoneNum">Phone number:</label>
            <input type="number" name="phoneNum" placeholder="Enter phone number" required/>
            <br> <br>
            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="Enter email" required/>
            <br> <br>
            <label for="facultyName">Faculty:</label>
            <select id="facultyName" name="facultyName">
                <option value="fsktm">FSKTM</option>
                <option value="fptv">FPTV</option>
                <option value="fkee">FKEE</option>
                <option value="fkmp">FKMP</option>
            </select>
            <br> <br>
            <label for="reason">Reason to join:</label><br>
            <textarea name="reason" cols="30" rows="10" placeholder="Enter your reason to join this club" required></textarea>
            <br> <br>
            <button type="submit" name="submit">Submit</button>
        </form>
    </div>

    <!-- Include Bootstrap JS (optional for some components) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
