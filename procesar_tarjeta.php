<?php
session_start();
include "conexion.php";

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION["id"];
$numero = $_POST["numero"];
$banco = $_POST["banco"];
$fecha = $_POST["fecha"];
$saldo = $_POST["saldo"];
$imagen = $_POST["imagen"]; 

$sql = "INSERT INTO tarjetas(id_usuario, numero, banco, fecha_registro, saldo, imagen)
        VALUES (?, ?, ?, ?, ?, ?)";


$stmt = $pdo->prepare($sql);


$stmt->execute([$id_usuario, $numero, $banco, $fecha, $saldo, $imagen]);


header("Location: mis_tarjetas.php");
exit();
?>