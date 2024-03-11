<?php  
require 'vendor/autoload.php'; // Asegúrate de que esta línea incluya el archivo de inicio de Composer

$client = new Google_Client();
$client->setAuthConfig('../json/client_secret_251772058693-uepne6gsvv0kikhe9dd8ds2518ruiacj.apps.googleusercontent.com.json'); // Ruta al archivo JSON de las credenciales
$client->setAccessType('offline');
$client->setApprovalPrompt('force');
$client->addScope(Google_Service_Gmail::GMAIL_SEND); // Permiso para enviar correos electrónicos

// Inicia sesión y obtén un token de acceso
$client->setRedirectUri('http://localhost/reacondicionado/login2.php'); // Define la URL de redirección
?>