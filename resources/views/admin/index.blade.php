<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>TB DOTS - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="icon" href="{{ url('assets/img/lungs.png') }}">
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
    .table-hover tbody tr:hover {
    background-color: #f8f9fa;
    transition: background-color 0.3s ease;
  }

  .badge {
    padding: 0.5em 0.75em;
    font-size: 0.875rem;
  }

  .btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 6px;
  }

  .btn-outline-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
    transition: all 0.3s ease;
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

      <li class="nav-item menu-item" data-tooltip="Physician / Personnel">
        <a href="{{ url('physician') }}">
          <img src="{{ url('assets/img/cross.png') }}" class="menu-icon" alt="">
          <span class="menu-text">Physician / Personnel</span>
          </a>
      </li>

      <li class="menu-item" data-tooltip="Facilities">
        <a href="{{url('facilities')}}">
          <img src="{{ url('assets/img/hospital-facility.png') }}" class="menu-icon" alt="">
          <span class="menu-text">Facilities</span>
        </a>
      </li>

      <li class="menu-item" data-tooltip="Meidication Adherence Flags">
        <!-- make the anchor position-relative and give some right padding (pe-4) -->
        <a href="{{url('medication-adherence-flags')}}" class="d-flex align-items-center position-relative pe-2">
          <img src="{{ url('assets/img/health-report.png') }}" class="menu-icon" alt="">
          <span class="menu-text">Medication Adherence Flags</span>

          @if(!empty($missedAdherenceCount) && $missedAdherenceCount > 0)
            <!-- dot positioned relative to the anchor -->
            <span class="position-absolute top-50 end-0 translate-middle-y me-3 p-1 bg-danger border border-light rounded-circle" 
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
      Dashboard
    </h4>

    <div class="card-grid">
      <!-- Patient -->
      <a href="{{ url('patient') }}" style="text-decoration:none;">
        <div class="card-dashboard patient">
        <div class="card-body">
          <div class="card-info">
            <div class="card-title">Patients</div>
            <div class="card-value">{{ $totalPatients }}</div>
          </div>
          <div class="card-icon">
            <img src="{{ url('assets/img/tbpatient.png') }}" alt="">
          </div>
        </div>
      </div>
      </a>

      <!-- Physician -->
      <a href="{{ url('physician') }}" style="text-decoration: none;">
        <div class="card-dashboard physician">
        <div class="card-body">
          <div class="card-info">
            <div class="card-title">Physician</div>
            <div class="card-value">{{ $totalPhysician }}</div>
          </div>
          <div class="card-icon">
            <img src="{{ url('assets/img/physician.png') }}" alt="">
          </div>
        </div>
      </div>
      </a>

      <!-- Staff -->
      <a href="{{ url('facilities') }}" style="text-decoration: none;">
        <div class="card-dashboard staff">
        <div class="card-body">
          <div class="card-info">
            <div class="card-title">Facilities</div>
            <div class="card-value">{{ $totalFacility }}</div>
          </div>
          <div class="card-icon">
            <img src="{{ url('assets/img/provider.png') }}" alt="">
          </div>
        </div>
      </div>
      </a>

    </div>




    <!-- Charts Row -->
    <div class="charts-row mt-4">

      <!-- Doughnut Chart -->
      <div class="card chart-card">
        <div class="card-body">
          <h5 class="card-title">Anatomical Classification of TB Cases</h5>
          <div class="doughnut-chart-container">
            <canvas id="doughnutChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Bar Chart -->
      <div class="card chart-card">
        <div class="card-body">
          <h5 class="card-title">New TB Patients Enrolled Monthly</h5>
          <div class="chart-container">
            <canvas id="monthlyBarChart"></canvas>
          </div>
        </div>
      </div>

    </div>

    <div class="mt-4">
    <div class="card" style="border-radius: 12px; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.02); border: 2px solid #f1f3f4;">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="card-title mb-0" style="color: #2c3e50; font-weight: 600;">
            <i class="fas fa-exclamation-triangle text-danger me-2"></i>
            Patients with Consecutive Missed Doses
          </h5>
          <span class="badge bg-danger">
            {{ count($patientsWithMissedDoses) }} Patient(s)
          </span>
        </div>

        @if(count($patientsWithMissedDoses) > 0)
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead style="background: linear-gradient(135deg, #fafbfc 0%, #ffffff 100%);">
                <tr>
                  <th scope="col" style="color: #2c3e50; font-weight: 600;">#</th>
                  <th scope="col" style="color: #2c3e50; font-weight: 600;">Patient ID</th>
                  <th scope="col" style="color: #2c3e50; font-weight: 600;">Full Name</th>
                  <th scope="col" style="color: #2c3e50; font-weight: 600;">Contact Number</th>
                  <th scope="col" style="color: #2c3e50; font-weight: 600;">Missed Doses</th>
                  <th scope="col" style="color: #2c3e50; font-weight: 600;">Last Missed</th>
                  <th scope="col" style="color: #2c3e50; font-weight: 600; text-align: center;">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($patientsWithMissedDoses as $index => $patient)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                      <span class="badge bg-secondary">{{ $patient->pat_id }}</span>
                    </td>
                    <td style="font-weight: 500;">
                      {{ $patient->pat_first_name }} 
                      {{ $patient->pat_middle_name ? $patient->pat_middle_name . ' ' : '' }}
                      {{ $patient->pat_last_name }}
                    </td>
                    <td>
                      <i class="fas fa-phone text-muted me-1"></i>
                      {{ $patient->pat_contact_number ?? 'N/A' }}
                    </td>
                    <td>
                      <span class="badge bg-danger rounded-pill">
                        {{ $patient->missed_count }} doses
                      </span>
                    </td>
                    <td>
                      <small class="text-muted">
                        {{ \Carbon\Carbon::parse($patient->last_missed_date)->format('M d, Y') }}
                      </small>
                    </td>
                    <td class="text-center">
                      <a href="{{ url('patient/' . $patient->pat_id) }}" 
                        class="btn btn-sm btn-outline-primary" 
                        title="View Patient Details">
                        <i class="fas fa-eye"></i> View
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="text-center py-5">
            <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
            <p class="mt-3 text-muted">No patients with consecutive missed doses found.</p>
          </div>
        @endif
      </div>
    </div>
  </div>



  </div>



  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script src="{{ url('assets/js/logout.js') }}"></script>

  <script src="{{ url('assets/js/sidebarToggle.js') }}"></script>

  <script src="{{ url('assets/js/active.js') }}"></script>

  <script src="{{ url('assets/js/rotate-icon.js') }}"></script>

  <!-- <script src="{{ url('assets/js/dropdown.js') }}"></script> -->
  <!-- <script src="{{ url('assets/js/script.js') }}"></script> -->



  <script>
    const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
    const doughnutChart = new Chart(ctxDoughnut, {
      type: 'doughnut',
      data: {
        labels: ['Pulmonary', 'Extra-pulmonary'],
        datasets: [{
          label: 'Total',
          data: [
        {{ $pulmonary }},
            {{ $extra }}
          ],
          backgroundColor: [
            'rgba(76, 175, 80, 0.85)',     // Pulmonary - Green (#4CAF50)
            'rgba(255, 222, 0, 0.85)'      // Extra-pulmonary - Yellow (#ffde00)
          ],
          borderColor: [
            'rgba(56, 142, 60, 1)',        // Pulmonary - Dark Green
            'rgba(255, 222, 0, 1)'         // Extra-pulmonary - Yellow border
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { position: 'bottom' }
        }
      }
    });

    document.querySelector('.sidebar-toggle').addEventListener('click', function () {
      document.body.classList.toggle('sidebar-collapsed');
      setTimeout(() => { doughnutChart.resize(); }, 300);
    });
  </script>

  <script>
    const ctxBar = document.getElementById('monthlyBarChart').getContext('2d');
    const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
      'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    fetch('/chart/monthly-patients')
      .then(response => response.json())
      .then(monthlyData => {
        new Chart(ctxBar, {
          type: 'bar',
          data: {
            labels: monthLabels,
            datasets: [{
              label: 'Patients Diagnosed',
              data: monthlyData,
              backgroundColor: 'rgba(76, 175, 80, 0.85)',  // theme green
              borderColor: 'rgba(56, 142, 60, 1)',         // darker green
              borderWidth: 1,
              borderRadius: 6
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: { display: false },
              tooltip: {
                callbacks: {
                  label: function (context) {
                    return `${context.parsed.y} + Patients`;
                  }
                }
              }
            },
            scales: {
              x: {
                grid: { display: false },
                ticks: { font: { size: 13, weight: 'bold' } }
              },
              y: {
                beginAtZero: true,
                ticks: {
                  stepSize: 5 // no decimals, auto step size
                }
              }
            }
          }
        });
      });
  </script>

  @if (session('status') === 'login-success')
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Login Successful',
        text: 'Welcome back, {{ Auth::user()->name }}!',
        showConfirmButton: false,
        timer: 1500
      });
    </script>
  @endif

  @if(session('success'))
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Registration Successful!',
        text: "{{ session('success') }}",
        confirmButtonColor: '#198754',
      });
    </script>
  @endif


</body>

</html>