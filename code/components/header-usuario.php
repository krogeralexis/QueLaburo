<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Variables de usuario
$usuario_esta_logeado = isset($_SESSION['usuario']['id']);
$es_proveedor = $usuario_esta_logeado ? ($_SESSION['usuario']['es_proveedor'] ?? false) : false;
$es_cliente   = $usuario_esta_logeado ? ($_SESSION['usuario']['es_cliente'] ?? false) : false;
?>

<header class="header">
  <!-- NAV LEFT -->
  <?php require_once __DIR__ . '/header/navLeft.php'; ?>

  <!-- LOGO -->
  <div class="logo">
    <?php require_once __DIR__ . '/header/logo.php'; ?>
  </div>

  <!-- NAV RIGHT -->
  <div class="nav-right">
    <?php if ($usuario_esta_logeado): ?>
      <?php if ($es_proveedor): ?>
        <a href="index.php?controller=servicio&action=publicar" class="btn-primary">Publicar</a>
      <?php endif; ?>

      <?php require __DIR__ . '/header/profile.php'; ?>

    <?php else: ?>
      <?php require __DIR__ . '/header/authActions.php'; ?>
    <?php endif; ?>
  </div> 
  <!-- Botón de cambio de apariencia -->
    <div class="value">
      <label class="switch">
        <input type="checkbox" id="toggleTheme" />
        <span class="slider"></span>
      </label>
    </div>
</header>


<!-- Scripts -->
<script src="js/header.js"></script>
<script src="js/header/profile.js"></script>
