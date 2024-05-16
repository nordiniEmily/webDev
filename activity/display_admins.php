<?php
include 'config.php';  

$sql = "SELECT adminName, matrixNo, last_login, last_logout FROM admin";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Table</title>
    <link rel="stylesheet" href="css/styledisplay.css">
</head>
<body>
    <h1>Admin Table</h1>
    <?php
    if ($result->num_rows > 0) {
        echo "<table border='1'>"; 
        echo "<tr>
                <th>Admin Name</th>
                <th>Matrix No</th>
                <th>Last Login</th>
                <th>Last Logout</th>
              </tr>";
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['adminName']) . "</td>
                    <td>" . htmlspecialchars($row['matrixNo']) . "</td>
                    <td>" . ($row['last_login'] ? date("Y-m-d H:i:s", strtotime($row['last_login'])) : 'Never logged in') . "</td>
                    <td>" . ($row['last_logout'] ? date("Y-m-d H:i:s", strtotime($row['last_logout'])) : 'Never logged out') . "</td>
                  </tr>";
        }
        echo "</table>"; 
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>
</body>
</html>
