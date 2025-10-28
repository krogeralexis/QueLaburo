document.addEventListener('DOMContentLoaded', () => {
  const toggleTheme = document.getElementById('toggleTheme');

  const getIcons = () => ({
    hamImg: document.getElementById('hamImg'),
    exploreArrow: document.getElementById('exploreArrow'),
    prevBtn: document.querySelector('#prevBtn img'),
    nextBtn: document.querySelector('#nextBtn img'),
    perfilsito: document.querySelector('#perfilsito img'),
    reservas: document.querySelector('#reservas img'),
    campanita: document.querySelector('#campanita img'),
    logout: document.querySelector('#logout img'),
    correo: document.getElementById('correo'),
    telefono: document.getElementById('telefono'),
    fecha: document.getElementById('fecha')
  });

  const applyTheme = (isDay) => {
    const { hamImg, exploreArrow, prevBtn, nextBtn, perfilsito, reservas, campanita, logout, correo, telefono, fecha } = getIcons();

    if (isDay) {
      document.body.classList.remove('dark-mode');
      if (hamImg) hamImg.src = 'css/storage/hamburguesitaDia.svg';
      if (exploreArrow) exploreArrow.src = 'css/storage/flechitaAbajoDia.svg';
      if (prevBtn) prevBtn.src = 'css/storage/flechitaIzqDia.svg';
      if (nextBtn) nextBtn.src = 'css/storage/flechitaDerDia.svg';
      if (perfilsito) perfilsito.src = 'css/storage/perfilsitoDia.svg';
      if (reservas) reservas.src = 'css/storage/reservasDia.svg';
      if (campanita) campanita.src = 'css/storage/campanitaDia.svg';
      if (logout) logout.src = 'css/storage/logoutDia.svg';
      if (correo) correo.src = 'css/storage/correoDia.svg';
      if (telefono) telefono.src = 'css/storage/telefonitoDia.svg';
      if (fecha) fecha.src = 'css/storage/calendarioDia.svg';
    } else {
      document.body.classList.add('dark-mode');
      if (hamImg) hamImg.src = 'css/storage/hamburguesitaNoche.svg';
      if (exploreArrow) exploreArrow.src = 'css/storage/flechitaAbajoNoche.svg';
      if (prevBtn) prevBtn.src = 'css/storage/flechitaIzqNoche.svg';
      if (nextBtn) nextBtn.src = 'css/storage/flechitaDerNoche.svg';
      if (perfilsito) perfilsito.src = 'css/storage/perfilsitoNoche.svg';
      if (reservas) reservas.src = 'css/storage/reservasNoche.svg';
      if (campanita) campanita.src = 'css/storage/campanitaNoche.svg';
      if (logout) logout.src = 'css/storage/logoutNoche.svg';
      if (correo) correo.src = 'css/storage/correoNoche.svg';
      if (telefono) telefono.src = 'css/storage/telefonitoNoche.svg';
      if (fecha) fecha.src = 'css/storage/calendarioNoche.svg';
    }
  };

  // Revisar si hay preferencia guardada
  const savedTheme = localStorage.getItem('theme');
  if (savedTheme === 'night') {
    toggleTheme.checked = false;
    applyTheme(false);
  } else {
    toggleTheme.checked = true;
    applyTheme(true);
  }

  // Cambiar tema al hacer toggle
  toggleTheme.addEventListener('change', () => {
    if (toggleTheme.checked) {
      localStorage.setItem('theme', 'day');
      applyTheme(true);
    } else {
      localStorage.setItem('theme', 'night');
      applyTheme(false);
    }
  });
});
