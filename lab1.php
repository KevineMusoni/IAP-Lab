<?php
include_once 'DBConnector.php';
include_once 'user.php';
include_once 'fileUploader.php';
$con = new DBConnector();

if (isset($_POST['btn-save'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $city = $_POST['city_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $utc_timestamp = $_POST['utc_timestamp'];
    $offset = $_POST['time_zone_offset'];
    // Creating a User Object

    $user = new User($first_name,$last_name,$city,$username,$password, $utc_timestamp, $offset);
    // Create object for file uploading
    $uploader = new FileUploader();

    if(!$user->validateForm()){
        $user->createFormErrorSessions();
        header("Refresh:0");
        die();
    }

    $res = $user->save($con);
    
    // call uploadFile() function, which returns,
    $file_upload_response = $uploader->uploadFile();

    if ($res && $file_upload_response) {
        echo "Save operation was a success";
    } else {
        echo "An error occured!";
    }
    
}
?>
<!-- html form -->
<html>
<head>

    <title>IAP Lab</title>

    <script type="text/javascript" src="validate.js"></script>
    <link rel="stylesheet" type="text/css" href="validate.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script type="text/javascript" src="timezone.js"></script>

</head>
<body>
<!-- onsubmit will call js function when the form is submitted -->
    <form method="post" name="user_details" id="user_details" onsubmit="return validateForm()" action="<?=$_SERVER['PHP_SELF']?>">
        <table text-align="center">
            <tr>
            <td>
                <div id="form-errors">
                    <?php
                    session_start();
                    if(!empty($_SESSION['form_errors'])){
                        echo "" . $_SESSION['form_errors'];
                    }
                    ?>
                
                </div>
            </td>
            </tr>

            <tr>
                <td><input type="text" name="first_name" required placeholder="First Name" /></td>
            </tr>
            <tr>
                <td><input type="text" name="last_name" placeholder="Last Name" /></td>
            </tr>
            <tr>
                <td><input type="text" name="city_name" placeholder="City" /></td>
            </tr>
            <tr>
                <td><input type="text" name="username" placeholder="Username" /></td>
            </tr>
            <tr>
                <td><input type="password" name="password" placeholder="Password"/></td>
            </tr>
            <tr>
                <td>Profile image:<input type="file" name="fileToUpload" id="fileToUpload"></td>
            </tr>
            <tr>
                <td><button type="submit" name="btn-save"><strong>SAVE</strong></button></td>
            </tr>
            <input type="hidden" name="utc_timestamp" id="utc_timestamp" value=""/>
            <input type="hidden" name="time_zone_offset" id="time_zone_offset" value=""/>
            <tr>
                <td><a href="login.php">Login</a></td>
            </tr>
           
        </table>
    </form>
    <button><a href= "records.php">View Records</a></button>
</body>
</html>