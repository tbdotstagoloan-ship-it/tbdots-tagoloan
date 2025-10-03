<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $table = 'tbl_diagnosis';

    protected $fillable = [
        'patient_id',
        'diag_diagnosis_date',
        'diag_notification_date',
        'diag_tb_case_no',
        'diag_attending_physician',
        'diag_referred_to',
        'diag_address',
        'diag_facility_code',
        'diag_province',
        'diag_region',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function tbClassification()
    {
        return $this->hasOne(TBClassification::class, 'patient_id', 'patient_id');
    }


    // public function patient()
    // {
    //     return $this->belongsTo(Patient::class, 'patient_id');
    // }

    // public function treatment()
    // {
    //     return $this->hasOne(Treatment::class, 'diagnosis_id');
    // }

}
