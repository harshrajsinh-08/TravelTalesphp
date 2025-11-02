// Mobile menu toggle functionality
document.addEventListener('DOMContentLoaded', () => {
    // Check authentication on page load
    const isLoggedIn = localStorage.getItem('isLoggedIn');
    const userEmail = localStorage.getItem('userEmail');
    
    if (!isLoggedIn) {
        window.location.href = 'login.html';
        return;
    }
    
    // Display user email in navbar
    if (userEmail) {
        const userEmailElement = document.getElementById('userEmail');
        if (userEmailElement) {
            userEmailElement.textContent = userEmail;
            userEmailElement.classList.remove('hidden');
        }
    }

    // Logout functionality
    function logout() {
        localStorage.removeItem('isLoggedIn');
        localStorage.removeItem('userEmail');
        window.location.href = 'login.html';
    }

    const logoutBtn = document.getElementById('logoutBtn');
    const mobileLogoutBtn = document.getElementById('mobileLogoutBtn');
    
    if (logoutBtn) {
        logoutBtn.addEventListener('click', logout);
    }
    if (mobileLogoutBtn) {
        mobileLogoutBtn.addEventListener('click', logout);
    }

    // Mobile menu functionality
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', () => {
            if (mobileMenu.classList.contains("hidden")) {
                // Show menu
                mobileMenu.classList.remove("hidden");
                setTimeout(() => {
                    mobileMenu.classList.remove("opacity-0", "-translate-y-5");
                    mobileMenu.classList.add("opacity-100", "translate-y-0");
                }, 10);
                mobileMenuToggle.setAttribute('aria-expanded', 'true');
            } else {
                // Hide menu
                mobileMenu.classList.remove("opacity-100", "translate-y-0");
                mobileMenu.classList.add("opacity-0", "-translate-y-5");
                setTimeout(() => {
                    mobileMenu.classList.add("hidden");
                }, 200);
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!mobileMenuToggle.contains(e.target) && !mobileMenu.contains(e.target)) {
                if (!mobileMenu.classList.contains("hidden")) {
                    mobileMenu.classList.remove("opacity-100", "translate-y-0");
                    mobileMenu.classList.add("opacity-0", "-translate-y-5");
                    setTimeout(() => {
                        mobileMenu.classList.add("hidden");
                    }, 200);
                    mobileMenuToggle.setAttribute('aria-expanded', 'false');
                }
            }
        });

        // Close mobile menu when clicking on a link
        const mobileMenuLinks = mobileMenu.querySelectorAll("a");
        mobileMenuLinks.forEach(link => {
            link.addEventListener("click", function() {
                mobileMenu.classList.remove("opacity-100", "translate-y-0");
                mobileMenu.classList.add("opacity-0", "-translate-y-5");
                setTimeout(() => {
                    mobileMenu.classList.add("hidden");
                }, 200);
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
            });
        });

        // Close mobile menu when window is resized to desktop view
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) { // md breakpoint
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
                if (!mobileMenu.classList.contains("hidden")) {
                    mobileMenu.classList.remove("opacity-100", "translate-y-0");
                    mobileMenu.classList.add("opacity-0", "-translate-y-5");
                    setTimeout(() => {
                        mobileMenu.classList.add("hidden");
                    }, 200);
                }
            }
        });
    }
}); 