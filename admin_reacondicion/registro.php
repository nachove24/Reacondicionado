<?php include("template/cabecera.php"); ?>

<?php 
$txtID = ""; // inicializamos la variable con una cadena vacía
if (isset($_POST['txtID'])) {
  $txtID = $_POST['txtID'];
}

$txtMadre = "";
if (isset($_POST['txtMadre'])) {
  $txtMadre = $_POST['txtMadre'];
}

$txtProcesador = "";
if (isset($_POST['txtProcesador'])) {
  $txtProcesador = $_POST['txtProcesador'];
}

$txtNum = "";
$txtTipo = "";
$resultado = "";
if(isset($_POST['txtNum']) && isset($_POST['txtTipo'])) {
  $txtNum = $_POST['txtNum'];
  $txtTipo = $_POST['txtTipo'];
  $resultado = $txtNum . $txtTipo;
}

$txtObs = "";
if (isset($_POST['txtObs'])) {
  $txtObs = $_POST['txtObs'];
}

//SWITCH
//===================================================================================
include("config/bd.php");
//BASE DE DATOS>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
$accion = "";
if (isset($_POST['accion'])) {
  $accion = $_POST['accion'];
}
//INSERT INTO `computadora` (`id`, `madre`, `procesador`, `ram`, `observacion`) VALUES ('1', 'intel 123', 'kingston 123', '4GB', 'No funciona');
switch ($accion) {
  case "Agregar":
    // código para la acción agregar
  
  $sentenciaSQL= $conexion->prepare("INSERT INTO computadora (id,madre,procesador,ram,observacion) VALUES (:id,:madre,:procesador,:ram,:observacion);");
  $sentenciaSQL->bindParam(':id',$txtID);
  $sentenciaSQL->bindParam(':madre', $txtMadre);
  $sentenciaSQL->bindParam(':procesador', $txtProcesador);
  $sentenciaSQL->bindParam(':ram', $resultado);
  $sentenciaSQL->bindParam(':observacion', $txtObs);
  $sentenciaSQL->execute();
  header("Location:registro.php");
    break;

  case "Modificar":
    $sentenciaSQL = $conexion->prepare("UPDATE computadora SET madre=:madre, procesador=:procesador, ram=:ram, observacion=:observacion WHERE id=:id");
	$sentenciaSQL->bindParam(':madre', $txtMadre);
  	$sentenciaSQL->bindParam(':procesador', $txtProcesador);
  	$sentenciaSQL->bindParam(':ram', $resultado);
  	$sentenciaSQL->bindParam(':observacion', $txtObs);
	$sentenciaSQL->bindParam(':id',$txtID);

	$sentenciaSQL->execute();
	header("Location:registro.php");
    break;

  case "Cancelar":
    header("Location:registro.php");
    break;

  case "Seleccionar":
  	$sentenciaSQL= $conexion->prepare("SELECT * FROM computadora WHERE id=:id");
	$sentenciaSQL->bindParam(':id',$txtID);
	$sentenciaSQL->execute();
	$listaEquipos=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

	$txtMadre=$listaEquipos['madre'];
	$txtProcesador=$listaEquipos['procesador'];
	$resultado=$listaEquipos['ram'];
	$txtObs=$listaEquipos['observacion'];
  	break;

  case "Borrar":
  	$sentenciaSQL = $conexion->prepare("DELETE FROM computadora WHERE id = :id");
    $sentenciaSQL->bindParam(':id', $txtID);
    $sentenciaSQL->execute();
    header("Location:registro.php");
  	break;

  default:
    break;
}

$sentenciaSQL= $conexion->prepare("SELECT * FROM computadora");
$sentenciaSQL->execute();
$listaEquipos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);



?>
<br>
<div class="row">
<div class="col-md-5">
	<!-- Formulario de los datos del libro -->
	<div class="card">
		<div class="card-header">
			Datos del equipo
		</div>
		<div class="card-body">

		
<!-- Si no ponemos esto, no se recepcionaran los arch/datos -->	
<form method="POST" enctype="multipart/form-data">
	<fieldset class="form-group">
    	<label for="txtID">ID:</label>
    	<input type="number"  class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="Enter ID" step="1">    
	</fieldset>

	<fieldset class="form-group">
		<label for="txtMadre">Placa Madre:</label>
		<input type="text"  class="form-control" value="<?php echo $txtMadre; ?>" name="txtMadre" id="txtMadre" placeholder="Enter Placa Madre">	
	</fieldset>

<div class="form-part">
	<fieldset class="form-group">
		<label for="txtProcesador">Procesador:</label>
		<input type="text"  class="form-control" value="<?php echo $txtProcesador; ?>" name="txtProcesador" id="txtProcesador" placeholder="Enter Procesador">	
	</fieldset>
	<div style="margin-bottom: 20px;"></div> <!-- Espacio entre los dos contenedores -->
</div>
	
	<div class="form-part">
  		<label for="txtNum">Ingresa la RAM:</label>
 		<input type="text" id="txtNum" value="<?php echo $resultado; ?>" name="txtNum" pattern="[0-9]+">
  		<select name="txtTipo">
    		<option value="KB">KB</option>
    		<option value="MB">MB</option>
    		<option value="GB">GB</option>
    		<option value="TB">TB</option>
  		</select>
  		<div style="margin-bottom: 20px;"></div>
  	</div>
  	

	<fieldset class="form-group">
    	<label for="txtObs">Observación:</label>
    	<textarea class="form-control" name="txtObs" id="txtObs" placeholder="Ingrese observaciones aquí"><?php echo $txtObs; ?></textarea>
	</fieldset>
<br>

	

		<div class="btn-group" role="group" aria-label="">
			<button type="submit" name="accion"  value="Agregar" <?php echo ($accion=="Seleccionar")?"disabled":""; ?> class="btn btn-success">Agregar</button>
			<button type="submit" name="accion"  value="Modificar" <?php echo ($accion!="Seleccionar")?"disabled":""; ?> class="btn btn-warning">Modificar</button>
			<button type="submit" name="accion"  value="Cancelar" <?php echo ($accion!="Seleccionar")?"disabled":""; ?> class="btn btn-info">Cancelar</button>
		</div>
	</form>
			
		</div>
	</div>
</div>

<!--TABLA=====================================================================-->

<div class="col-md-7">
	<!-- Tabla de libros (mostrar los datos de los libros) -->
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>ID</th>
				<th>Placa Madre</th>
				<th>Procesadora</th>
				<th>RAM</th>
				<th>Observacion</th>
				<th>Accion</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($listaEquipos as $computadora) { ?>
			<tr>
				<td><?php echo $computadora['id']; ?></td>
				<td><?php echo $computadora['madre']; ?></td>
				<td><?php echo $computadora['procesador']; ?></td>
				<td><?php echo $computadora['ram']; ?></td>
				<td><?php echo $computadora['observacion']; ?></td>
				<td>

					<form method="post">
					
						<input type="hidden" name="txtID" id="txtID" value="<?php echo $computadora['id']; ?>"/>
						<input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>
						<input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>

					</form>

				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>




</div>
</div>


<?php include("template/pie.php"); ?>