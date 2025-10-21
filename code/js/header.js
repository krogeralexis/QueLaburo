// header.js
document.addEventListener('DOMContentLoaded', () => {
  const hamburgerBtn = document.getElementById('hamburgerBtn');
  const mobileNav = document.getElementById('mobileNav');

  if(hamburgerBtn && mobileNav){
    hamburgerBtn.addEventListener('click', () => {
      mobileNav.classList.toggle('show');
    });
  }
});
