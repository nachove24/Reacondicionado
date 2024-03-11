<?php
session_start();
require 'config/config.php'; // Incluye el archivo config.php

if (!isset($_SESSION['access_token'])) {
    die("Token de acceso no válido. Debes autenticarte primero.");
}
// Configura el token de acceso en el cliente de Google
$client->setAccessToken($_SESSION['access_token']);

// Realiza solicitudes a la API de Gmail utilizando $client

function sendEmail($to, $subject, $message) {
    // Obtiene el cliente desde el ámbito global
    global $client;

    $service = new Google_Service_Gmail($client);

    $email = new Google_Service_Gmail_Message();
    $email->setRaw(strtr(base64_encode(
        "To: $to\r\n" .
        "Subject: $subject\r\n\r\n" .
        $message
    ), '+/', '-_'));

    try {
        $message = $service->users_messages->send("me", $email);
        return $message;
    } catch (Google_Service_Exception $e) {
        echo "Error al enviar el correo electrónico: " . $e->getMessage();
    }
}

$to = "nachove24@gmail.com";
$subject = "Asunto del correo";
$message = "Este es el cuerpo del correo electrónico.";

$result = sendEmail($to, $subject, $message);

if ($result) {
    echo "Correo electrónico enviado correctamente.";
} else {
    echo "Error al enviar el correo electrónico.";
}
