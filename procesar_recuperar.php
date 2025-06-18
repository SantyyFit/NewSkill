<?php
// Mostrar errores para depurar (quitar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir conexión a la base de datos
require 'includes/conexion.php';

// Incluir las clases de PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Función para generar token alfanumérico sin random_bytes()
function generarToken($longitud = 8) {
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $token = '';
    for ($i = 0; $i < $longitud; $i++) {
        $token .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $token;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['email'])) {
    $email = trim($_POST['email']);

    // Generar token seguro y expiración de 1 hora
    $token = generarToken(8);
    $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

    // Preparar consulta para verificar si existe el correo
    $stmt = $conexion->prepare("SELECT idusuario FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        // Actualizar token y expiración
        $stmt_update = $conexion->prepare("UPDATE usuarios SET reset_token = ?, reset_expira = ? WHERE email = ?");
        $stmt_update->bind_param("sss", $token, $expira, $email);
        if ($stmt_update->execute()) {
            // Configurar PHPMailer
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'newskill66@gmail.com';  // Cambia aquí por tu correo Gmail
                $mail->Password   = 'mvpvgsarwlaisfgf';  // Cambia aquí por tu contraseña de aplicación
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                //Recipients
                $mail->setFrom('newskill66@gmail.com', 'NewSkill'); // Cambia también aquí
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Recupera tu contraseña';
                $mail->Body = "
                    <h2>Recuperación de contraseña</h2>
                    <p>Usa este código para restablecer tu contraseña:</p>
                    <h3 style='color:#00bcd4;'>$token</h3>
                    <p>Este código expirará en 1 hora.</p>
                ";

                $mail->send();

                // Redirigir a resetear.php con email para ingresar token y nueva contraseña
                header("Location: cambiar_contrasena.php");
                exit();

            } catch (Exception $e) {
                echo "<p style='color:red; text-align:center;'>Error al enviar correo: {$mail->ErrorInfo}</p>";
            }
        } else {
            echo "<p style='color:red; text-align:center;'>Error al guardar token en la base de datos.</p>";
        }
    } else {
        echo "<p style='color:orange; text-align:center;'>Este correo no está registrado.</p>";
    }
} else {
    echo "<p style='color:red; text-align:center;'>Acceso no permitido.</p>";
}
?>
