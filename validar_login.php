<?php
session_start();
include "conexion.php";

$user = $_POST["user"];
$pass = $_POST["password"];

$sql = $pdo->prepare("SELECT * FROM usuarios                       WHERE username = :user OR email = :user");

$sql->execute(["user" => $user]);

$data = $sql->fetch(PDO::FETCH_ASSOC);

if ($data && password_verify($pass, $data["password"])) {

    $_SESSION["usuario"] = $data["nombre"];
    $_SESSION["id"] = $data["id"];
    $_SESSION["imagen"] = $data["imagen"];

    header("Location: usuario.php");
    exit;
} else {
    echo "Usuario o contraseña incorrectos";
}
?>