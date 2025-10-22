<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiagnosingFacility;


class DiagnosingFacilityController extends Controller
{

    public function index(Request $request){

        $facilities = DiagnosingFacility::paginate(10);

        return view('facility.facilities', compact('facilities'));
    }


    public function store(Request $request)
    {
        $facility_validate = $request->validate([
            'fac_name' => 'required',
            'fac_ntp_code' => 'required',
            'fac_province' => 'required',
            'fac_region' => 'required'
        ]);

        DiagnosingFacility::create($facility_validate);

        return redirect()->back()->with('success', 'Facility added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fac_name' => 'required|string|max:255',
            'fac_ntp_code' => 'required|string|max:255',
            'fac_province' => 'required|string|max:255',
            'fac_region' => 'required|string|max:255',
        ]);

        $facility = DiagnosingFacility::findOrFail($id);
        $facility->update($request->only(['fac_name', 'fac_ntp_code', 'fac_province', 'fac_region']));

        return redirect()->back()->with('success', 'Facility updated successfully!');
    }

    public function destroy($id)
    {
        $facility = DiagnosingFacility::findOrFail($id);
        $facility->delete();

        return redirect()->back()->with('success', 'Facility deleted successfully!');
    }

    public function show()
    {
        return DiagnosingFacility::select('id', 'fac_name', 'fac_ntp_code', 'fac_province', 'fac_region')->get();
    }
}
