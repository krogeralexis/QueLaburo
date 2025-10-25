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

          <?php if (!empty($error ?? '')): ?>
            <div class="form-error" style="color:red; margin-top:0.5em;">
              <?= htmlspecialchars($error) ?>
            </div>
          <?php endif; ?>
        </form>

        <p class="sign-up-label">
          ¿No tenés una cuenta? <span class="sign-up-link" id="toRegister">Unirse</span>
        </p>

        
        </div>
      </div>
    </div>

    <!-- Register -->
    <div id="registerContainer" style="display:none;">
      <div class="form-container">
        <p class="title">Registro</p>

        <!-- Elección inicial -->
          <div style="width:80%; text-align:center; margin:0.5em 0; border-bottom:1px solid #ccc;"></div>

          <button class="form-btn" id="chooseEmailRegister" style="width:80%;">Registrarse con Email</button>

          <p class="sign-up-label" style="margin-top:0.5em;">
            ¿Ya tenés una cuenta? <span class="sign-up-link" id="toLogin">Ingresá aquí</span>
          </p>
        </div>

        <!-- Formulario completo -->
        <form class="form" id="registerForm" method="POST" action="index.php?controller=login&action=register" style="display:none;">
          <input type="text" name="nombre" class="input" placeholder="Nombre completo" required>
          <input type="email" name="correo" class="input" placeholder="Correo electrónico" required>
          <input type="tel" name="telefono" class="input" placeholder="Teléfono" required pattern="[0-9]{8,15}" title="Solo números (8 a 15 dígitos)">
          <input type="password" name="password" class="input" placeholder="Contraseña" required minlength="6">
          <input type="password" name="confirm_password" class="input" placeholder="Confirmar contraseña" required minlength="6">

          <label style="font-size: 0.9em; margin-top: 0.5em; display:block;">
            <input type="checkbox" name="terms" required>
            Acepto los términos y condiciones
          </label>

          <button class="form-btn" type="submit" style="margin-top:1em;">Registrarse</button>

          <p class="sign-up-label" style="margin-top:0.5em; text-align:center;">
            ¿Ya tenés una cuenta? <span class="sign-up-link" id="toLogin2">Ingresá aquí</span>
          </p>

          <!-- Mensajes de error -->
          <?php if (!empty($errors ?? [])): ?>
            <div class="form-error" style="color:red; margin-top:0.5em;">
              <?php foreach($errors as $err): ?>
                <div><?= htmlspecialchars($err) ?></div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </form>
      </div>
    </div>

    

  </div>
</div>


