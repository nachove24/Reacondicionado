<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reacondicion</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min (1).css" />
 </head>
 <body>
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="#">Reacondición</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
    </ul>
  </div>
</nav>

<?php
// Conexión a la base de datos
include("config/bd.php");

// Procesamiento del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_a = $_POST["nombre_a"];
    $contrasena_a = $_POST["contrasena_a"];
    $contrasena_a2 = $_POST["contrasena_a2"];
    $email = $_POST["email"];


  if ($contrasena_a2 == $contrasena_a) {
    // code...
  
    $sql = "SELECT nombre_a FROM admin WHERE nombre_a = :nombre_a";
    try {
      $stmt = $conexion->prepare($sql);
      $stmt->bindParam(":nombre_a", $nombre_a);
      $stmt->execute();
    } catch (PDOException $ex) {
        echo "Ha ocurrido un error al registrar al usuario: " . $ex->getMessage();
    }

    if ($stmt->fetch()) {
      echo "<script>alert('El nombre de admin ya existe. Por favor, elige otro nombre de usuario.');</script>";
        // Redirigir después de que el usuario haga clic en Aceptar en la alerta
        //echo "<script>window.location = 'index.php';</script>";
        
    } else {
    // Inserción de los datos en la base de datos
    $sql = "INSERT INTO admin (nombre_a, contrasena_a, email)
            VALUES (:nombre_a, :contrasena_a, :email)";

    try {
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":nombre_a", $nombre_a);
        $stmt->bindParam(":contrasena_a", $contrasena_a);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        // Mostrar una alerta de JavaScript
        echo "<script>alert('El admin ha sido registrado correctamente');</script>";
        // Redirigir después de que el usuario haga clic en Aceptar en la alerta
        echo "<script>window.location = 'login2.php';</script>";
       
    } catch (PDOException $ex) {
        echo "Ha ocurrido un error al registrar al usuario: " . $ex->getMessage();
    }
  }
}else{echo "Las contraseñas no coinciden.";}
}
$conexion = null; // Cerrar la conexión

?>










<!DOCTYPE html>
<html>
<head>
	<title>Formulario de Registro</title>
</head>
<body>
	
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
  <div class="col-md-5">
    <div class="card">
      <div class="card-header text-center">
        <h4>Registro de Administrador</h4>
      </div>
      <div class="card-body">
        <form method="post" enctype="multipart/form-data">
          <fieldset class="form-group">
            <label for="nombre_u">Nombre:</label>
            <input type="text"  class="form-control" name="nombre_a" id="nombre_u" required>
          </fieldset>
          <br><br>
          <fieldset class="form-group">
            <label for="contrasena_u">Contraseña:</label>
            <input type="password" class="form-control" name="contrasena_a" id="contrasena_u" required>
          </fieldset>
          <br><br>
          <fieldset class="form-group">
            <label for="contrasena_u">Confirmar contraseña:</label>
            <input type="password" class="form-control" name="contrasena_a2" id="contrasena_u2" required>
          </fieldset>
          <br><br>
          <fieldset class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" name="email" id="email" required>
          </fieldset>
          <br><br>
          <div class="text-center">
            <input type="submit" value="Registrarse">
          </div>
        </form>
        <a href="login2.php">¿Ya estás registrado?</a>
      </div>
    </div>
  </div>
</div>


</body>
</html>




<?php include("template/pie.php"); ?>
