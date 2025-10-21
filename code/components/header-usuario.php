<?php
$usuario_esta_logeado = isset($_SESSION['usuario']['id']); 
$es_proveedor = $usuario_esta_logeado ? ($_SESSION['usuario']['es_proveedor'] ?? false) : false;
$es_cliente = $usuario_esta_logeado ? ($_SESSION['usuario']['es_cliente'] ?? false) : false;
?>
<header class="header">
  <!-- NAV LEFT -->
  <nav class="nav-left">
    <ul>
      <li><a href="#" class="nav-link">Explora</a></li>
    </ul>
  </nav>

  <!-- LOGO -->
  <div class="logo">
    <a href="index.php" aria-label="Ir al inicio">
      <img src="css/storage/Rectangulito.svg" alt="QueLaburo logo" class="logo-image">
      <div class="logo-text">
        <h1>QueLaburo</h1>
        <span>by AlfaCod</span>
      </div>
    </a>
  </div>

  <!-- NAV RIGHT -->
  <div class="nav-right">
    <?php if ($usuario_esta_logeado): ?>
        <?php if ($es_proveedor): ?>
          <a href="index.php?controller=servicio&action=publicar" class="btn-primary">Publicar</a>
        <?php endif; ?>
        <div class="profile-menu-container">
          <button class="profile-btn" id="profileBtn">
            <img src="css/storage/userThumb.svg" alt="Perfil" class="usr-img"> 
          </button>
          <div class="dropdown-menu" id="dropdownMenu">
            <?php if ($es_proveedor): ?>
              <a href="index.php?controller=proveedor&action=misServicios">Mis servicios</a>
            <?php endif; ?>
            <?php if ($es_cliente): ?>
              <a href="index.php?controller=cliente&action=misReservas">Mis reservas</a>
            <?php endif; ?>
            <a href="index.php?controller=usuario&action=verPerfil">Ver perfil</a>
            <a href="index.php?controller=login&action=logout">Cerrar sesión</a>
          </div>
        </div>
    <?php else: ?>
        <div class="auth-actions">
          <a href="#" class="btn" id="btnLogin">Iniciar sesión</a>
          <a href="#" class="btn btn-primary" id="btnRegister">Únete</a>
        </div>
    <?php endif; ?>
  </div>
</header>
