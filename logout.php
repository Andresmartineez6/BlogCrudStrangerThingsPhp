

<?php

    // Iniciar la sesión
    session_start();


    // Destruir todas las variables de sesión
    $_SESSION = array();


    // Si se desea destruir la cookie de sesión
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }


    // Eliminar la cookie de "recuérdame"
    if (isset($_COOKIE["sesion"])) {
        setcookie("sesion", "", time() - 3600, "/");
    }


    // Finalmente, destruir la sesión
    session_destroy();


    // Redireccionar al inicio
    header("Location: index.php");
    exit;


?>
