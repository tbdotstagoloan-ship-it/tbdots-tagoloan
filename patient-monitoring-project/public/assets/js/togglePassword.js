function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleBtnIcon = document.querySelector('.password-toggle i');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleBtnIcon.classList.remove('fa-eye-slash');
        toggleBtnIcon.classList.add('fa-eye');
    } else {
        passwordInput.type = 'password';
        toggleBtnIcon.classList.remove('fa-eye');
        toggleBtnIcon.classList.add('fa-eye-slash');
    }
}

document.querySelector('form').addEventListener('submit', function (e) {
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const btn = document.getElementById('login-btn');
    const btnText = document.getElementById('login-btn-text');

    // ❌ If empty, prevent submit + no spin
    if (email === "" || password === "") {
        e.preventDefault();
        return;
    }

    // ✅ If filled, show loader
    btn.disabled = true;
    btn.style.transition = 'all 0.3s ease';
    btn.style.opacity = '0.7';
    btn.style.transform = 'scale(0.98)';
    btn.style.cursor = 'not-allowed';
    btnText.innerHTML = `
        <span class="loader"></span> Signing in...
    `;
});

// ✅ Listen for Laravel error (login failed)
// Assuming backend redirects back with errors
window.addEventListener("pageshow", function(event) {
    const btn = document.getElementById('login-btn');
    const btnText = document.getElementById('login-btn-text');

    // Check if there are error messages from backend (Laravel flashes errors into DOM)
    const errorBox = document.querySelector(".error-message, .invalid-feedback, .alert-danger");

    if (errorBox) {
        // Reset button state if login failed
        btn.disabled = false;
        btn.style.opacity = "1";
        btn.style.transform = "scale(1)";
        btn.style.cursor = "pointer";
        btnText.innerHTML = `Sign in`; // or your original button label
    }
});
