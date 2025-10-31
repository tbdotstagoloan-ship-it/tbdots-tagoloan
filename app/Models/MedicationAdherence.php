<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicationAdherence extends Model
{
    use HasFactory;

    protected $table = 'tbl_medication_adherences';

    protected $fillable = [
        'patient_id',
        'username',
        'date',
        'status',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

}
