const modal = document.getElementById("authModal");

// Contenedores
const loginContainer = document.getElementById("loginContainer");
const registerContainer = document.getElementById("registerContainer");

// Botones
const loginWithMailBtn = document.getElementById("loginWithMailBtn");
const registerWithMailBtn = document.getElementById("registerWithMailBtn");

// Formularios
const loginForm = document.getElementById("loginForm");
const registerForm = document.getElementById("registerForm");

// Botones principales
const loginButtons = document.getElementById("loginButtons");
const registerButtons = document.getElementById("registerButtons");

// ABRIR MODAL
function openAuthModal(mode = 'login') {
    modal.style.display = 'flex';
    if (mode === 'login') {
        loginContainer.style.display = 'block';
        registerContainer.style.display = 'none';
        loginButtons.style.display = 'flex';
        loginForm.style.display = 'none';
    } else {
        loginContainer.style.display = 'none';
        registerContainer.style.display = 'block';
        registerButtons.style.display = 'flex';
        registerForm.style.display = 'none';
    }
}

// CERRAR MODAL
document.querySelector(".auth-close").onclick = () => modal.style.display = 'none';
window.onclick = e => { if(e.target == modal) modal.style.display = 'none'; }

// SWITCH LOGIN <-> REGISTER
document.getElementById("toRegister").onclick = () => openAuthModal('register');
document.getElementById("toLogin").onclick = () => openAuthModal('login');

// MOSTRAR FORMULARIO MAIL
loginWithMailBtn.onclick = () => {
    loginButtons.style.display = 'none';
    loginForm.style.display = 'flex';
};

registerWithMailBtn.onclick = () => {
    registerButtons.style.display = 'none';
    registerForm.style.display = 'flex';
};

// VALIDACIÓN DE CONTRASEÑAS
registerForm.addEventListener('submit', function(e) {
    const password = this.querySelector('input[placeholder="Contraseña"]').value;
    const confirm = this.querySelector('input[placeholder="Confirmar contraseña"]').value;
    if (password !== confirm) {
        e.preventDefault();
        alert('Las contraseñas no coinciden.');
    }
});
