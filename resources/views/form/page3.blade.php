<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>TB DOTS - Add New Patient</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="{{ url('assets/css/style.css') }}" />
  <link rel="icon" href="{{ url('assets/img/lungs.png') }}">

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
    <h4 style="margin-bottom: 20px; color: #2c3e50; font-weight: 600">
      National TB Control Program
    </h4>


    <div class="card inventory-card shadow-sm border-0">
      <div class="card-body p-0">
        <div class="table-responsive">

          <form id="form" action="{{ url('validatePage3') }}" method="post" class="p-2" novalidate>
            @csrf

            <!-- Tabs -->
              <ul class="nav nav-tabs flex-wrap" id="formTabs" role="tablist">
                <li class="nav-item">
                  <button class="nav-link active" id="ae-tab" data-bs-toggle="tab" data-bs-target="#ae" type="button" role="tab">
                    E. Serious Adverse Events
                  </button>
                </li>
                <li class="nav-item">
                  <button class="nav-link" id="progress-tab" data-bs-toggle="tab" data-bs-target="#progress" type="button" role="tab">
                    F. Patient Progress Report
                  </button>
                </li>
                <li class="nav-item">
                  <button class="nav-link" id="close-tab" data-bs-toggle="tab" data-bs-target="#close" type="button" role="tab">
                    G. Close Contacts
                  </button>
                </li>
                <li class="nav-item">
                  <button class="nav-link" id="sputum-tab" data-bs-toggle="tab" data-bs-target="#sputum" type="button" role="tab">
                    H. Sputum Monitoring
                  </button>
                </li>
                <li class="nav-item">
                  <button class="nav-link" id="xray-tab" data-bs-toggle="tab" data-bs-target="#xray" type="button" role="tab">
                    I. Chest X-ray
                  </button>
                </li>
                <li class="nav-item">
                  <button class="nav-link" id="followup-tab" data-bs-toggle="tab" data-bs-target="#followup" type="button" role="tab">
                    J. Post Treatment Follow-up
                  </button>
                </li>
              </ul>

            <!-- Tab Content -->
            <div class="tab-content p-3" id="formTabsContent">

              <!-- TAB 1: Adverse Events -->
              <div class="tab-pane fade show active" id="ae" role="tabpanel">
                <h5 class="mb-4">E. Serious Adverse Events and AEs of Special Interest</h5>
                <div class="row mb-2">
                  <div class="col-md-4">
                    <label for="adv_ae_date">Date of AE</label>
                    <input type="date" name="adv_ae_date" class="form-control" max="<?php echo date('Y-m-d'); ?>">
                  </div>
                  <div class="col-md-4">
                    <label for="adv_specific_ae">Specific AE</label>
                    <input type="text" name="adv_specific_ae" class="form-control" placeholder="Specific AE">
                  </div>
                  <div class="col-md-4">
                    <label for="adv_fda_reported_date">Date Reported to FDA</label>
                    <input type="date" name="adv_fda_reported_date" class="form-control"
                      max="<?php echo date('Y-m-d'); ?>">
                  </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                <button type="button" class="btn backBtn next-tab d-flex align-items-center gap-1">
                  Next <i class="fas fa-arrow-right"></i>
                </button>
              </div>

              </div>

              <!-- TAB 2: Patient Progress-->
              <div class="tab-pane fade" id="progress" role="tabpanel">
                <h5 class="mb-4">F. Patient Progress Report Form</h5>
                <div class="row mb-2">
                  <div class="col-md-3">
                    <label for="prog_date">Date</label>
                    <input type="date" name="prog_date" class="form-control" max="<?php echo date('Y-m-d'); ?>">
                  </div>
                  <div class="col-md-3">
                    <label for="prog_problem">Problem</label>
                    <input type="text" name="prog_problem" class="form-control" placeholder="AE, reason of absence">
                  </div>
                  <div class="col-md-3">
                    <label for="prog_action_taken">Action Taken</label>
                    <input type="text" name="prog_action_taken" class="form-control" placeholder="Action taken">
                  </div>
                  <div class="col-md-3">
                    <label for="prog_plan">Plan</label>
                    <input type="text" name="prog_plan" class="form-control" placeholder="Plan">
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

              <!-- TAB 3: Close Contact -->
              <div class="tab-pane fade" id="close" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <h5 class="mb-0 fw-bold">G. Close Contacts</h5>
                  <button type="button" class="btn btn-success btn-sm d-flex align-items-center gap-2" id="addMoreContact">
                    <i class="fas fa-plus"></i> Add Close Contact
                  </button>
                </div>

                <div id="closeContactContainer">
                  <div class="close-contact-entry mb-3">
                    <div class="row mb-3">
                      <div class="col-md-3">
                        <label for="con_name">Name</label>
                        <input type="text" name="con_name" class="form-control" placeholder="Name">
                      </div>
                      <div class="col-md-3">
                        <label for="con_age">Age</label>
                        <input type="number" name="con_age" class="form-control" placeholder="Age" min="0" max="120">
                      </div>
                      <div class="col-md-3">
                        <label for="con_sex">Sex</label>
                        <select name="con_sex" class="form-control form-select">
                          <option value="" disabled selected>Select</option>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label for="con_relationship">Relationship</label>
                        <input type="text" name="con_relationship" class="form-control" placeholder="Relationship">
                      </div>
                    </div>

                    <div class="row mb-2">
                      <div class="col-md-3">
                        <label for="con_initial_screening">Initial Screening</label>
                        <input type="date" name="con_initial_screening" class="form-control" max="<?php echo date('Y-m-d'); ?>">
                      </div>
                      <div class="col-md-3">
                        <label for="con_follow_up">Ff-up</label>
                        <input type="date" name="con_follow_up" class="form-control" max="<?php echo date('Y-m-d'); ?>">
                      </div>
                      <div class="col-md-3">
                        <label for="con_remarks">Remarks</label>
                        <input type="text" name="con_remarks" class="form-control" placeholder="TB/ TPT Case Number">
                      </div>
                      <div class="col-md-3 d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-contact mt-2" style="height:40px; width:85px; display:none;">
                          <i class="fas fa-trash-alt me-1"></i>Remove
                        </button>
                      </div>
                    </div>
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

              <!-- TAB 4: Sputum Monitoring -->
              <div class="tab-pane fade" id="sputum" role="tabpanel">
                <h5 class="mb-4">H. Sputum Monitoring</h5>
                <div class="row mb-2">
                  <div class="col-md-4">
                    <label for="sput_date_collected">Date Collected</label>
                    <input type="date" name="sput_date_collected" class="form-control"
                      max="<?php echo date('Y-m-d'); ?>">
                  </div>
                  <div class="col-md-4">
                    <label for="sput_smear_result">Smear Microscopy/ TB LAMP</label>
                    <input type="text" name="sput_smear_result" class="form-control"
                      placeholder="Smear Microscopy/ TB LAMP">
                  </div>
                  <div class="col-md-4">
                    <label for="sput_xpert_result">Xpert MTB/RIF</label>
                    <input type="text" name="sput_xpert_result" class="form-control" placeholder="Xpert MTB/RIF">
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

              <!-- TAB 5: Chest Xray -->
              <div class="tab-pane fade" id="xray" role="tabpanel">
                <h5 class="mb-4">I. Chest X-ray</h5>
                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="xray_date_examined">Date Examined</label>
                    <input type="date" name="xray_date_examined" class="form-control"
                      max="<?php echo date('Y-m-d'); ?>">
                  </div>
                  <div class="col-md-4">
                    <label for="xray_impression">Impression/ Comparative Reading</label>
                    <select name="xray_impression" class="form-control form-select">
                      <option value="" disabled selected>Select</option>
                      <option value="Normal">Normal</option>
                      <option value="Abnormal suggestive of TB">Abnormal suggestive of TB</option>
                      <option value="Abnormal not suggestive of TB">Abnormal not suggestive of TB</option>
                      <option value="Normal">Improved</option>
                      <option value="Abnormal suggestive of TB">Stable/Unchanged</option>
                      <option value="Abnormal not suggestive of TB">Worsened</option>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label for="xray_descriptive_comment">Descriptive Comments</label>
                    <input type="text" name="xray_descriptive_comment" class="form-control"
                      placeholder="Descriptive Comments">
                  </div>
                </div>

                <!-- <div class="row mb-3">
                    <div class="col-md-4">
                      <label for="out_date_examined"></label>
                      <input type="date" name="out_date_examined" class="form-control" max="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="col-md-4">
                      <label for="out_impression"></label>
                      <select name="out_impression" class="form-control form-select" >
                        <option value="" disabled selected>Select</option>
                        <option value="Normal">Improved</option>
                        <option value="Abnormal suggestive of TB">Stable/Unchanged</option>
                        <option value="Abnormal not suggestive of TB">Worsened</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label for="out_descriptive_comments"></label>
                      <input type="text" name="out_descriptive_comments" class="form-control" placeholder="Descriptive Comments" >
                    </div>
                  </div> -->

                <!-- <div class="row mb-3">
                    <div class="col-md-4">
                      <label for="out_date_examined"></label>
                      <input type="date" name="out_date_examined" class="form-control" max="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="col-md-4">
                      <label for="out_impression"></label>
                      <select name="out_impression" class="form-control form-select" >
                        <option value="" disabled selected>Select</option>
                        <option value="Normal">Improved</option>
                        <option value="Abnormal suggestive of TB">Stable/Unchanged</option>
                        <option value="Abnormal not suggestive of TB">Worsened</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label for="out_descriptive_comments"></label>
                      <input type="text" name="out_descriptive_comments" class="form-control" placeholder="Descriptive Comments" >
                    </div>
                  </div> -->
                <div class="d-flex justify-content-between mt-4">
                  <button type="button" class="btn backBtn prev-tab d-flex align-items-center gap-1">
                  <i class="fas fa-arrow-left"></i> Back
                </button>
                  <button type="button" class="btn backBtn next-tab d-flex align-items-center gap-1">
                  Next <i class="fas fa-arrow-right"></i>
                </button>
                </div>
              </div>

              <!-- TAB 6: Follow Up -->
              <div class="tab-pane fade" id="followup" role="tabpanel">
                <h5 class="mb-4">J. Post Treatment Follow-up</h5>
                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="fol_months_after_tx">Mo. After Tx</label>
                    <input type="text" name="fol_months_after_tx" class="form-control" placeholder="PT">
                  </div>
                  <div class="col-md-4">
                    <label for="fol_date">Date</label>
                    <input type="date" name="fol_date" class="form-control" max="<?php echo date('Y-m-d'); ?>">
                  </div>
                  <div class="col-md-4">
                    <label for="fol_cxr_findings">CXR Findings</label>
                    <input type="text" name="fol_cxr_findings" class="form-control" placeholder="CXR Findings">
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="fol_smear_xpert">Smear/ Xpert</label>
                    <input type="text" name="fol_smear_xpert" class="form-control" placeholder="Smear/ Xpert">
                  </div>
                  <div class="col-md-4">
                    <label for="fol_tbc_dst">TBC & DST</label>
                    <input type="text" name="fol_tbc_dst" class="form-control" placeholder="TBC & DST">
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
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Edit</button>
                  <button type="button" class="btn btn-primary" id="confirmSubmit">Confirm & Submit</button>
                </div>
              </div>
            </div>
          </div>

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

  <script src="{{ url('assets/js/tabs.js') }}"></script>

  <!-- <script src="{{ url('assets/js/disabledBtn.js') }}"></script> -->

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const form = document.getElementById('form');
      const inputs = document.querySelectorAll("input.form-control, select.form-select");

      const setError = (element, message) => {
        let errorDisplay = element.parentElement.querySelector('.error');
        if (!errorDisplay) {
          errorDisplay = document.createElement('div');
          errorDisplay.className = 'error';
          element.parentElement.appendChild(errorDisplay);
        }
        errorDisplay.innerText = message;
        element.classList.add('error');
        element.classList.remove('success');
      };

      const setSuccess = (element) => {
        const errorDisplay = element.parentElement.querySelector('.error');
        if (errorDisplay) errorDisplay.innerText = '';
        element.classList.add('success');
        element.classList.remove('error');
      };

      inputs.forEach(input => {
        const validate = () => {
          const value = input.value.trim();
          const today = new Date();

          // 1️⃣ Empty required fields
          if (input.hasAttribute("required") && value === "") {
            setError(input, "This is required.");
            return;
          }

          // 2️⃣ Age field must be numeric (con_age)
          if (input.name === "con_age" && value !== "") {
            const regex = /^[0-9]+$/;
            if (!regex.test(value)) {
              setError(input, "Age must be a valid number.");
              return;
            }
          }

          // 3️⃣ Special characters check (for other text fields)
          if (input.type === "text" && value !== "" && input.name !== "con_age") {
            const regex = /^[a-zA-Z0-9 ,.\-\/]*$/;
            if (!regex.test(value)) {
              setError(input, "Special characters prohibited.");
              return;
            }
          }

          // 4️⃣ Future date check
          if (input.type === "date" && value !== "") {
            const selectedDate = new Date(value);
            if (selectedDate > today) {
              setError(input, "Enter a valid date.");
              return;
            }
          }

          // ✅ If all validations pass
          if (value !== "") {
            setSuccess(input);
          } else {
            input.classList.remove("success", "error");
            const errorDisplay = input.parentElement.querySelector('.error');
            if (errorDisplay) errorDisplay.innerText = '';
          }
        };

        // Run once on load (for pre-filled values)
        validate();

        // Run on typing or changing
        input.addEventListener("input", validate);
        input.addEventListener("change", validate);

        // 🔒 Restrict "con_age" to digits only during typing
        if (input.name === "con_age") {
          input.addEventListener("input", () => {
            input.value = input.value.replace(/\D/g, ""); // remove non-digits
          });
        }
      });

      // ✅ Preview Modal before final submit
      form.addEventListener("submit", function (e) {
        e.preventDefault(); // stop normal submit

        const p = form; // shortcut to form elements
        let html = `
      <table class="table table-bordered">
        <tbody>
          <tr><th colspan="2" class="bg-light">E. Serious Adverse Events</th></tr>
          <tr><th>Date of AE</th><td>${p.adv_ae_date.value}</td></tr>
          <tr><th>Specific AE</th><td>${p.adv_specific_ae.value}</td></tr>
          <tr><th>Date Reported to FDA</th><td>${p.adv_fda_reported_date.value}</td></tr>

          <tr><th colspan="2" class="bg-light">F. Patient Progress Report Form</th></tr>
          <tr><th>Date</th><td>${p.prog_date.value}</td></tr>
          <tr><th>Problem</th><td>${p.prog_problem.value}</td></tr>
          <tr><th>Action Taken</th><td>${p.prog_action_taken.value}</td></tr>
          <tr><th>Plan</th><td>${p.prog_plan.value}</td></tr>

          <tr><th colspan="2" class="bg-light">G. Close Contacts</th></tr>
          <tr><th>Name</th><td>${p.con_name.value}</td></tr>
          <tr><th>Age</th><td>${p.con_age.value}</td></tr>
          <tr><th>Sex</th><td>${p.con_sex.value}</td></tr>
          <tr><th>Relationship</th><td>${p.con_relationship.value}</td></tr>
          <tr><th>Initial Screening</th><td>${p.con_initial_screening.value}</td></tr>
          <tr><th>Follow-up</th><td>${p.con_follow_up.value}</td></tr>
          <tr><th>Remarks</th><td>${p.con_remarks.value}</td></tr>
        </tbody>
      </table>
    `;

        document.getElementById("previewContent").innerHTML = html;
        let modal = new bootstrap.Modal(document.getElementById("previewModal"));
        modal.show();
      });

      // ✅ Final confirmation → submit form
      document.getElementById("confirmSubmit").addEventListener("click", function () {
        form.submit();
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
  const container = document.getElementById('closeContactContainer');
  const addBtn = document.getElementById('addMoreContact');

  addBtn.addEventListener('click', function () {
    // Clone the first close contact entry
    const firstEntry = container.querySelector('.close-contact-entry');
    const newEntry = firstEntry.cloneNode(true);

    // Clear all input values
    newEntry.querySelectorAll('input, select').forEach(input => input.value = '');

    // Show the remove button for this new entry
    newEntry.querySelector('.remove-contact').style.display = 'block';

    // Append new entry
    container.appendChild(newEntry);

    // Show remove button on previous entries too
    container.querySelectorAll('.remove-contact').forEach((btn, index) => {
      btn.style.display = index === 0 ? 'none' : 'block';
    });
  });

  // Remove close contact entry
  container.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-contact') || e.target.closest('.remove-contact')) {
      const allEntries = container.querySelectorAll('.close-contact-entry');
      if (allEntries.length > 1) {
        e.target.closest('.close-contact-entry').remove();

        // Hide remove button if only one entry left
        if (container.querySelectorAll('.close-contact-entry').length === 1) {
          container.querySelector('.remove-contact').style.display = 'none';
        }
      }
    }
  });
});
</script>

</body>

</html>