<?php 
class Conexion
{
	protected static function conectar()
	{
		try
		{
    		return new PDO("mysql:host=localhost; dbname=test", "root", "");
		}
		catch(PDOException $e) 
		{
    		echo 'Falló la conexión: ' . $e->getMessage();
		}
	
	}
}

class Modelo extends Conexion
{
	public static function listarUsuariosM()
	{
		static $tabla = "usuarios";
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt->close();
	}

	public static function agregarUsuariosM($datos)
	{
		static $tabla = "usuarios";
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre, edad) VALUES (:nombre, :edad)");    

        $stmt->bindParam(":nombre", $datos->nombre_a, PDO::PARAM_STR);
        $stmt->bindParam(":edad", $datos->edad, PDO::PARAM_INT);
       
        if($stmt->execute())
			return true;
			
        $stmt->close();
	}

	public static function editarUsuariosM($datos)
	{
		static $tabla = "usuarios";
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, edad = :edad  WHERE id = :id");

        $stmt->bindParam(":nombre", $datos->nombre, PDO::PARAM_STR);
        $stmt->bindParam(":edad", $datos->edad, PDO::PARAM_STR);
        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

        if($stmt->execute())
			return true;
        //cerrar la conexion con la base de datos
        $stmt->close();
	}
	public static function eliminarUsuariosM($id)
    {
		static $tabla = "usuarios";
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

		if($stmt->execute())
			return true;
        
        $stmt->close();
    }
}
?>