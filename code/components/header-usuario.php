<header class="header">
  <!-- IZQUIERDA: Nav-Left -->
  <nav class="nav-left">
    <?php require_once 'header/navLeft.php'; ?>
  </nav>

  <!-- CENTRO: Logo -->
  <div class="logo">
    <?php require_once 'header/logo.php'; ?>
  </div>

  <!-- DERECHA: Nav-Right (Auth Actions + Profile) -->
  <div class="nav-right">
    <?php require_once 'header/authActions.php'; ?>
    <?php require_once 'header/profile.php'; ?>
  </div>
</header>
