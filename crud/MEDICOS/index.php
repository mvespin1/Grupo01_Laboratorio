<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>MEDICO MEDICAS</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/05ad9ff252.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="../../Recursos_Crud/css/main.css">
	<link rel="stylesheet" href="../../Recursos_Crud/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../Recursos_Crud/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-dLREj2hcSp1JdRJ3BNtB1Cse4s5Y5IT6GOuP9DPjezy2z1Z+sLhxg5t01TIqHb5a" crossorigin="anonymous">

	<style>
		body {
			background-color: #f1f1f1;
		}

		.home-icon {
			position: fixed;
			top: 20px;
			left: 20px;
			font-size: 24px;
			color: #ec4e22;
		}

		.home-icon-container {
			position: fixed;
			top: 20px;
			left: 20px;
			background-color: #222; 
			padding: 10px; 
			border-radius: 10px; 
   		 }
	</style>

</head>

<body>

	<?php
	require_once("../constantes.php");
	include_once("../clases/class.medicos.php");


	$cn = conectar();
	$v = new medico($cn);

	if (isset($_GET['d'])) {
		$dato = base64_decode($_GET['d']);
		//	echo $dato;exit;
		$tmp = explode("/", $dato);
		$op = $tmp[0];
		$MedicoID = $tmp[1];

		if ($op == "del") {
			echo $v->delete_medico($MedicoID);
		} elseif ($op == "det") {
			echo $v->get_detail_medico($MedicoID);
		} elseif ($op == "new") {
			echo $v->get_form();
		} elseif ($op == "act") {
			echo $v->get_form($MedicoID);
		}

		// PARTE III	
	} else {

		/*echo "<br>PETICION POST <br>";
		echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/

		if (isset($_POST['Guardar']) && $_POST['op'] == "new") {
			$v->save_medico();
		} elseif (isset($_POST['Guardar']) && $_POST['op'] == "update") {
			$v->update_medico();
		} else {
			echo $v->get_list();
		}
	}

	//*******************************************************
	function conectar()
	{
		//echo "<br> CONEXION A LA BASE DE DATOS<br>";
		$c = new mysqli(SERVER, USER, PASS, BD);

		if ($c->connect_errno) {
			die("Error de conexión: " . $c->connect_error);
		} else {
			//echo "La conexión tuvo éxito .......<br><br>";
		}

		$c->set_charset("utf8");
		return $c;
	}
	//**********************************************************	


	?>

	<script>
		window.jQuery || document.write('<script src="../../Recursos_Crud/js/vendor/jquery-1.11.0.min.js"><\/script>')
	</script>

	<script src="../../Recursos_Crud/js/vendor/bootstrap.min.js"></script>

	<script src="../../Recursos_Crud/js/main.js"></script>
	<script src="../../Recursos_Crud/js/main2.js"></script>
	<script src="../../Recursos_Crud/js/funciones.js"></script>

</body>

</html>