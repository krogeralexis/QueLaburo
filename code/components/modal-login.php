<div id="authModal" class="auth-modal">
  <div class="auth-modal-content">
    <span class="auth-close">&times;</span>

    <!-- Login -->
    <div id="loginContainer">
      <div class="form-container">
        <p class="title">Bienvenido</p>
        <form class="form" id="loginForm" method="POST" action="index.php?controller=login&action=authenticate">
  <input type="email" name="correo" class="input" placeholder="Email" required>
  <input type="password" name="password" class="input" placeholder="Contraseña" required>
  <p class="page-link"><span class="page-link-label">¿Olvidaste tu contraseña?</span></p>
  <button class="form-btn" type="submit">Iniciar Sesión</button>

  <!-- Mensajes de error -->
  <?php if (!empty($error ?? '')): ?>
    <div class="form-error" style="color:red; margin-top:0.5em;">
      <?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>
</form>

        <p class="sign-up-label">
          ¿No tenés una cuenta? <span class="sign-up-link" id="toRegister">Unirse</span>
        </p>
        <div class="buttons-container">
          <div class="apple-login-button">
            <!-- Apple SVG -->
            <img src="css/storage/facebook.svg" alt="Facebook Icon" class="apple-icon"/>
            <span>Iniciar con Facebook</span>
          </div>
          <div class="google-login-button">
            <!-- Google SVG -->
            <img src="css/storage/google.svg" alt="Google Icon" class="google-icon"/>
            <span>Iniciar con Google</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Register -->
<div id="registerContainer" style="display:none;">
  <div class="form-container">
    <p class="title">Registro</p>
    <form class="form" id="registerForm" method="POST" action="index.php?controller=login&action=register">
  <input type="text" name="nombre" class="input" placeholder="Nombre completo" required>
  <input type="email" name="correo" class="input" placeholder="Correo electrónico" required>
  <input type="tel" name="telefono" class="input" placeholder="Teléfono" required pattern="[0-9]{8,15}" title="Solo números (8 a 15 dígitos)">
  <input type="password" name="password" class="input" placeholder="Contraseña" required minlength="6">
  <input type="password" name="confirm_password" class="input" placeholder="Confirmar contraseña" required minlength="6">

  <label style="font-size: 0.9em; margin-top: 0.5em; display:block;">
    <input type="checkbox" name="terms" required>
    Acepto los términos y condiciones
  </label>

  <button class="form-btn" type="submit">Unirse</button>

  <!-- Mensajes de error -->
  <?php if (!empty($errors ?? [])): ?>
    <div class="form-error" style="color:red; margin-top:0.5em;">
      <?php foreach($errors as $err): ?>
        <div><?= htmlspecialchars($err) ?></div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</form>


    <p class="sign-up-label">
      ¿Ya tienes una cuenta? <span class="sign-up-link" id="toLogin">Iniciar Sesión</span>
    </p>

    <div class="buttons-container">
      <div class="form-btn" id="registerWithMailBtn">
            <img src="css/storage/mailsito.svg" class="icon-left" alt="Mail Icon"/>
            Unirse con mail
        </div>
      <div class="apple-login-button">
        <img src="css/storage/facebook.svg" alt="Facebook Icon" class="apple-icon"/>
        <span>Unirse con Facebook</span>
      </div>
      <div class="google-login-button">
        <img src="css/storage/google.svg" alt="Google Icon" class="google-icon"/>
        <span>Unirse con Google</span>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', function(e) {
  const password = this.querySelector('input[placeholder="Contraseña"]').value;
  const confirm = this.querySelector('input[placeholder="Confirmar contraseña"]').value;

  if (password !== confirm) {
    e.preventDefault();
    alert('Las contraseñas no coinciden.');
  }
});
</script>

  </div>
</div>
