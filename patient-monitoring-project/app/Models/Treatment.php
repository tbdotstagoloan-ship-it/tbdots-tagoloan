<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $table = 'tbl_treatments';

    protected $fillable = [
        'diagnosis_id',
        'trt_treatment_facility',
        'trt_ntp_facility_code',
        'trt_province_huc',
        'trt_region',
        'trt_date_tx_started',
        'trt_treatment_unit',
        'trt_treatment_regimen',
        'trt_treatment_outcome',
        'trt_hiv_information',
        'trt_hiv_test_date',
        'trt_confirmatory_test_date',
        'trt_result',
        'trt_started_on_art',
        'trt_started_on_cpt',
        'trt_height',
        'trt_weight',
        'trt_other_vital_signs',
        'trt_emergency_contact',
        'trt_relationship',
        'trt_contact_information',
        'trt_diabetes_screening',
        'trt_4ps_beneficiary',
        'trt_fbs_screening',
        'trt_date_tested',
        'trt_occupation',
        'trt_comorbidity_date_diagnosed',
        'trt_comorbidity_type',
        'trt_comorbidity_other',
        'trt_comorbidity_treatment',
        'trt_regimen_type_start_treatment',
        'trt_treatment_start_date',
        'trt_regimen_type_end',
        'trt_outcome',
        'trt_outcome_date',
        'trt_reason',
        'trt_date_start',
        'trt_drug',
        'trt_strength',
        'trt_unit',
        'trt_continuation',
        'trt_continuation_drug',
        'trt_continuation_strength',
        'trt_continuation_unit',
        'trt_treatment_location',
        'trt_tx_supporter_name',
        'trt_tx_supporter_designation',
        'trt_tx_supporter_type',
        'trt_tx_supporter_contact',
        'trt_treatment_schedule',
        'trt_name_dats_used',
        'trt_intensive_phase_start',
        'trt_intensive_phase_end',
        'trt_continuation_phase_start',
        'trt_continuation_phase_end',
        'trt_weight_kg',
        'trt_children_height',
    ];

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class, 'diagnosis_id');
    }

    public function outcome()
    {
        return $this->hasOne(Outcome::class, 'treatment_id');
    }

}
