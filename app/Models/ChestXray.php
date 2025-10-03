<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChestXray extends Model
{
    protected $table = 'tbl_chest_xrays';

    protected $fillable = [
        'xray_date_examined',
        'xray_impression',
        'xray_descriptive_comment',
        'patient_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
