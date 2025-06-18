<?php
include_once 'includes/session.php'

?>

<?php
$usuario = $_GET['user'];
?>

<?
include_once 'includes/dbconexion.php'
?>

<?php

include_once './includes/head.php';

?>


<link rel="stylesheet" href="css/inicio.css">


<body>
    <header class="header-foro" id="Home">
        <h1>Foro de Aprendizaje</h1>
    </header>


    <section class="portfolio" id="Portfolio">
        <div class="portfolio_project-container">
            <div class="portfolio_project programacion" style=" background-image: linear-gradient(#0009, #0009), url(imagenes/pexels-markusspiske-965345.jpg)">
                <h2><a href="programacion.php?user=<?= $_GET["user"]; ?>&i=<?= $_GET["i"]; ?>" style="text-decoration: none; color:inherit">Programación</a></h2>
            </div>
            <div class="portfolio_project deportes" style=" background-image: linear-gradient(#0009, #0009), url(imagenes/freepik__candid-image-photography-natural-textures-highly-r__56599.jpeg)">
                <h2><a href="deportes.php?user=<?= $_GET["user"]; ?>&i=<?= $_GET["i"]; ?>" style="text-decoration: none; color:inherit">Deportes</a></h2>
            </div>
            <div class="portfolio_project artes" style="background-image: linear-gradient(#0009, #0009), url(imagenes/pexels-cottonbro-3777876.jpg)">
                <h2><a href="artes.php?user=<?= $_GET["user"]; ?>&i=<?= $_GET["i"]; ?>" style="text-decoration: none; color:inherit">Artes</a></h2>
            </div>
            <div class="portfolio_project matematicas" style=" background-image: linear-gradient(#0009, #0009), url(imagenes/pexels-silverkblack-22690752.jpg)">
                <h2><a href="matematicas.php?user=<?= $_GET["user"]; ?>&i=<?= $_GET["i"]; ?>" style="text-decoration: none; color:inherit">Matemáticas</a></h2>
            </div>
            <div class="portfolio_project videojuegos" style=" background-image: linear-gradient(#0009, #0009), url(imagenes/pexels-lulizler-3165335.jpg)">
                <h2><a href="videojuegos.php?user=<?= $_GET["user"]; ?>&i=<?= $_GET["i"]; ?>" style="text-decoration: none; color:inherit">Videojuegos</a></h2>
            </div>
        </div>
    </section>




    <?
    include_once 'includes/header.php';
    ?>
</body>