// ==========================================================
// BARANGAY SAN JOSE - UNIVERSAL ADMIN MOBILE SIDEBAR & UI JS
// ==========================================================

function initAdminMobileSidebar() {
    if (window.__adminMobileSidebarInitialized) return;
    window.__adminMobileSidebarInitialized = true;

    const sidebar = document.querySelector('.admin-sidebar');
    if (!sidebar) return;

    // Ensure mobile close button exists inside sidebar brand
    const brand = sidebar.querySelector('.sidebar-brand');
    if (brand && !brand.querySelector('.sidebar-mobile-close-btn')) {
        const closeBtn = document.createElement('button');
        closeBtn.type = 'button';
        closeBtn.className = 'sidebar-mobile-close-btn';
        closeBtn.title = 'Close Menu';
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

    // Ensure mobile toggle button exists in admin-header
    const headerLeft = document.querySelector('.admin-header .header-left');
    if (headerLeft && !document.getElementById('btn-admin-mobile-sidebar-toggle')) {
        const toggleBtn = document.createElement('button');
        toggleBtn.type = 'button';
        toggleBtn.id = 'btn-admin-mobile-sidebar-toggle';
        toggleBtn.className = 'btn-admin-mobile-sidebar-toggle';
        toggleBtn.setAttribute('aria-label', 'Toggle Navigation');
        toggleBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>';
        headerLeft.insertBefore(toggleBtn, headerLeft.firstChild);
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

    const toggleBtnEl = document.getElementById('btn-admin-mobile-sidebar-toggle');
    if (toggleBtnEl && !toggleBtnEl.dataset.boundSidebarToggle) {
        toggleBtnEl.dataset.boundSidebarToggle = 'true';
        toggleBtnEl.addEventListener('click', function(e) {
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

    window.addEventListener('resize', () => {
        if (window.innerWidth > 991) {
            closeDrawer();
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    initAdminMobileSidebar();
});

