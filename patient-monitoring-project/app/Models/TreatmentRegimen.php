<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentRegimen extends Model
{
    protected $table = 'tbl_treatment_regimens';

    protected $fillable = [
        'reg_start_type',
        'reg_start_date',
        'reg_end_type',
        'patient_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
