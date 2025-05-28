    <?php

        require_once("./db/conexionDatabase.php");
        require_once("./modelos/modeloUsuario.php");

        session_start();


        if(isset($_POST["enviar"])){


            $correoUsuario = trim($_POST["correo"]);
            $contrasenaUsuario = trim($_POST["contrasena"]);


            if($correoUsuario != "" && $contrasenaUsuario != ""){

                $usuarioModelo = new Usuario();
                $usuario = $usuarioModelo->autenticar($correoUsuario,$contrasenaUsuario);
        

                if($usuario){

                    $_SESSION['usuario'] = $usuario['nombre'];
                    $_SESSION['rol'] = $usuario['rol'];

                                        
                    if(!empty($_POST["recuerdame"])){

                        setcookie("sesion", session_encode(), time() + 7 * 24 * 60 * 60, "/");
                    }
        
                    header("Location: ./dashboardBlog.php");
                    
                    exit;
        
                }
                        
            }else{
                header("Location: ./index.php");
                    
                ?> <h2>Login fallido...</h2> <?php
            }

        }

    
    ?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>RAZER</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>


    <form action="index.php" method="POST" class="">

        <label for="correo">INTRODUCE TU CORREO:</label>
        <br>
        <input type="text" name="correo" placeholder="Email">
        <br>
        <br>
        <label for="contrasena"></label>
        <label for="contrasena">INTRODUCE TU CONTRASEÑA:</label>
        <br>
        <input type="password" name="contrasena" placeholder="Contraseña">
        <br>
        <br>
        <label for="recuerdame">Recuerdame:</label>
        <input type="checkbox" name="recuerdame" id="recuerdame">
        <br>
        <input type="submit" name="enviar" value="aceptar"> 

    </form>


</body>
</html>