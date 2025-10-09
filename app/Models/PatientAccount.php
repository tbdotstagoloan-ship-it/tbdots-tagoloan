<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class patientAccount extends Model
{
    protected $table = 'tbl_patient_accounts';

    protected $fillable = [
        // 'diagfacility_id',
        'patient_id',
        'acc_username',
        'acc_password',
    ];

    protected $hidden = [
        'acc_password',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    // public function diagnosingFacility()
    // {
    //     return $this->belongsTo(DiagnosingFacility::class, 'diagfacility_id');
    // }

}
