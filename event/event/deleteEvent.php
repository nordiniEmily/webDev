<?php
include "conn.php";
$eventID=$_GET['eventID'];

$sql="DELETE FROM event WHERE eventID = '$eventID'";

$val= $conn->query($sql);
if($val){
header('location: main.php');

}
?>
