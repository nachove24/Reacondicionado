<?php include("template/cabecera.php"); ?>

<?php

// Conexión a la base de datos
include("config/bd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_u = $_POST['nombre_u'];
    $contrasena_u = $_POST['contrasena_u'];

    // Verificar si el usuario ya existe en la base de datos
    $stmt = $conexion->prepare('SELECT * FROM usuario WHERE nombre_u = :nombre_u');
    $stmt->execute(['nombre_u' => $nombre_u]);
    $user = $stmt->fetch();

    if ($user) {
        // El usuario ya existe en la base de datos, muestra una alerta
        $error = 'Este nombre de usuario ya está en uso. Elige otro nombre de usuario.';
    } else {
        // El usuario no existe en la base de datos, puedes continuar con el inicio de sesión
        $stmt = $conexion->prepare('INSERT INTO usuario (nombre_u, contrasena_u) VALUES (:nombre_u, :contrasena_u)');
        $stmt->execute(['nombre_u' => $nombre_u, 'contrasena_u' => password_hash($contrasena_u, PASSWORD_DEFAULT)]);
        
        // Inicio de sesión exitoso
        session_start();
        $_SESSION['id_u'] = $conexion->lastInsertId();
        header('Location: index.php');
        exit;
    }
}

// Verificación de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_u = $_POST['nombre_u'];
    $contrasena_u = $_POST['contrasena_u'];

    $stmt = $conexion->prepare('SELECT * FROM usuario WHERE nombre_u = :nombre_u');
    $stmt->execute(['nombre_u' => $nombre_u]);
    $user = $stmt->fetch();

    if ($user && password_verify($contrasena_u, $user['contrasena_u'])) {
        // Inicio de sesión exitoso
        session_start();
        $_SESSION['id_u'] = $user['id_u'];
        header('Location: index.php');
        exit;
    } else {
        // Inicio de sesión fallido
        $error = 'Nombre de usuario o contraseña incorrectos';
    }
}


?>

<!-- Formulario de inicio de sesión (de nuevo) -->
<form method="post" action="login.php">
    <fieldset>
        <legend>Iniciar sesión</legend>
        <?php if (isset($error)): ?>
            <p><?php echo $error ?></p>
        <?php endif ?>
        <div>
            <label for="nombre_u">Nombre de usuario:</label>
            <input type="text" id="nombre_u" name="nombre_u" required>
        </div>
        <div>
            <label for="contrasena_u">Contraseña:</label>
            <input type="password" id="contrasena_u" name="contrasena_u" required>
        </div>
        <div>
            <input type="submit" value="Iniciar sesión">
        </div>
    </fieldset>
</form>


<?php include("template/pie.php"); ?>
