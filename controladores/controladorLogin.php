<?php

require_once __DIR__ . '/../modelos/modeloUsuario.php';


class ControladorLogin{

    public function login(){

        require_once __DIR__ . '/../config/sesion.php';


        $error = "";

        if($_SERVER['REQUEST_METHOD']==='POST'){

            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $usuarioModel=new Usuario();
            $usuario=$usuarioModel->autenticar($email, $password);

            if($usuario){
                $_SESSION['usuario'] = $usuario['nombre'];
                $_SESSION['rol'] = $usuario['rol'];

                header("Location: dashboardBlog.php");
                exit;

            }else{
                $error="Correo o contraseña incorrectos.";
            }

        }

        require __DIR__ . '/../vistas/vistaLogin.php';
        
    }
}