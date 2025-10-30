<?php
$es_proveedor = $es_proveedor ?? false;
$es_cliente   = $es_cliente ?? false;
$es_admin   = $es_admin ?? false;
?>

<div class="profile-menu-container">
  <button class="profile-btn" id="profileBtn">
    <img src="css/storage/userThumb.svg" alt="Perfil" class="usr-img">
  </button>
  
  <div class="dropdown-menu" id="dropdownMenu">

    <!-- Ver perfil -->
    <a id="perfilsito" class="value" href="index.php?controller=usuario&action=VerPerfil">
      <img src="css/storage/perfilsitoDia.svg" alt="Profile Icon" class="icon-profile">
      Ver perfil
    </a>

    <!-- Mis reservas (solo para clientes) -->
    <?php if ($es_cliente): ?>
      <a id="reservas" class="value" href="index.php?controller=cliente&action=verReservas">
        <img src="css/storage/reservasDia.svg" alt="Bookings Icon" class="icon-bookings">
        Mis reservas
      </a>
    <?php endif; ?>

    <!-- Notificaciones -->
    <a id="campanita" class="value" href="index.php?controller=mensaje&action=mensajeria">
      <img src="css/storage/campanitaDia.svg" alt="Bell Icon" class="icon-bell">
      Mensajes
    </a>

    <!-- Mis servicios (solo para proveedores) -->
    <?php if ($es_proveedor): ?>
      <a id="reservas" class="value" href="index.php?controller=proveedor&action=misServicios">
        <img src="css/storage/reservasDia.svg" alt="Bookings Icon" class="icon-bookings">
        Mis servicios
      </a>
    <?php endif; ?>

    <?php if ($es_admin): ?>
      <a id="reservas" class="value" href="index.php?controller=administrador&action=index">
        <img src="css/storage/reservasDia.svg" alt="Bookings Icon" class="icon-bookings">
        Admin Panel
      </a>
    <?php endif; ?>
    

    <!-- Cerrar sesión -->
    <a id="logout" class="value" href="index.php?controller=login&action=logout">
      <img src="css/storage/logoutDia.svg" alt="Logout Icon" class="icon-logout">
      Cerrar sesión
    </a>

  </div>
</div>
