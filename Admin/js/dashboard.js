document.addEventListener('DOMContentLoaded', function() {
    // -------------------------------------------------------------
    // Sidebar Dropdown Navigation Logic
    // -------------------------------------------------------------
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const parentLi = this.closest('.admin-dropdown');
            if (!parentLi) return;
            
            const menu = parentLi.querySelector('.admin-dropdown-menu');
            const isCurrentlyOpen = parentLi.classList.contains('open') || 
                                    parentLi.classList.contains('active') ||
                                    this.classList.contains('open') ||
                                    this.classList.contains('active') ||
                                    (menu && (menu.classList.contains('show') || menu.style.display === 'block'));

            if (isCurrentlyOpen) {
                parentLi.classList.remove('open', 'active');
                this.classList.remove('open', 'active');
                if (menu) {
                    menu.classList.remove('show');
                    menu.style.display = 'none';
                }
            } else {
                parentLi.classList.add('open');
                this.classList.add('open');
                if (menu) {
                    menu.classList.add('show');
                    menu.style.display = 'block';
                }
            }
        });
    });

    // Auto-open dropdown if current page is inside it
    document.querySelectorAll('.admin-dropdown').forEach(dropdown => {
        const activeLink = dropdown.querySelector('.admin-dropdown-menu a.active');
        if (activeLink || dropdown.classList.contains('active') || dropdown.querySelector('.dropdown-toggle.open')) {
            dropdown.classList.add('open');
            const toggle = dropdown.querySelector('.dropdown-toggle');
            if (toggle) toggle.classList.add('open');
            const menu = dropdown.querySelector('.admin-dropdown-menu');
            if (menu) {
                menu.classList.add('show');
                menu.style.display = 'block';
            }
        }
    });

    // -------------------------------------------------------------
    // Generic Modal Logic
    // -------------------------------------------------------------
    const closeBtns = document.querySelectorAll('.modal-close, .modal-cancel');
    const modals = document.querySelectorAll('.modal-overlay');

    closeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const modal = this.closest('.modal-overlay');
            if (modal) modal.classList.remove('show');
        });
    });

    modals.forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('show');
            }
        });
    });

    // Service Modal
    const serviceModal = document.getElementById('serviceModal');
    const addServiceBtn = document.getElementById('addServiceBtn');
    if (serviceModal && addServiceBtn) {
        addServiceBtn.addEventListener('click', () => serviceModal.classList.add('show'));
    }

    // Announcement Modal
    const announcementModal = document.getElementById('announcementModal');
    const addAnnouncementBtn = document.getElementById('addAnnouncementBtn');
    if (announcementModal && addAnnouncementBtn) {
        addAnnouncementBtn.addEventListener('click', () => announcementModal.classList.add('show'));
    }

    // -------------------------------------------------------------
    // Universal Admin Mobile Navigation & Sidebar Drawer Controller
    // -------------------------------------------------------------
    window.initAdminMobileSidebar = function() {
        if (window.__adminMobileSidebarInitialized) return;
        window.__adminMobileSidebarInitialized = true;

        const sidebar = document.querySelector('.admin-sidebar');
        if (!sidebar) return;

        // Ensure close button exists inside sidebar brand
        const brand = sidebar.querySelector('.sidebar-brand');
        if (brand && !brand.querySelector('.sidebar-mobile-close-btn')) {
            const closeBtn = document.createElement('button');
            closeBtn.type = 'button';
            closeBtn.className = 'sidebar-mobile-close-btn';
            closeBtn.title = 'Close Navigation Menu';
            closeBtn.setAttribute('aria-label', 'Close Menu');
            closeBtn.innerHTML = '&times;';
            brand.appendChild(closeBtn);
        }

        // Ensure backdrop overlay exists
        let backdrop = document.getElementById('sidebar-overlay-backdrop');
        if (!backdrop) {
            backdrop = document.createElement('div');
            backdrop.id = 'sidebar-overlay-backdrop';
            backdrop.className = 'sidebar-overlay-backdrop';
            document.body.appendChild(backdrop);
        }

        // Ensure mobile toggle button exists in header
        let toggleBtn = document.getElementById('btn-admin-mobile-sidebar-toggle');
        if (!toggleBtn) {
            toggleBtn = document.createElement('button');
            toggleBtn.type = 'button';
            toggleBtn.id = 'btn-admin-mobile-sidebar-toggle';
            toggleBtn.className = 'btn-admin-mobile-sidebar-toggle';
            toggleBtn.setAttribute('aria-label', 'Toggle Navigation Menu');
            toggleBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>';

            const headerLeft = document.querySelector('.admin-header .header-left');
            if (headerLeft) {
                headerLeft.insertBefore(toggleBtn, headerLeft.firstChild);
            } else {
                const header = document.querySelector('.admin-header');
                if (header) {
                    header.insertBefore(toggleBtn, header.firstChild);
                }
            }
        }

        const openDrawer = () => {
            sidebar.classList.add('mobile-open');
            backdrop.classList.add('active');
            document.body.style.overflow = 'hidden';
        };

        const closeDrawer = () => {
            sidebar.classList.remove('mobile-open');
            backdrop.classList.remove('active');
            document.body.style.overflow = '';
        };

        if (toggleBtn && !toggleBtn.dataset.boundSidebarToggle) {
            toggleBtn.dataset.boundSidebarToggle = 'true';
            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if (sidebar.classList.contains('mobile-open')) {
                    closeDrawer();
                } else {
                    openDrawer();
                }
            });
        }

        const closeBtns = sidebar.querySelectorAll('.sidebar-mobile-close-btn');
        closeBtns.forEach(btn => {
            btn.addEventListener('click', closeDrawer);
        });

        backdrop.addEventListener('click', closeDrawer);

        // Auto-close on nav link click (except dropdown toggle)
        const navLinks = sidebar.querySelectorAll('.sidebar-nav a:not(.dropdown-toggle)');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 991) {
                    closeDrawer();
                }
            });
        });

        // Close on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && sidebar.classList.contains('mobile-open')) {
                closeDrawer();
            }
        });

        // Close on resize to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth > 991 && sidebar.classList.contains('mobile-open')) {
                closeDrawer();
            }
        });
    };

    // Auto-initialize mobile sidebar
    window.initAdminMobileSidebar();
});
