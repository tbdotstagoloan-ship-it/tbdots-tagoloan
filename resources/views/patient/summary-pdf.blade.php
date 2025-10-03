<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Patient Summary Report</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; }
    h2 { text-align: center; margin-bottom: 20px; }
    .info { margin: 10px 0; }
    .label { font-weight: bold; }
  </style>
</head>
<body>
  <h2>TB DOTS Patient Summary Report</h2>

  <h4>I. Patient Demographic</h4>
  <div class="info"><span class="label">Patient ID:</span> {{ $patient->id }} </div>
  <div class="info"><span class="label">Full Name:</span> {{ $patient->pat_full_name }}</div>
  <div class="info"><span class="label">Sex:</span> {{ $patient->pat_sex }}</div>
  <div class="info"><span class="label">Age:</span> {{ $patient->pat_age }}</div>
  <div class="inof"><span class="label">Date of Birth:</span> {{ $patient->pat_date_of_birth }} </div>
  <div class="info"><span class="label">Civil status:</span> {{ $patient->pat_civil_status }} </div>
  <div class="info"><span class="label">Address:</span> 
  {{ $patient->pat_permanent_address }},
  {{ $patient->pat_permanent_city_mun }},
  {{ $patient->pat_permanent_region }},
  {{ $patient->pat_permanent_zip_code }}
  </div>
  <div class="info"><span class="label">Contact:</span> {{ $patient->pat_contact_number ?? 'N/A' }}</div>
  <div class="info"><span class="label">Natiolaity:</span> {{ $patient->pat_nationality }} </div>
  <!-- <div class="info"><span class="label">Medical Notes:</span> {{ $patient->medical_notes ?? 'No notes available' }}</div> -->
   <hr>
   <h4>II. Facility & Case Information</h4>
   <div class="info"><span class="label">Diagnosing Facility:</span> {{ $patient->pat_diagnosing_facility }} </div>
   <div class="info"><span class="label">NTP Facility Code:</span> {{ $patient->pat_ntp_facility_code }} </div>
   <div class="info"><span class="label">Province:</span> {{ $patient->pat_province }} </div>
   <div class="info"><span class="label">Region:</span> {{ $patient->pat_region }} </div>
   <div class="info"><span class="label">Date Registered:</span> {{ $diagnosis->diag_diagnosis_date }} </div>
   <div class="info"><span class="label">TB Case Number:</span> {{ $diagnosis->diag_tb_case_number }} </div>
   <hr>
   <h4>III. Diagnostic Information</h4>
   <div class="info"><span class="label">Type of TB:</span> {{ $diagnosis->diag_bacteriological_status }} </div>
   <div class="info"><span class="label">Xpert MTB/RIF:</span> {{ $diagnosis->diag_xpert_result }} </div>
   <div class="info"><span class="label">Date:</span> {{ $diagnosis->diag_xpert_test_date }} </div>
   <div class="info"><span class="label">Smear Microscopy/TB LAMP:</span> {{ $diagnosis->diag_smear_result }} </div>
   <div class="info"><span class="label">Date:</span> {{ $diagnosis->diag_smear_test_date }} </div>
   <div class="info"><span class="label">Chest X-ray:</span> {{ $diagnosis->diag_chest_xray_result }} </div>
   <div class="info"><span class="label">Date:</span> {{ $diagnosis->diag_chest_xray_result }} </div>
    <hr>
    <h4>IV. Treatment Information</h4>
    <div class="info"><span class="label">Treatment Category:</span> {{ $diagnosis->diag_registration_group }} </div>
    <div class="info"><span class="label">Treatment Start Date:</span> {{ $treatment->trt_treatment_start_date }} </div>
    <div class="info"><span class="label">Treatment Regimen:</span> {{ $treatment->trt_regimen_type_start_treatment }} </div>
    <div class="info"><span class="label">Attending Physician:</span> {{ $diagnosis->diag_attending_physician }} </div>
    <hr>
    <h4>V. Follow up & Monitoring</h4>
    <div class="info"><span class="label">Intensive Phase:</span> {{ $treatment->trt_intensive_phase_start }} </div>
    <div class="info"><span class="label">Continuation Phase:</span> {{ $treatment->trt_continuation_phase_start }} </div>
    <hr>
    <h4>VI. Treatment Outcome</h4>
    <div class="info"><span class="label">Outcome:</span> {{ $treatment->trt_outcome }} </div>
    <div class="info"><span class="label">Date:</span> {{ $treatment->trt_outcome_date }} </div>
    <div class="info"><span class="label">Reason:</span> {{ $treatment->trt_reason }} </div>

  <br><br>
  <small>Generated on {{ now()->format('F j, Y, g:i a') }}</small>
</body>
</html>
