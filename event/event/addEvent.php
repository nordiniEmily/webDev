<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to IDS</title>
</head>
<style>
    body {
            background-color: floralwhite;
        }
</style>
<body>
    
</body>
</html>

<?php
include("conn.php");
if(isset($_POST['send'])){
        $eventID="";
        $eventName="";
        $eventDetail="";
        $eventPic="";
        $eventDate="";

    $eventID = $_POST['eventID'];
    $eventName = $_POST['eventName'];
    $eventDetail = $_POST['eventDetail'];
    $eventPic = $_POST['eventPic'];
    $eventDate = $_POST['eventDate'];
         
    // this is the to be displayed 
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    
    if($eventID && $eventName && $eventDetail && $eventPic && $eventDate){
        $mysql = "INSERT INTO event (eventID,eventName,eventDetail,eventPic,eventDate) VALUES ('$eventID','$eventName','$eventDetail','$eventPic','$eventDate')";  

        
    if($conn->query($mysql)){
        header('location:main.php');
}
else{
    echo("Error in Adding Records in Table : ".$conn->connect_error);
}
    }
    else{
        echo "<br><br><br>";
        echo "<center>";
        echo "<span style='color:red; font-size:30px;'>FILL UP <strong>All OF THE FIELDS ON THE FORM IN ORDER TO UPDATE </strong> !!</span>";
        echo "";
        echo "</center>";
    }    header('location:main.php');
$conn->close();
}

else{
    echo "";
}

?>