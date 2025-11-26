<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SputumMonitoring extends Model
{
    protected $table = 'tbl_sputum_monitorings';

    protected $fillable = [
        'sput_date_collected',
        'sput_smear_result',
        'sput_xpert_result',
        'lab_test_photo',
        'patient_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
