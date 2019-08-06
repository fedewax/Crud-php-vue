<?php
	
	$metodo = $_SERVER["REQUEST_METHOD"];
	//$ruta = implode("/", array_slice(explode("/", $_SERVER["REQUEST_URI"]), 3));

	//$datos = json_decode(file_get_contents("php://input"));
	
	switch($metodo)
	{
		case 'GET':
			
			require_once "controlador.php";

			$r = (new Controlador)->listarUsuarios();
			echo json_encode($r);

		break;

	}
?>