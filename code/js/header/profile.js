// Función para mostrar el menú de perfil
function showProfileMenu() {
  const profileBtn = document.getElementById('profileBtn');
  const dropdownMenu = document.getElementById('dropdownMenu');

  if (!profileBtn || !dropdownMenu) return;

  // Alternar visibilidad al hacer clic en el botón
  profileBtn.addEventListener('click', (event) => {
    event.stopPropagation();
    dropdownMenu.classList.toggle('show');
  });

  // Cerrar el menú al hacer clic fuera
  window.addEventListener('click', (e) => {
    if (!profileBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
      dropdownMenu.classList.remove('show');
    }
  });
}

// Ejecutar la función cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', showProfileMenu);
