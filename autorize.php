<?php  
// authorize.php

require 'config/config.php';

$authUrl = $client->createAuthUrl();
header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    // Aquí tienes el token de acceso
    session_start();
    $_SESSION['access_token'] = $token;
    header('Location: gmail.php');
}
?>