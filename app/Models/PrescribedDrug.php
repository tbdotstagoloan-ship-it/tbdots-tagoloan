<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescribedDrug extends Model
{
    protected $table = 'tbl_prescribed_drugs';

    protected $fillable = [
        'drug_start_date',
        'drug_name',
        'drug_no_of_tablets',
        'drug_strength',
        'drug_unit',
        'drug_con_date',
        'drug_con_name',
        'drug_con_no_of_tablets',
        'drug_con_strength',
        'drug_con_unit',
        'patient_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
