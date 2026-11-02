document.addEventListener('DOMContentLoaded', () => {
    // --- 1. Initialize AOS Animation ---
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800, // Animation duration in ms
            easing: 'ease-in-out', // Easing function
            once: true, // Whether animation should happen only once - while scrolling down
            offset: 100 // Offset (in px) from the original trigger point
        });
    }

    // --- 2. Sticky Navbar ---
    const navbar = document.querySelector('.navbar');

    const handleScroll = () => {
        if (navbar) {
            if (window.scrollY > 10) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }
    };

    window.addEventListener('scroll', handleScroll, { passive: true });
    // Trigger on load in case page is refreshed midway
    handleScroll();

    // --- 3. Mobile Navigation Drawer Controller ---
    const toggleBtn = document.getElementById('btn-navbar-mobile-toggle');
    const closeBtn = document.getElementById('btn-mobile-nav-close');
    const drawer = document.getElementById('mobile-nav-drawer');
    const backdrop = document.getElementById('mobile-nav-backdrop');
    const aboutToggle = document.getElementById('btn-mobile-about-toggle');
    const aboutSubmenu = document.getElementById('mobile-about-submenu');

    function openMobileNav() {
        if (!drawer || !backdrop) return;
        drawer.classList.add('active');
        backdrop.classList.add('active');
        if (toggleBtn) {
            toggleBtn.classList.add('active');
            toggleBtn.setAttribute('aria-expanded', 'true');
        }
        drawer.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeMobileNav() {
        if (!drawer || !backdrop) return;
        drawer.classList.remove('active');
        backdrop.classList.remove('active');
        if (toggleBtn) {
            toggleBtn.classList.remove('active');
            toggleBtn.setAttribute('aria-expanded', 'false');
        }
        drawer.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            if (drawer && drawer.classList.contains('active')) {
                closeMobileNav();
            } else {
                openMobileNav();
            }
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', closeMobileNav);
    }

    if (backdrop) {
        backdrop.addEventListener('click', closeMobileNav);
    }

    if (aboutToggle && aboutSubmenu) {
        aboutToggle.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const isOpen = aboutSubmenu.classList.toggle('open');
            aboutToggle.classList.toggle('open', isOpen);
            aboutToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    }

    // Auto-close when clicking any mobile navigation link (except toggle button)
    const mobileLinks = document.querySelectorAll('.mobile-nav-link:not(.mobile-dropdown-toggle), .mobile-sublink, .btn-mobile-admin-login');
    mobileLinks.forEach(link => {
        link.addEventListener('click', () => {
            closeMobileNav();
        });
    });

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeMobileNav();
        }
    });

    // Auto-close if viewport resized to desktop width
    window.addEventListener('resize', () => {
        if (window.innerWidth > 991 && drawer && drawer.classList.contains('active')) {
            closeMobileNav();
        }
    });

});
