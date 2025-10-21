// header.js
document.addEventListener('DOMContentLoaded', () => {
  // ====== Selección de elementos ======
  const hamburgerBtn = document.getElementById('hamburgerBtn');
  const mobileNav = document.getElementById('mobileNav');
  const menuToggle = document.getElementById('menuToggle'); // Soporte alternativo (por si el botón usa otro id)

  // ====== Función para alternar visibilidad ======
  const toggleMenu = (e) => {
    if (e) e.preventDefault(); // Evita abrir la imagen del SVG
    if (mobileNav) {
      mobileNav.classList.toggle('show');
      mobileNav.classList.toggle('open');
    }
  };

  // ====== Eventos ======
  if (hamburgerBtn && mobileNav) {
    hamburgerBtn.addEventListener('click', toggleMenu);
  }

  if (menuToggle && mobileNav) {
    menuToggle.addEventListener('click', toggleMenu);
  }

  // ====== (Espacio reservado para otros comportamientos del header) ======
  // Podés agregar acá animaciones, despliegues de usuario, etc.
});
