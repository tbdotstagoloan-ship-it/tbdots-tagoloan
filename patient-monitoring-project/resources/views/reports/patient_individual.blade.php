<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Patient Summary Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        h2, h4 { text-align: center; margin: 0; }
        .meta { margin-bottom: 20px; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    
    <h2>Patient Summary Report</h2>
    <div class="meta">
        <h4>{{ $clinic }}</h4>
        <p>Generated: {{ $generated }}</p>
    </div>

    <table>
        <tr><th>Patient Name</th><td>{{ $patient->name }}</td></tr>
        <tr><th>Birth Date</th><td>{{ \Carbon\Carbon::parse($patient->birth_date)->format('F j, Y') }}</td></tr>
        <tr><th>Age</th><td>{{ $patient->age }}</td></tr>
        <tr><th>Sex</th><td>{{ $patient->sex }}</td></tr>
        <tr><th>Address</th><td>{{ $patient->address }}, {{ $patient->city }}, {{ $patient->province }}, {{ $patient->region }}, {{ $patient->zip_code }}</td></tr>
        <tr><th>Contact</th><td>{{ $patient->contact }}</td></tr>
        
        <tr><th>TB Case #</th><td>{{ $patient->tb_case_no }}</td></tr>
        <tr><th>Diagnosis Date</th><td>{{ \Carbon\Carbon::parse($patient->diagnosis_date)->format('F j, Y') }}</td></tr>

        <tr><th>TB Classification</th><td>{{ $patient->clas_bacteriological_status }}</td></tr>
        <tr><th>Anatomical Site</th><td>{{ $patient->clas_anatomical_site }}</td></tr>

        <tr><th>Physician</th><td>{{ $patient->physician }}</td></tr>

        <tr><th>Outcome</th><td>{{ $patient->outcome }}</td></tr>
        <tr><th>Date</th><td>{{ \Carbon\Carbon::parse($patient->date)->format('F j, Y') ?? 'N/A'}}</td></tr>
        <tr><th>Reason</th><td>{{ $patient->reason ?? 'N/A'}}</td></tr>
    </table>
</body>
</html>
