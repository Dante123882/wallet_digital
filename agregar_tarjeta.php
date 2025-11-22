<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Tarjeta - Billetera Digital</title>
    
    <!-- CSS Externos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- CSS Propios -->
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/agregar_tarjeta.css">
</head>
<body>

    <!-- Gradiente animado de fondo -->
    <div class="gradient-bg"></div>

    <!-- Partículas animadas -->
    <div class="particles" id="particles"></div>

    <!-- Navbar -->
    <header class="navbar">
        <div class="nav-left">
            <a href="usuario.php">
                <i class="fas fa-house"></i>
            </a>
        </div>
        <div class="nav-right">
            <a class="logout-btn" href="mis_tarjetas.php">Mis tarjetas</a>
            <a class="logout-btn" href="logout.php">Cerrar Sesión</a>
        </div>
    </header>

    <!-- Contenedor del Formulario -->
    <div class="form-container">
        
        <!-- Icono decorativo -->
        <div class="form-icon">
            <i class="fas fa-credit-card"></i>
        </div>

        <!-- Título -->
        <h1 class="form-title">Agregar Nueva Tarjeta</h1>
        <p class="form-subtitle">Completa los datos de tu tarjeta bancaria</p>

        <!-- Formulario -->
        <form action="procesar_tarjeta.php" method="POST" id="cardForm">
            
            <!-- Número de tarjeta -->
            <label for="numero">
                <i class="fas fa-credit-card"></i> Número de tarjeta
            </label>
            <div class="input-group">
                <input 
                    type="text" 
                    id="numero"
                    name="numero" 
                    maxlength="19" 
                    title="Ingresa los 16 dígitos de la tarjeta"
                    inputmode="numeric"
                    oninput="formatCardNumber(this)"
                    placeholder="0000 0000 0000 0000"
                    required
                >
                <div class="progress-line"></div>
            </div>

            <!-- Banco -->
            <label for="banco">
                <i class="fas fa-building-columns"></i> Banco
            </label>
            <div class="input-group">
                <select name="banco" id="banco" onchange="asignarImagen()" required>
                    <option value="">Seleccione un banco</option>
                    <option value="BBVA">BBVA</option>
                    <option value="Santander">Santander</option>
                    <option value="Banamex">Banamex</option>
                    <option value="HSBC">HSBC</option>
                    <option value="Scotiabank">Scotiabank</option>
                </select>
                <div class="progress-line"></div>
            </div>

            <!-- Fecha de registro -->
            <label for="fecha">
                <i class="fas fa-calendar"></i> Fecha de registro
            </label>
            <div class="input-group">
                <input type="date" id="fecha" name="fecha" required>
                <div class="progress-line"></div>
            </div>

            <!-- Saldo -->
            <label for="saldo">
                <i class="fas fa-dollar-sign"></i> Saldo inicial
            </label>
            <div class="input-group">
                <input 
                    type="number" 
                    id="saldo"
                    name="saldo" 
                    step="0.01" 
                    placeholder="0.00"
                    min="0"
                    required
                >
                <div class="progress-line"></div>
            </div>

            <!-- Campo oculto para la imagen -->
            <input type="hidden" name="imagen" id="imagen">

            <!-- Preview del banco seleccionado -->
            <div class="card-preview" id="cardPreview" style="display: none;">
                <p class="card-preview-title">Vista previa del banco</p>
                <img src="" alt="Logo banco" id="logoPreview" class="bank-logo-preview">
            </div>

            <!-- Botón de envío -->
            <button type="submit" id="submitBtn">
                <i class="fas fa-check-circle"></i> Guardar Tarjeta
            </button>

        </form>
    </div>

    <script>
    // Sistema de partículas animadas
    function createParticles() {
        const particlesContainer = document.getElementById('particles');
        const particleCount = 50;

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle');
            
            // Posición aleatoria horizontal
            particle.style.left = Math.random() * 100 + '%';
            
            // Tamaño aleatorio
            const size = Math.random() * 4 + 1;
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            
            // Duración de animación aleatoria
            const duration = Math.random() * 15 + 8;
            particle.style.animationDuration = duration + 's';
            
            // Delay aleatorio
            const delay = Math.random() * 5;
            particle.style.animationDelay = delay + 's';
            
            // Colores variados
            const colors = [
                'rgba(79, 125, 255, 0.6)',
                'rgba(79, 255, 173, 0.4)',
                'rgba(123, 158, 255, 0.5)'
            ];
            particle.style.background = colors[Math.floor(Math.random() * colors.length)];
            
            particlesContainer.appendChild(particle);
        }
    }

    // Asignar imagen del banco
    function asignarImagen() {
        const banco = document.getElementById("banco").value;
        const imagenInput = document.getElementById("imagen");
        const preview = document.getElementById("cardPreview");
        const logoPreview = document.getElementById("logoPreview");

        const imagenes = {
            "BBVA": "images/bancos/bbva.png",
            "Santander": "images/bancos/santander.png",
            "Banamex": "images/bancos/banamex.png",
            "HSBC": "images/bancos/hsbc.png",
            "Scotiabank": "images/bancos/scotiabank.png"
        };

        if (banco && imagenes[banco]) {
            imagenInput.value = imagenes[banco];
            logoPreview.src = imagenes[banco];
            preview.style.display = 'block';
        } else {
            imagenInput.value = "";
            preview.style.display = 'none';
        }
    }

    // Formatear número de tarjeta con espacios
    function formatCardNumber(input) {
        // Eliminar todo excepto números
        let value = input.value.replace(/[^0-9]/g, '');
        
        // Limitar a 16 dígitos
        value = value.substring(0, 16);
        
        // Guardar el valor sin espacios en el input
        input.value = value;
        
        // Actualizar el display con espacios cada 4 dígitos
        const formatted = value.replace(/(\d{4})(?=\d)/g, '$1 ');
        input.value = formatted;
    }

    // Validación en tiempo real
    const form = document.getElementById('cardForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('input', function() {
        const isValid = form.checkValidity();
        if (isValid) {
            submitBtn.style.opacity = '1';
        } else {
            submitBtn.style.opacity = '0.7';
        }
    });

    // Efecto de carga al enviar
    form.addEventListener('submit', function(e) {
        submitBtn.classList.add('loading');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
    });

    // Inicializar partículas al cargar
    window.addEventListener('load', createParticles);

    // Auto-focus en el primer input
    window.addEventListener('load', function() {
        document.getElementById('numero').focus();
    });

    // Animación de entrada para los labels
    const labels = document.querySelectorAll('label');
    labels.forEach((label, index) => {
        label.style.animationDelay = `${0.1 + (index * 0.1)}s`;
    });
    </script>

    <script>

        const input = document.getElementById("numero");

        input.addEventListener("input", () => {
            let value = input.value.replace(/\D/g, ""); // quitar todo excepto números
            value = value.substring(0, 16); // máximo 16 dígitos
            
            // insertar espacios cada 4 dígitos
            input.value = value.replace(/(.{4})/g, "$1 ").trim();
        });

        document.querySelector("form").addEventListener("submit", () => {
            input.value = input.value.replace(/\s/g, ""); // quitar espacios al enviar
        });
</script>


</body>
</html>
