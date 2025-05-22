<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión | Razer Blog</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r148/three.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(120deg, #0c0c0c, #111);
      color: #e5e5e5;
      font-family: 'Orbitron', sans-serif;
    }

    .glass {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      box-shadow: 0 0 15px rgba(0, 255, 128, 0.15);
    }

    .neon-btn {
      background: linear-gradient(to right, #00ff88, #00ccff, #aa00ff);
      color: black;
      font-weight: bold;
      transition: 0.4s;
    }

    .neon-btn:hover {
      transform: scale(1.05);
      box-shadow: 0 0 20px #00ff88, 0 0 30px #00ccff;
    }

    .error-box {
      background: linear-gradient(to right, #ff0077, #ff3399);
      color: white;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 1rem;
    }
  </style>

</head>

<body class="flex flex-col min-h-screen">

  <!-- Header tipo GSAP -->
  <header class="flex justify-between items-center px-6 py-4 bg-black text-white text-sm border-b border-gray-700">
    <div class="text-2xl font-bold text-green-400"><img src="/assets/imgs/razer-1.png" alt="Logo"></div>
    <nav class="flex gap-4">
      <a href="#" class="hover:text-green-400">Inicio</a>
      <a href="#" class="hover:text-pink-400">Blog</a>
      <a href="#" class="hover:text-blue-400">Comunidad</a>
      <a href="#" class="hover:text-purple-400">Docs</a>
      <a href="#" class="hover:text-orange-400">Demos</a>
    </nav>
    <a href="#" class="neon-btn px-4 py-2 rounded text-xs">Registrarse</a>
  </header>

  <canvas id="bgCanvas" class="fixed top-0 left-0 w-full h-full -z-10"></canvas>

  <!-- Login -->
  <main class="flex-1 flex justify-center items-center mt-20 mb-20">
    <div id="loginBox" class="w-full max-w-md glass p-8 rounded-xl border border-green-500 text-white">
      <h2 class="text-3xl text-center mb-6">Razer</h2>

      <?php if (!empty($error)): ?>
        <div class="error-box text-sm text-center"><?= $error ?></div>
      <?php endif; ?>

      <form method="POST" class="flex flex-col gap-4">
        <input type="email" name="email" placeholder="Email Address" required class="p-3 rounded bg-black border border-green-400 placeholder-green-500 text-green-300">
        <input type="password" name="password" placeholder="Password" required class="p-3 rounded bg-black border border-green-400 placeholder-green-500 text-green-300">
        <button type="submit" class="neon-btn p-3 rounded mt-2">Entrar</button>
        <div class="text-xs text-center text-gray-400 mt-3"><a href="">¿Olvidaste tu contraseña?</a></div>
      </form>
    </div>

  </main>

  <!-- Footer tipo GSAP -->
  <footer class="bg-black text-gray-300 py-10 px-8 border-t border-gray-800">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10">
      <div>
        <h3 class="text-green-400 mb-2">Newsletter</h3>
        <p class="text-sm mb-2">Keep in the loop con Razer IA y noticias tecnológicas.</p>
        <input type="text" placeholder="Email" class="w-full p-2 rounded bg-gray-900 border border-green-400 text-green-300">
      </div>
      <div>
        <h3 class="text-blue-400 mb-2">RAZER CORE</h3>
        <ul class="text-sm space-y-1">
          <li><a href="#">Blog</a></li>
          <li><a href="#">Showcase</a></li>
          <li><a href="#">Learn GSAP</a></li>
          <li><a href="#">Razer Webflow</a></li>
        </ul>
      </div>
      <div>
        <h3 class="text-pink-400 mb-2">Conecta</h3>
        <ul class="text-sm space-y-1">
          <li><a href="#">Forums</a></li>
          <li><a href="#">GitHub</a></li>
          <li><a href="#">LinkedIn</a></li>
          <li><a href="#">X (Twitter)</a></li>
        </ul>
      </div>
    </div>
    <div class="mt-8 text-center text-xs text-gray-500">
      ©2025 RAZER BLOG – Todos los derechos reservados.
    </div>
  </footer>

  <!-- Animación GSAP -->
  <script>
    gsap.from("#loginBox", {
      opacity: 0,
      y: -50,
      duration: 1,
      ease: "power4.out"
    });
  </script>

    <script>
    const canvas = document.getElementById('bgCanvas');
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth/window.innerHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ canvas, alpha: true });
    renderer.setSize(window.innerWidth, window.innerHeight);

    const particlesCount = 500;
    const positions = new Float32Array(particlesCount * 3);

    for (let i = 0; i < particlesCount * 3; i++) {
        positions[i] = (Math.random() - 0.5) * 40;
    }

    const geometry = new THREE.BufferGeometry();
    geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));

    const material = new THREE.PointsMaterial({ 
        color: 0x00ff88, 
        size: 0.2,
        transparent: true,
        opacity: 0.8
    });

    const particles = new THREE.Points(geometry, material);
    scene.add(particles);

    camera.position.z = 15;

    function animate() {
        requestAnimationFrame(animate);
        particles.rotation.y += 0.001;
        particles.rotation.x += 0.0005;
        renderer.render(scene, camera);
    }

    animate();

    window.addEventListener('resize', () => {
        camera.aspect = window.innerWidth/window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    });
    </script>

</body>
</html>