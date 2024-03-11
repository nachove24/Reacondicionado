<?php 
// Ruta al archivo JSON de credenciales (ajusta la ruta según tu ubicación)
$credentialsFile = 'client_secret_251772058693-uepne6gsvv0kikhe9dd8ds2518ruiacj.apps.googleusercontent.com.json';

// Lee el contenido del archivo JSON de credenciales
$credentialsJson = file_get_contents($credentialsFile);

// Decodifica el contenido del archivo JSON en un objeto PHP
$credentials = json_decode($credentialsJson);

// Verifica si la decodificación fue exitosa
if ($credentials === null) {
    die('Error al decodificar el archivo JSON de credenciales.');
}

// A partir de este punto, puedes acceder a las propiedades del objeto $credentials
// según lo requerido por la API de Google que estés utilizando.

// Por ejemplo, si tienes un campo 'client_id' en tus credenciales, puedes acceder a él así:
$clientID = $credentials->cliente_r;

// Continúa con la configuración de tu aplicación para interactuar con la API de Google.
?>

<?php