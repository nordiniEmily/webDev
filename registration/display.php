<?php
include('config.php'); 

$query = "SELECT * FROM user";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>User Data</title>";
    echo "</head>";
    echo "<body>";
    echo "<h1>User Data</h1>";
    echo "<table border='1'>";
        echo "<tr>";
            echo "<th>Full Name</th>";
            echo "<th>Matrix No</th>";
            echo "<th>Phone Number</th>";
            echo "<th>Email</th>";
            echo "<th>Faculty</th>";
            echo "<th>Reason to Join</th>";
        echo "</tr>";

        // Output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['uName'] . "</td>";
            echo "<td>" . $row['uMatrixNo'] . "</td>";
            echo "<td>" . $row['phoneNum'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['facultyName'] . "</td>";
            echo "<td>" . $row['reason'] . "</td>";
            echo "</tr>";
        }

echo "</table>";
    echo "</body>";
    echo "</html>";
} else {
    echo "No records found";
}

mysqli_close($con);
?>
