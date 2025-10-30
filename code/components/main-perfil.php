<?php
$usuario = $usuario ?? [];
$es_cliente = $es_cliente ?? false;
$es_proveedor = $es_proveedor ?? false;
$proveedor = $es_proveedor ? $usuario : null;

$calif_cliente = $usuario['calif_cliente'] ?? null;
$calif_proveedor = $usuario['calif_proveedor'] ?? null;

$usuario_actual_id = $_SESSION['usuario']['id'] ?? null;
$es_propietario = ($usuario_actual_id === $usuario['id']);
?>

<main class="perfil-view">
  <div class="perfil-card">

    <!-- Imagen / Avatar -->
    <div class="perfil-img-wrapper" <?php if($es_propietario) echo 'id="editablePerfil" data-usuario-id="'.$usuario["id"].'"'; ?>>
      <?php
        $perfilImg = $usuario['foto_perfil'] 
            ? 'data:image/png;base64,' . base64_encode($usuario['foto_perfil'])
            : 'storage/userThumb.svg';
      ?>
      <img class="perfil-img" src="<?= $perfilImg ?>" alt="Avatar de <?= htmlspecialchars($usuario['nombre']) ?>">
      <?php if($es_propietario): ?>
        <div class="perfil-edit-overlay">
          <img src="css/storage/editPerfil.svg" alt="Editar perfil">
        </div>
      <?php endif; ?>
    </div>

    <!-- Nombre -->
    <div class="graph-label nombre">
      <span><?= htmlspecialchars($usuario['nombre']) ?></span>
    </div>

    <!-- Datos -->
    <div class="info-item">
      <div class="icon mail"></div>
      <div class="graph-label correo">
        <img id="correo" class="icon" src="css/storage/correoDia.svg" alt="Correo:">
        <label>Correo:</label>
        <span><?= htmlspecialchars($usuario['correo']) ?></span>
      </div>
    </div>

    <div class="info-item">
      <div class="icon phone"></div>
      <div class="graph-label telefono">
        <img id="telefono" class="icon" src="css/storage/telefonitoDia.svg" alt="Teléfono:">
        <label>Teléfono:</label>
        <span><?= htmlspecialchars($usuario['telefono']) ?></span>
      </div>
    </div>

    <div class="info-item">
      <div class="icon calendar"></div>
      <div class="graph-label fecha">
        <img id="fecha" class="icon" src="css/storage/calendarioDia.svg" alt="Fecha de creación:">
        <label>Fecha de creación:</label>
        <span><?= htmlspecialchars($usuario['fecha_creacion']) ?></span>
      </div>
    </div>

    <!-- Estrellas Cliente -->
    <?php if ($es_cliente && $calif_cliente !== null): ?>
      <?php $stars_cliente = round($calif_cliente / 2); ?>
      <div class="info-item">
        <label>Calificación como cliente:</label>
        <div class="rating">
          <?php for ($i=5; $i>=1; $i--): ?>
            <input type="radio" name="rate_cliente" id="star_cliente<?= $i ?>" value="<?= $i ?>" <?= $i == $stars_cliente ? 'checked' : '' ?> disabled>
            <label for="star_cliente<?= $i ?>" title="<?= $i ?> estrellas"></label>
          <?php endfor; ?>
        </div>
        <span><?= htmlspecialchars($calif_cliente) ?>/10</span>
      </div>
    <?php endif; ?>

    <!-- Estrellas Proveedor -->
    <?php if ($es_proveedor && $calif_proveedor !== null): ?>
      <?php $stars_proveedor = round($calif_proveedor / 2); ?>
      <div class="info-item">
        <label>Calificación como proveedor:</label>
        <div class="rating">
          <?php for ($i=5; $i>=1; $i--): ?>
            <input type="radio" name="rate_proveedor" id="star_proveedor<?= $i ?>" value="<?= $i ?>" <?= $i == $stars_proveedor ? 'checked' : '' ?> disabled>
            <label for="star_proveedor<?= $i ?>" title="<?= $i ?> estrellas"></label>
          <?php endfor; ?>
        </div>
        <span><?= htmlspecialchars($calif_proveedor) ?>/10</span>
      </div>
    <?php endif; ?>

    <!-- Información extra del proveedor -->
    <?php if ($es_proveedor): ?>
      <div class="info-item">
        <div class="icon note"></div>
        <div class="graph-label">
          <label>Referencias:</label>
          <span><?= htmlspecialchars($proveedor['referencias'] ?? 'Ninguna') ?></span>
        </div>
      </div>

      <div class="info-item">
        <div class="icon sales"></div>
        <div class="graph-label">
          <label>Cantidad de ventas:</label>
          <span><?= htmlspecialchars($proveedor['cantidad_ventas'] ?? 0) ?></span>
        </div>
      </div>
    <?php endif; ?>

    <!-- Botón volver -->
    <div class="buttons">
      <a href="index.php?controller=usuario&action=index">
        <button class="btn btn-primary">Volver</button>
      </a>
    </div>

  </div>
</main>

<!-- CSS para estrellas -->
<style>
.rating {
  display: inline-block;
  direction: rtl;
}
.rating:not(:checked) > input {
  position: absolute;
  appearance: none;
}
.rating:not(:checked) > label {
  float: right;
  cursor: default;
  font-size: 28px;
  color: #ccc;
  padding: 0 3px;
}
.rating:not(:checked) > label:before {
  content: '★';
}
.rating > input:checked + label,
.rating > input:checked ~ label {
  color: #ffa723;
}
.info-item {
  margin-top: 8px;
}
</style>

<script src="js/main-perfil.js"></script>
  