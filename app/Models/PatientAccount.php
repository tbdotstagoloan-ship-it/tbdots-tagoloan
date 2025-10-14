<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class PatientAccount extends Authenticatable
{

    use HasFactory, HasApiTokens;
    protected $table = 'tbl_patient_accounts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'acc_username',
        'acc_password',
        'patient_id',
    ];

    protected $hidden = [
        'acc_password',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

}
