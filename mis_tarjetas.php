<?php
session_start();
include "conexion.php";

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION["id"];

// Consulta
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

    <header class="navbar">
        <div class="nav-left">
            <a href="usuario.php"><i class="fas fa-house"></i></a>
        </div>
        <div class="nav-right">
            <a class="logout-btn" href="agregar_tarjeta.php">Agregar tarjeta</a>
            <a class="logout-btn" href="logout.php">Cerrar Sesión</a>
        </div>
    </header>

    <h2 class="titulo">Mis Tarjetas</h2>

    <div class="contenedor-tarjetas">
        <?php if (count($result) > 0): ?>
            <?php foreach($result as $row) { 
                // Lógica de Estado (Activa/Inactiva)
                $clase_estado = ($row['estado'] == 0) ? 'inactiva' : '';
                $texto_boton = ($row['estado'] == 0) ? 'Activar' : 'Desactivar';
                $icono_boton = ($row['estado'] == 0) ? 'fa-toggle-off' : 'fa-toggle-on';

                // Lógica de Número Oculto
                $numero_real = $row['numero'];
                $numero_oculto = "**** **** **** " . substr($row['numero'], -4);
            ?>
                <div class="tarjeta-item <?= $clase_estado ?>">
                    <div class="tarjeta-imagen">
                        <img src="<?=$row['imagen']?>" alt="Banco">
                    </div>

                    <div class="tarjeta-info">
                        <span class="banco"><?=$row['banco']?></span>
                        
                        <div class="numero-wrapper">
                            <span class="numero" id="num_<?=$row['id']?>"><?= $numero_oculto ?></span>
                            
                            <button type="button" class="btn-ojo" 
                                    onclick="toggleNumero('<?=$row['id']?>', '<?=$numero_real?>', '<?=$numero_oculto?>')">
                                <i class="fas fa-eye" id="icon_<?=$row['id']?>"></i>
                            </button>
                        </div>

                        <span class="saldo">$<?=number_format($row['saldo'], 2)?></span>
                    </div>

                    <form action="cambiar_estado.php" method="POST" class="form-toggle">
                        <input type="hidden" name="id_tarjeta" value="<?=$row['id']?>">
                        <button type="submit" class="btn-estado" title="<?= $texto_boton ?>">
                            <i class="fas <?= $icono_boton ?>"></i>
                        </button>
                    </form>
                </div>
            <?php } ?>
        <?php else: ?>
            <p style="color: white; text-align: center;">No tienes tarjetas registradas aún.</p>
        <?php endif; ?>
    </div>

    <script>
    function toggleNumero(id, real, oculto) {
        let span = document.getElementById("num_" + id);
        let icon = document.getElementById("icon_" + id);
        
        // Comprobamos qué texto tiene actualmente
        if (span.innerText === oculto) {
            span.innerText = real; // Mostramos el número real
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash"); // Cambiamos icono a "ojo tachado"
            icon.style.color = "#fff"; // Resaltamos que está visible
        } else {
            span.innerText = oculto; // Volvemos a ocultar
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
            icon.style.color = ""; // Volvemos al color normal
        }
    }
    </script>

</body>
</html>