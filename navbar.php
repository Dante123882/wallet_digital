<?php
session_start();
if(!isset($_SESSION["usuario"])) header("Location: login.php");
?>

<header class="navbar">
    <link rel="stylesheet" href="css/navbar.css">
    <div class="nav-left">
        <img class="user-img" src="<?= $_SESSION['imagen'] ?>" alt="Foto">
        <div>
            <span class="welcome">Hola,</span><br>
            <span class="username"><?= $_SESSION["usuario"] ?></span>
        </div>
    </div>

    <div class="nav-right">
        <a class="logout-btn" href="logout.php">Cerrar Sesión</a>
    </div>
</header>