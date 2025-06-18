<?php
session_start();
include_once 'includes/PDOdb.php';  // Asegúrate de que la conexión a la base de datos esté incluida



// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['idusuario'])) {
    echo "No se ha iniciado sesión correctamente.";
    exit; // Detener la ejecución si no hay sesión
}

if (isset($_GET['idReceptor'])) {
    $idReceptor = $_GET['idReceptor'];
    $idEmisor = $_SESSION['idusuario'];  // Suponiendo que el ID de usuario está en la sesión

    try {
        // Obtener los mensajes entre el emisor y el receptor
        $sql = "SELECT * FROM mensajes 
                WHERE (id_emisor = :idEmisor AND id_receptor = :idReceptor) 
                   OR (id_emisor = :idReceptor AND id_receptor = :idEmisor) 
                ORDER BY fecha ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':idEmisor' => $idEmisor,
            ':idReceptor' => $idReceptor
        ]);

        $mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Mostrar los mensajes
        foreach ($mensajes as $mensaje) {
            $usuario = ($mensaje['id_emisor'] == $idEmisor) ? 'yo' : 'otro'; // Definir quién envió el mensaje
            echo '<div class="' . $usuario . '">' . htmlspecialchars($mensaje['mensaje']) . '</div>';
        }

    } catch (PDOException $e) {
        echo "Error al recibir los mensajes: " . $e->getMessage();
    }
} else {
    echo "No se proporcionó el ID del receptor.";
}
?>
