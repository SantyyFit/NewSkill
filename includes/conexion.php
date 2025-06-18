<?php
function Conectarse() {
    $host = "localhost";
    $usuario = "newskillcom_santy";
    $contrasena = "Diciembre1224#*";
    $bd = "newskillcom_newskill";

    $conexion = new mysqli($host, $usuario, $contrasena, $bd);

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Establecer codificación para caracteres especiales
    $conexion->set_charset("utf8");

    return $conexion;
}

// Esta línea crea la conexión al incluir este archivo
$conexion = Conectarse();
?>
