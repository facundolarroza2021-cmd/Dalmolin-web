  // Toggle menú móvil con animación del ícono
  const navbarToggle = document.getElementById('navbarToggle');
  const navbarMobile = document.getElementById('navbarMobile');

  if (navbarToggle && navbarMobile) {
    navbarToggle.addEventListener('click', () => {
      navbarMobile.classList.toggle('active');
      navbarToggle.classList.toggle('active');
    });

    // Cerrar menú al hacer click en un enlace
    const mobileLinks = navbarMobile.querySelectorAll('a');
    mobileLinks.forEach(link => {
      link.addEventListener('click', () => {
        navbarMobile.classList.remove('active');
        navbarToggle.classList.remove('active');
      });
    });

    // Cerrar menú al hacer click fuera
    document.addEventListener('click', (e) => {
      if (!navbarToggle.contains(e.target) && !navbarMobile.contains(e.target)) {
        navbarMobile.classList.remove('active');
        navbarToggle.classList.remove('active');
      }
    });
  }

  // Navbar scroll effect (opcional)
  let lastScroll = 0;
  const navbar = document.querySelector('.navbar');
  
  window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;
    
    if (currentScroll > 50) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
    
    lastScroll = currentScroll;
  });

  