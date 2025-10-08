<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Patient Summary Report</title>
    <style>
        body { 
            font-family: "Times New Roman", serif; 
            font-size: 13px; 
            color: #222; 
            margin: 40px;
            line-height: 1.5;
        }

        /* HEADER */
        .header {
            text-align: center;
            border-bottom: 2px solid #28a745;
            padding-bottom: 10px;
            margin-bottom: 25px;
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

        @page {
            margin: 40px;
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <div class="header">
        <h4>Republic of the Philippines</h4>
        <h4>Municipality of Tagoloan</h4>
        <h3>TB DOTS Tagoloan</h3>
    </div>

    <!-- TITLE -->
    <div class="report-title">Patient Summary Report</div>

    <!-- SECTION: PATIENT INFORMATION -->
    <div class="section">
        <div class="section-title">Patient Information</div>
        <table>
            <tr>
                <td class="info-label">Full Name:</td>
                <td class="info-value">{{ $patient->name }}</td>
            </tr>
            <tr>
                <td class="info-label">Date of Birth / Age:</td>
                <td class="info-value">
                    {{ \Carbon\Carbon::parse($patient->birth_date)->format('F j, Y') }}, {{ $patient->age }}
                </td>
            </tr>
            <tr>
                <td class="info-label">Contact Number:</td>
                <td class="info-value">{{ $patient->contact }}</td>
            </tr>
            <tr>
                <td class="info-label">Address:</td>
                <td class="info-value">
                    {{ $patient->address }}, {{ $patient->city }}, {{ $patient->province }}, {{ $patient->region }}, {{ $patient->zip_code }}
                </td>
            </tr>
        </table>
    </div>

    <!-- SECTION: DIAGNOSIS -->
    <div class="section">
        <div class="section-title">Diagnosis</div>
        <table>
            <tr>
                <td class="info-label">TB Case Number:</td>
                <td class="info-value">{{ $patient->tb_case_no }}</td>
            </tr>
            <tr>
                <td class="info-label">Date of Diagnosis:</td>
                <td class="info-value">{{ \Carbon\Carbon::parse($patient->diagnosis_date)->format('F j, Y') }}</td>
            </tr>
            <tr>
                <td class="info-label">TB Classification:</td>
                <td class="info-value">{{ $patient->clas_bacteriological_status }}</td>
            </tr>
            <tr>
                <td class="info-label">Anatomical Site:</td>
                <td class="info-value">{{ $patient->clas_anatomical_site }}</td>
            </tr>
            <tr>
                <td class="info-label">Attending Physician:</td>
                <td class="info-value">{{ $patient->physician }}</td>
            </tr>
        </table>
    </div>

    <!-- SECTION: TREATMENT OUTCOME -->
    <div class="section">
        <div class="section-title">Treatment Outcome</div>
        <table>
            <tr>
                <td class="info-label">Outcome:</td>
                <td class="info-value">{{ $patient->outcome }}</td>
            </tr>
            <tr>
                <td class="info-label">Date:</td>
                <td class="info-value">
                    {{ $patient->date ? \Carbon\Carbon::parse($patient->date)->format('F j, Y') : 'N/A' }}
                </td>
            </tr>
            <tr>
                <td class="info-label">Reason:</td>
                <td class="info-value">{{ $patient->reason ?? 'N/A' }}</td>
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

</body>
</html>
