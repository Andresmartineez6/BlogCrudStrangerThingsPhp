<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel | Razer Blog</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap" rel="stylesheet">
  <style>
    body {
      background: #0c0c0c;
      font-family: 'Orbitron', sans-serif;
      color: #00ff99;
    }

    .glass {
      background: rgba(0, 0, 0, 0.4);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(0, 255, 136, 0.2);
    }

    .neon-btn {
      background: linear-gradient(to right, #00ff88, #00ccff, #aa00ff);
      color: black;
      font-weight: bold;
    }

    .neon-btn:hover {
      transform: scale(1.05);
      box-shadow: 0 0 20px #00ff88, 0 0 30px #00ccff;
    }

    .tabla-header th {
      background: linear-gradient(to right, #00ff88, #00ccff);
      color: black;
    }
  </style>
</head>
<body class="min-h-screen px-6 py-10 relative">

  <canvas id="bgCanvas" class="fixed top-0 left-0 w-full h-full -z-10"></canvas>

  <header class="text-center mb-10">
    <h1 class="text-4xl font-bold text-green-400">RAZER ADMIN PANEL</h1>
    <p class="text-gray-400">Gestiona las entradas de tu blog como un gamer pro.</p>
  </header>

  <div class="text-right mb-4">
    <a href="/crear.php" class="neon-btn px-4 py-2 rounded">+ Nueva entrada</a>
  </div>

  <div class="glass p-6 rounded-xl shadow-xl">
    <table class="w-full border border-green-400 text-sm">
      <thead class="tabla-header">
        <tr>
          <th class="px-4 py-2">ID</th>
          <th class="px-4 py-2">Título</th>
          <th class="px-4 py-2">Autor</th>
          <th class="px-4 py-2">Categoría</th>
          <th class="px-4 py-2">Fecha</th>
          <th class="px-4 py-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($entradas as $entrada): ?>
        <tr class="border-t border-green-600 hover:bg-green-950 transition duration-300">
          <td class="px-4 py-2"><?= $entrada['id'] ?></td>
          <td class="px-4 py-2"><?= htmlspecialchars($entrada['titulo']) ?></td>
          <td class="px-4 py-2"><?= htmlspecialchars($entrada['autor']) ?></td>
          <td class="px-4 py-2"><?= $entrada['categoria'] ?></td>
          <td class="px-4 py-2"><?= date('d/m/Y', strtotime($entrada['creado_en'])) ?></td>
          <td class="px-4 py-2 flex gap-3">
            <a href="/editar.php?id=<?= $entrada['id'] ?>" class="text-green-400 hover:underline">Editar</a>
            <a href="/eliminar.php?id=<?= $entrada['id'] ?>" class="text-pink-400 hover:underline" onclick="return confirm('¿Eliminar esta entrada?')">Eliminar</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <script>
    gsap.from("table", {
      opacity: 0,
      y: 30,
      duration: 1,
      ease: "power2.out"
    });
  </script>

  <!-- Fondo con partículas -->
  <script>
    const canvas = document.getElementById('bgCanvas');
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth/window.innerHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ canvas, alpha: true });
    renderer.setSize(window.innerWidth, window.innerHeight);

    const particlesCount = 400;
    const positions = new Float32Array(particlesCount * 3);
    for (let i = 0; i < particlesCount * 3; i++) {
      positions[i] = (Math.random() - 0.5) * 60;
    }

    const geometry = new THREE.BufferGeometry();
    geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    const material = new THREE.PointsMaterial({ color: 0x00ff88, size: 0.25, opacity: 0.7, transparent: true });
    const particles = new THREE.Points(geometry, material);
    scene.add(particles);
    camera.position.z = 25;

    function animate() {
      requestAnimationFrame(animate);
      particles.rotation.y += 0.0015;
      particles.rotation.x += 0.0008;
      renderer.render(scene, camera);
    }

    animate();
  </script>

</body>
</html>