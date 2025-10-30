<main>
<?php if (!empty($servicios)): ?>
  <?php foreach ($servicios as $servicio): ?>
    <?php
    // Datos del servicio
    $categoria    = htmlspecialchars($servicio['categoria'] ?? 'Sin Categoría');
    $titulo       = htmlspecialchars($servicio['titulo'] ?? 'Sin Título');
    $descripcion  = htmlspecialchars($servicio['descripcion'] ?? 'Descripción no disponible.');
    $imagen       = !empty($servicio['imagen']) 
        ? 'data:image/jpeg;base64,' . base64_encode($servicio['imagen'])
        : 'css/storage/card-image.svg';
    $nombre       = htmlspecialchars($servicio['proveedor_nombre'] ?? 'Proveedor Desconocido');
    $foto_url     = !empty($servicio['foto_perfil'])
        ? 'data:image/png;base64,' . base64_encode($servicio['foto_perfil'])
        : 'css/storage/userThumb.svg';
    $proveedor_id = (int)($servicio['proveedor_id'] ?? 0);
    $id_servicio  = (int)($servicio['id_servicio'] ?? 0);
    $rol          = htmlspecialchars($servicio['rol'] ?? 'Proveedor');

    // Reservas asociadas a este servicio
    $reservas = $servicio['reservas'] ?? [];
    ?>
    
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
            <?php if (!empty($foto_url)): ?>
              <img src="<?= $foto_url ?>" alt="Perfil de <?= $nombre ?>" class="usr-img">
            <?php else: ?>
              <div class="icon-jam-icons-outline-logos-user">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M12 2C13.0609 2 14.0783 2.42143 14.8284 3.17157C15.5786 3.92172 16 4.93913 16 6V8C16 9.06087 15.5786 10.0783 14.8284 10.8284C14.0783 11.5786 13.0609 12 12 12C10.9391 12 9.92172 11.5786 9.17157 10.8284C8.42143 10.0783 8 9.06087 8 8V6C8 4.93913 8.42143 3.92172 9.17157 3.17157C9.92172 2.42143 10.9391 2 12 2Z" fill="#C1C7CD"/>
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
        <button id="btnReservar" class="text-container" data-id-servicio="<?= $id_servicio ?>">Reservar</button>
      </div>

      <img class="placeholder-picture" src="<?= $imagen ?>" alt="Imagen del servicio"/>

      <!-- Contenedor de reservas -->
      <div class="reservas-container">
        <?php if (!empty($reservas)): ?>
          <?php foreach ($reservas as $reserva): ?>
            <div class="reserva-card">
              <div class="title-category">
                <div class="category"><span class="category_span"><?= htmlspecialchars($reserva['categoria'] ?? '') ?></span></div>
                <div class="title"><span class="title_span"><?= htmlspecialchars($reserva['titulo'] ?? '') ?></span></div>
              </div>

              <div class="paragraph">
                <span class="paragraph_span"><?= htmlspecialchars($reserva['descripcion'] ?? '') ?></span>
              </div>

              <div class="user-card">
                <div class="user-thumb">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M12 2C13.0609 2 14.0783 2.42143 14.8284 3.17157C15.5786 3.92172 16 4.93913 16 6V8C16 9.06087 15.5786 10.0783 14.8284 10.8284C14.0783 11.5786 13.0609 12 12 12C10.9391 12 9.92172 11.5786 9.17157 10.8284C8.42143 10.0783 8 9.06087 8 8V6C8 4.93913 8.42143 3.92172 9.17157 3.17157C9.92172 2.42143 10.9391 2 12 2Z" fill="#C1C7CD"/>
                  </svg>
                </div>
                <div class="details">
                  <div class="category_01"><span class="category_01_span"><?= htmlspecialchars($reserva['proveedor_nombre'] ?? 'Desconocido') ?></span></div>
                  <div class="category_02"><span class="category_02_span"><?= htmlspecialchars($reserva['proveedor_rol'] ?? 'Proveedor') ?></span></div>
                </div>
              </div>

              <div class="button-1">
                <a href="index.php?controller=cliente&action=cancelarReserva&id=<?= (int)($reserva['id'] ?? 0) ?>" class="btn-cancelar">Cancelar Reserva</a>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="no-reservas">No tienes reservas activas.</p>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <p>No hay servicios disponibles.</p>
<?php endif; ?>
</main>

<script>
// Click en foto o nombre de proveedor -> ir a perfil
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.user-card .details, .user-thumb img').forEach(el => {
    el.addEventListener('click', () => {
      const parentCard = el.closest('.mis-servicios');
      const userId = parentCard?.dataset.userId;
      if (userId && userId != 0) {
        window.location.href = `index.php?controller=usuario&action=verPerfil&id=${userId}`;
      }
    });
  });
});
</script>
