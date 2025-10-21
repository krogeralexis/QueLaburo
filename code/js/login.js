const modal = document.getElementById("authModal");
const loginContainer = document.getElementById("loginContainer");
const registerContainer = document.getElementById("registerContainer");

// Abrir modal en login o registro
function openAuthModal(mode = 'login') {
    modal.style.display = 'flex';
    if (mode === 'login') {
        loginContainer.style.display = 'block';
        registerContainer.style.display = 'none';
    } else {
        loginContainer.style.display = 'none';
        registerContainer.style.display = 'block';
    }
}

// Cerrar modal
document.querySelector(".auth-close").onclick = () => modal.style.display = 'none';
window.onclick = e => { if(e.target == modal) modal.style.display = 'none'; }

// Switch dentro del modal
document.getElementById("toRegister").onclick = () => openAuthModal('register');
document.getElementById("toLogin").onclick = () => openAuthModal('login');

// Botones externos (ej: header)
document.addEventListener('DOMContentLoaded', () => {
    const btnLogin = document.getElementById("btnLogin");
    const btnRegister = document.getElementById("btnRegister");

    if (btnLogin) btnLogin.onclick = e => { e.preventDefault(); openAuthModal('login'); };
    if (btnRegister) btnRegister.onclick = e => { e.preventDefault(); openAuthModal('register'); };

    // Si querés abrir automáticamente al cargar la página
    // openAuthModal('login'); // Descomenta si lo necesitás
});
