<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdverseEvent extends Model
{
    protected $table = 'tbl_adverse_events';

    protected $fillable = [
        'adv_ae_date',
        'adv_specific_ae',
        'adv_fda_reported_date',
        'patient_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
