<?php
include_once './includes/head.php';

// Mensaje de error del servidor (PHP)
$mensajeError = "";
$usuarioPrellenado = "";

if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'usuarioexistente':
            $mensajeError = "Ese nombre de usuario ya existe. Intenta con otro.";
            break;
        case 'passdiff':
            $mensajeError = "Las contraseñas no coinciden.";
            break;
    }
}

if (isset($_GET['user'])) {
    $usuarioPrellenado = htmlspecialchars($_GET['user']);
}
?>

<link rel="stylesheet" href="css/registro.css">

<body class="body-r1">
    <div class="login">
        <div class="login-texto">Registro NewSkill</div>
        <div class="login-imagen">
            <img src="imagenes/LogoNS250.png" alt="Logo NewSkill">
        </div>
    </div>

    <div class="incio-sesion">
        <form name="Registro" action="guardarNuevoUsuario.php" method="post">

            <div class="input-container">
                <ion-icon name="person-circle-outline" class="input-icon"></ion-icon>
                <input name="nombre" id="id_ipt_nombre" type="text" maxlength="50" placeholder="Nombre" />
            </div>

            <div class="input-container">
                <ion-icon name="person-outline" class="input-icon"></ion-icon>
                <input name="usuario" id="id_ipt_usuario" type="text" maxlength="50" placeholder="Usuario"
                    value="<?= $usuarioPrellenado ?>" />
            </div>

            <div class="input-container">
                <ion-icon name="lock-closed-outline" class="input-icon"></ion-icon>
                <input name="password" id="id_ipt_password" type="password" maxlength="50" placeholder="Contraseña" />
            </div>

            <div class="input-container">
                <ion-icon name="lock-closed-outline" class="input-icon"></ion-icon>
                <input name="password2" id="id_ipt_password2" type="password" maxlength="50" placeholder="Confirmar contraseña" />
            </div>

            <div id="error-mensajes">
                <?php if (!empty($mensajeError)) : ?>
                    <div class="error-msg"><?= $mensajeError ?></div>
                <?php endif; ?>
            </div>

            <div class="submit-container">
                <input type="submit" name="registro" class="boton-entrar" value="Registrar">
            </div>
        </form>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        document.querySelector('form[name="Registro"]').addEventListener('submit', function(e) {
            const nombre = document.getElementById('id_ipt_nombre');
            const usuario = document.getElementById('id_ipt_usuario');
            const password = document.getElementById('id_ipt_password');
            const password2 = document.getElementById('id_ipt_password2');
            const errorBox = document.getElementById('error-mensajes');

            [nombre, usuario, password, password2].forEach(el => el.classList.remove('input-error'));
            errorBox.innerHTML = '';

            function mostrarError(mensaje) {
                const div = document.createElement('div');
                div.classList.add('error-msg');
                div.textContent = mensaje;
                errorBox.appendChild(div);
            }

            if (nombre.value.trim() === '') {
                nombre.classList.add('input-error');
                mostrarError('El nombre es obligatorio.');
                e.preventDefault();
                return;
            }

            if (usuario.value.trim() === '') {
                usuario.classList.add('input-error');
                mostrarError('El usuario es obligatorio.');
                e.preventDefault();
                return;
            }

            if (password.value.trim() === '') {
                password.classList.add('input-error');
                mostrarError('La contraseña es obligatoria.');
                e.preventDefault();
                return;
            }

            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
            if (!regex.test(password.value)) {
                password.classList.add('input-error');
                mostrarError('La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número.');
                e.preventDefault();
                return;
            }

            if (password2.value.trim() === '') {
                password2.classList.add('input-error');
                mostrarError('Confirma tu contraseña.');
                e.preventDefault();
                return;
            }

            if (password.value !== password2.value) {
                password2.classList.add('input-error');
                mostrarError('Las contraseñas no coinciden.');
                e.preventDefault();
                return;
            }
        });
    </script>
</body>