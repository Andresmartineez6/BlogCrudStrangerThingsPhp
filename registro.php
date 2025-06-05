<?php


    // Incluir archivo de conexión a la base de datos
    require_once("./db/conexionDatabase.php");


    // Inicializar variables
    $error = '';
    $success = '';


    // Procesar el formulario cuando se envía
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nombre = trim($_POST['nombre']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);
        

        // Validaciones básicas
        if (empty($nombre) || empty($email) || empty($password)) {

            $error = 'Por favor, completa todos los campos.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $error = 'Por favor, introduce un email válido.';
        } elseif (strlen($password) < 6) {

            $error = 'La contraseña debe tener al menos 6 caracteres.';
        } elseif ($password !== $confirm_password) {

            $error = 'Las contraseñas no coinciden.';
        } else {

            try {
                // Crear instancia de la conexión a la base de datos
                $database = new DataBase();
                $db = $database->conexion();
                
                // Verificar si el email ya existe
                $stmt = $db->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
                $stmt->execute([$email]);
                
                if ($stmt->fetchColumn() > 0) {
                    $error = 'Este email ya está registrado. Por favor, utiliza otro o inicia sesión.';
                } else {
                    // Hash de contraseña
                    $password_hash = password_hash($password, PASSWORD_DEFAULT);
                    
                    // Insertar usuario en la base de datos - rol 2 es usuario normal
                    $stmt = $db->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, 2)");
                    
                    if ($stmt->execute([$nombre, $email, $password_hash])) {
                        $success = 'Registro exitoso. Ahora puedes <a href="index.php" class="text-red-500 underline">iniciar sesión</a>.';
                    } else {
                        $error = 'Ocurrió un error. Por favor, inténtalo de nuevo.';
                    }
                }
            } catch (Exception $e) {
                $error = 'Error de conexión a la base de datos: ' . $e->getMessage();
            }
            
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Stranger Things</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        @font-face {
            font-family: 'Netflix Sans';
            src: url('https://assets.nflxext.com/ffe/siteui/fonts/netflix-sans/v3/NetflixSans_W_Rg.woff2') format('woff2');
            font-weight: normal;
            font-style: normal;
        }
        
        @font-face {
            font-family: 'Netflix Sans';
            src: url('https://assets.nflxext.com/ffe/siteui/fonts/netflix-sans/v3/NetflixSans_W_Bd.woff2') format('woff2');
            font-weight: bold;
            font-style: normal;
        }
        
        body {
            font-family: 'Netflix Sans', sans-serif;
        }
        
        .netflix-bg {
            background-color: black;
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                             url("assets/imgs/temporada 5 stranger things.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .login-container {
            background-color: rgba(0, 0, 0, 0.85);
            border-radius: 4px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.7);
        }

        .btn-netflix {
            background-color: #E50914;
            transition: all 0.2s ease;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .btn-netflix:hover {
            background-color: #F40612;
        }

        .netflix-input {
            background-color: #333;
            border: none;
            color: white;
            padding: 16px 20px;
            border-radius: 4px;
        }

        .netflix-input:focus {
            background-color: #454545;
            outline: none;
        }
        
        .stranger-title {
            font-family: 'Bebas Neue', sans-serif;
            color: #E50914;
            letter-spacing: 2px;
            text-shadow: 0 0 20px rgba(229, 9, 20, 0.7);
        }
    </style>
</head>

<body class="netflix-bg">

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 login-container p-8">
            <div>
                <h1 class="text-center font-extrabold stranger-title flicker">
                    <img src="assets/imgs/logo.png" alt="Stranger Things" class="mx-auto" style="height: 80px; width: auto; max-width: 280px; object-fit: contain;">
                </h1>
                <p class="mt-2 text-center text-sm text-gray-400">Únete al mundo del revés</p>
                <h2 class="mt-6 text-center text-2xl font-bold text-white">Crea tu cuenta</h2>
            </div>
            
            <?php if (!empty($error)): ?>
                <div class="bg-red-600 text-white p-3 rounded">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="bg-green-600 text-white p-3 rounded">
                    <?php echo $success; ?>
                </div>
            <?php else: ?>
                <form class="mt-8 space-y-6" method="POST">
                    <div class="rounded-md -space-y-px">
                        <div class="mb-4">
                            <div class="flex items-center text-sm text-gray-400 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <label for="nombre">Nombre completo</label>
                            </div>
                            <input id="nombre" name="nombre" type="text" required class="netflix-input appearance-none border border-gray-700 rounded-md relative block w-full px-3 py-2 placeholder-gray-500 focus:outline-none focus:ring-red-500 focus:border-red-500" placeholder="Nombre completo">
                        </div>
                        <div class="mb-4">
                            <div class="flex items-center text-sm text-gray-400 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <label for="email">Correo electrónico</label>
                            </div>
                            <input id="email" name="email" type="email" required class="netflix-input appearance-none border border-gray-700 rounded-md relative block w-full px-3 py-2 placeholder-gray-500 focus:outline-none focus:ring-red-500 focus:border-red-500" placeholder="Email">
                        </div>
                        <div class="mb-4">
                            <div class="flex items-center text-sm text-gray-400 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <label for="password">Contraseña</label>
                            </div>
                            <input id="password" name="password" type="password" required class="netflix-input appearance-none border border-gray-700 rounded-md relative block w-full px-3 py-2 placeholder-gray-500 focus:outline-none focus:ring-red-500 focus:border-red-500" placeholder="Contraseña (mínimo 6 caracteres)">
                        </div>
                        <div class="mb-4">
                            <div class="flex items-center text-sm text-gray-400 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <label for="confirm_password">Confirmar contraseña</label>
                            </div>
                            <input id="confirm_password" name="confirm_password" type="password" required class="netflix-input appearance-none border border-gray-700 rounded-md relative block w-full px-3 py-2 placeholder-gray-500 focus:outline-none focus:ring-red-500 focus:border-red-500" placeholder="Confirmar contraseña">
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn-netflix group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            REGISTRARSE
                        </button>
                    </div>
                </form>
            <?php endif; ?>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-400">¿Ya tienes cuenta? <a href="index.php" class="text-red-500 hover:text-red-400">Iniciar sesión</a></p>
            </div>
        </div>
    </div>

</body>
</html>
