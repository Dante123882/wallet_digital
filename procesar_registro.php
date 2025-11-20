<?php
include "conexion.php";

$nombre = $_POST["nombre"];
$username = $_POST["username"];
$email = $_POST["email"];
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);

// Guardar imagen
$imagen = "uploads/" . basename($_FILES["imagen"]["name"]);
move_uploaded_file($_FILES["imagen"]["tmp_name"], $imagen);

$sql = "INSERT INTO usuarios(nombre, username, email, password, imagen)
        VALUES ('$nombre', '$username', '$email', '$password', '$imagen')";

$pdo->query($sql);

header("Location: login.php");
?>
