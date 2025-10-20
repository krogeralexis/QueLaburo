document.addEventListener('DOMContentLoaded', () => {
    const wrapper = document.getElementById('carouselWrapper');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    // Si no encontramos los elementos necesarios, abortamos.
    if (!wrapper || !prevBtn || !nextBtn) return;

    // Solo contamos las tarjetas originales, no las copias para el loop.
    const realCards = wrapper.querySelectorAll('.card:not(.carousel-copy)');
    const totalRealCards = realCards.length;

    // Si hay 3 o menos servicios, deshabilitamos el carrusel cíclico.
    if (totalRealCards <= 3) {
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'none';
        wrapper.style.justifyContent = 'center'; // Centra las pocas tarjetas restantes
        return;
    }

    let currentIndex = 0; // Índice que apunta a la primera tarjeta REAL visible

    // Determina cuántas tarjetas se desplazan a la vez (1 en móvil, 3 en desktop)
    const getCardsToScroll = () => {
        return window.innerWidth <= 768 ? 1 : 3;
    };
    
    // Calcula el ancho de una tarjeta, incluyendo sus márgenes
    const getCardFullWidth = () => {
        if (realCards.length === 0) return 0;
        const card = realCards[0];
        const style = window.getComputedStyle(card);
        // Sumamos el ancho de la tarjeta y sus márgenes izquierdo/derecho
        const margin = parseFloat(style.marginLeft) + parseFloat(style.marginRight);
        return card.offsetWidth + margin;
    };

    // Función principal para desplazar el wrapper
    const scrollToCard = (index, smooth = true) => {
        const fullWidth = getCardFullWidth();
        wrapper.style.scrollBehavior = smooth ? 'smooth' : 'auto';
        
        // El scroll se basa en el índice x el ancho completo de la tarjeta
        wrapper.scrollLeft = index * fullWidth;
        currentIndex = index;
    };

    // Inicializar: Aseguramos que la primera tarjeta visible sea la 0
    scrollToCard(0, false); 


    // ----------------------------------------------------
    // Lógica de Desplazamiento Cíclico
    // ----------------------------------------------------

    const handleNext = () => {
        const cardsToScroll = getCardsToScroll();
        let newIndex = currentIndex + cardsToScroll;
        
        // Lógica Cíclica hacia adelante: si el nuevo índice llega a las tarjetas copiadas
        if (newIndex >= totalRealCards) {
            
            // 1. Mover animadamente a la tarjeta copiada
            scrollToCard(newIndex); 
            
            // 2. Después de la animación, saltar instantáneamente al índice 0
            setTimeout(() => {
                scrollToCard(0, false); 
            }, 300); 
            
            currentIndex = 0;
        } else {
            // Desplazamiento normal
            scrollToCard(newIndex);
        }
    };
    
    const handlePrev = () => {
        const cardsToScroll = getCardsToScroll();
        let newIndex = currentIndex - cardsToScroll;
        
        // Lógica Cíclica hacia atrás: si vamos antes del inicio (índice negativo)
        if (newIndex < 0) {
            // 1. Calcular el índice de la última tarjeta real visible
            const lastRealIndex = totalRealCards - cardsToScroll;
            
            // 2. Mover instantáneamente al elemento copiado que está antes del inicio
            // (Esto crea la ilusión de que el contenido proviene del final)
            const indexBeforeLoop = totalRealCards + cardsToScroll;
            scrollToCard(indexBeforeLoop, false); 

            // 3. Mover animadamente a la última tarjeta real visible
            setTimeout(() => {
                scrollToCard(lastRealIndex, true);
            }, 50); 
            
            currentIndex = lastRealIndex;
            
        } else {
            // Desplazamiento normal
            scrollToCard(newIndex);
        }
    };
    
    nextBtn.addEventListener('click', handleNext);
    prevBtn.addEventListener('click', handlePrev);
    
    // Manejar redimensionamiento de pantalla (para el responsive)
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            scrollToCard(currentIndex, false); // Re-calcula la posición y el ancho sin animación
        }, 100);
    });

});