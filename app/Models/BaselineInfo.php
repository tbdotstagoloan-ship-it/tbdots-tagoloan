<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaselineInfo extends Model
{
    protected $table = 'tbl_baseline_infos';

    protected $fillable = [
        'base_weight',
        'base_height',
        'base_blood_pressure',
        'base_pulse_rate',
        'base_temperature',
        'base_emergency_contact_name',
        'base_relationship',
        'base_contact_info',
        'base_diabetes_screening',
        'base_four_ps_beneficiary',
        'base_fbs_screening',
        'base_date_tested',
        'base_occupation',
        'patient_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
