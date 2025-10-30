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

        <a class="sign-up-label">
          ¿No tenés una cuenta? <span class="sign-up-link" href="index.php?controller=login&action=register" >Unirse</span>
          </a>

        
        </div>
      </div>
    </div>
</div>
<style>
    /* Estilo básico para el modal de autenticación */

.auth-modal {
  display: none; /* Oculto por defecto, se activa con JavaScript */
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5); /* Fondo semi-transparente */
  z-index: 1000;
  display: flex;
  justify-content: center;
  align-items: center;
}

.auth-modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  width: 90%;
  max-width: 400px;
  position: relative;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.auth-close {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size: 24px;
  cursor: pointer;
  color: #333;
}

.auth-close:hover {
  color: #f00;
}

.form-container {
  text-align: center;
}

.title {
  font-size: 24px;
  margin-bottom: 20px;
  color: #333;
}

.form {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.input {
  width: 80%;
  padding: 10px;
  margin: 10px 0;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
}

.input:focus {
  outline: none;
  border-color: #007bff;
}

.form-btn {
  width: 80%;
  padding: 10px;
  margin: 10px 0;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  font-size: 16px;
  cursor: pointer;
}

.form-btn:hover {
  background-color: #0056b3;
}

.page-link, .sign-up-label {
  font-size: 14px;
  margin: 10px 0;
}

.page-link-label, .sign-up-link {
  color: #007bff;
  cursor: pointer;
  text-decoration: underline;
}

.page-link-label:hover, .sign-up-link:hover {
  color: #0056b3;
}

.form-error {
  font-size: 14px;
  text-align: center;
}

/* Para el registro: ocultar el formulario completo inicialmente */
#registerForm {
  display: none;
}

/* Responsive básico */
@media (max-width: 600px) {
  .auth-modal-content {
    width: 95%;
    padding: 15px;
  }
  
  .input, .form-btn {
    width: 90%;
  }
}

</style>

