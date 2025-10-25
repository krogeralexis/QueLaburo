<?php
// Recibe las variables desde header-usuario.php
// Si no existen, se definen por defecto
$usuario_esta_logeado = $usuario_esta_logeado ?? false;
$es_proveedor = $es_proveedor ?? false;
$es_cliente   = $es_cliente ?? false;
?>

<div class="nav-right">
  <?php if ($usuario_esta_logeado): ?>
    
    <!-- Botón Publicar solo para proveedores -->
    <?php if ($es_proveedor): ?>
      <a href="index.php?controller=servicio&action=publicar" class="btn-primary">Publicar</a>
    <?php endif; ?>

    <!-- Perfil -->
    <?php require __DIR__ . '/profile.php'; ?>

  <?php else: ?>
    <!-- Acciones de autenticación -->
    <?php require __DIR__ . '/authActions.php'; ?>
  <?php endif; ?>
    
</div>

