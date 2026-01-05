<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TB DOTS | Forgot Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link rel="icon" href="{{ url('assets/img/tbdots-logo-1.png') }}">
    <link rel="stylesheet" href="{{ url('assets/css/login.css') }}">
</head>
<body>
    
    <div class="page-wrapper">
        <!-- TOP LOGO -->
        <!-- <div class="top-logo">
            <img src="{{ url('assets/img/tbdots-logo-1.png') }}" alt="logo">
        </div> -->

        <div class="login-container">
            <div class="login-header">
                <h2>Reset Password</h2>
                <p style="font-size: 0.9rem; color: #666; margin-top: 8px;">
                    Enter your email to receive a password reset link.
                </p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 20px; text-align: center; border: 1px solid #c3e6cb;">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Forgot Password Form -->
            <form id="form" method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="text" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}">
                    <div class="error"></div>
                    @error('email')
                        <div class="error-message" style="color: #dc3545; font-size: 0.875rem; margin-top: 5px;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="login-btn" id="submit-btn">
                    <span id="submit-btn-text">
                        <i class="fas fa-paper-plane"></i> Send Reset Link
                    </span>
                </button>
            </form>

            <div class="text-center mt-4" style="font-size: 0.90rem; margin-top: 20px;">
                <p>Remember your password? 
                    <a href="{{ route('login') }}" style="text-decoration: none; color: #4caf50; font-weight: 500;">
                        Back to Sign In
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const form = document.getElementById('form');
        const email = document.getElementById('email');

        // Allowed characters: letters, numbers, dot, @
        const hasInvalidChars = value => {
            const re = /[^a-zA-Z0-9.@]/;
            return re.test(value);
        };

        const setError = (element, message) => {
            const inputControl = element.parentElement;
            let errorDisplay = inputControl.querySelector('.error');

            if (!errorDisplay) {
                errorDisplay = document.createElement('div');
                errorDisplay.className = 'error';
                inputControl.appendChild(errorDisplay);
            }

            errorDisplay.innerText = message;
            inputControl.classList.add('error');
            inputControl.classList.remove('success');
        };

        const setSuccess = element => {
            const inputControl = element.parentElement;
            const errorDisplay = inputControl.querySelector('.error');

            if (errorDisplay) {
                errorDisplay.innerText = '';
            }

            inputControl.classList.add('success');
            inputControl.classList.remove('error');
        };

        const isValidEmail = email => {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(String(email).toLowerCase());
        };

        // Real-time validation
        const liveValidateEmail = () => {
            const emailValue = email.value.trim();

            if (emailValue === '') {
                setError(email, 'Email is required');
            } else if (hasInvalidChars(emailValue)) {
                setError(email, "Special characters are not allowed");
            } else {
                setSuccess(email);
            }
        };

        // Final validation on submit
        const validateOnSubmit = () => {
            const emailValue = email.value.trim();

            if (emailValue === '') {
                setError(email, 'Email is required');
                return false;
            } else if (hasInvalidChars(emailValue)) {
                setError(email, "Special characters are not allowed");
                return false;
            } else if (!isValidEmail(emailValue)) {
                setError(email, 'Provide a valid email address');
                return false;
            } else {
                setSuccess(email);
                return true;
            }
        };

        // Real-time validation
        email.addEventListener('input', liveValidateEmail);

        // Form submission
        form.addEventListener('submit', e => {
            e.preventDefault();
            if (validateOnSubmit()) {
                form.submit();
            }
        });
    </script>

    @if (session('status'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Email Sent!',
                text: '{{ session('status') }}',
                confirmButtonColor: '#4caf50',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if ($errors->has('email'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ $errors->first('email') }}',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Try Again'
            });
        </script>
    @endif

</body>
</html>