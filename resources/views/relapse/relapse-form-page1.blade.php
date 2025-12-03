<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>TB DOTS - Relapse Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="{{ url('assets/css/style.css') }}" />
  <link rel="icon" href="{{ url('assets/img/tbdots-logo-1.png') }}">
  <style>
    .card {
      background-color: #fff;
      border: 1px solid #e5e7eb;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .card-body {
      padding: 1.5rem;
    }

    .preview-table th {
      width: 35%;
      color: #6b7280;
      font-weight: 600;
      vertical-align: top;
    }

    .preview-table td {
      color: #111827;
      word-break: break-word;
    }

    .preview-table tr:not(:last-child) td,
    .preview-table tr:not(:last-child) th {
      border-bottom: 1px solid #f3f4f6;
      padding-bottom: 0.75rem;
    }

    .section-header {
      font-size: 1.1rem;
      font-weight: 700;
      color: #111827;
      margin-bottom: 0.75rem;
    }

    /* Error message styling */
    .error {
      color: #ef4444;
      font-size: 0.85rem;
    }

    .is-invalid {
      border-color: #ef4444;
      /* background-color: #fef2f2; */
      background-image: none !important;
      /* removes Bootstrap's error icon */
    }

    /* Green border for valid */
    .is-valid {
      border-color: #4caf50;
      background-color: #f1f8f4;
      background-image: none !important;
      /* removes Bootstrap's check icon */
    }

    #lab label.form-label {
      font-weight: 600;
      margin-bottom: 4px;
    }

    #lab input {
      border-radius: 6px;
    }

    #lab .row {
      margin-bottom: 1rem;
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
      RELAPSE REGISTRATION FORM
    </h4>

    <div class="card inventory-card shadow-sm border-0">
      <div class="card-body p-0">
        <div class="table-responsive">

          <form id="form" action="{{ url('validateRelapsePage1/' . $patient->id) }}" method="post" class="p-2" novalidate>
            @csrf

            <!-- Tabs -->
            <ul class="nav nav-tabs" id="formTabs" role="tablist">
              <li class="nav-item">
                <button class="nav-link active" id="case-tab" data-bs-toggle="tab" data-bs-target="#case" type="button"
                  role="tab">I. Case Finding / Notification</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="demo-tab" data-bs-toggle="tab" data-bs-target="#demo" type="button"
                  role="tab">Patient Demographic</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="screen-tab" data-bs-toggle="tab" data-bs-target="#screen" type="button"
                  role="tab">Screening Information</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="lab-tab" data-bs-toggle="tab" data-bs-target="#lab" type="button"
                  role="tab">Laboratory Tests</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="diag-tab" data-bs-toggle="tab" data-bs-target="#diag" type="button"
                  role="tab">Diagnosis</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="tb-tab" data-bs-toggle="tab" data-bs-target="#tb" type="button"
                  role="tab">TB Disease Classification</button>
              </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content p-3" id="formTabsContent">

              <!-- TAB 1: Case Finding -->
              <div class="tab-pane fade show active" id="case" role="tabpanel">
                <h5 class="mb-4">I. Case Finding / Notification</h5>
                <!-- your case finding fields -->
                <div class="row mb-2">
                <div class="col-md-3">
                  <label>Diagnosing Facility</label>
                  <input type="text" value="{{ $patient->diagnosingFacility->fac_name }}" class="form-control" readonly>
                </div>

                <div class="col-md-3">
                  <label>NTP Facility Code </label>
                  <input type="text" value="{{ $patient->diagnosingFacility->fac_ntp_code }}" class="form-control" readonly>
                </div>

                <div class="col-md-3">
                  <label>Province/ HUC </label>
                  <input type="text" value="{{ $patient->diagnosingFacility->fac_province }}" class="form-control" readonly>
                </div>

                <div class="col-md-3">
                  <label>Region </label>
                  <input type="text" value="{{ $patient->diagnosingFacility->fac_region }}" class="form-control" readonly>
                </div>
              </div>

                <div class="d-flex justify-content-between mt-4">
                  <a href="{{ url('patient') }}" class="btn backBtn d-flex align-items-center gap-1"><i class="fas fa-arrow-left"></i> Back</a>
                  <button type="button" class="btn backBtn next-tab d-flex align-items-center gap-1">
                    Next <i class="fas fa-arrow-right"></i>
                  </button>
                </div>
              </div>

              <!-- TAB 2: Patient Demographic -->
              <div class="tab-pane fade" id="demo" role="tabpanel">
                <h5 class="mb-4">A. Patient Demographic</h5>
                <div class="row mb-3">
                  <div class="col-md-4">
                    <label>Patient's Full Name </label>
                    <input type="text" value="{{ $patient->pat_full_name }}" class="form-control" readonly>
                  </div>
                  <div class="col-md-4">
                    <label>Date of Birth </label>
                      <input type="text" value="{{ $patient->pat_date_of_birth }}" class="form-control" readonly>
                  </div>
                  <div class="col-md-4">
                    <label>Age</label>
                    <input type="text" value="{{ $patient->pat_age }}" class="form-control" readonly>
                  </div>
                  <div class="col-md-4">
                    <label>Sex </label>
                    <input type="text" value="{{ $patient->pat_sex }}" class="form-control" readonly>
                  </div>
                  <div class="col-md-4">
                    <label>Civil Status </label>
                    <input type="text" value="{{ $patient->pat_civil_status }}" class="form-control" readonly>
                  </div>
                  <div class="col-md-4">
                    <label>Contact Number </label>
                    <input type="text" value="{{ $patient->pat_contact_number }}" class="form-control" readonly>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-4">
                    <label>Other Contact Information </label>
                    <input type="text" value="{{ $patient->pat_other_contact }}" class="form-control" readonly>
                  </div>
                  <div class="col-md-4">
                    <label>PhilHealth No. </label>
                    <input type="text" value="{{ $patient->pat_philhealth_no }}" class="form-control" readonly>
                  </div>
                  <div class="col-md-4">
                    <label>Nationality </label>
                    <input type="text" value="{{ $patient->pat_nationality }}" class="form-control" readonly>
                  </div>
                </div>

                <!-- ===== PERMANENT ADDRESS SECTION ===== -->
                <h5 class="mb-3">Permanent Address</h5>

                <div class="row mb-3">
                  <div class="col-md-4">
                    <label>Region </label>
                    <input type="text" value="{{ $patient->pat_permanent_region }}" class="form-control" readonly>
                  </div>

                  <div class="col-md-4">
                    <label>Province </label>
                    <input type="text" value="{{ $patient->pat_permanent_province }}" class="form-control" readonly>
                  </div>

                  <div class="col-md-4">
                    <label>City / Municipality </label>
                    <input type="text" value="{{ $patient->pat_permanent_city_mun }}" class="form-control" readonly>
                  </div>

                  <div class="col-md-4">
                    <label>Barangay </label>
                    <input type="text" value="{{ $patient->pat_permanent_address }}" class="form-control" readonly>
                  </div>

                  <div class="col-md-4">
                    <label>Zip Code</label>
                    <div class="error"></div>
                    <input type="text" value="{{ $patient->pat_permanent_zip_code }}" class="form-control" readonly>
                  </div>
                </div>


                <!-- ===== CURRENT ADDRESS SECTION ===== -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <h5 class="mb-0">Current Address</h5>
                </div>

                <div class="row mb-3">
                  <div class="col-md-4">
                    <label>Region </label>
                    <input type="text" value="{{ $patient->pat_current_region }}" class="form-control" readonly>
                  </div>

                  <div class="col-md-4">
                    <label>Province </label>
                    <input type="text" value="{{ $patient->pat_current_province }}" class="form-control" readonly>
                  </div>

                  <div class="col-md-4">
                    <label>City / Municipality </label>
                    <input type="text" value="{{ $patient->pat_current_city_mun }}" class="form-control" readonly>
                  </div>

                  <div class="col-md-4">
                    <label>Barangay </label>
                    <input type="text" value="{{ $patient->pat_current_address }}" class="form-control" readonly>
                  </div>

                  <div class="col-md-4">
                    <label>Zip Code</label>
                    <input type="text" value="{{ $patient->pat_current_zip_code }}" class="form-control" readonly>
                  </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                  <button type="button" class="btn backBtn prev-tab d-flex align-items-center gap-1">
                    <i class="fas fa-arrow-left"></i> Back
                  </button>
                  <button type="button" class="btn backBtn next-tab d-flex align-items-center gap-1">
                    Next <i class="fas fa-arrow-right"></i>
                  </button>
                </div>
              </div>


              <!-- TAB 3: Screening Information -->
              <div class="tab-pane fade" id="screen" role="tabpanel">
                <h5 class="mb-4">B. Screening Information</h5>
                <div class="row mb-3">
                  <div class="col-md-4">
                    <label>Referred by </label>
                    <!-- <input type="text" value="{{ $patient->latestScreening->scr_referred_by ?? '' }}" class="form-control" readonly> -->
                     <!-- <input type="text" name="scr_referred_by" id="scr_referred_by" class="form-control"
                      placeholder="Hospital / Barangay Name" required> -->
                      <input type="text" name="scr_referred_by" id="scr_referred_by" class="form-control" value="TB DOTS Tagoloan" readonly>
                  </div>
                  <div class="col-md-4">
                    <label>Location </label>
                    <!-- <input type="text" value="{{ $patient->latestScreening->scr_location ?? '' }}" class="form-control" readonly> -->
                     <!-- <input type="text" name="scr_location" id="scr_location" class="form-control"
                      placeholder="Location" required> -->
                      <input type="text" name="scr_location" id="scr_location" class="form-control" value="Poblacion, Tagoloan, Misamis Oriental" readonly>
                  </div>
                  <div class="col-md-4">
                    <label>Type of Referrer <span style="color: red;">*</span></label>
                    <!-- <input type="text" value="{{ $patient->latestScreening->scr_referrer_type ?? '' }}" class="form-control" readonly> -->
                     <select name="scr_referrer_type" id="scr_referrer_type" class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="Public">Public</option>
                      <option value="Other public">Other public</option>
                      <option value="Private">Private</option>
                      <option value="Community">Community</option>
                    </select>
                    <div class="error"></div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <label>Mode of Screening <span style="color: red;">*</span></label>
                    <!-- <input type="text" value="{{ $patient->latestScreening->scr_screening_mode ?? '' }}" class="form-control" readonly> -->
                     <select name="scr_screening_mode" id="scr_screening_mode" class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="PCF">PCF</option>
                      <option value="ACF">ACF</option>
                      <option value="ICF">ICF</option>
                      <option value="ECF">ECF</option>
                    </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label>Date of Screening <span style="color: red;">*</span></label>
                    <!-- <input type="text" value="{{ $patient->latestScreening->scr_screening_date ?? '' }}" class="form-control" readonly> -->
                     <input type="date" name="scr_screening_date" id="scr_screening_date" class="form-control" max="{{ date('Y-m-d') }}" required>
                     <div class="error"></div>
                  </div>
                </div>
                <div class="d-flex justify-content-between mt-4">
                  <button type="button" class="btn backBtn prev-tab d-flex align-items-center gap-1">
                    <i class="fas fa-arrow-left"></i> Back
                  </button>
                  <button type="button" class="btn backBtn next-tab d-flex align-items-center gap-1">
                    Next <i class="fas fa-arrow-right"></i>
                  </button>
                </div>
              </div>

              <!-- TAB 4: Laboratory Tests -->
              <div class="tab-pane fade" id="lab" role="tabpanel">
                <h5 class="mb-4 fw-bold">C. Laboratory Tests</h5>

                <!-- Xpert MTB/RIF -->
                <div class="row mb-3 align-items-end">
                  <div class="col-md-6">
                    <label for="lab_xpert_result" class="form-label">Xpert MTB/RIF Test Result <span
                        style="color: red;">*</span></label>
                    <select name="lab_xpert_result" id="lab_xpert_result" class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="MTB VERY HIGH">MTB VERY HIGH</option>
                      <option value="MTB HIGH">MTB HIGH</option>
                      <option value="MTB MEDIUM">MTB MEDIUM</option>
                      <option value="MTB LOW">MTB LOW</option>
                      <option value="MTB VERY LOW">MTB VERY LOW</option>
                      <option value="MTB NEGATIVE">MTB NEGATIVE</option>
                    </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-6">
                    <label for="lab_xpert_test_date" class="form-label">Xpert MTB/RIF Test Date <span
                        style="color: red;">*</span></label>
                    <input type="date" name="lab_xpert_test_date" id="lab_xpert_test_date" class="form-control"
                      max="{{ date('Y-m-d') }}" required>
                    <div class="error"></div>
                  </div>
                </div>

                <!-- Chest X-ray -->
                <div class="row mb-3 align-items-end">
                  <div class="col-md-6">
                    <label for="lab_cxray_result" class="form-label">Chest X-ray Test Result <span
                        style="color: red;">*</span></label>
                    <!-- <select name="lab_cxray_result" id="lab_cxray_result" class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="PTB BOTH RIGHT UPPER LOBE">PTB BOTH RIGHT UPPER LOBE</option>
                      <option value="PTB BOTH LOWER LOBE">PTB BOTH LOWER LOBE</option>
                      <option value="SUGGESTIVE POSITIVE TUBERCULOSIS">SUGGESTIVE POSITIVE TUBERCULOSIS</option>
                    </select> -->
                    <input type="text" name="lab_cxray_result" id="lab_cxray_result" class="form-control"
                        placeholder="Chest X-ray Test Result" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-6">
                    <label for="lab_cxray_test_date" class="form-label">Chest X-ray Test Date <span
                        style="color: red;">*</span></label>
                    <input type="date" name="lab_cxray_test_date" id="lab_cxray_test_date" class="form-control"
                      max="{{ date('Y-m-d') }}" required>
                    <div class="error"></div>
                  </div>
                </div>

                <!-- Smear Microscopy / TB Lamp -->
                <div class="row mb-3 align-items-end">
                  <div class="col-md-6">
                    <label for="lab_smear_result" class="form-label">Smear Microscopy Test Result <span
                        style="color: #6b7280;">(Optional)</span></label>
                    <select name="lab_smear_result" id="lab_smear_result" class="form-control form-select">
                      <option value="" disabled selected>Select</option>
                      <option value="Positive">Positive</option>
                      <option value="Negative">Negative</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="lab_smear_test_date" class="form-label">Smear Microscopy / TB Lamp Test Date <span
                        style="color: #6b7280;">(Optional)</span></label>
                    <input type="date" name="lab_smear_test_date" id="lab_smear_test_date" class="form-control"
                      max="{{ date('Y-m-d') }}">
                  </div>
                </div>

                <!-- Tuberculin Skin Test -->
                <div class="row mb-3 align-items-end">
                  <div class="col-md-6">
                    <label for="lab_tst_result" class="form-label">Tuberculin Skin Test Result <span
                        style="color: #6b7280;">(Optional)</span></label>
                    <select name="lab_tst_result" id="lab_tst_result" class="form-control form-select">
                      <option value="" disabled selected>Select</option>
                      <option value="Positive">Positive</option>
                      <option value="Negative">Negative</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="lab_tst_test_date" class="form-label">Tuberculin Skin Test Date <span
                        style="color: #6b7280;">(Optional)</span></label>
                    <input type="date" name="lab_tst_test_date" id="lab_tst_test_date" class="form-control"
                      max="{{ date('Y-m-d') }}">
                  </div>
                </div>

                <!-- Other -->
                <div class="row mb-3 align-items-end">
                  <div class="col-md-6">
                    <label for="lab_other_test_name" class="form-label">Other Test Name <span
                        style="color: #6b7280;">(Optional)</span></label>
                    <!-- <select name="lab_other_result" id="lab_other_result" class="form-control form-select">
                      <option value="" disabled selected>Select</option>
                      <option value="Positive">Positive</option>
                    </select> -->
                    <input type="text" name="lab_other_test_name" id="lab_other_test_name" class="form-control" placeholder="Specify">
                  </div>
                  <div class="col-md-6">
                    <label for="lab_other_result" class="form-label">Test Result <span
                        style="color: #6b7280;">(Optional)</span></label>
                    <input type="text" name="lab_other_result" id="lab_other_result" class="form-control" placeholder="Specify">
                  </div>
                  <div class="col-md-6">
                    <label for="lab_other_test_date" class="form-label">Test Date <span
                        style="color: #6b7280;">(Optional)</span></label>
                    <input type="date" name="lab_other_test_date" id="lab_other_test_date" class="form-control">
                  </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="d-flex justify-content-between mt-4">
                  <button type="button" class="btn backBtn prev-tab d-flex align-items-center gap-1">
                    <i class="fas fa-arrow-left"></i> Back
                  </button>
                  <button type="button" class="btn backBtn next-tab d-flex align-items-center gap-1">
                    Next <i class="fas fa-arrow-right"></i>
                  </button>
                </div>
              </div>

              <!-- TAB 5: Diagnosis -->
              <div class="tab-pane fade" id="diag" role="tabpanel">
                <h5 class="mb-4">D. Diagnosis</h5>
                <div class="row mb-3">
                  <div class="col-md-3">
                    <label for="diag_diagnosis_date">Date of Diagnosis <span style="color: red;">*</span></label>
                    <input type="date" name="diag_diagnosis_date" id="diag_diagnosis_date" class="form-control"
                      max="{{ date('Y-m-d') }}" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="diag_notification_date">Date of Notification </label>
                    <input type="date" name="diag_notification_date" id="diag_notification_date" class="form-control"
                        max="{{ date('Y-m-d') }}" readonly>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="diag_tb_case_no">TB Case Number</label>
                    <input type="text" name="diag_tb_case_no" id="diag_tb_case_no" class="form-control"
                      value="{{ $tbCaseNo }}" readonly>
                  </div>

                <!-- <div class="row mb-3"> -->
                  <div class="col-md-3">
                    <label for="diag_attending_physician">Attending Physician <span style="color: red;">*</span></label>
                    <select name="diag_attending_physician" id="diag_attending_physician"
                      class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                    </select>
                    <div class="error"></div>
                    </div>
                  </div>
                <div class="d-flex justify-content-between mt-4">
                  <button type="button" class="btn backBtn prev-tab d-flex align-items-center gap-1">
                    <i class="fas fa-arrow-left"></i> Back
                  </button>
                  <button type="button" class="btn backBtn next-tab d-flex align-items-center gap-1">
                    Next <i class="fas fa-arrow-right"></i>
                  </button>
                </div>
              </div>

              <!-- TAB 6: TB Disease Classification -->
              <div class="tab-pane fade" id="tb" role="tabpanel">
                <h5 class="mb-4">E. TB Disease Classification</h5>
                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="clas_bacteriological_status">Bacteriological Status <span
                        style="color: red;">*</span></label>
                    <select name="clas_bacteriological_status" id="clas_bacteriological_status"
                      class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="Bacteriologically-confirmed TB">Bacteriologically-confirmed TB</option>
                      <option value="Clinically-diagnosed TB">Clinically-diagnosed TB</option>
                    </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="clas_drug_resistance_status">Drug Resistance Bacteriological Status <span
                        style="color: red;">*</span></label>
                    <select name="clas_drug_resistance_status" id="clas_drug_resistance_status"
                      class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="Drug-susceptible">Drug-susceptible</option>
                      <option value="Bacteriologically-confirmed RR-TB">Bacteriologically-confirmed RR-TB</option>
                      <option value="Bacteriologically-confirmed MDR-TB">Bacteriologically-confirmed MDR-TB</option>
                      <option value="Bacteriologically-confirmed XDR-TB">Bacteriologically-confirmed XDR-TB</option>
                      <option value="Clinically-diagnosed MDR-TB">Clinically-diagnosed MDR-TB</option>
                    </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="clas_other_drug_resistant">Other Drug-resistant TB <span
                        style="color: #6b7280;">(Optional)</span></label>
                    <input type="text" name="clas_other_drug_resistant" id="clas_other_drug_resistant"
                      class="form-control" placeholder="Specify">
                    <div class="error"></div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <label for="clas_anatomical_site">Anatomical Site <span style="color: red;">*</span></label>
                    <select name="clas_anatomical_site" id="clas_anatomical_site" class="form-control form-select"
                      required>
                      <option value="" disabled selected>Select</option>
                      <option value="Pulmonary">Pulmonary</option>
                      <option value="Extra-pulmonary">Extra-pulmonary</option>
                    </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="clas_site_other">Extra-pulmonary Site <span
                        style="color: #6b7280;">(Optional)</span></label>
                    <!-- <input type="text" name="clas_site_other" id="clas_site_other" class="form-control"
                      placeholder="Specify"> -->
                      <select name="clas_site_other" id="clas_site_other" class="form-control form-select">
                        <option value="" disabled selected>Select</option>
                        <option value="TB Meningitis">TB Meningitis</option>
                        <option value="TB of Bones and Joints">TB of Bones and Joints</option>
                        <option value="Lymph Node TB">Lymph Node TB</option>
                        <option value="Pleural TB">Pleural TB</option>
                        <option value="Abdominal TB">Abdominal TB</option>
                        <option value="Genitourinary TB">Genitourinary TB</option>
                        <option value="TB of the Skin">TB of the Skin</option>
                        <option value="Pericardial TB">Pericardial TB</option>
                        <option value="Miliary TB">Miliary TB</option>
                      </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="clas_registration_group">Registration Group </label>
                    <input type="text" name="clas_registration_group" id="clas_registration_group" class="form-control" value="Relapse" readonly>
                    <div class="error"></div>
                  </div>
                </div>
                <div class="d-flex justify-content-between mt-4">
                  <button type="button" class="btn backBtn prev-tab d-flex align-items-center gap-1">
                    <i class="fas fa-arrow-left"></i> Back
                  </button>
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>
              </div>
            </div>

          </form>

          <!-- Preview Modal -->
          <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="previewModalLabel">Preview Entered Data</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="previewContent">
                  <!-- Auto-filled preview will show here -->
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn backBtn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-edit me-1"></i>Edit</button>
                  <button type="button" class="btn btn-success" id="confirmSubmit">
                    Confirm & Submit </button>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="{{ url('assets/js/logout.js') }}"></script>

  <script src="{{ url('assets/js/sidebarToggle.js') }}"></script>

  <script src="{{ url('assets/js/active.js') }}"></script>

  <script src="{{ url('assets/js/rotate-icon.js') }}"></script>

  <script src="{{ url('assets/js/tabs.js') }}"></script>

  <script>
    const form = document.getElementById('form');
    // Laboratory Tests
    const lab_xpert_test_date = document.getElementById('lab_xpert_test_date');
    const lab_xpert_result = document.getElementById('lab_xpert_result');
    const lab_cxray_test_date = document.getElementById('lab_cxray_test_date');
    const lab_cxray_result = document.getElementById('lab_cxray_result');
    const lab_smear_test_date = document.getElementById('lab_smear_test_date');
    const lab_smear_result = document.getElementById('lab_smear_result');
    const lab_tst_test_date = document.getElementById('lab_tst_test_date');
    const lab_tst_result = document.getElementById('lab_tst_result');
    const lab_other_test_date = document.getElementById('lab_other_test_date');
    const lab_other_result = document.getElementById('lab_other_result');
    // Diagnosis
    const diag_diagnosis_date = document.getElementById('diag_diagnosis_date');
    const diag_notification_date = document.getElementById('diag_notification_date');
    const diag_tb_case_no = document.getElementById('diag_tb_case_no');
    const diag_attending_physician = document.getElementById('diag_attending_physician');
    // TB Disease Classification
    const clas_bacteriological_status = document.getElementById('clas_bacteriological_status');
    const clas_drug_resistance_status = document.getElementById('clas_drug_resistance_status');
    const clas_other_drug_resistant = document.getElementById('clas_other_drug_resistant');
    const clas_anatomical_site = document.getElementById('clas_anatomical_site');
    const clas_site_other = document.getElementById('clas_site_other');
    const clas_registration_group = document.getElementById('clas_registration_group');

    // Get ALL inputs and selects in the form
    const allInputs = form.querySelectorAll("input, select");

    const requiredFields = [
    lab_xpert_test_date,
    lab_xpert_result,
    lab_cxray_test_date,
    lab_cxray_result,
    diag_diagnosis_date,
    diag_attending_physician,
    clas_bacteriological_status,
    clas_drug_resistance_status,
    clas_anatomical_site,
    clas_registration_group,
    ];

    form.addEventListener("submit", function (e) {
      e.preventDefault(); // stop default submit first

      if (validateInputs()) {

        const preview = document.getElementById("previewContent");

        preview.innerHTML = `
        <div class="container-fluid px-2">

          <!-- Laboratory Tests -->
          <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body">
              <h6 class="fw-bold mb-2">Laboratory Tests</h6>
              <table class="table table-borderless preview-table align-middle mb-0">
                <tbody>
                  <tr><th>Xpert Test Date</th><td>${lab_xpert_test_date.value}</td></tr>
                  <tr><th>Xpert Result</th><td>${lab_xpert_result.value}</td></tr>
                  <tr><th>Smear Microscopy Test Date</th><td>${lab_smear_test_date.value}</td></tr>
                  <tr><th>Smear Result</th><td>${lab_smear_result.value}</td></tr>
                  <tr><th>Chest X-ray Test Date</th><td>${lab_cxray_test_date.value}</td></tr>
                  <tr><th>Chest X-ray Result</th><td>${lab_cxray_result.value}</td></tr>
                  <tr><th>Tuberculin Skin Test Date</th><td>${lab_tst_test_date.value}</td></tr>
                  <tr><th>Tuberculin Skin Test Result</th><td>${lab_tst_result.value}</td></tr>
                  <tr><th>Other Test Date</th><td>${lab_other_test_date.value}</td></tr>
                  <tr><th>Other Test Result</th><td>${lab_other_result.value}</td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Diagnosis -->
          <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body">
              <h6 class="fw-bold mb-2">Diagnosis</h6>
              <table class="table table-borderless preview-table align-middle mb-0">
                <tbody>
                  <tr><th>Diagnosis Date</th><td>${diag_diagnosis_date.value}</td></tr>
                  <tr><th>Notification Date</th><td>${diag_notification_date.value}</td></tr>
                  <tr><th>TB Case Number</th><td>${diag_tb_case_no.value}</td></tr>
                  <tr><th>Attending Physician</th><td>${diag_attending_physician.options[diag_attending_physician.selectedIndex]?.text || 'N/A'}</td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- TB Disease Classification -->
          <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body">
              <h6 class="fw-bold mb-2">TB Disease Classification</h6>
              <table class="table table-borderless preview-table align-middle mb-0">
                <tbody>
                  <tr><th>Bacteriological Status</th><td>${clas_bacteriological_status.value}</td></tr>
                  <tr><th>Drug Resistance Status</th><td>${clas_drug_resistance_status.value}</td></tr>
                  <tr><th>Other Drug-resistant TB</th><td>${clas_other_drug_resistant.value}</td></tr>
                  <tr><th>Anatomical Site</th><td>${clas_anatomical_site.value}</td></tr>
                  <tr><th>Extra-pulmonary Site</th><td>${clas_site_other.value}</td></tr>
                  <tr><th>Registration Group</th><td>${clas_registration_group.value}</td></tr>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      `;

        // show modal
        let modal = new bootstrap.Modal(document.getElementById("previewModal"));
        modal.show();
      }
    });
    
      // Final confirm button - submit the form
    document.getElementById("confirmSubmit").addEventListener("click", function () {
    form.submit();
    });


    const setError = (element, message) => {
      const errorDisplay = element.parentElement.querySelector('.error');
      if (errorDisplay) errorDisplay.innerText = message;
      element.classList.add('is-invalid');
      element.classList.remove('is-valid');
    };

    const setSuccess = (element) => {
      const errorDisplay = element.parentElement.querySelector('.error');
      if (errorDisplay) errorDisplay.innerText = '';
      element.classList.add('is-valid');
      element.classList.remove('is-invalid');
    };

    function validateInputs() {
      let isValid = true;
      const today = new Date();

      const validateField = (element) => {
        // Skip validation for disabled fields (they're auto-filled)
        if (element.disabled) {
          return true;
        }

        const value = element.value.trim();

        // Required check
        if (!value || value === "") {
          setError(element, "This field is required.");
          return false;
        }

        // Special character check for all text fields
        if (element.type === "text" && value) {
          const regex = /^[a-zA-Z0-9 ,.\-\/]*$/;
          if (!regex.test(value)) {
            setError(element, "Special characters prohibited.");
            return false;
          }
        }

        // Date check (prevent future dates)
        if (element.type === "date" && value) {
          const selectedDate = new Date(value);
          if (selectedDate > today) {
            setError(element, "Enter a valid date.");
            return false;
          }
        }

        setSuccess(element);
        return true;
      };

      requiredFields.forEach(field => {
        if (!validateField(field)) isValid = false;
    });

      return isValid;
    }

    // Real-time validation
    allInputs.forEach(input => {
      const validateField = () => {

        // Skip validation for disabled fields
        if (input.disabled) {
          return;
        }

        const value = input.value.trim();
        const today = new Date();

        if (requiredFields.includes(input) && (!value || value === "")) {
        setError(input, "This field is required.");
        } else if (input.type === "date" && value) {
        const selectedDate = new Date(value);
        if (selectedDate > today) {
            setError(input, "Enter a valid date.");
        } else {
            setSuccess(input);
        }
        } else if (value && value !== "") {
        setSuccess(input);
        } else if (!requiredFields.includes(input)) {
        input.classList.remove("is-valid", "is-invalid");
        const errorDisplay = input.parentElement.querySelector('.error');
        if (errorDisplay) errorDisplay.innerText = '';
        }
    };

    input.addEventListener("input", validateField);
    input.addEventListener("change", validateField);
    });

  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const tabs = document.querySelectorAll("#formTabs .nav-link");
      const nextButtons = document.querySelectorAll(".next-tab");
      const prevButtons = document.querySelectorAll(".prev-tab");
      let isAlertShown = false;

      // Track which tabs are already valid
      const validatedTabs = new Set();

      // 🔹 Validate all required fields within a specific tab
      function validateTab(tabId) {
        const requiredInputs = document.querySelectorAll(`#${tabId} [required]`);
        let isValid = true;

        requiredInputs.forEach(input => {
          const errorDiv = input.nextElementSibling;
          if (input.value.trim() === "") {
            isValid = false;
            input.classList.add("is-invalid");
            if (errorDiv && errorDiv.classList.contains("error")) {
              errorDiv.textContent = "This field is required.";
            }
          } else {
            input.classList.remove("is-invalid");
            if (errorDiv && errorDiv.classList.contains("error")) {
              errorDiv.textContent = "";
            }
          }
        });

        // If valid, mark tab as validated
        if (isValid) validatedTabs.add(tabId);
        return isValid;
      }

      // 🔹 Show SweetAlert warning
      function showValidationAlert() {
        if (!isAlertShown) {
          isAlertShown = true;
          Swal.fire({
            icon: "warning",
            title: "Incomplete Fields",
            text: "Please fill out all required fields before proceeding.",
            confirmButtonColor: "#198754",
            confirmButtonText: "OK",
          }).then(() => {
            isAlertShown = false;
          });
        }
      }

      // 🔹 Prevent switching tabs if moving forward to a higher tab index
      tabs.forEach((tab, index) => {
        tab.addEventListener("show.bs.tab", function (e) {
          const currentActive = document.querySelector("#formTabs .nav-link.active");
          const currentIndex = Array.from(tabs).indexOf(currentActive);

          // Only validate if moving forward
          if (index > currentIndex) {
            const currentPane = document.querySelector(currentActive.dataset.bsTarget);
            if (!currentPane) return;

            const currentTabId = currentPane.id;
            if (!validateTab(currentTabId)) {
              e.preventDefault();
              showValidationAlert();
            }
          }
        });
      });

      // 🔹 Handle "Next" buttons
      nextButtons.forEach(btn => {
        btn.addEventListener("click", function () {
          const currentPane = btn.closest(".tab-pane");
          const currentTabId = currentPane.id;
          if (validateTab(currentTabId)) {
            const currentTab = document.querySelector(`#formTabs .nav-link[data-bs-target="#${currentTabId}"]`);
            const nextTab = currentTab.parentElement.nextElementSibling?.querySelector(".nav-link");
            if (nextTab) new bootstrap.Tab(nextTab).show();
          } else {
            showValidationAlert();
          }
        });
      });

      // 🔹 Handle "Back" buttons (always allowed)
      prevButtons.forEach(btn => {
        btn.addEventListener("click", function () {
          const currentPane = btn.closest(".tab-pane");
          const currentTabId = currentPane.id;
          const currentTab = document.querySelector(`#formTabs .nav-link[data-bs-target="#${currentTabId}"]`);
          const prevTab = currentTab.parentElement.previousElementSibling?.querySelector(".nav-link");
          if (prevTab) new bootstrap.Tab(prevTab).show();
        });
      });
    });
  </script>

  <!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
      const screeningInput = document.getElementById('scr_screening_date');
      const notificationInput = document.getElementById('diag_notification_date');

      screeningInput.addEventListener('change', function () {
        if (this.value) {
          notificationInput.value = this.value;
        } else {
          notificationInput.value = '';
        }
      });
    });
  </script> -->

  <!-- <script>
    document.addEventListener("DOMContentLoaded", function () {
      const permRegion = document.getElementById("pat_permanent_region");
      const permProvince = document.getElementById("pat_permanent_province");
      const permCity = document.getElementById("pat_permanent_city_mun");
      const permBrgy = document.getElementById("pat_permanent_address");
      const permZip = document.getElementById("pat_permanent_zip_code");

      const currRegion = document.getElementById("pat_current_region");
      const currProvince = document.getElementById("pat_current_province");
      const currCity = document.getElementById("pat_current_city_mun");
      const currBrgy = document.getElementById("pat_current_address");
      const currZip = document.getElementById("pat_current_zip_code");

      const sameCheckbox = document.getElementById("sameAsPermanent");

      fetch("/api/regions")
        .then(res => res.json())
        .then(data => {
          data.forEach(region => {
            permRegion.innerHTML += `<option value="${region.regCode}">${region.regDesc}</option>`;
            currRegion.innerHTML += `<option value="${region.regCode}">${region.regDesc}</option>`;
          });
        });

      function copyPermanentToCurrent() {
        currRegion.value = permRegion.value;
        currProvince.innerHTML = permProvince.innerHTML;
        currCity.innerHTML = permCity.innerHTML;
        currBrgy.innerHTML = permBrgy.innerHTML;

        currProvince.value = permProvince.value;
        currCity.value = permCity.value;
        currBrgy.value = permBrgy.value;
        currZip.value = permZip.value;
      }

      function toggleCurrentFields(makeReadonly) {
        [currRegion, currProvince, currCity, currBrgy, currZip].forEach(el => {
          if (makeReadonly) {
            el.setAttribute('readonly', 'readonly');
            el.style.pointerEvents = 'none';
            el.style.backgroundColor = '#e9ecef';
          } else {
            el.removeAttribute('readonly');
            el.style.pointerEvents = 'auto';
            el.style.backgroundColor = '';
          }
        });
      }

      permRegion.addEventListener("change", () => {
        fetch(`/api/provinces/${permRegion.value}`)
          .then(res => res.json())
          .then(data => {
            permProvince.innerHTML = '<option value="">Select</option>';
            permCity.innerHTML = '<option value="">Select</option>';
            permBrgy.innerHTML = '<option value="">Select</option>';
            data.forEach(prov => {
              permProvince.innerHTML += `<option value="${prov.provCode}">${prov.provDesc}</option>`;
            });
            if (sameCheckbox.checked) copyPermanentToCurrent();
          });
      });

      permProvince.addEventListener("change", () => {
        fetch(`/api/cities/${permProvince.value}`)
          .then(res => res.json())
          .then(data => {
            permCity.innerHTML = '<option value="">Select</option>';
            permBrgy.innerHTML = '<option value="">Select</option>';
            data.forEach(city => {
              permCity.innerHTML += `<option value="${city.citymunCode}">${city.citymunDesc}</option>`;
            });
            if (sameCheckbox.checked) copyPermanentToCurrent();
          });
      });

      permCity.addEventListener("change", () => {
        fetch(`/api/barangays/${permCity.value}`)
          .then(res => res.json())
          .then(data => {
            permBrgy.innerHTML = '<option value="">Select</option>';
            data.forEach(brgy => {
              permBrgy.innerHTML += `<option value="${brgy.brgyCode}">${brgy.brgyDesc}</option>`;
            });
            if (sameCheckbox.checked) copyPermanentToCurrent();
          });

        fetch(`/api/zipcode/${permCity.value}`)
          .then(res => res.json())
          .then(data => {
            permZip.value = data?.postal_code || '';
            if (sameCheckbox.checked) currZip.value = permZip.value;
          });
      });

      permBrgy.addEventListener("change", () => {
        if (sameCheckbox.checked) copyPermanentToCurrent();
      });

      currRegion.addEventListener("change", () => {
        fetch(`/api/provinces/${currRegion.value}`)
          .then(res => res.json())
          .then(data => {
            currProvince.innerHTML = '<option value="">Select</option>';
            currCity.innerHTML = '<option value="">Select</option>';
            currBrgy.innerHTML = '<option value="">Select</option>';
            data.forEach(prov => {
              currProvince.innerHTML += `<option value="${prov.provCode}">${prov.provDesc}</option>`;
            });
          });
      });

      currProvince.addEventListener("change", () => {
        fetch(`/api/cities/${currProvince.value}`)
          .then(res => res.json())
          .then(data => {
            currCity.innerHTML = '<option value="">Select</option>';
            currBrgy.innerHTML = '<option value="">Select</option>';
            data.forEach(city => {
              currCity.innerHTML += `<option value="${city.citymunCode}">${city.citymunDesc}</option>`;
            });
          });
      });

      currCity.addEventListener("change", () => {
        fetch(`/api/barangays/${currCity.value}`)
          .then(res => res.json())
          .then(data => {
            currBrgy.innerHTML = '<option value="">Select</option>';
            data.forEach(brgy => {
              currBrgy.innerHTML += `<option value="${brgy.brgyCode}">${brgy.brgyDesc}</option>`;
            });
          });

        fetch(`/api/zipcode/${currCity.value}`)
          .then(res => res.json())
          .then(data => {
            currZip.value = data?.postal_code || '';
          });
      });

      sameCheckbox.addEventListener("change", () => {
        if (sameCheckbox.checked) {
          copyPermanentToCurrent();
          toggleCurrentFields(true);
        } else {
          toggleCurrentFields(false);
          currProvince.innerHTML = '<option value="">Select</option>';
          currCity.innerHTML = '<option value="">Select</option>';
          currBrgy.innerHTML = '<option value="">Select</option>';
          currZip.value = '';
        }
      });
    });
  </script> -->

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    const selectPhysician = document.getElementById('diag_attending_physician');

    fetch('/api/physicians')
      .then(response => response.json())
      .then(data => {
        selectPhysician.innerHTML = '<option value="" disabled selected>Select</option>';

        data.forEach(physician => {
          const prefix = physician.phy_designation === 'Doctor' ? 'Dr. ' : '';
          const fullName = `${prefix}${physician.phy_first_name} ${physician.phy_last_name}`;
          const option = document.createElement('option');
          option.value = fullName; // ✅ store full name instead of ID
          option.textContent = fullName;
          selectPhysician.appendChild(option);
        });
      })
      .catch(error => console.error('Error fetching physicians:', error));
  });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const screeningInput = document.getElementById('scr_screening_date');
      const notificationInput = document.getElementById('diag_notification_date');

      screeningInput.addEventListener('change', function () {
        if (this.value) {
          // Auto-fill notification date same as screening date
          notificationInput.value = this.value;
        } else {
          // Clear if screening date removed
          notificationInput.value = '';
        }
      });
    });
  </script>


</body>

</html>