<?php
session_start();

include "conexion.php"; 

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION["id"];

///Toma los datos de la db (foto de perfil)
$sqlUser = "SELECT nombre, imagen FROM usuarios WHERE id = :id";
$stmtUser = $pdo->prepare($sqlUser);
$stmtUser->execute([':id' => $id_usuario]);
$usuario = $stmtUser->fetch(PDO::FETCH_ASSOC);

// Foto por defecto
$nombre_usuario = $usuario['nombre'] ?? "Usuario";
$foto_perfil = !empty($usuario['imagen']) ? $usuario['imagen'] : "https://cdn-icons-png.flaticon.com/512/149/149071.png";

// Calcular total y tarjetas que estan activas
$sqlStats = "SELECT SUM(saldo) as total_dinero, COUNT(*) as total_tarjetas 
             FROM tarjetas WHERE id_usuario = :id AND estado = 1";
$stmt = $pdo->prepare($sqlStats);
$stmt->execute([':id' => $id_usuario]);
$stats = $stmt->fetch(PDO::FETCH_ASSOC);

$saldo_total = $stats['total_dinero'] ?? 0;
$num_tarjetas = $stats['total_tarjetas'];

// Poner la ultima tarjeta registrada
$sqlLast = "SELECT banco, numero, imagen, fecha_registro FROM tarjetas 
            WHERE id_usuario = :id AND estado = 1
            ORDER BY fecha_registro DESC LIMIT 1"; 
$stmtLast = $pdo->prepare($sqlLast);
$stmtLast->execute([':id' => $id_usuario]);
$ultima_tarjeta = $stmtLast->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuario - Billetera Digital</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/usuario.css">
</head>
<body>

    <!-- Gradiente animado de fondo -->
    <div class="gradient-bg"></div>

    <!-- Partículas animadas -->
    <div class="particles" id="particles"></div>

    <!-- Navbar -->
    <header class="navbar">
        <div class="nav-left">
            <a href="usuario.php"><i class="fas fa-house"></i></a>
        </div>
        <div class="nav-right">
            <a class="logout-btn" href="logout.php">Cerrar Sesión</a>
        </div>
    </header>

    <div class="dashboard-container">
        
        <!-- Header con foto de perfil -->
        <div class="perfil-header">
            <a href="perfil.php">
                <img src="<?= htmlspecialchars($foto_perfil) ?>" alt="Mi Foto" class="foto-avatar">
            </a>
            <div class="saludo-texto">
                <h1>¡Hola, <?= htmlspecialchars($nombre_usuario) ?>!</h1>
                <p>Bienvenido a tu billetera digital</p>
            </div>
        </div>

        <!-- Layout de 2 columnas -->
        <div class="main-layout">
            
            <!-- Columna Izquierda: Tarjeta destacada + Movimientos -->
            <div class="left-column">
                
                <!-- Tarjeta Destacada -->
                <div class="featured-card">
                    <?php if($ultima_tarjeta): ?>
                        <div class="card-display-img">
                            <img src="<?= htmlspecialchars($ultima_tarjeta['imagen']) ?>" alt="<?= htmlspecialchars($ultima_tarjeta['banco']) ?>">
                            <div class="card-overlay">
                                <div class="card-number">
                                    <?= chunk_split(substr($ultima_tarjeta['numero'], 0, 16), 4, ' ') ?>
                                </div>
                                <div class="card-info">
                                    <div>
                                        <small>TITULAR</small>
                                        <p><?= htmlspecialchars($nombre_usuario) ?></p>
                                    </div>
                                    <div>
                                        <small>VENCE</small>
                                        <p><?= date('m/y', strtotime($ultima_tarjeta['fecha_registro'])) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="saldo-disponible">
                            <h3>Saldo disponible</h3>
                            <p class="monto-grande">$<?= number_format($saldo_total, 2) ?> MXN</p>
                            <small>Estado: Sesión activa</small>
                        </div>
                    <?php else: ?>
                        <div class="no-cards">
                            <i class="fas fa-credit-card"></i>
                            <p>No tienes tarjetas registradas</p>
                            <a href="agregar_tarjeta.php" class="btn-agregar-mini">Agregar primera tarjeta</a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Movimientos Recientes -->
                <div class="movimientos-section">
                    <h3>Movimientos recientes</h3>
                    <div class="movimiento-item">
                        <span class="mov-tipo"><i class="fas fa-arrow-down"></i> Retiro</span>
                        <span class="mov-monto">-$500.00</span>
                    </div>
                    <div class="movimiento-item">
                        <span class="mov-tipo"><i class="fas fa-arrow-up"></i> Depósito</span>
                        <span class="mov-monto positivo">+$800.00</span>
                    </div>
                    <div class="movimiento-item">
                        <span class="mov-tipo"><i class="fas fa-arrow-up"></i> Depósito</span>
                        <span class="mov-monto positivo">+$500.00</span>
                    </div>
                </div>

            </div>

            <!-- Columna Derecha: Formularios y Acciones -->
            <div class="right-column">
                
                <!-- Formulario: Registrar Nueva Tarjeta -->
                <div class="form-card">
                    <h3>Registrar nueva tarjeta</h3>
                    <form action="agregar_tarjeta.php" method="GET">
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-plus-circle"></i> Ir a Agregar Tarjeta
                        </button>
                    </form>
                </div>

                <!-- Formulario: Ver Mis Tarjetas -->
                <div class="form-card">
                    <h3>Mis tarjetas registradas</h3>
                    <form action="mis_tarjetas.php" method="GET">
                        <button type="submit" class="btn-submit secondary">
                            <i class="fas fa-credit-card"></i> Ver Mis Tarjetas
                        </button>
                    </form>
                </div>

                <!-- Información Rápida -->
                <div class="form-card">
                    <h3>Resumen de cuenta</h3>
                    <div class="info-rapida">
                        <div class="info-item">
                            <span class="info-label">Total de tarjetas</span>
                            <span class="info-value"><?= $num_tarjetas ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Saldo total</span>
                            <span class="info-value">$<?= number_format($saldo_total, 2) ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Estado</span>
                            <span class="info-value" style="color: #4fffad;">Activo</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Acciones Rápidas al final -->
        <h3>Acciones Rápidas</h3>
        <div class="actions-grid">
            <a href="agregar_tarjeta.php" class="action-btn">
                <i class="fas fa-plus-circle"></i>
                <span>Nueva Tarjeta</span>
            </a>
            
            <a href="mis_tarjetas.php" class="action-btn">
                <i class="fas fa-list-ul"></i>
                <span>Ver Mis Tarjetas</span>
            </a>
            
            <a href="perfil.php" class="action-btn">
                <i class="fas fa-user-circle"></i>
                <span>Mi Perfil</span>
            </a>
        </div>

    </div>

    <script>
    // Sistema de partículas animadas mejorado
    function createParticles() {
        const particlesContainer = document.getElementById('particles');
        const particleCount = 60;

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
            
            // Colores variados (azul y cyan)
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
    </script>

</body>
</html>