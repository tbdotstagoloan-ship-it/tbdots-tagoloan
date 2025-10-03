
            <form id="form" method="post" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                @method('put')

                <div class="mb-3">
                    <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
                    <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password">
                    @if ($errors->updatePassword->get('current_password'))
                        <div class="text-danger mt-1">
                            {{ $errors->updatePassword->first('current_password') }}
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
                    <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password">
                    @if ($errors->updatePassword->get('password'))
                        <div class="text-danger mt-1">
                            {{ $errors->updatePassword->first('password') }}
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
                    @if ($errors->updatePassword->get('password_confirmation'))
                        <div class="text-danger mt-1">
                            {{ $errors->updatePassword->first('password_confirmation') }}
                        </div>
                    @endif
                </div>

                <script>
const form = document.querySelector('form');
const currentPassword = document.getElementById('update_password_current_password');
const password = document.getElementById('update_password_password');
const passwordConfirmation = document.getElementById('update_password_password_confirmation');

const setError = (element, message) => {
    const inputControl = element.parentElement;
    let errorDisplay = inputControl.querySelector('.error');
    if (!errorDisplay) {
        errorDisplay = document.createElement('div');
        errorDisplay.classList.add('error');
        inputControl.appendChild(errorDisplay);
    }
    errorDisplay.innerText = message;
    inputControl.classList.add('error');
    inputControl.classList.remove('success');
};

const setSuccess = element => {
    const inputControl = element.parentElement;
    const errorDisplay = inputControl.querySelector('.error');
    if (errorDisplay) errorDisplay.innerText = '';
    inputControl.classList.add('success');
    inputControl.classList.remove('error');
};

const validatePassword = value => {
    if (value.length < 8) return "Password must be at least 8 characters";
    if (!/[A-Z]/.test(value)) return "At least one uppercase letter required";
    if (!/[a-z]/.test(value)) return "At least one lowercase letter required";
    if (!/[0-9]/.test(value)) return "At least one number required";
    if (!/[!@#$%^&*(),.?\":{}|<>]/.test(value)) return "At least one special character required";
    return "";
};

const validateField = field => {
    const value = field.value.trim();

    switch (field.id) {
        case "update_password_current_password":
            if (value === "") setError(field, "Current password is required");
            else setSuccess(field);
            break;

        case "update_password_password":
            const passwordError = validatePassword(value);
            if (value === "") setError(field, "New password is required");
            else if (passwordError) setError(field, passwordError);
            else setSuccess(field);
            break;

        case "update_password_password_confirmation":
            if (value === "") setError(field, "Please confirm your password");
            else if (password.value.trim() === "") setError(field, "Enter new password first");
            else if (value !== password.value) setError(field, "Passwords don't match");
            else setSuccess(field);
            break;
    }
};

// Real-time validation
[currentPassword, password, passwordConfirmation].forEach(input => {
    input.addEventListener("input", () => validateField(input));
    input.addEventListener("blur", () => validateField(input));
});

// Validate on submit
form.addEventListener('submit', e => {
    e.preventDefault();
    [currentPassword, password, passwordConfirmation].forEach(validateField);
    if (document.querySelectorAll(".input-control.error").length === 0) {
        form.submit();
    }
});
</script>


                <div class="d-flex align-items-center gap-3">
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                    @if (session('status') === 'password-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-success m-0"
                        >{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>
        
