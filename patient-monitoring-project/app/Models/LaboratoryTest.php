<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaboratoryTest extends Model
{
    protected $table = 'tbl_laboratory_tests';

    protected $fillable = [
        'patient_id',
        'lab_xpert_test_date',
        'lab_xpert_result',
        'lab_smear_test_date',
        'lab_smear_result',
        'lab_cxray_test_date',
        'lab_cxray_result',
        'lab_tst_test_date',
        'lab_tst_result',
        'lab_other_test_date',
        'lab_other_result',
        'diagfacility_id',
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
