<main>
  <!-- Buscador -->
  <section class="search-bar">
  <label for="textito">
    <img src="css/storage/lupita.svg" alt="lupa" class="search-icon">
  </label>
  <input id="textito" type="text" placeholder="¿Qué servicio estás buscando hoy?">
  <img src="css/storage/filtrito.svg" alt="Filtro" class="filter-btn">
</section>

  <!-- Cards -->
  <section class="card-container">
  <img src="css/storage/flechitaIzq.svg" class="arrow left" alt="Izquierda">

    <?php for ($i = 0; $i < 3; $i++): ?>
    <div class="card">
      <img src="css/storage/card-image.svg" class="card-img" alt="Imagen del servicio">
      <div class="card-body">
        <p class="category">Categoría</p>
        <h3 class="title">Título</h3>
        <p class="description">Descripción breve...</p>
        <div class="profile">
          <div class="profile-icon">
            <img src="css/storage/userThumb.svg" alt="Perfil" class="usr-img">
          </div>
          <div>
            <p class="name">Jane Doe</p>
            <p class="role">Senior Designer</p>
          </div>
        </div>
        <div class="card-buttons">
          <button class="main-btn">Contratar</button>
          <button class="main-btn">Contactar</button>
        </div>
      </div>
    </div>
  <?php endfor; ?>

  <img src="css/storage/flechitaDer.svg" class="arrow right" alt="Derecha">
  </section>
</main>
