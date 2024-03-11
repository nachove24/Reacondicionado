<?php include("template/cabecera.php"); ?>
<?php 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    session_destroy(); 

    header("Location: index.php");
    exit;
}
?>



<form method="post" style="padding: 5px;">
	<h2>Quieres cerrar sesión?</h2>
	<input type="submit" name="Cerrar" value="Cerrar" style="margin-left: 5px;">


</form>

	
<?php include("template/pie.php"); ?>