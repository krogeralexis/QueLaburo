document.addEventListener('DOMContentLoaded', () => {
  const editablePerfil = document.getElementById('editablePerfil');
  if (!editablePerfil) return;

  // Al hacer click sobre la imagen
  editablePerfil.addEventListener('click', () => {
    const usuarioId = editablePerfil.dataset.usuarioId;
    window.location.href = `index.php?controller=usuario&action=edit&id=${usuarioId}`;
  });

  // Hover: se maneja con CSS, el overlay ya está en la vista
});
