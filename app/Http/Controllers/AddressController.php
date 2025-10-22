<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function regions() {
        return DB::table('ph_region')
        ->orderBy('id')
        ->get();
    }

    public function provinces($regCode) {
        return DB::table('ph_province')->where('regCode', $regCode)->orderBy('provDesc')->get();
    }

    public function cities($provCode) {
        return DB::table('ph_citymun')->where('provCode', $provCode)->orderBy('citymunDesc')->get();
    }

    public function barangays($citymunCode) {
        return DB::table('ph_brgy')->where('citymunCode', $citymunCode)->orderBy('brgyDesc')->get();
    }

    public function zipcode($citymunCode) {
        return DB::table('ph_postalcode')->where('postal_citymunCode', $citymunCode)->first();
    }
}
