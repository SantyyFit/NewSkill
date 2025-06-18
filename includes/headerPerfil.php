<?php
session_start();
// Recuperar el nombre del usuario desde la sesión


$usuario=$_GET['user'];



?>
<header class="perfil-header">
        <nav class="navbar-perfil" style="display: flex; justify-content:center;">
        <p class="Nombre-Usuario"><?php echo htmlspecialchars($usuario) ?></p>
        </nav>
    </header>