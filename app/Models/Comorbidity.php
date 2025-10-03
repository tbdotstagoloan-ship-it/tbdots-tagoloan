<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comorbidity extends Model
{
    protected $table = 'tbl_comorbidities';

    protected $fillable = [
        'com_date_diagnosed',
        'com_type',
        'com_other',
        'com_treatment',
        'patient_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
