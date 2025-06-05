<?php

require_once __DIR__ . '/../db/conexionDatabase.php';

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
    public function insertarEntrada($titulo, $contenido, $autor, $categoria_id, $imagen = null){

        $sentencia="INSERT INTO entradas (titulo, contenido, autor, categoria_id, imagen) VALUES (?, ?, ?, ?, ?)";

        $consulta=$this->db->prepare($sentencia);
        $consulta->execute([$titulo, $contenido, $autor, $categoria_id, $imagen]);
        
        return $this->db->lastInsertId();
    }



    //BORRAR ENTRADA
    public function borrarEntrada($id){

        $sentencia="DELETE FROM entradas WHERE id=?";

        $consulta=$this->db->prepare($sentencia);
        $consulta->execute([$id]);

        return $consulta;
    }



    //ACTUALIZAR ENTRADA
    public function actualizarEntrada($id, $titulo, $contenido, $autor, $categoria_id, $imagen = null){
        
        // Si la imagen es null, no actualizamos ese campo para no sobreescribir la imagen existente
        if ($imagen === null) {
            $sentencia = "UPDATE entradas
                        SET titulo=?, contenido=?, autor=?, categoria_id=?
                        WHERE id=?";
            
            $consulta=$this->db->prepare($sentencia);
            $consulta->execute([$titulo, $contenido, $autor, $categoria_id, $id]);
        } else {
            $sentencia = "UPDATE entradas
                        SET titulo=?, contenido=?, autor=?, categoria_id=?, imagen=?
                        WHERE id=?";
            
            $consulta=$this->db->prepare($sentencia);
            $consulta->execute([$titulo, $contenido, $autor, $categoria_id, $imagen, $id]);
        }

        return $consulta;
    }
    



    //OBTENER CATEGORIAS
    public function obtenerCategorias() {
        $sentencia = "SELECT * FROM categorias";

        $consulta=$this->db->prepare($sentencia);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }



    //OBTENER ENTRADA POR ID
    public function obtenerPorId($id) {
        $sentencia = "SELECT e.*, c.nombre AS categoria 
                FROM entradas e 
                LEFT JOIN categorias c ON e.categoria_id = c.id 
                WHERE e.id = ?";

        $consulta=$this->db->prepare($sentencia);
        $consulta->execute([$id]);
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }
    




    
}