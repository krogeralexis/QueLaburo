const toggleTheme = document.getElementById('toggleTheme');
const main = document.querySelector('main');

if (toggleTheme && main) {
  // Inicial: modo día
  document.body.classList.remove('dark-theme');
  toggleTheme.checked = false;
  main.style.backgroundImage = "url('storage/error_bg_alfaCod_v0.1.jpg')";

  // Escucha cambios del switch
  toggleTheme.addEventListener('change', () => {
    if (toggleTheme.checked) {
      // Modo noche
      document.body.classList.add('dark-theme');
      main.style.backgroundImage = "url('storage/Background_Alfacode_v0.2.jpg')";
    } else {
      // Modo día
      document.body.classList.remove('dark-theme');
      main.style.backgroundImage = "url('storage/error_bg_alfaCod_v0.1.jpg')";
    }
  });
}
