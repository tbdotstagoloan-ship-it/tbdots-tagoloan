<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TBClassification extends Model
{
    protected $table = 'tbl_tb_classifications';

    protected $fillable = [
        'patient_id',
        'clas_bacteriological_status',
        'clas_drug_resistance_status',
        'clas_other_drug_resistant',
        'clas_anatomical_site',
        'clas_site_other',
        'clas_registration_group',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

}
