<x-guest-layout>

    <head>
        <title>TB DOTS | Register</title>
        <link rel="icon" href="{{ url('assets/img/lungs.png') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
        <!-- Add this once in your <head> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        <style>
            body {
                background: #f8f9fa;
                font-family: 'Poppins', sans-serif;
            }

            #form h1 {
                color: #0f2027;
                font-size: 20px;
                text-align: center;
                margin-bottom: 1rem;
            }

            #form button {
                padding: 8px;
                width: 100%;
                color: white;
                background-color: #2575fc;
                border: none;
                border-radius: 8px;
                cursor: pointer;
            }

            #form button:hover {
                background-color: #1a5ed8;
            }

            .input-control {
                display: flex;
                flex-direction: column;
                margin-bottom: 10px;
            }

            .input-control label {
                font-size: 14px;
            }

            .input-control input {
                border: 2px solid #f0f0f0;
                border-radius: 8px;
                font-size: 14px;
                padding: 8px;
                width: 100%;
                transition: border-color 0.3s;
            }

            .input-control input:focus {
                outline: 0;
                border-color: #fff;
                background: white;
                box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            }

            .input-control.success input {
                border-color: #09c372;
                /* green */
            }

            .input-control.error input {
                border-color: #ff3860;
                /* red */
            }

            .input-control .error {
                color: #ff3860;
                font-size: 12px;
                margin-top: 4px;
            }

            .already {
                text-align: center;
                margin-top: 1rem;
                font-size: 0.85rem;
            }

            .already a {
                color: #18a678;
                text-decoration: none;
                font-weight: 500;
            }

            .toggle-password {
                position: absolute;
                right: 10px;
                top: 35px;
                cursor: pointer;
                color: #6b7280;
                /* neutral gray */
                font-size: 14px;
            }

            .toggle-password:hover {
                color: #111827;
                /* darker on hover */
            }
        </style>
    </head>

    <body>
        <form id="form" method="POST" action="{{ route('register') }}">
            @csrf
            <h1>Sign Up</h1>

            <!-- Name -->
            <div class="input-control">
                <label for="name">Full Name</label>
                <input id="name" name="name" type="text" placeholder="Enter Full Name" value="{{ old('name') }}">
                <div class="error"></div>
            </div>

            <!-- Email -->
            <div class="input-control">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" placeholder="Enter Email" value="{{ old('email') }}">
                <div class="error"></div>
            </div>

            <!-- Phone -->
            <div class="input-control">
                <label for="phone">Phone</label>
                <input id="phone" name="phone" type="text" placeholder="Enter Phone" value="{{ old('phone') }}"
                    maxlength="11">
                <div class="error"></div>
            </div>

            <!-- Address -->
            <div class="input-control">
                <label for="address">Address</label>
                <input id="address" name="address" type="text" placeholder="Enter Address" value="{{ old('address') }}">
                <div class="error"></div>
            </div>

            <!-- Password -->
            <div class="input-control" style="position: relative;">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" placeholder="Enter Password">
                <span class="toggle-password" onclick="togglePassword('password', this)">
                    <i class="fa-solid fa-eye-slash"></i>
                </span>
                <div class="error"></div>
            </div>

            <!-- Confirm Password -->
            <div class="input-control" style="position: relative;">
                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password"
                    placeholder="Confirm Password">
                <span class="toggle-password" onclick="togglePassword('password_confirmation', this)">
                    <i class="fa-solid fa-eye-slash"></i>
                </span>
                <div class="error"></div>
            </div>

            <button type="submit">Sign Up</button>

            <div class="already">
                <p>
                    Already have an account?
                    <a href="{{ route('login') }}">Sign In</a>
                </p>
            </div>
        </form>
    </body>

    <script>
        const form = document.getElementById('form');
        const name = document.getElementById('name');
        const email = document.getElementById('email');
        const phone = document.getElementById('phone');
        const address = document.getElementById('address');
        const password = document.getElementById('password');
        const password_confirmation = document.getElementById('password_confirmation');

        // 🚫 Regex rules
        const allSpecialChars = /[^a-zA-Z0-9\s,.]/; // blocks all special chars (except space)
        const emailSpecialChars = /[^a-zA-Z0-9@._-]/; // allow only valid chars in email
        const phoneOnlyNumbers = /[^0-9]/; // only numbers for phone

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

        // ✅ validate single field
        const validateField = (field) => {
            const value = field.value.trim();

            switch (field.id) {
                case "name":
                    if (value === "") setError(field, "Full Name is required");
                    else if (allSpecialChars.test(value)) setError(field, "Special characters are not allowed");
                    else setSuccess(field);
                    break;

                case "email":
                    if (value === "") setError(field, "Email is required");
                    else if (emailSpecialChars.test(value)) setError(field, "Special characters are not allowed");
                    else if (!isValidEmail(value)) setError(field, "Provide a valid email address");
                    else setSuccess(field);
                    break;

                case "phone":
                    if (value === "") {
                        setError(field, "Phone is required");
                    } else if (phoneOnlyNumbers.test(value)) {
                        setError(field, "Only numbers are allowed");
                    } else if (value.length !== 11) {
                        setError(field, "Phone number must be exactly 11 digits");
                    } else {
                        setSuccess(field);
                    }
                    break;


                case "address":
                    if (value === "") setError(field, "Address is required");
                    else if (allSpecialChars.test(value)) setError(field, "Special characters are not allowed");
                    else setSuccess(field);
                    break;

                case "password":
                    if (value === "") setError(field, "Password is required");
                    else if (value.length < 8) setError(field, "Password must be at least 8 characters");
                    else if (!/[A-Z]/.test(value)) setError(field, "At least one uppercase letter required");
                    else if (!/[a-z]/.test(value)) setError(field, "At least one lowercase letter required");
                    else if (!/[0-9]/.test(value)) setError(field, "At least one number required");
                    else if (!/[!@#$%^&*(),.?\":{}|<>]/.test(value)) setError(field, "At least one special character required");
                    else setSuccess(field);
                    break;

                case "password_confirmation":
                    if (value === "") {
                        setError(field, "Please confirm your password");
                    } else if (password.value.trim() === "") {
                        setError(field, "Enter password first");
                    } else if (document.querySelector("#password").parentElement.classList.contains("error")) {
                        setError(field, "Original password is invalid");
                    } else if (value !== password.value) {
                        setError(field, "Passwords don't match");
                    } else {
                        setSuccess(field);
                    }
                    break;
            }
        };

        // ✅ real-time validation (only after typing)
        [name, email, phone, address, password, password_confirmation].forEach(input => {
            input.addEventListener("input", () => {
                if (input.value.trim().length > 0) {
                    validateField(input);
                }
            });

            input.addEventListener("blur", () => {
                if (input.value.trim().length > 0) {
                    validateField(input);
                }
            });
        });

        // final validation when submitting
        const validateInputs = () => {
            validateField(name);
            validateField(email);
            validateField(phone);
            validateField(address);
            validateField(password);
            validateField(password_confirmation);

            return document.querySelectorAll(".input-control.error").length === 0;
        };
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



</x-guest-layout>