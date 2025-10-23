<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\MedicationAdherence;

class MedicationAdherenceController extends Controller
{
    public function index()
    {
        return view('medication.index');
    }

    // GET /api/auth/current-user
    public function getCurrentUser(Request $request)
    {
        // Check if user is authenticated
        if (Auth::check()) {
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'username' => $user->username, // or $user->name, depending on your User model
                'user_id' => $user->id,
                'email' => $user->email
            ]);
        }

        // If using session-based auth without Auth facade
        if ($request->session()->has('username')) {
            return response()->json([
                'success' => true,
                'username' => $request->session()->get('username')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No user logged in'
        ], 401);
    }

    // POST /api/adherence/log
    public function logAdherence(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'date' => 'required|date',
            'status' => 'required|in:taken,missed',
        ]);

        MedicationAdherence::updateOrCreate(
            ['username' => $validated['username'], 'date' => $validated['date']],
            ['status' => $validated['status']]
        );

        return response()->json([
            'message' => 'Adherence logged successfully',
            'data' => $validated
        ]);
    }

    // GET /api/adherence/{username}
    public function getAdherence($username)
    {
        $logs = MedicationAdherence::where('username', $username)
            ->orderBy('date', 'asc')
            ->get();

        return response()->json($logs);
    }
}