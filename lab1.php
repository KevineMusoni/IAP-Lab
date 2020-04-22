<?php
include_once 'DBConnector.php';
include_once 'user.php';
$db = new DBConnector();

if (isset($_POST['btn-save'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $city = $_POST['city_name'];

    $user = new User($first_name,$last_name,$city);
    $res = $user->save();

    if ($res) {
        echo "Save operation was a success";
    } else {
        echo "An error occured!";
    }
    
}
?>
<html>
<head>
    <title>lab 1</title>
</head>
<body>
    <form method="post" action="<?$_SERVER['PHP_SELF']?>">
        <table text-align="center">
            <tr>
                <td><input type="text" name="first_name" required placeholder="First Name"></td>
            </tr>
            <tr>
                <td><input type="text" name="last_name" placeholder="Last Name"></td>
            </tr>
            <tr>
                <td><input type="text" name="city_name" placeholder="City"></td>
            </tr>
            <tr>
                <td><button type="submit" name="btn-save"><strong>SAVE</strong></button></td>
            </tr>
        </table>
    </form>
    <div>
        <p>Records:</p>
        <table>
            <tr>
                <td>First Name</td>
                <td>Last Name</td>
                <td>City</td>
            </tr>
            <?
                $user = new User("","","");
                $dbusers = $user->readAll($db->conn);
                foreach ($db_users as $db_user) {
            ?>
             <tr>
                    <td><?echo $a_user[0]?></td>
                    <td><?echo $a_user[1]?></td>
                    <td><?echo $a_user[2]?></td>
             </tr>   
            <?
                }
                $db->closeDatabase();
            ?>
        </table>
    </div>
</body>
</html>