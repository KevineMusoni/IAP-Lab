<?php
include_once 'DBConnector.php';
session_start();
if (!isset($_SESSION['username'])){
    header("Location:login.php");
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    //We do not allow users to visit this page via a url!
    header('HTTP/1.0 403 Forbidden');
    echo 'You are forbidden!';
} else {
    $api_key = null;
    $api_key = generateApiKey(64); // We generate an API key 64 characters long
    header('Content-type: application/json');
    echo generateResponse($api_key);
    }

    function generateApiKey($stringLength)
    {
        // base 62 map
        $chars = '';

        // get enough random bits for base 64 encoding and prevent '=' padding
        // Note: +1 is faster than ceil()
        $bytes = openssl_random_pseudo_bytes(3 * $stringLength / 4 + 1);

        // convert base 64 to base 62 by mapping + and / to something from the base 62
        // use the first 2 random bytes for the new characters
        $repl = unpack('C2', $bytes);

        $first =  $chars[$repl[1]%62];
        $second =  $chars[$repl[2]%62];

        return strstr(substr(base64_encode($bytes), 0, $stringLength), '+/', "$first$second");
    }

    function saveApiKey()
    {
        return true;
    }

    function generateResponse($api_key)
    {
        if (saveApiKey()){
            $res = ['success' => 1, 'message' => $api_key];
        } else {
            $res = ['success' => 0, 'message' => 'Something went wrong. Please regenerate the API key'];
        }
        return json_encode($res);
    }

    function fetchUserApiKey()
    {
      return true;
    }


?>
<html>
    <head>
        <title>Private Page</title>
        <script type="text/javascript" src="validate.js"></script>
        <link rel="stylesheet" type="text/css" href="validate.css">
        <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css.map">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css.map">

    </head>

    <body>
    <p style="text-align: center;"><a href="logout.php">Log Out</a></p>
    <hr>
    <h3>Here we will crate an API that will allow Users/Developers to order items from external systems</h3>
        <hr>
        <h4>We now put this feature of allowing users to generate an API key. Click on the button to generate the API key.</h4>

        <button class="btn btn-primary" id="api-key-btn">Generate API Key</button><br>

<!--        This text area holds the API key-->
        <strong>Your API key:</strong>Note that if your API key is in use by already running applications, generating the key will stop the application form functioning
        <br>
        <textarea cols="100" rows="2" id="api_key" name="api_key" readonly><?php echo fetchUserApiKey();?></textarea>

        <h3>Service Description</h3>
        We have a service / API that allows external applications to oder food and also
        pull all order status by using order id. Let's do it
        <hr>

    </body>
</html>