<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>

    <div class="glow-bg"></div>

    <div class="login-container">

        <h2 class="login-title">Iniciar Sesión</h2>

        <form action="validar_login.php" method="POST">

            <label for="user">Usuario o Email:</label>
            <input type="text" name="user" id="user" placeholder="Ingresa tu usuario o correo">

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" placeholder="••••••••">

            <button type="submit" class="btn-login">Ingresar</button>

            <div class="login-footer">
                <a href="crear_cuenta.php">¿No tienes cuenta? Regístrate</a>
            </div>

        </form>

    </div>

</body>
</html>
