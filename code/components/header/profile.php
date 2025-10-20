<div class="profile-menu-container">
  <button class="profile-btn" id="profileBtn">
    <img src="css/storage/userThumb.svg" alt="Perfil" class="usr-img"> 
  </button>

  <div class="dropdown-menu" id="dropdownMenu">
    
    <?php 
      // Opción: Mis servicios (Si es proveedor)
      if (isset($es_proveedor) && $es_proveedor): 
    ?>
        <a href="index.php?controller=proveedor&action=misServicios">Mis servicios</a>
    <?php endif; ?>
    
    <?php 
      // Opción: Mis reservas (Si es cliente)
      if (isset($es_cliente) && $es_cliente): 
    ?>
        <a href="index.php?controller=cliente&action=misReservas">Mis reservas</a>
    <?php endif; ?>
    
    <a href="index.php?controller=usuario&action=verPerfil">Ver perfil</a>
    <a href="index.php?controller=login&action=logout">Cerrar sesión</a>
  </div>
</div>