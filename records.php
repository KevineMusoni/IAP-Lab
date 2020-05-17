<?php
    include_once "DBConnector.php";
    include_once "user.php";
    $con = new DBConnector;
    $res = User::readAll($con->conn);
?>
<html>
<head><title>Records:</title></head>
    <body>
    <tr>
        <td>First Name:</td>
        <td>Last Name:</td>
        <td>City:</td>
    </tr>
        <?php
            if ($res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["first_name"] . "</td>";
                    echo "<td>" . $row["last_name"] . "</td>";
                    echo "<td>" . $row["user_city"] . "</td>";
                    echo "</tr>";
                }
            }
            
        ?>
    
        </table>
    </body>
</html>