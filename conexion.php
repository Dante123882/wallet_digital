<?php
$host = "localhost";
$user = "danterodz";
$pass = "2806";
$database = "wallet_digital";


// servidor del profe
// $host = "localhost";
// $user = "alumno_18"; //tu alumno
// $pass = "eJLhKtumDBIaXRC3flyiXeEJm"; // la segunda contraseña 
// $database = "alumno_18";


try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "conexion exitosa";
} catch (PDOException $e) {
    echo "error de conexion: " . $e->getMessage();
}