<?php

namespace App\Http\Controllers;

use App\Models\Physician;
use Illuminate\Http\Request;

class PhysicianController extends Controller
{
    public function index() {

        $physicians = Physician::paginate(10);

        return view('admin.physician', compact('physicians'));
    }

    public function show()
    {
        return Physician::select('id', 'phy_first_name', 'phy_last_name', 'phy_designation')->get();
    }

    public function store(Request $request)
    {
        $physician_validate = $request->validate([
            'phy_first_name' => 'required',
            'phy_last_name' => 'required',
            'phy_sex' => 'required',
            'phy_dob' => 'required',
            'phy_designation' => 'required',
            'phy_specialty' => 'nullable',
            'phy_contact' => 'required',
            'phy_address' => 'required',
            'phy_email' => 'required|email|unique:tbl_physicians,phy_email',
        ]);

        Physician::create($physician_validate);

        return redirect()->back()->with('success', 'Physician added successfully.');
    }

    public function update(Request $request, $id)
    {
        $physician = Physician::findOrFail($id);
        $physician->update($request->all());
        return redirect()->back()->with('success', 'Information updated successfully!');
    }


    public function destroy($id)
    {
        $physician = Physician::findOrFail($id);
        $physician->delete();

        return redirect()->back()->with('success', 'Physician deleted successfully!');
    }
}
