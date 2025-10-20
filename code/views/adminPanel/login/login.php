<!-- Enlace al CSS del header -->
<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="css/login.css">
<link rel="stylesheet" href="css/footer.css">
<link rel="stylesheet" href="css/form-login.css">
<link rel="stylesheet" href="css/styles.css">

<?php include 'components/header.php'; ?>

<main class="login-container">
  <form class="login-form" action="index.php?controller=login&action=authenticate" method="post" autocomplete="off">
    <label for="email">Email</label>
    <input type="email" id="email" name="correo" placeholder="Email" required>

    <label for="password">Contraseña</label>
    <input type="password" id="password" name="password" placeholder="Contraseña" required>

    <div class="form-options">
      <label><input type="checkbox" name="remember"> Recordarme</label>
      <a href="#">¿Olvidaste la contraseña?</a>
    </div>

    <button type="submit" class="btn">Log In</button>

    <p class="signup-text">
      ¿No tiene cuenta? <a href="index.php?controller=login&action=registerview">Cree una aquí</a>
      </p>

  </form>
</main>

<?php include 'components/footer.php'; ?>
