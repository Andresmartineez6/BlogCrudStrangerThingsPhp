

<?php

    require_once(__DIR__ . "/db/conexionDatabase.php");
    require_once(__DIR__ . "/modelos/modeloEntradas.php");


    session_start();


    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: ./index.php");
        exit;
    }



    // Verificar el rol del usuario
    $esAdmin = isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin';


    // Instanciar el modelo de entradas
    $modeloEntradas = new Post();


    // Obtener categorías para el formulario
    $categorias = $modeloEntradas->obtenerCategorias();


    // Nombre del usuario para mostrar en el dashboard
    $nombreUsuario = $_SESSION['usuario_nombre'] ?? 'Usuario';


    // Si no es admin y trata de eliminar, redirigir
    if (!$esAdmin && isset($_GET['eliminar'])) {

        $mensaje = "No tienes permisos para eliminar entradas";
        $tipoMensaje = "error";
        // Redirigir para eliminar el parámetro de la URL
        header("Location: dashboardBlog.php");
        exit;
    }


    // Procesar formulario de creación
    if (isset($_POST['accion']) && $_POST['accion'] == 'crear') {

        // Verificar si el usuario tiene permisos para crear (todos pueden crear)
        $titulo = trim($_POST['titulo']);
        $contenido = trim($_POST['contenido']);
        $autor = trim($_POST['autor']);
        $categoria_id = $_POST['categoria_id'];
        $imagen = null;
        

        // Procesar imagen si se ha subido alguna
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {

            $allowed = array('jpg', 'jpeg', 'png', 'gif', 'webp');
            $filename = $_FILES['imagen']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $filesize = $_FILES['imagen']['size'];
            
            // Validar tamaño máximo (5MB)
            $max_size = 5 * 1024 * 1024; // 5MB en bytes
            
            if ($filesize > $max_size) {
                $mensaje = "La imagen es demasiado grande. El tamaño máximo permitido es 5MB.";
                $tipoMensaje = "error";
            } else if (in_array(strtolower($ext), $allowed)) {

                // Crear directorio de imágenes si no existe
                $upload_dir = __DIR__ . '/descargaImagenes/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                // Generar nombre único para el archivo
                $new_filename = uniqid() . '.' . $ext;
                $destination = $upload_dir . $new_filename;
                
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destination)) {
                    $imagen = $new_filename;
                } else {
                    $mensaje = "Error al subir la imagen";
                    $tipoMensaje = "error";
                }

            } else {
                $mensaje = "Tipo de archivo no permitido. Solo JPG, PNG, GIF, WEBP";
                $tipoMensaje = "error";
            }
        }
        
        if (!isset($mensaje) && !empty($titulo) && !empty($contenido) && !empty($autor) && !empty($categoria_id)) {

            $modeloEntradas->insertarEntrada($titulo, $contenido, $autor, $categoria_id, $imagen);
            $mensaje = "Entrada creada con éxito";
            $tipoMensaje = "exito";

        } else if (!isset($mensaje)) {

            $mensaje = "Todos los campos son obligatorios";
            $tipoMensaje = "error";
        }
    }



    // Procesar formulario de actualización
    if (isset($_POST['accion']) && $_POST['accion'] == 'actualizar') {

        $id = $_POST['id'];
        $titulo = trim($_POST['titulo']);
        $contenido = trim($_POST['contenido']);
        $autor = trim($_POST['autor']);
        $categoria_id = $_POST['categoria_id'];
        $imagen = null;
        

        // Si no es admin, verificar que la entrada le pertenezca
        $puedeActualizar = $esAdmin;
        

        if (!$esAdmin) {
            // Obtener la entrada actual para verificar si el autor coincide con el usuario actual
            $entradaActual = $modeloEntradas->obtenerPorId($id);
            if ($entradaActual && $entradaActual['autor'] === $nombreUsuario) {
                $puedeActualizar = true;
            }
        }
        

        if ($puedeActualizar) {
            // Procesar imagen si se ha subido alguna
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                $allowed = array('jpg', 'jpeg', 'png', 'gif', 'webp');
                $filename = $_FILES['imagen']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $filesize = $_FILES['imagen']['size'];
                
                // Validar tamaño máximo (5MB)
                $max_size = 5 * 1024 * 1024; // 5MB en bytes
                
                if ($filesize > $max_size) {
                    $mensaje = "La imagen es demasiado grande. El tamaño máximo permitido es 5MB.";
                    $tipoMensaje = "error";
                } else if (in_array(strtolower($ext), $allowed)) {
                    // Crear directorio de imágenes si no existe
                    $upload_dir = __DIR__ . '/descargaImagenes/';
                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }
                    
                    // Generar nombre único para el archivo
                    $new_filename = uniqid() . '.' . $ext;
                    $destination = $upload_dir . $new_filename;
                    
                    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destination)) {
                        $imagen = $new_filename;
                        
                        // Obtener la entrada actual para verificar si ya tiene una imagen
                        $entradaActual = $modeloEntradas->obtenerPorId($id);
                        if (!empty($entradaActual['imagen'])) {
                            $old_image = $upload_dir . $entradaActual['imagen'];
                            if (file_exists($old_image)) {
                                unlink($old_image);
                            }
                        }
                    } else {
                        $mensaje = "Error al subir la imagen";
                        $tipoMensaje = "error";
                    }
                } else {
                    $mensaje = "Tipo de archivo no permitido. Solo JPG, PNG, GIF, WEBP";
                    $tipoMensaje = "error";
                }
            }
            
            if (!isset($mensaje) && !empty($titulo) && !empty($contenido) && !empty($autor) && !empty($categoria_id)) {
               
                $modeloEntradas->actualizarEntrada($id, $titulo, $contenido, $autor, $categoria_id, $imagen);
                $mensaje = "Entrada actualizada con éxito";
                $tipoMensaje = "exito";
            } else if (!isset($mensaje)) {

                $mensaje = "Todos los campos son obligatorios";
                $tipoMensaje = "error";
            }
            
        } else {

            $mensaje = "No tienes permisos para actualizar esta entrada";
            $tipoMensaje = "error";
        }
    }

    // Procesar eliminación
    if (isset($_GET['eliminar'])) {
        $id = $_GET['eliminar'];
        
        // Obtener la entrada para verificar si tiene imagen
        $entradaEliminar = $modeloEntradas->obtenerPorId($id);
        
        // Si la entrada tiene una imagen, eliminarla
        if ($entradaEliminar && !empty($entradaEliminar['imagen'])) {
            $upload_dir = __DIR__ . '/descargaImagenes/';
            $imagen_path = $upload_dir . $entradaEliminar['imagen'];
            
            if (file_exists($imagen_path)) {
                unlink($imagen_path);
            }
        }
        
        // Eliminar la entrada de la base de datos
        $modeloEntradas->borrarEntrada($id);
        $mensaje = "Entrada eliminada con éxito";
        $tipoMensaje = "exito";
    }

    // Obtener entrada para editar
    $entradaEditar = null;
    if (isset($_GET['editar'])) {
        $id = $_GET['editar'];
        $entradaEditar = $modeloEntradas->obtenerPorId($id);
    }

    // Obtener todas las entradas
    $entradas = $modeloEntradas->obtenerTodas();

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Stranger Things</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css">
    
