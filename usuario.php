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
$sqlLast = "SELECT banco, fecha_registro FROM tarjetas 
            WHERE id_usuario = :id 
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

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/usuario.css">
</head>
<body>

    <!-- Navbar -->
    <header class="navbar">
        <div class="nav-left">
            <a href="usuario.php" title="Inicio">
                <i class="fas fa-house"></i>
            </a>
        </div>
        <div class="nav-right">
            <a class="logout-btn" href="logout.php">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>
    </header>

    <!-- Contenedor principal del dashboard -->
    <div class="dashboard-container">
        
        <!-- Header del perfil -->
        <div class="perfil-header">
            <a href="perfil.php">
                <img src="<?= htmlspecialchars($foto_perfil) ?>" alt="Foto de <?= htmlspecialchars($nombre_usuario) ?>" class="foto-avatar">
            </a>
            <div class="saludo-texto">
                <h1>¡Hola, <?= htmlspecialchars($nombre_usuario) ?>!</h1>
                <p>Bienvenido a tu billetera digital</p>
            </div>
        </div>

        <!-- Widgets informativos -->
        <div class="widgets-grid">
            
            <!-- Widget de Saldo Total -->
            <div class="widget-card saldo">
                <div class="icon-box">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="info-box">
                    <h3>Saldo Total</h3>
                    <p>$<?= number_format($saldo_total, 2) ?></p>
                </div>
            </div>

            <!-- Widget de Cantidad de Tarjetas -->
            <div class="widget-card cantidad">
                <div class="icon-box">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="info-box">
                    <h3>Tarjetas</h3>
                    <p><?= $num_tarjetas ?> Activas</p>
                </div>
            </div>

            <!-- Widget de Última Actividad -->
            <div class="widget-card reciente">
                <div class="icon-box">
                    <i class="fas fa-history"></i>
                </div>
                <div class="info-box">
                    <h3>Último Registro</h3>
                    <?php if($ultima_tarjeta): ?>
                        <p><?= htmlspecialchars($ultima_tarjeta['banco']) ?></p>
                        <small><?= date('d/m/Y', strtotime($ultima_tarjeta['fecha_registro'])) ?></small>
                    <?php else: ?>
                        <p>--</p>
                        <small>Sin movimientos</small>
                    <?php endif; ?>
                </div>
            </div>

        </div>

        <!-- Título de acciones -->
        <h3>Acciones Rápidas</h3>

        <!-- Botones de acción -->
        <div class="actions-grid">
            <a href="agregar_tarjeta.php" class="action-btn">
                <i class="fas fa-plus-circle"></i>
                <span>Nueva Tarjeta</span>
            </a>
            
            <a href="mis_tarjetas.php" class="action-btn">
                <i class="fas fa-list-ul"></i>
                <span>Ver Mis Tarjetas</span>
            </a>
        </div>

    </div>

</body>
</html>