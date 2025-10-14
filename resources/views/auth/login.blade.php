<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TB DOTS | Log-In</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link rel="icon" href="{{ url('assets/img/lungs.png') }}">
    <link rel="stylesheet" href="{{ url('assets/css/login.css') }}">
    
</head>
<body>
    
    <div class="page-wrapper">
        <!-- TOP LOGO -->
        <div class="top-logo">
            <img src="{{ url('assets/img/tbdots-logo-1.png') }}" alt="logo">
        </div>

    <div class="login-container">
        <div class="login-header">
            <h2>Please Sign In</h2>
        </div>

        <!-- Laravel Status Message -->
        <x-auth-session-status class="mb-4 text-red-500 text-sm text-center" :status="session('status')" />

        <!-- Login Form -->
        <form id="form" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="text" id="email" name="email" placeholder="Email" type="text" value="{{ old('email') }}">
                <div class="error"></div>
                <!-- @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror -->
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" type="text">
                <span class="toggle-password" onclick="togglePassword('password', this)">
                  <i class="fa-solid fa-eye-slash"></i>
              </span>
                <div class="error"></div>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="login-btn" id="login-btn">
                <span id="login-btn-text">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </span>
            </button>
        </form>
        <div class="text-center mt-4" style="font-size: 0.90rem;">
            <p>Don't have an account? <a href="{{ route('register') }}" style="text-decoration: none;">
                Sign Up
            </a>
            </p>
        </div>


    </div>
</div>

</body>
<!-- <script src="{{ url('assets/js/togglePassword.js') }}"></script> -->

<script>
  const form = document.getElementById('form');
  const email = document.getElementById('email');
  const password = document.getElementById('password');

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

  // 🔹 Real-time validation per field
  const liveValidateEmail = () => {
    const emailValue = email.value.trim();

    if (emailValue === '') {
      setError(email, 'Email is required');
    } else if (hasInvalidChars(emailValue)) {
      setError(email, "Special characters are not allowed");
    } else {
      setSuccess(email); // valid so far
    }
  };

  const liveValidatePassword = () => {
    const passwordValue = password.value.trim();

    if (passwordValue === '') {
      setError(password, 'Password is required');
    } else if (passwordValue.length < 8) {
      // Don’t show error until submit → just green if okay so far
      setSuccess(password);
    } else {
      setSuccess(password);
    }
  };

  // 🔹 Final validation on submit (full rules)
  const validateOnSubmit = () => {
    let isValid = true;
    const emailValue = email.value.trim();
    const passwordValue = password.value.trim();

    // Email strict check
    if (emailValue === '') {
      setError(email, 'Email is required');
      isValid = false;
    } else if (hasInvalidChars(emailValue)) {
      setError(email, "Special characters are not allowed");
      isValid = false;
    } else if (!isValidEmail(emailValue)) {
      setError(email, 'Provide a valid email address');
      isValid = false;
    } else {
      setSuccess(email);
    }

    // Password strict check
    if (passwordValue === '') {
      setError(password, 'Password is required');
      isValid = false;
    } else if (passwordValue.length < 8) {
      setError(password, 'Password must be at least 8 characters');
      isValid = false;
    } else {
      setSuccess(password);
    }

    return isValid;
  };

  // ✅ Real-time validation (per field only)
  email.addEventListener('input', liveValidateEmail);
  password.addEventListener('input', liveValidatePassword);

  // ✅ Final validation on submit
  form.addEventListener('submit', e => {
    e.preventDefault();
    if (validateOnSubmit()) {
      form.submit();
    }
  });
</script>

<script>
function togglePassword(fieldId, el) {
    const input = document.getElementById(fieldId);
    const icon = el.querySelector("i");

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    }
}
</script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@if ($errors->has('email'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            text: '{{ $errors->first('email') }}',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Try Again'
        });
    </script>
@endif



</html>
