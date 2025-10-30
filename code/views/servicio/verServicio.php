<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QueLaburo</title>

  <!-- CSS -->
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/main-servicio.css">
  <link rel="stylesheet" href="css/footer.css">
  <link rel="stylesheet" href="css/login.css">
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
  
  <?php include 'components/header-usuario.php'; ?>
  <?php include 'components/main-servicio.php';?>
  <?php include 'components/footer.php'; ?>
  <?php include_once 'components/modal-login.php'; ?> 
  <!-- JS -->
  <script src="js/header/profile.js"></script>
  <script src="js/carrusel.js"></script>
  <script src="js/filtrito.js"></script>
  <script src="js/header/campanita.js"></script>
  <script src="js/login.js"></script>
  <script src="js/header.js"></script>
  <script src="js/dianoche.js"></script>

  <!-- Modal Reserva (simple) -->
  <div id="modalReserva" class="modal-reserva" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
    <div style="background:#fff; padding:20px; max-width:480px; width:90%; border-radius:8px;">
      <h3>Reservar servicio</h3>
      <form action="index.php?controller=reserva&action=store" method="POST">
        <input type="hidden" name="id_servicio" value="">
        
        <label>Fecha y hora de la reserva</label><br>
        <input type="datetime-local" name="fecha_reserva" required><br><br>

        <label>Notas (opcional, máximo 200 caracteres)</label><br>
        <input type="text" name="notas" maxlength="200" style="width:100%"><br><br>

        <div style="display:flex; gap:8px;">
          <button type="submit">Confirmar reserva</button>
          <button type="button" id="cancelReserva">Cancelar</button>
        </div>
      </form>
    </div>
  </div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('btnReservar');
  const modal = document.getElementById('modalReserva');

  console.log("DOM cargado. Buscando elementos...");
  console.log("btnReservar:", btn);
  console.log("modalReserva:", modal);

  if (!btn) {
    console.warn("❌ No se encontró el botón con id='btnReservar'. Revisa el include main-servicio.php");
    return;
  }

  btn.addEventListener('click', () => {
    console.log("✅ Click detectado en botón de reservar");
    modal.style.display = 'flex';
  });
});
</script>


</body>
</html>
