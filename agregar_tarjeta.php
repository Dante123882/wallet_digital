 <header class="navbar">
    <link rel="stylesheet" href="css/navbar.css">
    <!-- MDBootstrap Icons -->
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.css"
    />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">



    <div class="nav-left">
        <a href="usuario.php">
       <i class="fas fa-house"></i>
        </a>
    </div>

    <div class="nav-right">
        <a class="logout-btn" href="logout.php">Cerrar Sesión</a>
    </div>
</header>
<form action="procesar_tarjeta.php" method="POST">

    <link rel="stylesheet" href="css/agregar_tarjeta.css">
    
    <label>Número de tarjeta:</label>
    <input 
        type="text" 
        name="numero" 
        maxlength="16" 
        pattern="\d{16}"
        title="Ingresa los 16 dígitos de la tarjeta"
        inputmode="numeric"
        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
        placeholder="0000000000000000"
        required
    ><br>

    <label>Banco:</label>
    <select name="banco" id="banco" onchange="asignarImagen()" required>
        <option value="">Seleccione un banco</option>
        <option value="BBVA">BBVA</option>
        <option value="Santander">Santander</option>
        <option value="Banamex">Banamex</option>
        <option value="HSBC">HSBC</option>
        <option value="Scotiabank">Scotiabank</option>
    </select><br>

    <label>Fecha de registro:</label>
    <input type="date" name="fecha" required><br>

    <label>Saldo:</label>
    <input type="number" step="0.01" name="saldo" required><br>

    <input type="hidden" name="imagen" id="imagen">

    <button type="submit">Guardar Tarjeta</button>
</form>


<script>
function asignarImagen() {
    let banco = document.getElementById("banco").value;
    let imagenInput = document.getElementById("imagen");

    
    let imagenes = {
        "BBVA": "images/bancos/bbva.png",
        "Santander": "images/bancos/santander.webp",
        "Banamex": "images/bancos/banamex.png",
        "HSBC": "images/bancos/hsbc.jpg",
        "Scotiabank": "images/bancos/scotiabank.png"
    };

    
    imagenInput.value = imagenes[banco] ?? "";
}
</script>

