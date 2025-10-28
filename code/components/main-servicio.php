<?php
// Evitar errores si $servicio no fue definido
$servicio = $servicio ?? [];

$categoria    = htmlspecialchars($servicio['categoria'] ?? 'Sin Categoría');
$titulo       = htmlspecialchars($servicio['titulo'] ?? 'Sin Título');
$descripcion  = htmlspecialchars($servicio['descripcion'] ?? 'Descripción no disponible.');
$imagen       = $servicio['imagen'] 
    ? 'data:image/jpeg;base64,' . base64_encode($servicio['imagen'])
    : 'css/storage/card-image.svg';
$nombre       = htmlspecialchars($servicio['proveedor_nombre'] ?? 'Proveedor Desconocido');
$foto_url     = !empty($servicio['foto_perfil'])
    ? 'data:image/png;base64,' . base64_encode($servicio['foto_perfil'])
    : 'css/storage/userThumb.svg';
$proveedor_id = $servicio['proveedor_id'] ?? 0;
$id_servicio  = $servicio['id_servicio'] ?? 0;
$rol          = $servicio['rol'] ?? 'Proveedor';
?>

<main>
  <div class="mis-servicios" data-user-id="<?= $proveedor_id ?>">
    <div class="content">
      <div class="title-category">
        <div class="category"><span class="category_span"><?= $categoria ?></span></div>
        <div class="title"><span class="title_span"><?= $titulo ?></span></div>
      </div>

      <div class="paragraph">
        <span class="paragraph_span"><?= $descripcion ?></span>
      </div>

      <div class="user-card">
        <div class="user-thumb">
          <?php if ($foto_url): ?>
            <img src="<?= $foto_url ?>" alt="Perfil de <?= $nombre ?>" class="usr-img">
          <?php else: ?>
            <div class="icon-jam-icons-outline-logos-user">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M8.534 12.07C8.65695 12.0175 ..." fill="#C1C7CD"/>
              </svg>
            </div>
          <?php endif; ?>
        </div>

        <div class="details">
          <div class="category_01"><span class="category_01_span"><?= $nombre ?></span></div>
          <div class="category_02"><span class="category_02_span"><?= $rol ?></span></div>
        </div>
      </div>
    </div>

    <div class="button-1">
      <a href="index.php?controller=servicio&action=reservar&id=<?= $id_servicio ?>" class="text-container">
        <span class="sdasd_span">Reservar</span>
      </a>
    </div>

    <img class="placeholder-picture" src="<?= $imagen ?>" alt="Imagen del servicio"/>
  </div>
</main>

<script>
// Click en foto o nombre de proveedor -> ir a perfil
document.addEventListener('DOMContentLoaded', () => {
  const profiles = document.querySelectorAll('.user-card .details, .user-thumb img');
  profiles.forEach(el => {
    el.addEventListener('click', () => {
      const parentCard = el.closest('.mis-servicios');
      const userId = parentCard.dataset.userId; // <-- ahora usamos data-user-id
      if (userId && userId != 0) {
        window.location.href = `index.php?controller=usuario&action=verPerfil&id=${userId}`;
      }
    });
  });
});
</script>
