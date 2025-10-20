<?php
// Ya que index.php llama a session_start(), $_SESSION está disponible aquí.

// 🟢 LÓGICA CORREGIDA DE SESIÓN Y ROL (usa booleanos de la sesión) 🟢
$usuario_esta_logeado = isset($_SESSION['usuario']['id']); 

$es_proveedor = false;
$es_cliente = false;

if ($usuario_esta_logeado) {
    // RECUPERAMOS LOS VALORES BOOLEANOS GUARDADOS EN EL CONTROLADOR.
    // Usamos '?? false' para asegurarnos de que siempre sea un booleano si la clave no existe.
    $es_proveedor = $_SESSION['usuario']['es_proveedor'] ?? false;
    $es_cliente = $_SESSION['usuario']['es_cliente'] ?? false;
}

// ----------------------------------------------------------------------
// Puedes COMENTAR el var_dump anterior si ya no lo necesitas, o dejarlo aquí.
/*
if ($usuario_esta_logeado) {
    echo '<pre style="background: #fdd; padding: 10px; border: 1px solid red;">';
    echo 'DEBUG DE SESIÓN (SOLO PARA LOGEADOS):<br>';
    var_dump($_SESSION['usuario']);
    echo 'Estado de Cliente ($es_cliente): ' . ($es_cliente ? 'TRUE' : 'FALSE') . '<br>';
    echo 'Estado de Proveedor ($es_proveedor): ' . ($es_proveedor ? 'TRUE' : 'FALSE') . '<br>';
    echo '</pre>';
}
*/
// ----------------------------------------------------------------------
?>
<header class="header">
  <nav class="nav-left">
    <?php require_once 'header/navLeft.php'; ?>
  </nav>

  <div class="logo">
    <?php require_once 'header/logo.php'; ?>
  </div>

  <div class="nav-right">
    <?php 
      
      if ($usuario_esta_logeado) {
          
          // 1. Botón "Publicar servicio" (si $es_proveedor es TRUE)
          if ($es_proveedor) {
              echo '<a href="index.php?controller=servicio&action=publicar" class="btn-primary">Publicar servicio</a>';
          }

          // 2. Menú de Perfil
          // profile.php usa $es_proveedor y $es_cliente para mostrar las opciones.
          require 'header/profile.php'; 
      } else {
          // 3. Acciones de Autenticación (si no está logeado)
          require 'header/authActions.php';
      }
    ?>
  </div>
</header>