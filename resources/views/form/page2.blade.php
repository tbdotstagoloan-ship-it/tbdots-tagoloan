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
      color: #dc3545;
      font-size: 0.85rem;
    }

    /* Red border for invalid */
    .is-invalid {
      border-color: #dc3545 !important;
      background-image: none !important;
      /* removes Bootstrap's error icon */
    }

    /* Green border for valid */
    .is-valid {
      border-color: #09c372 !important;
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
      National TB Control Program
    </h4>


    <div class="card inventory-card shadow-sm border-0">
      <div class="card-body p-0">
        <div class="table-responsive">

          <form id="form" action="{{ url('validatePage2') }}" method="post" class="p-2" novalidate>
            @csrf

            <!-- Tabs -->
            <ul class="nav nav-tabs" id="formTabs" role="tablist">
              <li class="nav-item">
                <button class="nav-link active" id="treatment-tab" data-bs-toggle="tab" data-bs-target="#treatment"
                  type="button" role="tab">II. Treatment</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="baseline-tab" data-bs-toggle="tab" data-bs-target="#baseline" type="button"
                  role="tab">A. Baseline Information</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="regimen-tab" data-bs-toggle="tab" data-bs-target="#regimen" type="button"
                  role="tab">B. Treatment Regimen</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="outcome-tab" data-bs-toggle="tab" data-bs-target="#outcome" type="button"
                  role="tab">C. Treatment Outcome</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="medicine-tab" data-bs-toggle="tab" data-bs-target="#medicine" type="button"
                  role="tab">Prescribed Drugs</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="admin-tab" data-bs-toggle="tab" data-bs-target="#admin" type="button"
                  role="tab">D. Administration of Drugs</button>
              </li>
            </ul>

            <!-- <input type="hidden" name="diagnosis_id" value="{{ $diagnosis->id ?? '' }}"> -->

            <!-- Tab Content -->
            <div class="tab-content p-3" id="formTabsContent">

              <!-- TAB 1: Treatment -->
              <div class="tab-pane fade show active" id="treatment" role="tabpanel">
                <div class="row mb-2">
                  <div class="col-md-3">
                    <label for="trea_name">Name of Treatment Facility</label>
                    <input type="text" name="trea_name" id="trt_treatment_facility" class="form-control"
                      value="{{ session('trea_name') }}" readonly>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="trea_ntp_code">NTP Facility Code</label>
                    <input type="text" name="trea_ntp_code" id="trt_ntp_facility_code" class="form-control"
                      value="{{ session('trea_ntp_code') }}" readonly>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="trea_province">Province / HUC</label>
                    <input type="text" name="trea_province" id="trt_province_huc" class="form-control"
                      value="{{ session('trea_province') }}" readonly>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="trea_region">Region</label>
                    <input type="text" name="trea_region" id="trt_region" class="form-control"
                      value="{{ session('trea_region') }}" readonly>
                    <div class="error"></div>
                  </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                  <button type="button" class="btn backBtn next-tab d-flex align-items-center gap-1">
                    Next <i class="fas fa-arrow-right"></i>
                  </button>
                </div>
              </div>

              <!-- TAB 2: Baseline -->
              <div class="tab-pane fade" id="baseline" role="tabpanel">
                <h5 class="mb-4">A. Baseline Information</h5>
                <div class="row align-items-center mb-2">
                  <div class="col-md-6">
                    <label for="">History of TB Treatment</label>
                  </div>
                </div>

                <div class="row mb-2">
                  <div class="col-md-3">
                    <label for="hist_date_tx_started">Date Tx Started</label>
                    <input type="date" name="hist_date_tx_started" id="trt_date_tx_started" class="form-control"
                      max="<?php echo date('Y-m-d'); ?>">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="hist_treatment_unit">Name of Treatment Unit</label>
                    <input type="text" name="hist_treatment_unit" id="trt_treatment_unit" class="form-control"
                      placeholder="Name of treatment unit">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="hist_regimen">Treatment Regimen</label>
                    <input type="text" name="hist_regimen" id="trt_treatment_regimen" class="form-control"
                      placeholder="Drug & duration">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="hist_outcome">Outcome</label>
                    <input type="text" name="hist_outcome" id="trt_treatment_outcome" class="form-control"
                      placeholder="Outcome">
                    <div class="error"></div>
                  </div>
                </div>

                <hr>
                <div class="row mb-3">
                  <div class="col-md-3">
                    <label for="hiv_information">HIV Information</label>
                    <select name="hiv_information" class="form-control form-select">
                      <option value="" disabled selected>Select</option>
                      <option value="Know PLHIV Prior to Start of Tx">Know PLHIV Prior to Start of Tx</option>
                      <option value="Not Eligible for Testing">Not Eligible for Testing</option>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label for="hiv_test_date">HIV Test Date</label>
                    <input type="date" name="hiv_test_date" class="form-control" max="<?php echo date('Y-m-d'); ?>">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="hiv_confirmatory_test_date">Confirmatory Test Date</label>
                    <input type="date" name="hiv_confirmatory_test_date" class="form-control"
                      max="<?php echo date('Y-m-d'); ?>">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="hiv_result">Result</label>
                    <select name="hiv_result" class="form-control form-select">
                      <option value="" disabled selected>Select</option>
                      <option value="P">P</option>
                      <option value="N">N</option>
                      <option value="Undetermined">Undetermined</option>
                    </select>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-3">
                    <label for="hiv_art_started">Started on ART?</label>
                    <select name="hiv_art_started" class="form-control form-select">
                      <option value="" disabled selected>Select</option>
                      <option value="Yes">Yes</option>
                      <option value="No">No</option>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label for="hiv_cpt_started">Started on CPT?</label>
                    <select name="hiv_cpt_started" class="form-control form-select">
                      <option value="" disabled selected>Select</option>
                      <option value="Yes">Yes</option>
                      <option value="No">No</option>
                    </select>
                  </div>
                </div>

                <hr>
                <div class="row mb-3">
                  <div class="col-md-3">
                    <label for="base_height">Height</label>
                    <input type="text" name="base_height" id="trt_height" class="form-control" placeholder="cm"
                      required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="base_weight">Weight</label>
                    <input type="text" name="base_weight" id="trt_weight" class="form-control" placeholder="kg"
                      required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="base_vital_signs">Other Vital Signs</label>
                    <input type="text" name="base_vital_signs" id="trt_other_vital_signs" class="form-control"
                      placeholder="Treatment considerations" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="base_emergency_contact_name">Person to Notify</label>
                    <input type="text" name="base_emergency_contact_name" id="trt_emergency_contact"
                      class="form-control" placeholder="In case of emergency" required>
                    <div class="error"></div>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-3">
                    <label for="base_relationship">Relationship</label>
                    <input type="text" name="base_relationship" id="trt_relationship" class="form-control"
                      placeholder="Relationship" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="base_contact_info">Contact Information</label>
                    <input type="text" name="base_contact_info" id="trt_contact_information" class="form-control"
                      placeholder="Contact Information" maxlength="11" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="base_diabetes_screening">Diabetes Screening</label>
                    <select name="base_diabetes_screening" id="base_diabetes_screening" class="form-control form-select"
                      required>
                      <option value="" disabled selected>Select</option>
                      <option value="Known Diabetic">Known Diabetic</option>
                      <option value="Not Eligible">Not Eligible</option>
                    </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="base_four_ps_beneficiary">4Ps Beneficiary?</label>
                    <select name="base_four_ps_beneficiary" id="base_four_ps_beneficiary"
                      class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="Yes">Yes</option>
                      <option value="No">No</option>
                    </select>
                    <div class="error"></div>
                  </div>
                </div>

                <div class="row mb-2">
                  <div class="col-md-3">
                    <label for="base_fbs_screening">FBS Screening</label>
                    <input type="text" name="base_fbs_screening" id="base_fbs_screening" class="form-control"
                      placeholder="mg/dl" required>
                      <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="base_date_tested">Date Tested</label>
                    <input type="date" name="base_date_tested" id="base_date_tested" class="form-control"
                      max="<?php echo date('Y-m-d'); ?>" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="base_occupation">Occupation</label>
                    <input type="text" name="base_occupation" id="trt_occupation" class="form-control"
                      placeholder="Occupation" required>
                    <div class="error"></div>
                  </div>
                </div>

                <hr>
                <div class="row align-items-center mb-2">
                  <div class="col-md-6">
                    <label for="comorbidities">Co-morbidities</label>
                  </div>
                </div>

                <div class="row mb-2">
                  <div class="col-md-3">
                    <label for="com_date_diagnosed">Date Diagnosed</label>
                    <input type="date" name="com_date_diagnosed" class="form-control"
                      max="<?php echo date('Y-m-d'); ?>">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="com_type">Type</label>
                    <select name="com_type" class="form-control form-select">
                      <option value="" disabled selected>Select</option>
                      <option value="Diabetes Mellitus">Diabetes Mellitus</option>
                      <option value="Mental Illness">Mental Illness</option>
                      <option value="Substance Abuse">Substance Abuse</option>
                      <option value="Liver Disease">Liver Disease</option>
                      <option value="Renal Disease">Renal Disease</option>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label for="com_other">Other (Specify)</label>
                    <input type="text" name="com_other" id="trt_comorbidity_other" class="form-control"
                      placeholder="Specify">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="com_treatment">Treatment</label>
                    <input type="text" name="com_treatment" id="trt_comorbidity_treatment" class="form-control"
                      placeholder="Treatment">
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

              <!-- TAB 3: Regimen -->
              <div class="tab-pane fade" id="regimen" role="tabpanel">
                <h5 class="mb-4">B. Treatment Regimen</h5>
                <div class="row mb-2">
                  <div class="col-md-4">
                    <label for="reg_start_type">Regimen Type at Start of Treatment</label>
                    <select name="reg_start_type" id="trt_regimen_type_start_treatment"
                      class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="Regimen 1 - 2HRZE/4HR">Regimen 1 - 2HRZE/4HR</option>
                      <option value="Regimen 2 - 2HRZE/10HR">Regimen 2 - 2HRZE/10HR</option>
                    </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="reg_start_date">Treatment Start Date</label>
                    <input type="date" name="reg_start_date" id="trt_treatment_start_date" class="form-control"
                      max="<?php echo date('Y-m-d'); ?>" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="reg_end_type">Regimen Type at End of Treatment</label>
                    <input type="text" name="reg_end_type" class="form-control"
                      placeholder="Regimen type at end of treatment" max="<?php echo date('Y-m-d'); ?>">
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

              <!-- TAB 4: Outcome -->
              <div class="tab-pane fade" id="outcome" role="tabpanel">
                <h5 class="mb-4">C. Treatment Outcome</h5>
                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="out_outcome">Outcome</label>
                    <select name="out_outcome" class="form-control form-select">
                      <option value="" disabled selected>Select</option>
                      <option value="Cured">Cured</option>
                      <option value="Treatment Completed">Treatment Completed</option>
                      <option value="Lost to Follow-Up">Lost to Follow-up</option>
                      <option value="Died">Died</option>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label for="out_date">Date of Outcome</label>
                    <input type="date" name="out_date" class="form-control" max="<?php echo date('Y-m-d'); ?>">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="out_reason">Reason</label>
                    <input type="text" name="out_reason" id="trt_reason" class="form-control"
                      placeholder="If Failed, LTFU, or Died">
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

              <!-- TAB 5: Medicine -->
              <div class="tab-pane fade" id="medicine" role="tabpanel">
                <h5 class="mb-4">Prescribed Drugs</h5>
                <div class="row mb-2">
                  <div class="col-md-3">
                    <label for="drug_start_date">Date Start</label>
                    <input type="date" name="drug_start_date" id="trt_date_start" class="form-control"
                      max="<?php echo date('Y-m-d'); ?>" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="drug_name">Drug</label>
                    <select name="drug_name" id="trt_drug" class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="4FDC">4FDC</option>
                      <option value="2FDC">2FDC</option>
                      <option value="H">H</option>
                      <option value="R">R</option>
                      <option value="Z">Z</option>
                      <option value="E">E</option>
                    </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="drug_strength">Strength</label>
                    <input type="text" name="drug_strength" id="trt_strength" class="form-control"
                      placeholder="Strength" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="drug_unit">Unit</label>
                    <input type="text" name="drug_unit" id="trt_unit" class="form-control" placeholder="Unit" required>
                    <div class="error"></div>
                  </div>
                </div>

                <div class="row mb-2">
                  <div class="col-md-3">
                    <label for="drug_con_date">Continuation</label>
                    <input type="date" name="drug_con_date" id="drug_con_date" class="form-control" readonly>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="drug_con_name">Drug</label>
                    <select name="drug_con_name" class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="2FDC">2FDC</option>
                      <option value="H">H</option>
                      <option value="R">R</option>
                      <option value="Z">Z</option>
                      <option value="E">E</option>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label for="drug_con_strength">Strength</label>
                    <input type="text" name="drug_con_strength" id="trt_continuation_strength" class="form-control"
                      placeholder="Strength" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="drug_con_unit">Unit</label>
                    <input type="text" name="drug_con_unit" id="trt_continuation_unit" class="form-control"
                      placeholder="Unit" required>
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

              <!-- TAB 6: Administration -->
              <div class="tab-pane fade" id="admin" role="tabpanel">
                <h5 class="mb-4">D. Administration of Drugs</h5>
                <div class="row mb-3">
                  <div class="col-md-3">
                    <label for="sup_location">Location of Treatment</label>
                    <select name="sup_location" id="trt_treatment_location" class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="Facility-based">Falicity-based</option>
                      <option value="Community-based">Community-based</option>
                      <option value="Home-based">Home-based</option>
                    </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="sup_name">Name of Tx Supporter</label>
                    <input type="text" name="sup_name" id="trt_tx_supporter_name" class="form-control"
                      placeholder="Name" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="sup_designation">Designation</label>
                    <input type="text" name="sup_designation" id="trt_tx_supporter_designation" class="form-control"
                      placeholder="Designation" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="sup_type">Type of Tx Supporter</label>
                    <select name="sup_type" id="trt_tx_supporter_type" class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="Falicity HCW">Falicity HCW</option>
                      <option value="Community HCW">Community HCW</option>
                      <option value="Family">Family</option>
                      <option value="Lay Volunteer">Lay Volunteer</option>
                      <option value="Others">Others</option>
                    </select>
                    <div class="error"></div>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="sup_contact_info">Tx Supporter Contact Information</label>
                    <input type="text" name="sup_contact_info" id="trt_tx_supporter_contact" class="form-control"
                      placeholder="Tx Supporter Contact Information" maxlength="11" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="sup_treatment_schedule">Schedule of Treatment</label>
                    <input type="text" name="sup_treatment_schedule" id="trt_treatment_schedule" class="form-control"
                      placeholder="Schedule of Treatment">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="sup_dat_used">Name of DAT/s Used</label>
                    <input type="text" name="sup_dat_used" id="trt_name_dats_used" class="form-control"
                      placeholder="Name of DAT/s Used" required>
                    <div class="error"></div>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-3">
                    <label for="pha_intensive_start">Intensive Phase Start Date</label>
                    <input type="date" name="pha_intensive_start" id="trt_intensive_phase_start" class="form-control"
                      readonly>
                    <div class="error"></div>
                  </div>

                  <div class="col-md-3">
                    <label for="pha_intensive_end">IP End Date</label>
                    <input type="date" name="pha_intensive_end" id="trt_intensive_phase_end" class="form-control"
                      readonly>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="pha_continuation_start">Continuation Phase Start</label>
                    <input type="date" name="pha_continuation_start" id="pha_continuation_start" class="form-control"
                      readonly>
                    <div class="error"></div>
                  </div>

                  <div class="col-md-3">
                    <label for="pha_continuation_end">CP End Date</label>
                    <input type="date" name="pha_continuation_end" id="pha_continuation_end" class="form-control"
                      readonly>
                    <div class="error"></div>
                  </div>
                </div>

                <!-- <div class="row mb-3">
              <div class="col-md-3">
                <label for="pha_month">Month</label>
                <input type="text" name="pha_month" class="form-control" >
              </div>
              <div class="col-md-3">
                <label for="pha_monthly_doses">Monthly Doses Taken</label>
                <input type="text" name="pha_monthly_doses" class="form-control" placeholder="Monthly Doses Taken" >
              </div>
              <div class="col-md-3">
                <label for="pha_cumulative_doses">Cum. Doses Taken</label>
                <input type="text" name="pha_cumulative_doses" class="form-control" placeholder="Cum. Doses Taken" >
              </div>
              <div class="col-md-3">
                <label for="pha_monthly_missed">Monthly missed Doses</label>
                <input type="text" name="pha_monthly_missed" class="form-control" placeholder="Monthly missed Doses" >
              </div>
            </div> -->

                <div class="row mb-3">
                  <!-- <div class="col-md-4">
                <label for="pha_adherence_percent">% Adherence</label>
                <input type="text" name="pha_adherence_percent" class="form-control" placeholder="% Adherence">
              </div> -->
                  <div class="col-md-3">
                    <label for="pha_weight">Weight</label>
                    <input type="text" name="pha_weight" id="trt_weight_kg" class="form-control" placeholder="kg">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="pha_child_height">Height (cm) for Children</label>
                    <input type="text" name="pha_child_height" id="trt_children_height" class="form-control"
                      placeholder="cm">
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

  <!-- <script src="{{ url('assets/js/disabledBtn.js') }}"></script> -->

  <script>
    const form = document.getElementById('form');
    const trt_treatment_facility = document.getElementById('trt_treatment_facility');
    const trt_ntp_facility_code = document.getElementById('trt_ntp_facility_code');
    const trt_province_huc = document.getElementById('trt_province_huc');
    const trt_region = document.getElementById('trt_region');
    const trt_height = document.getElementById('trt_height');
    const trt_weight = document.getElementById('trt_weight');
    const trt_other_vital_signs = document.getElementById('trt_other_vital_signs');
    const trt_emergency_contact = document.getElementById('trt_emergency_contact');
    const trt_relationship = document.getElementById('trt_relationship');
    const trt_contact_information = document.getElementById('trt_contact_information');
    const base_diabetes_screening = document.getElementById('base_diabetes_screening');
    const base_four_ps_beneficiary = document.getElementById('base_four_ps_beneficiary');
    const base_fbs_screening = document.getElementById('base_fbs_screening');
    const base_date_tested = document.getElementById('base_date_tested');
    const trt_occupation = document.getElementById('trt_occupation');
    const trt_regimen_type_start_treatment = document.getElementById('trt_regimen_type_start_treatment');
    const trt_treatment_start_date = document.getElementById('trt_treatment_start_date');
    const trt_date_start = document.getElementById('trt_date_start');
    const trt_drug = document.getElementById('trt_drug');
    const trt_strength = document.getElementById('trt_strength');
    const trt_unit = document.getElementById('trt_unit');
    const trt_treatment_location = document.getElementById('trt_treatment_location');
    const trt_tx_supporter_name = document.getElementById('trt_tx_supporter_name');
    const trt_tx_supporter_designation = document.getElementById('trt_tx_supporter_designation');
    const trt_tx_supporter_type = document.getElementById('trt_tx_supporter_type');
    const trt_tx_supporter_contact = document.getElementById('trt_tx_supporter_contact');
    const trt_treatment_schedule = document.getElementById('trt_treatment_schedule');
    const trt_intensive_phase_start = document.getElementById('trt_intensive_phase_start');
    const trt_intensive_phase_end = document.getElementById('trt_intensive_phase_end');
    const pha_continuation_start = document.getElementById('pha_continuation_start');
    const pha_continuation_end = document.getElementById('pha_continuation_end');
    const drug_con_date = document.getElementById('drug_con_date');

    // Get ALL inputs and selects in the form
    const allInputs = form.querySelectorAll("input, select");

    const requiredFields = [
      trt_treatment_facility,
      trt_ntp_facility_code,
      trt_province_huc,
      trt_region,
      trt_height,
      trt_weight,
      trt_other_vital_signs,
      trt_emergency_contact,
      trt_relationship,
      trt_contact_information, // required contact
      base_diabetes_screening,
      base_four_ps_beneficiary,
      base_fbs_screening,
      base_date_tested,
      trt_occupation,
      trt_regimen_type_start_treatment,
      trt_treatment_start_date,
      trt_date_start,
      trt_drug,
      trt_strength,
      trt_unit,
      trt_treatment_location,
      trt_tx_supporter_name,
      trt_tx_supporter_designation,
      trt_tx_supporter_type,
      trt_tx_supporter_contact, // required contact
      trt_treatment_schedule,

    ];

    form.addEventListener("submit", function (e) {
      e.preventDefault(); // stop default submit

      if (validateInputs()) {
        // populate preview
        const preview = document.getElementById("previewContent");
        preview.innerHTML = `
          <div class="container-fluid px-2">

            <!-- Treatment Facility -->
            <div class="card shadow-sm border-0 rounded-3 mb-4">
              <div class="card-body">
                <h6 class="fw-bold mb-2">Treatment Facility</h6>
                <table class="table table-borderless preview-table align-middle mb-0">
                  <tbody>
                    <tr><th>Name of Treatment Facility</th><td>${form.trea_name.value}</td></tr>
                    <tr><th>NTP Facility Code</th><td>${form.trea_ntp_code.value}</td></tr>
                    <tr><th>Province</th><td>${form.trea_province.value}</td></tr>
                    <tr><th>Region</th><td>${form.trea_region.value}</td></tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Baseline Information -->
            <div class="card shadow-sm border-0 rounded-3 mb-4">
              <div class="card-body">
                <h6 class="fw-bold mb-2">Baseline Information</h6>
                <table class="table table-borderless preview-table align-middle mb-0">
                  <tbody>
                    <tr><th>Date Tx Started</th><td>${form.hist_date_tx_started.value}</td></tr>
                    <tr><th>Name of Treatment Unit</th><td>${form.hist_treatment_unit.value}</td></tr>
                    <tr><th>Treatment Regimen</th><td>${form.hist_regimen.value}</td></tr>
                    <tr><th>Outcome</th><td>${form.hist_outcome.value}</td></tr>
                    <tr><th>HIV Info</th><td>${form.hiv_information.value}</td></tr>
                    <tr><th>HIV Test Date</th><td>${form.hiv_test_date.value}</td></tr>
                    <tr><th>Confirmatory Test Date</th><td>${form.hiv_confirmatory_test_date.value}</td></tr>
                    <tr><th>HIV Result</th><td>${form.hiv_result.value}</td></tr>
                    <tr><th>ART Started?</th><td>${form.hiv_art_started.value}</td></tr>
                    <tr><th>CPT Started?</th><td>${form.hiv_cpt_started.value}</td></tr>
                    <tr><th>Height</th><td>${form.base_height.value}</td></tr>
                    <tr><th>Weight</th><td>${form.base_weight.value}</td></tr>
                    <tr><th>Other Vital Signs</th><td>${form.base_vital_signs.value}</td></tr>
                    <tr><th>Emergency Contact</th><td>${form.base_emergency_contact_name.value}</td></tr>
                    <tr><th>Relationship</th><td>${form.base_relationship.value}</td></tr>
                    <tr><th>Contact Info</th><td>${form.base_contact_info.value}</td></tr>
                    <tr><th>Diabetes Screening</th><td>${form.base_diabetes_screening.value}</td></tr>
                    <tr><th>4Ps Beneficiary</th><td>${form.base_four_ps_beneficiary.value}</td></tr>
                    <tr><th>FBS Screening</th><td>${form.base_fbs_screening.value}</td></tr>
                    <tr><th>Date Tested</th><td>${form.base_date_tested.value}</td></tr>
                    <tr><th>Occupation</th><td>${form.base_occupation.value}</td></tr>
                    <tr><th>Comorbidity Type</th><td>${form.com_type.value}</td></tr>
                    <tr><th>Other Comorbidity</th><td>${form.com_other.value}</td></tr>
                    <tr><th>Comorbidity Treatment</th><td>${form.com_treatment.value}</td></tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Treatment Regimen -->
            <div class="card shadow-sm border-0 rounded-3 mb-4">
              <div class="card-body">
                <h6 class="fw-bold mb-2">Treatment Regimen</h6>
                <table class="table table-borderless preview-table align-middle mb-0">
                  <tbody>
                    <tr><th>Start Regimen Type</th><td>${form.reg_start_type.value}</td></tr>
                    <tr><th>Treatment Start Date</th><td>${form.reg_start_date.value}</td></tr>
                    <tr><th>End Regimen Type</th><td>${form.reg_end_type.value}</td></tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Treatment Outcome -->
            <div class="card shadow-sm border-0 rounded-3 mb-4">
              <div class="card-body">
                <h6 class="fw-bold mb-2">Treatment Outcome</h6>
                <table class="table table-borderless preview-table align-middle mb-0">
                  <tbody>
                    <tr><th>Outcome</th><td>${form.out_outcome.value}</td></tr>
                    <tr><th>Date of Outcome</th><td>${form.out_date.value}</td></tr>
                    <tr><th>Reason</th><td>${form.out_reason.value}</td></tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Prescribed Drugs -->
            <div class="card shadow-sm border-0 rounded-3 mb-4">
              <div class="card-body">
                <h6 class="fw-bold mb-2">Prescribed Drugs</h6>
                <table class="table table-borderless preview-table align-middle mb-0">
                  <tbody>
                    <tr><th>Date Start</th><td>${form.drug_start_date.value}</td></tr>
                    <tr><th>Drug</th><td>${form.drug_name.value}</td></tr>
                    <tr><th>Strength</th><td>${form.drug_strength.value}</td></tr>
                    <tr><th>Unit</th><td>${form.drug_unit.value}</td></tr>
                    <tr><th>Continuation Date</th><td>${form.drug_con_date.value}</td></tr>
                    <tr><th>Continuation Drug</th><td>${form.drug_con_name.value}</td></tr>
                    <tr><th>Continuation Strength</th><td>${form.drug_con_strength.value}</td></tr>
                    <tr><th>Continuation Unit</th><td>${form.drug_con_unit.value}</td></tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Administration of Drugs -->
            <div class="card shadow-sm border-0 rounded-3 mb-4">
              <div class="card-body">
                <h6 class="fw-bold mb-2">Administration of Drugs</h6>
                <table class="table table-borderless preview-table align-middle mb-0">
                  <tbody>
                    <tr><th>Location</th><td>${form.sup_location.value}</td></tr>
                    <tr><th>Supporter Name</th><td>${form.sup_name.value}</td></tr>
                    <tr><th>Designation</th><td>${form.sup_designation.value}</td></tr>
                    <tr><th>Type</th><td>${form.sup_type.value}</td></tr>
                    <tr><th>Contact Info</th><td>${form.sup_contact_info.value}</td></tr>
                    <tr><th>Schedule</th><td>${form.sup_treatment_schedule.value}</td></tr>
                    <tr><th>DAT/s Used</th><td>${form.sup_dat_used.value}</td></tr>
                    <tr><th>Intensive Phase Start</th><td>${form.pha_intensive_start.value}</td></tr>
                    <tr><th>Intensive Phase End</th><td>${form.pha_intensive_end.value}</td></tr>
                    <tr><th>Continuation Phase Start</th><td>${form.pha_continuation_start.value}</td></tr>
                    <tr><th>Continuation Phase End</th><td>${form.pha_continuation_end.value}</td></tr>
                    <tr><th>Weight</th><td>${form.pha_weight.value}</td></tr>
                    <tr><th>Children Height</th><td>${form.pha_child_height.value}</td></tr>
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

    // ✅ Contact number validation (must start with 09 + 9 digits)
    function validateContactNumber(element) {
      const value = element.value.trim();
      const regex = /^09\d{9}$/; // 11 digits, starts with 09

      if (!value) {
        setError(element, "This is required.");
        return false;
      }

      if (!regex.test(value)) {
        setError(element, "Enter a valid 11-digit number.");
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

        // Special character check for text
        if (element.type === "text" && value &&
          element.id !== "trt_contact_information" &&
          element.id !== "trt_tx_supporter_contact") {
          const regex = /^[a-zA-Z0-9 ,.\-\/]*$/;
          if (!regex.test(value)) {
            setError(element, "Special characters prohibited.");
            return false;
          }
        }

        // Date check
        // if (element.type === "date" && value) {
        //   const selectedDate = new Date(value);
        //   if (selectedDate > today) {
        //     setError(element, "Enter a valid date.");
        //     return false;
        //   }
        // }

        // Numeric check for weight/height
        if ((element.id === "trt_weight" || element.id === "trt_height" || element.id === "trt_weight_kg" || element.id === "trt_children_height") && value) {
          const regex = /^[0-9]+(\.[0-9]+)?$/;
          if (!regex.test(value)) {
            setError(element, "Enter a valid numeric value.");
            return false;
          }
        }

        setSuccess(element);
        return true;
      };

      requiredFields.forEach(field => {
        if (field === trt_contact_information || field === trt_tx_supporter_contact) {
          if (!validateContactNumber(field)) isValid = false;
        } else {
          if (!validateField(field)) isValid = false;
        }
      });

      return isValid;
    }

    // Real-time validation
    allInputs.forEach(input => {
      const validateField = () => {
        const value = input.value.trim();
        const today = new Date();

        if (input === trt_contact_information || input === trt_tx_supporter_contact) {
          validateContactNumber(input);
        } else if (input.id === "trt_weight" || input.id === "trt_height" || input.id === "trt_weight_kg" || input.id === "trt_children_height") {
          const regex = /^[0-9]*\.?[0-9]*$/;
          if (!regex.test(value)) {
            setError(input, "Enter a valid numeric value.");
          } else if (value && isNaN(value)) {
            setError(input, "Enter a valid numeric value.");
          } else {
            setSuccess(input);
          }
        } else if (input.type === "text" && value) {
          const regex = /^[a-zA-Z0-9 ,.\-\/]*$/;
          if (!regex.test(value)) {
            setError(input, "Special characters prohibited.");
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

    // ✅ Force digits only for contact fields
    [trt_height, trt_weight, trt_contact_information, trt_tx_supporter_contact].forEach(input => {
      input.addEventListener("input", () => {
        input.value = input.value.replace(/\D/g, ""); // remove non-digits
        if (input.value.length > 11) input.value = input.value.slice(0, 11); // limit to 11 digits
      });
    });
  </script>


  @if(session('success'))
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: "{{ session('success') }}",
        confirmButtonColor: '#198754',
      });
    </script>
  @endif

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const drugStart = document.getElementById('trt_date_start');
      const drugContinuation = document.getElementById('drug_con_date');
      const intensiveStart = document.getElementById('trt_intensive_phase_start');
      const intensiveEnd = document.getElementById('trt_intensive_phase_end');
      const contStart = document.getElementById('pha_continuation_start');
      const contEnd = document.getElementById('pha_continuation_end');

      drugStart.addEventListener('change', function () {
        if (this.value) {
          const startDate = new Date(this.value);

          // Intensive Phase Start = Date Start
          intensiveStart.value = this.value;

          // Intensive Phase End = Start + 56 days
          const intensiveEndDate = new Date(startDate);
          intensiveEndDate.setDate(startDate.getDate() + 56);
          intensiveEnd.value = intensiveEndDate.toISOString().split('T')[0];

          // Drug Continuation = Start + 57 days (day after Intensive End)
          const drugConDate = new Date(startDate);
          drugConDate.setDate(startDate.getDate() + 56 + 1);
          drugContinuation.value = drugConDate.toISOString().split('T')[0];

          // Continuation Phase Start = same as Drug Continuation
          contStart.value = drugContinuation.value;

          // Continuation Phase End = Continuation Start + 6 months
          const contEndDate = new Date(drugConDate);
          contEndDate.setMonth(contEndDate.getMonth() + 6);
          contEnd.value = contEndDate.toISOString().split('T')[0];
        } else {
          intensiveStart.value = '';
          intensiveEnd.value = '';
          drugContinuation.value = '';
          contStart.value = '';
          contEnd.value = '';
        }
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

  // ✅ Real-time validation listener
  document.querySelectorAll("input[required], select[required], textarea[required]").forEach(input => {
    input.addEventListener("input", () => validateField(input));
    input.addEventListener("change", () => validateField(input));
  });

  // ✅ Single field validation
  function validateField(input) {
    const errorDiv = input.nextElementSibling;
    if (input.value.trim() === "") {
      input.classList.remove("is-valid");
      input.classList.add("is-invalid");
      if (errorDiv && errorDiv.classList.contains("error")) {
        errorDiv.textContent = "This field is required.";
      }
      return false;
    } else {
      input.classList.remove("is-invalid");
      input.classList.add("is-valid");
      if (errorDiv && errorDiv.classList.contains("error")) {
        errorDiv.textContent = "";
      }
      return true;
    }
  }

  // ✅ Validate all fields in current tab
  function validateTab(tabId) {
    const requiredInputs = document.querySelectorAll(`#${tabId} [required]`);
    let isValid = true;
    requiredInputs.forEach(input => {
      if (!validateField(input)) isValid = false;
    });

    if (isValid) validatedTabs.add(tabId);
    return isValid;
  }

  // ✅ Show SweetAlert warning
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

  // ✅ Prevent switching to higher tab without validation
  tabs.forEach((tab, index) => {
    tab.addEventListener("show.bs.tab", function (e) {
      const currentActive = document.querySelector("#formTabs .nav-link.active");
      const currentIndex = Array.from(tabs).indexOf(currentActive);

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

  // ✅ Handle "Next" buttons
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

  // ✅ Handle "Back" buttons
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



</body>

</html>