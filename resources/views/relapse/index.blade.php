<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>TB DOTS - Relapse Cases</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="icon" href="{{ url('assets/img/tbdots-logo-1.png') }}">
  <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
  <style>
    .charts-row {
      display: flex;
      gap: 20px;
    }

    .chart-card {
      flex: 1;
      /* hati sila sa lapad (50/50) */
      min-width: 0;
      /* para hindi mag-overflow */
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.02);
      border: 2px solid #f1f3f4;
    }

    .doughnut-chart-container {
      position: relative;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.02);
      border: 2px solid #f1f3f4;
      height: 350px;
    }

    .chart-container {
      position: relative;
      height: 350px;
      background: linear-gradient(135deg, #fafbfc 0%, #ffffff 100%);
      border-radius: 16px;
      padding: 20px;
      border: 2px solid #f1f3f4;
      box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.02);
    }

    @media (max-width: 768px) {
      .charts-row {
        flex-direction: column;
      }
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
    <h4 style="margin-bottom: 50px; color: #2c3e50; font-weight: 600;">
      Relapse Cases
    </h4>

    <div class="d-flex justify-content-end mb-2">
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPhysicianModal">
        <i class="fas fa-plus me-2"></i>Add Relapse Cases
      </button>

    </div>

    <div class="card shadow-sm border-0">
      <div class="card-body p-0">
        <div class="table-responsive">
          
        

          <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Sex</th>
                <th>Date of Birth</th>
                <th>Contact No</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>

                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="text-center">
                    <div class="dropdown">
                      <button class="btn btn-light btn-sm rounded-circle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end">

                      <!-- View Details -->
                        <li>
                          <a class="dropdown-item d-flex align-items-center btn-view"
                            href="#"
                            data-bs-toggle="modal"
                            data-bs-target="#viewPhysicianModal"
                            title="View Details">
                            <i class="fas fa-eye me-2"></i> View Details
                          </a>
                        </li>

                        <!-- Edit -->
                        <li>
                          <a class="dropdown-item d-flex align-items-center btn-edit"
                            href="#"
                            data-bs-toggle="modal"
                            data-bs-target="#editPhysicianModal"
                            title="Edit Details">
                            <i class="fas fa-edit me-2"></i> Edit
                          </a>
                        </li>


                        <!-- Delete -->
                        <li>
                            <button type="submit" class="dropdown-item d-flex align-items-center btn-delete"
                              title="Delete Patient">
                              <i class="fas fa-trash-alt me-2"></i> Delete
                            </button>
                        </li>
                        
                      </ul>
                    </div>
                  </td>
                  
                </tr>
            </tbody>
          </table>



        </div>
      </div>


    </div>
  </div>



  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->

  <script src="{{ url('assets/js/logout.js') }}"></script>

  <script src="{{ url('assets/js/sidebarToggle.js') }}"></script>

  <script src="{{ url('assets/js/active.js') }}"></script>

  <script src="{{ url('assets/js/rotate-icon.js') }}"></script>

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

  <script>
    document.querySelectorAll('.btn-view').forEach(btn => {
      btn.addEventListener('click', function () {
        document.getElementById('view_first_name').innerText = this.dataset.first_name;
        document.getElementById('view_last_name').innerText = this.dataset.last_name;
        document.getElementById('view_sex').innerText = this.dataset.sex;
        document.getElementById('view_dob').innerText = this.dataset.dob;
        document.getElementById('view_designation').innerText = this.dataset.designation;
        document.getElementById('view_specialty').innerText = this.dataset.specialty;
        document.getElementById('view_contact').innerText = this.dataset.contact;
        document.getElementById('view_email').innerText = this.dataset.email;
        document.getElementById('view_address').innerText = this.dataset.address;
      });
    });
  </script>

    <script>
    document.querySelectorAll('.btn-edit').forEach(btn => {
      btn.addEventListener('click', function () {
        const id = this.dataset.id;
        const form = document.getElementById('editPhysicianForm');

        // dynamically set the form action
        form.action = `/physician/${id}`;

        // fill in the form fields
        document.getElementById('edit_phy_first_name').value = this.dataset.firstname;
        document.getElementById('edit_phy_last_name').value = this.dataset.lastname;
        document.getElementById('edit_phy_sex').value = this.dataset.sex;
        document.getElementById('edit_phy_dob').value = this.dataset.dob;
        document.getElementById('edit_phy_designation').value = this.dataset.designation;
        document.getElementById('edit_phy_specialty').value = this.dataset.specialty;
        document.getElementById('edit_phy_contact').value = this.dataset.contact;
        document.getElementById('edit_phy_email').value = this.dataset.email;
        document.getElementById('edit_phy_address').value = this.dataset.address;
      });
    });
  </script>


</body>

</html>