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
      Dashboard
    </h4>

    <div class="card-grid">
  <!-- Patient -->
  <div class="card-dashboard patient">
    <div class="card-body">
      <div class="card-info">
        <div class="card-title">Patients</div>
        <div class="card-value">{{ $totalPatients }}</div>
      </div>
      <div class="card-icon">
        <img src="{{ url('assets/img/patienttb.png') }}" alt="">
      </div>
    </div>
  </div>

  <!-- Physician -->
  <div class="card-dashboard physician">
    <div class="card-body">
      <div class="card-info">
        <div class="card-title">Physician</div>
        <div class="card-value">{{ $totalPhysician }}</div>
      </div>
      <div class="card-icon">
        <img src="{{ url('assets/img/doctor.png') }}" alt="">
      </div>
    </div>
  </div>

  <!-- Staff -->
  <div class="card-dashboard staff">
    <div class="card-body">
      <div class="card-info">
        <div class="card-title">Staff</div>
        <div class="card-value">{{ $totalStaff }}</div>
      </div>
      <div class="card-icon">
        <img src="{{ url('assets/img/psychiatrist.png') }}" alt="">
      </div>
    </div>
  </div>
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