// profile.js
const profileBtn = document.getElementById('profileBtn');
const dropdownMenu = document.getElementById('dropdownMenu');
const toggleTheme = document.getElementById('toggleTheme');

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

// Toggle día/noche
if (toggleTheme) {
  toggleTheme.addEventListener('change', () => {
    document.body.classList.toggle('dark-theme');
  });
}
