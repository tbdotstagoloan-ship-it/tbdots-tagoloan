<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>TB DOTS - Facilities</title>
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
      min-width: 0;
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
    <h4 style="margin-bottom: 50px; color: #2c3e50; font-weight: 600;">
        Facilities Management
    </h4>

    <div class="d-flex justify-content-end mb-2">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addFacilityModal">
            <i class="fas fa-plus me-2"></i>Add New Facility
        </button>
    </div>


    <div class="card shadow-sm border-0">
      <div class="card-body p-0">
        <div class="table-responsive">

        <form method="GET" action="{{ url('facilities') }}" class="d-flex align-items-center">
            <select name="per_page" id="per_page" class="form-select form-select-sm w-auto"
              onchange="this.form.submit()">
              <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
              <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
              <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
              <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
              <option value="250" {{ $perPage == 250 ? 'selected' : '' }}>250</option>
              <option value="500" {{ $perPage == 500 ? 'selected' : '' }}>500</option>
            </select>
            <span class="ms-2">entries</span>
          </form>

          <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Facility Name</th>
                <th>NTP Facility Code</th>
                <th>Province</th>
                <th>Region</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>

                @foreach ($facilities as $facility)

                <tr>
                  <td>{{ $facility->id }}</td>
                  <td>{{ $facility->fac_name }}</td>
                  <td>{{ $facility->fac_ntp_code }}</td>
                  <td>{{ $facility->fac_province }}</td>
                  <td>{{ $facility->fac_region }}</td>
                  <td class="text-center">
                    <div class="dropdown">
                      <button class="btn btn-light btn-sm rounded-circle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end">

                        <!-- Edit Button -->
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal"
                            data-bs-target="#editFacilityModal{{ $facility->id }}" title="Edit Details">
                            <i class="fas fa-edit me-2"></i> Edit
                            </a>
                        </li>

                        <!-- Delete Button -->
                        <li>
                            <form action="{{ route('facilities.destroy', $facility->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item d-flex align-items-center btn-delete">
                                <i class="fas fa-trash-alt me-2"></i> Delete
                            </button>
                            </form>
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

      <div class="card-footer">Showing {{ $facilities->firstItem() }} to {{ $facilities->lastItem() }} of
        {{ $facilities->total() }} entries
        <div class="mt-2">
          {{ $facilities->links() }}
        </div>
      </div>

    </div>
  </div>

  <!-- Add New Facility Modal (moved outside the loop) -->
  <div class="modal fade" id="addFacilityModal" tabindex="-1" aria-labelledby="addFacilityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-3 shadow-lg border-0">
        <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="addFacilityModalLabel">
             Add New Facility
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="{{ route('facilities.store') }}" method="POST">
            @csrf
            <div class="modal-body">
            <div class="row g-3">
                <!-- Facility Name -->
                <div class="col-md-6">
                <label for="fac_name" class="form-label">Facility Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="fac_name" id="fac_name" placeholder="Facility Name" required>
                </div>

                <!-- NTP Code -->
                <div class="col-md-6">
                <label for="fac_ntp_code" class="form-label">NTP Facility Code <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="fac_ntp_code" id="fac_ntp_code" placeholder="NTP Facility Code" required>
                </div>

                <!-- Region -->
                <div class="col-md-6">
                  <label for="fac_region" class="form-label">Region</label>
                  <select id="fac_region" class="form-control form-select" required>
                    <option value="" disabled selected>Select</option>
                  </select>
                  <input type="hidden" name="fac_region" id="fac_region_text">
                </div>

                <!-- Province -->
                <div class="col-md-6">
                  <label for="fac_province" class="form-label">Province / HUC</label>
                  <select id="fac_province" class="form-control form-select" required>
                    <option value="" disabled selected>Select</option>
                  </select>
                  <input type="hidden" name="fac_province" id="fac_province_text">
                </div>

            </div>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success">
                Submit
            </button>
            </div>
        </form>
        </div>
    </div>
  </div>
  <!-- End of Add New Facility Modal -->

  <!-- Edit Modals (moved outside the loop) -->
  @foreach ($facilities as $facility)
  <div class="modal fade" id="editFacilityModal{{ $facility->id }}" tabindex="-1" aria-labelledby="editFacilityModalLabel{{ $facility->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-3 shadow-lg border-0">
        <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="editFacilityModalLabel{{ $facility->id }}">
            Edit Facility
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="{{ route('facilities.update', $facility->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
            <div class="row g-3">
                <!-- Facility Name -->
                <div class="col-md-6">
                <label for="fac_name_{{ $facility->id }}" class="form-label">Facility Name</label>
                <input type="text" class="form-control" name="fac_name" id="fac_name_{{ $facility->id }}" value="{{ $facility->fac_name }}" required>
                </div>

                <!-- NTP Code -->
                <div class="col-md-6">
                <label for="fac_ntp_code_{{ $facility->id }}" class="form-label">NTP Facility Code</label>
                <input type="text" class="form-control" name="fac_ntp_code" id="fac_ntp_code_{{ $facility->id }}" value="{{ $facility->fac_ntp_code }}" required>
                </div>

                <!-- Province -->
                <div class="col-md-6">
                <label for="fac_province_{{ $facility->id }}" class="form-label">Province / HUC</label>
                <input type="text" class="form-control" name="fac_province" id="fac_province_{{ $facility->id }}" value="{{ $facility->fac_province }}" required>
                </div>

                <!-- Region -->
                <div class="col-md-6">
                <label for="fac_region_{{ $facility->id }}" class="form-label">Region</label>
                <input type="text" class="form-control" name="fac_region" id="fac_region_{{ $facility->id }}" value="{{ $facility->fac_region }}" required>
                </div>
            </div>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success">Save Changes</button>
            </div>
        </form>
        </div>
    </div>
  </div>
  @endforeach
  <!-- End of Edit Modals -->



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
          text: "This facility will be permanently deleted!",
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
    document.addEventListener("DOMContentLoaded", function () {
      const facRegion = document.getElementById("fac_region");
      const facProvince = document.getElementById("fac_province");
      const facRegionText = document.getElementById("fac_region_text");
      const facProvinceText = document.getElementById("fac_province_text");

      // --- Load Regions ---
      fetch("/api/regions")
        .then(res => res.json())
        .then(data => {
          data.forEach(region => {
            facRegion.innerHTML += `<option value="${region.regCode}">${region.regDesc}</option>`;
          });
        });

      // --- When Region changes, load Provinces ---
      facRegion.addEventListener("change", () => {
        const regionCode = facRegion.value;
        const regionName = facRegion.options[facRegion.selectedIndex].text;

        facRegionText.value = regionName; // Store selected text
        facProvince.innerHTML = '<option value="" disabled selected>Loading...</option>';

        fetch(`/api/provinces/${regionCode}`)
          .then(res => res.json())
          .then(data => {
            facProvince.innerHTML = '<option value="" disabled selected>Select</option>';
            data.forEach(prov => {
              facProvince.innerHTML += `<option value="${prov.provCode}">${prov.provDesc}</option>`;
            });
          });
      });

      // --- When Province changes, store province name ---
      facProvince.addEventListener("change", () => {
        const provinceName = facProvince.options[facProvince.selectedIndex].text;
        facProvinceText.value = provinceName;
      });
    });
  </script>

</body>

</html>