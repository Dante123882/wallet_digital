<?php
session_start();
include "conexion.php";

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION["id"];

// Consulta
$sql = "SELECT * FROM tarjetas WHERE id_usuario = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([":id" => $id]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Tarjetas</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/mis_tarjetas.css">
</head>
<body>

    <header class="navbar">
        <div class="nav-left">
            <a href="usuario.php">
                <i class="fas fa-house"></i>
            </a>
        </div>
        <div class="nav-right">
            <a class="logout-btn" href="logout.php">Cerrar Sesión</a>
            
        </div>
    </header>

    <h2 class="titulo">Mis Tarjetas</h2>

    <div class="contenedor-tarjetas">
        <?php if (count($result) > 0): ?>
            <?php foreach($result as $row) { ?>
                <div class="tarjeta-item">
                    <div class="tarjeta-imagen">
                        <img src="<?=$row['imagen']?>" alt="Banco">
                    </div>

                    <div class="tarjeta-info">
                        <span class="banco"><?=$row['banco']?></span>
                        <span class="numero">**** **** **** <?=substr($row['numero'], -4)?></span>
                        <span class="saldo">$<?=number_format($row['saldo'], 2)?></span>
                    </div>
                </div>
            <?php } ?>
        <?php else: ?>
            <p style="color: white; text-align: center;">No tienes tarjetas registradas aún.</p>
        <?php endif; ?>
    </div>

</body>
</html>