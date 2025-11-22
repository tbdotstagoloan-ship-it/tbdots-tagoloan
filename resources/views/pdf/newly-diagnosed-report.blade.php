<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Newly Diagnosed Report</title>
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

        /* META INFO */
        .meta { 
            text-align: right;
            font-size: 12px;
            font-style: italic;
            color: #555;
            margin-bottom: 15px;
        }

        /* TABLE */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            font-size: 13px;
            text-align: center;
        }
        th, td { 
            border: 1px solid #ccc; 
            padding: 8px 10px;
            text-align: center; 
        }
        th { 
            background: #28a745;
            color: #fff; 
            text-align: center;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        td { 
            text-align: center;
        }
        tr:nth-child(even) td {
            background: #f8fdf8;
        }
        tr:hover td {
            background: #e9f7ec;
        }

        /* FOOTER */
        .footer {
            text-align: center;
            font-size: 11px;
            color: #777;
            margin-top: 25px;
            border-top: 1px solid #ccc;
            padding-top: 8px;
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

        /* PRINT-FRIENDLY */
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

    <!-- REPORT TITLE -->
    <div class="report-title">Newly Diagnosed Tuberculosis Patients Report</div>

    <!-- TABLE -->
    <table>
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>Age</th>
                <th>Sex</th>
                <th>Barangay</th>
                <th>TB Case No</th>
                <th>Diagnosis Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($new as $patient)
            <tr>
                <td>{{ $patient->pat_full_name }}</td>
                <td>{{ $patient->pat_age }}</td>
                <td>{{ $patient->pat_sex }}</td>
                <td>{{ $patient->barangay }}</td>
                <td>{{ $patient->diag_tb_case_no }}</td>
                <td>{{ \Carbon\Carbon::parse($patient->diag_diagnosis_date)->format('F j, Y') }}</td>
                <td>{{ $patient->clas_registration_group }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; color:#666;">No data found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

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