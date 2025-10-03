<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Barangay Cases</title>
    <style>
        body { 
            font-family: "Times New Roman", serif; 
            font-size: 13px; 
            color: #000; 
            line-height: 1.6;
            margin: 40px;
        }
        /* HEADER */
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        .header h4 {
            margin: 2px 0;
            font-size: 14px;
            font-weight: normal;
        }
        .header h3 {
            margin: 6px 0;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }
        /* TITLE */
        .report-title {
            text-align: center;
            margin: 20px 0 15px 0;
            font-size: 17px;
            font-weight: bold;
            text-transform: uppercase;
        }
        /* META */
        .meta { 
            margin-bottom: 20px; 
            text-align: right; 
            font-size: 12px;
            font-style: italic;
        }
        /* TABLE */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
            font-size: 13px;
        }
        th, td { 
            border: 1px solid #444; 
            padding: 8px; 
        }
        th { 
            background: #28a745;
            color: #fff; 
            text-align: center;
            font-weight: bold;
            font-size: 13px;
        }
        td {
            text-align: center;
        }
        td:first-child {
            text-align: left; /* Name aligned left for readability */
        }
        tr:nth-child(even) td {
            background: #f9f9f9;
        }
        /* SIGNATURES */
        .signature-block {
            display: flex;
            justify-content: space-between;
            margin-top: 60px;
        }
        .signature {
            width: 45%;
            text-align: center;
        }
        .signature p {
            margin: 2px 0;
            font-size: 13px;
        }
        .signature-line {
            margin-top: 50px;
            border-top: 1px solid #333;
            display: inline-block;
            width: 80%;
        }
        /* FOOTER */
        .page-footer {
            margin-top: 50px;
            text-align: center;
            font-size: 11px;
            color: #444;
            font-style: italic;
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
    <div class="report-title">Barangay Cases Tuberculosis Patients Report</div>

    <!-- META -->
    <div class="meta">
        Report Date: {{ \Carbon\Carbon::now()->format('F j, Y') }}
    </div>

    <!-- TABLE -->
    <table>
        <thead>
            <tr>
                <th>Barangay</th>
                <th>Name</th>
                <th>Age</th>
                <th>Sex</th>
                <th>TB Case #</th>
                <th>Diagnosis Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($brgyCases as $patient)
            <tr>
                <td>{{ $patient->barangay }}</td>
                <td>{{ $patient->patient_name }}</td>
                <td>{{ $patient->pat_age }}</td>
                <td>{{ $patient->pat_sex }}</td>
                <td>{{ $patient->diag_tb_case_no }}</td>
                <td>{{ \Carbon\Carbon::parse($patient->diag_diagnosis_date)->format('F j, Y') }}</td>
                <td>{{ $patient->out_outcome }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;">No data found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
