document.addEventListener('DOMContentLoaded', () => {
    const contactForm = document.getElementById('contactForm');
    const formMessage = document.getElementById('formMessage');

    contactForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        const submitButton = e.target.querySelector('button[type="submit"]');
        
        // Disable submit button and show loading state
        submitButton.disabled = true;
        submitButton.innerHTML = 'Sending...';
        
        try {
            // Since we're using PHP backend, submit the form normally
            // This JavaScript is for enhanced UX but form will work without it
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
            // Fallback to normal form submission
            e.target.submit();
        } finally {
            // Re-enable submit button
            submitButton.disabled = false;
            submitButton.innerHTML = 'Send Message';
        }
    });
});