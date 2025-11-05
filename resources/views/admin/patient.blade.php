<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>TB DOTS - Patient List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="icon" href="{{ url('assets/img/tbdots-logo-1.png') }}">
  <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
  <style>
    /* Make search input and button same height */
    .search-input,
    .search-btn {
      height: 40px;
      /* fixed equal height */
      font-size: 0.875rem;
      /* smaller font */
      padding: 0 12px;
      /* balance spacing */
      display: flex;
      align-items: center;
    }

    .searchBtn {
      height: 40px;
      border-radius: 12px;
    }

    .perPage {
      height: 35px;
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
          <span class="menu-text">Medication Adherence</span>

          @if(!empty($missedAdherenceCount) && $missedAdherenceCount > 0)
            <!-- dot positioned relative to the anchor -->
            <span class="position-absolute top-50 end-0 translate-middle-y me-4 p-1 bg-danger border border-light rounded-circle" 
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
    <div style="margin-bottom: 50px;">
      <h4 style="color: #2c3e50; font-weight: 600;">
      New Cases
    </h4>
    <p class="text-muted mb-3">
      You have total {{ $totalPatients }} patients in TB DOTS.
    </p>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-2">

      <form method="GET" action="{{ url('patient') }}" class="d-flex">
        <input type="hidden" name="per_page" value="{{ $perPage }}">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control searchBtn me-2"
            placeholder="Search patients...">
          <button type="submit" class="btn btn-secondary search-btn">Search</button>
      </form>

      <!-- Add Patient button -->
      <a href="{{ url('form/page1') }}" class="btn btn-success">
        <i class="fas fa-plus me-2"></i>Add New Patient
      </a>
    </div>

    <div class="card shadow-sm border-0">
      <div class="card-body p-0">
        <div class="table-responsive">

          <div class="d-flex justify-content-between align-items-center">

          <form method="GET" action="{{ url('patient') }}" class="d-flex align-items-center">
            <select name="per_page" id="per_page" class="form-select form-select-sm w-auto"
              onchange="this.form.submit()">
              <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
              <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
              <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
              <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
              <option value="250" {{ $perPage == 250 ? 'selected' : '' }}>250</option>
              <option value="500" {{ $perPage == 500 ? 'selected' : '' }}>500</option>
            </select>
            <span class="ms-2"></span>
          </form>

          </div>


          <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Sex</th>
                <th>Age</th>
                <th>Barangay</th>
                <th>TB Case No</th>
                <th>Date Registered</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($patients as $patient)
                <tr>
                  <td>{{ $patient->id }}</td>
                  <td>
                    <a href="{{ url('admin/patient-profile/' . $patient->id) }}" 
                      style="text-decoration: none; color: #212529;">
                        {{ $patient->pat_full_name }}
                    </a>
                </td>
                  <td>{{ $patient->pat_sex }}</td>
                  <td>{{ $patient->pat_age }}</td>
                  <td>{{ $patient->pat_current_address }}</td>
                  <td>{{ $patient->diag_tb_case_no }}</td>
                  <td>{{ \Carbon\Carbon::parse($patient->diag_diagnosis_date)->format('F j, Y') }}</td>
                  <td>
                      @php
                          $status = strtolower($patient->status);
                          $badgeClass = match($status) {
                              'ongoing' => 'bg-warning text-dark',
                              'cured' => 'bg-success',
                              'treatment completed' => 'bg-success',
                              'lost to follow-up' => 'bg-secondary',
                              'died' => 'bg-danger',
                              'relapse' => 'bg-warning text-dark',
                              default => 'bg-secondary'
                          };
                      @endphp

                      <span class="status-badge badge {{ $badgeClass }}">{{ ucfirst($patient->status) }}</span>
                  </td>

                  <td class="text-center">
                    <div class="dropdown">
                      <button class="btn btn-light btn-sm rounded-circle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end">
                        <!-- View -->
                        <li>
                          <a class="dropdown-item d-flex align-items-center btn-view-details"
                            href="{{ route('admin.patientProfile', $patient->id) }}"
                            title="Patient Details">
                            <i class="fas fa-eye me-2"></i> View Details
                          </a>

                        </li>

                        <!-- Edit -->
                        <li>
                          <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal"
                            data-bs-target="#editPatientModal{{ $patient->id }}" title="Edit Details">
                            <i class="fas fa-edit me-2"></i> Edit
                          </a>
                        </li>

                        <!-- Delete -->
                        <li>
                          <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item d-flex align-items-center btn-delete"
                              title="Delete Patient">
                              <i class="fas fa-trash-alt me-2"></i> Delete
                            </button>
                          </form>
                        </li>

                        <!-- Create Patient Account -->
                        <li>
                          <a class="dropdown-item d-flex align-items-center"
                            href="{{ route('patient.account', $patient->id) }}" title="Create Patient Account">
                            <i class="fas fa-user-plus me-2"></i> Create Account
                          </a>
                        </li>

                        <!-- Report -->
                        <li>
                          <a class="dropdown-item d-flex align-items-center" target="_blank"
                            href="{{ route('patient.summary', $patient->id) }}" title="Patient Summary Report">
                            <i class="fas fa-download me-2"></i> Generate Report
                          </a>
                        </li>
                        
                      </ul>
                    </div>
                  </td>
                </tr>

                <!-- Edit Patient Modal - MOVED INSIDE THE LOOP -->
                <div class="modal fade" id="editPatientModal{{ $patient->id }}" tabindex="-1"
                  aria-labelledby="editPatientModalLabel{{ $patient->id }}" aria-hidden="true">
                  <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                      <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="editPatientModalLabel{{ $patient->id }}">Update Patient Information
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form action="{{ route('patients.update', $patient->id) }}" method="POST"
                          id="editPatientForm{{ $patient->id }}">
                          @csrf
                          @method('PUT')

                          <div class="row mb-3">
                            <div class="col-md-4">
                              <label for="pat_full_name{{ $patient->id }}" class="form-label">Patient's Full Name</label>
                              <input type="text" name="pat_full_name" id="pat_full_name{{ $patient->id }}"
                                class="form-control" value="{{ $patient->pat_full_name ?? '' }}" required>
                            </div>
                            <div class="col-md-2">
                              <label for="pat_date_of_birth{{ $patient->id }}" class="form-label">Date of Birth</label>
                              <input type="date" name="pat_date_of_birth" id="pat_date_of_birth{{ $patient->id }}"
                                class="form-control" value="{{ $patient->pat_date_of_birth ?? '' }}" max="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-2">
                              <label for="pat_age{{ $patient->id }}" class="form-label">Age</label>
                              <input type="text" name="pat_age" id="pat_age{{ $patient->id }}" class="form-control"
                                value="{{ $patient->pat_age ?? '' }}" readonly>
                            </div>
                            <div class="col-md-2">
                              <label for="pat_sex{{ $patient->id }}" class="form-label">Sex</label>
                              <select name="pat_sex" id="pat_sex{{ $patient->id }}" class="form-control form-select"
                                required>
                                <option disabled {{ empty($patient->pat_sex) ? 'selected' : '' }}>Select</option>
                                @foreach (["Male", "Female"] as $sex)
                                  <option value="{{ $sex }}" {{ isset($patient->pat_sex) && $patient->pat_sex == $sex ? 'selected' : '' }}>
                                    {{ $sex }}
                                  </option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-md-2">
                              <label for="pat_civil_status{{ $patient->id }}" class="form-label">Civil Status</label>
                              <select name="pat_civil_status" id="pat_civil_status{{ $patient->id }}"
                                class="form-control form-select" required>
                                <option disabled {{ empty($patient->pat_civil_status) ? 'selected' : '' }}>Select</option>
                                @foreach (["Single", "Married", "Divorced"] as $status)
                                  <option value="{{ $status }}" {{ isset($patient->pat_civil_status) && $patient->pat_civil_status == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                  </option>
                                @endforeach
                              </select>
                            </div>
                          </div>

                          <!-- <div class="row mb-3">
                            <div class="col-md-4">
                              <label for="pat_permanent_region{{ $patient->id }}" class="form-label">Region</label>
                              <input type="text" name="pat_permanent_region" id="pat_permanent_region{{ $patient->id }}"
                                class="form-control" value="{{ $patient->pat_permanent_region ?? '' }}">
                            </div>
                            <div class="col-md-4">
                              <label for="pat_permanent_province{{ $patient->id }}" class="form-label">Province</label>
                              <input type="text" name="pat_permanent_province"
                                id="pat_permanent_province{{ $patient->id }}" class="form-control"
                                value="{{ $patient->pat_permanent_province ?? '' }}">
                            </div>
                            <div class="col-md-4">
                              <label for="pat_permanent_city_mun{{ $patient->id }}" class="form-label">City/
                                Municipality</label>
                              <input type="text" name="pat_permanent_city_mun"
                                id="pat_permanent_city_mun{{ $patient->id }}" class="form-control"
                                value="{{ $patient->pat_permanent_city_mun ?? '' }}">
                            </div>
                            
                          </div> -->

                          <!-- <div class="row mb-3">
                            <div class="col-md-4">
                              <label for="pat_permanent_address{{ $patient->id }}" class="form-label">Barangay</label>
                              <input type="text" name="pat_permanent_address" id="pat_permanent_address{{ $patient->id }}"
                                class="form-control" value="{{ $patient->pat_permanent_address ?? '' }}">
                            </div>
                            <div class="col-md-4">
                              <label for="pat_permanent_zip_code{{ $patient->id }}" class="form-label">Zip Code</label>
                              <input type="text" name="pat_permanent_zip_code"
                                id="pat_permanent_zip_code{{ $patient->id }}" class="form-control"
                                value="{{ $patient->pat_permanent_zip_code ?? '' }}">
                            </div>
                          </div> -->

                          <div class="row mb-3">
                            <div class="col-md-4">
                              <label for="pat_current_region{{ $patient->id }}" class="form-label">Region</label>
                              <input type="text" name="pat_current_region" id="pat_current_region{{ $patient->id }}"
                                class="form-control" value="{{ $patient->pat_current_region ?? '' }}">
                            </div>
                            <div class="col-md-4">
                              <label for="pat_current_province{{ $patient->id }}" class="form-label">Province</label>
                              <input type="text" name="pat_current_province" id="pat_current_province{{ $patient->id }}"
                                class="form-control" value="{{ $patient->pat_current_province ?? '' }}">
                            </div>
                            <div class="col-md-4">
                              <label for="pat_current_city_mun{{ $patient->id }}" class="form-label">City/
                                Municipality</label>
                              <input type="text" name="pat_current_city_mun" id="pat_current_city_mun{{ $patient->id }}"
                                class="form-control" value="{{ $patient->pat_current_city_mun ?? '' }}">
                            </div>

                          </div>

                          <div class="row mb-3">
                            <div class="col-md-4">
                              <label for="pat_current_address{{ $patient->id }}" class="form-label">Barangay</label>
                              <input type="text" name="pat_current_address" id="pat_current_address{{ $patient->id }}"
                                class="form-control" value="{{ $patient->pat_current_address ?? '' }}">
                            </div>
                            <div class="col-md-4">
                              <label for="pat_current_zip_code{{ $patient->id }}" class="form-label">Zip Code</label>
                              <input type="text" name="pat_current_zip_code" id="pat_current_zip_code{{ $patient->id }}"
                                class="form-control" value="{{ $patient->pat_current_zip_code ?? '' }}">
                            </div>
                            <div class="col-md-4">
                              <label for="pat_contact_number{{ $patient->id }}" class="form-label">Contact Number</label>
                              <input type="text" name="pat_contact_number" id="pat_contact_number{{ $patient->id }}"
                                class="form-control" value="{{ $patient->pat_contact_number ?? '' }}">
                            </div>
                          </div>

                          <div class="row mb-3">
                            <div class="col-md-4">
                              <label for="pat_other_contact{{ $patient->id }}" class="form-label">Other Contact
                                Information</label>
                              <input type="text" name="pat_other_contact" id="pat_other_contact{{ $patient->id }}"
                                class="form-control" value="{{ $patient->pat_other_contact ?? '' }}">
                            </div>
                            <div class="col-md-4">
                              <label for="pat_philhealth_no{{ $patient->id }}" class="form-label">PhilHealth No.</label>
                              <input type="text" name="pat_philhealth_no" id="pat_philhealth_no{{ $patient->id }}"
                                class="form-control" value="{{ $patient->pat_philhealth_no ?? '' }}">
                            </div>
                            <div class="col-md-4">
                              <label for="pat_nationality{{ $patient->id }}" class="form-label">Nationality</label>
                              <input type="text" name="pat_nationality" id="pat_nationality{{ $patient->id }}"
                                class="form-control" value="{{ $patient->pat_nationality ?? '' }}">
                            </div>
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" form="editPatientForm{{ $patient->id }}"
                          class="btn btn-success">Update</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End of Modal -->

              @endforeach
            </tbody>
          </table>

        </div>
      </div>

      

      <div class="card-footer">Showing {{ $patients->firstItem() }} to {{ $patients->lastItem() }} of
        {{ $patients->total() }} entries
        <div class="mt-2">
          {{ $patients->links() }}
        </div>
      </div>




    </div>
  </div>



  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="{{ url('assets/js/sidebarToggle.js') }}"></script>

  <script src="{{ url('assets/js/logout.js') }}"></script>

  <script src="{{ url('assets/js/active.js') }}"></script>

  <script src="{{ url('assets/js/rotate-icon.js') }}"></script>

  <!-- <script src="{{ url('assets/js/dropdown.js') }}"></script> -->
  <!-- <script src="{{ url('assets/js/script.js') }}"></script> -->


  <script>
    document.querySelectorAll('.btn-delete').forEach(button => {
      button.addEventListener('click', function (e) {
        e.preventDefault();
        let form = this.closest('form');

        Swal.fire({
          title: "Are you sure?",
          text: "This patient will be permanently deleted!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#d33",
          cancelButtonColor: "#6c757d",
          confirmButtonText: "Yes, delete it!"
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });
  </script>

  @if(session('success'))
    <script>
      Swal.fire({
        title: 'Success!',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonColor: '#198754',
      });
    </script>
  @endif

  @if($errors->any())
    <script>
      Swal.fire({
        title: 'Error!',
        text: "{{ implode(', ', $errors->all()) }}",
        icon: 'error',
        confirmButtonText: 'Try Again'
      });
    </script>
  @endif

  <script>
document.addEventListener('DOMContentLoaded', function() {
  // Find all date of birth inputs
  const dobInputs = document.querySelectorAll('input[name="pat_date_of_birth"]');
  
  dobInputs.forEach(function(dobInput) {
    dobInput.addEventListener('change', function() {
      const inputId = this.id;
      const patientId = inputId.replace('pat_date_of_birth', '');
      const ageInput = document.getElementById('pat_age' + patientId);

      if (this.value && ageInput) {
        const birthDate = new Date(this.value);
        const today = new Date();

        // Compute total years
        let years = today.getFullYear() - birthDate.getFullYear();
        let months = today.getMonth() - birthDate.getMonth();

        // Adjust for months/days
        if (today.getDate() < birthDate.getDate()) {
          months--;
        }
        if (months < 0) {
          years--;
          months += 12;
        }

        // Format display with proper singular/plural
        let formattedAge = `${years} year${years === 1 ? '' : 's'}`;
        if (months > 0) {
          formattedAge += ` ${months} month${months === 1 ? '' : 's'}`;
        }

        // Update the input (readonly text)
        ageInput.value = formattedAge;
      }
    });
  });
});
</script>



</body>

</html>