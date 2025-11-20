<form action="procesar_registro.php" method="POST" enctype="multipart/form-data">
    <link rel="stylesheet" href="css/crear_cuenta.css">
    
    <label>Nombre:</label>
    <input type="text" name="nombre"><br>

    <label>Username:</label>
    <input type="text" name="username"><br>

    <label>Email:</label>
    <input type="email" name="email"><br>

    <label>Password:</label>
    <input type="password" name="password"><br>

    <label>Imagen del usuario:</label>
    <input type="file" name="imagen"><br>

    <button type="submit">Crear cuenta</button>

    <a href="index.php">Volver</a>

</form>
