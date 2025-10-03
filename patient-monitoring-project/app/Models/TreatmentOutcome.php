<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentOutcome extends Model
{
    protected $table = 'tbl_treatment_outcomes';

    protected $fillable = [
        'out_outcome',
        'out_date',
        'out_reason',
        'patient_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
