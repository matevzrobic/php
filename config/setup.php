<?php

$site_title = "store";
/*
$user = "root";
$pass = '';
$db = 'storedatabase';

$db = new mysqli('localhost', $user, $pass, $db) or die("unable to connect");

echo "database works";
*/

// $http_port = '8012';
$http_port = '8012';
$https_port = '433';

$url = filter_input(INPUT_SERVER, "PHP_SELF", FILTER_SANITIZE_SPECIAL_CHARS);
$urlBase = "http://localhost:". $http_port . "/EpSeminar/index.php";

if (isset($_SESSION['user'])) {
    $user_name = $signed_usr = $_SESSION["user"]["firstname"] . $_SESSION["user"]["lastname"];
    $user_permissions = $_SESSION["user"]["permission"];
}
else{
    $user_name = "Guest";
    $user_permissions = 0;
}

//var_dump($_SESSION["user"]);
//if(!isset($_SERVER["HTTPS"])){
//    $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
//    $url_parts = explode('/', $url);
//    $url_parts[2] = "localhost"; // remove port number; this means https will default to port :443
//    $url = implode("/", $url_parts);
//    header("Location: " . $url);
//}

if (isset($_SESSION["user"]) && !isset($_SERVER["HTTPS"])) {
    $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    $url_parts = explode('/', $url);
    $url_parts[2] = "localhost"; // remove port number; this means https will default to port :443
    $url = implode("/", $url_parts);
    header("Location: " . $url);
}
?>
