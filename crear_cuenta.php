<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Cuenta</title>
    <link rel="stylesheet" href="css/crear_cuenta.css">
</head>

<body>

    <div class="glow-bg"></div>

    <div class="register-container">

        <h2 class="register-title">Crear Cuenta</h2>

        <form action="procesar_registro.php" method="POST" enctype="multipart/form-data">

            <label for="nombre">Nombre completo:</label>
            <input type="text" name="nombre" id="nombre" placeholder="Tu nombre">

            <label for="username">Nombre de usuario:</label>
            <input type="text" name="username" id="username" placeholder="Usuario">

            <label for="email">Correo electrónico:</label>
            <input type="email" name="email" id="email" placeholder="ejemplo@correo.com">

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" placeholder="••••••••">

            <label for="imagen">Foto de perfil:</label>
            <input type="file" name="imagen" id="imagen" accept="image/*">

            <button type="submit" class="btn-register">Crear cuenta</button>

            <div class="register-footer">
                <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
                <br>
                <a href="usuario.php" class="btn-volver">← Volver </a>
            </div>

        </form>

    </div>

</body>
</html>
