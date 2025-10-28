<?php
// Evitar errores si $servicios no fue definido
$servicios = $servicios ?? [];
?>
<main>
  <!-- Buscador -->
  <section class="search-bar">
    <label for="textito">
        <img src="css/storage/lupita.svg" alt="lupa" class="search-icon">
    </label>
    <input id="textito" type="text" placeholder="¿Qué servicio estás buscando hoy?">

    <div class="filter-wrapper">
        <button id="filterBtn" class="filter-btn">
            <img src="css/storage/filtrito.svg" alt="Filtro">
        </button>

        <!-- Menú desplegable de filtros -->
        <div id="filterMenu" class="filter-dropdown">
            <p class="filter-title">Filtrar por categoría</p>
            <ul>
                <li><input type="checkbox" value="Limpieza" class="filter-option"> Limpieza</li>
                <li><input type="checkbox" value="Reparación" class="filter-option"> Reparación</li>
                <li><input type="checkbox" value="Transporte" class="filter-option"> Transporte</li>
                <li><input type="checkbox" value="Educación" class="filter-option"> Educación</li>
            </ul>
        </div>
    </div>
  </section>
 
  <!-- CARRUSEL -->
  <section class="card-container">
    <button id="prevBtn" class="arrow left">
      <img src="css/storage/flechitaIzqDia.svg" alt="Izquierda">
    </button>

    <div id="carouselWrapper" class="carousel-wrapper">
      <?php 
      function renderServiceCard($servicio, $is_copy = false) {
          $copy_class = $is_copy ? ' carousel-copy' : '';
          $categoria = htmlspecialchars($servicio['categoria'] ?? 'Sin Categoría');
          $titulo = htmlspecialchars($servicio['titulo'] ?? 'Sin Título');
          $descripcion = htmlspecialchars($servicio['descripcion'] ?? 'Descripción no disponible.');
          $imagen = $servicio['imagen'] 
              ? 'data:image/jpeg;base64,' . base64_encode($servicio['imagen']) 
              : 'css/storage/card-image.svg';
          $nombre = htmlspecialchars($servicio['proveedor_nombre'] ?? 'Proveedor Desconocido');
          
          // Foto de perfil sacada del usuario (tabla Usuario -> foto_perfil)
          $foto_url = !empty($servicio['foto_perfil']) 
              ? 'data:image/png;base64,' . base64_encode($servicio['foto_perfil'])
              : 'css/storage/userThumb.svg';
          
          // ID del proveedor para enlazar al perfil
          $proveedor_id = $servicio['proveedor_id'] ?? 0;
          ?>
          <div class="card<?php echo $copy_class; ?>">
            <img src="<?php echo $imagen; ?>" class="card-img" alt="Imagen del servicio: <?php echo $titulo; ?>">
            <div class="card-body">
              <p class="category"><?php echo $categoria; ?></p>
              <h3 class="title"><?php echo $titulo; ?></h3>
              <p class="description"><?php echo $descripcion; ?></p>
              <div class="profile" data-user-id="<?php echo $proveedor_id; ?>">
                <div class="profile-icon clickable">
                  <img src="<?php echo $foto_url; ?>" alt="Perfil de <?php echo $nombre; ?>" class="usr-img">
                </div>
                <div class="clickable">
                  <p class="name"><?php echo $nombre; ?></p>
                </div>
              </div>
              <div class="card-buttons">
                <a href="index.php?controller=servicio&action=verServicio&id=<?= $servicio['id_servicio'] ?>" class="main-btn">Ver servicio</a>
              </div>
            </div>
          </div>
          <?php
      }

      // Renderizamos tarjetas originales
      foreach ($servicios as $servicio) {
          renderServiceCard($servicio);
      }

      // Renderizamos copias para efecto infinito si hay suficientes servicios
      $total_servicios = count($servicios);
      if ($total_servicios >= 3) {
          for ($i = 0; $i < 3; $i++) {
              renderServiceCard($servicios[$i], true);
          }
      }
      ?>
    </div>

    <button id="nextBtn" class="arrow right">
      <img src="css/storage/flechitaDerDia.svg" alt="Derecha">
    </button>
  </section>
</main>

<!-- Scripts -->
<script src="js/carrusel.js"></script>
<script src="js/filtrito.js"></script>

<script>
// Click en foto o nombre de proveedor -> ir a perfil
document.addEventListener('DOMContentLoaded', () => {
  const profiles = document.querySelectorAll('.profile .clickable, .profile-icon.clickable');
  profiles.forEach(el => {
    el.addEventListener('click', () => {
      const parentProfile = el.closest('.profile');
      const userId = parentProfile.dataset.userId;
      if (userId) {
        window.location.href = `index.php?controller=usuario&action=verPerfil&id=${userId}`;
      }
    });
  });
});
</script>
