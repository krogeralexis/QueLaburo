const profileBtn = document.getElementById('profileBtn');
const dropdownMenu = document.getElementById('dropdownMenu');
const toggleTheme = document.getElementById('toggleTheme');

// --- Mostrar/ocultar menú de perfil ---
if (profileBtn && dropdownMenu) {
  profileBtn.addEventListener('click', (event) => {
    event.stopPropagation();
    dropdownMenu.classList.toggle('show');
  });

  window.addEventListener('click', (e) => {
    if (!profileBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
      dropdownMenu.classList.remove('show');
    }
  });
}

// --- Modo día/noche ---
if (toggleTheme) {
  // Asegura que empiece en modo día
  document.body.classList.remove('dark-theme'); // quita la clase de modo noche
  toggleTheme.checked = true;                  // checkbox sin marcar

  // Escucha el cambio del switch
  toggleTheme.addEventListener('change', () => {
    if (toggleTheme.checked) {
      document.body.classList.add('dark-theme');   // activa modo noche
    } else {
      document.body.classList.remove('dark-theme'); // vuelve a modo día
    }
  });
}
