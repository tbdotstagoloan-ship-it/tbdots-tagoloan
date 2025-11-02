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
      <h4 style="margin-bottom: 10px; color: #2c3e50; font-weight: 600;">
        Quarterly Anatomical Site
      </h4>
      <p class="text-muted mb-3">
        Displays TB cases by anatomical site, summarized per quarter.
      </p>

      <div class="d-flex justify-content-end mb-2 gap-1">
        <a href="{{ route('pdf.quarterly-anatomical-site.pdf') }}" target="_blank" class="btn btn-danger">
          <i class="fas fa-file-pdf me-1"></i> Generate Report
        </a>
      </div>
      
      <div class="card inventory-card shadow-sm border-0">
        <div class="card-body p-0">
          <div class="table-responsive">

          <select id="statusRedirect" class="form-select mb-2" style="width: 210px;">
            <option value="" disabled selected>Select Quarter Report</option>
            <option value="{{ url('quarterly-cases-notification') }}">Cases Notification</option>
            <option value="{{ url('quarterly-tb-classification') }}">TB Disease Classification</option>
            <option value="{{ url('quarterly-anatomical-site') }}">Anatomical Site</option>
            <option value="{{ url('quarterly-treatment-outcome') }}">Treatment Outcome</option>
            </select>

                <table class="table">
              <thead>
                <tr>
                  <th>Year</th>
                  <th>Quarter</th>
                  <th>Pulmonary</th>
                  <th>Extra-pulmonary</th>
                  <th>Total Cases</th>
                </tr>
              </thead>
              <tbody>

              @foreach ($quarterlyAnatomicalSite as $patient)
                
                <tr>
                  <td>{{ $patient->year }}</td>
                  <td>{{ $patient->quarter }}</td>
                  <td>{{ $patient->pulmonary }}</td>
                  <td>{{ $patient->extra }}</td>
                  <td>{{ $patient->total }}</td>
                </tr>

                @endforeach

              </tbody>
            </table>
  
                </div>
              </div>

              <div class="card-footer">Showing {{ $quarterlyAnatomicalSite->firstItem() }} to {{ $quarterlyAnatomicalSite->lastItem() }} of
        {{ $quarterlyAnatomicalSite->total() }} entries
        <div class="mt-2">
          {{ $quarterlyAnatomicalSite->links() }}
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
