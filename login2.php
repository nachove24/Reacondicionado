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
    $nombre_u = $_POST["nombre_u"];
    $contrasena_u = $_POST["contrasena_u"];

    $sql="SELECT nombre_u, contrasena_u, id_u FROM usuario WHERE nombre_u = :nombre_u";

    try {
        $stmt = $conexion->prepare($sql);
        $stmt->execute(['nombre_u' => $nombre_u]);
        $resultado = $stmt->fetch();
    } catch (PDOException $ex) {
        echo "Ha ocurrido un error al registrar al usuario: " . $ex->getMessage();
    }

     if ($resultado) {
        // Nombre de usuario existe en la base de datos
        $v_usuario = $resultado['nombre_u'];
        $v_contrasena = $resultado['contrasena_u'];
        $v_id_u = $resultado['id_u'];

        if ($v_usuario == $nombre_u) {
          if ($v_contrasena == $contrasena_u){
            session_start();
            $_SESSION['id_u'] = $v_id_u;
            header("Location: inicio.php");
            //VIAJE A OTRA PAGINA //////////////////////////////////////////////////
            /*header("Location: registro.php?variable=$v_id_u");
            exit;*/
            ///////////////////////////////////////////////////////////////////////
        }else{
          echo "Nombre de usuario no encontrado en la base de datos";
        }}
        
    } else {
        echo "Nombre de usuario no encontrado en la base de datos";
    }
    
}







?>










<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
  <div class="col-md-5">
    <div class="card">
      <div class="card-header text-center">
        <h4>Verificación de usuario</h4>
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
            <input type="submit" value="Siguiente">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<?php include("template/pie.php"); ?>