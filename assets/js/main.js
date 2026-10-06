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
