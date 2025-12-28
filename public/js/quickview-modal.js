// ============================================
// QUICKVIEW MODAL - JavaScript
// Archivo: public/js/quickview-modal.js
// ============================================

let quickviewSwiper = null;
let currentPropiedadId = null;

// Abrir modal de quickview
function openQuickView(propiedadId) {
    currentPropiedadId = propiedadId;
    
    // Hacer petición AJAX para obtener el contenido
    fetch(`/propiedad/${propiedadId}/quickview`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la petición');
            }
            return response.text();
        })
        .then(html => {
            // Insertar contenido en el modal
            const modalContent = document.getElementById('quickViewContent');
            if (modalContent) {
                modalContent.innerHTML = html;
            }
            
            // Mostrar el modal
            const modal = document.getElementById('quickViewModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('modal-open');
            }
            
            // Inicializar Swiper después de cargar el contenido
            setTimeout(() => {
                initQuickviewSwiper(propiedadId);
            }, 150);
        })
        .catch(error => {
            console.error('Error al cargar quickview:', error);
            alert('Error al cargar la información de la propiedad. Por favor, intenta de nuevo.');
        });
}

// Cerrar modal
function closeQuickView() {
    const modal = document.getElementById('quickViewModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('modal-open');
    }
    
    // Destruir Swiper
    if (quickviewSwiper) {
        quickviewSwiper.destroy(true, true);
        quickviewSwiper = null;
    }
    
    currentPropiedadId = null;
}

// Inicializar Swiper
function initQuickviewSwiper(propiedadId) {
    const swiperElement = document.querySelector(`.quickview-swiper-${propiedadId}`);
    
    if (!swiperElement) {
        console.error('Swiper element not found for property:', propiedadId);
        return;
    }
    
    // Verificar que Swiper esté disponible
    if (typeof Swiper === 'undefined') {
        console.error('Swiper library not loaded. Make sure to include Swiper CDN.');
        return;
    }
    
    // Destruir instancia previa si existe
    if (quickviewSwiper) {
        quickviewSwiper.destroy(true, true);
    }
    
    // Crear nueva instancia de Swiper
    try {
        quickviewSwiper = new Swiper(`.quickview-swiper-${propiedadId}`, {
            loop: false,
            speed: 400,
            spaceBetween: 0,
            slidesPerView: 1,
            
            // Navegación
            navigation: {
                nextEl: `.quickview-swiper-${propiedadId} .swiper-button-next`,
                prevEl: `.quickview-swiper-${propiedadId} .swiper-button-prev`,
            },
            
            // Paginación
            pagination: {
                el: `.quickview-swiper-${propiedadId} .swiper-pagination`,
                clickable: true,
                dynamicBullets: true,
                dynamicMainBullets: 3,
            },
            
            // Teclado
            keyboard: {
                enabled: true,
                onlyInViewport: true,
            },
            
            // Touch
            touchRatio: 1,
            touchAngle: 45,
            grabCursor: true,
            
            // Lazy loading
            lazy: {
                loadPrevNext: true,
                loadPrevNextAmount: 2,
            },
            
            // Efectos
            effect: 'slide',
            
            // Eventos
            on: {
                init: function() {
                    console.log('✅ Swiper initialized for property:', propiedadId);
                    updatePhotoCounter(this);
                },
                slideChange: function() {
                    updatePhotoCounter(this);
                }
            }
        });
    } catch (error) {
        console.error('Error initializing Swiper:', error);
    }
}

// Actualizar contador de fotos
function updatePhotoCounter(swiper) {
    if (!currentPropiedadId) return;
    
    const counter = document.querySelector(`.quickview-photo-counter-${currentPropiedadId}`);
    if (counter && swiper) {
        counter.textContent = swiper.activeIndex + 1;
    }
}

// Funciones auxiliares para navegación
function nextSlide() {
    if (quickviewSwiper) {
        quickviewSwiper.slideNext();
    }
}

function prevSlide() {
    if (quickviewSwiper) {
        quickviewSwiper.slidePrev();
    }
}

function goToSlide(index) {
    if (quickviewSwiper) {
        quickviewSwiper.slideTo(index);
    }
}

// ============================================
// EVENT LISTENERS
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 QuickView Modal initialized');
    
    // Cerrar modal al hacer click fuera
    const modal = document.getElementById('quickViewModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            // Solo cerrar si se hace click en el fondo oscuro (no en el contenido)
            if (e.target === modal) {
                closeQuickView();
            }
        });
    }
    
    // Cerrar con tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
            closeQuickView();
        }
    });
    
    // Prevenir propagación de clicks dentro del modal
    const modalContent = document.getElementById('quickViewContent');
    if (modalContent) {
        modalContent.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
    
    // Prevenir scroll en el fondo cuando el modal está abierto
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'class') {
                const modal = mutation.target;
                if (!modal.classList.contains('hidden')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            }
        });
    });
    
    if (modal) {
        observer.observe(modal, { attributes: true });
    }
});