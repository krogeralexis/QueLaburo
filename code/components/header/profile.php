<?php
$es_proveedor = $es_proveedor ?? false;
$es_cliente   = $es_cliente ?? false;
?>

<div class="profile-menu-container">
  <button class="profile-btn" id="profileBtn">
    <img src="css/storage/userThumb.svg" alt="Perfil" class="usr-img">
  </button>

  <div class="dropdown-menu" id="dropdownMenu">
    
      <button class="value">
        <img src="css/storage/perfilsito.svg" alt="Profile Icon" class="icon-profile"
        href="index.php?controller=usuario&action=VerPerfil">
        Ver perfil
      </button>

    <?php if ($es_cliente): ?>
      <button class="value">
        <img src="css/storage/reservas.svg" alt="Bookings Icon" class="icon-bookings"
        href="index.php?controller=cliente&action=VerReservas">
        Mis reservas
      </button>
    <?php endif; ?>

    <button class="value">
      <img src="css/storage/campanita.svg" alt="Bell Icon" class="icon-bell"
      href="index.php?controller=usuario&action=Notificaciones">
      Notificaciones
    </button>

    <?php if ($es_proveedor): ?>
      <button class="value">
        <img src="css/storage/reservas.svg" alt="Bookings Icon" class="icon-bookings"
        href="index.php?controller=proveedor&action=VerMisServicios">
        Mis Servicios
      </button>
    <?php endif; ?>

    <!-- Botón de cambio de apariencia -->
    <div class="value">
      <span>Modo:</span>
      <label class="switch">
        <input type="checkbox" id="toggleTheme"/>
        <span class="slider"></span>
      </label>
    </div>

    <a href="index.php?controller=login&action=logout">Cerrar sesión</a>
  </div>
</div>
