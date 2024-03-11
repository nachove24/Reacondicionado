<?php include("template/cabecera.php"); ?>

<?php
// Conexión a la base de datos
include("config/bd.php");

// Procesamiento del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_u = $_POST["nombre_u"];
    $contrasena_u = $_POST["contrasena_u"];

    // Inserción de los datos en la base de datos
    $sql = "INSERT INTO usuario (nombre_u, contrasena_u)
            VALUES (:nombre_u, :contrasena_u)";

    try {
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":nombre_u", $nombre_u);
        $stmt->bindParam(":contrasena_u", $contrasena_u);
        $stmt->execute();
        // Mostrar una alerta de JavaScript
        echo "<script>alert('El usuario ha sido registrado correctamente');</script>";
        // Redirigir después de que el usuario haga clic en Aceptar en la alerta
        echo "<script>window.location = 'usuario.php';</script>";

    } catch (PDOException $ex) {
        echo "Ha ocurrido un error al registrar al usuario: " . $ex->getMessage();
    }
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
        <h4>Registro de usuario</h4>
      </div>
      <div class="card-body">
        <form method="post" enctype="multipart/form-data">
          <fieldset class="form-group">
            <label for="nombre_u">Nombre:</label>
            <input type="text"  class="form-control" name="nombre_u" id="nombre_u" required>
          </fieldset>
          <br><br>
          <fieldset class="form-group">
            <label for="contrasena_u">Contraseña:</label>
            <input type="password" class="form-control" name="contrasena_u" id="contrasena_u" required>
          </fieldset>
          <br><br>
          <div class="text-center">
            <input type="submit" value="Registrarse">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


</body>
</html>




<?php include("template/pie.php"); ?>
