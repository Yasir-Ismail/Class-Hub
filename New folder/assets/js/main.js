// Main JS for ClassHub

document.addEventListener('DOMContentLoaded', () => {
    // Mobile Menu Toggle
    const menuToggle = document.getElementById('mobile-menu');
    const navList = document.getElementById('nav-list');

    if (menuToggle) {
        menuToggle.addEventListener('click', () => {
            navList.classList.toggle('active');
            menuToggle.querySelector('i').classList.toggle('fa-bars');
            menuToggle.querySelector('i').classList.toggle('fa-times');
        });
    }

    // Profile Dropdown Toggle
    const profileBtn = document.getElementById('profile-dropdown-btn');
    const profileMenu = document.getElementById('profile-dropdown-content');

    if (profileBtn && profileMenu) {
        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            profileMenu.classList.toggle('show');
        });

        document.addEventListener('click', (e) => {
            if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
                profileMenu.classList.remove('show');
            }
        });
    }

    // Add active class to current nav item
    const currentLocation = window.location.pathname.split('/').pop() || 'index.php';
    const navLinks = document.querySelectorAll('.nav-links a');

    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentLocation) {
            link.classList.add('active');
        }
    });

    // Simple scroll animation for glass cards
    const observerOptions = {
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.glass-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
        observer.observe(card);
    });

    // Admin Sidebar Toggle
    const adminSidebarToggle = document.getElementById('admin-sidebar-toggle');
    const adminSidebar = document.getElementById('admin-sidebar');
    const adminOverlay = document.getElementById('admin-sidebar-overlay');

    if (adminSidebarToggle && adminSidebar) {
        const toggleSidebar = () => {
            adminSidebar.classList.toggle('active');
            adminOverlay.classList.toggle('active');

            const icon = adminSidebarToggle.querySelector('i');
            if (adminSidebar.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        };

        adminSidebarToggle.addEventListener('click', toggleSidebar);
        if (adminOverlay) {
            adminOverlay.addEventListener('click', toggleSidebar);
        }

        // Close sidebar on link click (for mobile)
        const adminLinks = adminSidebar.querySelectorAll('.admin-nav-link');
        adminLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    adminSidebar.classList.remove('active');
                    adminOverlay.classList.remove('active');
                    adminSidebarToggle.querySelector('i').classList.replace('fa-times', 'fa-bars');
                }
            });
        });
    }
});
