<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class PatientAccount extends Model
{

    use HasApiTokens;
    protected $table = 'tbl_patient_accounts';

    protected $fillable = [
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

}
