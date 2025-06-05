

<?php


class DataBase{

    // Parámetros de la base de datos
    private $host = "localhost"; 
    private $db_name = "stranger_things_blog";
    private $username = "root";
    private $password = "";
    public $db;
 
    // Obtener la conexión a la base de datos
    public function conexion(){

        $this->db=null;
 
        try{

             $this->db = new PDO(
                 "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                 $this->username,
                 $this->password
             );

             $this->db->exec("set names utf8");
             $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $e){
             echo "Error de conexión: " . $e->getMessage();
        }
 
        return $this->db;
    }


}




?>