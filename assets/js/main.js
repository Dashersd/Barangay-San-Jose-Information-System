document.addEventListener('DOMContentLoaded', () => {


    // --- 2. Sticky Navbar ---
    const navbar = document.querySelector('.navbar');

    const handleScroll = () => {
        if (window.scrollY > 10) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    };

    window.addEventListener('scroll', handleScroll, { passive: true });
    // Trigger on load in case page is refreshed midway
    handleScroll();


    // --- 4. Active Link Highlighting (Optional JS fallback) ---
    const currentPath = window.location.pathname;
    const navItems = document.querySelectorAll('.navbar-links a');
    navItems.forEach(item => {
        const linkPath = item.getAttribute('href');
        // Simple match - if the href is in the current path (and not just base URL)
        if (linkPath && currentPath.includes(linkPath.replace('../', '').replace('./', ''))) {
            // Avoid matching 'index.html' on every page if it's the root
            if ((linkPath.includes('index.html') || linkPath.includes('index.php')) && currentPath.includes('pages/')) {
                return;
            }
            item.classList.add('active');
        }
    });
});
