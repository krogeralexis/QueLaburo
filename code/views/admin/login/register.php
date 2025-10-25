<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro</title>
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/form-register.css">
  <link rel="stylesheet" href="css/footer.css">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>

  <?php include 'components/header.php'; ?>

  <main class="register-container">
      <form class="register-form" method="POST" action="index.php?controller=login&action=register">
        <div class="form-group">
          <div class="field">
            <label for="first_name">Nombre</label>
            <input type="text" id="first_name" name="nombre" placeholder="Ingrese su nombre" required>
          </div>
          <div class="field">
            <label for="last_name">Apellido</label>
            <input type="text" id="last_name" name="apellido" placeholder="Ingrese su apellido" required>
          </div>
        </div>

        <div class="field">
          <label for="email">Correo electrónico</label>
          <input type="email" id="email" name="correo" placeholder="ejemplo@correo.com" required>
        </div>
        <div class="field">
          <label for="telefono">Teléfono</label>
          <input type="text" id="telefono" name="telefono" placeholder="Ingrese su teléfono" required>
        </div>

        <div class="field">
          <label for="password">Contraseña</label>
          <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required>
        </div>

        <div class="field">
          <label for="confirm_password">Confirmar contraseña</label>
          <input type="password" id="confirm_password" name="confirm_password" placeholder="Repita su contraseña" required>
        </div>

        <div class="form-check">
          <input type="checkbox" id="terms" name="terms" required>
          <label for="terms">Acepto los términos y condiciones</label>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn-primary btn-text">Registrarse</button>
        </div>

        <p class="login-link">
          ¿Ya tiene cuenta? <a href="index.php?controller=login&action=index">Ingrese aquí</a>
        </p>
      </form>
  </main>


  <?php include 'components/footer.php'; ?>

</body>
</html>