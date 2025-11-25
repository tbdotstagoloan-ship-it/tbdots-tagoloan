<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>TB DOTS - Edit Patient Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}" />
    <link rel="icon" href="{{ url('assets/img/tbdots-logo-1.png') }}">
    
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
          <li><a href="{{ url('newly-diagnosed')}}" class="nav-link">Newly Diagnosed</a></li>
          <li><a href="{{ url('relapse') }}" class="nav-link">Relapse Patients</a></li>
          <li><a href="{{ url('underage')}}" class="nav-link">Underage Patients</a></li>
          <li><a href="{{ url('bacteriologically-confirmed') }}" class="nav-link">TB Classification</a></li>
          <li><a href="{{ url('pulmonary') }}" class="nav-link">Anatomical Sites</a></li>
          <li><a href="{{ url('ongoing-treatment')}}" class="nav-link">Ongoing Treatments</a></li>
          <li><a href="{{ url('barangay-cases')}}" class="nav-link">Barangay Cases</a></li>
          <li><a href="{{ url('intensive-treatment') }}" class="nav-link">Treatment Phases</a></li>
          <li><a href="{{ url('sputum-monitoring') }}" class="nav-link">Sputum Monitoring</a></li>
          <li><a href="{{ url('cured')}}" class="nav-link">Treatment Outcomes</a></li>
          <li><a href="{{ url('barangay-cases-notification') }}" class="nav-link">Barangay Cases Notification</a></li>
          <li><a href="{{ url('quarterly-cases-notification') }}" class="nav-link">Quarterly Reports</a></li>
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
        Update Patient Information
      </h4>
      
      <div class="card inventory-card shadow-sm border-0">
        <div class="card-body p-0">
          <div class="table-responsive">
                
                <form action="{{ route('patients.update', $patient->id) }}" method="POST" class="p-2">
                    @csrf
                    @method('PUT')
                  
                  <!-- <h5 class="mb-4" style="color: #495057;">Update Patient Information</h5> -->
                  <div class="row mb-3">
                    <div class="col-md-4">
                      <label for="pat_full_name">Patient's Full Name</label>
                      <input type="text" name="pat_full_name" class="form-control" 
                            value="{{ old('pat_full_name', $patient->pat_full_name) }}">
                    </div>
                    <div class="col-md-2">
                      <label for="pat_date_of_birth">Date of Birth</label>
                      <input type="date" name="pat_date_of_birth" class="form-control" 
                            value="{{ old('pat_date_of_birth', $patient->pat_date_of_birth) }}">
                    </div>
                    <div class="col-md-2">
                      <label for="pat_age">Age</label>
                      <input type="text" name="pat_age" class="form-control" 
                            value="{{ old('pat_age', $patient->pat_age) }}">
                    </div>
                    <div class="col-md-2">
                      <label for="pat_sex">Sex</label>
                      <select name="pat_sex" class="form-control form-select" required>
                        <option disabled>Select</option>
                        @foreach ([
                            "Male",
                            "Female"
                            ] as $sex)
                            <option value="{{ $sex }}" {{ old('pat_sex', $patient->pat_sex) == $sex ? 'selected' : '' }}>
                                {{$sex}}
                            </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-2">
                      <label for="pat_civil_status">Civil Status</label>
                       <select name="pat_civil_status" class="form-control form-select" required>
                        <option disabled >Select</option>
                        @foreach ([
                            "Single",
                            "Married",
                            "Divorced"
                            ] as $status)
                            <option value="{{ $status }}" {{ old('pat_civil_status', $patient->pat_civil_status) == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                       </select>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-3">
                      <label for="pat_permanent_address">Permanent Address</label>
                      <input type="text" name="pat_permanent_address" class="form-control" 
                            value="{{ old('pat_permanent_address', $patient->pat_permanent_address) }}" >
                    </div>
                    <div class="col-md-3">
                      <label for="pat_permanent_city_mun">City/ Municipality</label>
                      <input type="text" name="pat_permanent_city_mun" class="form-control" 
                            value="{{ old('pat_permanent_city_mun', $patient->pat_permanent_city_mun) }}">
                    </div>
                    <div class="col-md-3">
                      <label for="pat_permanent_region">Region</label>
                      <input type="text" name="pat_permanent_region" class="form-control" 
                            value="{{ old('pat_permanent_region', $patient->pat_permanent_region) }}">
                    </div>
                    <div class="col-md-3">
                      <label for="pat_permanent_zip_code">Zip Code</label>
                      <input type="text" name="pat_permanent_zip_code" class="form-control" 
                            value="{{ old('pat_permanent_zip_code', $patient->pat_permanent_zip_code) }}">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-3">
                      <label for="pat_current_address">Current Address</label>
                      <input type="text" name="pat_current_address" class="form-control" 
                            value="{{ old('pat_current_address', $patient->pat_current_address) }}" >
                    </div>
                    <div class="col-md-3">
                      <label for="pat_current_city_mun">City/ Municipality</label>
                      <input type="text" name="pat_current_city_mun" class="form-control" 
                            value="{{ old('pat_current_city_mun', $patient->pat_current_city_mun) }}">
                    </div>
                    <div class="col-md-3">
                      <label for="pat_current_region">Region</label>
                      <input type="text" name="pat_current_region" class="form-control" 
                            value="{{ old('pat_current_region', $patient->pat_current_region) }}">
                    </div>
                    <div class="col-md-3">
                      <label for="pat_current_zip_code">Zip Code</label>
                      <input type="text" name="pat_current_zip_code" class="form-control" 
                            value="{{ old('pat_current_zip_code', $patient->pat_current_zip_code) }}">
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="col-md-3">
                      <label for="pat_contact_number">Contact Number</label>
                      <input type="text" name="pat_contact_number" class="form-control" 
                            value="{{ old('pat_contact_number', $patient->pat_contact_number) }}">
                    </div>
                    <div class="col-md-3">
                      <label for="pat_other_contact">Other Contact Information</label>
                      <input type="text" name="pat_other_contact" class="form-control" 
                            value="{{ old('pat_other_contact', $patient->pat_other_contact) }}">
                    </div>
                    <div class="col-md-3">
                      <label for="pat_philhealth_no">PhilHealth No.</label>
                      <input type="text" name="pat_philhealth_no" class="form-control" 
                            value="{{ old('pat_philhealth_no', $patient->pat_philhealth_no) }}">
                    </div>
                    <div class="col-md-3">
                      <label for="pat_nationality">Nationality</label>
                      <input type="text" name="pat_nationality" class="form-control" 
                            value="{{ old('pat_nationality', $patient->pat_nationality) }}">
                    </div>
                  </div>
                  
                  <div class="float-end mb-4">
                   <button type="submit" class="btn btn-success">Update</button>
                   <a href="{{ url('patient') }}" class="btn btn-secondary">Cancel</a>
                </div>
                </form>

                </div>
              </div>

            </div>
          </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ url('assets/js/logout.js') }}"></script>

    <script src="{{ url('assets/js/sidebarToggle.js') }}"></script>

    <script src="{{ url('assets/js/active.js') }}"></script>

    <script src="{{ url('assets/js/rotate-icon.js') }}"></script>

    <script src="{{ url('assets/js/disabledBtn.js') }}"></script>


  </body>
</html>
