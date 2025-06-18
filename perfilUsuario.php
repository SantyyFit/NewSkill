<?php
include_once 'includes/dbconexion.php';
include_once 'includes/session.php';
include_once 'includes/head.php';

$UsuarioBuscado = $_GET['UsuarioB'];
$idUsuarioB = $_GET['idUsuarioB'];

$querybuscausuario = "SELECT * FROM usuarios WHERE idusuario = '$idUsuarioB'";
$consulta = mysql_query($querybuscausuario, $conexion);

while ($row = mysql_fetch_array($consulta)) {
    $usuarioencontrado = $row["usuario"];
    $nombreencontrado = $row["nombre"];
    $fotoperfil = $row["img_perfil"];
    $descripcion = $row["descripcion"];
    $nivel = $row["nivel"];  
    $telefono = $row["numero_telefono"]; 
}
?>
<link rel="stylesheet" href="css/perfilUsuario.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<header class="perfil-header">
    <nav class="navbar-perfil">
        <p class="Nombre-Usuario"><?php echo htmlspecialchars($usuarioencontrado); ?></p>
    </nav>
</header>

<body class="body-perfil">
    <main class="main-perfil">
        <div class="perfil-wrapper">
            <div class="foto-perfi-contenedor">
                <img src="<?= $fotoperfil ?>" alt="Foto de perfil" onclick="expandirImagen('<?= $fotoperfil ?>')">
            </div>
            <div class="datos-perfil_contenedor">
                <p>Seguidores 0</p>
                <p>Publicaciones 0</p>
                <p>Habilidades 3</p>
                <p>Cursos 2</p>
            </div>
            <div class="descripcion">
                <p style="color: black;">
                    <i class="fas fa-align-left"></i> "<?= $descripcion ?>"
                </p>
                <p style="color: black;">
                    <i class="fas fa-trophy"></i> Nivel: <?= $nivel ?>
                </p>
                <p style="color: black;">
                    <i class="fas fa-phone"></i> Teléfono: <?= $telefono ?>
                </p>
            </div>
            <div class="perzonalizar-contenedor">
                <div class="Editar-perfil">
                    <p><a href="chat.php?user=<?= $_GET['user'] ?>&id=<?= $idUsuarioB ?>&i=<?= $_GET['i'] ?>">Contactar</a></p>
                </div>
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
                <img src="imagenes/insignia1.png" alt="Insignia 1">
                <img src="imagenes/insignia2.png" alt="Insignia 2">
                <img src="imagenes/insignia3.png" alt="Insignia 3">
                <img src="imagenes/insignia4.png" alt="Insignia 4">
            </div>
            <div class="contenedor-recomendaciones">
                <p>Críticas y recomendaciones</p>
                <div class="critica-contenedor">
                    <p>DyyBautista:</p>
                    <p>Muy buenas explicaciones</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal para mostrar la imagen expandida -->
    <div id="modalFoto" class="modal-foto" onclick="cerrarModal(event)">
        <span class="cerrar-modal" onclick="cerrarModal(event)">&times;</span>
        <img class="modal-contenido" id="imgExpandidaPerfil">
    </div>

    <script>
        function expandirImagen(src) {
            const modal = document.getElementById("modalFoto");
            const img = document.getElementById("imgExpandidaPerfil");
            modal.style.display = "flex";
            img.src = src;
        }

        function cerrarModal(e) {
            if (e.target.id === "modalFoto" || e.target.classList.contains("cerrar-modal")) {
                document.getElementById("modalFoto").style.display = "none";
            }
        }
    </script>
</body>

<?php include_once 'includes/header.php'; ?>
