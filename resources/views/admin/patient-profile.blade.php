<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TB DOTS - Patient Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}" />
    <link rel="icon" href="{{ url('assets/img/tbdots-logo-1.png') }}">
    <style>
        .page-content {
            background: white;
            padding: 20px 30px;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
            position: sticky;
            top: 24px;
            z-index: 100;
        }

        .page-title {
            font-size: 28px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 20px;
        }

        /* Navigation Tabs */
        .custom-tabs {
            display: flex;
            border-bottom: 2px solid #e2e8f0;
            gap: 20px;
        }

        .nav-tab {
            background: none;
            border: none;
            padding: 10px 12px;
            font-size: 16px;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 3px solid transparent;
            font-weight: 500;
            cursor: pointer;
            transition: 0.1s ease;
        }

        .nav-tab i {
            font-size: 20px;
        }

        .nav-tab.active {
            color: #18a678;
            border-bottom-color: #18a678;
            font-weight: 600;
        }

        .nav-tab.active i {
            color: #18a678;
        }

        .nav-tab:hover {
            color: #18a678;
        }


        .info-section {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .info-item {
            display: flex;
            padding: 12px 0;
            /* border-bottom: 1px solid #f1f5f9; */
        }

        .info-label {
            color: #636e72;
            width: 140px;
            flex-shrink: 0;
        }

        .info-value {
            color: #475569;
            font-weight: 500;
            flex: 1;
        }



        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            .floating-actions {
                right: 15px;
                padding: 10px 5px;
            }

            .action-btn {
                width: 40px;
                height: 40px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .nav-tabs {
                overflow-x: auto;
                white-space: nowrap;
            }

            .nav-tab {
                flex-shrink: 0;
            }
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Medication Adherence Calendar Styles */
        .adherence-calendar-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e7eb;
            margin-top: 20px;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }

        .adherence-calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e2e8f0;
        }

        .adherence-calendar-title {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
        }

        .adherence-calendar-nav {
            display: flex;
            gap: 8px;
        }

        .adherence-nav-btn {
            background: #f8fafc;
            border: 1px solid #d1d5db;
            width: 36px;
            height: 36px;
            border-radius: 6px;
            color: #475569;
            transition: 0.2s ease;
        }

        .adherence-nav-btn:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        /* Calendar grid */
        .adherence-calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 6px;
            max-width: 700px;
            margin: 0 auto;
        }

        .adherence-day-header {
            text-align: center;
            padding: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
        }

        .adherence-calendar-day {
            width: 100%;
            aspect-ratio: 1 / 1;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            background: #fff;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #1e293b;
            transition: 0.2s ease;
            cursor: pointer;
        }

        .adherence-calendar-day span {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #1e293b;
        }

        .adherence-calendar-day:hover {
            background: #f9fafb;
        }

        .adherence-calendar-day.adherence-taken {
            background: #ecfdf5;
            color: #047857;
            border-color: #a7f3d0;
        }

        .adherence-calendar-day.adherence-missed {
            background: #fef2f2;
            color: #b91c1c;
            border-color: #fecaca;
        }

        .adherence-calendar-day.adherence-empty {
            background: transparent;
            border: none;
            cursor: default;
        }

        .adherence-status-icon {
            position: absolute;
            bottom: 5px;
            font-size: 11px;
            opacity: 0.9;
        }

        /* Stats */
        .adherence-stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-top: 32px;
        }

        .adherence-stat-card {
            background: #f9fafb;
            padding: 16px 20px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            text-align: center;
        }

        .adherence-stat-label {
            font-size: 13px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 500;
        }

        .adherence-stat-value {
            font-size: 24px;
            font-weight: 600;
            color: #1e293b;
            margin-top: 6px;
        }

        .adherence-stat-success .adherence-stat-value {
            color: #15803d;
        }

        .adherence-stat-danger .adherence-stat-value {
            color: #b91c1c;
        }

        /* Legend */
        .adherence-legend-container {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .adherence-legend {
            display: flex;
            justify-content: center;
            gap: 24px;
            flex-wrap: wrap;
        }

        .adherence-legend-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #475569;
        }

        .adherence-legend-indicator {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .adherence-legend-indicator.adherence-taken {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
        }

        .adherence-legend-indicator.adherence-missed {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .adherence-calendar-card {
                padding: 20px;
            }

            .adherence-calendar-title {
                font-size: 18px;
            }

            .adherence-calendar-grid {
                gap: 4px;
            }

            .adherence-legend {
                flex-direction: column;
                align-items: center;
            }
        }

        /* Modal Styles */
.adherence-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.adherence-modal-content {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    max-width: 400px;
    width: 90%;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

.adherence-modal-btn {
    min-width: 100px;
    padding: 0.75rem 1.5rem;
}

.adherence-calendar-day:not(.adherence-empty):not(.adherence-future):hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.adherence-future {
    cursor: not-allowed !important;
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
                <a href="{{url('medication-adherence-flags')}}"
                    class="d-flex align-items-center position-relative pe-4">
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
                    <li><a href="{{ url('barangay-cases-notification') }}" class="nav-link">Barangay Cases
                            Notification</a></li>
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

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title">
                <span class="text-muted">Patient</span>
                <span class="mx-2 text-secondary">›</span>
                <span class="fw-bold" style="color: #059669; font-size: 1.5rem;">
                    {{ $patient->pat_full_name }}
                </span>
            </h1>

            <!-- <a href="{{ url('patient') }}" class="btn btn-secondary backBtn">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a> -->
            @php
                $latestOutcome = $patient->treatmentOutcomes()->latest('created_at')->first();
            @endphp

            @if ($latestOutcome && in_array(strtolower($latestOutcome->out_outcome), ['cured', 'treatment completed', 'lost to follow up']))
                <a href="javascript:void(0);" class="btn btn-warning btn-relapse"
                    data-url="{{ route('relapse.page1', $patient->id) }}">
                    <i class="fas fa-arrows-rotate me-2"></i>Re-register <b>(Relapse)</b>
                </a>
            @endif



        </div>

        <div class="page-content">

            <div class="nav-tabs custom-tabs">
                <button class="nav-tab active" onclick="switchTab(this, 'personal')">
                    <img src="{{ url('assets/img/patient-profile.png') }}" class="menu-icons" alt="">
                    <span>Patient Profile</span>
                </button>
                <button class="nav-tab" onclick="switchTab(this, 'diagnosis')">
                    <img src="{{ url('assets/img/diagnosis.png') }}" class="menu-icons" alt="">
                    <span>Diagnosis</span>
                </button>
                <button class="nav-tab" onclick="switchTab(this, 'treatment')">
                    <img src="{{ url('assets/img/treatment.png') }}" class="menu-icons" alt="">
                    <span>Treatment Information</span>
                </button>
                <button class="nav-tab" onclick="switchTab(this, 'lab')">
                    <img src="{{ url('assets/img/check-up.png') }}" class="menu-icons" alt="">
                    <span>Follow Ups</span>
                </button>
                <button class="nav-tab" onclick="switchTab(this, 'adherence')">
                    <img src="{{ url('assets/img/schedule.png') }}" class="menu-icons" alt="">
                    <span>Monitoring</span>
                </button>
            </div>


            <!-- Patient Profile Tab -->
            <div id="personal-tab" class="tab-content active" style="margin-top: 30px;">

                <div class="info-section card p-3 shadow-sm border-0 rounded-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-bold mb-1">Diagnosing Facility</h5>
                            <p class="text-muted small mb-0">
                                Information about the facility where the diagnosis was conducted.
                            </p>
                        </div>
                    </div>

                    @if ($patient->diagnosingFacility)
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Facility Name</th>
                                        <th>NTP Facility Code</th>
                                        <th>Province</th>
                                        <th>Region</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $patient->diagnosingFacility->fac_name ?? '—' }}</td>
                                        <td>{{ $patient->diagnosingFacility->fac_ntp_code ?? '—' }}</td>
                                        <td>{{ $patient->diagnosingFacility->fac_province ?? '—' }}</td>
                                        <td>{{ $patient->diagnosingFacility->fac_region ?? '—' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted fst-italic mt-2">
                            No diagnosing facility information recorded for this patient.
                        </p>
                    @endif
                </div>


                <div class="info-section card p-3 shadow-sm border-0 rounded-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-bold mb-1">Patient Demographic</h5>
                            <p class="text-muted small mb-0">
                                Basic information, contact details, and address of the patient.
                            </p>
                        </div>
                    </div>

                    {{-- Personal Information --}}
                    <div class="table-responsive mb-4">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Date of Birth</th>
                                    <th>Age</th>
                                    <th>Sex</th>
                                    <th>Civil Status</th>
                                    <th>Nationality</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $patient->pat_full_name ?? '—' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($patient->pat_date_of_birth)->format('F j, Y') ?? '—' }}
                                    </td>
                                    <td>{{ $patient->pat_age ?? '—' }}</td>
                                    <td>{{ $patient->pat_sex ?? '—' }}</td>
                                    <td>{{ $patient->pat_civil_status ?? '—' }}</td>
                                    <td>{{ $patient->pat_nationality ?? '—' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Contact Information --}}
                    <div class="table-responsive mb-4">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Contact Number</th>
                                    <th>Other Contact Info</th>
                                    <th>PhilHealth No</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $patient->pat_contact_number ?? '—' }}</td>
                                    <td>{{ $patient->pat_other_contact ?? '—' }}</td>
                                    <td>{{ $patient->pat_philhealth_no ?? '—' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Permanent Address --}}
                    <small class="fw-semibold mt-3">Permanent Address</small>
                    <div class="table-responsive mb-4">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Street/Barangay</th>
                                    <th>City/Municipality</th>
                                    <th>Province</th>
                                    <th>Region</th>
                                    <th>Zip Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $patient->pat_permanent_address ?? '—' }}</td>
                                    <td>{{ $patient->pat_permanent_city_mun ?? '—' }}</td>
                                    <td>{{ $patient->pat_permanent_province ?? '—' }}</td>
                                    <td>{{ $patient->pat_permanent_region ?? '—' }}</td>
                                    <td>{{ $patient->pat_permanent_zip_code ?? '—' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Current Address --}}
                    <small class="fw-semibold mt-3">Current Address</small>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Street/Barangay</th>
                                    <th>City/Municipality</th>
                                    <th>Province</th>
                                    <th>Region</th>
                                    <th>Zip Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $patient->pat_current_address ?? '—' }}</td>
                                    <td>{{ $patient->pat_current_city_mun ?? '—' }}</td>
                                    <td>{{ $patient->pat_current_province ?? '—' }}</td>
                                    <td>{{ $patient->pat_current_region ?? '—' }}</td>
                                    <td>{{ $patient->pat_current_zip_code ?? '—' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <!-- End of Patient Profile Tab -->

            <!-- Screening Information -->
            <div id="diagnosis-tab" class="tab-content" style="margin-top: 30px; display: none;">
                <div class="info-section card p-3 shadow-sm border-0 rounded-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-bold mb-1">Screening Information</h5>
                            <p class="text-muted small mb-0"> Details regarding the patient's referral, location, and
                                mode of screening. </p>
                        </div>
                    </div> @if ($patient->screenings->isNotEmpty())
                        <div class="table-responsive mb-3">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Referred By</th>
                                        <th>Type of Referrer</th>
                                        <th>Location</th>
                                        <th>Mode of Screening</th>
                                        <th>Date of Screening</th>
                                    </tr>
                                </thead>
                                <tbody> @foreach ($patient->screenings as $screening) <tr>
                                    <td>{{ $screening->scr_referred_by ?? '—' }}</td>
                                    <td>{{ $screening->scr_referrer_type ?? '—' }}</td>
                                    <td>{{ $screening->scr_location ?? '—' }}</td>
                                    <td>{{ $screening->scr_screening_mode ?? '—' }}</td>
                                    <td> @if (!empty($screening->scr_screening_date))
                                        {{ \Carbon\Carbon::parse($screening->scr_screening_date)->format('F j, Y') }}
                                    @else — @endif </td>
                                </tr> @endforeach </tbody>
                            </table>
                    </div> @else <p class="text-muted fst-italic mt-2"> No screening information recorded for this
                    patient. </p> @endif
                </div>

            <div class="info-section card p-3 shadow-sm border-0 rounded-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Initial Laboratory Tests</h5>
                        <p class="text-muted small mb-0">
                            Patient’s laboratory test details, dates, and results.
                        </p>
                    </div>
                </div>

                @if ($patient->labTests && $patient->labTests->isNotEmpty())
                    <div class="table-responsive mb-3">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Laboratory Test</th>
                                    <th>Result</th>
                                    <th>Date Conducted</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->labTests as $lab)
                                    @php
                                        $tests = [
                                            ['name' => 'Xpert MTB/RIF', 'result' => $lab->lab_xpert_result, 'date' => $lab->lab_xpert_test_date],
                                            ['name' => 'Smear Microscopy', 'result' => $lab->lab_smear_result, 'date' => $lab->lab_smear_test_date],
                                            ['name' => 'Chest X-ray', 'result' => $lab->lab_cxray_result, 'date' => $lab->lab_cxray_test_date],
                                            ['name' => 'Tuberculin Skin Test', 'result' => $lab->lab_tst_result, 'date' => $lab->lab_tst_test_date],
                                            ['name' => 'Other Test', 'result' => $lab->lab_other_result, 'date' => $lab->lab_other_test_date],
                                        ];
                                    @endphp
                                    @foreach ($tests as $test)
                                        @if (!empty($test['result']))
                                            <tr>
                                                <td>{{ $test['name'] }}</td>
                                                <td>{{ $test['result'] }}</td>
                                                <td>
                                                    {{ $test['date'] ? \Carbon\Carbon::parse($test['date'])->format('F j, Y') : '—' }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted fst-italic mt-2">No laboratory test records available for this patient.</p>
                @endif
            </div>


                                <div class="info-section card p-3 shadow-sm border-0 rounded-3">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h5 class="fw-bold mb-1">Diagnosis</h5>
                                            <p class="text-muted small mb-0">Details of the patient’s diagnosis, attending physician,
                                                and referral information.</p>
                                        </div>
                                        <button class="btn btn-sm btn-success d-flex align-items-center gap-1" data-bs-toggle="modal"
                                            data-bs-target="#editDiagnosisModal">
                                            <i class="fas fa-plus"></i> Add Referral
                                        </button>
                                    </div>

                                    @if ($patient->diagnoses->count() > 0)

                                        {{-- Table 1: Diagnosis Details --}}
                                        <small class="fw-semibold mt-3 d-block">Diagnosis Details</small>
                                        <div class="table-responsive mb-4">
                                            <table class="table align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Diagnosis Date</th>
                                                        <th>Notification Date</th>
                                                        <th>TB Case Number</th>
                                                        <th>Attending Physician</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($patient->diagnoses as $index => $diagnosis)
                                                        <tr>
                                                            <td>
                                                                @if(!empty($diagnosis->diag_diagnosis_date))
                                                                    {{ \Carbon\Carbon::parse($diagnosis->diag_diagnosis_date)->format('F j, Y') }}
                                                                @else
                                                                    —
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if(!empty($diagnosis->diag_notification_date))
                                                                    {{ \Carbon\Carbon::parse($diagnosis->diag_notification_date)->format('F j, Y') }}
                                                                @else
                                                                    —
                                                                @endif
                                                            </td>
                                                            <td>{{ $diagnosis->diag_tb_case_no ?? '—' }}</td>
                                                            <td>{{ $diagnosis->diag_attending_physician ?? '—' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        {{-- Table 2: Referral Information --}}
                                        <small class="fw-semibold mt-3 d-block">Referral Information</small>
                                        <div class="table-responsive mb-4">
                                            <table class="table align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Referred To</th>
                                                        <th>Address</th>
                                                        <th>Facility Code</th>
                                                        <th>Province</th>
                                                        <th>Region</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($patient->diagnoses as $index => $diagnosis)
                                                        <tr>
                                                            <td>{{ $diagnosis->diag_referred_to ?? '—' }}</td>
                                                            <td>{{ $diagnosis->diag_address ?? '—' }}</td>
                                                            <td>{{ $diagnosis->diag_facility_code ?? '—' }}</td>
                                                            <td>{{ $diagnosis->diag_province ?? '—' }}</td>
                                                            <td>{{ $diagnosis->diag_region ?? '—' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    @else
                                        <p class="text-muted fst-italic mt-2">No diagnosis record available for this patient.</p>
                                    @endif
                                </div>


            @php
            $tbRecords = $patient->tbClassification;

            // Check if each optional column has at least one non-empty value
            $hasOtherDrugResistance = $tbRecords->whereNotNull('clas_other_drug_resistant')->where('clas_other_drug_resistant', '!=', '')->isNotEmpty();
            $hasExtraPulmonarySite = $tbRecords->whereNotNull('clas_site_other')->where('clas_site_other', '!=', '')->isNotEmpty();
            @endphp

            <div class="info-section card p-3 shadow-sm border-0 rounded-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">TB Disease Classification</h5>
                        <p class="text-muted small mb-0">
                            Details about the patient’s TB classification, drug resistance, and anatomical site.
                        </p>
                    </div>
                </div>

                @if ($tbRecords->count())
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Bacteriological Status</th>
                                    <th>Drug Resistance Status</th>

                                    @if ($hasOtherDrugResistance)
                                        <th>Other Drug Resistance Status</th>
                                    @endif

                                    <th>Anatomical Site</th>

                                    @if ($hasExtraPulmonarySite)
                                        <th>Extra-pulmonary Site</th>
                                    @endif

                                    <th>Registration Group</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tbRecords as $index => $classification)
                                    <tr>
                                        <td>{{ $classification->clas_bacteriological_status ?? '—' }}</td>
                                        <td>{{ $classification->clas_drug_resistance_status ?? '—' }}</td>

                                        @if ($hasOtherDrugResistance)
                                            <td>{{ $classification->clas_other_drug_resistant ?? '—' }}</td>
                                        @endif

                                        <td>{{ $classification->clas_anatomical_site ?? '—' }}</td>

                                        @if ($hasExtraPulmonarySite)
                                            <td>{{ $classification->clas_site_other ?? '—' }}</td>
                                        @endif

                                        <td>{{ $classification->clas_registration_group ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted fst-italic mt-2">
                        No TB disease classification recorded for this patient.
                    </p>
                @endif
            </div>

        </div>
        <!-- End of Diagnosis Tab -->


        <!-- Treatment Information Tab -->
        <div id="treatment-tab" class="tab-content" style="margin-top: 30px; display: none;">

            <div class="info-section card p-3 shadow-sm border-0 rounded-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Treatment Facility</h5>
                        <p class="text-muted small mb-0">Details of the facility where the patient is receiving
                            treatment.</p>
                    </div>
                    <!-- <button class="btn btn-success btn-sm d-flex align-items-center gap-1"
                                                data-bs-toggle="modal" data-bs-target="#editTreatmentFacilityModal">
                                            <i class="fas fa-edit"></i> Edit
                                        </button> -->
                </div>

                @if ($patient->treatmentFacilities->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Facility Name</th>
                                    <th>NTP Facility Code</th>
                                    <th>Province</th>
                                    <th>Region</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->treatmentFacilities as $facility)
                                    @php
                                        $hasData = !empty($facility->trea_name)
                                            || !empty($facility->trea_ntp_code)
                                            || !empty($facility->trea_province)
                                            || !empty($facility->trea_region);
                                    @endphp

                                    @if ($hasData)
                                        <tr>
                                            <td>{{ $facility->trea_name ?? '—' }}</td>
                                            <td>{{ $facility->trea_ntp_code ?? '—' }}</td>
                                            <td>{{ $facility->trea_province ?? '—' }}</td>
                                            <td>{{ $facility->trea_region ?? '—' }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted fst-italic mt-2">No treatment facility information found for this patient.</p>
                @endif
            </div>


            <div class="info-section card p-3 shadow-sm border-0 rounded-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">History of TB Treatment</h5>
                        <p class="text-muted small mb-0">Previous TB treatment information and outcomes.</p>
                    </div>
                    <!-- <button class="btn btn-success btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal"
                                                data-bs-target="#editTreatmentHistoryModal">
                                                <i class="fas fa-plus"></i> Add Record
                                            </button> -->
                </div>

                @if ($patient->treatmentHistories->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date Tx Started</th>
                                    <th>Name of Treatment Unit</th>
                                    <th>Drug</th>
                                    <th>Treatment Duration</th>
                                    <th>Outcome</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->treatmentHistories as $history)
                                    @php
                                        $hasData = !empty($history->hist_date_tx_started)
                                            || !empty($history->hist_treatment_unit)
                                            || !empty($history->hist_drug)
                                            || !empty($history->hist_treatment_duration)
                                            || !empty($history->hist_outcome);
                                    @endphp

                                    @if ($hasData)
                                        <tr>
                                            <td>
                                                @if(!empty($history->hist_date_tx_started))
                                                    {{ \Carbon\Carbon::parse($history->hist_date_tx_started)->format('F j, Y') }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>{{ $history->hist_treatment_unit ?? '—' }}</td>
                                            <td>{{ $history->hist_drug ?? '—' }}</td>
                                            <td>{{ $history->hist_treatment_duration ?? '—' }}</td>
                                            <td>{{ $history->hist_outcome ?? '—' }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted fst-italic mt-2">No TB treatment history found for this patient.</p>
                @endif
            </div>


            <div class="info-section card p-3 shadow-sm border-0 rounded-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Co-morbidities</h5>
                        <p class="text-muted small mb-0">Other medical conditions and treatments related to this
                            patient.</p>
                    </div>
                    <button class="btn btn-success btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal"
                        data-bs-target="#editComorbiditiesModal">
                        <i class="fas fa-plus"></i> Add Record
                    </button>
                </div>

                @if ($patient->comorbidities->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date Diagnosed</th>
                                    <th>Type</th>
                                    <th>Other</th>
                                    <th>Treatment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->comorbidities as $comorbidity)
                                    @php
                                        $hasData = !empty($comorbidity->com_date_diagnosed)
                                            || !empty($comorbidity->com_type)
                                            || !empty($comorbidity->com_other)
                                            || !empty($comorbidity->com_treatment);
                                    @endphp

                                    @if ($hasData)
                                        <tr>
                                            <td>
                                                @if(!empty($comorbidity->com_date_diagnosed))
                                                    {{ \Carbon\Carbon::parse($comorbidity->com_date_diagnosed)->format('F j, Y') }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>{{ $comorbidity->com_type ?? '—' }}</td>
                                            <td>{{ $comorbidity->com_other ?? '—' }}</td>
                                            <td>{{ $comorbidity->com_treatment ?? '—' }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted fst-italic mt-2">No co-morbidities recorded for this patient.</p>
                @endif
            </div>


            <div class="info-section card p-3 shadow-sm border-0 rounded-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold mb-1">Baseline Information</h5>
                    <p class="text-muted small mb-0">
                        Patient’s initial measurements, vital signs, and screening details.
                    </p>
                </div>
            </div>

            @if ($patient->baselineInfos->isNotEmpty())
                {{-- Table 1: Physical Measurements & Vitals --}}
                <div class="table-responsive mb-4">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Height</th>
                                <th>Weight</th>
                                <th>Blood Pressure</th>
                                <th>Pulse Rate</th>
                                <th>Temperature</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patient->baselineInfos as $info)
                                <tr>
                                    <td>{{ $info->base_height ?? '—' }}</td>
                                    <td>{{ $info->base_weight ?? '—' }}</td>
                                    <td>{{ $info->base_blood_pressure ?? '—' }}</td>
                                    <td>{{ $info->base_pulse_rate ?? '-' }}</td>
                                    <td>{{ $info->base_temperature ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Table 2: Screening Information --}}
                <div class="table-responsive mb-4">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Diabetes Screening</th>
                                <th>FBS Screening</th>
                                <th>Date Tested</th>
                                <th>4Ps Beneficiary?</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patient->baselineInfos as $info)
                                <tr>
                                    <td>{{ $info->base_diabetes_screening ?? '—' }}</td>
                                    <td>{{ $info->base_fbs_screening ?? '—' }}</td>
                                    <td>
                                        @if(!empty($info->base_date_tested))
                                            {{ \Carbon\Carbon::parse($info->base_date_tested)->format('F j, Y') }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>{{ $info->base_four_ps_beneficiary ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Table 3: Emergency Contact --}}
                <small class="fw-semibold mt-3">Emergency Contact Information</small>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Relationship</th>
                                <th>Contact Info</th>
                                <th>Occupation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patient->baselineInfos as $info)
                                <tr>
                                    <td>{{ $info->base_emergency_contact_name ?? '—' }}</td>
                                    <td>{{ $info->base_relationship ?? '—' }}</td>
                                    <td>{{ $info->base_contact_info ?? '—' }}</td>
                                    <td>{{ $info->base_occupation ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted fst-italic mt-2">
                    No baseline information recorded for this patient.
                </p>
            @endif
        </div>




            <div class="info-section card p-3 shadow-sm border-0 rounded-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">HIV Information</h5>
                        <p class="text-muted small mb-0">Details regarding HIV screening, test results, and
                            treatment initiation.</p>
                    </div>
                    <button class="btn btn-success btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal"
                        data-bs-target="#editBaselineModal">
                        <i class="fas fa-plus"></i> Add Record
                    </button>
                </div>

                @if ($patient->hivInfos->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>HIV Information</th>
                                    <th>HIV Test Date</th>
                                    <th>Confirmatory Test Date</th>
                                    <th>Result</th>
                                    <th>Started on ART</th>
                                    <th>Started on CPT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->hivInfos as $hiv)
                                    @php
                                        $hasData = !empty($hiv->hiv_information)
                                            || !empty($hiv->hiv_test_date)
                                            || !empty($hiv->hiv_confirmatory_test_date)
                                            || !empty($hiv->hiv_result)
                                            || !empty($hiv->hiv_art_started)
                                            || !empty($hiv->hiv_cpt_started);
                                    @endphp

                                    @if ($hasData)
                                        <tr>
                                            <td>{{ $hiv->hiv_information ?? '—' }}</td>
                                            <td>
                                                @if(!empty($hiv->hiv_test_date))
                                                    {{ \Carbon\Carbon::parse($hiv->hiv_test_date)->format('F j, Y') }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($hiv->hiv_confirmatory_test_date))
                                                    {{ \Carbon\Carbon::parse($hiv->hiv_confirmatory_test_date)->format('F j, Y') }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>{{ $hiv->hiv_result ?? '—' }}</td>
                                            <td>{{ $hiv->hiv_art_started ?? '—' }}</td>
                                            <td>{{ $hiv->hiv_cpt_started ?? '—' }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted fst-italic mt-2">No HIV information recorded for this patient.</p>
                @endif
            </div>


            <div class="info-section card p-3 shadow-sm border-0 rounded-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Treatment Regimen</h5>
                        <p class="text-muted small mb-0">Details regarding the patient’s treatment regimen from
                            start to end.</p>
                    </div>
                    <!-- <button class="btn btn-success btn-sm d-flex align-items-center gap-1"
                                                data-bs-toggle="modal" data-bs-target="#editTreatmentRegimenModal">
                                            <i class="fas fa-plus"></i> Add Record
                                        </button> -->
                </div>

                @if ($patient->treatmentRegimens->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Regimen Type at Start of Treatment</th>
                                    <th>Treatment Start Date</th>
                                    <th>Regimen Type at End of Treatment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->treatmentRegimens as $regimen)
                                    @php
                                        $hasData = !empty($regimen->reg_start_type)
                                            || !empty($regimen->reg_start_date)
                                            || !empty($regimen->reg_end_type);
                                    @endphp

                                    @if ($hasData)
                                        <tr>
                                            <td>{{ $regimen->reg_start_type ?? '—' }}</td>
                                            <td>
                                                @if (!empty($regimen->reg_start_date))
                                                    {{ \Carbon\Carbon::parse($regimen->reg_start_date)->format('F j, Y') }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>{{ $regimen->reg_end_type ?? '—' }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted fst-italic mt-2">
                        No treatment regimen recorded for this patient.
                    </p>
                @endif
            </div>


            <!-- Administration of Drugs - FIXED -->
            <div class="info-section card p-3 shadow-sm border-0 rounded-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Administration of Drugs</h5>
                        <p class="text-muted small mb-0">Details of treatment supporter, treatment schedules, and patient measurements.</p>
                    </div>
                    <button class="btn btn-success btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal"
                        data-bs-target="#editAdministrationModal">
                        <i class="fas fa-plus"></i> Add Record
                    </button>
                </div>

                {{-- Table 1: Treatment Supporter Information --}}
                @if ($patient->txSupporters->isNotEmpty())
                    <small class="fw-semibold mt-3">Treatment Supporter Information</small>
                    <div class="table-responsive mb-4">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Location of Treatment</th>
                                    <th>Supporter Name</th>
                                    <th>Designation</th>
                                    <th>Supporter Type</th>
                                    <th>Contact Information</th>
                                    <th>Name of DAT/s Used</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->txSupporters as $supporter)
                                    <tr>
                                        <td>{{ $supporter->sup_location ?? '—' }}</td>
                                        <td>{{ $supporter->sup_name ?? '—' }}</td>
                                        <td>{{ $supporter->sup_designation ?? '—' }}</td>
                                        <td>{{ $supporter->sup_type ?? '—' }}</td>
                                        <td>{{ $supporter->sup_contact_info ?? '—' }}</td>
                                        <td>{{ $supporter->sup_dat_used ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                {{-- Table 2: Treatment Schedule Details --}}
                @if ($patient->adherences->isNotEmpty())
                    <small class="fw-semibold mt-3">Treatment Schedule Details</small>
                    <div class="table-responsive mb-4">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Schedule of Treatment</th>
                                    <th>Intensive Phase Start</th>
                                    <th>Intensive Phase End</th>
                                    <th>Continuation Phase Start</th>
                                    <th>Continuation Phase End</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->adherences as $adherence)
                                    <tr>
                                        <td>{{ $supporter->sup_treatment_schedule ?? '—' }}</td>
                                        <td>
                                            @if (!empty($adherence->pha_intensive_start))
                                                {{ \Carbon\Carbon::parse($adherence->pha_intensive_start)->format('F j, Y') }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td>
                                            @if (!empty($adherence->pha_intensive_end))
                                                {{ \Carbon\Carbon::parse($adherence->pha_intensive_end)->format('F j, Y') }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td>
                                            @if (!empty($adherence->pha_continuation_start))
                                                {{ \Carbon\Carbon::parse($adherence->pha_continuation_start)->format('F j, Y') }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td>
                                            @if (!empty($adherence->pha_continuation_end))
                                                {{ \Carbon\Carbon::parse($adherence->pha_continuation_end)->format('F j, Y') }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                {{-- Table 3: Measurements --}}
                @if ($patient->adherences->isNotEmpty())
                    <small class="fw-semibold mt-3">Measurements</small>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Weight (kg)</th>
                                    <th>Height (cm) for Children</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->adherences as $adherence)
                                    <tr>
                                        <td>{{ $adherence->pha_weight ?? '—' }}</td>
                                        <td>{{ $adherence->pha_child_height ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @if ($patient->txSupporters->isEmpty() && $patient->adherences->isEmpty())
                    <p class="text-muted fst-italic mt-2">
                        No administration of drugs recorded for this patient.
                    </p>
                @endif
            </div>


            <!-- Prescribed Drugs - FIXED -->
            <div class="info-section card p-3 shadow-sm border-0 rounded-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Prescribed Drugs</h5>
                        <p class="text-muted small mb-0">Details of drugs prescribed during the intensive and continuation phases.</p>
                    </div>
                    <!-- <button class="btn btn-success btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal"
                        data-bs-target="#editPrescribedDrugsModal">
                        <i class="fas fa-plus"></i> Add Record
                    </button> -->
                </div>

                @if ($patient->prescribedDrugs->isNotEmpty())
                    {{-- Table 1: Intensive Phase --}}
                    <small class="fw-semibold mt-3">Intensive Phase</small>
                    <div class="table-responsive mb-4">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date Start</th>
                                    <th>Drug</th>
                                    <th>No. of Tablets</th>
                                    <th>Strength</th>
                                    <th>Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->prescribedDrugs as $drug)
                                    @if (!empty($drug->drug_start_date) || !empty($drug->drug_name))
                                        <tr>
                                            <td>
                                                @if (!empty($drug->drug_start_date))
                                                    {{ \Carbon\Carbon::parse($drug->drug_start_date)->format('F j, Y') }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>{{ $drug->drug_name ?? '—' }}</td>
                                            <td>{{ $drug->drug_no_of_tablets ?? '—' }}</td>
                                            <td>{{ $drug->drug_strength ?? '—' }}</td>
                                            <td>{{ $drug->drug_unit ?? '—' }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Table 2: Continuation Phase --}}
                    <small class="fw-semibold mt-3">Continuation Phase</small>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Drug</th>
                                    <th>No. of Tablets</th>
                                    <th>Strength</th>
                                    <th>Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->prescribedDrugs as $drug)
                                    @if (!empty($drug->drug_con_date) || !empty($drug->drug_con_name))
                                        <tr>
                                            <td>
                                                @if (!empty($drug->drug_con_date))
                                                    {{ \Carbon\Carbon::parse($drug->drug_con_date)->format('F j, Y') }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>{{ $drug->drug_con_name ?? '—' }}</td>
                                            <td>{{ $drug->drug_con_no_of_tablets ?? '—' }}</td>
                                            <td>{{ $drug->drug_con_strength ?? '—' }}</td>
                                            <td>{{ $drug->drug_con_unit ?? '—' }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted fst-italic mt-2 mb-0">
                        No prescribed drugs recorded for this patient.
                    </p>
                @endif
            </div>


            <div class="info-section card p-3 shadow-sm border-0 rounded-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Treatment Outcome</h5>
                        <p class="text-muted small mb-0">List of all recorded treatment outcomes and reasons.</p>
                    </div>
                    <button class="btn btn-success btn-sm d-flex align-items-center gap-1" onclick="editOutcome(
                                                    {{ $patient->treatmentOutcomes->first()->id ?? 0 }}, 
                                                    '{{ addslashes($patient->treatmentOutcomes->first()->out_outcome ?? '') }}', 
                                                    '{{ $patient->treatmentOutcomes->first()->out_date ?? '' }}', 
                                                    '{{ addslashes($patient->treatmentOutcomes->first()->out_reason ?? '') }}'
                                                )" data-bs-toggle="modal" data-bs-target="#editTreatmentOutcomeModal"
                        @if($patient->treatmentOutcomes->isEmpty()) disabled @endif>
                        <i class="fas fa-edit"></i> Edit Outcome
                    </button>
                </div>

                @if ($patient->treatmentOutcomes->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Outcome</th>
                                    <th>Date of Outcome</th>
                                    <th>Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->treatmentOutcomes as $outcome)
                                    @php
                                        $hasData = !empty($outcome->out_outcome)
                                            || !empty($outcome->out_date)
                                            || !empty($outcome->out_reason);
                                    @endphp

                                    @if ($hasData)
                                        <tr>
                                            <td>{{ $outcome->out_outcome ?? '—' }}</td>
                                            <td>
                                                @if (!empty($outcome->out_date))
                                                    {{ \Carbon\Carbon::parse($outcome->out_date)->format('F j, Y') }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>{{ $outcome->out_reason ?? '—' }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted fst-italic mt-2">
                        No treatment outcome recorded for this patient.
                    </p>
                @endif
            </div>

        </div>
        <!-- End of Treatment Information Tab -->


        <!-- Follow Ups Tab -->
        <div id="lab-tab" class="tab-content" style="margin-top: 30px; display: none;">

            <div class="info-section card p-3 shadow-sm border-0 rounded-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Serious Adverse Events</h5>
                        <p class="text-muted small mb-0">Recorded adverse events and AEs of special interest for
                            this patient.</p>
                    </div>
                    <button class="btn btn-success btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal"
                        data-bs-target="#editAdverseEventModal">
                        <i class="fas fa-plus"></i> Add Event
                    </button>
                </div>

                @if ($patient->adverseEvents->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date of Adverse Event</th>
                                    <th>Specific Adverse Event</th>
                                    <th>Date Reported to FDA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->adverseEvents as $adverse)
                                    @php
                                        $hasData = !empty($adverse->adv_ae_date)
                                            || !empty($adverse->adv_specific_ae)
                                            || !empty($adverse->adv_fda_reported_date);
                                    @endphp

                                    @if ($hasData)
                                        <tr>
                                            <td>
                                                @if(!empty($adverse->adv_ae_date))
                                                    {{ \Carbon\Carbon::parse($adverse->adv_ae_date)->format('F j, Y') }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>{{ $adverse->adv_specific_ae ?? '—' }}</td>
                                            <td>
                                                @if(!empty($adverse->adv_fda_reported_date))
                                                    {{ \Carbon\Carbon::parse($adverse->adv_fda_reported_date)->format('F j, Y') }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted fst-italic mt-2">No adverse events have been recorded for this patient.</p>
                @endif
            </div>


            <div class="info-section card p-3 shadow-sm border-0 rounded-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Patient Progress Report</h5>
                        <p class="text-muted small mb-0">Summary of the patient’s progress and treatment updates.
                        </p>
                    </div>
                    <button class="btn btn-success btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal"
                        data-bs-target="#editProgressModal">
                        <i class="fas fa-plus"></i> Add Report
                    </button>
                </div>

                @if ($patient->progress->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Problem</th>
                                    <th>Action Taken</th>
                                    <th>Plan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->progress as $prog)
                                    @php
                                        $hasData = !empty($prog->prog_date)
                                            || !empty($prog->prog_problem)
                                            || !empty($prog->prog_action_taken)
                                            || !empty($prog->prog_plan);
                                    @endphp

                                    @if ($hasData)
                                        <tr>
                                            <td>
                                                @if(!empty($prog->prog_date))
                                                    {{ \Carbon\Carbon::parse($prog->prog_date)->format('F j, Y') }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>{{ $prog->prog_problem ?? '—' }}</td>
                                            <td>{{ $prog->prog_action_taken ?? '—' }}</td>
                                            <td>{{ $prog->prog_plan ?? '—' }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted fst-italic mt-2">No progress reports have been recorded for this patient.</p>
                @endif
            </div>


            <div class="info-section card p-3 shadow-sm border-0 rounded-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Close Contacts</h5>
                        <p class="text-muted small mb-0">List of patient’s identified close contacts and their
                            screening details.</p>
                    </div>
                    <button class="btn btn-success btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal"
                        data-bs-target="#editCloseContactModal">
                        <i class="fas fa-plus"></i> Add Contact
                    </button>
                </div>

                @if ($patient->close_contacts->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Sex</th>
                                    <th>Relationship</th>
                                    <th>Initial Screening</th>
                                    <th>Follow-up</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->close_contacts as $contact)
                                    @php
                                        $hasData = !empty($contact->con_name)
                                            || !empty($contact->con_age)
                                            || !empty($contact->con_sex)
                                            || !empty($contact->con_relationship)
                                            || !empty($contact->con_initial_screening)
                                            || !empty($contact->con_follow_up)
                                            || !empty($contact->con_remarks);
                                    @endphp

                                    @if ($hasData)
                                        <tr>
                                            <td>{{ $contact->con_name ?? '—' }}</td>
                                            <td>{{ $contact->con_age ?? '—' }}</td>
                                            <td>{{ $contact->con_sex ?? '—' }}</td>
                                            <td>{{ $contact->con_relationship ?? '—' }}</td>
                                            <td>
                                                @if(!empty($contact->con_initial_screening))
                                                    {{ \Carbon\Carbon::parse($contact->con_initial_screening)->format('F j, Y') }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($contact->con_follow_up))
                                                    {{ \Carbon\Carbon::parse($contact->con_follow_up)->format('F j, Y') }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>{{ $contact->con_remarks ?? '—' }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted fst-italic mt-2">No close contacts have been recorded for this patient.</p>
                @endif
            </div>


            <div class="info-section card p-3 shadow-sm border-0 rounded-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Sputum Monitoring</h5>
                        <p class="text-muted small mb-0">Laboratory monitoring results of sputum samples collected
                            during treatment.</p>
                    </div>
                    <button class="btn btn-success btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal"
                        data-bs-target="#editSputumModal">
                        <i class="fas fa-plus"></i> Add Record
                    </button>
                </div>

                @if ($patient->sputum_monitorings->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date Collected</th>
                                    <th>Smear Microscopy / TB LAMP Result</th>
                                    <th>Xpert MTB/RIF Result</th>
                                    <th>Lab Test Result</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->sputum_monitorings as $sputum)
                                    @php
                                        $hasData = !empty($sputum->sput_date_collected)
                                            || !empty($sputum->sput_smear_result)
                                            || !empty($sputum->sput_xpert_result);
                                    @endphp

                                    @if ($hasData)
                                        <tr>
                                            <td>
                                                @if(!empty($sputum->sput_date_collected))
                                                    {{ \Carbon\Carbon::parse($sputum->sput_date_collected)->format('F j, Y') }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>{{ $sputum->sput_smear_result ?? '—' }}</td>
                                            <td>{{ $sputum->sput_xpert_result ?? '—' }}</td>
                                            <td>
                                                @if ($sputum->lab_test_photo)
                                                    <a href="{{ asset('storage/' . $sputum->lab_test_photo) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $sputum->lab_test_photo) }}" 
                                                            alt="Lab Test Photo" 
                                                            style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;">
                                                    </a>
                                                @else
                                                    —
                                                @endif
                                            </td>

                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted fst-italic mt-2">No sputum monitoring records have been added for this patient.
                    </p>
                @endif
            </div>


            <div class="info-section card p-3 shadow-sm border-0 rounded-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Chest X-ray</h5>
                        <p class="text-muted small mb-0">Recorded chest X-ray examinations and findings during
                            patient management.</p>
                    </div>
                    <button class="btn btn-success btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal"
                        data-bs-target="#editChestXrayModal">
                        <i class="fas fa-plus"></i> Add Record
                    </button>
                </div>

                @if ($patient->chestXrays->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date Examined</th>
                                    <th>Impression / Comparative Reading</th>
                                    <th>Descriptive Comments</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->chestXrays as $xray)
                                    @php
                                        $hasData = !empty($xray->xray_date_examined)
                                            || !empty($xray->xray_impression)
                                            || !empty($xray->xray_descriptive_comment);
                                    @endphp

                                    @if ($hasData)
                                        <tr>
                                            <td>
                                                @if(!empty($xray->xray_date_examined))
                                                    {{ \Carbon\Carbon::parse($xray->xray_date_examined)->format('F j, Y') }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>{{ $xray->xray_impression ?? '—' }}</td>
                                            <td>{{ $xray->xray_descriptive_comment ?? '—' }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted fst-italic mt-2">No chest X-ray results have been recorded for this patient.
                    </p>
                @endif
            </div>


            <div class="info-section card p-3 shadow-sm border-0 rounded-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Post-Treatment Follow-up</h5>
                        <p class="text-muted small mb-0">Follow-up examinations and results after treatment
                            completion.</p>
                    </div>
                    <button class="btn btn-success btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal"
                        data-bs-target="#editPostTreatmentModal">
                        <i class="fas fa-plus"></i> Add Record
                    </button>
                </div>

                @if ($patient->postTreatment->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Months After Tx</th>
                                    <th>Date</th>
                                    <th>CXR Findings</th>
                                    <th>Smear / Xpert</th>
                                    <th>TBC & DST</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->postTreatment as $followup)
                                    @php
                                        $hasData = !empty($followup->fol_months_after_tx)
                                            || !empty($followup->fol_date)
                                            || !empty($followup->fol_cxr_findings)
                                            || !empty($followup->fol_smear_xpert)
                                            || !empty($followup->fol_tbc_dst);
                                    @endphp

                                    @if ($hasData)
                                        <tr>
                                            <td>{{ $followup->fol_months_after_tx ?? '—' }}</td>
                                            <td>
                                                @if(!empty($followup->fol_date))
                                                    {{ \Carbon\Carbon::parse($followup->fol_date)->format('F j, Y') }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>{{ $followup->fol_cxr_findings ?? '—' }}</td>
                                            <td>{{ $followup->fol_smear_xpert ?? '—' }}</td>
                                            <td>{{ $followup->fol_tbc_dst ?? '—' }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted fst-italic mt-2">No post-treatment follow-up records found for this patient.
                    </p>
                @endif
            </div>

        </div>
        <!-- End of Follow Ups Tab -->

        <!-- Medication Adherence Tab -->
        <div id="adherence-tab" class="tab-content" style="margin-top: 30px; display: none;">
            <div class="info-section">
                <h5 class="fw-bold mb-3">Medication Adherence</h5>

                <div class="adherence-calendar-card">
                    <div class="adherence-calendar-header">
                        <div class="d-flex align-items-center gap-3">
                            <h3 class="adherence-calendar-title mb-0" id="monthYear"></h3>
                        </div>
                        <div class="adherence-calendar-nav">
                            <button class="adherence-nav-btn" id="prevMonth">
                                <i class="fa fa-chevron-left"></i>
                            </button>
                            <button class="adherence-nav-btn" id="nextMonth">
                                <i class="fa fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>

                    <div class="adherence-calendar-grid" id="calendar"></div>

                    <div class="adherence-stats-container mt-4">
                        <div class="adherence-stat-card adherence-stat-success">
                            <div class="adherence-stat-label">Days Taken</div>
                            <div class="adherence-stat-value" id="daysTaken">0</div>
                        </div>
                        <div class="adherence-stat-card adherence-stat-danger">
                            <div class="adherence-stat-label">Days Missed</div>
                            <div class="adherence-stat-value" id="daysMissed">0</div>
                        </div>
                        <div class="adherence-stat-card adherence-stat-success">
                            <div class="adherence-stat-label">Adherence Rate</div>
                            <div class="adherence-stat-value" id="adherenceRate">0%</div>
                        </div>
                    </div>

                    <div class="adherence-stats-container mt-4">
                        <div class="adherence-stat-card adherence-stat-info">
                            <div class="adherence-stat-label">Total Days Taken</div>
                            <div class="adherence-stat-value" id="totalDaysTaken">0</div>
                        </div>
                        <div class="adherence-stat-card adherence-stat-info">
                            <div class="adherence-stat-label">Total Days Missed</div>
                            <div class="adherence-stat-value" id="totalDaysMissed">0</div>
                        </div>
                        <div class="adherence-stat-card adherence-stat-primary">
                            <div class="adherence-stat-label">Overall Adherence Rate</div>
                            <div class="adherence-stat-value" id="totalAdherenceRate">0%</div>
                        </div>
                    </div>

                    <div class="adherence-legend-container">
                        <div class="adherence-legend">
                            <div class="adherence-legend-item">
                                <div class="adherence-legend-indicator adherence-taken">
                                    <i class="fa fa-check"></i>
                                </div>
                                <span>Medication Taken</span>
                            </div>
                            <div class="adherence-legend-item">
                                <div class="adherence-legend-indicator adherence-missed">
                                    <i class="fa fa-times"></i>
                                </div>
                                <span>Medication Missed</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- End of Monitoring Tab -->

        </div>




        <!-- Referral Modal -->
<div class="modal fade" id="editDiagnosisModal" tabindex="-1" aria-labelledby="editDiagnosisModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="editDiagnosisModalLabel">Referral Information</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- ✅ Always point to latest diagnosis record -->
            @php
                $latestDiagnosis = $patient->diagnoses->sortByDesc('created_at')->first();
            @endphp

            @if ($latestDiagnosis)
            <form method="POST" action="{{ route('referrals.update', $latestDiagnosis->id) }}">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <!-- Hidden core fields -->
                    <input type="hidden" name="diag_diagnosis_date" value="{{ old('diag_diagnosis_date', $latestDiagnosis->diag_diagnosis_date) }}">
                    <input type="hidden" name="diag_notification_date" value="{{ old('diag_notification_date', $latestDiagnosis->diag_notification_date) }}">
                    <input type="hidden" name="diag_tb_case_no" value="{{ old('diag_tb_case_no', $latestDiagnosis->diag_tb_case_no) }}">
                    <input type="hidden" name="diag_attending_physician" value="{{ old('diag_attending_physician', $latestDiagnosis->diag_attending_physician) }}">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="diag_referred_to" class="form-label">Referred to</label>
                            <input type="text" class="form-control" id="diag_referred_to" name="diag_referred_to"
                                placeholder="Treatment Facility Name"
                                value="{{ old('diag_referred_to', $latestDiagnosis->diag_referred_to) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="diag_address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="diag_address" name="diag_address"
                                placeholder="Address"
                                value="{{ old('diag_address', $latestDiagnosis->diag_address) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="diag_facility_code" class="form-label">Facility Code</label>
                            <input type="text" class="form-control" id="diag_facility_code" name="diag_facility_code"
                                placeholder="Facility code"
                                value="{{ old('diag_facility_code', $latestDiagnosis->diag_facility_code) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="diag_region" class="form-label">Region</label>
                            <select id="diag_region" class="form-control form-select" required>
                                <option value="" disabled>Select</option>
                            </select>
                            <input type="hidden" name="diag_region" id="diag_region_text"
                                value="{{ old('diag_region', $latestDiagnosis->diag_region) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="diag_province" class="form-label">Province</label>
                            <select id="diag_province" class="form-control form-select" required>
                                <option value="" disabled>Select</option>
                            </select>
                            <input type="hidden" name="diag_province" id="diag_province_text"
                                value="{{ old('diag_province', $latestDiagnosis->diag_province) }}">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
            @else
                <div class="modal-body text-center text-muted">
                    <p>No diagnosis record found for this patient.</p>
                </div>
            @endif
        </div>
    </div>
</div>



        <!-- History of TB Treatment Modal -->
        <!-- <div class="modal fade" id="editTreatmentHistoryModal" tabindex="-1"
            aria-labelledby="editTreatmentHistoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="editTreatmentHistoryModalLabel">History of TB Treatment</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form method="POST" action="{{ route('treatment-history.store', $patient->id) }}">
                        @csrf

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="hist_date_tx_started" class="form-label">Date Tx Started</label>
                                <input type="date" class="form-control" id="hist_date_tx_started"
                                    name="hist_date_tx_started" max="<?php echo date('Y-m-d'); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="hist_treatment_unit" class="form-label">Name of Treatment Unit</label>
                                <input type="text" class="form-control" id="hist_treatment_unit"
                                    name="hist_treatment_unit" placeholder="Treatment unit" required>
                            </div>

                            <div class="mb-3">
                                <label for="hist_regimen" class="form-label">Treatment Regimen</label>
                                <input type="text" class="form-control" id="hist_regimen" name="hist_regimen"
                                    placeholder="Drugs & Duration" required>
                            </div>

                            <div class="mb-3">
                                <label for="hist_outcome" class="form-label">Outcome</label>
                                <select class="form-control form-select" id="hist_outcome" name="hist_outcome" required>
                                    <option value="" disabled selected>Select</option>
                                    <option value="Cured">Cured</option>
                                    <option value="Treatment Completed">Treatment Completed</option>
                                    <option value="Lost to Follow-up">Lost to Follow-up</option>
                                    <option value="Died">Died</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> -->


        <!-- Co-morbidities Modal -->
        <div class="modal fade" id="editComorbiditiesModal" tabindex="-1" aria-labelledby="editComorbiditiesModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="editComorbiditiesModalLabel">Co-morbidities</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <!-- ✅ Add form action for saving co-morbidity -->
                    <form method="POST" action="{{ route('comorbidities.store', $patient->id) }}">
                        @csrf

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="com_date_diagnosed" class="form-label">Date Diagnosed</label>
                                    <input type="date" class="form-control" id="com_date_diagnosed"
                                        name="com_date_diagnosed" max="<?php echo date('Y-m-d'); ?>" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="com_type" class="form-label">Type</label>
                                    <select class="form-control form-select" id="com_type" name="com_type" required>
                                        <option value="">Select</option>
                                        <option value="Diabetes Mellitus">Diabetes Mellitus</option>
                                        <option value="Mental Illness">Mental Illness</option>
                                        <option value="Substance Abuse">Substance Abuse</option>
                                        <option value="Liver Disease">Liver Disease</option>
                                        <option value="Renal Disease">Renal Disease</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="com_other" class="form-label">Other (Optional)</label>
                                    <input type="text" class="form-control" id="com_other" name="com_other"
                                        placeholder="Specify">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="com_treatment" class="form-label">Treatment</label>
                                    <input type="text" class="form-control" id="com_treatment" name="com_treatment"
                                        placeholder="Treatment">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- HIV Modal -->
        <div class="modal fade" id="editBaselineModal" tabindex="-1" aria-labelledby="editBaselineModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="editBaselineModalLabel">HIV Information</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <!-- ✅ Form with action route -->
                    <form method="POST" action="{{ route('hiv.store', $patient->id) }}">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="hiv_information" class="form-label">HIV Information</label>
                                    <!-- <input type="text" class="form-control" id="hiv_information" name="hiv_information"
                                        placeholder="HIV Information"> -->
                                        <select name="hiv_information" id="hiv_information" class="form-control form-select">
                                            <option value="" disabled selected>Select</option>
                                            <option value="Known for HIV">Known for HIV</option>
                                            <option value="Not yet Tested">Not yet Tested</option>
                                        </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="hiv_test_date" class="form-label">HIV Test Date</label>
                                    <input type="date" class="form-control" id="hiv_test_date" name="hiv_test_date"
                                        max="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="hiv_confirmatory_test_date" class="form-label">Confirmatory Test
                                        Date</label>
                                    <input type="date" class="form-control" id="hiv_confirmatory_test_date"
                                        name="hiv_confirmatory_test_date" max="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="hiv_result" class="form-label">Result</label>
                                    <!-- <input type="text" name="hiv_result" id="hiv_result" class="form-control"
                                        placeholder="Result"> -->
                                        <select name="hiv_result" id="hiv_result" class="form-control form-select">
                                            <option value="" disabled selected>Select</option>
                                            <option value="Reactive">Reactive</option>
                                            <option value="Non-reactive">Non-reactive</option>
                                        </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="hiv_art_started" class="form-label">Started on ART?</label>
                                    <select class="form-control form-select" id="hiv_art_started"
                                        name="hiv_art_started">
                                        <option value="">Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="hiv_cpt_started" class="form-label">Started on CPT?</label>
                                    <select class="form-control form-select" id="hiv_cpt_started"
                                        name="hiv_cpt_started">
                                        <option value="">Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="editTreatmentOutcomeModal" tabindex="-1"
    aria-labelledby="editTreatmentOutcomeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="editTreatmentOutcomeModalLabel">Edit Treatment Outcome</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <form method="POST" id="editOutcomeForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    @php
                        // Get the latest treatment outcome instead of first
                        $treatment = $patient->treatmentOutcomes->sortByDesc('created_at')->first();
                        $selectedOutcome = old('out_outcome', optional($treatment)->out_outcome);
                        $outDate = old('out_date', optional($treatment)->out_date);
                        $outReason = old('out_reason', optional($treatment)->out_reason);
                    @endphp

                    <!-- Outcome -->
                    <div class="mb-3">
                        <label for="edit_out_outcome" class="form-label">Outcome</label>
                        <select class="form-control form-select" id="edit_out_outcome" name="out_outcome"
                            required>
                            @foreach (['Cured', 'Treatment Completed', 'Lost to Follow-up', 'Died'] as $option)
                                <option value="{{ $option }}" {{ $selectedOutcome === $option ? 'selected' : '' }}>
                                    {{ $option }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date -->
                    <div class="mb-3">
                        <label for="edit_out_date" class="form-label">Date of Outcome</label>
                        <input type="date" class="form-control" id="edit_out_date" name="out_date"
                            max="{{ date('Y-m-d') }}" value="{{ $outDate }}">
                    </div>

                    <!-- Reason -->
                    <div class="mb-3">
                        <label for="edit_out_reason" class="form-label">Reason</label>
                        <input type="text" class="form-control" id="edit_out_reason" name="out_reason"
                            placeholder="Enter reason" value="{{ $outReason }}">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-success">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

        <!-- Administration of Drugs Modal -->
<div class="modal fade" id="editAdministrationModal" tabindex="-1"
    aria-labelledby="editAdministrationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="editAdministrationModalLabel">Administration of Drugs</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- ✅ Form with update route -->
            <form method="POST" action="{{ route('adherence.update', $patient->id) }}">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    @php
                        // ✅ Get latest related records safely
                        $latestSupporter = $patient->txSupporters->sortByDesc('created_at')->first();
                        $latestAdherence = $patient->adherences->sortByDesc('created_at')->first();
                        $latestDrug = $patient->prescribedDrugs->sortByDesc('created_at')->first();
                    @endphp

                    {{-- ========================= --}}
                    {{-- 🟩 HIDDEN TREATMENT SUPPORTER INFO --}}
                    {{-- ========================= --}}
                    <input type="hidden" name="sup_location" value="{{ $latestSupporter->sup_location ?? '' }}">
                    <input type="hidden" name="sup_name" value="{{ $latestSupporter->sup_name ?? '' }}">
                    <input type="hidden" name="sup_designation" value="{{ $latestSupporter->sup_designation ?? '' }}">
                    <input type="hidden" name="sup_type" value="{{ $latestSupporter->sup_type ?? '' }}">
                    <input type="hidden" name="sup_contact_info" value="{{ $latestSupporter->sup_contact_info ?? '' }}">
                    <input type="hidden" name="sup_dat_used" value="{{ $latestSupporter->sup_dat_used ?? '' }}">
                    <input type="hidden" name="sup_treatment_schedule" value="{{ $latestSupporter->sup_treatment_schedule ?? '' }}">

                    {{-- ========================= --}}
                    {{-- 🟦 TREATMENT SCHEDULE DETAILS --}}
                    {{-- ========================= --}}
                    

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pha_weight" class="form-label">Weight (kg)</label>
                            <input type="number" step="0.01" class="form-control" id="pha_weight" name="pha_weight"
                                value="{{ $latestAdherence->pha_weight ?? '' }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="pha_child_height" class="form-label">Height (cm) for Children</label>
                            <input type="number" step="0.01" class="form-control" id="pha_child_height"
                                name="pha_child_height"
                                value="{{ $latestAdherence->pha_child_height ?? '' }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="pha_intensive_start">Intensive Phase Start Date</label>
                            <input type="date" class="form-control" id="pha_intensive_start" name="pha_intensive_start" 
                                value="{{ $latestAdherence->pha_intensive_start ?? '' }}" max="<?php echo date('Y-m-d'); ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="pha_intensive_end">Intensive Phase End Date</label>
                            <input type="date" class="form-control" id="pha_intensive_end" name="pha_intensive_end" 
                                value="{{ $latestAdherence->pha_intensive_end ?? '' }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="pha_continuation_start" class="form-label">Continuation Phase Start Date</label>
                            <input type="date" class="form-control" id="pha_continuation_start" name="pha_continuation_start"
                                value="{{ $latestAdherence->pha_continuation_start ?? '' }}" max="<?php echo date('Y-m-d'); ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="pha_continuation_end" class="form-label">Continuation Phase End Date</label>
                            <input type="date" class="form-control" id="pha_continuation_end" name="pha_continuation_end"
                                value="{{ $latestAdherence->pha_continuation_end ?? '' }}" >
                        </div>

                        {{-- ========================= --}}
                        {{-- 🧪 PRESCRIBED DRUGS --}}
                        {{-- ========================= --}}
                        <div class="col-md-6 mb-3">
                            <label for="drug_con_date">Continuation Date</label>
                            <input type="text" class="form-control" id="drug_con_date" name="drug_con_date"
                                max="{{ date('Y-m-d') }}"
                                value="{{ old('drug_con_date', $latestDrug->drug_con_date ?? '') }}" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="drug_con_name" class="form-label">Drug</label>
                            <input type="text" name="drug_con_name" id="drug_con_name" class="form-control"
                                value="{{ old('drug_con_name', $latestDrug->drug_con_name ?? '') }}" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="drug_con_no_of_tablets">No. of Tablets</label>
                            <input type="text" class="form-control" id="drug_con_no_of_tablets"
                                name="drug_con_no_of_tablets"
                                value="{{ old('drug_con_no_of_tablets', $latestDrug->drug_con_no_of_tablets ?? '') }}"
                                readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="drug_con_strength" class="form-label">Strength</label>
                            <input type="text" name="drug_con_strength" id="drug_con_strength"
                                class="form-control"
                                value="{{ old('drug_con_strength', $latestDrug->drug_con_strength ?? '') }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="drug_con_unit" class="form-label">Unit</label>
                            <input type="text" name="drug_con_unit" id="drug_con_unit" class="form-control"
                                value="{{ old('drug_con_unit', $latestDrug->drug_con_unit ?? '') }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>



        <!-- Adverse Events Modal -->
        <div class="modal fade" id="editAdverseEventModal" tabindex="-1" aria-labelledby="editAdverseEventModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="editAdverseEventModalLabel">
                            Serious Adverse Event
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <!-- IMPORTANT: action points to adverse.store route -->
                    <form action="{{ route('adverse.store', $patient->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <!-- Date of AE -->
                            <div class="mb-3">
                                <label for="adv_ae_date" class="form-label">Date of AE</label>
                                <input type="date" class="form-control" id="adv_ae_date" name="adv_ae_date"
                                    max="<?php echo date('Y-m-d'); ?>" required>
                            </div>

                            <!-- Specific AE -->
                            <div class="mb-3">
                                <label for="adv_specific_ae" class="form-label">Specific AE</label>
                                <input type="text" class="form-control" id="adv_specific_ae" name="adv_specific_ae"
                                    placeholder="e.g. Severe rash, dizziness" required>
                            </div>

                            <!-- Date Reported to FDA -->
                            <div class="mb-3">
                                <label for="adv_fda_reported_date" class="form-label">Date Reported to FDA</label>
                                <input type="date" class="form-control" id="adv_fda_reported_date"
                                    name="adv_fda_reported_date" max="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


        <!-- Patient Progress Modal -->
        <div class="modal fade" id="editProgressModal" tabindex="-1" aria-labelledby="editProgressModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="editProgressModalLabel">Patient Progress Report</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <!-- Laravel Route for storing progress -->
                    <form method="POST" action="{{ route('patient-progress.store', $patient->id) }}">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="prog_date" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="prog_date" name="prog_date"
                                        max="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="prog_problem" class="form-label">Problem</label>
                                    <input type="text" class="form-control" id="prog_problem" name="prog_problem"
                                        placeholder="Problem" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="prog_action_taken" class="form-label">Action Taken</label>
                                    <input type="text" class="form-control" id="prog_action_taken"
                                        name="prog_action_taken" placeholder="Action taken" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="prog_plan" class="form-label">Plan</label>
                                    <input type="text" class="form-control" id="prog_plan" name="prog_plan"
                                        placeholder="Plan" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Close Contact Modal -->
        <div class="modal fade" id="editCloseContactModal" tabindex="-1" aria-labelledby="editCloseContactModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="editCloseContactModalLabel">Close Contact</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <!-- Laravel Route for storing close contact -->
                    <form method="POST" action="{{ route('close-contact.store', $patient->id) }}">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="con_name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="con_name" name="con_name"
                                        placeholder="Name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="con_age" class="form-label">Age</label>
                                    <input type="number" class="form-control" id="con_age" name="con_age" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="con_sex" class="form-label">Sex</label>
                                    <select class="form-control form-select" id="con_sex" name="con_sex" required>
                                        <option value="">Select</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="con_relationship" class="form-label">Relationship</label>
                                    <input type="text" class="form-control" id="con_relationship"
                                        name="con_relationship" placeholder="Relationship" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="con_initial_screening" class="form-label">Initial Screening</label>
                                    <input type="date" class="form-control" id="con_initial_screening"
                                        name="con_initial_screening" max="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="con_follow_up" class="form-label">Follow-up</label>
                                    <input type="date" class="form-control" id="con_follow_up" name="con_follow_up"
                                        max="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="con_remarks" class="form-label">Remarks</label>
                                    <input type="text" class="form-control" id="con_remarks" name="con_remarks"
                                        placeholder="Remarks">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Sputum Monitoring Modal -->
<div class="modal fade" id="editSputumModal" tabindex="-1" aria-labelledby="editSputumModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="editSputumModalLabel">Sputum Monitoring</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Important: route should point to sputum.store (create new) -->
            <form action="{{ route('sputum.store', $patient->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Date Collected -->
                    <div class="mb-3">
                        <label for="sput_date_collected" class="form-label">Date Collected</label>
                        <input type="date" class="form-control" id="sput_date_collected"
                            name="sput_date_collected" max="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <!-- Smear Microscopy -->
                    <div class="mb-3">
                        <label for="sput_smear_result" class="form-label">Smear Microscopy /TB LAMP</label>
                        <select name="sput_smear_result" id="sput_smear_result"
                            class="form-control form-select">
                            <option value="" disabled selected>Select</option>
                            <option value="MTB VERY HIGH">MTB VERY HIGH</option>
                            <option value="MTB HIGH">MTB HIGH</option>
                            <option value="MTB MEDIUM">MTB MEDIUM</option>
                            <option value="MTB LOW">MTB LOW</option>
                            <option value="MTB VERY LOW">MTB VERY LOW</option>
                            <option value="MTB NEGATIVE">MTB NEGATIVE</option>
                        </select>
                    </div>

                    <!-- Xpert MTB/RIF -->
                    <div class="mb-3">
                        <label for="sput_xpert_result" class="form-label">Xpert MTB/RIF</label>
                        <select name="sput_xpert_result" id="sput_xpert_result"
                            class="form-control form-select" required>
                            <option value="" disabled selected>Select</option>
                            <option value="MTB VERY HIGH">MTB VERY HIGH</option>
                            <option value="MTB HIGH">MTB HIGH</option>
                            <option value="MTB MEDIUM">MTB MEDIUM</option>
                            <option value="MTB LOW">MTB LOW</option>
                            <option value="MTB VERY LOW">MTB VERY LOW</option>
                            <option value="MTB NEGATIVE">MTB NEGATIVE</option>
                        </select>
                    </div>

                    <!-- Lab Test Photo Upload with Preview -->
                    <div class="mb-3">
                        <label for="lab_test_photo" class="form-label">Upload Lab Test Photo</label>
                        <input type="file" class="form-control" id="lab_test_photo" name="lab_test_photo" 
                            accept="image/*" onchange="previewImage(event)">
                        
                        <!-- Image Preview Container -->
                        <div id="imagePreviewContainer" class="mt-3" style="display: none;">
                            <div class="position-relative d-inline-block">
                                <img id="imagePreview" src="" alt="Preview" 
                                    class="img-thumbnail" 
                                    style="max-width: 100%; max-height: 300px; object-fit: contain;">
                                <button type="button" 
                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2" 
                                    onclick="removeImage()"
                                    style="padding: 0.25rem 0.5rem;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <p class="text-muted small mt-2 mb-0">
                                <i class="fas fa-info-circle"></i> Preview of your lab test photo
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


        <!-- Chest X-ray Modal -->
        <div class="modal fade" id="editChestXrayModal" tabindex="-1" aria-labelledby="editChestXrayModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="editChestXrayModalLabel">Chest X-ray</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <!-- Laravel route for storing chest x-ray -->
                    <form method="POST" action="{{ route('chest-xray.store', $patient->id) }}">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="xray_date_examined" class="form-label">Date Examined</label>
                                <input type="date" class="form-control" id="xray_date_examined"
                                    name="xray_date_examined" max="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="xray_impression" class="form-label">Impression/ Comparative Reading</label>
                                <select name="xray_impression" id="xray_impression" class="form-control form-select">
                                    <option value="" disabled selected>Select</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Abnormal suggestive of TB">Abnormal suggestive of TB</option>
                                    <option value="Abnormal not suggestive of TB">Abnormal not suggestive of TB</option>
                                    <option value="Improved">Improved</option>
                                    <option value="Stable/Unchanged">Stable/Unchanged</option>
                                    <option value="Worsened">Worsened</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="xray_descriptive_comment" class="form-label">Descriptive Comments</label>
                                <input type="text" class="form-control" id="xray_descriptive_comment"
                                    name="xray_descriptive_comment" placeholder="Descriptive Comments">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Post Treatment Follow-up Modal -->
        <div class="modal fade" id="editPostTreatmentModal" tabindex="-1" aria-labelledby="editPostTreatmentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="editPostTreatmentModalLabel">Post Treatment Follow-up</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <!-- ✅ Add action route -->
                    <form method="POST" action="{{ route('post-treatment-follow-up.store', $patient->id) }}">
                        @csrf

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fol_months_after_tx" class="form-label">Months After Treatment</label>
                                    <input type="number" class="form-control" id="fol_months_after_tx"
                                        name="fol_months_after_tx" placeholder="Months After Treatment" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fol_date" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="fol_date" name="fol_date"
                                        max="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fol_cxr_findings" class="form-label">CXR Findings</label>
                                    <input type="text" class="form-control" id="fol_cxr_findings"
                                        name="fol_cxr_findings" placeholder="Cxr Findings">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fol_smear_xpert" class="form-label">Smear / Xpert</label>
                                    <input type="text" class="form-control" id="fol_smear_xpert" name="fol_smear_xpert"
                                        placeholder="Smear / Xpert">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fol_tbc_dst" class="form-label">TBC & DST</label>
                                    <input type="text" class="form-control" id="fol_tbc_dst" name="fol_tbc_dst"
                                        placeholder="Tbc & Dst">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



    </main>

    <script src="{{ url('assets/js/patientProfile.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ url('assets/js/logout.js') }}"></script>

    <script src="{{ url('assets/js/active.js') }}"></script>

    <script src="{{ url('assets/js/sidebarToggle.js') }}"></script>

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
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('editDiagnosisModal');
            modal.addEventListener('shown.bs.modal', function () {
                document.getElementById('diag_diagnosis_date').focus();
            });
        });
    </script>

    <!-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('editPrescribedDrugsModal');
            modal.addEventListener('shown.bs.modal', function () {
                document.getElementById('drug_start_date').focus();
            });
        });
    </script> -->

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // ✅ When clicking edit button
            document.querySelectorAll(".btn-edit-admin").forEach((button) => {
                button.addEventListener("click", function () {
                    const patientId = this.getAttribute("data-id");

                    // Fetch patient data via AJAX
                    fetch(`/admin/administration/${patientId}/edit`)
                        .then(response => response.json())
                        .then(data => {
                            if (!data) return;

                            // 🟩 Treatment Supporter Information
                            document.getElementById("sup_location").value = data.sup_location ?? "";
                            document.getElementById("sup_name").value = data.sup_name ?? "";
                            document.getElementById("sup_designation").value = data.sup_designation ?? "";
                            document.getElementById("sup_type").value = data.sup_type ?? "";
                            document.getElementById("sup_contact_info").value = data.sup_contact_info ?? "";
                            document.getElementById("sup_dat_used").value = data.sup_dat_used ?? "";
                            document.getElementById("sup_treatment_schedule").value = data.sup_treatment_schedule ?? "";

                            // 🟦 Treatment Schedule Details
                            document.getElementById("pha_intensive_start").value = data.pha_intensive_start ?? "";
                            document.getElementById("pha_intensive_end").value = data.pha_intensive_end ?? "";
                            document.getElementById("pha_continuation_start").value = data.pha_continuation_start ?? "";
                            document.getElementById("pha_continuation_end").value = data.pha_continuation_end ?? "";

                            // 🟨 Measurements
                            document.getElementById("pha_weight").value = data.pha_weight ?? "";
                            document.getElementById("pha_child_height").value = data.pha_child_height ?? "";

                            // ✅ Update form action dynamically
                            const form = document.querySelector("#editAdministrationModal form");
                            form.action = `/admin/administration/${patientId}`;

                            // ✅ Show modal
                            const modal = new bootstrap.Modal(document.getElementById("editAdministrationModal"));
                            modal.show();
                        })
                        .catch(error => console.error("Error loading data:", error));
                });
            });

            // ✅ Optional: form validation before submit
            const form = document.querySelector("#editAdministrationModal form");
            form.addEventListener("submit", function (e) {
                const weight = document.getElementById("pha_weight").value;
                if (weight === "" || weight <= 0) {
                    e.preventDefault();
                    alert("Please enter a valid weight before saving.");
                }
            });
        });
    </script>




    <!-- <script>
        (function () {
            const calendar = document.getElementById("calendar");
            const monthYear = document.getElementById("monthYear");
            const adherenceRateEl = document.getElementById("adherenceRate");
            const daysTakenEl = document.getElementById("daysTaken");
            const daysMissedEl = document.getElementById("daysMissed");

            const totalDaysTakenEl = document.getElementById("totalDaysTaken");
            const totalDaysMissedEl = document.getElementById("totalDaysMissed");
            const totalAdherenceRateEl = document.getElementById("totalAdherenceRate");

            if (!calendar || !monthYear) return;

            let currentDate = new Date();
            let adherenceData = {};

            const username = @json(
                $patient->adherences->first()->username ?? $patient->patientAccount->acc_username ?? null
            );

            function calculateStats(year, month) {
                let taken = 0, missed = 0;
                let totalTaken = 0, totalMissed = 0;

                Object.keys(adherenceData).forEach(dateStr => {
                    const date = new Date(dateStr);

                    if (date.getFullYear() === year && date.getMonth() === month) {
                        if (adherenceData[dateStr] === "taken") taken++;
                        if (adherenceData[dateStr] === "missed") missed++;
                    }

                    if (adherenceData[dateStr] === "taken") totalTaken++;
                    if (adherenceData[dateStr] === "missed") totalMissed++;
                });

                const monthTotal = taken + missed;
                const monthRate = monthTotal > 0 ? Math.round((taken / monthTotal) * 100) : 0;
                adherenceRateEl.textContent = monthRate + "%";
                daysTakenEl.textContent = taken;
                daysMissedEl.textContent = missed;

                const totalDays = totalTaken + totalMissed;
                const totalRate = totalDays > 0 ? Math.round((totalTaken / totalDays) * 100) : 0;
                totalDaysTakenEl.textContent = totalTaken;
                totalDaysMissedEl.textContent = totalMissed;
                totalAdherenceRateEl.textContent = totalRate + "%";
            }

            function renderCalendar(date) {
                calendar.innerHTML = "";
                const year = date.getFullYear();
                const month = date.getMonth();
                const firstDay = new Date(year, month, 1);
                const lastDay = new Date(year, month + 1, 0);

                const monthName = date.toLocaleString("default", { month: "long" });
                monthYear.textContent = `${monthName} ${year}`;

                const daysOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
                daysOfWeek.forEach(day => {
                    const header = document.createElement("div");
                    header.textContent = day;
                    header.classList.add("adherence-day-header");
                    calendar.appendChild(header);
                });

                for (let i = 0; i < firstDay.getDay(); i++) {
                    const empty = document.createElement("div");
                    empty.classList.add("adherence-calendar-day", "adherence-empty");
                    calendar.appendChild(empty);
                }

                for (let day = 1; day <= lastDay.getDate(); day++) {
                    const cell = document.createElement("div");
                    const dateStr = `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
                    cell.textContent = day;
                    cell.classList.add("adherence-calendar-day");

                    if (adherenceData[dateStr]) {
                        cell.classList.add("adherence-" + adherenceData[dateStr]);
                        const icon = document.createElement("i");
                        icon.classList.add(
                            "fa",
                            adherenceData[dateStr] === "taken" ? "fa-check" : "fa-times",
                            "adherence-status-icon"
                        );
                        cell.appendChild(icon);
                    }

                    calendar.appendChild(cell);
                }

                calculateStats(year, month);
            }

            document.getElementById("prevMonth")?.addEventListener("click", () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar(currentDate);
            });

            document.getElementById("nextMonth")?.addEventListener("click", () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar(currentDate);
            });

            async function fetchAdherenceData() {
                try {
                    let url = username
                        ? `/api/adherence/${encodeURIComponent(username)}`
                        : `/api/adherence/patient/{{ $patient->id }}`;

                    const response = await fetch(url, { credentials: 'same-origin' });
                    if (!response.ok) {
                        console.error('Adherence API returned status', response.status);
                        return;
                    }

                    const data = await response.json();
                    adherenceData = {};
                    (data || []).forEach(item => {
                        const d = item.date ? item.date.split(' ')[0] : null;
                        if (d) adherenceData[d] = item.status;
                    });

                    renderCalendar(currentDate);
                } catch (error) {
                    console.error("Error fetching adherence data:", error);
                }
            }

            fetchAdherenceData();
        })();
    </script> -->

    <script>
    (function () {
        const calendar = document.getElementById("calendar");
        const monthYear = document.getElementById("monthYear");
        const adherenceRateEl = document.getElementById("adherenceRate");
        const daysTakenEl = document.getElementById("daysTaken");
        const daysMissedEl = document.getElementById("daysMissed");

        // new total stat elements
        const totalDaysTakenEl = document.getElementById("totalDaysTaken");
        const totalDaysMissedEl = document.getElementById("totalDaysMissed");
        const totalAdherenceRateEl = document.getElementById("totalAdherenceRate");

        if (!calendar || !monthYear) return;

        let currentDate = new Date();
        let adherenceData = {};

        const username = @json(
            $patient->adherences->first()->username ?? $patient->patientAccount->acc_username ?? null
        );

        function calculateStats(year, month) {
            let taken = 0, missed = 0;
            let totalTaken = 0, totalMissed = 0;

            Object.keys(adherenceData).forEach(dateStr => {
                const date = new Date(dateStr);

                // count monthly
                if (date.getFullYear() === year && date.getMonth() === month) {
                    if (adherenceData[dateStr] === "taken") taken++;
                    if (adherenceData[dateStr] === "missed") missed++;
                }

                // count overall totals
                if (adherenceData[dateStr] === "taken") totalTaken++;
                if (adherenceData[dateStr] === "missed") totalMissed++;
            });

            // per-month
            const monthTotal = taken + missed;
            const monthRate = monthTotal > 0 ? Math.round((taken / monthTotal) * 100) : 0;
            adherenceRateEl.textContent = monthRate + "%";
            daysTakenEl.textContent = taken;
            daysMissedEl.textContent = missed;

            // total
            const totalDays = totalTaken + totalMissed;
            const totalRate = totalDays > 0 ? Math.round((totalTaken / totalDays) * 100) : 0;
            totalDaysTakenEl.textContent = totalTaken;
            totalDaysMissedEl.textContent = totalMissed;
            totalAdherenceRateEl.textContent = totalRate + "%";
        }

        // Function to show status selection modal
        function showStatusModal(dateStr, currentStatus) {
            const existingModal = document.getElementById('adherenceModal');
            if (existingModal) existingModal.remove();

            const modal = document.createElement('div');
            modal.id = 'adherenceModal';
            modal.innerHTML = `
                <div class="adherence-modal-overlay">
                    <div class="adherence-modal-content">
                        <h4 class="mb-3">Log Medication for ${dateStr}</h4>
                        <p class="text-muted mb-4">Select status:</p>
                        <div class="d-flex gap-3 justify-content-center mb-3">
                            <button class="btn btn-success adherence-modal-btn" data-status="taken">
                                <i class="fa fa-check"></i> Taken
                            </button>
                            <button class="btn btn-danger adherence-modal-btn" data-status="missed">
                                <i class="fa fa-times"></i> Missed
                            </button>
                            ${currentStatus ? `
                            <button class="btn btn-secondary adherence-modal-btn" data-status="remove">
                                <i class="fa fa-trash"></i> Remove
                            </button>
                            ` : ''}
                        </div>
                        <button class="btn btn-outline-secondary w-100" id="cancelModal">Cancel</button>
                    </div>
                </div>
            `;

            document.body.appendChild(modal);

            // Handle button clicks
            modal.querySelectorAll('.adherence-modal-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const status = btn.dataset.status;
                    if (status === 'remove') {
                        deleteAdherence(dateStr);
                    } else {
                        saveAdherence(dateStr, status);
                    }
                    modal.remove();
                });
            });

            document.getElementById('cancelModal').addEventListener('click', () => {
                modal.remove();
            });

            // Close on overlay click
            modal.querySelector('.adherence-modal-overlay').addEventListener('click', (e) => {
                if (e.target.classList.contains('adherence-modal-overlay')) {
                    modal.remove();
                }
            });
        }

        // Save adherence to backend
        async function saveAdherence(dateStr, status) {
            if (!username) {
                alert('Username not found. Cannot save adherence data.');
                return;
            }

            try {
                const response = await fetch('/api/adherence/log', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        username: username,
                        date: dateStr,
                        status: status
                    })
                });

                if (!response.ok) {
                    throw new Error('Failed to save adherence');
                }

                // Update local data and re-render
                adherenceData[dateStr] = status;
                renderCalendar(currentDate);
            } catch (error) {
                console.error('Error saving adherence:', error);
                alert('Failed to save adherence data. Please try again.');
            }
        }

        // Delete adherence from backend
        async function deleteAdherence(dateStr) {
            if (!username) {
                alert('Username not found. Cannot delete adherence data.');
                return;
            }

            try {
                const response = await fetch(`/api/adherence/${encodeURIComponent(username)}/${dateStr}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    credentials: 'same-origin'
                });

                if (!response.ok) {
                    throw new Error('Failed to delete adherence');
                }

                // Remove from local data and re-render
                delete adherenceData[dateStr];
                renderCalendar(currentDate);
            } catch (error) {
                console.error('Error deleting adherence:', error);
                alert('Failed to delete adherence data. Please try again.');
            }
        }

        function renderCalendar(date) {
            calendar.innerHTML = "";
            const year = date.getFullYear();
            const month = date.getMonth();
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const monthName = date.toLocaleString("default", { month: "long" });
            monthYear.textContent = `${monthName} ${year}`;

            const daysOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
            daysOfWeek.forEach(day => {
                const header = document.createElement("div");
                header.textContent = day;
                header.classList.add("adherence-day-header");
                calendar.appendChild(header);
            });

            for (let i = 0; i < firstDay.getDay(); i++) {
                const empty = document.createElement("div");
                empty.classList.add("adherence-calendar-day", "adherence-empty");
                calendar.appendChild(empty);
            }

            for (let day = 1; day <= lastDay.getDate(); day++) {
                const cell = document.createElement("div");
                const dateStr = `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
                const cellDate = new Date(year, month, day);
                
                cell.textContent = day;
                cell.classList.add("adherence-calendar-day");

                // Don't allow clicking future dates
                if (cellDate <= today) {
                    cell.style.cursor = "pointer";
                    cell.addEventListener("click", () => {
                        showStatusModal(dateStr, adherenceData[dateStr]);
                    });
                } else {
                    cell.classList.add("adherence-future");
                    cell.style.opacity = "0.4";
                }

                if (adherenceData[dateStr]) {
                    cell.classList.add("adherence-" + adherenceData[dateStr]);
                    const icon = document.createElement("i");
                    icon.classList.add(
                        "fa",
                        adherenceData[dateStr] === "taken" ? "fa-check" : "fa-times",
                        "adherence-status-icon"
                    );
                    cell.appendChild(icon);
                }

                calendar.appendChild(cell);
            }

            calculateStats(year, month);
        }

        document.getElementById("prevMonth")?.addEventListener("click", () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar(currentDate);
        });

        document.getElementById("nextMonth")?.addEventListener("click", () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar(currentDate);
        });

        async function fetchAdherenceData() {
            try {
                let url = username
                    ? `/api/adherence/${encodeURIComponent(username)}`
                    : `/api/adherence/patient/{{ $patient->id }}`;

                const response = await fetch(url, { credentials: 'same-origin' });
                if (!response.ok) {
                    console.error('Adherence API returned status', response.status);
                    return;
                }

                const data = await response.json();
                adherenceData = {};
                (data || []).forEach(item => {
                    const d = item.date ? item.date.split(' ')[0] : null;
                    if (d) adherenceData[d] = item.status;
                });

                renderCalendar(currentDate);
            } catch (error) {
                console.error("Error fetching adherence data:", error);
            }
        }

        fetchAdherenceData();
    })();
</script>

   <script>
    function editOutcome() {
        // Get the latest treatment outcome ID
        @php
            $latestOutcome = $patient->treatmentOutcomes->sortByDesc('created_at')->first();
        @endphp
        
        @if($latestOutcome)
            const id = {{ $latestOutcome->id }};
            const outcome = "{{ $latestOutcome->out_outcome }}";
            const date = "{{ $latestOutcome->out_date }}";
            const reason = "{{ $latestOutcome->out_reason }}";

            // Set form action to update route
            const form = document.getElementById('editOutcomeForm');
            form.action = `/treatment-outcome/${id}`;

            // Populate form fields with existing data
            document.getElementById('edit_out_outcome').value = outcome || '';
            document.getElementById('edit_out_date').value = date || '';
            document.getElementById('edit_out_reason').value = reason || '';
        @endif
    }

    // Reset form when modal closes
    document.getElementById('editTreatmentOutcomeModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('editOutcomeForm').reset();
    });
</script>

    @if (session('stay_on_tab'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const tabName = @json(session('stay_on_tab'));
                // Apply tab
                applyTab(tabName);
                // Save in sessionStorage so that reload/back keeps it active
                sessionStorage.setItem(STORAGE_KEY, tabName);
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 🟩 Elements
            const weightInput = document.getElementById('pha_weight');
            const heightInput = document.getElementById('pha_child_height');
            const drugName = document.getElementById('drug_con_name');
            const noOfTablets = document.getElementById('drug_con_no_of_tablets');
            const strength = document.getElementById('drug_con_strength');
            const unit = document.getElementById('drug_con_unit');

            // 🚫 Function to block invalid keys
            function preventInvalidKeys(input) {
                input.addEventListener('keydown', function (event) {
                    if (['-', 'e', 'E', '+'].includes(event.key)) {
                        event.preventDefault();
                    }
                });

                // 🚫 Prevent negative or invalid values
                input.addEventListener('input', function () {
                    const value = parseFloat(this.value);
                    if (isNaN(value) || value < 0) {
                        this.value = '';
                    }
                });
            }

            // Apply validation to both weight & height
            if (weightInput) preventInvalidKeys(weightInput);
            if (heightInput) preventInvalidKeys(heightInput);

            // 🧮 Weight-based drug logic
            if (weightInput) {
                weightInput.addEventListener('input', function () {
                    const weight = parseFloat(this.value);

                    // 🧹 Reset if invalid
                    if (isNaN(weight) || this.value.trim() === '') {
                        drugName.value = '';
                        noOfTablets.value = '';
                        strength.value = '';
                        unit.value = '';
                        return;
                    }

                    // ✅ Set base drug name
                    drugName.value = '2FDC';

                    // ✅ Determine dosage by weight range
                    if (weight >= 25 && weight <= 37) {
                        noOfTablets.value = '2';
                        strength.value = '400mg';
                        unit.value = 'Tablet';
                    } else if (weight >= 38 && weight <= 54) {
                        noOfTablets.value = '3';
                        strength.value = '600mg';
                        unit.value = 'Tablet';
                    } else if (weight >= 55 && weight <= 70) {
                        noOfTablets.value = '4';
                        strength.value = '800mg';
                        unit.value = 'Tablet';
                    } else if (weight > 70) {
                        noOfTablets.value = '5';
                        strength.value = '1000mg';
                        unit.value = 'Tablet';
                    } else {
                        // For weight below 25
                        drugName.value = '2FDC';
                        noOfTablets.value = '1';
                        strength.value = '200mg';
                        unit.value = 'Tablet';
                    }
                });
            }

            // 🟦 Continuation Phase Date Logic
            const conStart = document.getElementById('pha_continuation_start');
            const conEnd = document.getElementById('pha_continuation_end');
            const drugConDate = document.getElementById('drug_con_date');

            if (conStart) {
                conStart.addEventListener('change', function () {
                    const startDate = new Date(this.value);

                    // 🧹 Clear when invalid
                    if (isNaN(startDate.getTime()) || this.value.trim() === '') {
                        if (conEnd) conEnd.value = '';
                        if (drugConDate) drugConDate.value = '';
                        return;
                    }

                    // ✅ Auto-fill drug_con_date
                    if (drugConDate) {
                        drugConDate.value = this.value;
                    }

                    // ✅ Compute end date (+4 months)
                    const endDate = new Date(startDate);
                    endDate.setMonth(endDate.getMonth() + 4);

                    // Fix for month overflow (e.g. Jan 31)
                    if (endDate.getDate() !== startDate.getDate()) {
                        endDate.setDate(0);
                    }

                    const formattedEnd = endDate.toISOString().split('T')[0];
                    conEnd.value = formattedEnd;
                });
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const diagRegion = document.getElementById("diag_region");
            const diagProvince = document.getElementById("diag_province");
            const diagRegionText = document.getElementById("diag_region_text");
            const diagProvinceText = document.getElementById("diag_province_text");

            // --- Load Regions ---
            fetch("/api/regions")
                .then(res => res.json())
                .then(data => {
                    data.forEach(region => {
                        diagRegion.innerHTML += `<option value="${region.regCode}">${region.regDesc}</option>`;
                    });
                });

            // --- When Region changes, load Provinces ---
            diagRegion.addEventListener("change", () => {
                const regionCode = diagRegion.value;
                const regionName = diagRegion.options[diagRegion.selectedIndex].text;

                diagRegionText.value = regionName; // Store selected text
                diagProvince.innerHTML = '<option value="" disabled selected>Loading...</option>';

                fetch(`/api/provinces/${regionCode}`)
                    .then(res => res.json())
                    .then(data => {
                        diagProvince.innerHTML = '<option value="" disabled selected>Select</option>';
                        data.forEach(prov => {
                            diagProvince.innerHTML += `<option value="${prov.provCode}">${prov.provDesc}</option>`;
                        });
                    });
            });

            // --- When Province changes, store province name ---
            diagProvince.addEventListener("change", () => {
                const provinceName = diagProvince.options[diagProvince.selectedIndex].text;
                diagProvinceText.value = provinceName;
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.btn-relapse');

            buttons.forEach(button => {
                button.addEventListener('click', function () {
                    const url = this.getAttribute('data-url');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You are about to re-register this patient as a relapse case.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#198754',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, re-register!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to the relapse form page
                            window.location.href = url;
                        }
                    });
                });
            });
        });
    </script>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    const previewContainer = document.getElementById('imagePreviewContainer');
    
    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        
        reader.readAsDataURL(file);
    } else {
        previewContainer.style.display = 'none';
    }
}

function removeImage() {
    const fileInput = document.getElementById('lab_test_photo');
    const preview = document.getElementById('imagePreview');
    const previewContainer = document.getElementById('imagePreviewContainer');
    
    // Clear the file input
    fileInput.value = '';
    
    // Hide preview
    preview.src = '';
    previewContainer.style.display = 'none';
}

// Reset preview when modal is closed
document.getElementById('editSputumModal').addEventListener('hidden.bs.modal', function () {
    removeImage();
});
</script>

</body>

</html>