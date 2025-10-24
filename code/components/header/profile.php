<?php
$es_proveedor = $es_proveedor ?? false;
$es_cliente   = $es_cliente ?? false;
?>

<div class="profile-menu-container">
  <button class="profile-btn" id="profileBtn">
    <img src="css/storage/userThumb.svg" alt="Perfil" class="usr-img">
  </button>
  
  <div class="dropdown-menu" id="dropdownMenu">

    <!-- Ver perfil -->
    <a class="value" href="index.php?controller=usuario&action=VerPerfil">
      <img src="css/storage/perfilsito.svg" alt="Profile Icon" class="icon-profile">
      Ver perfil
    </a>

    <!-- Mis reservas (solo para clientes) -->
    <?php if ($es_cliente): ?>
      <a class="value" href="index.php?controller=cliente&action=VerReservas">
        <img src="css/storage/reservas.svg" alt="Bookings Icon" class="icon-bookings">
        Mis reservas
      </a>
    <?php endif; ?>

    <!-- Notificaciones -->
    <a class="value" href="index.php?controller=usuario&action=Notificaciones">
      <img src="css/storage/campanita.svg" alt="Bell Icon" class="icon-bell">
      Notificaciones
    </a>

    <!-- Mis servicios (solo para proveedores) -->
    <?php if ($es_proveedor): ?>
      <a class="value" href="index.php?controller=proveedor&action=VerMisServicios">
        <img src="css/storage/reservas.svg" alt="Bookings Icon" class="icon-bookings">
        Mis servicios
      </a>
    <?php endif; ?>

    

    <!-- Cerrar sesión -->
    <a class="value" href="index.php?controller=login&action=logout">
      <img src="css/storage/logout.svg" alt="Logout Icon" class="icon-logout">
      Cerrar sesión
    </a>

  </div>
</div>
