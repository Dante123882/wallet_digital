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
    <link rel="stylesheet" href="css/perfil.css">
</head>
<body>
    <div class="perfil-container">
        <h1>Mi Perfil</h1>
        <div class="foto-container">
            <img src="<?= $_SESSION['imagen'] ?>" alt="Foto" class="perfil-foto">
    </div>

        <p><strong>Nombre de usuario:</strong> <?= htmlspecialchars($usuario['nombre']) ?></p>
        <p><strong>Username:</strong> <?= htmlspecialchars($usuario['username']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($usuario['email']) ?></p>

        <a href="usuario.php" class="btn-volver">← Volver </a>
    </div>
</body>
</html>