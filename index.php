<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>BLOG RAZER</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap" rel="stylesheet">

  <style>    
    body {
      background: #0f0f0f;
      color: #d1d5db;
      font-family: 'Orbitron', sans-serif;
    }
    .razer-gradient {
      background: linear-gradient(90deg, #00ff00, #00cc66);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
  </style>
</head>

<body class="min-h-screen px-6 py-10">


    <?php
    
        require_once 'config/sesion.php';

        if (isset($_SESSION['usuario'])) {
            require_once __DIR__ . '/controladores/controladorEntradas.php';
            $controlador = new ControladorEntradas();
            $controlador->listarEntradas();
        } else {
            require_once __DIR__ . '/controladores/controladorLogin.php';
            $controlador = new ControladorLogin();
            $controlador->login();
            
            // Detener la ejecución aquí para evitar que se muestre el resto
            exit;
        }
    ?>



    <!-- Este contenido solo se mostrará si el usuario está logueado -->
    <?php if (isset($entradas) && is_array($entradas)): ?>
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach($entradas as $entrada): ?>
        <article class="bg-[#1a1a1a] p-6 rounded-lg shadow-lg hover:scale-105 transition duration-300 ease-in-out">
            <h2 class="text-2xl font-bold text-green-400 mb-2"><?= htmlspecialchars($entrada['titulo']) ?></h2>
            <p class="text-sm text-gray-500"><?= substr(strip_tags($entrada['contenido']), 0, 100) . '...' ?></p>
            <div class="mt-4 flex justify-between text-xs text-gray-400">
                <span><?= htmlspecialchars($entrada['autor']) ?></span>
                <span><?= date('d M Y', strtotime($entrada['creado_en'])) ?></span>
            </div>
            <a href="/entrada?id=<?= $entrada['id'] ?>" class="block mt-4 text-green-500 hover:underline">Leer más</a>
        </article>
        <?php endforeach; ?>
    </section>
    <?php endif; ?>



    <footer class="mt-16 text-center text-gray-500 text-sm">
        &copy; <?= date("Y") ?> Razer Gaming. Powered by PHP + TailwindCSS + GSAP.
    </footer>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script>
    gsap.from("article", {
        y: 30,
        opacity: 0,
        duration: 0.8,
        stagger: 0.2
    });
    </script>


</body>
</html>