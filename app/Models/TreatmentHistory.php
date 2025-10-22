<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentHistory extends Model
{
    protected $table = 'tbl_treatment_histories';

    protected $fillable = [
        'hist_date_tx_started',
        'hist_treatment_unit',
        'hist_drug',
        'hist_treatment_duration',
        'hist_outcome',
        'patient_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

}
