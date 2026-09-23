document.addEventListener('DOMContentLoaded', function() {
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.parentElement;
            const menu = parent.querySelector('.admin-dropdown-menu');
            
            this.classList.toggle('open');
            if (menu) {
                menu.classList.toggle('show');
                // Remove inline display style if it was set
                if (menu.style.display === 'block') {
                    menu.style.display = '';
                }
            }
        });
    });

    // Modal Logic Generic
    const closeBtns = document.querySelectorAll('.modal-close, .modal-cancel');
    const modals = document.querySelectorAll('.modal-overlay');

    closeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const modal = this.closest('.modal-overlay');
            if(modal) modal.classList.remove('show');
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
