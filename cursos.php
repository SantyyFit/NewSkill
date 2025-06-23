<?php
include_once 'includes/session.php';
include_once 'includes/PDOdb.php';
include_once './includes/head.php';
$usuario = $_GET['user'];
$i = $_GET['i'];
$id_usuario = $_SESSION['idusuario'];



?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Mi Repositorio - NewSkill</title>
<style>
  /* Reset básico */
  * {
    box-sizing: border-box;
  }
  body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #0d1b2a;
    color: #cbd5e1;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px 15px;
  }
  h1 {
    color: #e0e7ff;
    margin-bottom: 20px;
  }
  button {
    background-color: #1e40af;
    border: none;
    color: #cbd5e1;
    padding: 10px 18px;
    margin: 5px 10px 20px 0;
    font-size: 1rem;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  button:hover {
    background-color: #3b82f6;
  }
  .toggle-btn {
    background-color: transparent;
    border: 2px solid #3b82f6;
    color: #3b82f6;
    padding: 8px 18px;
    margin: 0 10px 30px 0;
    font-weight: 600;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
  }
  .toggle-btn:hover,
  .toggle-btn.active {
    background-color: #3b82f6;
    color: #0d1b2a;
    border-color: #3b82f6;
  }

  /* Formulario Crear clase */
  .form-crear {
    display: none;
    width: 100%;
    max-width: 600px;
    background: #1e293b;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgb(59 130 246 / 0.3);
    margin-bottom: 40px;
  }
  .form-crear.active {
    display: block;
  }
  label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: #93c5fd;
  }
  input[type="text"],
  select,
  textarea,
  input[type="file"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #334155;
    border-radius: 6px;
    background: #0f172a;
    color: #cbd5e1;
    font-size: 1rem;
    transition: border-color 0.3s ease;
  }
  input[type="text"]:focus,
  select:focus,
  textarea:focus,
  input[type="file"]:focus {
    outline: none;
    border-color: #3b82f6;
  }
  textarea {
    resize: vertical;
  }

  hr {
    border: 0;
    border-top: 1px solid #334155;
    margin: 40px 0;
    width: 100%;
    max-width: 600px;
  }

  /* Contenedores de listas */
  .clases-lista {
    width: 100%;
    max-width: 600px;
    display: none;
    background: #1e293b;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgb(59 130 246 / 0.3);
    margin-bottom: 40px;
  }
  .clases-lista.activo {
    display: block;
  }
  .clases-lista h2 {
    margin-top: 0;
    color: #93c5fd;
  }
  ul {
    list-style: none;
    padding-left: 0;
  }
  ul li {
    padding: 12px 10px;
    margin-bottom: 8px;
    background: #0f172a;
    border-radius: 6px;
    border-left: 4px solid #3b82f6;
    transition: background-color 0.2s ease;
  }
  ul li:hover {
    background: #334155;
  }

  /* Responsive */
  @media (max-width: 650px) {
    button,
    .toggle-btn {
      width: 100%;
      margin-bottom: 15px;
    }
    .form-crear,
    .clases-lista {
      max-width: 100%;
      padding: 15px;
    }
  }
</style>
</head>
<body>

<h1>Mi Repositorio</h1>

<button id="btnCrearClase">Crear nueva clase</button>

<!-- Formulario oculto -->
<div id="formularioCrearClase" class="form-crear" style="max-width:500px; margin:auto; background:#1e293b; padding:20px; border-radius:8px; color:#e2e8f0; font-family:sans-serif;">
  <h2 style="color:#60a5fa;">Crear nueva clase</h2>
  <form action="crear_clase.php" method="POST" enctype="multipart/form-data">
      <label for="titulo">Título:</label><br>
      <input type="text" id="titulo" name="titulo" required style="width:100%; padding:8px; border-radius:4px; border:none; margin-bottom:15px;">

      <label for="descripcion">Descripción:</label><br>
      <textarea id="descripcion" name="descripcion" rows="5" required style="width:100%; padding:8px; border-radius:4px; border:none; margin-bottom:15px;"></textarea>

      <label for="visibilidad">Visibilidad:</label><br>
      <select id="visibilidad" name="visibilidad" style="width:100%; padding:8px; border-radius:4px; border:none; margin-bottom:15px;">
          <option value="privada">Privada</option>
          <option value="publica">Pública</option>
      </select>

      <label for="materiales">Materiales:</label><br>
      <input type="file" id="materiales" name="materiales[]" multiple style="margin-bottom:8px;">

      <div id="lista-archivos" style="color:#60a5fa; font-family: monospace; min-height: 20px; margin-bottom: 20px;">
        No has seleccionado archivos.
      </div>

      <button type="submit" name="crear_clase" style="background:#2563eb; color:#e2e8f0; padding:10px 20px; border:none; border-radius:5px; cursor:pointer; font-weight:bold;">
        Crear clase
      </button>
  </form>
</div>

<script>
  const inputArchivos = document.getElementById('materiales');
  const listaArchivos = document.getElementById('lista-archivos');

  inputArchivos.addEventListener('change', () => {
    const archivos = inputArchivos.files;
    if (archivos.length === 0) {
      listaArchivos.textContent = 'No has seleccionado archivos.';
      return;
    }

    let nombres = [];
    for (let i = 0; i < archivos.length; i++) {
      nombres.push(archivos[i].name);
    }

    listaArchivos.textContent = 'Archivos seleccionados: ' + nombres.join(', ');
  });
</script>


<!-- Botones para alternar -->
<div style="max-width:600px; width: 100%; margin-bottom: 20px;">
  <button class="toggle-btn active" onclick="mostrarLista('creadas', this)">Clases creadas</button>
  <button class="toggle-btn" onclick="mostrarLista('recibidas', this)">Clases recibidas</button>
