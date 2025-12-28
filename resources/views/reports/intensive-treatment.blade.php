<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>TB DOTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}" />
    <link rel="icon" href="{{ url('assets/img/tbdots-logo-1.png') }}">
    <style>
      .form-select {
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 10px 15px;
    margin-bottom: 15px;
    transition: border-color 0.3s ease;
    }

    .form-select:focus {
        border-color: #2cc094;
        box-shadow: 0 0 0 0.2rem rgba(25, 118, 210, 0.1);
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
      <h4 style="margin-bottom: 10px; color: #2c3e50; font-weight: 600;">
        Intensive Phase
      </h4>
      <p class="text-muted mb-3">
        Patients currently in the initial intensive phase of TB treatment.
      </p>

      <div class="d-flex justify-content-end align-items-center mb-3 position-relative">
        <div class="dropdown">
          <button class="btn btn-light border-0 shadow-sm rounded-circle d-flex align-items-center justify-content-center" 
                  type="button" data-bs-toggle="dropdown" aria-expanded="false"
                  style="width:40px; height:40px;">
            <i class="fas fa-filter text-secondary"></i>
          </button>

          <div class="dropdown-menu dropdown-menu-end p-4 shadow-lg border-0 rounded-4" style="width: 320px;">
            <h6 class="fw-semibold text-dark mb-3">Filter by Date</h6>
            <form method="GET" action="{{ url('intensive-treatment') }}" class="row g-3">
              <div class="col-12">
                <label class="form-label small text-muted mb-1">Start Date</label>
                <input type="date" class="form-control form-control-sm" id="start_date" name="start_date"
                      value="{{ $startDate ?? '' }}">
              </div>
              <div class="col-12">
                <label class="form-label small text-muted mb-1">End Date</label>
                <input type="date" class="form-control form-control-sm" id="end_date" name="end_date"
                      value="{{ $endDate ?? '' }}">
              </div>
              <div class="col-12 d-flex justify-content-between align-items-center mt-2">
                <a href="{{ url('intensive-treatment') }}" class="btn btn-outline-secondary btn-sm px-3">
                  Reset
                </a>
                <button type="submit" class="btn btn-primary btn-sm px-3">
                  Filter
                </button>
              </div>
            </form>
          </div>
        </div>

        <a href="{{ route('intensive-treatment.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" 
          target="_blank" class="btn btn-danger ms-2 d-flex align-items-center gap-1">
          <i class="fas fa-file-pdf"></i> Generate Report
        </a>
      </div>
      
      <div class="card inventory-card shadow-sm border-0">
        <div class="card-body p-0">
          <div class="table-responsive">

          <select id="statusRedirect" class="form-select mb-2" style="width: 220px;">
            <option value="" disabled selected>Select Treatment</option>
            <option value="{{ url('intensive-treatment') }}">Intensive Phase</option>
            <option value="{{ url('maintenance-treatment') }}">Continuation Phase</option>
          </select>

                <table class="table">
              <thead>
                  <tr>
                      <th>Full Name</th>
                      <th>Drug</th>
                      <th>Tablets</th>
                      <th>Strength</th>
                      <th>Unit</th>
                      <th>Intensive Phase Start</th>
                      <th>Day</th>
                      <th>Intensive Phase End</th>
                      <th>Status</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($intensive as $patient)
                  
                  <tr>
                      <td>{{ $patient->pat_full_name }}</td>
                      <td>{{ $patient->drug_name }}</td>
                      <td>{{ $patient->drug_no_of_tablets }}</td>
                      <td>{{ $patient->drug_strength }}</td>
                      <td>{{ $patient->drug_unit }}</td>
                      <td>{{ \Carbon\Carbon::parse($patient->pha_intensive_start)->format('F j, Y') }}</td>
                      <td>{{ $patient->treatment_day }}</td>
                      <td>{{ \Carbon\Carbon::parse($patient->pha_intensive_end)->format('F j, Y') }}</td>
                      <td><span class="badge bg-warning">{{ $patient->outcome }}</span></td>
                  </tr>
                  @endforeach
              </tbody>
          </table>

  
                </div>
              </div>
              <div class="card-footer">Showing {{ $intensive->firstItem() }} to {{ $intensive->lastItem() }} of
        {{ $intensive->total() }} entries
        <div class="mt-2">
          {{ $intensive->links() }}
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

    <script>
      document.getElementById("statusRedirect").addEventListener("change", function() {
        if (this.value) {
          window.location.href = this.value;
        }
      });
    </script>
    
  </body>
</html>
