<!-- Update Profile Form -->
<form id="form" method="post" action="{{ route('profile.update') }}" class="space-y-4">
    @csrf
    @method('patch')

    <div class="mb-3 input-control">
        <label for="name" class="form-label">{{ __('Name') }}</label>
        <input id="name" name="name" type="text" class="form-control"
            value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
        <div class="error text-danger mt-1"></div>
    </div>

    <div class="mb-3 input-control">
        <label for="email" class="form-label">{{ __('Email') }}</label>
        <input id="email" name="email" type="text" class="form-control"
            value="{{ old('email', $user->email) }}" required autocomplete="username">
        <div class="error text-danger mt-1"></div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div class="mt-2">
                <p class="text-sm text-warning">
                    {{ __('Your email address is unverified.') }}
                    <button form="send-verification" type="submit" class="btn btn-link p-0 align-baseline">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>
                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-sm text-success">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            </div>
        @endif
    </div>

    <script>
    const form = document.getElementById('form');
    const name = document.getElementById('name');
    const email = document.getElementById('email');

    // ❌ Disallow all special characters except dot (.), comma (,) and allow @ only for email
    const disallowedCharsName = /[^a-zA-Z0-9\s.,]/; 
    const disallowedCharsEmail = /[^a-zA-Z0-9\s@._,-]/;  

    // ✅ Real-time validation
    name.addEventListener('input', () => validateName());
    email.addEventListener('input', () => validateEmail());

    form.addEventListener('submit', e => {
        e.preventDefault();
        if (validateInputs()) {
            form.submit();
        }
    });

    const setError = (element, message) => {
        const inputControl = element.parentElement;
        const errorDisplay = inputControl.querySelector('.error');
        errorDisplay.innerText = message;
        inputControl.classList.add('error');
        inputControl.classList.remove('success');
    };

    const setSuccess = element => {
        const inputControl = element.parentElement;
        const errorDisplay = inputControl.querySelector('.error');
        errorDisplay.innerText = '';
        inputControl.classList.add('success');
        inputControl.classList.remove('error');
    };

    const isValidEmail = email => {
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    };

    // 🟢 Validate Name
    const validateName = () => {
        const nameValue = name.value.trim();
        if (nameValue === '') {
            setError(name, 'Name is required');
            return false;
        } else if (disallowedCharsName.test(nameValue)) {
            setError(name, "Special characters are not allowed");
            return false;
        } else {
            setSuccess(name);
            return true;
        }
    };

    // 🟢 Validate Email
    const validateEmail = () => {
        const emailValue = email.value.trim();
        if (emailValue === '') {
            setError(email, 'Email is required');
            return false;
        } else if (disallowedCharsEmail.test(emailValue)) {
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

    // ✅ Validate both (on submit)
    const validateInputs = () => {
        let isValid = true;
        if (!validateName()) isValid = false;
        if (!validateEmail()) isValid = false;
        return isValid;
    };
</script>


    <style>
        .input-control.success input {
            border: 1px solid #28a745; /* green */
        }
        .input-control.error input {
            border: 1px solid #dc3545; /* red */
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
    </div>

    @if (session('status') === 'profile-updated')
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Profile Updated',
                text: 'Your profile information has been successfully updated!',
                showConfirmButton: false,
                timer: 1000
            });
        </script>
    @endif
</form>
