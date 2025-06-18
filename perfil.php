<?php include_once 'includes/head.php'; ?>
<?php include_once 'includes/dbconexion.php'; ?>
<?php include_once 'includes/headerPerfil.php'; ?>

<link rel="stylesheet" href="css/perfil.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<body class="body-perfil">
    <main class="main-perfil">
        <div class="perfil-wrapper">
            <div class="foto-perfi-contenedor">
                <?php
                $idUsuario = $_GET["i"];
                $query = "SELECT * FROM usuarios WHERE MD5(idusuario) = '$idUsuario'";
                $resultt = mysql_query($query, $conexion);

                while ($f = mysql_fetch_array($resultt)) {
                    $idusuarioLimpio = $f["idusuario"];
                    $Nombre = $f["usuario"];
                    $rutaimagen = $f["img_perfil"];
                    $descripcion = $f["descripcion"];
                    $nivel = $f["nivel"];
                    $telefono = $f["numero_telefono"];
                }
                ?>
                <img src="<?= $rutaimagen ?>" id="perfil-foto" class="perfil-img" alt="Foto de perfil">
            </div>

            <!-- Modal para ampliar imagen -->
            <div id="modal-foto" class="modal-foto">
                <span class="cerrar-modal">&times;</span>
                <img class="modal-contenido" id="img-ampliada" alt="Imagen ampliada">
            </div>

            <div class="datos-perfil_contenedor">
                <p>Seguidores 0</p>
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

        img.onclick = function() {
            modal.style.display = "block";
            modalImg.src = this.src;
        }

        cerrar.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>