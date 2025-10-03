<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TxSupporter extends Model
{
    protected $table = 'tbl_tx_supporters';

    protected $fillable = [
        'sup_location',
        'sup_name',
        'sup_designation',
        'sup_type',
        'sup_contact_info',
        'sup_treatment_schedule',
        'sup_dat_used',
        'patient_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
