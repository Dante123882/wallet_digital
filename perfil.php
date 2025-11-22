<?php
session_start();
require_once 'conexion.php';
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['id'];

$stmt = $pdo->prepare("SELECT nombre, username, email FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/perfil.css">
</head>
<body>

    <!-- Gradiente animado de fondo -->
    <div class="gradient-bg"></div>

    <!-- Partículas animadas -->
    <div class="particles" id="particles"></div>

    <div class="perfil-container">
        <!-- Icono decorativo (opcional) -->
        <div class="profile-icon">
            <i class="fas fa-user-circle"></i>
        </div>

        <h1>Mi Perfil</h1>
        
        <div class="foto-container">
            <img src="<?= htmlspecialchars($_SESSION['imagen'] ?? 'https://cdn-icons-png.flaticon.com/512/149/149071.png') ?>" alt="Foto de perfil" class="perfil-foto">
        </div>

        <p><strong><i class="fas fa-user"></i> Nombre:</strong> <?= htmlspecialchars($usuario['nombre']) ?></p>
        <p><strong><i class="fas fa-at"></i> Username:</strong> <?= htmlspecialchars($usuario['username']) ?></p>
        <p><strong><i class="fas fa-envelope"></i> Email:</strong> <?= htmlspecialchars($usuario['email']) ?></p>

        <a href="usuario.php" class="btn-volver">
            <i class="fas fa-arrow-left"></i> Volver al Dashboard
        </a>
    </div>

    <script>
    // Sistema de partículas animadas
    function createParticles() {
        const particlesContainer = document.getElementById('particles');
        const particleCount = 50;

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle');
            
            // Posición aleatoria horizontal
            particle.style.left = Math.random() * 100 + '%';
            
            // Tamaño aleatorio
            const size = Math.random() * 4 + 1;
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            
            // Duración de animación aleatoria
            const duration = Math.random() * 15 + 8;
            particle.style.animationDuration = duration + 's';
            
            // Delay aleatorio
            const delay = Math.random() * 5;
            particle.style.animationDelay = delay + 's';
            
            // Colores variados
            const colors = [
                'rgba(79, 125, 255, 0.6)',
                'rgba(79, 255, 173, 0.4)',
                'rgba(123, 158, 255, 0.5)'
            ];
            particle.style.background = colors[Math.floor(Math.random() * colors.length)];
            
            particlesContainer.appendChild(particle);
        }
    }

    // Inicializar partículas cuando carga la página
    window.addEventListener('load', createParticles);

    // Animación de entrada suave
    window.addEventListener('load', function() {
        document.querySelector('.perfil-container').style.opacity = '0';
        setTimeout(() => {
            document.querySelector('.perfil-container').style.transition = 'opacity 0.8s ease';
            document.querySelector('.perfil-container').style.opacity = '1';
        }, 100);
    });
    </script>

</body>
</html>