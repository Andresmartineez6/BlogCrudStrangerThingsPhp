

<?php

    session_start();
    require_once(__DIR__ . "/db/conexionDatabase.php");
    require_once(__DIR__ . "/modelos/modeloEntradas.php");

    
    // Instanciar el modelo de entradas
    $modeloEntradas = new Post();


    // Obtener todas las entradas
    $entradas = $modeloEntradas->obtenerTodas();


    // Obtener entrada individual si se solicita
    $entradaIndividual=null;
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $entradaIndividual = $modeloEntradas->obtenerPorId($id);
    }
    

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stranger Things | Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body class="blog-bg text-white min-h-screen">



    <!-- Barra de navegación -->
    <nav class="bg-black border-b border-red-600 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="stranger-title">
                        <img src="assets/imgs/logo.png" alt="Stranger Things" class="logo-image">
                    </h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="blog.php" class="px-3 py-2 text-sm font-medium text-white hover:text-gray-300 transition-colors">Inicio</a>
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <a href="dashboardBlog.php" class="px-3 py-2 text-sm font-medium text-white hover:text-gray-300 transition-colors">Dashboard</a>
                        <a href="logout.php" class="inline-block px-4 py-2 text-sm bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-md">Cerrar sesión</a>
                    <?php else: ?>
                        <a href="index.php" class="inline-block px-4 py-2 text-sm btn-netflix text-white font-bold rounded-md">Iniciar sesión</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>



    <!-- Contenido principal -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <?php if ($entradaIndividual): ?>
            <!-- Vista de entrada individual -->
            <div class="mb-6">
                <a href="blog.php" class="text-red-600 hover:text-red-500 flex items-center space-x-2 netflix-link mb-4 inline-block transition-transform hover:-translate-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Volver al listado</span>
                </a>
            </div>
            



            <article class="mb-12">

                <!-- Cabecera del articulo con imagen hero -->
                <div class="relative rounded-lg overflow-hidden mb-8 h-96">
                    <?php
                    // Usamos la imagen específica si existe, o una imagen predeterminada si no
                    $heroImages = ['stranger-things-4k-d22h0coz6j6ph0e7.jpg', 'temporada 5 stranger things.jpg', 'dustin.jpg', 'eleven.jpg', 'stranger-things-bg.jpg'];
                    $heroIndex = (isset($entradaIndividual['id'])) ? $entradaIndividual['id'] % count($heroImages) : 0;
                    
                    if (!empty($entradaIndividual['imagen'])) {
                        // Usar la imagen específica del post
                        $imageSrc = "descargaImagenes/" . $entradaIndividual['imagen'];
                    } else {
                        // Usar una imagen aleatoria predeterminada
                        $imageSrc = "assets/imgs/" . $heroImages[$heroIndex];
                    }
                    ?>
                    <img src="<?php echo $imageSrc; ?>" alt="<?php echo htmlspecialchars($entradaIndividual['titulo']); ?>" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 md:p-10">
                        <span class="post-category px-3 py-1 rounded-md text-xs font-bold uppercase mb-4 inline-block">
                            <?php echo htmlspecialchars($entradaIndividual['categoria']); ?>
                        </span>
                        <h1 class="text-3xl md:text-4xl xl:text-5xl font-bold stranger-title text-white mb-4 leading-tight">
                            <?php echo htmlspecialchars($entradaIndividual['titulo']); ?>
                        </h1>
                        <div class="flex items-center text-sm text-gray-300">
                            <span class="font-medium">Por <?php echo htmlspecialchars($entradaIndividual['autor']); ?></span>
                            <span class="mx-2">•</span>
                            <span><?php echo date('d/m/Y', strtotime($entradaIndividual['creado_en'])); ?></span>
                        </div>
                    </div>
                </div>
                

                <!-- Contenido del artículo -->
                <div class="post-card shadow overflow-hidden rounded-lg p-8">
                    <div class="prose prose-invert prose-headings:stranger-title prose-headings:text-red-600 prose-a:text-red-500 max-w-none">
                        <?php 
                        // Dividimos el contenido en párrafos
                        $paragraphs = explode("\n\n", $entradaIndividual['contenido']);
                        
                        // Insertamos una imagen estilo pull-quote después del segundo párrafo si hay suficientes párrafos
                        foreach ($paragraphs as $index => $paragraph) {
                            echo '<p class="mb-6 text-gray-200 leading-relaxed">' . nl2br(htmlspecialchars($paragraph)) . '</p>';
                            
                            // Después del segundo párrafo, insertamos una cita visual
                            if ($index === 1 && count($paragraphs) > 3) {
                                $quotes = [
                                    "Las cosas se están poniendo extrañas. De nuevo.",
                                    "No me gusta cuando las cosas cambian. Y de repente todo está cambiando.",
                                    "No soy un monstruo.",
                                    "Amigos no mienten.",
                                    "Yo cierro puertas, no las abro."
                                ];
                                $randomQuote = $quotes[array_rand($quotes)];
                                echo '<div class="my-8 border-l-4 border-red-600 pl-6 py-2">';                          
                                echo '<p class="text-xl md:text-2xl text-red-600 italic font-semibold">"' . $randomQuote . '"</p>';                          
                                echo '</div>';
                            }
                            
                            // Después del cuarto párrafo, insertamos una imagen
                            if ($index === 3 && count($paragraphs) > 5) {
                                $pullImages = ['dustin.jpg', 'eleven.jpg'];
                                $pullIndex = (isset($entradaIndividual['id'])) ? ($entradaIndividual['id'] + 1) % count($pullImages) : 0;
                                echo '<div class="my-12 rounded-lg overflow-hidden">';                          
                                echo '<img src="assets/imgs/' . $pullImages[$pullIndex] . '" alt="Stranger Things" class="w-full h-64 object-cover">';                          
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    
                    <!-- Etiquetas relacionadas -->
                    <div class="mt-10 pt-6 border-t border-gray-800">
                        <div class="flex flex-wrap gap-2">
                            <span class="text-sm text-gray-400 mr-2">Tags:</span>
                            <a href="#" class="px-3 py-1 bg-gray-900 text-xs text-gray-300 rounded-full hover:bg-gray-800 transition">#StrangerThings</a>
                            <a href="#" class="px-3 py-1 bg-gray-900 text-xs text-gray-300 rounded-full hover:bg-gray-800 transition">#Netflix</a>
                            <a href="#" class="px-3 py-1 bg-gray-900 text-xs text-gray-300 rounded-full hover:bg-gray-800 transition">#<?php echo str_replace(' ', '', htmlspecialchars($entradaIndividual['categoria'])); ?></a>
                        </div>
                    </div>
                </div>
            </article>
            


            <!-- Artículos relacionados -->
            <div class="mb-10">
                <h3 class="text-2xl font-bold mb-6 stranger-title">MÁS HISTORIAS</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php 
                    // Mostrar hasta 3 entradas relacionadas (excluimos la entrada actual)
                    if (!empty($entradas)) {
                        $count = 0;
                        foreach ($entradas as $entrada) {
                            if ($entrada['id'] != $entradaIndividual['id'] && $count < 3) {
                                $count++;
                    ?>
                    <div class="post-card rounded-lg overflow-hidden hover:shadow-xl transform transition-transform duration-300 hover:scale-105 flex flex-col h-full">
                        <?php 
                        // Pseudo-random image selection
                        $relatedImages = ['dustin.jpg', 'eleven.jpg', 'stranger-things-bg.jpg'];
                        $imgIndexRelated = $entrada['id'] % count($relatedImages);
                        ?>
                        <div class="h-40 overflow-hidden">
                            <img src="assets/imgs/<?php echo $relatedImages[$imgIndexRelated]; ?>" class="w-full h-full object-cover" alt="Stranger Things">
                        </div>
                        <div class="p-4 flex-grow">
                            <h4 class="text-lg font-semibold mb-2 stranger-text"><?php echo htmlspecialchars($entrada['titulo']); ?></h4>
                            <div class="text-sm text-gray-400 mb-2"><?php echo date('d/m/Y', strtotime($entrada['creado_en'])); ?></div>
                            <a href="blog.php?id=<?php echo $entrada['id']; ?>" class="text-red-600 hover:text-red-500 text-sm font-medium">Leer más &rarr;</a>
                        </div>
                    </div>
                    <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>


        <?php else: ?>

            <!-- Listado de entradas -->
            <div class="mb-8 text-center">
                <h2 class="text-4xl font-bold stranger-title text-red-600 flicker">ÚLTIMAS HISTORIAS</h2>
                <p class="text-gray-300 mt-2">Explora nuestro mundo del revés</p>
            </div>


            <?php if (empty($entradas)): ?>
                <div class="post-card shadow overflow-hidden sm:rounded-lg p-6 text-center">
                    <p class="text-gray-400">No hay entradas disponibles en este momento.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($entradas as $entrada): ?>
                        <div class="post-card rounded-lg flex flex-col overflow-hidden h-full transform transition-transform duration-300 hover:scale-105 hover:shadow-xl hover:shadow-red-900/20">
                            <div class="aspect-w-16 aspect-h-9 relative">
                                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent z-10"></div>
                                <div class="bg-gray-900 h-48 flex items-center justify-center overflow-hidden">
                                    <?php 
                                    // Usar imagen específica si existe, o una aleatoria si no
                                    if (!empty($entrada['imagen'])) {
                                        // Usar la imagen específica del post
                                        $cardImageSrc = "descargaImagenes/" . $entrada['imagen'];
                                    } else {
                                        // Pseudo-random image selection based on entry ID
                                        $images = ['dustin.jpg', 'eleven.jpg', 'temporada 5 stranger things.jpg', 'stranger-things-bg.jpg', 'stranger-things-4k-d22h0coz6j6ph0e7.jpg'];
                                        $imgIndex = $entrada['id'] % count($images);
                                        $cardImageSrc = "assets/imgs/" . $images[$imgIndex]; 
                                    }
                                    ?>
                                    <img src="<?php echo $cardImageSrc; ?>" class="min-w-full min-h-full object-cover opacity-70" alt="<?php echo htmlspecialchars($entrada['titulo']); ?>">
                                </div>
                            </div>
                            <div class="p-5 flex-grow flex flex-col">
                                <h3 class="text-xl font-bold stranger-title mb-2 leading-tight">
                                    <?php echo htmlspecialchars($entrada['titulo']); ?>
                                </h3>
                                <div class="flex items-center text-xs text-gray-400 mb-3">
                                    <span class="post-category px-2 py-1 text-xs rounded-md text-white mr-2"><?php echo htmlspecialchars($entrada['categoria']); ?></span>
                                    <span><?php echo date('d/m/Y', strtotime($entrada['creado_en'])); ?></span>
                                </div>
                                <div class="text-sm text-gray-300 mb-4 flex-grow">
                                    <?php echo htmlspecialchars(substr($entrada['contenido'], 0, 120)) . '...'; ?>
                                </div>
                                <div class="pt-2">
                                    <a href="blog.php?id=<?php echo $entrada['id']; ?>" class="inline-flex items-center px-4 py-2 text-sm btn-netflix text-white rounded-md">
                                        Ver historia
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>



    <!-- Llamada a la acción -->
    <section class="bg-black border-t border-b border-red-800 py-16 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold stranger-title mb-4">EXPLORA EL MUNDO DEL REVÉS</h2>
                <p class="text-gray-300 max-w-2xl mx-auto">Únete a nuestra comunidad de fans de Stranger Things y comparte tus teorías sobre la quinta temporada, momentos favoritos y personajes.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div class="bg-gray-900 bg-opacity-60 p-6 rounded-lg text-center hover:bg-opacity-80 transition duration-300">
                    <div class="text-red-600 text-4xl mb-4">11</div>
                    <h3 class="text-xl font-bold mb-2">Teorías Asombrosas</h3>
                    <p class="text-gray-400">Descubre las teorías más impactantes sobre el final de la serie</p>
                </div>
                <div class="bg-gray-900 bg-opacity-60 p-6 rounded-lg text-center hover:bg-opacity-80 transition duration-300">
                    <div class="text-red-600 text-4xl mb-4">24</div>
                    <h3 class="text-xl font-bold mb-2">Easter Eggs</h3>
                    <p class="text-gray-400">Referencias ocultas que quizás no notaste en las temporadas</p>
                </div>
                <div class="bg-gray-900 bg-opacity-60 p-6 rounded-lg text-center hover:bg-opacity-80 transition duration-300">
                    <div class="text-red-600 text-4xl mb-4">80+</div>
                    <h3 class="text-xl font-bold mb-2">Análisis de Personajes</h3>
                    <p class="text-gray-400">Perfiles detallados de tus personajes favoritos de la serie</p>
                </div>
            </div>
            
            <?php if (!isset($_SESSION['usuario_id'])): ?>
            <div class="text-center">
                <a href="index.php" class="inline-flex items-center px-6 py-3 text-base font-bold btn-netflix text-white rounded-md hover:shadow-glow">
                    ÚNETE AHORA
                </a>
            </div>
            <?php else: ?>
            <div class="text-center">
                <a href="dashboardBlog.php" class="inline-flex items-center px-6 py-3 text-base font-bold btn-netflix text-white rounded-md hover:shadow-glow">
                    CREAR NUEVA ENTRADA
                </a>
            </div>
            <?php endif; ?>
        </div>
    </section>



    <!-- Pie de página -->
    <footer class="bg-black border-t border-red-800">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:justify-between md:items-center">
                <div class="mb-6 md:mb-0">
                    <h2 class="stranger-title">
                        <img src="assets/imgs/logo.png" alt="Stranger Things" style="height: 40px; width: auto; max-width: 180px; object-fit: contain;">
                    </h2>
                    <p class="text-gray-400 mt-1">EL MUNDO DEL REVÉS</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-red-600">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-red-600">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-red-600">
                        <span class="sr-only">Twitter</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-800 pt-8 md:flex md:items-center md:justify-between">
                <div class="flex space-x-6 md:order-2">
                    <a href="#" class="text-gray-400 hover:text-gray-300 text-sm">Términos</a>
                    <a href="#" class="text-gray-400 hover:text-gray-300 text-sm">Privacidad</a>
                    <a href="#" class="text-gray-400 hover:text-gray-300 text-sm">Cookies</a>
                </div>
                <p class="mt-8 md:mt-0 md:order-1 text-gray-400 text-sm">&copy; 2025 Stranger Things. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>


</body>
</html>
