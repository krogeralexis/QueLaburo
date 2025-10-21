const modal = document.getElementById("authModal");
const loginContainer = document.getElementById("loginContainer");
const registerContainer = document.getElementById("registerContainer");

const loginWithMailBtn = document.getElementById("loginWithMailBtn");
const registerWithMailBtn = document.getElementById("registerWithMailBtn");

const loginForm = document.getElementById("loginForm");
const registerForm = document.getElementById("registerForm");
const loginInitial = document.getElementById("loginInitial");
const registerInitial = document.getElementById("registerInitial");

// Abrir modal
function openAuthModal(mode = 'login') {
    modal.style.display = 'flex';
    if (mode === 'login') {
        loginContainer.style.display = 'block';
        registerContainer.style.display = 'none';
        loginForm.style.display = 'none';
        loginInitial.style.display = 'block';
    } else {
        loginContainer.style.display = 'none';
        registerContainer.style.display = 'block';
        registerForm.style.display = 'none';
        registerInitial.style.display = 'block';
    }
}

// Cerrar modal
document.querySelector(".auth-close").onclick = () => modal.style.display = 'none';
window.onclick = e => { if(e.target == modal) modal.style.display = 'none'; }

// Switch modal
document.getElementById("toRegister").onclick = () => openAuthModal('register');
document.getElementById("toLogin").onclick = () => openAuthModal('login');

// Botón "Ingresar con mail"
loginWithMailBtn.onclick = () => {
    loginInitial.style.display = 'none';
    loginForm.style.display = 'flex';
};

registerWithMailBtn.onclick = () => {
    registerInitial.style.display = 'none';
    registerForm.style.display = 'flex';
};

// Validación de contraseña en registro
registerForm.addEventListener('submit', function(e) {
    const password = this.querySelector('input[placeholder="Contraseña"]').value;
    const confirm = this.querySelector('input[placeholder="Confirmar contraseña"]').value;

    if (password !== confirm) {
        e.preventDefault();
        alert('Las contraseñas no coinciden.');
    }
});
