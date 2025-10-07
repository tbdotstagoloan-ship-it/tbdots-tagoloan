<?php

namespace App\Http\Controllers;

use App\Models\Adherence;
use Illuminate\Http\Request;

class AdherenceController extends Controller
{
    public function update(Request $request, $id)
{
    $adherence = Adherence::findOrFail($id);

    $adherence->update([
        'pha_weight' => $request->pha_weight,
        'pha_child_height' => $request->pha_child_height,
    ]);

    return back()->with('success', 'Administration of drugs record updated successfully.');
}

}
