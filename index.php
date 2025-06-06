    
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

                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['usuario_nombre'] = $usuario['nombre'];
                    $_SESSION['usuario_rol'] = $usuario['rol'];

                                        
                    if(!empty($_POST["recuerdame"])){

                        setcookie("sesion", session_encode(), time() + 7 * 24 * 60 * 60, "/");
                    }
        
                    header("Location: ./blog.php");
                    
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Stranger Things</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body class="netflix-bg">


    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 login-container p-8">
            <div>
                <h1 class="text-center font-extrabold stranger-title flicker">
                    <img src="assets/imgs/logo.png" alt="Stranger Things" class="mx-auto logo-image">
                </h1>
                <p class="mt-2 text-center text-sm text-gray-400">Tu portal al mundo del revés</p>
                <h2 class="mt-6 text-center text-2xl font-bold text-white">Inicia sesión en tu cuenta</h2>
            </div>
            


            <?php if (isset($error)): ?>
                <div class="bg-red-600 text-white p-3 rounded">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            

            <form class="mt-8 space-y-6" method="POST">
                <input type="hidden" name="enviar" value="1">
                <div class="space-y-4">
                    <div>
                        <label for="correo" class="text-sm text-gray-300 block mb-1">Email</label>
                        <input id="correo" name="correo" type="email" required class="netflix-input w-full" placeholder="Email">
                    </div>
                    <div>
                        <label for="contrasena" class="text-sm text-gray-300 block mb-1">Contraseña</label>
                        <input id="contrasena" name="contrasena" type="password" required class="netflix-input w-full" placeholder="Contraseña">
                    </div>
                </div>

                <div class="flex items-center mt-4">
                    <div class="flex items-center">
                        <input id="recuerdame" name="recuerdame" type="checkbox" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-700 rounded bg-gray-800">
                        <label for="recuerdame" class="ml-2 block text-sm text-gray-300">
                            Recuérdame
                        </label>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 text-base font-bold rounded-md text-white btn-netflix">
                        INICIAR SESIÓN
                    </button>
                </div>
            </form>
            

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-400">¿Nuevo en Stranger Things? <a href="registro.php" class="netflix-link">Regístrate ahora</a></p>
            </div>

        </div>
    </div>


</body>
</html>