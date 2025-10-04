<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>TB DOTS - Patient List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="icon" href="{{ url('assets/img/lungs.png') }}">
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
          <img src="{{ url('assets/img/logout.png') }}" class="menu-icon" alt="">
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
    <h4 style="margin-bottom: 10px; color: #2c3e50; font-weight: 600;">
      Patient List
    </h4>
    <p class="text-muted mb-3">
      You have total {{ $totalPatients }} patients in TB DOTS.
    </p>

    <div class="d-flex justify-content-end mb-2">
      <!-- Add Patient button -->
      <a href="{{ url('form/page1') }}" class="btn btn-success">
        <i class="fas fa-plus me-2"></i>Add New Patient
      </a>
    </div>

    <div class="card shadow-sm border-0">
      <div class="card-body p-0">
        <div class="table-responsive">

          <div class="d-flex justify-content-between align-items-center">
            <!-- Left side: Entries per page -->
            <form method="GET" action="{{ url('patient') }}" class="d-flex">
              <input type="hidden" name="per_page" value="{{ $perPage }}">
              <input type="text" name="search" value="{{ request('search') }}" class="form-control searchBtn me-2"
                placeholder="Search patients...">
              <button type="submit" class="btn btn-secondary search-btn">Search</button>
            </form>

          </div>


          <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Sex</th>
                <th>Age</th>
                <th>Address</th>
                <th>TB Case #</th>
                <th>Date Registered</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($patients as $patient)

                <tr>
                  <td>{{ $patient->id }}</td>
                  <td>{{ $patient->pat_full_name }}</td>
                  <td>{{ $patient->pat_sex }}</td>
                  <td>{{ $patient->pat_age }}</td>
                  <td>{{ $patient->pat_current_address }}</td>
                  <td>{{ $patient->diag_tb_case_no }}</td>
                  <td>{{ \Carbon\Carbon::parse($patient->diag_diagnosis_date)->format('F j, Y') }}</td>
                  <td class="text-center">
                    <div class="dropdown">
                      <button class="btn btn-light btn-sm rounded-circle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end">

                        <!-- View -->
                        <li>
                          <a class="dropdown-item d-flex align-items-center"
                            href="{{ route('admin.patientProfile', $patient->id) }}" title="Patient Details">
                            <i class="fas fa-eye me-2"></i> View Details
                          </a>
                        </li>

                        <!-- Edit -->
                        <li>
                          <a class="dropdown-item d-flex align-items-center"
                            href="{{ route('patients.edit', $patient->id) }}" title="Edit Details">
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

                        <!-- Report -->
                        <li>
                          <a class="dropdown-item d-flex align-items-center" target="_blank"
                            href="{{ route('patient.summary', $patient->id) }}" title="Patient Summary Report">
                            <i class="fas fa-download me-2"></i> Generate Report
                          </a>
                        </li>

                        <!-- Create Patient Account -->
                        <li>
                          <a class="dropdown-item d-flex align-items-center"
                            href="{{ route('patient.account', $patient->id) }}" title="Create Patient Account">
                            <i class="fas fa-user-plus me-2"></i> Create Account
                          </a>
                        </li>

                      </ul>
                    </div>
                  </td>
                </tr>

              @endforeach

            </tbody>
          </table>

        </div>
      </div>

     <div class="card-footer">
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
    
    <!-- Left: showing entries -->
    <div>
      Showing {{ $patients->firstItem() }} to {{ $patients->lastItem() }} of {{ $patients->total() }} entries
    </div>

    <!-- Center: pagination links -->
    <div>
      {{ $patients->appends(['search' => request('search'), 'per_page' => $perPage])->links() }}
    </div>

    <!-- Right: per page dropdown -->
    <form method="GET" action="{{ url('patient') }}" class="d-flex align-items-center">
      <select name="per_page" id="per_page" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
        <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
      </select>
      <span class="ms-2">per page</span>
    </form>
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

</body>

</html>