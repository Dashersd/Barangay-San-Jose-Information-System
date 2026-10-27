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
});
