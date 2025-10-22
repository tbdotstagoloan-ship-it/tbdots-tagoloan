<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adherence extends Model
{
    protected $table = 'tbl_adherences';

    protected $fillable = [
        'pha_intensive_start',
        'pha_intensive_end',
        'pha_continuation_start',
        'pha_continuation_end',
        'pha_weight',
        'pha_child_height',
        'patient_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
