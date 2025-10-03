<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HIVInfo extends Model
{
    protected $table = 'tbl_hiv_infos';

    protected $fillable = [
        'hiv_information',
        'hiv_test_date',
        'hiv_confirmatory_test_date',
        'hiv_result',
        'hiv_art_started',
        'hiv_cpt_started',
        'patient_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
