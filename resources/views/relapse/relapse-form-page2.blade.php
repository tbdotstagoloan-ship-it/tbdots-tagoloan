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
      RELAPSE REGISTRATION FORM
    </h4>


    <div class="card inventory-card shadow-sm border-0">
      <div class="card-body p-0">
        <div class="table-responsive">

          <form id="form" action="{{ url('validateRelapsePage2/' . $patient->id) }}" method="post" class="p-2" novalidate>
            @csrf

            <!-- Tabs -->
            <ul class="nav nav-tabs" id="formTabs" role="tablist">
              <li class="nav-item">
                <button class="nav-link active" id="treatment-tab" data-bs-toggle="tab" data-bs-target="#treatment"
                  type="button" role="tab">II. Treatment</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button"
                  role="tab">History of TB Treatment</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="hiv-tab" data-bs-toggle="tab" data-bs-target="#hiv" type="button"
                  role="tab">HIV Information</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="baseline-tab" data-bs-toggle="tab" data-bs-target="#baseline" type="button"
                  role="tab">Baseline Information</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="comorbidity-tab" data-bs-toggle="tab" data-bs-target="#comorbidity" type="button"
                  role="tab">Co-morbidities</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="regimen-tab" data-bs-toggle="tab" data-bs-target="#regimen" type="button"
                  role="tab">Treatment Regimen</button>
              </li>
              <!-- <li class="nav-item">
                <button class="nav-link" id="outcome-tab" data-bs-toggle="tab" data-bs-target="#outcome" type="button"
                  role="tab">C. Treatment Outcome</button>
              </li> -->
              <li class="nav-item">
                <button class="nav-link" id="medicine-tab" data-bs-toggle="tab" data-bs-target="#medicine" type="button"
                  role="tab">Prescribed Drugs</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="admin-tab" data-bs-toggle="tab" data-bs-target="#admin" type="button"
                  role="tab">Administration of Drugs</button>
              </li>
            </ul>

            <!-- <input type="hidden" name="diagnosis_id" value="{{ $diagnosis->id ?? '' }}"> -->

            <!-- Tab Content -->
            <div class="tab-content p-3" id="formTabsContent">

              <!-- TAB 1: Treatment -->
              <div class="tab-pane fade show active" id="treatment" role="tabpanel">
                <div class="row mb-2">
                  <div class="col-md-3">
                      <label for="trea_name">Treatment Facility</label>
                      <input type="text" value="{{ $patient->latestTreatmentFacility->trea_name ?? '' }}" class="form-control" readonly>
                  </div>
                  <div class="col-md-3">
                      <label for="trea_ntp_code">NTP Facility Code</label>
                      <input type="text" value="{{ $patient->latestTreatmentFacility->trea_ntp_code ?? '' }}" class="form-control" readonly>
                  </div>
                  <div class="col-md-3">
                      <label for="trea_province">Province / HUC</label>
                      <input type="text" value="{{ $patient->latestTreatmentFacility->trea_province ?? '' }}" class="form-control" readonly>
                  </div>
                  <div class="col-md-3">
                      <label for="trea_region">Region</label>
                      <input type="text" value="{{ $patient->latestTreatmentFacility->trea_region ?? '' }}" class="form-control" readonly>
                  </div>

                </div>
                <div class="d-flex justify-content-end mt-4">
                  <button type="button" class="btn backBtn next-tab d-flex align-items-center gap-1">
                    Next <i class="fas fa-arrow-right"></i>
                  </button>
                </div>
              </div>

              <!-- TAB 2: Baseline -->
              <div class="tab-pane fade" id="history" role="tabpanel">
                <h5 class="mb-4">History of TB Treatment</h5>

                <div class="row mb-2">
                  <div class="col-md-6">
                    <label for="hist_date_tx_started">Date Tx Started <span style="color: #6b7280;">(Optional)</span></label>
                    <input type="date" name="hist_date_tx_started" id="hist_date_tx_started" class="form-control"
                      max="{{ date('Y-m-d') }}">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-6">
                    <label for="hist_treatment_unit">Name of Treatment Unit <span style="color: #6b7280;">(Optional)</span></label>
                    <input type="text" name="hist_treatment_unit" id="hist_treatment_unit" class="form-control"
                      placeholder="Name of Treatment Unit">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-6">
                    <label for="hist_drug">Treatment Regimen <span style="color: #6b7280;">(Optional)</span></label>
                    <input type="text" name="hist_drug" id="hist_drug" class="form-control"
                      placeholder="Drug">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-6">
                    <label for="hist_treatment_duration">Treatment Duration <span style="color: #6b7280;">(Optional)</span></label>
                      <!-- <select name="hist_treatment_duration" id="hist_treatment_duration" class="form-control form-select">
                        <option value="" disabled selected>Select</option>
                        <option value="6 Months">6 Months</option>
                      </select> -->
                      <input type="text" name="hist_treatment_duration" id="hist_treatment_duration" class="form-control"
                        placeholder="Duration">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-6">
                    <label for="hist_outcome">Outcome <span style="color: #6b7280;">(Optional)</span></label>
                      <select name="hist_outcome" id="hist_outcome" class="form-control form-select">
                        <option value="" disabled selected>Select</option>
                        <option value="Cured">Cured</option>
                        <option value="Treatment Completed">Treatment Completed</option>
                        <option value="Lost to Follow-Up">Lost to Follow-Up</option>
                        <option value="Died">Died</option>
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

              <!-- TAB 3: HIV Information -->
              <div class="tab-pane fade" id="hiv" role="tabpanel">
                <h5 class="mb-4">Human Immnunodeficiency Virus</h5>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="hiv_information">HIV Information <span style="color: #6b7280;">(Optional)</span></label>
                    <select name="hiv_information" id="hiv_information" class="form-control form-select">
                      <option value="" disabled selected>Select</option>
                      <option value="Known for HIV">Known for HIV</option>
                      <option value="Not yet Tested">Not yet Tested</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="hiv_test_date">HIV Test Date <span style="color: #6b7280;">(Optional)</span></label>
                    <input type="date" name="hiv_test_date" id="hiv_test_date" class="form-control" max="{{ date('Y-m-d') }}">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-6">
                    <label for="hiv_confirmatory_test_date">Confirmatory Test Date <span style="color: #6b7280;">(Optional)</span></label>
                    <input type="date" name="hiv_confirmatory_test_date" id="hiv_confirmatory_test_date" class="form-control"
                      max="{{ date('Y-m-d') }}">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-6">
                    <label for="hiv_result">Result <span style="color: #6b7280;">(Optional)</span></label>
                    <select name="hiv_result" id="hiv_result" class="form-control form-select">
                      <option value="" disabled selected>Select</option>
                      <option value="Reactive">Reactive</option>
                      <option value="Non-reactive">Non-reactive</option>
                      <option value="Undetermined">Undetermined</option>
                    </select>
                  </div>
                
                  <div class="col-md-6">
                    <label for="hiv_art_started">Started on ART? <span style="color: #6b7280;">(Optional)</span></label>
                    <select name="hiv_art_started" id="hiv_art_started" class="form-control form-select">
                      <option value="" disabled selected>Select</option>
                      <option value="Yes">Yes</option>
                      <option value="No">No</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="hiv_cpt_started">Started on CPT? <span style="color: #6b7280;">(Optional)</span></label>
                    <select name="hiv_cpt_started" id="hiv_cpt_started" class="form-control form-select">
                      <option value="" disabled selected>Select</option>
                      <option value="Yes">Yes</option>
                      <option value="No">No</option>
                    </select>
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

              <!-- TAB 4: Baseline Information -->
              <div class="tab-pane fade" id="baseline" role="tabpanel">
                <h5 class="mb-4">A. Baseline Information</h5>

                <div class="row mb-2">
                  <div class="col-md-4">
                    <label for="base_height">Height <span style="color: red;">*</span></label>
                    <input type="text" name="base_height" id="base_height" class="form-control" placeholder="cm"
                      required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="base_weight">Weight <span style="color: red;">*</span></label>
                    <input type="text" name="base_weight" id="base_weight" class="form-control" placeholder="kg"
                      required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="base_blood_pressure">Blood Pressure <span style="color: red;">*</span></label>
                    <input type="text" name="base_blood_pressure" id="base_blood_pressure" class="form-control"
                      placeholder="Blood Pressure" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="base_pulse_rate">Pulse Rate <span style="color: red;">*</span></label>
                    <input type="text" name="base_pulse_rate" id="base_pulse_rate" class="form-control"
                      placeholder="Pulse Rate" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="base_temperature">Temperature (°C) <span style="color: red;">*</span></label>
                    <input type="text" name="base_temperature" id="base_temperature" class="form-control"
                      placeholder="Temperature" required>
                    <div class="error"></div>
                  </div>
                  </div>
                  <hr>
                  <div class="row mb-2">
                    <div class="col-md-3">
                    <label for="base_emergency_contact_name">Person to Notify <span style="color: red;">*</span></label>
                     <input type="text" name="base_emergency_contact_name" id="base_emergency_contact_name" class="form-control" 
                        placeholder="In Case of Emergency" required>
                        <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="base_relationship">Relationship <span style="color: red;">*</span></label>
                     <input type="text" name="base_relationship" id="base_relationship" class="form-control" 
                        placeholder="Relationship" required>
                        <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="base_contact_info">Contact Information <span style="color: red;">*</span></label>
                     <input type="text" name="base_contact_info" id="base_contact_info" class="form-control" 
                        placeholder="Contact Information" required>
                        <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="base_occupation">Occupation <span style="color: red;">*</span></label>
                     <input type="text" name="base_occupation" id="base_occupation" class="form-control" 
                        placeholder="Occupation" required>
                        <div class="error"></div>
                  </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                    <label for="base_diabetes_screening">Diabetes Screening <span style="color: red;">*</span></label>
                    <select name="base_diabetes_screening" id="base_diabetes_screening" class="form-control form-select"
                      required>
                      <option value="" disabled selected>Select</option>
                      <option value="Known Diabetic">Known Diabetic</option>
                      <option value="Not Eligible">Not Eligible</option>
                    </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="base_four_ps_beneficiary">4Ps Beneficiary? <span style="color: red;">*</span></label>
                    <select name="base_four_ps_beneficiary" id="base_four_ps_beneficiary"
                      class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="Yes">Yes</option>
                      <option value="No">No</option>
                    </select>
                    <div class="error"></div>
                  </div>

                  <div class="col-md-3">
                    <label for="base_fbs_screening">FBS Screening <span style="color: #6b7280;">(Optional)</span></label>
                      <select name="base_fbs_screening" id="base_fbs_screening" class="form-control form-select">
                        <option value="" disabled selected>Select</option>
                        <option value="Normal">Normal</option>
                        <option value="Abnormal">Abnormal</option>
                      </select>
                      <div class="error"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="base_date_tested">Date Tested <span style="color: #6b7280;">(Optional)</span></label>
                    <input type="date" name="base_date_tested" id="base_date_tested" class="form-control"
                      max="{{ date('Y-m-d') }}">
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

              <!-- TAB 4: Co-morbidities -->
              <div class="tab-pane fade" id="comorbidity" role="tabpanel">
                <h5 class="mb-4">Co-morbidities</h5>

                <div class="row mb-2">
                  <div class="col-md-6">
                    <label for="com_date_diagnosed">Date Diagnosed <span style="color: #6b7280;">(Optional)</span></label>
                    <input type="date" name="com_date_diagnosed" id="com_date_diagnosed" class="form-control"
                      max="{{ date('Y-m-d') }}">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-6">
                    <label for="com_type">Type <span style="color: #6b7280;">(Optional)</span></label>
                    <select name="com_type" id="com_type" class="form-control form-select">
                      <option value="" disabled selected>Select</option>
                      <option value="Diabetes Mellitus">Diabetes Mellitus</option>
                      <option value="Mental Illness">Mental Illness</option>
                      <option value="Substance Abuse">Substance Abuse</option>
                      <option value="Liver Disease">Liver Disease</option>
                      <option value="Renal Disease">Renal Disease</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="com_other">Other <span style="color: #6b7280;">(Optional)</span></label>
                    <input type="text" name="com_other" id="com_other" class="form-control"
                      placeholder="Specify">
                    <div class="error"></div>
                  </div>
                  <div class="col-md-6">
                    <label for="com_treatment">Treatment <span style="color: #6b7280;">(Optional)</span></label>
                    <input type="text" name="com_treatment" id="com_treatment" class="form-control"
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
                    <label for="reg_start_type">Regimen Type at Start of Treatment <span style="color: red;">*</span></label>
                    <select name="reg_start_type" id="reg_start_type"
                      class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="Regimen 1 - 2HRZE/4HR">Regimen 1 - 2HRZE/4HR</option>
                      <option value="Regimen 2 - 2HRZE/10HR">Regimen 2 - 2HRZE/10HR</option>
                    </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="reg_start_date">Treatment Start Date <span style="color: red;">*</span></label>
                    <input type="date" name="reg_start_date" id="reg_start_date" class="form-control"
                      max="{{ date('Y-m-d') }}" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="reg_end_type">Regimen Type at End of Treatment <span style="color: #6b7280;">(Optional)</span></label>
                    <!-- <input type="text" name="reg_end_type" id="reg_end_type" class="form-control"
                      placeholder="Regimen type at end of treatment"> -->
                      <select name="reg_end_type" id="reg_end_type"
                      class="form-control form-select">
                      <option value="" disabled selected>Select</option>
                      <option value="Regimen 1 - 2HRZE/4HR">Regimen 1 - 2HRZE/4HR</option>
                      <option value="Regimen 2 - 2HRZE/10HR">Regimen 2 - 2HRZE/10HR</option>
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

              <!-- TAB 5: Medicine -->
              <div class="tab-pane fade" id="medicine" role="tabpanel">
                <h5 class="mb-4">Prescribed Drugs</h5>
                <div class="row mb-2">
                  <div class="col-md-4">
                    <label for="drug_start_date">Date Start <span style="color: red;">*</span></label>
                    <input type="date" name="drug_start_date" id="drug_start_date" class="form-control"
                      max="{{ date('Y-m-d') }}" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="drug_name">Drug</label>
                    <!-- <select name="drug_name" id="drug_name" class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="4FDC">4FDC</option>
                      <option value="2FDC">2FDC</option>
                      <option value="H">H</option>
                      <option value="R">R</option>
                      <option value="Z">Z</option>
                      <option value="E">E</option>
                    </select> -->
                    <input type="text" name="drug_name" id="drug_name" class="form-control" readonly>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="drug_no_of_tablets">No. of Tablets</label>
                    <input type="text" name="drug_no_of_tablets" id="drug_no_of_tablets" class="form-control" readonly>
                  </div>
                  <div class="col-md-4">
                    <label for="drug_strength">Strength</label>
                      <!-- <select name="drug_strength" id="drug_strength" class="form-control form-select" readonly>
                        <option value="" disabled selected>Select</option>
                        <option value="400mg">400mg</option>
                        <option value="275mg">275mg</option>
                        <option value="150mg">150mg</option>
                        <option value="75mg">75mg</option>
                      </select> -->
                      <input type="text" name="drug_strength" id="drug_strength" class="form-control" readonly>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="drug_unit">Unit</label>
                     <!-- <select name="drug_unit" id="drug_unit" class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="Tablet">Tablet</option>
                     </select> -->
                     <input type="text" name="drug_unit" id="drug_unit" class="form-control" readonly>
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
                  <div class="col-md-4">
                    <label for="sup_location">Location of Treatment <span style="color: red;">*</span></label>
                    <select name="sup_location" id="sup_location" class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="Facility-based">Falicity-based</option>
                      <option value="Community-based">Community-based</option>
                      <option value="Home-based">Home-based</option>
                    </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="sup_name">Name of Tx Supporter <span style="color: red;">*</span></label>
                    <input type="text" name="sup_name" id="sup_name" class="form-control"
                      placeholder="Name" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="sup_designation">Designation <span style="color: red;">*</span></label>
                      <select name="sup_designation" id="sup_designation" class="form-control form-select" required>
                        <option value="" disabled selected>Select</option>
                        <option value="Doctor">Doctor</option>
                        <option value="Nurse">Nurse</option>
                        <option value="Midwife">Midwife</option>
                        <option value="BHW">BHW</option>
                      </select>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="sup_type">Type of Tx Supporter <span style="color: red;">*</span></label>
                    <select name="sup_type" id="sup_type" class="form-control form-select" required>
                      <option value="" disabled selected>Select</option>
                      <option value="Falicity HCW">Falicity HCW</option>
                      <option value="Community HCW">Community HCW</option>
                      <option value="Family">Family</option>
                      <option value="Lay Volunteer">Lay Volunteer</option>
                      <option value="Others">Others</option>
                    </select>
                    <div class="error"></div>
                  </div>

                <!-- <div class="row mb-3"> -->
                  <div class="col-md-4">
                    <label for="sup_contact_info">Tx Supporter Contact <span style="color: red;">*</span></label>
                    <input type="text" name="sup_contact_info" id="sup_contact_info" class="form-control"
                      placeholder="Tx Supporter Contact" maxlength="11" required>
                    <div class="error"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="sup_treatment_schedule">Schedule of Treatment </label>
                      <!-- <select name="sup_treatment_schedule" id="sup_treatment_schedule" class="form-control form-select">
                        <option value="Daily" selected>Daily</option>
                      </select> -->
                      <input type="text" name="sup_treatment_schedule" id="sup_treatment_schedule" class="form-control"
                        value="Daily" readonly>
                    <div class="error"></div>
                  </div>
                  <!-- <div class="row mb-3"> -->
                  <div class="col-md-4">
                    <label for="pha_intensive_start">Intensive Phase Start Date</label>
                    <input type="date" name="pha_intensive_start" id="pha_intensive_start" class="form-control"
                      readonly>
                    <div class="error"></div>
                  </div>

                  <div class="col-md-4">
                    <label for="pha_intensive_end">Intensive Phase End Date</label>
                    <input type="date" name="pha_intensive_end" id="pha_intensive_end" class="form-control"
                      readonly>
                    <div class="error"></div>
                  </div>

                 <div class="col-md-4">
                    <label for="sup_dat_used">Name of DAT/s Used <span style="color: #6b7280;">(Optional)</span></label>
                    <input type="text" name="sup_dat_used" id="sup_dat_used" class="form-control"
                      placeholder="Name of DAT/s Used">
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

  <!-- <script src="{{ url('assets/js/disabledBtn.js') }}"></script> -->

  <script>
    const form = document.getElementById('form');
    // Baseline Information (Required fields only)
    const base_height = document.getElementById('base_height');
    const base_weight = document.getElementById('base_weight');
    const base_blood_pressure = document.getElementById('base_blood_pressure');
    const base_pulse_rate = document.getElementById('base_pulse_rate');
    const base_temperature = document.getElementById('base_temperature');
    const base_diabetes_screening = document.getElementById('base_diabetes_screening');
    const base_four_ps_beneficiary = document.getElementById('base_four_ps_beneficiary');

    // Treatment Regimen
    const reg_start_type = document.getElementById('reg_start_type');
    const reg_start_date = document.getElementById('reg_start_date');

    // Prescribed Drugs
    const drug_start_date = document.getElementById('drug_start_date');
    const drug_name = document.getElementById('drug_name');
    const drug_no_of_tablets = document.getElementById('drug_no_of_tablets');
    const drug_strength = document.getElementById('drug_strength');
    const drug_unit = document.getElementById('drug_unit');

    // Administration of Drugs
    const sup_location = document.getElementById('sup_location');
    const sup_name = document.getElementById('sup_name');
    const sup_designation = document.getElementById('sup_designation');
    const sup_type = document.getElementById('sup_type');
    const sup_contact_info = document.getElementById('sup_contact_info');
    const pha_intensive_start = document.getElementById('pha_intensive_start');
    const pha_intensive_end = document.getElementById('pha_intensive_end');

    // Get ALL inputs and selects in the form
    const allInputs = form.querySelectorAll("input, select");

    const requiredFields = [
      base_height,
      base_weight,
      base_blood_pressure,
      base_pulse_rate,
      base_temperature,
      base_diabetes_screening,
      base_four_ps_beneficiary,
      reg_start_type,
      reg_start_date,
      drug_start_date,
      sup_location,
      sup_name,
      sup_designation,
      sup_type,
      sup_contact_info,
    ];

    form.addEventListener("submit", function (e) {
      e.preventDefault();

      if (validateInputs()) {
        const preview = document.getElementById("previewContent");
        preview.innerHTML = `
          <div class="container-fluid px-2">

            <!-- Baseline Information -->
            <div class="card shadow-sm border-0 rounded-3 mb-4">
              <div class="card-body">
                <h6 class="fw-bold mb-2">Baseline Information</h6>
                <table class="table table-borderless preview-table align-middle mb-0">
                  <tbody>
                    <tr><th>Height</th><td>${base_height.value} cm</td></tr>
                    <tr><th>Weight</th><td>${base_weight.value} kg</td></tr>
                    <tr><th>Blood Pressure</th><td>${base_blood_pressure.value}</td></tr>
                    <tr><th>Pulse Rate</th><td>${base_pulse_rate.value}</td></tr>
                    <tr><th>Temperature</th><td>${base_temperature.value} °C</td></tr>
                    <tr><th>Diabetes Screening</th><td>${base_diabetes_screening.value}</td></tr>
                    <tr><th>4Ps Beneficiary</th><td>${base_four_ps_beneficiary.value}</td></tr>
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
                    <tr><th>Regimen Type at Start</th><td>${reg_start_type.value}</td></tr>
                    <tr><th>Treatment Start Date</th><td>${reg_start_date.value}</td></tr>
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
                    <tr><th>Date Start</th><td>${drug_start_date.value}</td></tr>
                    <tr><th>Drug</th><td>${drug_name.value}</td></tr>
                    <tr><th>No. of Tablets</th><td>${drug_no_of_tablets.value}</td></tr>
                    <tr><th>Strength</th><td>${drug_strength.value}</td></tr>
                    <tr><th>Unit</th><td>${drug_unit.value}</td></tr>
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
                    <tr><th>Location of Treatment</th><td>${sup_location.value}</td></tr>
                    <tr><th>Tx Supporter Name</th><td>${sup_name.value}</td></tr>
                    <tr><th>Designation</th><td>${sup_designation.value}</td></tr>
                    <tr><th>Type</th><td>${sup_type.value}</td></tr>
                    <tr><th>Contact Info</th><td>${sup_contact_info.value}</td></tr>
                    <tr><th>Intensive Phase Start</th><td>${pha_intensive_start.value}</td></tr>
                    <tr><th>Intensive Phase End</th><td>${pha_intensive_end.value}</td></tr>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        `;

        let modal = new bootstrap.Modal(document.getElementById("previewModal"));
        modal.show();
      }
    });

    // Final confirm button
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

    // Contact number validation
    function validateContactNumber(element) {
      const value = element.value.trim();
      const regex = /^09\d{9}$/;

      if (!value) {
        setError(element, "This field is required.");
        return false;
      }

      if (!regex.test(value)) {
        setError(element, "Enter a valid 11-digit number starting with 09");
        return false;
      }

      setSuccess(element);
      return true;
    }

    function validateInputs() {
      let isValid = true;
      const today = new Date();

      const validateField = (element) => {
        // Skip validation for disabled or readonly fields
        if (element.disabled || element.readOnly) {
          return true;
        }

        const value = element.value.trim();

        // Required check
        if (!value) {
          setError(element, "This field is required.");
          return false;
        }

        // Date validation
        if (element.type === "date" && value) {
          const selectedDate = new Date(value);
          if (selectedDate > today) {
            setError(element, "Enter a valid date.");
            return false;
          }
        }

        // Numeric validation for height/weight
        if ((element.id === "base_weight" || element.id === "base_height") && value) {
          const regex = /^[0-9]+(\.[0-9]+)?$/;
          if (!regex.test(value)) {
            setError(element, "Enter a valid numeric value.");
            return false;
          }
        }

        // Text field validation (allow common characters)
        if (element.type === "text" && value && element.id !== "sup_contact_info") {
          const regex = /^[a-zA-Z0-9 ,.\-\/°]*$/;
          if (!regex.test(value)) {
            setError(element, "Special characters prohibited.");
            return false;
          }
        }

        setSuccess(element);
        return true;
      };

      requiredFields.forEach(field => {
        if (field === sup_contact_info) {
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
        // Skip validation for disabled or readonly fields
        if (input.disabled || input.readOnly) {
          return;
        }

        const value = input.value.trim();
        const today = new Date();

        if (input === sup_contact_info) {
          validateContactNumber(input);
        } else if (requiredFields.includes(input) && !value) {
          setError(input, "This field is required.");
        } else if (input.type === "date" && value) {
          const selectedDate = new Date(value);
          if (selectedDate > today) {
            setError(input, "Enter a valid date.");
          } else {
            setSuccess(input);
          }
        } else if ((input.id === "base_weight" || input.id === "base_height") && value) {
          const regex = /^[0-9]*\.?[0-9]*$/;
          if (!regex.test(value)) {
            setError(input, "Enter a valid numeric value.");
          } else {
            setSuccess(input);
          }
        } else if (input.type === "text" && value && input.id !== "sup_contact_info") {
          const regex = /^[a-zA-Z0-9 ,.\-\/°]*$/;
          if (!regex.test(value)) {
            setError(input, "Special characters prohibited.");
          } else {
            setSuccess(input);
          }
        } else if (value) {
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

    // Force digits only for contact number
    sup_contact_info.addEventListener("input", () => {
      sup_contact_info.value = sup_contact_info.value.replace(/\D/g, "");
      if (sup_contact_info.value.length > 11) {
        sup_contact_info.value = sup_contact_info.value.slice(0, 11);
      }
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
      const drugStart = document.getElementById('drug_start_date');
      const drugContinuation = document.getElementById('drug_con_date');
      const intensiveStart = document.getElementById('pha_intensive_start');
      const intensiveEnd = document.getElementById('pha_intensive_end');

      // ✅ Calculate Intensive Phase (56 days)
      drugStart.addEventListener('change', function () {
        if (this.value) {
          const startDate = new Date(this.value);

          // Intensive Phase Start = Date Start
          intensiveStart.value = this.value;

          // Intensive Phase End = Start + 56 days
          const intensiveEndDate = new Date(startDate);
          intensiveEndDate.setDate(startDate.getDate() + 56);
          intensiveEnd.value = intensiveEndDate.toISOString().split('T')[0];
        } else {
          intensiveStart.value = '';
          intensiveEnd.value = '';
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

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const baseWeight = document.getElementById('base_weight');
    const drugName = document.getElementById('drug_name');
    const noOfTablets = document.getElementById('drug_no_of_tablets');
    const strength = document.getElementById('drug_strength');
    const unit = document.getElementById('drug_unit');

    baseWeight.addEventListener('input', function () {
      const weight = parseFloat(this.value);

      // Reset if invalid input
      if (isNaN(weight)) {
        drugName.value = '';
        noOfTablets.value = '';
        strength.value = '';
        unit.value = '';
        return;
      }

      // Default drug is 4FDC (intensive phase)
      drugName.value = '4FDC';

      let tablets = 0;

      // Determine # of tablets based on weight
      if (weight >= 25 && weight <= 37) {
        tablets = 2;
      } else if (weight >= 38 && weight <= 54) {
        tablets = 3;
      } else if (weight >= 55 && weight <= 70) {
        tablets = 4;
      } else if (weight > 70) {
        tablets = 5;
      } else {
        drugName.value = '';
        noOfTablets.value = '';
        strength.value = '';
        unit.value = '';
        return;
      }

      noOfTablets.value = tablets;

      // 4FDC strength table
      const strengthMap4FDC = {
        1: 400,
        2: 800,
        3: 12000,
        4: 16000,
        5: 20000
      };
      strength.value = strengthMap4FDC[tablets] + 'mg';

      unit.value = 'Tablet';
    });
  });
</script>



</body>

</html>