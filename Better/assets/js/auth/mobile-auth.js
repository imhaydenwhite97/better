document.addEventListener('DOMContentLoaded', () => {
    const loginButton = document.querySelector('.login-button');
    const authOverlay = document.querySelector('.mobile-auth-overlay');
    const closeAuth = document.querySelector('.close-auth');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    loginButton.addEventListener('click', () => {
        authOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    });

    closeAuth.addEventListener('click', () => {
        authOverlay.classList.remove('active');
        document.body.style.overflow = '';
    });

    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(loginForm);
            formData.append('action', 'mobile_auth_login');
            formData.append('security', mobileAuth.nonce);
            
            submitAuthForm(formData, 'login');
        });
    }

    if (registerForm) {
        registerForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(registerForm);
            formData.append('action', 'mobile_auth_register');
            formData.append('security', mobileAuth.nonce);
            
            submitAuthForm(formData, 'register');
        });
    }

    function submitAuthForm(formData, type) {
        const form = type === 'login' ? loginForm : registerForm;
        const button = form.querySelector('button[type="submit"]');
        const originalText = button.textContent;
        
        button.disabled = true;
        button.textContent = 'Loading...';

        fetch(mobileAuth.ajaxurl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                showError(form, data.message || 'An error occurred');
                button.textContent = originalText;
                button.disabled = false;
            }
        })
        .catch(error => {
            showError(form, 'Connection error');
            button.textContent = originalText;
            button.disabled = false;
        });
    }

    function showError(form, message) {
        const errorDiv = form.querySelector('.form-error') || document.createElement('div');
        errorDiv.className = 'form-error';
        errorDiv.textContent = message;
        
        if (!form.querySelector('.form-error')) {
            form.insertBefore(errorDiv, form.firstChild);
        }
    }
});