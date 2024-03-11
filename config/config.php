
<?php 
// config.php 
require 'vendor/autoload.php'; // Reemplaza con la ruta correcta a autoload.php

$credentialsFile = 'json/client_secret_251772058693-uepne6gsvv0kikhe9dd8ds2518ruiacj.apps.googleusercontent.com.json';
$jsonString = file_get_contents($credentialsFile);
$credentials = json_decode($jsonString, true);

$client = new Google_Client();
$client->setAuthConfig($credentials);
$client->setRedirectUri('http://localhost/reacondicionado/login2.php');
$client->addScope('https://www.googleapis.com/auth/gmail.send'); // Cambia el alcance según tus necesidades
?>