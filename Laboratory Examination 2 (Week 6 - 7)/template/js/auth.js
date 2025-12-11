// Validation Helper Functions
const validators = {
    email: (value) => {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(value);
    },
    
    password: (value) => {
        return value.length >= 6;
    },
    
    phone: (value) => {
        // Accepts various phone formats including +63, 09, etc.
        const phoneRegex = /^[\+]?[(]?[0-9]{1,4}[)]?[-\s\.]?[(]?[0-9]{1,4}[)]?[-\s\.]?[0-9]{1,9}$/;
        return phoneRegex.test(value) && value.length >= 10;
    },
    
    name: (value) => {
        return value.trim().length >= 2;
    },
    
    address: (value) => {
        return value.trim().length >= 5;
    }
};

// Show error message for a field
function showError(fieldId, message) {
    const errorElement = document.getElementById(fieldId + 'Error');
    const inputElement = document.getElementById(fieldId);
    
    if (errorElement) {
        errorElement.textContent = message;
    }
    
    if (inputElement) {
        inputElement.classList.add('invalid');
        inputElement.classList.remove('valid');
    }
}

// Clear error message for a field
function clearError(fieldId) {
    const errorElement = document.getElementById(fieldId + 'Error');
    const inputElement = document.getElementById(fieldId);
    
    if (errorElement) {
        errorElement.textContent = '';
    }
    
    if (inputElement) {
        inputElement.classList.remove('invalid');
        inputElement.classList.add('valid');
    }
}

// Validate individual field
function validateField(fieldId, validator, errorMessage) {
    const inputElement = document.getElementById(fieldId);
    if (!inputElement) return true;
    
    const value = inputElement.value.trim();
    
    if (value === '') {
        showError(fieldId, 'This field is required');
        return false;
    }
    
    if (!validator(value)) {
        showError(fieldId, errorMessage);
        return false;
    }
    
    clearError(fieldId);
    return true;
}

// Login Form Validation
function validateLoginForm() {
    let isValid = true;
    
    // Validate email
    if (!validateField('email', validators.email, 'Please enter a valid email address')) {
        isValid = false;
    }
    
    // Validate password
    if (!validateField('password', validators.password, 'Password must be at least 6 characters')) {
        isValid = false;
    }
    
    return isValid;
}

// Registration Form Validation
function validateRegisterForm() {
    let isValid = true;
    
    // Validate first name
    if (!validateField('firstName', validators.name, 'First name must be at least 2 characters')) {
        isValid = false;
    }
    
    // Validate last name
    if (!validateField('lastName', validators.name, 'Last name must be at least 2 characters')) {
        isValid = false;
    }
    
    // Validate email
    if (!validateField('email', validators.email, 'Please enter a valid email address')) {
        isValid = false;
    }
    
    // Validate password
    if (!validateField('password', validators.password, 'Password must be at least 6 characters')) {
        isValid = false;
    }
    
    return isValid;
}

// Toggle Password Visibility
function setupPasswordToggle() {
    const toggleButtons = document.querySelectorAll('.toggle-password');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const passwordInput = this.previousElementSibling;
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.innerHTML = `
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                    </svg>
                `;
            } else {
                passwordInput.type = 'password';
                this.innerHTML = `
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                `;
            }
        });
    });
}

// Real-time validation on input
function setupRealtimeValidation() {
    const inputs = document.querySelectorAll('input[required]');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            const fieldId = this.id;
            const value = this.value.trim();
            
            if (value === '') {
                showError(fieldId, 'This field is required');
                return;
            }
            
            // Field-specific validation
            switch(fieldId) {
                case 'email':
                    validateField(fieldId, validators.email, 'Please enter a valid email address');
                    break;
                case 'password':
                    validateField(fieldId, validators.password, 'Password must be at least 6 characters');
                    break;
                case 'firstName':
                case 'lastName':
                    validateField(fieldId, validators.name, 'Must be at least 2 characters');
                    break;
            }
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('invalid')) {
                clearError(this.id);
            }
        });
    });
}

// Auto-hide messages after 5 seconds
function setupAutoHideMessages() {
    const messages = document.querySelectorAll('.error-message, .success-message');
    
    messages.forEach(message => {
        setTimeout(() => {
            message.style.transition = 'opacity 0.3s ease';
            message.style.opacity = '0';
            setTimeout(() => {
                message.style.display = 'none';
            }, 300);
        }, 5000);
    });
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Setup password toggle
    setupPasswordToggle();
    
    // Setup real-time validation
    setupRealtimeValidation();
    
    // Auto-hide messages
    setupAutoHideMessages();
    
    // Login form submission
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (validateLoginForm()) {
                // Add loading state
                const submitButton = this.querySelector('.btn-submit');
                submitButton.classList.add('loading');
                submitButton.disabled = true;
                
                // Submit form
                this.submit();
            }
        });
    }
    
    // Register form submission
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (validateRegisterForm()) {
                // Add loading state
                const submitButton = this.querySelector('.btn-submit');
                submitButton.classList.add('loading');
                submitButton.disabled = true;
                
                // Submit form
                this.submit();
            }
        });
    }
});
