<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Patient Summary Report</title>
  <style>
    body {
      font-family: "Times New Roman", Times, serif;
      font-size: 11px;
      line-height: 1.5;
      color: #000;
      margin: 0;
      padding: 30px 40px;
      background: #fff;
    }
    
    .header {
      text-align: center;
      border-bottom: 2px solid #2ecc71;
      padding-bottom: 15px;
      margin-bottom: 25px;
    }
    
    .header h1 {
      margin: 0 0 5px 0;
      font-size: 18px;
      font-weight: bold;
      text-transform: uppercase;
      color: #27ae60;
      letter-spacing: 1px;
    }
    
    .header .date {
      font-size: 11px;
      color: #555;
    }
    
    .section {
      margin-bottom: 20px;
    }
    
    .section-title {
      font-size: 13px;
      font-weight: bold;
      color: #27ae60;
      margin: 0 0 10px 0;
      text-transform: uppercase;
      border-bottom: 1px solid #27ae60;
      padding-bottom: 3px;
    }
    
    .info-table {
      width: 100%;
      border-collapse: collapse;
    }
    
    .info-table tr {
      border-bottom: 1px solid #e0e0e0;
    }
    
    .info-table tr:last-child {
      border-bottom: none;
    }
    
    .info-table td {
      padding: 8px 0;
      vertical-align: top;
    }
    
    .info-label {
      font-weight: bold;
      width: 180px;
      color: #333;
    }
    
    .info-value {
      color: #000;
    }
    
    .no-record {
      font-style: italic;
      color: #666;
      padding: 8px 0;
    }
    
    .footer {
      margin-top: 30px;
      padding-top: 15px;
      border-top: 1px solid #e0e0e0;
      text-align: center;
      font-size: 9px;
      color: #777;
    }
    
    @media print {
      body {
        padding: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="header">
    <h1>Patient Summary Report</h1>
    <div class="date">Generated on October 01, 2025</div>
  </div>
  
  <!-- Patient Information -->
  <div class="section">
    <div class="section-title">Patient Information</div>
    <table class="info-table">
      <tr>
        <td class="info-label">Full Name:</td>
        <td class="info-value">{{ $patient->name }}</td>
      </tr>
      <tr>
        <td class="info-label">Date of Birth / Age:</td>
        <td class="info-value">{{ \Carbon\Carbon::parse($patient->birth_date)->format('F j, Y') }}, {{ $patient->age }}</td>
      </tr>
      <tr>
        <td class="info-label">Contact Number:</td>
        <td class="info-value">{{ $patient->contact }}</td>
      </tr>
      <tr>
        <td class="info-label">Address:</td>
        <td class="info-value">{{ $patient->address }}, {{ $patient->city }}, {{ $patient->province }}, {{ $patient->region }}, {{ $patient->zip_code }}</td>
      </tr>
    </table>
  </div>
  
  <!-- Diagnosis -->
  <div class="section">
    <div class="section-title">Diagnosis</div>
    <table class="info-table">
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
    
    <!-- Example of no record state -->
    <!-- <div class="no-record">No diagnosis has been recorded for this patient.</div> -->
  </div>
  
  <!-- Treatment -->
  <div class="section">
    <div class="section-title">Treatment Outcome</div>
    <table class="info-table">
        <tr>
            <td class="info-label">Outcome:</td>
            <td class="info-value">{{ $patient->outcome }}</td>
        </tr>
      <tr>
        <td class="info-label">Date:</td>
        <td class="info-value">{{ \Carbon\Carbon::parse($patient->date)->format('F j, Y') ?? 'N/A'}}</td>
      </tr>
      <tr>
        <td class="info-label">Reason:</td>
        <td class="info-value">{{ $patient->reason ?? 'N/A'}}</td>
      </tr>
    </table>
    
    <!-- Example of no record state -->
    <!-- <div class="no-record">No treatment has been recorded for this patient.</div> -->
  </div>
  
  <div class="footer">
    This is a confidential medical document. Handle in accordance with patient privacy regulations.
  </div>
</body>
</html>