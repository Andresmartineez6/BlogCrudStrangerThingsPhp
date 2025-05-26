<?php

session_start(); 
require_once __DIR__ . '/../modelos/modeloUsuario.php';

$error = "";

if(isset($_POST["enviar"])){
    $email = trim($_POST['email']);
    $contrasena = trim($_POST['contrasena']);

    $usuarioModelo = new Usuario();
    $usuario = $usuarioModelo->autenticar($email, $contrasena);

    if($usuario){
        $_SESSION['usuario'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['rol'];

        header("Location: ../vistas/dashboardBlog.php");
        exit;

    }else{
        $error="Correo o contraseña incorrectos.";
    }
}

require __DIR__ . '/../vistas/vistaLogin.php';