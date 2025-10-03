<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CloseContact extends Model
{
    protected $table = 'tbl_close_contacts';

    protected $fillable = [
        'con_name',
        'con_age',
        'con_sex',
        'con_relationship',
        'con_initial_screening',
        'con_follow_up',
        'con_remarks',
        'patient_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
