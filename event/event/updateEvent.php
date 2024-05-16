<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Welcome to IDS</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="mx-auto" style="width: auto;">
                <br><h3><b>Update Event List</b></h3>
            </div>
            <div class="col-md-12 col-md-offset-3">
                <p></p>
                <button type="button" class="btn btn-outline-dark" "float-right" onclick="window.print()">Print List</button>
                <p></p>
                <form method="POST">
                    <div class="form-group">
      
                        Event ID: <input type="text" name="eventID" class="form-control" id="newtask" value=""><br>
                        Event Name: <input type="text" name="eventName" class="form-control" id="newtask" value=""><br>
                        Event Detail: <input type="text" name="eventDetail" class="form-control" id="newtask" value=""><br>
                        Event Pic: <input type="text" name="eventPic" class="form-control" id="newtask" value=""><br>
                        Event Date: <input type="date" name="eventDate" class="form-control" id="newtask" value=""><br>
                    
                    </div>
                    <button type="submit" name="send" class="btn btn-primary">Update</button>
                    <a class="btn btn-outline-danger" href="main.php" role="button">Back</a>
                </form>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>

<?php 
include "conn.php";

$eventID=$_GET['eventID'];
$sql = "SELECT * FROM event WHERE eventID='$eventID'";  

$rows=$conn->query($sql);    
$row=$rows->fetch_assoc();

if(isset($_POST['send'])){
        $eventID="";
        //$contact="";
        $eventName="";
        $eventDetail="";
        $eventPic="";
        $eventDate="";
    
    $eventID = $_POST['eventID'];
    $eventName = $_POST['eventName'];
    $eventDetail = $_POST['eventDetail'];
    $eventPic = $_POST['eventPic'];
    $eventDate= $_POST['eventDate'];
          
    // this is the to be displayed 
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    
    if($eventID && $eventName && $eventDetail && $eventPic && $eventDate){
         $mysql = "UPDATE event set eventID='$eventID', eventName='$eventName', eventDetail='$eventDetail', eventPic='$eventPic', eventDate='$eventDate' WHERE eventID='$eventID' ";
        
        
    if($conn->query($mysql)){
        header('location: main.php');
}
else{
    echo("Error in Adding Records in Table : ".$conn->connect_error);
}
    }
    else{
        echo "<br>";
        echo "<center>";
        echo "<span style='color:red; font-size:30px;'>FILL UP <strong>All OF THE FIELDS ON THE FORM IN ORDER TO UPDATE </strong> !!</span>";
        echo "";
        echo "</center>";
    }   
$conn->close();
}

else{
    echo "";
}

?>

