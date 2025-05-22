<?php

require_once 'db/conexionDatabase.php';

class Post {
    private $db;

    public function __construct() {
        $database=new DataBase();
        $this->db=$database->conexion();
    }

    public function obtenerTodas() {
        $sentencia = "SELECT e.*, c.nombre AS categoria 
                FROM entradas e 
                LEFT JOIN categorias c ON e.categoria_id = c.id 
                ORDER BY e.creado_en DESC";

        $consulta=$this->db->prepare($sentencia);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);

    }
}