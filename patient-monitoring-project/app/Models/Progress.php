<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $table = 'tbl_progress';

    protected $fillable = [
        'prog_date',
        'prog_problem',
        'prog_action_taken',
        'prog_plan',
        'patient_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
