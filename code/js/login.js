document.addEventListener('DOMContentLoaded', () => {

  const modal = document.getElementById("authModal");
  const loginContainer = document.getElementById("loginContainer");
  const registerContainer = document.getElementById("registerContainer");
  const registerForm = document.getElementById("registerForm");
  const registerChoice = document.getElementById("registerChoice");
  const chooseEmailRegister = document.getElementById("chooseEmailRegister");
  const googleLoginBtn = document.getElementById("googleLoginBtn");
  const googleRegisterBtn = document.getElementById("googleRegisterBtn");

  // Abrir modal en login o registro
  function openAuthModal(mode = 'login') {
      if (!modal) return;
      modal.style.display = 'flex';

      if (mode === 'login') {
          loginContainer && (loginContainer.style.display = 'block');
          registerContainer && (registerContainer.style.display = 'none');
      } else {
          loginContainer && (loginContainer.style.display = 'none');
          registerContainer && (registerContainer.style.display = 'block');
          // Ocultar formulario completo y mostrar elección
          registerForm && (registerForm.style.display = 'none');
          registerChoice && (registerChoice.style.display = 'flex');
      }
  }

  // Cerrar modal
  const authClose = document.querySelector(".auth-close");
  authClose && (authClose.onclick = () => modal.style.display = 'none');
  window.onclick = e => { if (e.target == modal) modal.style.display = 'none'; }

  // Switch dentro del modal
  const toRegister = document.getElementById("toRegister");
  const toLoginLinks = [document.getElementById("toLogin"), document.getElementById("toLogin2")];
  toRegister && (toRegister.onclick = () => openAuthModal('register'));
  toLoginLinks.forEach(link => {
      link && (link.onclick = e => {
          e.preventDefault();
          openAuthModal('login');
      });
  });

  // Botones externos (ej: header)
  const btnLogin = document.getElementById("btnLogin");
  const btnRegister = document.getElementById("btnRegister");
  if (btnLogin) btnLogin.onclick = e => { e.preventDefault(); openAuthModal('login'); };
  if (btnRegister) btnRegister.onclick = e => { e.preventDefault(); openAuthModal('register'); };

  // Mostrar formulario completo al elegir registrarse con Email
  chooseEmailRegister && (chooseEmailRegister.onclick = e => {
      e.preventDefault();
      registerChoice && (registerChoice.style.display = 'none');
      registerForm && (registerForm.style.display = 'block');
  });

  // Validación registro
  if (registerForm) {
    registerForm.addEventListener('submit', function(e) {
      const password = this.querySelector('input[placeholder="Contraseña"]')?.value;
      const confirm = this.querySelector('input[placeholder="Confirmar contraseña"]')?.value;

      if (password && confirm && password !== confirm) {
        e.preventDefault();
        alert('Las contraseñas no coinciden.');
      }
    });
  }

  // Función para login/register con Google
  async function handleGoogleAuth() {
    const provider = new firebase.auth.GoogleAuthProvider();
    try {
      const result = await firebase.auth().signInWithPopup(provider);
      const user = result.user;
      if (!user) throw new Error('No se obtuvo usuario');

      const formData = new FormData();
      formData.append("correo", user.email);
      formData.append("nombre", user.displayName);
      formData.append("google_uid", user.uid);

      const res = await fetch("index.php?controller=login&action=googleLogin", {
        method: "POST",
        body: formData
      });
      const data = await res.json();

      if (data.success) {
        window.location.href = "index.php?controller=usuario&action=index";
      } else {
        alert(data.message || "Error al iniciar sesión con Google.");
      }
    } catch (error) {
      console.error("Error Google login:", error);
      alert("Error al iniciar sesión con Google.");
    }
  }

  // Google login en login
  googleLoginBtn && googleLoginBtn.addEventListener("click", handleGoogleAuth);
  // Google register en registro
  googleRegisterBtn && googleRegisterBtn.addEventListener("click", handleGoogleAuth);

});
