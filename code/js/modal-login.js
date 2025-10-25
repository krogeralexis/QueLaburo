// Modal
const modal = document.getElementById("authModal");
const openBtn = document.getElementById("openModalBtn");
const closeBtn = document.querySelector(".close");

openBtn.onclick = () => modal.style.display = "block";
closeBtn.onclick = () => modal.style.display = "none";
window.onclick = (e) => { if(e.target == modal) modal.style.display = "none"; };

// Forms toggle
const loginForm = document.getElementById("loginForm");
const registerForm = document.getElementById("registerForm");
const switchToRegister = document.getElementById("switchToRegister");
const switchToLogin = document.getElementById("switchToLogin");
const modalTitle = document.getElementById("modalTitle");

switchToRegister.onclick = () => {
  loginForm.style.display = "none";
  registerForm.style.display = "block";
  modalTitle.textContent = "Crea tu cuenta";
};

switchToLogin.onclick = () => {
  registerForm.style.display = "none";
  loginForm.style.display = "block";
  modalTitle.textContent = "Bienvenido";
};
