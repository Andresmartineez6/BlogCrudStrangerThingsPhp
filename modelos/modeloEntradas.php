<?php

require_once 'db/conexionDatabase.php';

class Post{

    private $db;


    public function __construct() {
        $database=new DataBase();
        $this->db=$database->conexion();
    }


    //LISTAR ENTRADAS
    public function obtenerTodas() {
        $sentencia = "SELECT e.*, c.nombre AS categoria 
                FROM entradas e 
                LEFT JOIN categorias c ON e.categoria_id = c.id 
                ORDER BY e.creado_en DESC";

        $consulta=$this->db->prepare($sentencia);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);

    }



    //INSERTAR ENTRADA
    public function insertarEntrada($titulo,$contenido,$autor,$categoria_id){

        $sentencia="INSERT INTO entradas (titulo, contenido, autor, categoria_id) VALUES (?, ?, ?, ?)";

        $consulta=$this->db->prepare($sentencia);
        $consulta->execute([$titulo, $contenido, $autor, $categoria_id]);

    }



    //BORRAR ENTRADA
    public function borrarEntrada($id){

        $sentencia="DELETE FROM entradas WHERE id=?";

        $consulta=$this->db->prepare($sentencia);
        $consulta->execute([$id]);

        return $consulta;
    }



    //ACTUALIZAR ENTRADA
    public function actualizarEntrada($titulo,$contenido,$autor,$categoria_id){

        $sentencia = "UPDATE entradas
                        SET titulo=?, contenido=?, autor=?, categoria_id=?
                        WHERE id=?";
        
        $consulta=$this->db->prepare($sentencia);
        $consulta->execute([$titulo,$contenido,$autor,$categoria_id]);

    }
    




    
}