<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Screening extends Model
{
    protected $table = 'tbl_screenings';

    protected $fillable = [
        'patient_id',
        'scr_referred_by',
        'scr_location',
        'scr_referrer_type',
        'scr_screening_mode',
        'scr_screening_date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function labTests()
    {
        return $this->hasMany(LaboratoryTest::class, 'patient_id', 'patient_id');
    }

}
