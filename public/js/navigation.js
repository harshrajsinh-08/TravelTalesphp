// Mobile menu toggle aur navigation functionality
document.addEventListener('DOMContentLoaded', () => {
    // Page load hone pe authentication check karte hain
    const isLoggedIn = localStorage.getItem('isLoggedIn');
    const userEmail = localStorage.getItem('userEmail');
    
    if (!isLoggedIn) {
        window.location.href = 'login.html';
        return;
    }
    
    // Navbar mein user email display karte hain
    if (userEmail) {
        const userEmailElement = document.getElementById('userEmail');
        if (userEmailElement) {
            userEmailElement.textContent = userEmail;
            userEmailElement.classList.remove('hidden');
        }
    }

    // Logout functionality - localStorage clear kar ke login page pe bhej dete hain
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

    // Mobile menu functionality - toggle karne ke liye
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', () => {
            if (mobileMenu.classList.contains("hidden")) {
                // Menu show karte hain smooth animation ke saath
                mobileMenu.classList.remove("hidden");
                setTimeout(() => {
                    mobileMenu.classList.remove("opacity-0", "-translate-y-5");
                    mobileMenu.classList.add("opacity-100", "translate-y-0");
                }, 10);
                mobileMenuToggle.setAttribute('aria-expanded', 'true');
            } else {
                // Menu hide karte hain
                mobileMenu.classList.remove("opacity-100", "translate-y-0");
                mobileMenu.classList.add("opacity-0", "-translate-y-5");
                setTimeout(() => {
                    mobileMenu.classList.add("hidden");
                }, 200);
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
            }
        });

        // Bahar click karne pe menu close kar dete hain
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

        // Menu link pe click karne pe menu close kar dete hain
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