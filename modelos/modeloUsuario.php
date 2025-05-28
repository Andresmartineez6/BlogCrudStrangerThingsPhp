<?php

require_once("db/conexionDatabase.php");


class Usuario{

    private $db;

    
    public function __construct() {
        $database=new DataBase();
        $this->db=$database->conexion();
    }



    public function autenticar($email, $password) {
        $sentencia = "SELECT * FROM usuarios WHERE email = ?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->execute([$email]);
        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

        //verifico si se encontró el usuario y si la contraseña coincide
        if($usuario && $password === $usuario['password']) {
            return $usuario;
        }

        return false;
    }

    
}