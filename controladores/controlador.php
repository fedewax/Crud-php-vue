<?php
$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

switch($metodo)
{
	case 'GET':
		$r = Controlador::listarUsuarios();
	break;

	case 'POST':
		if(!empty($datos->id_borrar))
			Controlador::eliminarUsuarios($datos->id_borrar);
		
		if(!empty($datos->nombre_a))
			Controlador::agregarUsuarios($datos);
	
		if(!empty($datos->id))
			Controlador::editarUsuarios($datos);
	break;
}

class Controlador
{
	public static function listarUsuarios()
	{
		require_once "../modelos/modelo.php";
		$r = Modelo::listarUsuariosM();
		echo json_encode($r);
	}

	public static function eliminarUsuarios($id)
	{
		require_once "../modelos/modelo.php";
		$r = Modelo::eliminarUsuariosM($id);
		echo json_encode($r);
	}

	public static function agregarUsuarios($datos)
	{
		require_once "../modelos/modelo.php";
		$r = Modelo::agregarUsuariosM($datos);
		echo json_encode($r);
	}

	public static function editarUsuarios($datos)
	{
		require_once "../modelos/modelo.php";
		$r = Modelo::editarUsuariosM($datos);
		echo json_encode($r);
	}
}

?>