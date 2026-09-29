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


});
