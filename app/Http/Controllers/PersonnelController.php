<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PersonnelController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $personnels = User::paginate($perPage);

        return view('personnel.index', compact('personnels', 'perPage'));
    }

    public function store(Request $request)
    {

        //  ADMIN CHECK
        if (!$this->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|string|max:20',
            'address'  => 'required|string|max:255',
            'password' => 'nullable',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Personnel added successfully!');
    }

    public function update(Request $request, $id)
    {
        //  ADMIN CHECK
        if (!$this->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $personnel = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $personnel->id,
            'phone'    => 'required|string|max:20',
        ]);

        $personnel->name    = $request->name;
        $personnel->email   = $request->email;
        $personnel->phone   = $request->phone;

        $personnel->save();

        return redirect()->back()->with('success', 'Personnel updated successfully!');
    }

    public function destroy($id)
    {
         //  ADMIN CHECK
        if (!$this->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $personnel = User::findOrFail($id);
        $personnel->delete();

        return redirect()->back()->with('success', 'Personnel deleted successfully!');
    }

    /**
     * Check if logged-in user is the admin
     */
    private function isAdmin()
    {
        return auth()->check() &&
               auth()->user()->email === config('admin.email');
    }

}
