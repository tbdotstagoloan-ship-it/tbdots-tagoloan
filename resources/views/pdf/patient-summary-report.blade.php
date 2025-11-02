<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Patient Summary Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #222;
            margin: 40px;
            line-height: 1.5;
        }

        /* HEADER */
        .header {
            width: 100%;
            border-bottom: 2px solid #28a745;
            padding-bottom: 10px;
            margin-bottom: 25px;
            position: relative;
            min-height: 90px;
        }

        .header img.left-logo {
            position: absolute;
            left: 0;
            top: -5px;
            width: 105px;
            height: 105px;
            object-fit: contain;
        }

        .header img.right-logo {
            position: absolute;
            right: 0;
            top: 0;
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        .header .text {
            text-align: center;
            margin: 0 100px;
            padding-top: 5px;
        }

        .header h4 {
            margin: 0;
            font-size: 13px;
            color: #555;
        }

        .header h3 {
            margin: 8px 0 2px;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            color: #1f5124;
        }

        /* REPORT TITLE */
        .report-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            color: #1d4120;
            margin: 20px 0 10px;
        }

        /* SECTION */
        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #1f5124;
            text-transform: uppercase;
            border-bottom: 1px solid #28a745;
            padding-bottom: 4px;
            margin-bottom: 10px;
        }

        /* INFO TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        td {
            padding: 6px 8px;
            vertical-align: top;
        }

        .info-label {
            width: 200px;
            font-weight: bold;
            color: #333;
        }

        .info-value {
            color: #000;
        }

        /* NO RECORD TEXT */
        .no-record {
            font-style: italic;
            color: #666;
            text-align: center;
            padding: 10px 0;
        }

        /* FOOTER */
        .footer {
            text-align: center;
            font-size: 11px;
            color: #555;
            margin-top: 30px;
            border-top: 1px solid #ccc;
            padding-top: 8px;
            font-style: italic;
        }

        /* SIGNATURE */
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: flex-end;
            text-align: center;
        }

        .signature {
            width: 250px;
            border-top: 1px solid #000;
            padding-top: 5px;
            font-size: 13px;
        }

        .signature-title {
            font-weight: bold;
            text-transform: uppercase;
        }

        .signature-subtitle {
            font-size: 11px;
            color: #555;
        }

        @page {
            margin: 40px;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <img src="{{ public_path('assets/img/tbdots-logo-2.png') }}" class="left-logo" alt="Logo Left">
        <div class="text">
            <h4>Republic of the Philippines</h4>
            <h4>Municipality of Tagoloan</h4>
            <h3>TB DOTS Tagoloan</h3>
        </div>
        <img src="{{ public_path('assets/img/tbdots-logo-1.png') }}" class="right-logo" alt="Logo Right">
    </div>

    <!-- TITLE -->
    <div class="report-title">Patient Summary Report</div>

    <!-- SECTION: DIAGNOSING FACILITY -->



    <!-- SECTION: PATIENT DEMOGRAPHIC -->
    <div class="section">
        <div class="section-title">Patient Demographic</div>
        <table>
            <tr>
                <td class="info-label">Full Name:</td>
                <td class="info-value">{{ $patient->name }}</td>
            </tr>
            <tr>
                <td class="info-label">Date of Birth:</td>
                <td class="info-value">
                    {{ \Carbon\Carbon::parse($patient->birth_date)->format('F j, Y') }}
                </td>
            </tr>
            <tr>
                <td class="info-label">Age:</td>
                <td class="info-value">{{ $patient->age }}</td>
            </tr>
            <tr>
                <td class="info-label">Sex:</td>
                <td class="info-value">{{ $patient->sex }}</td>
            </tr>
            <tr>
                <td class="info-label">Civil Status:</td>
                <td class="info-value">{{ $patient->civil_status }}</td>
            </tr>
            <tr>
                <td class="info-label">Nationality:</td>
                <td class="info-value">{{ $patient->nationality }}</td>
            </tr>
            <tr>
                <td class="info-label">Contact Number:</td>
                <td class="info-value">{{ $patient->contact }}</td>
            </tr>
            <tr>
                <td class="info-label">Other Contact Info:</td>
                <td class="info-value">{{ $patient->other_contact }}</td>
            </tr>
            <tr>
                <td class="info-label">PhilHealth No:</td>
                <td class="info-value">{{ $patient->philhealth_no }}</td>
            </tr>
            <tr>
                <td class="info-label">Address:</td>
                <td class="info-value">
                    {{ $patient->address }}, {{ $patient->city }}, {{ $patient->province }}, {{ $patient->region }},
                    {{ $patient->zip_code }}
                </td>
            </tr>
        </table>
    </div>

    <!-- SECTION: SCREENING INFORMATION -->
    <div class="section">
        <div class="section-title">Screening Information</div>
        <table>
            <tr>
                <td class="info-label">Referred by:</td>
                <td class="info-value">{{ $patient->scr_referred_by }}</td>
            </tr>
            <tr>
                <td class="info-label">Type of Referrer:</td>
                <td class="info-value">{{ $patient->scr_referrer_type }}</td>
            </tr>
            <tr>
                <td class="info-label">Location:</td>
                <td class="info-value">{{ $patient->scr_location }}</td>
            </tr>
            <tr>
                <td class="info-label">Mode of Screening:</td>
                <td class="info-value">{{ $patient->scr_screening_mode }}</td>
            </tr>
            <tr>
                <td class="info-label">Date of Screening:</td>
                <td class="info-value">{{ $patient->scr_screening_date }}</td>
            </tr>
        </table>
    </div>

    <!-- SECTION: DIAGNOSIS -->
    <div class="section">
        <div class="section-title">Diagnosis</div>
        <table>
            <tr>
                <td class="info-label">Diagnosis Date:</td>
                <td class="info-value">{{ $patient->diag_diagnosis_date }}</td>
            </tr>
            <tr>
                <td class="info-label">Notification Date:</td>
                <td class="info-value">{{ $patient->diag_notification_date }}</td>
            </tr>
            <tr>
                <td class="info-label">TB Case Number:</td>
                <td class="info-value">{{ $patient->diag_tb_case_no }}</td>
            </tr>
            <tr>
                <td class="info-label">Attending Physician:</td>
                <td class="info-value">{{ $patient->diag_attending_physician }}</td>
            </tr>
        </table>
    </div>

    <!-- SECTION: TB DISEASE CLASSIFICATION -->
    <div class="section">
        <div class="section-title">TB Disease Classification</div>
        <table>
            <tr>
                <td class="info-label">Bacteriological Status:</td>
                <td class="info-value">{{ $patient->clas_bacteriological_status }}</td>
            </tr>
            <tr>
                <td class="info-label">Drug Resistance Status:</td>
                <td class="info-value">{{ $patient->clas_drug_resistance_status }}</td>
            </tr>
            <tr>
                <td class="info-label">Other Drug Resistance Status:</td>
                <td class="info-value">{{ $patient->clas_other_drug_resistant }}</td>
            </tr>
            <tr>
                <td class="info-label">Anatomical Site:</td>
                <td class="info-value">{{ $patient->clas_anatomical_site }}</td>
            </tr>
            <tr>
                <td class="info-label">Extra-pulmonary Site:</td>
                <td class="info-value">{{ $patient->clas_site_other }}</td>
            </tr>
            <tr>
                <td class="info-label">Registration Group:</td>
                <td class="info-value">{{ $patient->clas_registration_group }}</td>
            </tr>
        </table>
    </div>

    <!-- SECTION: TREATMENT FACILITY -->
    <div class="section">
        <div class="section-title">Treatment Facility</div>
        <table>
            <tr>
                <td class="info-label">Facility Name:</td>
                <td class="info-value">{{ $patient->trea_name }}</td>
            </tr>
            <tr>
                <td class="info-label">NTP Facility Code:</td>
                <td class="info-value">
                    {{ $patient->trea_ntp_code }}
                </td>
            </tr>
            <tr>
                <td class="info-label">Province:</td>
                <td class="info-value">{{ $patient->trea_province }}</td>
            </tr>
            <tr>
                <td class="info-label">Region:</td>
                <td class="info-value">{{ $patient->trea_region }}</td>
            </tr>
        </table>
    </div>

    <!-- SECTION: HISTORY OF TB TREATMENT -->
    <div class="section">
        <div class="section-title">History of TB Treatment</div>
        <table>
            <tr>
                <td class="info-label">Date Tx Started:</td>
                <td class="info-value">{{ $patient->hist_date_tx_started }}</td>
            </tr>
            <tr>
                <td class="info-label">Name of Treatment Unit:</td>
                <td class="info-value">{{ $patient->hist_treatment_unit }}</td>
            </tr>
            <tr>
                <td class="info-label">Drug:</td>
                <td class="info-value">{{ $patient->hist_drug }}</td>
            </tr>
            <tr>
                <td class="info-label">Treatment Duration:</td>
                <td class="info-value">{{ $patient->hist_treatment_duration }}</td>
            </tr>
            <tr>
                <td class="info-label">Outcome:</td>
                <td class="info-value">{{ $patient->hist_outcome }}</td>
            </tr>
        </table>
    </div>

    @if($patient->com_date_diagnosed || $patient->com_type || $patient->com_other || $patient->com_treatment)
        <!-- SECTION: CO-MORBIDITIES -->
        <div class="section">
            <div class="section-title">Co-morbidities</div>
            <table>
                @if($patient->com_date_diagnosed)
                    <tr>
                        <td class="info-label">Date Diagnosed:</td>
                        <td class="info-value">{{ $patient->com_date_diagnosed }}</td>
                    </tr>
                @endif

                @if($patient->com_type)
                    <tr>
                        <td class="info-label">Type:</td>
                        <td class="info-value">{{ $patient->com_type }}</td>
                    </tr>
                @endif

                @if($patient->com_other)
                    <tr>
                        <td class="info-label">Other:</td>
                        <td class="info-value">{{ $patient->com_other }}</td>
                    </tr>
                @endif

                @if($patient->com_treatment)
                    <tr>
                        <td class="info-label">Treatment:</td>
                        <td class="info-value">{{ $patient->com_treatment }}</td>
                    </tr>
                @endif
            </table>
        </div>
    @endif


    <!-- SECTION: BASELINE INFORMATION -->
    <div class="section">
        <div class="section-title">Baseline Information</div>
        <table>
            <tr>
                <td class="info-label">Height:</td>
                <td class="info-value">{{ $patient->base_height }}</td>
            </tr>
            <tr>
                <td class="info-label">Weight:</td>
                <td class="info-value">{{ $patient->base_weight }}</td>
            </tr>
            <tr>
                <td class="info-label">Blood Pressure:</td>
                <td class="info-value">{{ $patient->base_blood_pressure }}</td>
            </tr>
            <tr>
                <td class="info-label">Pulse Rate:</td>
                <td class="info-value">{{ $patient->base_pulse_rate }}</td>
            </tr>
            <tr>
                <td class="info-label">Temperature:</td>
                <td class="info-value">{{ $patient->base_temperature }}</td>
            </tr>
            <tr>
                <td class="info-label">Diabetes Screening:</td>
                <td class="info-value">{{ $patient->base_diabetes_screening }}</td>
            </tr>
            <tr>
                <td class="info-label">FBS Screening:</td>
                <td class="info-value">{{ $patient->base_fbs_screening }}</td>
            </tr>
            <tr>
                <td class="info-label">Date Tested:</td>
                <td class="info-value">{{ $patient->base_date_tested }}</td>
            </tr>
            <tr>
                <td class="info-label">4Ps Beneficiary:</td>
                <td class="info-value">{{ $patient->base_four_ps_beneficiary }}</td>
            </tr>
            <tr>
                <td class="info-label">Person to Notify In Case of Emergency:</td>
                <td class="info-value">{{ $patient->base_emergency_contact_name }}</td>
            </tr>
            <tr>
                <td class="info-label">Relationship:</td>
                <td class="info-value">{{ $patient->base_relationship }}</td>
            </tr>
            <tr>
                <td class="info-label">Contact Information:</td>
                <td class="info-value">{{ $patient->base_contact_info }}</td>
            </tr>
            <tr>
                <td class="info-label">Occupation:</td>
                <td class="info-value">{{ $patient->base_occupation }}</td>
            </tr>
        </table>
    </div>

    @if($patient->hiv_information || $patient->hiv_test_date || $patient->hiv_confirmatory_test_date || $patient->hiv_result || $patient->hiv_art_started || $patient->hiv_cpt_started)
        <!-- SECTION: HIV INFORMATION -->
        <div class="section">
            <div class="section-title">HIV Information</div>
            <table>
                @if($patient->hiv_information)
                    <tr>
                        <td class="info-label">HIV Information:</td>
                        <td class="info-value">{{ $patient->hiv_information }}</td>
                    </tr>
                @endif

                @if($patient->hiv_test_date)
                    <tr>
                        <td class="info-label">HIV Test Date:</td>
                        <td class="info-value">{{ $patient->hiv_test_date }}</td>
                    </tr>
                @endif

                @if($patient->hiv_confirmatory_test_date)
                    <tr>
                        <td class="info-label">Confirmatory Test Date:</td>
                        <td class="info-value">{{ $patient->hiv_confirmatory_test_date }}</td>
                    </tr>
                @endif

                @if($patient->hiv_result)
                    <tr>
                        <td class="info-label">Result:</td>
                        <td class="info-value">{{ $patient->hiv_result }}</td>
                    </tr>
                @endif

                @if($patient->hiv_art_started)
                    <tr>
                        <td class="info-label">Started on ART:</td>
                        <td class="info-value">{{ $patient->hiv_art_started }}</td>
                    </tr>
                @endif

                @if($patient->hiv_cpt_started)
                    <tr>
                        <td class="info-label">Started on CPT:</td>
                        <td class="info-value">{{ $patient->hiv_cpt_started }}</td>
                    </tr>
                @endif
            </table>
        </div>
    @endif


    <!-- SECTION: TREATMENT REGIMEN -->
    <div class="section">
        <div class="section-title">Treatment Regimen</div>
        <table>
            <tr>
                <td class="info-label">Regimen Type at Start of Treatment:</td>
                <td class="info-value">{{ $patient->reg_start_type }}</td>
            </tr>
            <tr>
                <td class="info-label">Treatment Start Date:</td>
                <td class="info-value">
                    {{ $patient->reg_start_date }}
                </td>
            </tr>
            <tr>
                <td class="info-label">Regimen Type at End of Treatment:</td>
                <td class="info-value">{{ $patient->reg_end_type }}</td>
            </tr>
        </table>
    </div>

    <!-- SECTION: ADMINISTRATION OF DRUGS -->
    <div class="section">
        <div class="section-title">Administration of Drugs</div>
        <table>
            <tr>
                <td class="info-label">Location of Treatment:</td>
                <td class="info-value">{{ $patient->sup_location }}</td>
            </tr>
            <tr>
                <td class="info-label">Supporter Name:</td>
                <td class="info-value">
                    {{ $patient->sup_name }}
                </td>
            </tr>
            <tr>
                <td class="info-label">Designation:</td>
                <td class="info-value">{{ $patient->sup_designation }}</td>
            </tr>
            <tr>
                <td class="info-label">Supporter Type:</td>
                <td class="info-value">{{ $patient->sup_type }}</td>
            </tr>
            <tr>
                <td class="info-label">Contact Information:</td>
                <td class="info-value">{{ $patient->sup_contact_info }}</td>
            </tr>
            <tr>
                <td class="info-label">Name of Dat/s Used:</td>
                <td class="info-value">{{ $patient->sup_dat_used }}</td>
            </tr>
            <tr>
                <td class="info-label">Schedule of Treatment:</td>
                <td class="info-value">{{ $patient->sup_treatment_schedule }}</td>
            </tr>
            <tr>
                <td class="info-label">Intensive Phase Start:</td>
                <td class="info-value">{{ $patient->pha_intensive_start }}</td>
            </tr>
            <tr>
                <td class="info-label">Intensive Phase End:</td>
                <td class="info-value">{{ $patient->pha_intensive_end }}</td>
            </tr>
            <tr>
                <td class="info-label">Continuation Phase Start:</td>
                <td class="info-value">{{ $patient->pha_continuation_start }}</td>
            </tr>
            <tr>
                <td class="info-label">Continuation Phase End:</td>
                <td class="info-value">{{ $patient->pha_continuation_end }}</td>
            </tr>
            <tr>
                <td class="info-label">Weight:</td>
                <td class="info-value">{{ $patient->pha_weight }}</td>
            </tr>
            <tr>
                <td class="info-label">Height for Children:</td>
                <td class="info-value">{{ $patient->pha_child_height }}</td>
            </tr>
        </table>
    </div>

    <!-- SECTION: PRESCRIBED DRUGS -->
    <div class="section">
        <div class="section-title">Prescribed Drugs</div>
        <table>
            <tr>
                <td class="info-label">Intensive Start Date:</td>
                <td class="info-value">{{ $patient->drug_start_date }}</td>
            </tr>
            <tr>
                <td class="info-label">Drug:</td>
                <td class="info-value">
                    {{ $patient->drug_name }}
                </td>
            </tr>
            <tr>
                <td class="info-label">No. of Tablets:</td>
                <td class="info-value">{{ $patient->drug_no_of_tablets }}</td>
            </tr>
            <tr>
                <td class="info-label">Strength:</td>
                <td class="info-value">{{ $patient->drug_strength }}</td>
            </tr>
            <tr>
                <td class="info-label">Unit:</td>
                <td class="info-value">{{ $patient->drug_unit }}</td>
            </tr>
            <tr>
                <td class="info-label">Continuation Start Date:</td>
                <td class="info-value">{{ $patient->drug_con_date }}</td>
            </tr>
            <tr>
                <td class="info-label">Drug:</td>
                <td class="info-value">
                    {{ $patient->drug_con_name }}
                </td>
            </tr>
            <tr>
                <td class="info-label">No. of Tablets:</td>
                <td class="info-value">{{ $patient->drug_con_no_of_tablets }}</td>
            </tr>
            <tr>
                <td class="info-label">Strength:</td>
                <td class="info-value">{{ $patient->drug_con_strength }}</td>
            </tr>
            <tr>
                <td class="info-label">Unit:</td>
                <td class="info-value">{{ $patient->drug_con_unit }}</td>
            </tr>
        </table>
    </div>

    <!-- SECTION: TREATMENT OUTCOME -->
    <div class="section">
        <div class="section-title">Treatment Outcome</div>
        <table>
            <tr>
                <td class="info-label">Outcome:</td>
                <td class="info-value">{{ $patient->out_outcome }}</td>
            </tr>
            <tr>
                <td class="info-label">Date:</td>
                <td class="info-value">
                    {{ $patient->out_date ? \Carbon\Carbon::parse($patient->out_date)->format('F j, Y') : 'N/A' }}
                </td>
            </tr>
            <tr>
                <td class="info-label">Reason:</td>
                <td class="info-value">{{ $patient->out_reason ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <!-- SECTION: SERIOUS ADVERSE EVENTS -->
    <div class="section">
        <div class="section-title">Serious Adverse Events</div>
        <table>
            <tr>
                <td class="info-label">Date of Adverse Event:</td>
                <td class="info-value">{{ $patient->adv_ae_date }}</td>
            </tr>
            <tr>
                <td class="info-label">Specific Adverse Event:</td>
                <td class="info-value">
                    {{ $patient->adv_specific_ae }}
                </td>
            </tr>
            <tr>
                <td class="info-label">Date Reported to FDA:</td>
                <td class="info-value">{{ $patient->adv_fda_reported_date }}</td>
            </tr>
        </table>
    </div>

    <!-- SECTION: PATIENT PROGRESS REPORT -->
    <div class="section">
        <div class="section-title">Patient Progress Report</div>
        <table>
            <tr>
                <td class="info-label">Date:</td>
                <td class="info-value">{{ $patient->prog_date }}</td>
            </tr>
            <tr>
                <td class="info-label">Problem:</td>
                <td class="info-value">{{ $patient->prog_problem }}</td>
            </tr>
            <tr>
                <td class="info-label">Action Taken:</td>
                <td class="info-value">{{ $patient->prog_action_taken }}</td>
            </tr>
            <tr>
                <td class="info-label">Plan:</td>
                <td class="info-value">{{ $patient->prog_plan }}</td>
            </tr>
        </table>
    </div>

    <!-- SECTION: CLOSE CONTACT -->
    <div class="section">
        <div class="section-title">Close Contact</div>
        <table>
            <tr>
                <td class="info-label">Name:</td>
                <td class="info-value">{{ $patient->con_name }}</td>
            </tr>
            <tr>
                <td class="info-label">Age:</td>
                <td class="info-value">{{ $patient->con_age }}</td>
            </tr>
            <tr>
                <td class="info-label">Sex:</td>
                <td class="info-value">{{ $patient->con_sex }}</td>
            </tr>
            <tr>
                <td class="info-label">Relationship:</td>
                <td class="info-value">{{ $patient->con_relationship }}</td>
            </tr>
            <tr>
                <td class="info-label">Iniital Screening:</td>
                <td class="info-value">{{ $patient->con_initial_screening }}</td>
            </tr>
            <tr>
                <td class="info-label">Follow Up:</td>
                <td class="info-value">{{ $patient->con_follow_up }}</td>
            </tr>
            <tr>
                <td class="info-label">Remarks:</td>
                <td class="info-value">{{ $patient->con_remarks }}</td>
            </tr>
        </table>
    </div>

    <!-- SECTION: SPUTUM MONITORING -->
    <div class="section">
        <div class="section-title">Sputum Monitoring</div>
        <table>
            <tr>
                <td class="info-label">Date Collected:</td>
                <td class="info-value">{{ $patient->sput_date_collected }}</td>
            </tr>
            <tr>
                <td class="info-label">Smear Microscopy / TB LAMP Result:</td>
                <td class="info-value">{{ $patient->sput_date_collected }}</td>
            </tr>
            <tr>
                <td class="info-label">Xpert MTB / RIF Result:</td>
                <td class="info-value">{{ $patient->sput_xpert_result }}</td>
            </tr>
        </table>
    </div>

    <!-- SECTION: CHEST X-RAY -->
    <div class="section">
        <div class="section-title">Chest X-ray</div>
        <table>
            <tr>
                <td class="info-label">Date Examined:</td>
                <td class="info-value">{{ $patient->xray_date_examined }}</td>
            </tr>
            <tr>
                <td class="info-label">Impression / Comparative Reading:</td>
                <td class="info-value">{{ $patient->xray_impression }}</td>
            </tr>
            <tr>
                <td class="info-label">Descriptive Comments:</td>
                <td class="info-value">{{ $patient->xray_descriptive_comment }}</td>
            </tr>
        </table>
    </div>

    <!-- SECTION: POST-TREATMENT FOLLOW-UP -->
    <div class="section">
        <div class="section-title">Post Treatment Follow-Up</div>
        <table>
            <tr>
                <td class="info-label">Months after Tx:</td>
                <td class="info-value">{{ $patient->fol_months_after_tx }}</td>
            </tr>
            <tr>
                <td class="info-label">Date:</td>
                <td class="info-value">{{ $patient->fol_date }}</td>
            </tr>
            <tr>
                <td class="info-label">CXR Findings:</td>
                <td class="info-value">{{ $patient->fol_cxr_findings }}</td>
            </tr>
            <tr>
                <td class="info-label">Smear / Xpert:</td>
                <td class="info-value">{{ $patient->fol_smear_xpert }}</td>
            </tr>
            <tr>
                <td class="info-label">TBC & DST:</td>
                <td class="info-value">{{ $patient->fol_tbc_dst }}</td>
            </tr>
        </table>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <em>
            Generated by the <strong>TB DOTS Patient Monitoring System</strong> &mdash;
            {{ \Carbon\Carbon::now()->format('F j, Y') }}
        </em>
    </div>

    <!-- SIGNATURE -->
    <div class="signature-section">
        <div class="signature">
            <div class="signature-title">Marife Labeste</div>
            <div class="signature-subtitle">TB DOTS Program Coordinator</div>
        </div>
    </div>

</body>

</html>