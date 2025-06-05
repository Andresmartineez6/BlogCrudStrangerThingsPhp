<?php

require_once(__DIR__ . "/../db/conexionDatabase.php");


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

        // Verificar si se encontró el usuario
        if($usuario) {
            // Para usuarios existentes que no tienen hash en la contraseña
            if($password === $usuario['password']) {
                return $usuario;
            }
            // Para nuevos usuarios que tienen contraseña con hash
            else if(password_verify($password, $usuario['password'])) {
                return $usuario;
            }
        }

        return false;
    }

    
}