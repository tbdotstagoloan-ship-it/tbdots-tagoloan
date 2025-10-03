<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'tbl_admins';

    protected $fillable = [
        'diagfacility_id',
        'patient_id',
        'adm_username',
        'adm_password',
    ];

    protected $hidden = [
        'adm_password',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function diagnosingFacility()
    {
        return $this->belongsTo(DiagnosingFacility::class, 'diagfacility_id');
    }

}
