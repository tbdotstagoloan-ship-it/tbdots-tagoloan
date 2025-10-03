<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentFacility extends Model
{
    protected $table = 'tbl_treatment_facilities';

    protected $fillable = [
        'trea_name',
        'trea_ntp_code',
        'trea_province',
        'trea_region',
        'patient_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
    

    public function treatmentHistories()
    {
        return $this->hasMany(TreatmentHistory::class, 'treatfacility_id');
    }

}
