<?php

namespace App\Http\Controllers;
use App\Models\DiagnosingFacility;
use App\Models\Physician;
use App\Models\TBClassification;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\returnArgument;
use App\Models\Patient;
use App\Models\Diagnosis;
use App\Models\Treatment;
use App\Models\Outcome;
use App\Models\PatientAccount;
use App\Models\User;
use App\Models\MedicationAdherence;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    
    public function index()
    {
        // ✅ Cache static counts (for 60 minutes)
        $totalPatients   = Cache::remember('dashboard_total_patients', 3600, fn() => Patient::count());
        $totalPhysician  = Cache::remember('dashboard_total_physician', 3600, fn() => Physician::count());
        $totalPersonnel  = Cache::remember('dashboard_total_personnel', 3600, fn() => User::count());
        $totalFacility   = Cache::remember('dashboard_total_facility', 3600, fn() => DiagnosingFacility::count());
        $pulmonary       = Cache::remember('dashboard_pulmonary', 3600, fn() => TBClassification::where('clas_anatomical_site', 'Pulmonary')->count());
        $extra           = Cache::remember('dashboard_extra', 3600, fn() => TBClassification::where('clas_anatomical_site', 'Extra-pulmonary')->count());

        // Eager load patients (1 query)
        $accounts = PatientAccount::with('patient')->get();

        // Fetch all adherence logs in one query
        $usernames = $accounts->pluck('acc_username')->toArray();
        $adherenceLogs = MedicationAdherence::whereIn('username', $usernames)
            ->orderByDesc('date')
            ->get(['username', 'date', 'status'])
            ->groupBy('username');

        // Compute consecutive missed doses efficiently
        $patientsWithConsecutiveMissed = $accounts->map(function ($acc) use ($adherenceLogs) {
            $patient = $acc->patient;
            if (!$patient || !isset($adherenceLogs[$acc->acc_username])) return null;

            $logs = $adherenceLogs[$acc->acc_username]->sortByDesc('date')->values();

            if ($logs->first()->status !== 'missed') return null;

            $consecutiveMissed = 0;
            foreach ($logs as $log) {
                if ($log->status === 'missed') $consecutiveMissed++;
                else break;
            }

            return $consecutiveMissed >= 2 ? [
                'patient_id' => $patient->id,
                'full_name' => $patient->pat_full_name,
                'contact' => $patient->pat_contact_number,
                'barangay' => $patient->pat_permanent_address,
                'consecutive_missed' => $consecutiveMissed,
                'last_missed' => $logs->where('status', 'missed')->max('date'),
            ] : null;
        })->filter()
        ->sortByDesc('last_missed')
        ->values();

        return view('dashboard', compact(
            'totalPatients',
            'totalPhysician',
            'pulmonary',
            'extra',
            'totalFacility',
            'totalPersonnel',
            'patientsWithConsecutiveMissed'
        ));
    }
    
    public function patient(Request $request)
    {
        $totalPatients = Cache::remember('total_patients_count', 60, fn() => Patient::count());
        
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);
        $lastId = $request->input('last_id');
        $direction = $request->input('direction');

        $query = DB::table('tbl_patients as p')
        ->join(DB::raw('(SELECT MAX(id) AS latest_diag_id, patient_id FROM tbl_diagnosis GROUP BY patient_id) AS ld'), 'p.id', '=', 'ld.patient_id')
        ->join('tbl_diagnosis as d', 'd.id', '=', 'ld.latest_diag_id')
        ->leftJoin(DB::raw('(SELECT MAX(id) AS latest_out_id, patient_id FROM tbl_treatment_outcomes GROUP BY patient_id) AS lo'), 'p.id', '=', 'lo.patient_id')
        ->leftJoin('tbl_treatment_outcomes as to', 'to.id', '=', 'lo.latest_out_id')
        ->leftJoin(DB::raw('(SELECT MAX(id) AS latest_phase_id, patient_id FROM tbl_adherences GROUP BY patient_id) AS lp'), 'p.id', '=', 'lp.patient_id')
        ->leftJoin('tbl_adherences as tp', 'tp.id', '=', 'lp.latest_phase_id')
        ->leftJoin('tbl_patient_accounts as pa', 'pa.patient_id', '=', 'p.id')

        ->select(
            'p.id',
            'p.pat_full_name',
            'p.pat_sex',
            'p.pat_date_of_birth',
            'p.pat_age',
            'p.pat_civil_status',
            'p.pat_contact_number',
            'p.pat_other_contact',
            'p.pat_philhealth_no',
            'p.pat_nationality',
            'p.pat_current_region',
            'p.pat_current_province',
            'p.pat_current_city_mun',
            'p.pat_current_address',
            'p.pat_current_zip_code',
            'd.diag_tb_case_no',
            'd.diag_diagnosis_date',
            'to.out_outcome as status',
            'tp.pha_intensive_start',
            'tp.pha_intensive_end',
            'tp.pha_continuation_start',
            'tp.pha_continuation_end',
            'pa.id as account_id'

        )
        ->when($search, function ($query, $search) {
            $query->where('p.pat_full_name', 'LIKE', "%{$search}%")
                ->orWhere('d.diag_tb_case_no', 'LIKE', "{$search}%");
        });


        // ✅ Keyset pagination (unchanged)
        if ($lastId) {
            if ($direction === 'next') {
                $query->where('p.id', '<', $lastId)->orderByDesc('p.id');
            } elseif ($direction === 'prev') {
                $query->where('p.id', '>', $lastId)->orderBy('p.id');
            }
        } else {
            $query->orderByDesc('p.id');
        }

        // ✅ Fetch + check next/prev
        $patients = $query->limit($perPage + 1)->get();
        $hasMore = $patients->count() > $perPage;
        $patients = $patients->take($perPage);

        if ($direction === 'prev') {
            $patients = $patients->sortByDesc('id')->values();
        }

        if ($direction === 'next') {
            $nextId = $hasMore ? $patients->last()->id : null;
            $prevId = $patients->first()->id;
        } elseif ($direction === 'prev') {
            $nextId = $patients->last()->id;
            $prevId = $hasMore ? $patients->first()->id : null;
        } else {
            $nextId = $hasMore ? $patients->last()->id : null;
            $prevId = null;
        }

        return view('admin.patient', compact('patients', 'totalPatients', 'perPage', 'nextId', 'prevId'));
    }

    public function patientProfile($id)
    {
        $patient = Patient::with([
            'diagnosingFacility',
            'screenings.labTests',  
            'diagnoses',
            'tbClassification',  
            'treatmentFacilities',
            'treatmentHistories',
            'comorbidities',
            'baselineInfos',
            'hivInfos',
            'treatmentRegimens',
            'txSupporters',
            'adherences',
            'prescribedDrugs',
            'treatmentOutcomes',
            'adverseEvents',
            'progress',
            'close_contacts',
            'sputum_monitorings',
            'chestXrays',
            'postTreatment',
            'medicationAdherences'
        ])->findOrFail($id);
        
        return view('admin.patient-profile', compact('patient'));
    }


    public function page1()
    {

        $latestCase = Diagnosis::orderBy('id', 'desc')->first();
        $nextId = $latestCase ? $latestCase->id + 1 : 1;
        $tbCaseNo = 'TB-' . date('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        return view('form.page1', compact('tbCaseNo'));
    }

     


    public function page2()
    {

        return view('form.page2');
    }

    public function page3()
    {

        return view('form.page3');
    }


    // Home
    public function notification()
    {
        return view('home.notification');
    }

    public function error()
    {
        return view('admin.error');
    }

    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('patient.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $validatedData = $request->validate([
            'pat_full_name' => 'required|string|max:255',
            'pat_date_of_birth' => 'required|date',
            'pat_age' => 'required|string',
            'pat_sex' => 'required|string',
            'pat_civil_status' => 'required|string',
            'pat_permanent_address' => 'nullable|string',
            'pat_permanent_city_mun' => 'nullable|string',
            'pat_permanent_province' => 'nullable|string',
            'pat_permanent_region' => 'nullable|string',
            'pat_permanent_zip_code' => 'nullable|string',
            'pat_current_address' => 'nullable|string',
            'pat_current_city_mun' => 'nullable|string',
            'pat_current_province' => 'nullable|string',
            'pat_current_region' => 'nullable|string',
            'pat_current_zip_code' => 'nullable|string',
            'pat_contact_number' => 'nullable|string',
            'pat_other_contact' => 'nullable|string',
            'pat_philhealth_no' => 'nullable|string',
            'pat_nationality' => 'nullable|string',
        ]);

        $patient = Patient::findOrFail($id);
        $patient->update($validatedData);

        return redirect()->back()->with('success', 'Record updated successfully!');
    }

    // View
    // public function view($id)
    // {
    //     $patient = Patient::with([
    //         'diagnosingFacility',
    //         'screenings.labTests',
    //         'diagnosis.tbClassification',
    //         'treatmentFacilities',
    //         'treatmentHistories',
    //         'hivInfos',
    //         'baselineInfos',
    //         'comorbidities',
    //         'treatmentRegimens',
    //         'treatmentOutcomes',
    //         'prescribedDrugs',
    //         'txSupporters',
    //         'adherences',
    //         'adverseEvents',
    //         'progress',
    //         'close_contacts',
    //         'sputum_monitorings',
    //         'chestXrays',
    //         'postTreatment'

    //     ])->findOrFail($id);

    //     return view('admin.patient-profile', compact('patient'));
    // }

    // Delete
    public function destroy($id)
    {

        $patient = Patient::findOrFail($id);
        $patient->delete();

        return redirect()->back()->with('success', 'Patient deleted successfully.');
    }

    

}
