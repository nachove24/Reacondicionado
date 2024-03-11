<?php include("template/cabecera.php"); ?>

<br>
<div class="col-md-3 text-center" style="margin: 0 auto;">
	<div class="card">
		<div class="card-header">
    		<h4>Buscador</h4>
    	</div>
   		<div class="card-body">
			<form method="post">
				<label for="id">ID usuario:</label>
				<input type="number" required name="id" id="id">
				<button type="submit" name="accion" value="buscar">Buscar</button>
				<!--<button type="submit" name="volver" value="volver">Volver</button>-->
			</form>
		<div class="card-footer" style="border-top: 1px solid #ccc; background-color: #f9f9f9; padding: 10px;">
			<form method="post">
				<button type="submit" name="accion" value="volver">Volver</button>
			</form>
		</div>
		</div>
	</div>
</div>
<br>
<?php 


$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";



switch ($accion) {
	case 'volver':
	
	header("Location:listar.php");
		break;

	case 'buscar':
		?>
		<table class="table table-bordered">
	<thead>
		<tr>
			<th>ID</th>
			<th>Placa Madre</th>
			<th>Procesador</th>
			<th>RAM</th>
			<th>Observaciones</th>
			<th>ID usuario</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php
		// Incluir archivo de conexión
		include("config/bd.php");

		// Verificar si se ha enviado el formulario
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			// Obtener el ID ingresado
			$id = $_POST["id"];

			// Consulta SQL filtrada por ID
			$sql = "SELECT * FROM computadora WHERE id_u = $id";
			$resultado = $conexion->query($sql);

			// Verificar si hay resultados
			if ($resultado->rowCount() > 0) {
				// Mostrar el registro correspondiente al ID ingresado
				$fila = $resultado->fetch();
				echo "<tr>";
				echo "<td>" . $fila["id"] . "</td>";
				echo "<td>" . $fila["madre"] . "</td>";
				echo "<td>" . $fila["procesador"] . "</td>";
				echo "<td>" . $fila["ram"] . "</td>";
				echo "<td>" . $fila["observacion"] . "</td>";
				echo "<td>" . $fila["id_u"] . "</td>";
				echo "<td>";
				echo "<form method='post'>";
				echo "<input type='hidden' name='id' value='" . $fila["id"] . "'>";
				echo "<button type='submit' name='borrar' value='borrar' class='btn btn-danger'>Borrar</button>";
				echo "</form>";
				echo "</td>";
				echo "</tr>";
			} else {
				// Mostrar mensaje de que no se encontró el registro
				echo "<tr><td colspan='6'>No se encontró el registro con ID $id.</td></tr>";
			}
		}
	?>
	</tbody>
</table>
<?php
		break;
	
	default:
		include("config/bd.php");

// Consulta SQL para obtener todos los registros
$sql = "SELECT * FROM computadora";
$resultado = $conexion->query($sql);

// Obtener todos los registros
$registros = $resultado->fetchAll();

?>
		<table class="table table-bordered">
	<thead>
		<tr>
			<th>ID</th>
			<th>Placa Madre</th>
			<th>Procesador</th>
			<th>RAM</th>
			<th>Observaciones</th>
			<th>ID Usuario</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php
		// Iterar sobre todos los registros
		foreach ($registros as $fila) {
			echo "<tr>";
			echo "<td>" . $fila["id"] . "</td>";
			echo "<td>" . $fila["madre"] . "</td>";
			echo "<td>" . $fila["procesador"] . "</td>";
			echo "<td>" . $fila["ram"] . "</td>";
			echo "<td>" . $fila["observacion"] . "</td>";
			echo "<td>" . $fila["id_u"] . "</td>";
			echo "<td>";
			echo "<form method='post'>";
			echo "<input type='hidden' name='id' value='" . $fila["id"] . "'>";
			echo "<button type='submit' name='borrar' value='borrar' class='btn btn-danger'>Borrar</button>";
			echo "</form>";
			echo "</td>";
			echo "</tr>";
		}
		?>
	</tbody>
</table>
	<?php
		break;
}


$borrar= (isset($_POST['borrar'])) ? $_POST['borrar'] : "";

if ($borrar=="borrar"){
	include("config/bd.php");
	$txtID = (isset($_POST['id'])) ? $_POST['id'] : "";
	$sentenciaSQL = $conexion->prepare("DELETE FROM computadora WHERE id_u = :id");
    $sentenciaSQL->bindParam(':id_u', $txtID);
    $sentenciaSQL->execute();
   

	header("Location:listar.php");
}else{

}








?>










<?php include("template/pie.php"); ?>