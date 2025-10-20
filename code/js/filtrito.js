document.addEventListener('DOMContentLoaded', () => {
    const filterBtn = document.getElementById('filterBtn');
    const filterMenu = document.getElementById('filterMenu');

    // Toggle del dropdown al hacer click en el botón
    filterBtn.addEventListener('click', (e) => {
        e.stopPropagation(); // Evita que el click se propague al document
        filterMenu.classList.toggle('active');
    });

    // Cierra el dropdown si se hace click fuera
    document.addEventListener('click', (e) => {
        if (!filterMenu.contains(e.target) && !filterBtn.contains(e.target)) {
            filterMenu.classList.remove('active');
        }
    });
});