</div>

<!-- Listas de clases -->
<div id="clasesCreadas" class="clases-lista activo">
  <h2>📘 Clases que he creado</h2>
  <ul>
  <?php
  $stmt = $pdo->prepare("
      SELECT c.id_clase, c.titulo, c.fecha_creacion
      FROM clases c
      WHERE c.id_creador = ?
      ORDER BY c.fecha_creacion DESC
  ");
  $stmt->execute([$id_usuario]);
  $clasesCreadas = $stmt->fetchAll();

if ($clasesCreadas) {
    foreach ($clasesCreadas as $clase) {
        $titulo = htmlspecialchars($clase['titulo']);
        $fecha = htmlspecialchars($clase['fecha_creacion']);
        $id = $clase['id_clase'];

echo "<li style='margin-bottom: 10px;'>
  📘 <a href='ver_clase.php?id=$id' style='color:#60a5fa; font-weight:bold; text-decoration:none;'>$titulo</a>
  <span style='color:#94a3b8; font-size: 0.9em;'> - $fecha</span>
  <button onclick=\"abrirModalCompartir($id, '$titulo')\" style='margin-left:10px; background:#3b82f6; color:white; padding:4px 8px; border:none; border-radius:4px; font-size:0.9em;'>Compartir</button>
</li>";

    }
} else {
    echo "<li>No has creado clases aún.</li>";
}
  ?>
  </ul>
</div>

<div id="clasesRecibidas" class="clases-lista">
  <h2>📥 Clases que me han compartido</h2>
  <ul>
  <?php
  $stmt = $pdo->prepare("
      SELECT c.id_clase, c.titulo, u.usuario AS creador
      FROM repositorio r
      JOIN clases c ON r.id_clase = c.id_clase
      JOIN usuarios u ON c.id_creador = u.idusuario
      WHERE r.id_usuario = ? AND c.id_creador != ?
      ORDER BY r.fecha_agregado DESC
  ");
  $stmt->execute([$id_usuario, $id_usuario]);
  $clasesRecibidas = $stmt->fetchAll();

  if ($clasesRecibidas) {
      foreach ($clasesRecibidas as $clase) {
          $id = $clase['id_clase'];
          $titulo = htmlspecialchars($clase['titulo']);
          $creador = htmlspecialchars($clase['creador']);

          echo "<li style='margin-bottom:10px;'>
                📥 <a href='ver_clase.php?id=$id' style='color:#60a5fa; font-weight:bold; text-decoration:none;'>$titulo</a>
                <span style='color:#94a3b8; font-size: 0.9em;'> de $creador</span>
                </li>";
      }
  } else {
      echo "<li>Aún no has recibido clases de otros usuarios.</li>";
  }
  ?>
  </ul>
</div>


<script>
  const btnCrear = document.getElementById('btnCrearClase');
  const formCrear = document.getElementById('formularioCrearClase');

  btnCrear.addEventListener('click', () => {
    if(formCrear.classList.contains('active')){
      formCrear.classList.remove('active');
      btnCrear.textContent = 'Crear nueva clase';
    } else {
      formCrear.classList.add('active');
      btnCrear.textContent = 'Cerrar formulario';
      window.scrollTo({top: formCrear.offsetTop - 20, behavior: 'smooth'});
    }
  });

  function mostrarLista(tipo, btn) {
    document.getElementById('clasesCreadas').classList.remove('activo');
    document.getElementById('clasesRecibidas').classList.remove('activo');

    document.querySelectorAll('.toggle-btn').forEach(b => b.classList.remove('active'));

    if(tipo === 'creadas') {
      document.getElementById('clasesCreadas').classList.add('activo');
    } else {
      document.getElementById('clasesRecibidas').classList.add('activo');
    }
    btn.classList.add('active');
  }
</script>

<script>
function abrirModalCompartir(idClase, titulo) {
  document.getElementById('inputIdClase').value = idClase;
  document.getElementById('tituloClaseModal').textContent = titulo;
  document.getElementById('modalCompartir').style.display = 'flex';
}

function cerrarModal() {
  document.getElementById('modalCompartir').style.display = 'none';
}
</script>


<div id="modalCompartir" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:#000000cc; z-index:9999; align-items:center; justify-content:center;">
  <div style="background:#1e293b; padding:25px; border-radius:10px; width:90%; max-width:400px; color:#e2e8f0; position:relative;">
    <span onclick="cerrarModal()" style="position:absolute; top:10px; right:15px; cursor:pointer; color:#94a3b8;">✖</span>
    <h3 style="color:#60a5fa; margin-bottom:15px;">Compartir clase: <span id="tituloClaseModal"></span></h3>

    <form action="compartir_clase.php" method="POST">
        <input type="hidden" name="id_clase" id="inputIdClase">

        <label>Nombre del usuario:</label>
        <input type="text" name="nombre_usuario" required style="width:100%; padding:8px; border-radius:5px; margin-bottom:10px; border:none; background:#334155; color:#e2e8f0;">

        <label>Permiso:</label>
        <select name="permiso" style="width:100%; padding:8px; border-radius:5px; margin-bottom:20px; background:#334155; color:#e2e8f0; border:none;">
            <option value="lectura">Lectura</option>
            <option value="editable">Editable</option>
        </select>

        <button type="submit" style="background:#38bdf8; color:#1e293b; padding:10px; width:100%; border:none; border-radius:6px; font-weight:bold; cursor:pointer;">
            Compartir clase
        </button>
    </form>
  </div>
</div>


</body>

<?include_once 'includes/header.php'?>

</html>
