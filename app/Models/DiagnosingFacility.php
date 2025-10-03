<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiagnosingFacility extends Model
{
    protected $table = 'tbl_diagnosing_facilities';

    protected $fillable = [
        'fac_name',
        'fac_ntp_code',
        'fac_province',
        'fac_region',
    ];

    public function patients()
    {
        return $this->hasMany(Patient::class, 'diagfacility_id');
    }
}
