// Form validation and submission handling
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('contactForm');
    if (!form) return;

    const formMessage = document.getElementById('formMessage');
    const spinner = form.querySelector('.loading-spinner');
    const submitText = form.querySelector('button[type="submit"] span');

    // Input validation functions
    const validators = {
        name: (value) => {
            if (value.length < 2) return 'Name must be at least 2 characters long';
            if (!/^[A-Za-z\s]+$/.test(value)) return 'Name can only contain letters and spaces';
            return '';
        },
        email: (value) => {
            if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)) return 'Please enter a valid email address';
            return '';
        },
        subject: (value) => {
            if (value.length < 3) return 'Subject must be at least 3 characters long';
            return '';
        },
        message: (value) => {
            if (value.length < 10) return 'Message must be at least 10 characters long';
            return '';
        }
    };

    // Real-time validation
    Object.keys(validators).forEach(field => {
        const input = document.getElementById(field);
        const errorDiv = document.getElementById(`${field}Error`);
        
        if (input && errorDiv) {
            input.addEventListener('input', () => {
                const error = validators[field](input.value);
                errorDiv.textContent = error;
                errorDiv.classList.toggle('hidden', !error);
                input.setAttribute('aria-invalid', error ? 'true' : 'false');
            });
        }
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Check all validations before submitting
        let hasErrors = false;
        Object.keys(validators).forEach(field => {
            const input = document.getElementById(field);
            if (input) {
                const error = validators[field](input.value);
                const errorDiv = document.getElementById(`${field}Error`);
                if (errorDiv) {
                    errorDiv.textContent = error;
                    errorDiv.classList.toggle('hidden', !error);
                }
                if (error) hasErrors = true;
            }
        });

        if (hasErrors) return;

        // Show loading state
        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        spinner.classList.remove('hidden');
        submitText.textContent = 'Sending...';

        // Add CSRF token
        const formData = new FormData(form);
        formData.append('_csrf', Math.random().toString(36).substring(2));

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            formMessage.classList.remove('hidden', 'error');
            formMessage.classList.add('success');
            formMessage.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>Thank you! Your message has been sent successfully.</span>
            `;
            form.reset();
            // Reset validation states
            Object.keys(validators).forEach(field => {
                const input = document.getElementById(field);
                if (input) {
                    input.setAttribute('aria-invalid', 'false');
                    const errorDiv = document.getElementById(`${field}Error`);
                    if (errorDiv) errorDiv.classList.add('hidden');
                }
            });
        })
        .catch(error => {
            formMessage.classList.remove('hidden', 'success');
            formMessage.classList.add('error');
            formMessage.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <span>Oops! There was a problem sending your message. Please try again.</span>
            `;
        })
        .finally(() => {
            submitButton.disabled = false;
            spinner.classList.add('hidden');
            submitText.textContent = 'Send Message';
            formMessage.classList.remove('hidden');
        });
    });
}); 