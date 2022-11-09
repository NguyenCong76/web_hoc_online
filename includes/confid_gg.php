<?php
require_once '../Google_API/vendor/autoload.php';

session_start();

// init configuration
$clientID = '947840471908-umncs13698icef2vlsmjp453uvmk42gn.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/giao_dien_hoc_online/hocsinh/login_gg.php';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// Connect to database
$hostname = "localhost";
$username = "root";
$password = "";
$database = "hoc_online";

$conn = mysqli_connect($hostname, $username, $password, $database);
?>