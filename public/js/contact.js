document.addEventListener('DOMContentLoaded', () => {
    const contactForm = document.getElementById('contactForm');
    const formMessage = document.getElementById('formMessage');

    contactForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        const submitButton = e.target.querySelector('button[type="submit"]');
        
        // Submit button disable kar dete hain aur loading state show karte hain
        submitButton.disabled = true;
        submitButton.innerHTML = 'Sending...';
        
        try {
            // PHP backend use kar rahe hain, toh form normally submit karte hain
            // Yeh JavaScript sirf better UX ke liye hai, form bina bhi kaam karega
            const response = await fetch(window.location.href, {
                method: 'POST',
                body: formData
            });

            if (response.ok) {
                formMessage.classList.remove('hidden');
                formMessage.className = 'success-message';
                formMessage.textContent = 'Message sent successfully!';
                e.target.reset();
            } else {
                throw new Error('Failed to send message');
            }
        } catch (error) {
            // Agar koi problem hai toh normal form submission kar dete hain
            e.target.submit();
        } finally {
            // Submit button wapas enable kar dete hain
            submitButton.disabled = false;
            submitButton.innerHTML = 'Send Message';
        }
    });
});