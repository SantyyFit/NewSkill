<?php
include_once 'includes/session.php';
include_once 'includes/dbconexion.php';
include_once './includes/head.php';
$usuario = $_GET['user'];
$i = $_GET['i'];
?>

<link rel="stylesheet" href="css/cursos.css">

<body>
    <header class="header-cursos">
        <h1>Explora Nuestros Cursos</h1>
    </header>

    <section class="cursos-container">
        <div class="curso" style="background-image: linear-gradient(#0009, #0009), url(imagenes/programacion.jpg);">
            <h2><a href="proximamente.php?user=<?= $usuario ?>&i=<?= $i ?>">Programación</a></h2>
            <p>Aprende desarrollo web, backend, lógica y más.</p>
        </div>

        <div class="curso" style="background-image: linear-gradient(#0009, #0009), url(imagenes/deportes.jpg);">
            <h2><a href="proximamente.php?user=<?= $usuario ?>&i=<?= $i ?>">Deportes</a></h2>
            <p>Fútbol, entrenamiento físico, yoga y salud.</p>
        </div>

        <div class="curso" style="background-image: linear-gradient(#0009, #0009), url(imagenes/artes.jpg);">
            <h2><a href="proximamente.php?user=<?= $usuario ?>&i=<?= $i ?>">Artes</a></h2>
            <p>Dibujo, pintura, fotografía y creatividad.</p>
        </div>

        <div class="curso" style="background-image: linear-gradient(#0009, #0009), url(imagenes/matematicas.jpg);">
            <h2><a href="proximamente.php?user=<?= $usuario ?>&i=<?= $i ?>">Matemáticas</a></h2>
            <p>Álgebra, cálculo, geometría y lógica matemática.</p>
        </div>

        <div class="curso" style="background-image: linear-gradient(#0009, #0009), url(imagenes/videojuegos.jpg);">
            <h2><a href="proximamente.php?user=<?= $usuario ?>&i=<?= $i ?>">Videojuegos</a></h2>
            <p>Diseño, desarrollo y análisis de videojuegos.</p>
        </div>
    </section>

    <?php include_once 'includes/header.php'; ?>
</body>
