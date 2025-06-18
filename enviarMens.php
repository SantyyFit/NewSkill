<?php
session_start();
include_once 'includes/PDOdb.php';


// Verificar conexión a la base de datos
if (!$pdo) {
    die("Error de conexión a la base de datos");
}

// Verificar sesión
if (!isset($_SESSION['idusuario'])) {
    die("No se ha iniciado sesión correctamente.");
}

if (isset($_POST['idReceptor']) && isset($_POST['mensaje'])) {
    $idReceptor = $_POST['idReceptor'];
    $mensaje = $_POST['mensaje'];
    $idEmisor = $_SESSION['idusuario'];

    if (!empty($mensaje) && !empty($idReceptor)) {
        try {
            $sql = "INSERT INTO mensajes (id_emisor, id_receptor, mensaje, fecha) 
                    VALUES (:idEmisor, :idReceptor, :mensaje, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':idEmisor' => $idEmisor,
                ':idReceptor' => $idReceptor,
                ':mensaje' => $mensaje
            ]);
            echo "Mensaje enviado correctamente";
        } catch (PDOException $e) {
            die("Error al enviar el mensaje: " . $e->getMessage());
        }
    } else {
        echo "El mensaje o el receptor no son válidos.";
    }
} else {
    echo "Faltan parámetros para enviar el mensaje.";
}
?>