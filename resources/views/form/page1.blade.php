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
  </style>
</head>

<body>

  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <div class="sidebar-logo">
        <img src="{{url('assets/img/TBDOTS.png')}}" alt="TB DOTS Logo" />
      </div>
      <div class="sidebar-brand">
        <h2>TB DOTS</h2>
        <p>RHU, Tagoloan</p>
      </div>
    </div>

    <ul class="sidebar-menu" id="sidebarAccordion">
      <li class="menu-item" data-tooltip="Dashboard">
        <a href="{{url('admin/dashboard')}}" class="active">
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
          <li><a class="nav-link" href="{{ url('form/page1') }}">Add Patient</a></li>
          <li><a class="nav-link" href="{{ url('patient') }}">Patient List</a></li>
        </ul>
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
        <a href="{{url('patient-accounts')}}">
          <img src="{{ url('assets/img/pa1.png') }}" class="menu-icon" alt="">
          <span class="menu-text">Patient Accounts</span>
        </a>
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
                    <label for="fac_name">Name of Diagnosing Facility</label>
                    <input type="text" name="fac_name" id="pat_diagnosing_facility" class="form-control"
                      placeholder="Diagnosing facility" required>
                    <div class="error"></div>
                  </div>

                  <div class="col-md-3">
                    <label for="fac_ntp_code">NTP Facility Code</label>
                    <input type="text" name="fac_ntp_code" id="pat_ntp_facility_code" class="form-control"
                      placeholder="NTP facility code" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="fac_province">Province/ HUC</label>
                    <input type="text" name="fac_province" id="pat_province" class="form-control"
                      placeholder="Province/ huc" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="fac_region">Region</label>
                    <!-- <select name="fac_region" id="pat_region" class="form-control form-select" required>
                      <option value="">Select</option>
                      <option value="Region I - Ilocos Region">Region I - Ilocos Region</option>
                      <option value="Region II - Cagayan Valley">Region II - Cagayan Valley</option>
                      <option value="Region III - Central Luzon">Region III - Central Luzon</option>
                      <option value="Region IV - CALABARZON MIMAROPA Region">Region IV - CALABARZON</option>
                      <option value="Region V - Bicol Region">Region V - Bicol Region</option>
                      <option value="Region VI - Western Visayas">Region VI - Western Visayas</option>
                      <option value="Region VII - Central Visayas">Region VII - Central Visayas</option>
                      <option value="Region VIII - Eastern Visayas">Region VIII - Eastern Visayas</option>
                      <option value="Region IX - Zamboanga Peninsula">Region IX - Zamboanga Peninsula</option>
                      <option value="Region X - Northern Mindanao">Region X - Northern Mindanao</option>
                      <option value="Region XI - Davao Region">Region XI - Davao Region</option>
                      <option value="Region XII - SOCCSKSARGEN">Region XII - SOCCSKSARGEN</option>
                      <option value="Region XIII - Caraga">Region XIII - Caraga</option>
                    </select> -->
                    <input type="text" name="fac_region" id="pat_region" class="form-control" placeholder="Region"
                      required>
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
                    <label for="pat_full_name">Patient's Full Name</label>
                    <input type="text" name="pat_full_name" id="pat_full_name" class="form-control"
                      placeholder="Surname, given names, middle name" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="pat_date_of_birth">Date of Birth</label>
                    <input type="date" name="pat_date_of_birth" id="pat_date_of_birth" class="form-control"
                      max="<?php echo date('Y-m-d'); ?>" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="pat_age">Age</label>
                    <input type="text" name="pat_age" id="pat_age" class="form-control" placeholder="Years months"
                      readonly>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="pat_sex">Sex</label>
                    <select name="pat_sex" id="pat_sex" class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="pat_civil_status">Civil Status</label>
                    <select name="pat_civil_status" id="pat_civil_status" class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="Single">Single</option>
                      <option value="Married">Married</option>
                      <option value="Divorced">Divorced</option>
                    </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="pat_contact_number">Contact Number</label>
                    <input type="text" name="pat_contact_number" id="pat_contact_number" class="form-control"
                      placeholder="09XXXXXXXXX" maxlength="11" required>
                    <div class="error"></div>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="pat_other_contact">Other Contact Information</label>
                    <input type="text" name="pat_other_contact" id="pat_other_contact" class="form-control"
                      placeholder="09XXXXXXXXX" maxlength="11">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="pat_philhealth_no">PhilHealth No.</label>
                    <input type="text" name="pat_philhealth_no" id="pat_philhealth_no" class="form-control"
                      placeholder="PhilHealth number">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="pat_nationality">Nationality</label>
                    <input type="text" name="pat_nationality" id="pat_nationality" class="form-control"
                      placeholder="Nationality" required>
                    <div class="error"></div>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="pat_permanent_address">Permanent Address</label>
                    <input type="text" name="pat_permanent_address" id="pat_permanent_address" class="form-control"
                      placeholder="House no., street, brgy" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="pat_permanent_city_mun">City/ Municipality</label>
                    <input type="text" name="pat_permanent_city_mun" id="pat_permanent_city_mun" class="form-control"
                      placeholder="City/ municipality" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="pat_permanent_province">Province</label>
                    <input type="text" name="pat_permanent_province" id="pat_permanent_province" class="form-control"
                      placeholder="Province" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="pat_permanent_region">Region</label>
                    <input type="text" name="pat_permanent_region" id="pat_permanent_region" class="form-control"
                      placeholder="Region" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="pat_permanent_zip_code">Zip Code</label>
                    <input type="text" name="pat_permanent_zip_code" id="pat_permanent_zip_code" class="form-control"
                      placeholder="Zip code" maxlength="5" required>
                    <div class="error"></div>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="pat_current_address">Current Address</label>
                    <input type="text" name="pat_current_address" id="pat_current_address" class="form-control"
                      placeholder="House no., street, brgy" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="pat_current_city_mun">City/ Municipality</label>
                    <input type="text" name="pat_current_city_mun" id="pat_current_city_mun" class="form-control"
                      placeholder="City/ municipality" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="pat_current_province">Province</label>
                    <input type="text" name="pat_current_province" id="pat_current_province" class="form-control"
                      placeholder="Province" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="pat_current_region">Region</label>
                    <input type="text" name="pat_current_region" id="pat_current_region" class="form-control"
                      placeholder="Region" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="pat_current_zip_code">Zip Code</label>
                    <input type="text" name="pat_current_zip_code" id="pat_current_zip_code" class="form-control"
                      placeholder="Zip code" maxlength="5" required>
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
                    <label for="scr_referred_by">Referred by</label>
                    <input type="text" name="scr_referred_by" id="diag_referred_by" class="form-control"
                      placeholder="Name" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="scr_location">Location</label>
                    <input type="text" name="scr_location" id="diag_location" class="form-control"
                      placeholder="Location" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="scr_referrer_type">Type of Referrer</label>
                    <select name="scr_referrer_type" id="diag_type_of_referrer" class="form-control form-select"
                      required>
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
                    <label for="scr_screening_mode">Mode of Screening</label>
                    <select name="scr_screening_mode" id="diag_mode_of_screening" class="form-control form-select"
                      required>
                      <option value="" disabled selected>Select</option>
                      <option value="PCF">PCF</option>
                      <option value="ACF">ACF</option>
                      <option value="ICF">ICF</option>
                      <option value="ECF">ECF</option>
                    </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="scr_screening_date">Date of Screening</label>
                    <input type="date" name="scr_screening_date" id="diag_date_of_screening" class="form-control"
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
                <h5 class="mb-4">C. Laboratory Tests</h5>
                <div class="row mb-2">
                  <div class="col-md-4">
                    <label for="lab_xpert_test_date">Xpert MTB/RIF</label>
                    <input type="date" name="lab_xpert_test_date" id="diag_xpert_test_date" class="form-control"
                      max="<?php echo date('Y-m-d'); ?>" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="lab_smear_test_date">Smear Microscopy/TB Lamp</label>
                    <input type="date" name="lab_smear_test_date" id="diag_smear_test_date" class="form-control"
                      max="<?php echo date('Y-m-d'); ?>">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="lab_cxray_test_date">Chest X-ray</label>
                    <input type="date" name="lab_cxray_test_date" id="diag_chest_xray_test_date" class="form-control"
                      max="<?php echo date('Y-m-d'); ?>" required>
                    <div class="error"></div>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="lab_xpert_result"></label>
                    <input type="text" name="lab_xpert_result" id="diag_xpert_result" class="form-control"
                      placeholder="Result" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="lab_smear_result"></label>
                    <input type="text" name="lab_smear_result" id="diag_smear_result" class="form-control"
                      placeholder="Result">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="lab_cxray_result"></label>
                    <input type="text" name="lab_cxray_result" id="diag_chest_xray_result" class="form-control"
                      placeholder="Result" required>
                    <div class="error"></div>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="lab_tst_test_date">Tuberculin Skin Test</label>
                    <input type="date" name="lab_tst_test_date" id="diag_tuberculin_skin_test_date" class="form-control"
                      max="<?php echo date('Y-m-d'); ?>">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="lab_other_test_date">Other</label>
                    <input type="date" name="lab_other_test_date" id="diag_other_test_date" class="form-control"
                      max="<?php echo date('Y-m-d'); ?>">
                    <div class="error"></div>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="lab_tst_result"></label>
                    <input type="text" name="lab_tst_result" id="diag_tuberculin_skin_result" class="form-control"
                      placeholder="Result">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="lab_other_result"></label>
                    <input type="text" name="lab_other_result" id="diag_other_test_result" class="form-control"
                      placeholder="Result">
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

              <!-- TAB 5: Diagnosis -->
              <div class="tab-pane fade" id="diag" role="tabpanel">
                <h5 class="mb-4">D. Diagnosis</h5>
                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="diag_diagnosis_date">Date of Diagnosis</label>
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
                    <input type="text" name="diag_tb_case_no" id="diag_tb_case_number" class="form-control"
                      value="{{ $tbCaseNo }}" readonly>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="diag_attending_physician">Attending Physician</label>
                    <select name="diag_attending_physician" id="diag_attending_physician"
                      class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="Dr. Jennifer Advincula">Dr. Jennifer Advincula</option>
                    </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="diag_referred_to">Referred To</label>
                    <input type="text" name="diag_referred_to" id="diag_referred_to" class="form-control"
                      placeholder="Name">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="diag_address">Address</label>
                    <input type="text" name="diag_address" id="diag_referred_address" class="form-control"
                      placeholder="Address">
                    <div class="error"></div>
                  </div>
                </div>

                <div class="row mb-2">
                  <div class="col-md-4">
                    <label for="diag_facility_code">Facility Code</label>
                    <input type="text" name="diag_facility_code" id="diag_referred_facility_code" class="form-control"
                      placeholder="Facility code">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="diag_province">Province/HUC</label>
                    <input type="text" name="diag_province" id="diag_referred_province" class="form-control"
                      placeholder="Province/huc">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="diag_region">Region</label>
                    <input type="text" name="diag_region" id="diag_referred_region" class="form-control" placeholder="Region">
                    <!-- <select name="diag_region" id="diag_referred_region" class="form-control form-select">
                      <option value="" disabled selected>Select</option>
                      <option value="Region I - Ilocos Region">Region I - Ilocos Region</option>
                      <option value="Region II - Cagayan Valley">Region II - Cagayan Valley</option>
                      <option value="Region III - Central Luzon">Region III - Central Luzon</option>
                      <option value="Region IV - CALABARZON">Region IV - CALABARZON</option>
                      <option value="Region V - Bicol Region">Region V - Bicol Region</option>
                      <option value="Region VI - Western Visayas">Region VI - Western Visayas</option>
                      <option value="Region VII - Central Visayas">Region VII - Central Visayas</option>
                      <option value="Region VIII - Eastern Visayas">Region VIII - Eastern Visayas</option>
                      <option value="Region IX - Zamboanga Peninsula">Region IX - Zamboanga Peninsula</option>
                      <option value="Region X - Northern Mindanao">Region X - Northern Mindanao</option>
                      <option value="Region XI - Davao Region">Region XI - Davao Region</option>
                      <option value="Region XII - SOCCSKSARGEN">Region XII - SOCCSKSARGEN</option>
                      <option value="Region XIII - Caraga">Region XIII - Caraga</option>
                    </select> -->
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
                    <label for="clas_bacteriological_status">Bacteriological Status</label>
                    <select name="clas_bacteriological_status" id="clas_bacteriological_status"
                      class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="Bacteriologically-confirmed TB">Bacteriologically-confirmed TB</option>
                      <option value="Clinically-diagnosed TB">Clinically-diagnosed TB</option>
                    </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="clas_drug_resistance_status">Drug Resistance Bacteriological Status</label>
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
                    <label for="clas_other_drug_resistant">Other Drug-resistant TB</label>
                    <input type="text" name="clas_other_drug_resistant" id="diag_other_drug_resistant_tb"
                      class="form-control" placeholder="Specify">
                    <div class="error"></div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <label for="clas_anatomical_site">Anatomical Site</label>
                    <select name="clas_anatomical_site" id="clas_anatomical_site" class="form-control form-select"
                      required>
                      <option value="" disabled selected>Select</option>
                      <option value="Pulmonary">Pulmonary</option>
                      <option value="Extra-pulmonary">Extra-pulmonary</option>
                    </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="clas_site_other">Extra-pulmonary Site (Specify)</label>
                    <input type="text" name="clas_site_other" id="clas_site_other" class="form-control"
                      placeholder="Specify">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="clas_registration_group">Registration Group</label>
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
                  <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane me-1"></i>Submit</button>
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
                    <i class="fas fa-paper-plane me-1"></i> Confirm & Submit </button>
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
    const pat_diagnosing_facility = document.getElementById('pat_diagnosing_facility');
    const pat_ntp_facility_code = document.getElementById('pat_ntp_facility_code');
    const pat_province = document.getElementById('pat_province');
    const pat_region = document.getElementById('pat_region');
    const pat_full_name = document.getElementById('pat_full_name');
    const pat_date_of_birth = document.getElementById('pat_date_of_birth');
    const pat_age = document.getElementById('pat_age');
    const pat_sex = document.getElementById('pat_sex');
    const pat_civil_status = document.getElementById('pat_civil_status');
    const pat_permanent_address = document.getElementById('pat_permanent_address');
    const pat_permanent_city_mun = document.getElementById('pat_permanent_city_mun');
    const pat_permanent_province = document.getElementById('pat_permanent_province');
    const pat_permanent_region = document.getElementById('pat_permanent_region');
    const pat_permanent_zip_code = document.getElementById('pat_permanent_zip_code');
    const pat_current_address = document.getElementById('pat_current_address');
    const pat_current_city_mun = document.getElementById('pat_current_city_mun');
    const pat_current_province = document.getElementById('pat_current_province');
    const pat_current_region = document.getElementById('pat_current_region');
    const pat_current_zip_code = document.getElementById('pat_current_zip_code');
    const pat_contact_number = document.getElementById('pat_contact_number');
    const pat_other_contact = document.getElementById('pat_other_contact');
    const pat_nationality = document.getElementById('pat_nationality');
    const diag_referred_by = document.getElementById('diag_referred_by');
    const diag_location = document.getElementById('diag_location');
    const diag_type_of_referrer = document.getElementById('diag_type_of_referrer');
    const diag_mode_of_screening = document.getElementById('diag_mode_of_screening');
    const diag_date_of_screening = document.getElementById('diag_date_of_screening');
    const diag_diagnosis_date = document.getElementById('diag_diagnosis_date');
    const diag_notification_date = document.getElementById('diag_notification_date');
    const diag_attending_physician = document.getElementById('diag_attending_physician');
    const diag_bacteriological_status = document.getElementById('diag_bacteriological_status');
    const clas_drug_resistance_status = document.getElementById('clas_drug_resistance_status');
    const diag_anatomical_site = document.getElementById('diag_anatomical_site');
    const diag_registration_group = document.getElementById('diag_registration_group');
    const diag_xpert_test_date = document.getElementById('diag_xpert_test_date');
    const diag_xpert_result = document.getElementById('diag_xpert_result');
    const diag_chest_xray_test_date = document.getElementById('diag_chest_xray_test_date');
    const diag_chest_xray_result = document.getElementById('diag_chest_xray_result');

    // Get ALL inputs and selects in the form
    const allInputs = form.querySelectorAll("input, select");

    const requiredFields = [
      pat_diagnosing_facility,
      pat_ntp_facility_code,
      pat_province,
      pat_region,
      pat_full_name,
      pat_date_of_birth,
      // pat_age,
      // pat_sex,
      // pat_civil_status,
      pat_permanent_address,
      pat_permanent_city_mun,
      pat_permanent_province,
      pat_permanent_region,
      pat_permanent_zip_code,
      pat_current_address,
      pat_current_city_mun,
      pat_current_province,
      pat_current_region,
      pat_current_zip_code,
      pat_contact_number, // required
      pat_nationality,
      diag_referred_by,
      diag_location,
      // diag_type_of_referrer,
      // diag_mode_of_screening,
      // diag_date_of_screening,
      diag_diagnosis_date,
      // diag_notification_date,
      // diag_attending_physician,
      clas_bacteriological_status,
      clas_drug_resistance_status,
      clas_anatomical_site,
      clas_registration_group,
      diag_xpert_test_date,
      diag_xpert_result,
      diag_chest_xray_test_date,
      diag_chest_xray_result,
    ];

    form.addEventListener("submit", function (e) {
      e.preventDefault(); // stop default submit first

      if (validateInputs()) {
        // populate preview
        const preview = document.getElementById("previewContent");
        preview.innerHTML = `
        <div class="container-fluid px-2">

        <!-- Diagnosing Facility -->
          <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body">
              <h6 class="fw-bold mb-2">Facility Information</h6>
              <table class="table table-borderless preview-table align-middle mb-0">
                <tbody>
                  <tr><th>Diagnosing Facility</th><td>${pat_diagnosing_facility.value}</td></tr>
                  <tr><th>NTP Facility Code</th><td>${pat_ntp_facility_code.value}</td></tr>
                  <tr><th>Province</th><td>${pat_province.value}</td></tr>
                  <tr><th>Region</th><td>${pat_region.value}</td></tr>
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
                    <td>${pat_permanent_address.value}, ${pat_permanent_city_mun.value}, ${pat_permanent_province.value}, ${pat_permanent_region.value} - ${pat_permanent_zip_code.value}</td>
                  </tr>
                  <tr>
                    <th>Current Address</th>
                    <td>${pat_current_address.value}, ${pat_current_city_mun.value}, ${pat_current_province.value}, ${pat_current_region.value} - ${pat_current_zip_code.value}</td>
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
                  <tr><th>Referred By</th><td>${diag_referred_by.value}</td></tr>
                  <tr><th>Location</th><td>${diag_location.value}</td></tr>
                  <tr><th>Type of Referrer</th><td>${diag_type_of_referrer.value}</td></tr>
                  <tr><th>Mode of Screening</th><td>${diag_mode_of_screening.value}</td></tr>
                  <tr><th>Date of Screening</th><td>${diag_date_of_screening.value}</td></tr>
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
                  <tr><th>Xpert Test Date</th><td>${diag_xpert_test_date.value}</td></tr>
                  <tr><th>Xpert Result</th><td>${diag_xpert_result.value}</td></tr>
                  <tr><th>Smear Microscopy Test Date</th><td>${diag_smear_test_date.value}</td></tr>
                  <tr><th>Smear Result</th><td>${diag_smear_result.value}</td></tr>
                  <tr><th>Chest X-ray Test Date</th><td>${diag_chest_xray_test_date.value}</td></tr>
                  <tr><th>Chest X-ray Result</th><td>${diag_chest_xray_result.value}</td></tr>
                  <tr><th>Tuberculin Skin Test Date</th><td>${diag_tuberculin_skin_test_date.value}</td></tr>
                  <tr><th>Tuberculin Skin Test Result</th><td>${diag_tuberculin_skin_result.value}</td></tr>
                  <tr><th>Other Test Date</th><td>${diag_other_test_date.value}</td></tr>
                  <tr><th>Other Test Result</th><td>${diag_other_test_result.value}</td></tr>
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
                  <tr><th>Attending Physician</th><td>${diag_attending_physician.value}</td></tr>
                  <tr><th>Referred to</th><td>${diag_referred_to.value}</td></tr>
                  <tr><th>Address</th><td>${diag_referred_address.value}</td></tr>
                  <tr><th>Facility Code</th><td>${diag_referred_facility_code.value}</td></tr>
                  <tr><th>Province</th><td>${diag_referred_province.value}</td></tr>
                  <tr><th>Region</th><td>${diag_referred_region.value}</td></tr>
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
                  <tr><th>Other Drug-resistant TB</th><td>${diag_other_drug_resistant_tb.value}</td></tr>
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

    // ✅ Final confirm button event
    document.getElementById("confirmSubmit").addEventListener("click", function () {
      form.submit(); // final submit
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
        const value = element.value.trim();

        // Required check
        if (!value) {
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
        const value = input.value.trim();
        const today = new Date();

        if (input === pat_contact_number) {
          validateContactNumber(input, true);
        } else if (input === pat_other_contact) {
          validateContactNumber(input, false);
        } else if (requiredFields.includes(input) && !value) {
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
        } else if (!requiredFields.includes(input) && value) {
          const regex = /^[a-zA-Z0-9 ,.\-\/]*$/;
          if (!regex.test(value)) {
            setError(input, "Special characters prohibited.");
          } else {
            setSuccess(input);
          }
        } else {
          input.classList.remove("success", "error");
          const errorDisplay = input.parentElement.querySelector('.error');
          if (errorDisplay) errorDisplay.innerText = '';
        }
      };

      input.addEventListener("input", validateField);
      input.addEventListener("change", validateField);
    });

    // ✅ Restrict to digits only in real-time
    [pat_permanent_zip_code, pat_current_zip_code, pat_contact_number, pat_other_contact].forEach(input => {
      input.addEventListener("input", () => {
        input.value = input.value.replace(/\D/g, ""); // remove non-digits
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
      const screeningInput = document.getElementById('diag_date_of_screening');
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