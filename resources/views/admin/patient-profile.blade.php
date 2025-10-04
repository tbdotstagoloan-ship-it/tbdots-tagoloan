<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>TB DOTS - Patient Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}" />
    <link rel="icon" href="{{ url('assets/img/lungs.png') }}">
    <style>
        /* Main Content */
        /* .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 24px;
        } */

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


        /* Status Badges */
        /* .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            background: #dcfce7;
            color: #166534;
        } */
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
                    <li><a href="{{ url('barangay-cases-notification') }}" class="nav-link">Barangay Cases
                            Notification</a></li>
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

            <a href="{{ url('patient') }}" class="btn btn-secondary backBtn">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>
        <div class="page-content">
            <!-- <h1 class="page-title">Patient / <span style="color: #059669; font-size: 23px;">{{$patient->pat_full_name}}</span></h1> -->
            <div class="nav-tabs custom-tabs">
                <button class="nav-tab active" onclick="switchTab(this, 'personal')">
                    <img src="{{ url('assets/img/patient.png') }}" class="menu-icons" alt="">
                    <span>Patient Profile</span>
                </button>
                <button class="nav-tab" onclick="switchTab(this, 'diagnosis')">
                    <img src="{{ url('assets/img/diagnosis.png') }}" class="menu-icons" alt="">
                    <span>Screening & Diagnosis</span>
                </button>
                <button class="nav-tab" onclick="switchTab(this, 'treatment')">
                    <img src="{{ url('assets/img/medical.png') }}" class="menu-icons" alt="">
                    <span>Treatment Information</span>
                </button>
                <button class="nav-tab" onclick="switchTab(this, 'lab')">
                    <img src="{{ url('assets/img/check-up.png') }}" class="menu-icons" alt="">
                    <span>Follow Up & Monitoring</span>
                </button>
            </div>


            <!--  Tab -->
            <div id="personal-tab" class="tab-content active" style="margin-top: 30px;">

                <div class="info-section">
                    <h2 class="section-title">Dianosing Facility</h2>
                    <div class="info-grid">
                        <div>
                            <div class="info-item">
                                <span class="info-label">Facility Name</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->diagnosingFacility->fac_name }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">NTP Facility Code</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->diagnosingFacility->fac_ntp_code }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="info-item">
                                <span class="info-label">Province</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->diagnosingFacility->fac_province }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Region</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->diagnosingFacility->fac_region }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <h2 class="section-title">Patient Demographic</h2>
                    <div class="info-grid gap-5">

                        <div>
                            <div class="info-item">
                                <span class="info-label">Name</span>
                                <span class="info-value d-flex justify-content-end">{{ $patient->pat_full_name }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Date of Birth</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ \Carbon\Carbon::parse($patient->pat_date_of_birth)->format('F j, Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Age</span>
                                <span class="info-value d-flex justify-content-end">{{ $patient->pat_age }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Sex</span>
                                <span class="info-value d-flex justify-content-end">{{ $patient->pat_sex }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Contact Number</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->pat_contact_number }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Permanent Address</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->pat_permanent_address }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">City/ Municipality</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->pat_permanent_city_mun }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Province</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->pat_permanent_province }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Region</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->pat_permanent_region }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Zip Code</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->pat_permanent_zip_code }}</span>
                            </div>
                        </div>

                        <div>
                            <div class="info-item">
                                <span class="info-label">Civil Status</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->pat_civil_status }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Other Contact Info</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->pat_other_contact }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">PhilHealth No</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->pat_philhealth_no }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Nationality</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->pat_nationality }}</span>
                            </div>
                            <br>
                            <br>
                            <div class="info-item">
                                <span class="info-label">Current Address</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->pat_current_address }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">City/ Municipality</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->pat_current_city_mun }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Province</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->pat_current_province }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Region</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->pat_current_region }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Zip Code</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->pat_current_zip_code }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Diagnosis Tab -->
            <div id="diagnosis-tab" class="tab-content" style="margin-top: 30px; display: none;">

                <div class="info-section">
                    <h2 class="section-title">Screening Information</h2>
                    <div class="info-grid gap-5">

                        <div>
                            <div class="info-item">
                                <span class="info-label">Referred by</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->screenings->first()->scr_referred_by }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Location</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->screenings->first()->scr_location }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Type of Referrer</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->screenings->first()->scr_referrer_type }}</span>
                            </div>
                        </div>

                        <div>
                            <div class="info-item">
                                <span class="info-label">Mode of Screening</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->screenings->first()->scr_screening_mode }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Date of Screening</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ \Carbon\Carbon::parse($patient->screenings->first()->scr_screening_date)->format('F j, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <button class="btn btn-sm btn-success float-end" data-bs-toggle="modal"
                        data-bs-target="#editLabTestsModal">
                        <i class="fas fa-add"></i>
                    </button>
                    <h2 class="section-title">Laboratory Tests</h2>
                    <div class="info-grid gap-5">

                        <div>
                            <div class="info-item">
                                <span class="info-label">Xpert MTB/RIF</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ \Carbon\Carbon::parse($patient->screenings->first()->labTests->first()->lab_xpert_test_date)->format('F j, Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Smear Microscopy</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->screenings->first()->labTests->first()->lab_smear_test_date }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Chest X-ray</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ \Carbon\Carbon::parse($patient->screenings->first()->labTests->first()->lab_cxray_test_date)->format('F j, Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Tuberculin Skin Test</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->screenings->first()->labTests->first()->lab_tst_test_date }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Other Test</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->screenings->first()->labTests->first()->lab_other_test_date }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="info-item">
                                <span class="info-label">Result</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->screenings->first()->labTests->first()->lab_xpert_result }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Result</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->screenings->first()->labTests->first()->lab_smear_result }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Result</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->screenings->first()->labTests->first()->lab_cxray_result }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Result</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->screenings->first()->labTests->first()->lab_tst_result }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Result</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->screenings->first()->labTests->first()->lab_other_result }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <button class="btn btn-sm btn-success float-end" data-bs-toggle="modal"
                        data-bs-target="#editDiagnosisModal">
                        <i class="fas fa-add"></i>
                    </button>
                    <h2 class="section-title">Diagnosis</h2>
                    <div class="info-grid gap-5">

                        <div>
                            <div class="info-item">
                                <span class="info-label">Diagnosis Date</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ \Carbon\Carbon::parse($patient->diagnosis->diag_diagnosis_date)->format('F j, Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Notification Date</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ \Carbon\Carbon::parse($patient->diagnosis->diag_notification_date)->format('F j, Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">TB Case Number</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->diagnosis->diag_tb_case_no }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Attending Physician</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->diagnosis->diag_attending_physician }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="info-item">
                                <span class="info-label">Referred to</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->diagnosis->diag_referred_to }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Address</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->diagnosis->diag_address }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Facility Code</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->diagnosis->diag_facility_code }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Province</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->diagnosis->diag_province }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Region</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->diagnosis->diag_region }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <h2 class="section-title">TB Disease Classification</h2>
                    <div class="info-grid gap-5">

                        <div>
                            <div class="info-item">
                                <span class="info-label">Bacteriological Status</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->diagnosis->tbClassification->clas_bacteriological_status }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Drug Resistance status</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->diagnosis->tbClassification->clas_drug_resistance_status }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Other Drug Resistance status</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->diagnosis->tbClassification->clas_other_drug_resistant }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Anatomical Site</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->diagnosis->tbClassification->clas_anatomical_site }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Site Other</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->diagnosis->tbClassification->clas_site_other }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Registration Group</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->diagnosis->tbClassification->clas_registration_group }}</span>
                            </div>
                        </div>
                        <div>

                        </div>
                    </div>
                </div>

            </div>


            <!-- Treatment Plan Tab -->
            <div id="treatment-tab" class="tab-content" style="margin-top: 30px; display: none;">

                <div class="info-section">
                    <h2 class="section-title">Treatment Facility</h2>
                    <div class="info-grid">
                        <div>
                            <div class="info-item">
                                <span class="info-label">Facility Name</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->treatmentFacilities->first()->trea_name }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">NTP Facility Code</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->treatmentFacilities->first()->trea_ntp_code }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="info-item">
                                <span class="info-label">Province</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->treatmentFacilities->first()->trea_province }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Region</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->treatmentFacilities->first()->trea_region }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <button class="btn btn-sm btn-success float-end" data-bs-toggle="modal"
                        data-bs-target="#editTreatmentHistoryModal">
                        <i class="fas fa-add"></i>
                    </button>
                    <h2 class="section-title">History of TB Treatment</h2>
                    <div class="info-grid">
                        <div>
                            <div class="info-item">
                                <span class="info-label">Date Tx Started</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->treatmentHistories->first()->hist_date_tx_started }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Name of Treatment Unit</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->treatmentHistories->first()->hist_treatment_unit }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="info-item">
                                <span class="info-label">Treatment Regimen</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->treatmentHistories->first()->hist_regimen }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Outcome</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->treatmentHistories->first()->hist_outcome }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <button class="btn btn-sm btn-success float-end" data-bs-toggle="modal"
                        data-bs-target="#editComorbiditiesModal">
                        <i class="fas fa-add"></i>
                    </button>
                    <h2 class="section-title">Co-morbidities</h2>
                    <div class="info-grid">
                        <div>
                            <div class="info-item">
                                <span class="info-label">Date Diagnosed</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->comorbidities->first()->com_date_diagnosed }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Type</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->comorbidities->first()->com_type }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="info-item">
                                <span class="info-label">Other</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->comorbidities->first()->com_other }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Treatment</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->comorbidities->first()->com_treatment }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <button class="btn btn-sm btn-success float-end" data-bs-toggle="modal"
                        data-bs-target="#editBaselineModal">
                        <i class="fas fa-add"></i>
                    </button>
                    <h2 class="section-title">Baseline Information</h2>
                    <div class="info-grid">
                        <div>
                            <div class="info-item">
                                <span class="info-label">Height</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->baselineInfos->first()->base_weight }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Weight</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->baselineInfos->first()->base_height }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Other Vital Signs</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->baselineInfos->first()->base_vital_signs }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Emergency Contact</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->baselineInfos->first()->base_emergency_contact_name }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Relationship</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->baselineInfos->first()->base_relationship }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Contact Info</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->baselineInfos->first()->base_contact_info }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Diabetes Screening</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->baselineInfos->first()->base_diabetes_screening }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">FBS Screening</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->baselineInfos->first()->base_fbs_screening }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Date Tested</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ \Carbon\Carbon::parse($patient->baselineInfos->first()->base_date_tested)->format('F j, Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">4Ps Beneficiary?</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->baselineInfos->first()->base_four_ps_beneficiary }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Occupation</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->baselineInfos->first()->base_occupation }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="info-item">
                                <span class="info-label">HIV Information</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->hivInfos->first()->hiv_information }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">HIV Test Date</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->hivInfos->first()->hiv_test_date }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Confirmatory Test Date</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->hivInfos->first()->hiv_confirmatory_test_date }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Result</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->hivInfos->first()->hiv_result }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Started on ARt?</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->hivInfos->first()->hiv_art_started }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Started on CPT?</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->hivInfos->first()->hiv_cpt_started }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <button class="btn btn-sm btn-success float-end" data-bs-toggle="modal"
                        data-bs-target="#editTreatmentOutcomeModal">
                        <i class="fas fa-add"></i>
                    </button>
                    <h2 class="section-title">Treatment Regimen</h2>
                    <div class="info-grid">
                        <div>
                            <div class="info-item">
                                <span class="info-label">Regimen Type at Start of Treatment</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->treatmentRegimens->first()->reg_start_type }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Treatment Start Date</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ \Carbon\Carbon::parse($patient->treatmentRegimens->first()->reg_start_date)->format('F j, Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Regimen Type at End of Treatment</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->treatmentRegimens->first()->reg_end_type }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="info-item">
                                <span class="info-label">Outcome</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->treatmentOutcomes->first()->out_outcome }}</span>
                            </div>
                            <br>
                            <div class="info-item">
                                <span class="info-label">Date of Outcome</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->treatmentOutcomes->first()->out_date }}</span>
                            </div>
                            <br>
                            <div class="info-item">
                                <span class="info-label">Reason</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->treatmentOutcomes->first()->out_reason }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <button class="btn btn-sm btn-success float-end" data-bs-toggle="modal"
                        data-bs-target="#editPrescribedDrugsModal">
                        <i class="fas fa-add"></i>
                    </button>
                    <h2 class="section-title">Prescribed Drugs</h2>
                    <div class="info-grid">
                        <div>
                            <div class="info-item">
                                <span class="info-label">Date Start</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ \Carbon\Carbon::parse($patient->prescribedDrugs->first()->drug_start_date)->format('F j, Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Drug</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->prescribedDrugs->first()->drug_name }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Strength</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->prescribedDrugs->first()->drug_strength }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Unit</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->prescribedDrugs->first()->drug_unit }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="info-item">
                                <span class="info-label">Continuation</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->prescribedDrugs->first()->drug_con_date }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Drug</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->prescribedDrugs->first()->drug_con_name }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Strength</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->prescribedDrugs->first()->drug_con_strength }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Unit</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->prescribedDrugs->first()->drug_con_unit }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <button class="btn btn-sm btn-success float-end" data-bs-toggle="modal"
                        data-bs-target="#editAdministrationModal">
                        <i class="fas fa-add"></i>
                    </button>
                    <h2 class="section-title">Administration of Drugs</h2>
                    <div class="info-grid">
                        <div>
                            <div class="info-item">
                                <span class="info-label">Location of Treatment</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->txSupporters->first()->sup_location }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Name</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->txSupporters->first()->sup_name }}</span>
                            </div>
                            <br>
                            <div class="info-item">
                                <span class="info-label">Designation</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->txSupporters->first()->sup_designation }}</span>
                            </div>
                            <br>
                            <div class="info-item">
                                <span class="info-label">Tx Supporter Type</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->txSupporters->first()->sup_type }}</span>
                            </div>
                            <br>
                            <div class="info-item">
                                <span class="info-label">Tx Supporter Contact</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->txSupporters->first()->sup_contact_info }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Schedule of Treatment</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->txSupporters->first()->sup_treatment_schedule }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Name of DAT/s Used</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->txSupporters->first()->sup_dat_used }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="info-item">
                                <span class="info-label">Intensive Phase Start Date</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ \Carbon\Carbon::parse($patient->adherences->first()->pha_intensive_start)->format('F j, Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Intensive Phase End Date</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->adherences->first()->pha_intensive_end }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Continuation Phase Start Date</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->adherences->first()->pha_continuation_start }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Continuation Phase End Date</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->adherences->first()->pha_continuation_end }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Weight</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->adherences->first()->pha_weight }}</span>
                            </div>
                            <br>
                            <div class="info-item">
                                <span class="info-label">Height(cm) for Children</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->adherences->first()->pha_child_height }}</span>
                            </div>
                        </div>
                    </div>
                </div>



            </div>


            <!-- Lab Results Tab -->
            <div id="lab-tab" class="tab-content" style="margin-top: 30px; display: none;">

                <div class="info-section">
                    <button class="btn btn-sm btn-success float-end" data-bs-toggle="modal"
                        data-bs-target="#editAdverseEventModal">
                        <i class="fas fa-add"></i>
                    </button>
                    <h2 class="section-title">Serious Adverse Events and AEs of Special Interest</h2>
                    <div class="info-grid">
                        <div>
                            <div class="info-item">
                                <span class="info-label">Date of AE</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->adverseEvents->first()->adv_ae_date }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Specific AE</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->adverseEvents->first()->adv_specific_ae }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Date Reported to FDA</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->adverseEvents->first()->adv_fda_reported_date }}</span>
                            </div>
                        </div>
                        <div>

                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <button class="btn btn-sm btn-success float-end" data-bs-toggle="modal"
                        data-bs-target="#editProgressModal">
                        <i class="fas fa-add"></i>
                    </button>
                    <h2 class="section-title">Patient Progress Report Form</h2>
                    <div class="info-grid">
                        <div>
                            <div class="info-item">
                                <span class="info-label">Date</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->progress->first()->prog_date }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Problem</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->progress->first()->prog_problem }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Action Taken</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->progress->first()->prog_action_taken }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Plan</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->progress->first()->prog_plan }}</span>
                            </div>
                        </div>
                        <div>

                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <button class="btn btn-sm btn-success float-end" data-bs-toggle="modal"
                        data-bs-target="#editCloseContactModal">
                        <i class="fas fa-add"></i>
                    </button>
                    <h2 class="section-title">Close Contact</h2>
                    <div class="info-grid">
                        <div>
                            <div class="info-item">
                                <span class="info-label">Name</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->close_contacts->first()->con_name }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Age</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->close_contacts->first()->con_age }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Sex</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->close_contacts->first()->con_sex }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Relationship</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->close_contacts->first()->con_relationship }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Initial Screening</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->close_contacts->first()->con_initial_screening }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Ff-up</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->close_contacts->first()->con_follow_up }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Remarks</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->close_contacts->first()->con_remarks }}</span>
                            </div>
                        </div>
                        <div>

                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <button class="btn btn-sm btn-success float-end" data-bs-toggle="modal"
                        data-bs-target="#editSputumModal">
                        <i class="fas fa-add"></i>
                    </button>
                    <h2 class="section-title">Sputum Monitoring</h2>
                    <div class="info-grid">
                        <div>
                            <div class="info-item">
                                <span class="info-label">Date Collected</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->sputum_monitorings->first()->sput_date_collected }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Smear Microscopy/ TB LAMP</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->sputum_monitorings->first()->sput_smear_result }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Xpert MTB/RIF</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->sputum_monitorings->first()->sput_xpert_result }}</span>
                            </div>
                        </div>
                        <div>

                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <button class="btn btn-sm btn-success float-end" data-bs-toggle="modal"
                        data-bs-target="#editChestXrayModal">
                        <i class="fas fa-add"></i>
                    </button>
                    <h2 class="section-title">Chest X-ray</h2>
                    <div class="info-grid">
                        <div>
                            <div class="info-item">
                                <span class="info-label">Date Examined</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->chestXrays->first()->xray_date_examined }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Impression/ Comparative Reading</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->chestXrays->first()->xray_impression }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Descriptive Comments</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->chestXrays->first()->xray_descriptive_comment }}</span>
                            </div>
                        </div>
                        <div>

                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <button class="btn btn-sm btn-success float-end" data-bs-toggle="modal"
                        data-bs-target="#editPostTreatmentModal">
                        <i class="fas fa-add"></i>
                    </button>
                    <h2 class="section-title">Post Treatment Follow-up</h2>
                    <div class="info-grid">
                        <div>
                            <div class="info-item">
                                <span class="info-label">Mo.Afer Tx</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->postTreatment->first()->fol_months_after_tx }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Date</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->postTreatment->first()->fol_date }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">CXR Findings</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->postTreatment->first()->fol_cxr_findings }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Smear/ Xpert</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->postTreatment->first()->fol_smear_xpert }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">TBC & DST</span>
                                <span
                                    class="info-value d-flex justify-content-end">{{ $patient->postTreatment->first()->fol_tbc_dst }}</span>
                            </div>
                        </div>
                        <div>

                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Laboratory Tests Modal -->
        <div class="modal fade" id="editLabTestsModal" tabindex="-1" aria-labelledby="editLabTestsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editLabTestsModalLabel">Laboratory Tests</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- ✅ Connected to store route -->
                    <form method="POST" action="{{ route('laboratory-tests.store', $patient->id) }}">
                        @csrf
                        <div class="modal-body">
                            <!-- Smear Microscopy -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="lab_smear_test_date" class="form-label">Smear Microscopy (Date)</label>
                                    <input type="date" class="form-control" id="lab_smear_test_date"
                                        name="lab_smear_test_date" max="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lab_smear_result" class="form-label">Smear Microscopy Result</label>
                                    <input type="text" class="form-control" id="lab_smear_result"
                                        name="lab_smear_result" placeholder="Result (e.g. Negative, 1+, etc.)">
                                </div>
                            </div>

                            <!-- Tuberculin Skin Test -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="lab_tst_test_date" class="form-label">Tuberculin Skin Test (Date)</label>
                                    <input type="date" class="form-control" id="lab_tst_test_date"
                                        name="lab_tst_test_date" max="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lab_tst_result" class="form-label">TST Result</label>
                                    <input type="text" class="form-control" id="lab_tst_result"
                                        name="lab_tst_result" placeholder="Result (e.g. Positive, Negative)">
                                </div>
                            </div>

                            <!-- Other Tests -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="lab_other_test_date" class="form-label">Other Test (Date)</label>
                                    <input type="date" class="form-control" id="lab_other_test_date"
                                        name="lab_other_test_date" max="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lab_other_result" class="form-label">Other Test Result</label>
                                    <input type="text" class="form-control" id="lab_other_result"
                                        name="lab_other_result" placeholder="Result (optional)">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Referral Modal -->
        <div class="modal fade" id="editDiagnosisModal" tabindex="-1" aria-labelledby="editDiagnosisModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDiagnosisModalLabel">Referral</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- ✅ Add action route -->
                    <form method="POST" action="{{ route('referrals.store', $patient->id) }}">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="diag_referred_to" class="form-label">Referred to</label>
                                    <input type="text" class="form-control" id="diag_referred_to"
                                        name="diag_referred_to" placeholder="Referred to">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="diag_address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="diag_address"
                                        name="diag_address" placeholder="Address">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="diag_facility_code" class="form-label">Facility Code</label>
                                    <input type="text" class="form-control" id="diag_facility_code"
                                        name="diag_facility_code" placeholder="Facility code">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="diag_province" class="form-label">Province</label>
                                    <input type="text" class="form-control" id="diag_province"
                                        name="diag_province" placeholder="Province">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="diag_region" class="form-label">Region</label>
                                    <input type="text" class="form-control" id="diag_region"
                                        name="diag_region" placeholder="Region">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- History of TB Treatment Modal -->
        <div class="modal fade" id="editTreatmentHistoryModal" tabindex="-1"
            aria-labelledby="editTreatmentHistoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTreatmentHistoryModalLabel">History of TB Treatment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- ✅ Add route for storing treatment history -->
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
                                <input type="text" class="form-control" id="hist_regimen"
                                    name="hist_regimen" placeholder="Treatment regimen" required>
                            </div>

                            <div class="mb-3">
                                <label for="hist_outcome" class="form-label">Outcome</label>
                                <select class="form-control form-select" id="hist_outcome" name="hist_outcome" required>
                                    <option value="" disabled selected>Please Select</option>
                                    <option value="Cured">Cured</option>
                                    <option value="Treatment Completed">Treatment Completed</option>
                                    <option value="Lost to Follow-up">Lost to Follow-up</option>
                                    <option value="Died">Died</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Co-morbidities Modal -->
        <div class="modal fade" id="editComorbiditiesModal" tabindex="-1" aria-labelledby="editComorbiditiesModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editComorbiditiesModalLabel">Co-morbidities</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- ✅ Add form action for saving co-morbidity -->
                    <form method="POST" action="{{ route('comorbidities.store', $patient->id) }}">
                        @csrf

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="com_date_diagnosed" class="form-label">Date Diagnosed</label>
                                <input type="date" class="form-control" id="com_date_diagnosed"
                                    name="com_date_diagnosed" max="<?php echo date('Y-m-d'); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="com_type" class="form-label">Type</label>
                                <select class="form-control form-select" id="com_type" name="com_type" required>
                                    <option value="">Please Select</option>
                                    <option value="Diabetes Mellitus">Diabetes Mellitus</option>
                                    <option value="Mental Illness">Mental Illness</option>
                                    <option value="Substance Abuse">Substance Abuse</option>
                                    <option value="Liver Disease">Liver Disease</option>
                                    <option value="Renal Disease">Renal Disease</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="com_other" class="form-label">Other (Specify)</label>
                                <input type="text" class="form-control" id="com_other" name="com_other"
                                    placeholder="Specify">
                            </div>

                            <div class="mb-3">
                                <label for="com_treatment" class="form-label">Treatment</label>
                                <input type="text" class="form-control" id="com_treatment"
                                    name="com_treatment" placeholder="Treatment">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBaselineModalLabel">HIV Baseline Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- ✅ Form with action route -->
                    <form method="POST" action="{{ route('hiv.store', $patient->id) }}">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="hiv_information" class="form-label">HIV Information</label>
                                    <input type="text" class="form-control" id="hiv_information" name="hiv_information"
                                        placeholder="HIV Information">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="hiv_test_date" class="form-label">HIV Test Date</label>
                                    <input type="date" class="form-control" id="hiv_test_date" name="hiv_test_date"
                                        max="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="hiv_confirmatory_test_date" class="form-label">Confirmatory Test Date</label>
                                    <input type="date" class="form-control" id="hiv_confirmatory_test_date"
                                        name="hiv_confirmatory_test_date" max="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="hiv_result" class="form-label">Result</label>
                                    <input type="text" name="hiv_result" id="hiv_result" class="form-control"
                                        placeholder="Result">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="hiv_art_started" class="form-label">Started on ART?</label>
                                    <select class="form-control form-select" id="hiv_art_started" name="hiv_art_started">
                                        <option value="">Please Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="hiv_cpt_started" class="form-label">Started on CPT?</label>
                                    <select class="form-control form-select" id="hiv_cpt_started" name="hiv_cpt_started">
                                        <option value="">Please Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Treatment Outcome Modal -->
        <div class="modal fade" id="editTreatmentOutcomeModal" tabindex="-1"
            aria-labelledby="editTreatmentOutcomeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTreatmentRegimenModalLabel">Treatment Regimen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- ✅ Form with route and CSRF -->
                    <form method="POST" action="{{ route('treatment-outcome.store', $patient->id) }}">
                        @csrf
                        <div class="modal-body">
                            <div class="row">

                                <div class="mb-3">
                                    <label for="out_outcome" class="form-label">Outcome</label>
                                    <select class="form-control form-select" id="out_outcome" name="out_outcome" required>
                                        <option value="">Please Select</option>
                                        <option value="Cured">Cured</option>
                                        <option value="Treatment Completed">Treatment Completed</option>
                                        <option value="Lost to Follow-up">Lost to Follow-up</option>
                                        <option value="Died">Died</option>
                                    </select>
                                </div>
                            </div>

                                <div class="mb-3">
                                    <label for="out_date" class="form-label">Date of Outcome</label>
                                    <input type="date" class="form-control" id="out_date" name="out_date"
                                        max="<?php echo date('Y-m-d'); ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="out_reason" class="form-label">Reason</label>
                                    <input type="text" class="form-control" id="out_reason" name="out_reason"
                                        placeholder="Reason">
                                </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Prescribed Drugs Modal -->
        <div class="modal fade" id="editPrescribedDrugsModal" tabindex="-1"
            aria-labelledby="editPrescribedDrugsModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPrescribedDrugsModalLabel">Prescribed Drugs</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- ✅ Form with route -->
                    <form method="POST" action="{{ route('prescribed-drugs.store', $patient->id) }}">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="drug_con_date" class="form-label">Continuation Date</label>
                                <input type="date" class="form-control" id="drug_con_date" name="drug_con_date"
                                    max="<?php echo date('Y-m-d'); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="drug_con_name" class="form-label">Drug</label>
                                <input type="text" class="form-control" id="drug_con_name" name="drug_con_name"
                                    placeholder="Drug name" required>
                            </div>

                            <div class="mb-3">
                                <label for="drug_con_strength" class="form-label">Strength</label>
                                <input type="text" class="form-control" id="drug_con_strength" name="drug_con_strength"
                                    placeholder="Strength (e.g. 500mg)">
                            </div>

                            <div class="mb-3">
                                <label for="drug_con_unit" class="form-label">Unit</label>
                                <input type="text" class="form-control" id="drug_con_unit" name="drug_con_unit"
                                    placeholder="Unit (e.g. tablet, capsule)">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
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
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAdministrationModalLabel">Administration of Drugs</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="pha_intensive_end" class="form-label">Intensive Phase End
                                        Date</label>
                                    <input type="date" class="form-control" id="pha_intensive_end"
                                        name="pha_intensive_end" max="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="pha_continuation_start" class="form-label">Continuation Phase Start
                                        Date</label>
                                    <input type="date" class="form-control" id="pha_continuation_start"
                                        name="pha_continuation_start" max="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="pha_weight" class="form-label">Weight (kg)</label>
                                    <input type="number" step="0.01" class="form-control" id="pha_weight"
                                        name="pha_weight">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="pha_continuation_end" class="form-label">Continuation Phase End
                                        Date</label>
                                    <input type="date" class="form-control" id="pha_continuation_end"
                                        name="pha_continuation_end" max="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="pha_child_height" class="form-label">Height (cm) for
                                        Children</label>
                                    <input type="number" step="0.01" class="form-control" id="pha_child_height"
                                        name="pha_child_height">
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
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

                    <div class="modal-header">
                        <h5 class="modal-title" id="editAdverseEventModalLabel">
                            Add Serious Adverse Event
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


        <!-- Patient Progress Modal -->
        <div class="modal fade" id="editProgressModal" tabindex="-1" aria-labelledby="editProgressModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProgressModalLabel">Patient Progress Report Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Laravel Route for storing progress -->
                    <form method="POST" action="{{ route('patient-progress.store', $patient->id) }}">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="prog_date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="prog_date" name="prog_date"
                                    max="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="prog_problem" class="form-label">Problem</label>
                                <input type="text" class="form-control" id="prog_problem" name="prog_problem" placeholder="Problem" required>
                            </div>
                            <div class="mb-3">
                                <label for="prog_action_taken" class="form-label">Action Taken</label>
                                <input type="text" class="form-control" id="prog_action_taken" name="prog_action_taken" placeholder="Action taken" required>
                            </div>
                            <div class="mb-3">
                                <label for="prog_plan" class="form-label">Plan</label>
                                <input type="text" class="form-control" id="prog_plan" name="prog_plan" placeholder="Plan" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCloseContactModalLabel">Close Contact</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Laravel Route for storing close contact -->
                    <form method="POST" action="{{ route('close-contact.store', $patient->id) }}">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="con_name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="con_name" name="con_name" placeholder="Name" required>
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
                                        <option value="">Please Select</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="con_relationship" class="form-label">Relationship</label>
                                    <input type="text" class="form-control" id="con_relationship" name="con_relationship" placeholder="Relationship" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="con_initial_screening" class="form-label">Initial Screening</label>
                                    <input type="date" class="form-control" id="con_initial_screening" name="con_initial_screening" max="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="con_follow_up" class="form-label">Follow-up</label>
                                    <input type="date" class="form-control" id="con_follow_up" name="con_follow_up" max="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="con_remarks" class="form-label">Remarks</label>
                                    <input type="text" class="form-control" id="con_remarks" name="con_remarks" placeholder="Remarks">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

                    <div class="modal-header">
                        <h5 class="modal-title" id="editSputumModalLabel">Add Sputum Monitoring Result</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Important: route should point to sputum.store (create new) -->
                    <form action="{{ route('sputum.store', $patient->id) }}" method="POST">
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
                                <input type="text" class="form-control" id="sput_smear_result" name="sput_smear_result" placeholder="Smear microscopy / tb lamp">
                            </div>

                            <!-- Xpert MTB/RIF -->
                            <div class="mb-3">
                                <label for="sput_xpert_result" class="form-label">Xpert MTB/RIF</label>
                                <input type="text" class="form-control" id="sput_xpert_result" name="sput_xpert_result" placeholder="Xpert mtb / rif" required>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                    <div class="modal-header">
                        <h5 class="modal-title" id="editChestXrayModalLabel">Chest X-ray</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                    <option value="" disabled selected>Please Select</option>
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
                                    name="xray_descriptive_comment" placeholder="Descriptive comments">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPostTreatmentModalLabel">Post Treatment Follow-up</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- ✅ Add action route -->
                    <form method="POST" action="{{ route('post-treatment-follow-up.store', $patient->id) }}">
                        @csrf

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fol_months_after_tx" class="form-label">Months After Treatment</label>
                                    <input type="number" class="form-control" id="fol_months_after_tx"
                                        name="fol_months_after_tx" placeholder="Mo. after treatment" required>
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
                                        name="fol_cxr_findings" placeholder="Cxr findings">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fol_smear_xpert" class="form-label">Smear / Xpert</label>
                                    <input type="text" class="form-control" id="fol_smear_xpert"
                                        name="fol_smear_xpert" placeholder="Smear /xpert">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fol_tbc_dst" class="form-label">TBC & DST</label>
                                    <input type="text" class="form-control" id="fol_tbc_dst" name="fol_tbc_dst" placeholder="Tbc & dst">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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


</body>

</html>