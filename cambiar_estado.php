<?php
session_start();
include "conexion.php";

if (!isset($_SESSION["id"]) || !isset($_POST['id_tarjeta'])) {
    header("Location: mis_tarjetas.php");
    exit();
}

$id_tarjeta = $_POST['id_tarjeta'];
$id_usuario = $_SESSION["id"];

// 1. Averiguamos el estado actual de esa tarjeta (y verificamos que sea tuya)
$sql = "SELECT estado FROM tarjetas WHERE id = ? AND id_usuario = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_tarjeta, $id_usuario]);
$tarjeta = $stmt->fetch(PDO::FETCH_ASSOC);

if ($tarjeta) {
    // 2. Calculamos el nuevo estado (si es 1 pasa a 0, si es 0 pasa a 1)
    $nuevo_estado = ($tarjeta['estado'] == 1) ? 0 : 1;

    // 3. Actualizamos
    $update = $pdo->prepare("UPDATE tarjetas SET estado = ? WHERE id = ?");
    $update->execute([$nuevo_estado, $id_tarjeta]);
}

header("Location: mis_tarjetas.php");
exit();
?>