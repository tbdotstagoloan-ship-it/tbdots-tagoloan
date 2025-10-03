<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTreatmentFollowUp extends Model
{
    protected $table = 'tbl_post_treatment_follow_ups';

    protected $fillable = [
        'fol_months_after_tx',
        'fol_date',
        'fol_cxr_findings',
        'fol_smear_xpert',
        'fol_tbc_dst',
        'patient_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
