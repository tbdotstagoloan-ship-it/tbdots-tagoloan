<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outcome extends Model
{
    protected $table = 'tbl_treatment_outcomes';

    protected $fillable = [
            'treatment_id',
            'out_date_of_ae',
            'out_specific_ae',
            'out_fda_reported_date',
            'out_progress_date',
            'out_problem',
            'out_action_taken',
            'out_plan',
            'out_close_contact_name',
            'out_age',
            'out_sex',
            'out_relationship',
            'out_initial_screening',
            'out_follow_up',
            'out_remarks',
            'out_sputum_date_collected',
            'out_smear_microscopy',
            'out_xpert_mtb_rif',
            'out_chest_xray_date_examined',
            'out_chest_xray_impression',
            'out_chest_xray_comments',
            'out_chest_xray_date_examined2',
            'out_chest_xray_impression2',
            'out_chest_xray_comments2',
            'out_chest_xray_date_examined3',
            'out_chest_xray_impression3',
            'out_chest_xray_comments3',
            'out_mo_after_tx',
            'out_follow_up_date',
            'out_cxr_findings',
            'out_smear_xpert',
            'out_tbc_dst',
            'user_id',
    ];

    // public function treatment()
    // {
    //     return $this->belongsTo(Treatment::class, 'treatment_id');
    // }

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

}
