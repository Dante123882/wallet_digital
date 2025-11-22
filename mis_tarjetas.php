<?php
session_start();
include "conexion.php";

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION["id"];

// Consulta tarjetas del usuario
$sql = "SELECT * FROM tarjetas WHERE id_usuario = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([":id" => $id]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Tarjetas</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/mis_tarjetas.css">
</head>
<body>

    <div class="gradient-bg"></div>
    <div class="particles" id="particles"></div>

    <header class="navbar">
        <div class="nav-left">
            <a href="usuario.php"><i class="fas fa-house"></i></a>
        </div>
        <div class="nav-right">
            <a class="logout-btn" href="agregar_tarjeta.php">Agregar tarjeta</a>
            <a class="logout-btn" href="logout.php">Cerrar Sesión</a>
        </div>
    </header>

    <div class="contenedor-principal">
        <h2 class="titulo">Mis Tarjetas</h2>

        <div class="contenedor-tarjetas">

            <?php if (count($result) > 0): ?>
                <?php foreach ($result as $row): 

                    // Estado
                    $clase_estado = ($row['estado'] == 0) ? 'inactiva' : '';
                    $texto_boton = ($row['estado'] == 0) ? 'Activar' : 'Desactivar';
                    $icono_boton = ($row['estado'] == 0) ? 'fa-toggle-off' : 'fa-toggle-on';

                    // Números
                    $numero_real = $row['numero'];
                    $numero_oculto = "**** **** **** " . substr($row['numero'], -4);

                ?>

                <div class="tarjeta-item <?= $clase_estado ?>">
                    <div class="tarjeta-imagen">
                        <img src="<?= $row['imagen'] ?>" alt="banco">
                    </div>

                    <div class="tarjeta-info">

                        <span class="banco"><?= $row['banco'] ?></span>

                        <!-- NÚMERO OCULTO POR DEFECTO -->
                        <div class="numero-wrapper">
                            <span class="numero" id="num_<?= $row['id'] ?>">
                                <?= $numero_oculto ?>
                            </span>

                            <button type="button" class="btn-ojo"
                                onclick="toggleNumero(
                                    '<?= $row['id'] ?>',
                                    '<?= htmlspecialchars($numero_real, ENT_QUOTES) ?>',
                                    '<?= htmlspecialchars($numero_oculto, ENT_QUOTES) ?>'
                                )">
                                <i class="fas fa-eye" id="icon_<?= $row['id'] ?>"></i>
                            </button>
                        </div>

                        <span class="saldo">$<?= number_format($row['saldo'], 2) ?></span>
                    </div>

                    <form action="cambiar_estado.php" method="POST" class="form-toggle">
                        <input type="hidden" name="id_tarjeta" value="<?= $row['id'] ?>">
                        <button type="submit" class="btn-estado">
                            <i class="fas <?= $icono_boton ?>"></i> <?= $texto_boton ?>
                        </button>
                    </form>
                </div>

                <?php endforeach; ?>

            <?php else: ?>
                <p>No tienes tarjetas registradas aún.</p>
            <?php endif; ?>

        </div>
    </div>

    <script>
function toggleNumero(id, real, oculto) {
    const span = document.getElementById("num_" + id);
    const icon = document.getElementById("icon_" + id);

    if (!span || !icon) {
        console.warn("Elemento no encontrado para id:", id);
        return;
    }

    // Normalizamos y quitamos espacios extras
    const actual = span.textContent.replace(/\u00A0/g,' ').trim();
    const r = String(real).replace(/\u00A0/g,' ').trim();
    const o = String(oculto).replace(/\u00A0/g,' ').trim();

    // Logs para depuración: abre la consola y mira estos valores
    console.log("toggleNumero -> id:", id, { actual, oculto:o, real:r });

    if (actual === o) {
        span.textContent = r;
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
        icon.style.color = "#fff";
    } else {
        span.textContent = o;
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
        icon.style.color = "";
    }
}
</script>


    <script>
    // ======================
    // PARTICULAS DE FONDO
    // ======================
    function createParticles() {
        const container = document.getElementById('particles');
        const count = 50;

        for (let i = 0; i < count; i++) {
            const p = document.createElement('div');
            p.classList.add('particle');

            p.style.left = Math.random() * 100 + '%';

            const size = Math.random() * 3 + 1;
            p.style.width = size + 'px';
            p.style.height = size + 'px';

            p.style.animationDuration = (Math.random() * 10 + 10) + 's';
            p.style.animationDelay = (Math.random() * 5) + 's';
            p.style.opacity = (Math.random() * 0.5 + 0.3);

            container.appendChild(p);
        }
    }
    window.addEventListener('load', createParticles);
    </script>

</body>
</html>
