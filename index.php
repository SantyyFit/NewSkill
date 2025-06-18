<?php
include_once './includes/head.php';

$mensajeError = "";

if (isset($_GET['r']) && $_GET['r'] == 'error') {
    $mensajeError = "Usuario o contraseña son incorrectos.";
}
?>

<link rel="stylesheet" href="css/index.css">

<body>
    <div>
        <div>Login NewSkill</div>
        <div>
            <img src="imagenes/LogoNS250.png">
        </div>
    </div>

    <div>

        <form name="Registro" action="logueo.php" method="post">
            <div class="input-container">
                <ion-icon name="person" class="input-icon"></ion-icon>
                <input name="usuario" id="id_ipt_usuario" type="text" maxlength="50" placeholder="Usuario" />
            </div>

            <div class="input-container">
                <ion-icon name="lock-closed" class="input-icon"></ion-icon>
                <input name="password" id="id_ipt_password" type="password" maxlength="50" placeholder="Contraseña" />
            </div>
            <style>
                .error-msg {
                    background-color:#3a3a4f;
                    color: #d8000c !important;
                    border: 1px solid #d8000c !important;
                    padding: 10px 15px;
                    margin: 10px 0;
                    border-radius: 6px;
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    font-weight: 600;
                    font-size: 14px;
                    box-shadow: 0 2px 6px rgba(216, 0, 12, 0.25);
                }
                .recuperar{
                    font-size: small;
                }
            </style>
            <?php if (!empty($mensajeError)) : ?>
                <div class="error-msg"><?= $mensajeError ?></div>
            <?php endif; ?>

            <div>
            <a class="recuperar" href="recuperar.php">¿Olvidó su contraseña?</a>
            </div>

            <div>
                <input type="submit" name="entrar" value="Entrar">
            </div>

            <div>
                Si no tiene cuenta <a href="registro.php">Regístrese aquí</a>
            </div>
            
        </form>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        document.querySelector('form[name="Registro"]').addEventListener('submit', function(e) {
            const usuario = document.getElementById('id_ipt_usuario');
            const password = document.getElementById('id_ipt_password');
            let valido = true;

            usuario.classList.remove('input-error');
            password.classList.remove('input-error');

            if (usuario.value.trim() === '') {
                usuario.classList.add('input-error');
                valido = false;
            }

            if (password.value.trim() === '') {
                password.classList.add('input-error');
                valido = false;
            }

            if (!valido) {
                e.preventDefault();
            }
        });


        // Espera 5 segundos (5000 ms) y luego oculta el mensaje
        setTimeout(() => {
            const errorMsg = document.querySelector('.error-msg');
            if (errorMsg) {
                errorMsg.style.transition = 'opacity 0.5s ease';
                errorMsg.style.opacity = '0';
                setTimeout(() => errorMsg.remove(), 500);
            }
        }, 5000);
    </script>
</body>