</head>


<body class="dashboard-bg text-white min-h-screen">



    <!-- Barra de navegación -->
    <nav class="bg-black border-b border-red-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="font-bold stranger-title">
                        <img src="assets/imgs/logo.png" alt="Stranger Things" style="height: 50px; width: auto; max-width: 200px; object-fit: contain;">
                    </h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-300">Bienvenido, <span class="text-white font-bold"><?php echo htmlspecialchars($nombreUsuario); ?></span></span>
                    <a href="blog.php" class="inline-block px-4 py-2 text-sm btn-netflix text-white font-bold rounded-md">Ver Blog</a>
                    <a href="logout.php" class="inline-block px-4 py-2 text-sm bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-md">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </nav>




    <!-- Contenido principal -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">

        <!-- Mensajes de alerta -->
        <?php if (isset($mensaje)): ?>
            <div class="mb-4 p-4 rounded-md <?php echo $tipoMensaje == 'exito' ? 'bg-red-600 bg-opacity-80' : 'bg-red-800'; ?> shadow-glow">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>


        <!-- Formulario para crear/editar entradas -->
        <div class="content-card shadow overflow-hidden sm:rounded-lg mb-8">

            <div class="px-4 py-5 sm:px-6 border-b border-red-800">
                <h3 class="text-lg leading-6 font-medium text-red-600 stranger-title">
                    <?php echo $entradaEditar ? 'Editar Entrada' : 'Nueva Entrada'; ?>
                </h3>
            </div>

            <div class="p-6">
                <form method="POST" action="dashboardBlog.php" class="space-y-6" enctype="multipart/form-data">
                    <input type="hidden" name="accion" value="<?php echo $entradaEditar ? 'actualizar' : 'crear'; ?>">
                    <?php if ($entradaEditar): ?>
                        <input type="hidden" name="id" value="<?php echo $entradaEditar['id']; ?>">
                    <?php endif; ?>
                    
                    <div>
                        <label for="titulo" class="block text-sm font-medium text-gray-300 mb-1">Título</label>
                        <input type="text" name="titulo" id="titulo" required 
                            value="<?php echo $entradaEditar ? htmlspecialchars($entradaEditar['titulo']) : ''; ?>"
                            class="netflix-input block w-full">
                    </div>
                    
                    <div class="mt-4">
                        <label for="contenido" class="block text-sm font-medium text-gray-300 mb-1">Contenido</label>
                        <textarea name="contenido" id="contenido" rows="6" required 
                            class="netflix-input block w-full"><?php echo $entradaEditar ? htmlspecialchars($entradaEditar['contenido']) : ''; ?></textarea>
                    </div>
                    
                    <div class="mt-4">
                        <label for="autor" class="block text-sm font-medium text-gray-300 mb-1">Autor</label>
                        <input type="text" name="autor" id="autor" required 
                            value="<?php echo $entradaEditar ? htmlspecialchars($entradaEditar['autor']) : ''; ?>"
                            class="netflix-input block w-full">
                    </div>
                    
                    <div class="mt-4">
                        <label for="categoria_id" class="block text-sm font-medium text-gray-300 mb-1">Categoría</label>
                        <select name="categoria_id" id="categoria_id" required 
                            class="netflix-input block w-full appearance-none pr-10 bg-[url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="white"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>')] bg-no-repeat bg-right-4 bg-8">
                            <option value="">Selecciona una categoría</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?php echo $categoria['id']; ?>" 
                                    <?php echo ($entradaEditar && $entradaEditar['categoria_id'] == $categoria['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($categoria['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mt-4">
                        <label for="imagen" class="block text-sm font-medium text-gray-300 mb-1">Imagen</label>
                        <input type="file" name="imagen" id="imagen" 
                            class="netflix-input block w-full bg-gray-900 text-white py-2 px-3 rounded">
                        <p class="text-xs text-gray-400 mt-1">Formatos permitidos: JPG, PNG, GIF, WEBP</p>
                        <?php if ($entradaEditar && !empty($entradaEditar['imagen'])): ?>
                        <div class="mt-3">
                            <p class="text-sm text-gray-400 mb-2">Imagen actual:</p>
                            <img src="descargaImagenes/<?php echo htmlspecialchars($entradaEditar['imagen']); ?>" alt="Imagen actual" class="max-h-32 rounded shadow-md border border-gray-700">
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 btn-netflix">
                            <?php echo $entradaEditar ? 'Actualizar Entrada' : 'Crear Entrada'; ?>
                        </button>
                        <?php if ($entradaEditar): ?>
                            <a href="dashboardBlog.php" class="ml-3 inline-flex justify-center py-2 px-4 border border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-300 bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancelar
                            </a>
                        <?php endif; ?>
                    </div>
                </form>

            </div>
        </div>





        <!-- Tabla de entradas -->
        <div class="content-card shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-red-800">
                <h3 class="text-lg leading-6 font-medium text-red-600 stranger-title">Entradas del Blog</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-800">
                    <thead class="table-header">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Imagen</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Título</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider hidden md:table-cell">Autor</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider hidden lg:table-cell">Categoría</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Fecha</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        <?php if (empty($entradas)): ?>
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center text-gray-400">No hay entradas disponibles</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($entradas as $entrada): ?>
                                <tr class="table-row">
                                    <td class="px-4 py-3 text-sm">
                                        <div class="h-12 w-16 overflow-hidden rounded">
                                            <?php if (!empty($entrada['imagen'])): ?>
                                                <img src="descargaImagenes/<?php echo htmlspecialchars($entrada['imagen']); ?>" class="h-full w-full object-cover" alt="Imagen del post">
                                            <?php else: ?>
                                                <?php 
                                                $images = ['dustin.jpg', 'eleven.jpg', 'temporada 5 stranger things.jpg', 'stranger-things-bg.jpg'];
                                                $imgIndex = $entrada['id'] % count($images);
                                                ?>
                                                <img src="assets/imgs/<?php echo $images[$imgIndex]; ?>" class="h-full w-full object-cover" alt="Imagen predeterminada">
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="font-medium text-white truncate max-w-xs" title="<?php echo htmlspecialchars($entrada['titulo']); ?>">
                                            <?php echo htmlspecialchars(strlen($entrada['titulo']) > 30 ? substr($entrada['titulo'], 0, 30).'...' : $entrada['titulo']); ?>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-300 hidden md:table-cell"><?php echo htmlspecialchars($entrada['autor']); ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-300 hidden lg:table-cell"><?php echo htmlspecialchars($entrada['categoria']); ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-300"><?php echo date('d/m/Y', strtotime($entrada['creado_en'])); ?></td>
                                    <td class="px-4 py-3 text-sm font-medium">
                                        <div class="flex flex-wrap gap-2">
                                            <?php if($esAdmin || $nombreUsuario === $entrada["autor"]): ?>
                                                <a href="?editar=<?php echo $entrada['id']; ?>" class="inline-flex items-center px-2 py-1 bg-gray-800 hover:bg-gray-700 text-xs rounded">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Editar
                                                </a>
                                            <?php endif; ?>
                                            <?php if($esAdmin): ?>
                                                <a href="#" onclick="confirmarEliminar(<?php echo $entrada['id']; ?>)" class="inline-flex items-center px-2 py-1 btn-netflix text-xs rounded">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Eliminar
                                                </a>
                                            <?php endif; ?>
                                            <a href="blog.php?id=<?php echo $entrada['id']; ?>" class="inline-flex items-center px-2 py-1 bg-gray-700 hover:bg-gray-600 text-xs rounded">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Ver
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <script>
        function confirmarEliminar(id) {
            if (confirm('¿Estás seguro de que deseas eliminar esta entrada?')) {
                window.location.href = 'dashboardBlog.php?eliminar=' + id;
            }
        }
    </script>

    
</body>
</html>