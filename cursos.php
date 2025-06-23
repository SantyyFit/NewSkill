<?php
include_once 'includes/session.php';
include_once 'includes/PDOdb.php';
include_once './includes/head.php';
$usuario = $_GET['user'];
$i = $_GET['i'];
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
<div id="formularioCrearClase" class="form-crear">
  <h2>Crear nueva clase</h2>
  <form action="crear_clase.php" method="POST" enctype="multipart/form-data">
      <label>Título:</label>
      <input type="text" name="titulo" required>

      <label>Descripción:</label>
      <textarea name="descripcion" rows="5" required></textarea>

      <label>Visibilidad:</label>
      <select name="visibilidad">
          <option value="privada">Privada</option>
          <option value="publica">Pública</option>
      </select>

      <label>Materiales:</label>
      <input type="file" name="materiales[]" multiple>

      <button type="submit" name="crear_clase">Crear clase</button>
  </form>
</div>

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
          echo "<li><strong>".htmlspecialchars($clase['titulo'])."</strong> - ".htmlspecialchars($clase['fecha_creacion'])."</li>";
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
          echo "<li><strong>".htmlspecialchars($clase['titulo'])."</strong> de ".htmlspecialchars($clase['creador'])."</li>";
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

</body>

<?include_once 'includes/header.php'?>

</html>
