<?php include("template/cabecera.php"); ?>

<?php session_start();
$id_u = $_SESSION['id_u'];
echo "id usuario: " . $id_u;  ?>

<br>
<div class="col-md-3 text-center" style="margin: 0 auto;">
	<div class="card">
		<div class="card-header">
    		<h4>Buscador</h4>
    	</div>
   		<div class="card-body">
			<form method="post">
				<!--<label for="id">ID:</label>-->
		<select name="txtTipo">
    		<option value="id">ID:</option>
    		<option value="madre">Placa Madre:</option>
    		<option value="ram">RAM:</option>
    		<option value="procesador">Procesador:</option>
  		</select>

				<input type="text" required name="search" id="search">
				<br>
				<button type="submit" name="accion" value="buscar" style="margin-top: 5px;">Buscar</button>
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
			// Obtener el valor de búsqueda
$search = $_POST["search"];

// Validar y tratar el valor según el tipo de búsqueda
$txtTipo = $_POST["txtTipo"];

switch ($txtTipo) {
    case 'id':
        // Tratar como número si es un ID
        $int = intval($search);
        $consulta = "SELECT * FROM computadora WHERE id = $int AND id_u = $id_u";
        break;
    case 'madre':
        // Tratar como cadena (entre comillas simples) si es una placa madre
        $search = $conexion->quote($search);
        $consulta = "SELECT * FROM computadora WHERE madre = $search AND id_u = $id_u";
        break;
    case 'procesador':
        // Tratar como cadena (entre comillas simples) si es un procesador
        $search = $conexion->quote($search);
        $consulta = "SELECT * FROM computadora WHERE procesador = $search AND id_u = $id_u";
        break;
    case 'ram':
        // Tratar como cadena (entre comillas simples) si es RAM
        $search = $conexion->quote($search);
        $consulta = "SELECT * FROM computadora WHERE ram = $search AND id_u = $id_u";
        break;
}


			// Consulta SQL filtrada por ID
			//$sql = "SELECT * FROM computadora WHERE id = $id AND id_u = $id_u";
			$sql = $consulta;
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
				echo "<td>";
				echo "<form method='post'>";
				echo "<input type='hidden' name='id' value='" . $fila["id"] . "'>";
				echo "<button type='submit' name='borrar' value='borrar' class='btn btn-danger'>Borrar</button>";
				echo "</form>";
				echo "</td>";
				echo "</tr>";
			} else {
				// Mostrar mensaje de que no se encontró el registro
				echo "<tr><td colspan='6'>No se encontró el registro $search.</td></tr>";
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
$sql = "SELECT * FROM computadora WHERE id_u = :id_u";
$resultado = $conexion->prepare($sql);
$resultado->bindParam(":id_u", $id_u, PDO::PARAM_INT);
$resultado->execute();
//$resultado = $conexion->query($sql);

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
	$sentenciaSQL = $conexion->prepare("DELETE FROM computadora WHERE id = :id");
    $sentenciaSQL->bindParam(':id', $txtID);
    $sentenciaSQL->execute();
   

	header("Location:listar.php");
}else{

}








?>










<?php include("template/pie.php"); ?>