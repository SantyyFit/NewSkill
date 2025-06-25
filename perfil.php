<?php
session_start();

// Verificación de acceso (solo si quieres proteger el acceso)
if (isset($_SESSION['access']) && isset($_GET['user'])) {
    $sesion = $_SESSION['access'];
    $usuario = $_GET['user'];

    if ($sesion !== md5($usuario)) {
        header("Location: login.php");
        exit();
    }
}

include_once 'includes/head.php';
include_once 'includes/dbconexion.php';
include_once 'includes/headerPerfil.php';

// Verificamos que se reciba el parámetro 'i'
if (!isset($_GET['i'])) {
    echo "<p>Error: No se especificó el ID del usuario.</p>";
    exit();
}

$idUsuarioHash = $_GET["i"];
$query = "SELECT * FROM usuarios WHERE MD5(idusuario) = '$idUsuarioHash'";
$resultt = mysql_query($query, $conexion);

if (!$resultt || mysql_num_rows($resultt) === 0) {
    echo "<p>No se encontró el usuario.</p>";
    exit();
}

$f = mysql_fetch_array($resultt);
$idusuarioLimpio = $f["idusuario"];
$Nombre = $f["usuario"];
$rutaimagen = $f["img_perfil"];
$descripcion = $f["descripcion"];
$nivel = $f["nivel"];
$telefono = $f["numero_telefono"];

$yo = $_SESSION['idusuario'];
$ya_sigue = false;

// Verificamos si el usuario logueado ya sigue a este perfil
$seguirConsulta = mysql_query("SELECT * FROM seguidores WHERE id_usuario = $yo AND id_seguido = $idusuarioLimpio", $conexion);
if (mysql_num_rows($seguirConsulta) > 0) {
    $ya_sigue = true;
}

// Contadores seguidores y seguidos
$seguidores = mysql_query("SELECT COUNT(*) as total FROM seguidores WHERE id_seguido = $idusuarioLimpio", $conexion);
$seguidores_count = mysql_fetch_assoc($seguidores)['total'];

$seguidos = mysql_query("SELECT COUNT(*) as total FROM seguidores WHERE id_usuario = $idusuarioLimpio", $conexion);
$seguidos_count = mysql_fetch_assoc($seguidos)['total'];
?>

<link rel="stylesheet" href="css/perfill.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<body class="body-perfil">
    <main class="main-perfil">
        <div class="perfil-wrapper">

            <div class="foto-perfi-contenedor">
                <img src="<?= $rutaimagen ?>" id="perfil-foto" class="perfil-img" alt="Foto de perfil">
            </div>

            <!-- Modal para ampliar imagen -->
            <div id="modal-foto" class="modal-foto">
                <span class="cerrar-modal">&times;</span>
                <img class="modal-contenido" id="img-ampliada" alt="Imagen ampliada">
            </div>

            <div class="datos-perfil_contenedor">
                <p><a href="verSeguidores.php?id=<?= $idusuarioLimpio ?>&user=<?=$_GET['user']?>&i=<?=$_GET ['i']?>" class="link-seguidores">Seguidores <?= $seguidores_count ?></a></p>
                <p><a href="verSeguidos.php?id=<?= $idusuarioLimpio ?>&user=<?=$_GET['user']?>&i=<?=$_GET ['i']?>" class="link-seguidos">Seguidos <?= $seguidos_count ?></a></p>
                <p>Publicaciones 0</p>
                <p>Habilidades 3</p>
                <p>Cursos 2</p>
            </div>

            <div class="descripcion">
                <p><i class="fas fa-align-left"></i> "<?= $descripcion ?>"</p>
                <p><i class="fas fa-trophy"></i> Nivel: <?= $nivel ?></p>
                <p><i class="fas fa-phone"></i> Teléfono: <?= $telefono ?></p>
            </div>

            <div class="perzonalizar-contenedor">
                <div class="Editar-perfil">
                    <p><a href="editarPerfil.php?user=<?= $_GET["user"]; ?>&i=<?= $_GET["i"]; ?>">Editar Perfil</a></p>
                </div>
                <div class="Compartir-perfil">
                    <p><a href="proximamente.php">Boletas</a></p>
                </div>
                <?php if ($yo != $idusuarioLimpio): ?>
                <div class="Editar-perfil">
                    <button id="boton-seguir" data-id="<?= $idusuarioLimpio ?>" class="boton-seguir">
                        <?= $ya_sigue ? "Siguiendo" : "Seguir" ?>
                    </button>
                </div>
                <?php endif; ?>
            </div>

            <div class="habilidades-contenedor">
                <p>HABILIDADES</p>
                <div class="habilidad-card" style="background-image: url('imagenes/Guitarra.png');">
                    <p>Guitarra: Avanzado</p>
                </div>
                <div class="habilidad-card" style="background-image: url('imagenes/programacion.png');">
                    <p>Programación: Intermedio</p>
                </div>
                <div class="habilidad-card" style="background-image: url('imagenes/matematicas.png');">
                    <p>Matemáticas: Amateur</p>
                </div>
            </div>

            <div class="insignias-contenedor">
                <img src="imagenes/insignia1.png">
                <img src="imagenes/insignia2.png">
                <img src="imagenes/insignia3.png">
                <img src="imagenes/insignia4.png">
            </div>

        </div>
    </main>

    <?php include_once 'includes/header.php'; ?>

    <script>
        const modal = document.getElementById("modal-foto");
        const img = document.getElementById("perfil-foto");
        const modalImg = document.getElementById("img-ampliada");
        const cerrar = document.getElementsByClassName("cerrar-modal")[0];

        img.onclick = function () {
            modal.style.display = "block";
            modalImg.src = this.src;
        }

        cerrar.onclick = function () {
            modal.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }

        // AJAX para botón seguir
        document.getElementById('boton-seguir')?.addEventListener('click', function () {
            const boton = this;
            const idUsuario = boton.getAttribute('data-id');

            fetch('seguir_ajax.php?id=' + idUsuario)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    return;
                }
                boton.textContent = data.accion === 'siguiendo' ? 'Siguiendo' : 'Seguir';

                document.querySelector('.link-seguidores').textContent = 'Seguidores ' + data.seguidores_count;
                document.querySelector('.link-seguidores').href = 'verSeguidores.php?id=' + idUsuario;

                document.querySelector('.link-seguidos').textContent = 'Seguidos ' + data.seguidos_count;
                document.querySelector('.link-seguidos').href = 'verSeguidos.php?id=' + idUsuario;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al procesar la solicitud.');
            });
        });
    </script>
</body>
