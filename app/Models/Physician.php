<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Physician extends Model
{
    protected $table = 'tbl_physicians';
    protected $fillable = [
    'phy_first_name',
    'phy_last_name',
    'phy_sex',
    'phy_dob',
    'phy_designation',
    'phy_specialty',
    'phy_contact',
    'phy_address',
    'phy_email',
    ];
}
