<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['idusuario'])) {
    die("Debes iniciar sesión para ver las notificaciones.");
}

$id_usuario = $_SESSION['idusuario'];

try {
    $pdo = new PDO("mysql:host=localhost;dbname=newskillcom_newskill;charset=utf8", "newskillcom_santy", "Diciembre1224#*");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error conectando a la base de datos: " . $e->getMessage());
}

try {
    $stmt = $pdo->prepare("SELECT id, tipo, mensaje, url FROM notificaciones WHERE idusuario = ? AND visto = 0 ORDER BY id DESC");
    $stmt->execute([$id_usuario]);
    $notificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Error al obtener notificaciones: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>NewSkill</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="imagenes/logons50.png">
    <link rel="stylesheet" href="css/notificaciones.css">
</head>
<body>

<div class="notificaciones-wrapper">
    <h3>Notificaciones 
        <?php if (count($notificaciones) > 0): ?>
            <span class="globo"><?= count($notificaciones) ?></span>
        <?php endif; ?>
    </h3>

    <?php if (empty($notificaciones)): ?>
        <p>No tienes notificaciones nuevas.</p>
    <?php else: ?>
        <?php foreach ($notificaciones as $n): ?>
            <div class="notificacion">
                <a href="marcar_visto.php?id=<?= $n['id'] ?>&url=<?= urlencode($n['url']) ?>">
                    <?= htmlspecialchars($n['mensaje']) ?>
                </a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
function marcarComoVisto(event, id, url) {
    event.preventDefault();
    fetch('marcar_visto.php?id=' + id, { method: 'GET' })
        .then(response => {
            if (!response.ok) throw new Error('Error al marcar como visto');
            window.location.href = url;
        })
        .catch(error => {
            console.error('Falló:', error);
            window.location.href = url;
        });
}
</script>

<?php include 'includes/header.php'; ?>
</body>
</html>
