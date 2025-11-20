<?php
session_start();

// 1. IMPORTANTE: La conexión debe ir PRIMERO para que $pdo exista
include "conexion.php"; 

// 2. Verificamos seguridad de sesión
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION["id"];

// 3. LÓGICA DE LOS WIDGETS (Base de Datos)

// A) Calcular Saldo Total y Cantidad de Tarjetas
$sqlStats = "SELECT SUM(saldo) as total_dinero, COUNT(*) as total_tarjetas 
             FROM tarjetas WHERE id_usuario = :id";
$stmt = $pdo->prepare($sqlStats);
$stmt->execute([':id' => $id_usuario]);
$stats = $stmt->fetch(PDO::FETCH_ASSOC);

// Si es null (usuario nuevo), ponemos 0
$saldo_total = $stats['total_dinero'] ?? 0;
$num_tarjetas = $stats['total_tarjetas'];

// B) Obtener la última tarjeta registrada (para el widget de "Reciente")
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
    <title>Panel de Usuario</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/usuario.css">

    <style>
    
    </style>
</head>
<body>

    <header class="navbar">
        <div class="nav-left">
            <a href="usuario.php"><i class="fas fa-house"></i></a>
        </div>
        <div class="nav-right">
            <a class="logout-btn" href="logout.php">Cerrar Sesión</a>
        </div>
    </header>

    <div class="dashboard-container">
        
        <div class="welcome-section">
            <h1>Resumen Financiero</h1>
            <p>Estado actual de tus tarjetas y cuentas.</p>
        </div>

        <div class="widgets-grid">
            
            <div class="widget-card saldo">
                <div class="icon-box"><i class="fas fa-wallet"></i></div>
                <div class="info-box">
                    <h3>Saldo Total</h3>
                    <p>$<?= number_format($saldo_total, 2) ?></p>
                </div>
            </div>

            <div class="widget-card cantidad">
                <div class="icon-box"><i class="fas fa-credit-card"></i></div>
                <div class="info-box">
                    <h3>Tarjetas</h3>
                    <p><?= $num_tarjetas ?> Activas</p>
                </div>
            </div>

            <div class="widget-card reciente">
                <div class="icon-box"><i class="fas fa-history"></i></div>
                <div class="info-box">
                    <h3>Último Registro</h3>
                    <?php if($ultima_tarjeta): ?>
                        <p><?= $ultima_tarjeta['banco'] ?></p>
                        <small><?= $ultima_tarjeta['fecha_registro'] ?></small>
                    <?php else: ?>
                        <p>--</p>
                        <small>Sin movimientos</small>
                    <?php endif; ?>
                </div>
            </div>

        </div>

        <h3 style="margin-bottom: 20px; color: #eee;">Acciones Rápidas</h3>

        <div class="actions-grid">
            <a href="agregar_tarjeta.php" class="action-btn">
                <i class="fas fa-plus-circle"></i>
                Nueva Tarjeta
            </a>
            
            <a href="mis_tarjetas.php" class="action-btn">
                <i class="fas fa-list-ul"></i>
                Ver Mis Tarjetas
            </a>
        </div>

    </div>

</body>
</html>