<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>TB DOTS - Create Account</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="{{ url('assets/css/style.css') }}" />
  <link rel="stylesheet" href="{{ url('assets/css/register.css') }}">
  <link rel="icon" href="{{ url('assets/img/tbdots-logo-1.png') }}">
  <style>
    .toggle-password {
      position: absolute;
      right: 12px;
      top: 45px;
      cursor: pointer;
      color: #6b7280;
      /* neutral gray */
      font-size: 16px;
    }

    .toggle-password:hover {
      color: #6b7270;
      /* darker hover */
    }
  </style>
</head>

<body>

  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <div class="sidebar-logo">
        <img src="{{url('assets/img/tbdots-logo-1.png')}}" alt="TB DOTS Logo" />
      </div>
      <div class="sidebar-brand">
        <h2>TB DOTS</h2>
        <p>RHU, Tagoloan</p>
      </div>
    </div>

    <ul class="sidebar-menu" id="sidebarAccordion">
      <li class="menu-item" data-tooltip="Dashboard">
        <a href="{{url('dashboard')}}">
          <img src="{{ url('assets/img/m1.png') }}" class="menu-icon" alt="">
          <span class="menu-text">Dashboard</span>
        </a>
      </li>

      <li class="nav-item menu-item" data-tooltip="Patient">
        <a href="#" class="nav-link d-flex align-items-center patient-toggle">
          <img src="{{ url('assets/img/ap1.png') }}" class="menu-icon" alt="">
          <span class="menu-text">Patient</span>
          <i class="fas fa-chevron-right toggle-arrow"></i>
        </a>
        <ul class="submenu list-unstyled ps-4">
          <li><a class="nav-link" href="{{ url('form/page1') }}">Add New TB Patient</a></li>
          <li><a class="nav-link" href="{{ url('patient') }}">TB Patients</a></li>
        </ul>
      </li>

      <li class="nav-item menu-item" data-tooltip="Physician">
        <a href="{{ url('physician') }}">
          <img src="{{ url('assets/img/cross.png') }}" class="menu-icon" alt="">
          <span class="menu-text">Physician</span>
          </a>
      </li>

      <li class="menu-item" data-tooltip="Personnel">
        <a href="{{url('personnel')}}">
          <img src="{{ url('assets/img/friends.png') }}" class="menu-icon" alt="">
          <span class="menu-text">Personnel</span>
        </a>
      </li>

      <li class="menu-item" data-tooltip="Facilities">
        <a href="{{url('facilities')}}">
          <img src="{{ url('assets/img/hospital-facility.png') }}" class="menu-icon" alt="">
          <span class="menu-text">Facilities</span>
        </a>
      </li>

      <li class="menu-item" data-tooltip="Meidication Adherence">
        <!-- make the anchor position-relative and give some right padding (pe-4) -->
        <a href="{{url('medication-adherence-flags')}}" class="d-flex align-items-center position-relative pe-4">
          <img src="{{ url('assets/img/health-report.png') }}" class="menu-icon" alt="">
          <span class="menu-text">Missed Medication Intake</span>

          @if(!empty($missedAdherenceCount) && $missedAdherenceCount > 0)
            <span class="position-absolute top-50 end-0 translate-middle-y me-4 
                        bg-danger text-white border border-light 
                        rounded-circle d-flex justify-content-center align-items-center"
                  style="width: 16px; height: 16px; font-size: 10px; font-weight: 600;">
                {{ $missedAdherenceCount }}
            </span>
          @endif
        </a>
      </li>

      <li class="menu-item" data-tooltip="Patient Accounts">
        <a href="{{url('patient-accounts')}}">
          <img src="{{ url('assets/img/pa1.png') }}" class="menu-icon" alt="">
          <span class="menu-text">Patient Accounts</span>
        </a>
      </li>

      <!-- <li class="menu-item" data-tooltip="Notification">
        <a href="{{url('error')}}">
          <img src="{{ url('assets/img/n1.png') }}" class="menu-icon" alt="">
          <span class="menu-text">Notification</span>
        </a>
      </li> -->

      <li class="nav-item menu-item" data-tooltip="Generate Reports">
        <a href="#" class="nav-link d-flex align-items-center reports-toggle">
          <img src="{{ url('assets/img/r1.png') }}" class="menu-icon" alt="">
          <span class="menu-text">Generate Reports</span>
          <i class="fas fa-chevron-right toggle-arrow rotate-icon"></i>
        </a>
        <ul class="submenu list-unstyled ps-4">
          <li><a href="{{ url('adverse-event') }}" class="nav-link">Adverse Events</a></li>
          <li><a href="{{ url('pulmonary') }}" class="nav-link">Anatomical Sites</a></li>
          <li><a href="{{ url('barangay-cases')}}" class="nav-link">Barangay Cases</a></li>
          <li><a href="{{ url('barangay-cases-notification') }}" class="nav-link">Barangay Cases Notification</a></li>
          <li><a href="{{ url('newly-diagnosed')}}" class="nav-link">Newly Diagnosed</a></li>
          <li><a href="{{ url('ongoing-treatment')}}" class="nav-link">Ongoing Treatments</a></li>
          <li><a href="{{ url('quarterly-cases-notification') }}" class="nav-link">Quarterly Reports</a></li>
          <li><a href="{{ url('relapse') }}" class="nav-link">Relapse Patients</a></li>
          <li><a href="{{ url('sputum-monitoring') }}" class="nav-link">Sputum Monitoring</a></li>
          <li><a href="{{ url('bacteriologically-confirmed') }}" class="nav-link">TB Classification</a></li>
          <li><a href="{{ url('cured')}}" class="nav-link">Treatment Outcomes</a></li>
          <li><a href="{{ url('intensive-treatment') }}" class="nav-link">Treatment Phases</a></li>
          <li><a href="{{ url('underage')}}" class="nav-link">Underage Patients</a></li>
        </ul>
      </li>

      <!-- <li class="menu-item" data-tooltip="Settings">
        <a href="{{url('profile')}}">
          <img src="{{ url('assets/img/s1.png') }}" class="menu-icon" alt="">
          <span class="menu-text">Settings</span>
        </a>
      </li> -->
    </ul>

    <div class="logout-section">
      <form id="logout-form" method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="button" id="logout-btn" class="logout-button">
          <i class="fas fa-sign-out-alt menu-icon-logout"></i>
          <span class="menu-text">Logout</span>
        </button>
      </form>
    </div>

  </div>

  <div class="header" id="header">
    <div class="header-left">
      <button class="sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
      </button>
    </div>
  </div>

  <div class="main-content py-4" id="mainContent">
    <h4 style="margin-bottom: 20px; color: #2c3e50; font-weight: 600;">
      <!-- Create Patient Account -->
    </h4>

    <div class="page-wrapper">

      <div class="login-container">
        <div class="login-header">
          <h2>Create Patient Account</h2>
        </div>

        <!-- Login Form -->
        <form id="form" method="POST" action="{{ route('patient.register') }}">
          @csrf

          <input type="hidden" name="patient_id" value="{{ $patient->id }}">

          <div class="form-group">
            <label class="form-label">Username</label>
            <input type="text" id="username" name="acc_username" placeholder="Username"
              value="{{ old('acc_username') }}">
            @error('acc_username')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" id="password" name="acc_password" placeholder="Password">
            <span class="toggle-password" onclick="togglePassword('password', this)">
              <i class="fa-solid fa-eye-slash"></i>
            </span>
            @error('acc_password')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="register-btn" id="login-btn">
            <span id="register-btn-text">
              <i class="fas fa-user-plus"></i> Create Account
            </span>
          </button>
        </form>

      </div>
    </div>

  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="{{ url('assets/js/sidebarToggle.js') }}"></script>

  <script src="{{ url('assets/js/logout.js') }}"></script>

  <script src="{{ url('assets/js/active.js') }}"></script>

  <script src="{{ url('assets/js/rotate-icon.js') }}"></script>

  <script>
    const form = document.getElementById('form');
    const username = document.getElementById('username');
    const password = document.getElementById('password');

    // Username allowed chars: only letters, numbers, dot, @
    const hasInvalidChars = value => {
      const re = /^[a-zA-Z0-9.@]+$/;
      return !re.test(value);
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

    // Step-by-step password validation
    const firstPasswordError = value => {
      if (value.length < 8) {
        return "Password must be at least 8 characters";
      }
      if (!/[A-Z]/.test(value)) {
        return "At least one uppercase letter required";
      }
      if (!/[a-z]/.test(value)) {
        return "At least one lowercase letter required";
      }
      if (!/[0-9]/.test(value)) {
        return "At least one number required";
      }
      if (!/[!@#$%^&*(),.?\":{}|<>]/.test(value)) {
        return "At least one special character required";
      }
      return null; // ✅ all good
    };

    // Real-time username validation
    const liveValidateUsername = () => {
      const usernameValue = username.value.trim();

      if (usernameValue === '') {
        setError(username, 'Username is required');
      } else if (hasInvalidChars(usernameValue)) {
        setError(username, "Only letters, numbers, dot and @ are allowed");
      } else {
        setSuccess(username);
      }
    };

    // Real-time password validation
    const liveValidatePassword = () => {
      const passwordValue = password.value.trim();
      const error = firstPasswordError(passwordValue);

      if (passwordValue === '') {
        setError(password, 'Password is required');
      } else if (error) {
        setError(password, error);
      } else {
        setSuccess(password);
      }
    };

    // Final validation on submit
    const validateOnSubmit = () => {
      let isValid = true;
      const usernameValue = username.value.trim();
      const passwordValue = password.value.trim();

      if (usernameValue === '') {
        setError(username, 'Username is required');
        isValid = false;
      } else if (hasInvalidChars(usernameValue)) {
        setError(username, "Only letters, numbers, dot and @ are allowed");
        isValid = false;
      } else {
        setSuccess(username);
      }

      const error = firstPasswordError(passwordValue);
      if (passwordValue === '') {
        setError(password, 'Password is required');
        isValid = false;
      } else if (error) {
        setError(password, error);
        isValid = false;
      } else {
        setSuccess(password);
      }

      return isValid;
    };

    username.addEventListener('input', liveValidateUsername);
    password.addEventListener('input', liveValidatePassword);

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


</body>

</html>