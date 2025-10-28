<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>TB DOTS - Add New Patient</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="{{ url('assets/css/style.css') }}" />
  <link rel="icon" href="{{ url('assets/img/lungs.png') }}">
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
        <a href="{{url('admin/dashboard')}}">
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
          <li><a class="nav-link" href="{{ url('form/page1') }}">Add TB Patient</a></li>
          <li><a class="nav-link" href="{{ url('patient') }}">TB Patients</a></li>
        </ul>
      </li>

      <li class="nav-item menu-item" data-tooltip="Physician / Personnel">
        <a href="{{ url('physician') }}">
          <img src="{{ url('assets/img/cross.png') }}" class="menu-icon" alt="">
          <span class="menu-text">Physician / Personnel</span>
          </a>
      </li>

      <li class="menu-item" data-tooltip="Facilities">
        <a href="{{url('facilities')}}">
          <img src="{{ url('assets/img/hospital-facility.png') }}" class="menu-icon" alt="">
          <span class="menu-text">Facilities</span>
        </a>
      </li>

      <li class="menu-item" data-tooltip="Meidication Adherence Flags">
        <!-- make the anchor position-relative and give some right padding (pe-4) -->
        <a href="{{url('medication-adherence-flags')}}" class="d-flex align-items-center position-relative pe-2">
          <img src="{{ url('assets/img/health-report.png') }}" class="menu-icon" alt="">
          <span class="menu-text">Medication Adherence Flags</span>

          @if(!empty($missedAdherenceCount) && $missedAdherenceCount > 0)
            <!-- dot positioned relative to the anchor -->
            <span class="position-absolute top-50 end-0 translate-middle-y me-3 p-1 bg-danger border border-light rounded-circle" 
                  style="width:10px; height:10px;" title="{{ $missedAdherenceCount }} missed">
              <span class="visually-hidden">{{ $missedAdherenceCount }} missed</span>
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

      <li class="menu-item" data-tooltip="Settings">
        <a href="{{url('profile')}}">
          <img src="{{ url('assets/img/s1.png') }}" class="menu-icon" alt="">
          <span class="menu-text">Settings</span>
        </a>
      </li>
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
      FORM 4B. DS-TB TREATMENT CARD
    </h4>

    <div class="card inventory-card shadow-sm border-0">
      <div class="card-body p-0">
        <div class="table-responsive">

          <form id="form" action="{{ url('validatePage1') }}" method="post" class="p-2" novalidate>
            @csrf

            <!-- Tabs -->
            <ul class="nav nav-tabs" id="formTabs" role="tablist">
              <li class="nav-item">
                <button class="nav-link active" id="case-tab" data-bs-toggle="tab" data-bs-target="#case" type="button"
                  role="tab">I. Case Finding / Notification</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="demo-tab" data-bs-toggle="tab" data-bs-target="#demo" type="button"
                  role="tab">A. Patient Demographic</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="screen-tab" data-bs-toggle="tab" data-bs-target="#screen" type="button"
                  role="tab">B. Screening Information</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="lab-tab" data-bs-toggle="tab" data-bs-target="#lab" type="button"
                  role="tab">C. Laboratory Tests</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="diag-tab" data-bs-toggle="tab" data-bs-target="#diag" type="button"
                  role="tab">D. Diagnosis</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="tb-tab" data-bs-toggle="tab" data-bs-target="#tb" type="button"
                  role="tab">E. TB Disease Classification</button>
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
                  <label for="fac_name">Diagnosing Facility <span style="color: red;">*</span></label>
                  <select name="fac_name" id="fac_name" class="form-control" required>
                    <option value="" disabled selected>Select</option>
                    <!-- dynamic options here -->
                  </select>
                  <div class="error"></div>
                </div>

                <div class="col-md-3">
                  <label for="fac_ntp_code">NTP Facility Code <span style="color: red;">*</span></label>
                  <input type="text" name="fac_ntp_code" id="fac_ntp_code" class="form-control" readonly>
                  <div class="error"></div>
                </div>

                <div class="col-md-3">
                  <label for="fac_province">Province/ HUC <span style="color: red;">*</span></label>
                  <input type="text" name="fac_province" id="fac_province" class="form-control" readonly>
                  <div class="error"></div>
                </div>

                <div class="col-md-3">
                  <label for="fac_region">Region <span style="color: red;">*</span></label>
                  <input type="text" name="fac_region" id="fac_region" class="form-control" readonly>
                  <div class="error"></div>
                </div>
              </div>

                <div class="d-flex justify-content-end mt-4">
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
                    <label for="pat_full_name">Patient's Full Name <span style="color: red;">*</span></label>
                    <input type="text" name="pat_full_name" id="pat_full_name" class="form-control"
                      placeholder="Patient's Full Name" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="pat_date_of_birth">Date of Birth <span style="color: red;">*</span></label>
                    <input type="date" name="pat_date_of_birth" id="pat_date_of_birth" class="form-control"
                      max="<?php echo date('Y-m-d'); ?>" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="pat_age">Age</label>
                    <input type="text" name="pat_age" id="pat_age" class="form-control" placeholder="Years Months"
                      readonly>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="pat_sex">Sex <span style="color: red;">*</span></label>
                    <select name="pat_sex" id="pat_sex" class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="pat_civil_status">Civil Status <span style="color: red;">*</span></label>
                    <select name="pat_civil_status" id="pat_civil_status" class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="Single">Single</option>
                      <option value="Married">Married</option>
                      <option value="Divorced">Divorced</option>
                    </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="pat_contact_number">Contact Number <span style="color: red;">*</span></label>
                    <input type="text" name="pat_contact_number" id="pat_contact_number" class="form-control"
                      placeholder="Contact Number" maxlength="11" required>
                    <div class="error"></div>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="pat_other_contact">Other Contact Information <span
                        style="color: #6b7280;">(Optional)</span></label>
                    <input type="text" name="pat_other_contact" id="pat_other_contact" class="form-control"
                      placeholder="Other Contact Information" maxlength="11">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="pat_philhealth_no">PhilHealth No. <span
                        style="color: #6b7280;">(Optional)</span></label>
                    <input type="text" name="pat_philhealth_no" id="pat_philhealth_no" class="form-control"
                      placeholder="PhilHealth Number">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="pat_nationality">Nationality <span style="color: red;">*</span></label>
                    <select name="pat_nationality" id="pat_nationality" class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="Filipino">Filipino</option>
                    </select>
                    <div class="error"></div>
                  </div>
                </div>

                <!-- ===== PERMANENT ADDRESS SECTION ===== -->
                <h5 class="mb-3">Permanent Address</h5>

                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="pat_permanent_region">Region <span style="color: red;">*</span></label>
                    <select id="pat_permanent_region" class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                    </select>
                    <input type="hidden" name="pat_permanent_region" id="pat_permanent_region_text">
                    <!-- <input type="text" name="pat_permanent_region" id="pat_permanent_region" class="form-control" required> -->
                    <div class="error"></div>
                  </div>

                  <div class="col-md-4">
                    <label for="pat_permanent_province">Province <span style="color: red;">*</span></label>
                    <select id="pat_permanent_province" class="form-control form-select"
                      required>
                      <option value="" disabled selected>Select</option>
                    </select>
                    <input type="hidden" name="pat_permanent_province" id="pat_permanent_province_text">
                    <!-- <input type="text" name="pat_permanent_province" id="pat_permanent_province" class="form-control" required> -->
                    <div class="error"></div>
                  </div>

                  <div class="col-md-4">
                    <label for="pat_permanent_city_mun">City / Municipality <span style="color: red;">*</span></label>
                    <select id="pat_permanent_city_mun" class="form-control form-select"
                      required>
                      <option value="" disabled selected>Select</option>
                    </select>
                    <input type="hidden" name="pat_permanent_city_mun" id="pat_permanent_city_mun_text">
                    <!-- <input type="text" name="pat_permanent_city_mun" id="pat_permanent_city_mun" class="form-control" required> -->
                    <div class="error"></div>
                  </div>

                  <div class="col-md-4">
                    <label for="pat_permanent_address">Barangay <span style="color: red;">*</span></label>
                    <select id="pat_permanent_address" class="form-control form-select"
                      required>
                      <option value="" disabled selected>Select</option>
                    </select>
                    <input type="hidden" name="pat_permanent_address" id="pat_permanent_address_text">
                    <!-- <input type="text" name="pat_permanent_address" id="pat_permanent_address" class="form-control" required> -->
                    <div class="error"></div>
                  </div>

                  <div class="col-md-4">
                    <label for="pat_permanent_zip_code">Zip Code</label>
                    <input type="text" id="pat_permanent_zip_code" name="pat_permanent_zip_code" class="form-control" readonly>
                    <div class="error"></div>
                  </div>
                </div>


                <!-- ===== CURRENT ADDRESS SECTION ===== -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <h5 class="mb-0">Current Address</h5>

                  <div class="form-check formal-checkbox">
                    <input type="checkbox" class="form-check-input" id="sameAsPermanent">
                    <label class="form-check-label" for="sameAsPermanent">Same as Permanent Address</label>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="pat_current_region">Region <span style="color: red;">*</span></label>
                    <select id="pat_current_region" class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                    </select>
                    <input type="hidden" name="pat_current_region" id="pat_current_region_text">
                    <!-- <input type="text" id="pat_current_region" name="pat_current_region" class="form-control" required> -->
                    <div class="error"></div>
                  </div>

                  <div class="col-md-4">
                    <label for="pat_current_province">Province <span style="color: red;">*</span></label>
                    <select id="pat_current_province" class="form-control form-select"
                      required>
                      <option value="" disabled selected>Select</option>
                    </select>
                    <input type="hidden" name="pat_current_province" id="pat_current_province_text">
                    <!-- <input type="text" id="pat_current_province" name="pat_current_province" class="form-control" required> -->
                    <div class="error"></div>
                  </div>

                  <div class="col-md-4">
                    <label for="pat_current_city_mun">City / Municipality <span style="color: red;">*</span></label>
                    <select id="pat_current_city_mun" class="form-control form-select"
                      required>
                      <option value="" disabled selected>Select</option>
                    </select>
                    <input type="hidden" name="pat_current_city_mun" id="pat_current_city_mun_text">
                    <!-- <input type="text" id="pat_current_city_mun" name="pat_current_city_mun" class="form-control" required> -->
                    <div class="error"></div>
                  </div>

                  <div class="col-md-4">
                    <label for="pat_current_address">Barangay <span style="color: red;">*</span></label>
                    <select id="pat_current_address" class="form-control form-select"
                      required>
                      <option value="" disabled selected>Select</option>
                    </select>
                    <input type="hidden" name="pat_current_address" id="pat_current_address_text">
                    <!-- <input type="text" id="pat_current_address" name="pat_current_address" class="form-control" required> -->
                    <div class="error"></div>
                  </div>

                  <div class="col-md-4">
                    <label for="pat_current_zip_code">Zip Code</label>
                    <input type="text" id="pat_current_zip_code" name="pat_current_zip_code" class="form-control" readonly>
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


              <!-- TAB 3: Screening Information -->
              <div class="tab-pane fade" id="screen" role="tabpanel">
                <h5 class="mb-4">B. Screening Information</h5>
                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="scr_referred_by">Referred by <span style="color: red;">*</span></label>
                    <input type="text" name="scr_referred_by" id="scr_referred_by" class="form-control"
                      placeholder="Hospital / Barangay Name" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="scr_location">Location <span style="color: red;">*</span></label>
                    <input type="text" name="scr_location" id="scr_location" class="form-control" placeholder="Location"
                      required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="scr_referrer_type">Type of Referrer <span style="color: red;">*</span></label>
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
                    <label for="scr_screening_mode">Mode of Screening <span style="color: red;">*</span></label>
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
                    <label for="scr_screening_date">Date of Screening <span style="color: red;">*</span></label>
                    <input type="date" name="scr_screening_date" id="scr_screening_date" class="form-control"
                      max="<?php echo date('Y-m-d'); ?>" required />
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
                      <option value="MTB HIGH">MTB HIGH</option>
                      <option value="MTB MEDIUM">MTB MEDIUM</option>
                      <option value="MTB LOW">MTB LOW</option>
                      <option value="MTB NEGATIVE">MTB NEGATIVE</option>
                    </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-6">
                    <label for="lab_xpert_test_date" class="form-label">Xpert MTB/RIF Test Date <span
                        style="color: red;">*</span></label>
                    <input type="date" name="lab_xpert_test_date" id="lab_xpert_test_date" class="form-control"
                      max="<?php echo date('Y-m-d'); ?>" required>
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
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="lab_smear_test_date" class="form-label">Smear Microscopy / TB Lamp Test Date <span
                        style="color: #6b7280;">(Optional)</span></label>
                    <input type="date" name="lab_smear_test_date" id="lab_smear_test_date" class="form-control"
                      max="<?php echo date('Y-m-d'); ?>">
                  </div>
                </div>

                <!-- Chest X-ray -->
                <div class="row mb-3 align-items-end">
                  <div class="col-md-6">
                    <label for="lab_cxray_result" class="form-label">Chest X-ray Test Result <span
                        style="color: red;">*</span></label>
                    <select name="lab_cxray_result" id="lab_cxray_result" class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="PTB BOTH RIGHT UPPER LOBE">PTB BOTH RIGHT UPPER LOBE</option>
                      <option value="PTB BOTH LOWER LOBE">PTB BOTH LOWER LOBE</option>
                      <option value="SUGGESTIVE POSITIVE TUBERCULOSIS">SUGGESTIVE POSITIVE TUBERCULOSIS</option>
                    </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-6">
                    <label for="lab_cxray_test_date" class="form-label">Chest X-ray Test Date <span
                        style="color: red;">*</span></label>
                    <input type="date" name="lab_cxray_test_date" id="lab_cxray_test_date" class="form-control"
                      max="<?php echo date('Y-m-d'); ?>" required>
                    <div class="error"></div>
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
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="lab_tst_test_date" class="form-label">Tuberculin Skin Test Date <span
                        style="color: #6b7280;">(Optional)</span></label>
                    <input type="date" name="lab_tst_test_date" id="lab_tst_test_date" class="form-control"
                      max="<?php echo date('Y-m-d'); ?>">
                  </div>
                </div>

                <!-- Other -->
                <div class="row mb-3 align-items-end">
                  <div class="col-md-6">
                    <label for="lab_other_result" class="form-label">Other Test Result <span
                        style="color: #6b7280;">(Optional)</span></label>
                    <select name="lab_other_result" id="lab_other_result" class="form-control form-select">
                      <option value="" disabled selected>Select</option>
                      <option value="Positive">Positive</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="lab_other_test_date" class="form-label">Other Test Date <span
                        style="color: #6b7280;">(Optional)</span></label>
                    <input type="date" name="lab_other_test_date" id="lab_other_test_date" class="form-control"
                      max="<?php echo date('Y-m-d'); ?>">
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
                  <div class="col-md-4">
                    <label for="diag_diagnosis_date">Date of Diagnosis <span style="color: red;">*</span></label>
                    <input type="date" name="diag_diagnosis_date" id="diag_diagnosis_date" class="form-control"
                      max="<?php echo date('Y-m-d'); ?>" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="diag_notification_date">Date of Notification</label>
                    <input type="date" name="diag_notification_date" id="diag_notification_date" class="form-control"
                      readonly>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="diag_tb_case_no">TB Case Number</label>
                    <input type="text" name="diag_tb_case_no" id="diag_tb_case_no" class="form-control"
                      value="{{ $tbCaseNo }}" readonly>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="diag_attending_physician">Attending Physician <span style="color: red;">*</span></label>
                    <select name="diag_attending_physician" id="diag_attending_physician"
                      class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                    </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="diag_referred_to">Referred To <span style="color: #6b7280;">(Optional)</span></label>
                    <input type="text" name="diag_referred_to" id="diag_referred_to" class="form-control"
                      placeholder="Name of Treatment Facility">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="diag_address">Address <span style="color: #6b7280;">(Optional)</span></label>
                    <input type="text" name="diag_address" id="diag_address" class="form-control" placeholder="Address">
                    <div class="error"></div>
                  </div>
                </div>

                <div class="row mb-2">
                  <div class="col-md-4">
                    <label for="diag_facility_code">Facility Code <span
                        style="color: #6b7280;">(Optional)</span></label>
                    <input type="text" name="diag_facility_code" id="diag_facility_code" class="form-control"
                      placeholder="Facility code">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="diag_region">Region <span style="color: #6b7280;">(Optional)</span></label>
                    <input type="text" name="diag_region" id="diag_region" class="form-control" placeholder="Region">
                    <!-- <select id="diag_region" class="form-control form-select">
                      <option value="" disabled selected>Select</option>
                    </select>
                    <input type="hidden" name="diag_region" id="diag_region_text"> -->
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="diag_province">Province/HUC <span style="color: #6b7280;">(Optional)</span></label>
                    <input type="text" name="diag_province" id="diag_province" class="form-control" placeholder="Province/HUC">
                    <!-- <select id="diag_province" class="form-control form-select">
                      <option value="" disabled selected>Select</option>
                    </select>
                    <input type="hidden" name="diag_province" id="diag_province_text"> -->
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
                    <input type="text" name="clas_site_other" id="clas_site_other" class="form-control"
                      placeholder="Specify">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="clas_registration_group">Registration Group <span style="color: red;">*</span></label>
                    <select name="clas_registration_group" id="clas_registration_group" class="form-control form-select"
                      required>
                      <option value="" disabled selected>Select</option>
                      <option value="New">New</option>
                      <option value="Relapse">Relapse</option>
                      <option value="TALF">TALF</option>
                      <option value="TAF">TAF</option>
                      <option value="PTOU">PTOU</option>
                      <option value="Unknown History">Unknown History</option>
                    </select>
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

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="{{ url('assets/js/logout.js') }}"></script>

  <script src="{{ url('assets/js/sidebarToggle.js') }}"></script>

  <script src="{{ url('assets/js/active.js') }}"></script>

  <script src="{{ url('assets/js/rotate-icon.js') }}"></script>

  <script src="{{ url('assets/js/tabs.js') }}"></script>

  <script src="{{ url('assets/js/age.js') }}"></script>

  <script>
    const form = document.getElementById('form');
    const fac_name = document.getElementById('fac_name');
    const fac_ntp_code = document.getElementById('fac_ntp_code');
    const fac_province = document.getElementById('fac_province');
    const fac_region = document.getElementById('fac_region');
    const pat_full_name = document.getElementById('pat_full_name');
    const pat_date_of_birth = document.getElementById('pat_date_of_birth');
    // const pat_age = document.getElementById('pat_age');
    // const pat_sex = document.getElementById('pat_sex');
    // const pat_civil_status = document.getElementById('pat_civil_status');
    // const pat_permanent_address = document.getElementById('pat_permanent_address');
    // const pat_permanent_city_mun = document.getElementById('pat_permanent_city_mun');
    // const pat_permanent_province = document.getElementById('pat_permanent_province');
    // const pat_permanent_region = document.getElementById('pat_permanent_region');
    // const pat_permanent_zip_code = document.getElementById('pat_permanent_zip_code');
    // const pat_current_address = document.getElementById('pat_current_address');
    // const pat_current_city_mun = document.getElementById('pat_current_city_mun');
    // const pat_current_province = document.getElementById('pat_current_province');
    // const pat_current_region = document.getElementById('pat_current_region');
    // const pat_current_zip_code = document.getElementById('pat_current_zip_code');
    const pat_contact_number = document.getElementById('pat_contact_number');
    const pat_other_contact = document.getElementById('pat_other_contact');
    const pat_nationality = document.getElementById('pat_nationality');
    const scr_referred_by = document.getElementById('scr_referred_by');
    const scr_location = document.getElementById('scr_location');
    // const scr_referrer_type = document.getElementById('scr_referrer_type');
    // const scr_screening_mode = document.getElementById('scr_screening_mode');
    // const scr_screening_date = document.getElementById('scr_screening_date');
    const diag_diagnosis_date = document.getElementById('diag_diagnosis_date');
    // const diag_notification_date = document.getElementById('diag_notification_date');
    const diag_attending_physician = document.getElementById('diag_attending_physician');
    const clas_bacteriological_status = document.getElementById('clas_bacteriological_status');
    const clas_drug_resistance_status = document.getElementById('clas_drug_resistance_status');
    const clas_anatomical_site = document.getElementById('clas_anatomical_site');
    const clas_registration_group = document.getElementById('clas_registration_group');
    // const lab_xpert_test_date = document.getElementById('lab_xpert_test_date');
    // const lab_xpert_result = document.getElementById('lab_xpert_result');
    // const lab_cxray_test_date = document.getElementById('lab_cxray_test_date');
    // const lab_cxray_result = document.getElementById('lab_cxray_result');

    // Get ALL inputs and selects in the form
    const allInputs = form.querySelectorAll("input, select");

    const requiredFields = [
      fac_name,
      pat_full_name,
      pat_date_of_birth,
      // pat_age,
      // pat_sex,
      // pat_civil_status,
      // pat_permanent_address,
      // pat_permanent_city_mun,
      // pat_permanent_province,
      // pat_permanent_region,
      // pat_permanent_zip_code,
      // pat_current_address,
      // pat_current_city_mun,
      // pat_current_province,
      // pat_current_region,
      // pat_current_zip_code,
      pat_contact_number,
      // pat_nationality,
      scr_referred_by,
      scr_location,
      // scr_referrer_type,
      // scr_screening_mode,
      // scr_screening_date,
      diag_diagnosis_date,
      // diag_notification_date,
      diag_attending_physician,
      clas_bacteriological_status,
      clas_drug_resistance_status,
      clas_anatomical_site,
      clas_registration_group,
      // lab_xpert_test_date,
      // lab_xpert_result,
      // lab_cxray_test_date,
      // lab_cxray_result,
    ];

    // ✅ Load Diagnosing Facilities dynamically
      document.addEventListener("DOMContentLoaded", function() {
        fetch("/api/facilities")
          .then(response => response.json())
          .then(data => {
            data.forEach(facility => {
              const option = document.createElement("option");
              option.value = facility.id;
              option.textContent = facility.fac_name;
              option.dataset.code = facility.fac_ntp_code;
              option.dataset.province = facility.fac_province;
              option.dataset.region = facility.fac_region;
              fac_name.appendChild(option);
            });
          })
          .catch(error => console.error("Error loading facilities:", error));

        fac_name.addEventListener("change", function() {
          const selected = this.options[this.selectedIndex];
          fac_ntp_code.value = selected.dataset.code || "";
          fac_province.value = selected.dataset.province || "";
          fac_region.value = selected.dataset.region || "";
        });
      });

    form.addEventListener("submit", function (e) {
      e.preventDefault(); // stop default submit first

      if (validateInputs()) {

        function getSelectText(select) {
          if (!select || !select.options.length) return '';
          const selected = select.options[select.selectedIndex];
          if (!selected || selected.value === '' || selected.text.toLowerCase().includes('select')) {
            return ''; // return blank if no valid selection
          }
          return selected.text;
        }



        // populate preview
        const preview = document.getElementById("previewContent");
        const selectedFacility = fac_name.options[fac_name.selectedIndex].text;

        preview.innerHTML = `
        <div class="container-fluid px-2">

        <!-- Diagnosing Facility -->
          <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body">
              <h6 class="fw-bold mb-2">Facility Information</h6>
              <table class="table table-borderless preview-table align-middle mb-0">
                <tbody>
                  <tr><th>Diagnosing Facility</th><td>${selectedFacility}</td></tr>
                  <tr><th>NTP Facility Code</th><td>${fac_ntp_code.value}</td></tr>
                  <tr><th>Province</th><td>${fac_province.value}</td></tr>
                  <tr><th>Region</th><td>${fac_region.value}</td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Patient Information -->
          <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body">
              <h6 class="fw-bold mb-2">Patient Information</h6>
              <table class="table table-borderless preview-table align-middle mb-0">
                <tbody>
                  <tr><th>Full Name</th><td>${pat_full_name.value}</td></tr>
                  <tr><th>Date of Birth</th><td>${pat_date_of_birth.value}</td></tr>
                  <tr><th>Age</th><td>${pat_age.value}</td></tr>
                  <tr><th>Sex</th><td>${pat_sex.value}</td></tr>
                  <tr><th>Civil Status</th><td>${pat_civil_status.value}</td></tr>
                  <tr><th>Contact Number</th><td>${pat_contact_number.value}</td></tr>
                  <tr><th>Other Contact</th><td>${pat_other_contact.value}</td></tr>
                  <tr><th>PhilHealth No.</th><td>${pat_philhealth_no.value}</td></tr>
                  <tr><th>Nationality</th><td>${pat_nationality.value}</td></tr>
                  <tr>
                    <th>Permanent Address</th>
                    <td>${getSelectText(pat_permanent_address)}, 
                        ${getSelectText(pat_permanent_city_mun)}, 
                        ${getSelectText(pat_permanent_province)}, 
                        ${getSelectText(pat_permanent_region)} - 
                        ${pat_permanent_zip_code.value}
                    </td>
                  </tr>
                  <tr>
                    <th>Current Address</th>
                    <td>${getSelectText(pat_current_address)}, 
                        ${getSelectText(pat_current_city_mun)}, 
                        ${getSelectText(pat_current_province)}, 
                        ${getSelectText(pat_current_region)} - 
                        ${pat_current_zip_code.value}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Screening Information -->
          <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body">
              <h6 class="fw-bold mb-2">Screening Information</h6>
              <table class="table table-borderless preview-table align-middle mb-0">
                <tbody>
                  <tr><th>Referred By</th><td>${scr_referred_by.value}</td></tr>
                  <tr><th>Location</th><td>${scr_location.value}</td></tr>
                  <tr><th>Type of Referrer</th><td>${scr_referrer_type.value}</td></tr>
                  <tr><th>Mode of Screening</th><td>${scr_screening_mode.value}</td></tr>
                  <tr><th>Date of Screening</th><td>${scr_screening_date.value}</td></tr>
                </tbody>
              </table>
            </div>
          </div>

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
                  <tr><th>Referred to</th><td>${diag_referred_to.value}</td></tr>
                  <tr><th>Address</th><td>${diag_address.value}</td></tr>
                  <tr><th>Facility Code</th><td>${diag_facility_code.value}</td></tr>
                  <tr><th>Province</th><td>${diag_province.value}</td></tr>
                  <tr><th>Region</th><td>${diag_region.value}</td></tr>
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

    // ✅ Final confirm button - ENABLE disabled fields before submit
    document.getElementById("confirmSubmit").addEventListener("click", function () {
      const sameCheckbox = document.getElementById("sameAsPermanent");

      const permRegion = document.getElementById("pat_permanent_region");
      const permRegionText = permRegion.options[permRegion.selectedIndex].text;
      document.getElementById("pat_permanent_region_text").value = permRegionText;

      const permProvince = document.getElementById("pat_permanent_province");
      const permProvinceText = permProvince.options[permProvince.selectedIndex].text;
      document.getElementById("pat_permanent_province_text").value = permProvinceText;

      const permCity = document.getElementById("pat_permanent_city_mun");
      const permCityText = permCity.options[permCity.selectedIndex].text;
      document.getElementById("pat_permanent_city_mun_text").value = permCityText;

      const permBrgy = document.getElementById("pat_permanent_address");
      const permBrgyText = permBrgy.options[permBrgy.selectedIndex].text;
      document.getElementById("pat_permanent_address_text").value = permBrgyText;

      const currRegion = document.getElementById("pat_current_region");
      const currRegionText = currRegion.options[currRegion.selectedIndex].text;
      document.getElementById("pat_current_region_text").value = currRegionText;

      const currProvince = document.getElementById("pat_current_province");
      const currProvinceText = currProvince.options[currProvince.selectedIndex].text;
      document.getElementById("pat_current_province_text").value = currProvinceText;

      const currCity = document.getElementById("pat_current_city_mun");
      const currCityText = currCity.options[currCity.selectedIndex].text;
      document.getElementById("pat_current_city_mun_text").value = currCityText;

      const currBrgy = document.getElementById("pat_current_address");
      const currBrgyText = currBrgy.options[currBrgy.selectedIndex].text;
      document.getElementById("pat_current_address_text").value = currBrgyText;

      // const diagRegion = document.getElementById("diag_region");
      // const diagRegionText = diagRegion.options[diagRegion.selectedIndex].text;
      // document.getElementById("diag_region_text").value = diagRegionText;

      // const diagProvince = document.getElementById("diag_province");
      // const diagProvinceText = diagProvince.options[diagProvince.selectedIndex].text;
      // document.getElementById("diag_province_text").value = diagProvinceText;
      

      // If checkbox is checked, temporarily enable current address fields for submission
      if (sameCheckbox && sameCheckbox.checked) {
        [pat_current_region, pat_current_province, pat_current_city_mun, pat_current_address].forEach(el => {
          el.disabled = false;
        });
      }

      // Now submit the form
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

    // ✅ Contact number validation
    function validateContactNumber(element, required = true) {
      const value = element.value.trim();
      const regex = /^09\d{9}$/; // must start with 09 + 9 digits = 11 digits

      if (!value) {
        if (required) {
          setError(element, "This is required.");
          return false;
        } else {
          element.classList.remove("error", "success");
          return true; // optional, allow empty
        }
      }

      if (!regex.test(value)) {
        setError(element, "Enter a valid 11-digit number");
        return false;
      }

      setSuccess(element);
      return true;
    }

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
          setError(element, "This is required.");
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
        if (field === pat_contact_number) {
          if (!validateContactNumber(field, true)) isValid = false;
        } else if (field === pat_other_contact) {
          if (!validateContactNumber(field, false)) isValid = false;
        } else {
          if (!validateField(field)) isValid = false;
        }
      });

      // also validate optional other contact if filled
      if (!validateContactNumber(pat_other_contact, false)) isValid = false;

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

        if (input === pat_contact_number) {
          validateContactNumber(input, true);
        } else if (input === pat_other_contact) {
          validateContactNumber(input, false);
        } else if (requiredFields.includes(input) && (!value || value === "")) {
          setError(input, "This is required.");
        } else if (input.type === "text" && value) {
          const regex = /^[a-zA-Z0-9 ,.\-\/]*$/;
          if (!regex.test(value)) {
            setError(input, "Special characters prohibited.");
          } else {
            setSuccess(input);
          }
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

    // Restrict to digits only
    [pat_permanent_zip_code, pat_current_zip_code, pat_contact_number, pat_other_contact].forEach(input => {
      input.addEventListener("input", () => {
        input.value = input.value.replace(/\D/g, "");
      });
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

  <!-- ===== SCRIPT SECTION ===== -->
  <script>
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

      // const diagRegion = document.getElementById("diag_region");
      // const diagProvince = document.getElementById("diag_province");

      const sameCheckbox = document.getElementById("sameAsPermanent");

      // Load regions for both dropdowns
      fetch("/api/regions")
        .then(res => res.json())
        .then(data => {
          data.forEach(region => {
            permRegion.innerHTML += `<option value="${region.regCode}">${region.regDesc}</option>`;
            currRegion.innerHTML += `<option value="${region.regCode}">${region.regDesc}</option>`;
            // diagRegion.innerHTML += `<option value="${region.regCode}">${region.regDesc}</option>`;
          });
        });

      // --- Helper function to copy Permanent → Current ---
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

      // --- Helper function to toggle readonly instead of disabled ---
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

      // --- Permanent dropdown logic ---
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

      // --- Current dropdown logic ---
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

      // --- Diagnosing Facility Dropdown Logic 👇
    // diagRegion.addEventListener("change", () => {
    //   fetch(`/api/provinces/${diagRegion.value}`)
    //     .then(res => res.json())
    //     .then(data => {
    //       diagProvince.innerHTML = '<option value="">Select</option>';
    //       data.forEach(prov => {
    //         diagProvince.innerHTML += `<option value="${prov.provCode}">${prov.provDesc}</option>`;
    //       });
    //     });
    // });

      // --- Checkbox logic (use readonly instead of disabled) ---
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
  </script>

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



</body>

</html>