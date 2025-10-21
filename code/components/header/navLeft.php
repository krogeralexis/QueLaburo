<?php
// navLeft.php
$usuario_esta_logeado = isset($_SESSION['usuario']['id']); 
?>

<nav class="nav-left" id="mobileNav">
  <ul>
    <!-- Solo se ve en mobile -->
    <li class="mobile-only">
      <a href="css/storage/hamburgesita.svg" class="hamburger" aria-label="Abrir menú" id="menuToggle">
        <img src="css/storage/hamburgesita.svg" alt="Menú" style="height: 6vh; width: 6vh;">
      </a>
    </li>

    <li><a href="index.php?controller=proveedor&action=index" class="nav-link">Panel de Administrador</a></li>
    <li>
      <a href="#" class="nav-link">
        Explora
        <img src="css/storage/flechitaAbajo.svg" alt="Flecha abajo" class="nav-arrow">
      </a>
    </li>
  </ul>
</nav>

<!-- JS -->
<script src="js/header.js"></script>
