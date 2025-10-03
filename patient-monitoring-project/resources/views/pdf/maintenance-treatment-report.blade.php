<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Maintenance Phase</title>
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
    <div class="report-title">Continuation Phase Tuberculosis Patients Report</div>

    <!-- META -->
    <div class="meta">
        Report Date: {{ \Carbon\Carbon::now()->format('F j, Y') }}
    </div>

    <!-- TABLE -->
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Sex</th>
                <th>Drug</th>
                <th>Strength</th>
                <th>Unit</th>
                <th>Intensive Start</th>
                <th>Day</th>
                <th>Intensive End</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($maintenanceTreatment as $patient)
            <tr>
                <td>{{ $patient->pat_full_name }}</td>
                <td>{{ $patient->pat_sex }}</td>
                <td>{{ $patient->drug_name }}</td>
                <td>{{ $patient->drug_strength }}</td>
                <td>{{ $patient->drug_unit }}</td>
                <td>{{ \Carbon\Carbon::parse($patient->pha_continuation_start)->format('F j, Y') }}</td>
                <td>{{ $patient->treatment_day }}</td>
                <td>{{ \Carbon\Carbon::parse($patient->pha_continuation_end)->format('F j, Y') }}</td>
                <td>{{ $patient->outcome }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align:center;">No data found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
