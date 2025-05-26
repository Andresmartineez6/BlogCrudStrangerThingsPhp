<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>RAZER</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap" rel="stylesheet">
</head>

<body>


    <form action="#" method="POST">

        <label for="correo">INTRODUCE TU CORREO:</label>
        <input type="text" name="correo" placeholder="Email">
        <br>
        <label for="contrasena"></label>
        <input type="text" name="contrasena" placeholder="Contraseña">
        <br>
        <input type="submit" name="enviar" value="aceptar"> 

    </form>


    <?php

        require_once("./db/conexionDatabase.php");
        require_once("./modelos/modeloUsuario.php");

        if(isset($_POST["enviar"])){
            $error="";

            $correoUsuario = trim($_POST["correo"]);
            $contrasenaUsuario = trim($_POST["contrasena"]);
            
    
            $usuarioModelo = new Usuario();
            $usuario = $usuarioModelo->autenticar($correoUsuario, $contrasenaUsuario);
    
            if($usuario){
                $_SESSION['usuario'] = $usuario['nombre'];
                $_SESSION['rol'] = $usuario['rol'];
    
                header("Refresh:1; url=dashboardBlog.php");
                ?> <h2>Redireccionando...</h2> <?php
                exit;
    
            }else{
                $error="Correo o contraseña incorrectos.";
            }

        }

    
    ?>


</body>
</html>