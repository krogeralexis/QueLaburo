<div id="authModal" class="auth-modal">
  <div class="auth-modal-content">
    <span class="auth-close">&times;</span>

    <!-- Login -->
    <div id="loginContainer">
      <div class="form-container">
        <p class="title">Bienvenido</p>

        <!-- Solo botones inicialmente -->
        <div class="buttons-container" id="loginButtons">
          <div class="form-btn" id="loginWithMailBtn">Ingresar con mail</div>
          <div class="apple-login-button">
            <img src="css/storage/facebook.svg" alt="Facebook Icon" class="apple-icon"/>
            <span>Iniciar con Facebook</span>
          </div>
          <div class="google-login-button">
            <img src="css/storage/google.svg" alt="Google Icon" class="google-icon"/>
            <span>Iniciar con Google</span>
          </div>
        </div>

        <!-- Formulario oculto -->
        <form class="form" id="loginForm" style="display:none;">
          <input type="email" class="input" placeholder="Email" required>
          <input type="password" class="input" placeholder="Contraseña" required>
          <p class="page-link"><span class="page-link-label">¿Olvidaste tu contraseña?</span></p>
          <button class="form-btn" type="submit">Iniciar Sesión</button>
        </form>

        <p class="sign-up-label">
          ¿No tenés una cuenta? <span class="sign-up-link" id="toRegister">Unirse</span>
        </p>
      </div>
    </div>

    <!-- Register -->
    <div id="registerContainer" style="display:none;">
      <div class="form-container">
        <p class="title">Registro</p>

        <!-- Solo botones inicialmente -->
        <div class="buttons-container" id="registerButtons">
          <div class="form-btn" id="registerWithMailBtn">Unirse con mail</div>
          <div class="apple-login-button">
            <img src="css/storage/facebook.svg" alt="Facebook Icon" class="apple-icon"/>
            <span>Unirse con Facebook</span>
          </div>
          <div class="google-login-button">
            <img src="css/storage/google.svg" alt="Google Icon" class="google-icon"/>
            <span>Unirse con Google</span>
          </div>
        </div>

        <!-- Formulario oculto -->
        <form class="form" id="registerForm" style="display:none;">
          <input type="text" class="input" placeholder="Nombre completo" required>
          <input type="email" class="input" placeholder="Correo electrónico" required>
          <input type="tel" class="input" placeholder="Teléfono" required pattern="[0-9]{8,15}" title="Solo números (8 a 15 dígitos)">
          <input type="password" class="input" placeholder="Contraseña" required minlength="6">
          <input type="password" class="input" placeholder="Confirmar contraseña" required minlength="6">
          <button class="form-btn" type="submit">Unirse</button>
        </form>

        <p class="sign-up-label">
          ¿Ya tienes una cuenta? <span class="sign-up-link" id="toLogin">Iniciar Sesión</span>
        </p>
      </div>
    </div>

  </div>
</div>
