<?php
// navLeft.php
$usuario_esta_logeado = isset($_SESSION['usuario']['id']); 
?>

<nav class="nav-left" id="mobileNav">
  <ul>
    <!-- Solo se ve en mobile -->
    <li class="mobile-only">
      <a class="hamburger" id="hamburgerBtn" aria-label="Abrir menú">
        <img src="css/storage/hamburguesita.svg" alt="..." class="ham-img" id="hamImg">
      </a>
    </li>

    <li><a href="index.php?controller=proveedor&action=index" class="nav-link">Conviertete en Proveedor</a></li>
    <li>
      <!-- <a href="#" class="nav-link">
        Explora
        <img src="css/storage/flechitaAbajo.svg" alt="Flecha abajo" class="nav-arrow" id="exploreArrow">
      </a> -->
    </li>
  </ul>
</nav>

<!-- JS -->
<script src="js/header.js"></script>
