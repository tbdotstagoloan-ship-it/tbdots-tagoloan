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
    // public function index()
    // {
    //     $totalPatients = Patient::count();

    //     $totalPhysician = Physician::count();

    //     $totalPersonnel = User::count();

    //     $totalFacility = DiagnosingFacility::count();

    //     $pulmonary = TBClassification::where('clas_anatomical_site', 'Pulmonary')->count();

    //     $extra = TBClassification::where('clas_anatomical_site', 'Extra-pulmonary')->count();

    //     $accounts = PatientAccount::with('patient')->get();

    //         $patientsWithConsecutiveMissed = $accounts->map(function ($acc) {
    //             $patient = $acc->patient;
    //             if (!$patient) return null;

    //             $adherenceLogs = MedicationAdherence::where('username', $acc->acc_username)
    //                 ->orderBy('date', 'desc')
    //                 ->pluck('status', 'date');

    //             $consecutiveMissed = 0;
    //             foreach ($adherenceLogs as $status) {
    //                 if ($status === 'missed') {
    //                     $consecutiveMissed++;
    //                 } else {
    //                     break;
    //                 }
    //             }

    //             if ($consecutiveMissed >= 2) {
    //                 return [
    //                     'patient_id' => $patient->id ?? null,
    //                     'full_name' => $patient->pat_full_name,
    //                     'barangay' => $patient->pat_current_address,
    //                     'username' => $acc->acc_username,
    //                     'contact' => $patient->pat_contact_number,
    //                     'consecutive_missed' => $consecutiveMissed,
    //                     'last_missed' => MedicationAdherence::where('username', $acc->acc_username)
    //                         ->where('status', 'missed')
    //                         ->orderByDesc('date')
    //                         ->value('date'),
    //                 ];
    //             }

    //             return null;
    //         })->filter()->values();

    //         return view('admin.index', compact(
    //             'totalPatients',
    //             'totalPhysician',
    //             'pulmonary',
    //             'extra',
    //             'totalFacility',
    //             'totalPersonnel',
    //             'patientsWithConsecutiveMissed'
    //         ));
    // }


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
        })->filter()->values();

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




    // public function patient(Request $request)
    // {
    //     $search = $request->input('search');
    //     $perPage = $request->input('per_page', 10); // default 10

    //     $patients = DB::table('tbl_patients as p')
    //         ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
    //         ->join('tbl_treatment_outcomes as to', 'p.id', '=', 'to.patient_id')
    //         ->select(
    //             'p.id',
    //             'p.*',
    //             'p.pat_full_name',
    //             'p.pat_sex',
    //             DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
    //             'p.pat_current_address',
    //             'd.diag_tb_case_no',
    //             'd.diag_diagnosis_date',
    //             'to.out_outcome as status'
    //         )
    //         ->when($search, function ($query, $search) {
    //             $query->where('p.pat_full_name', 'LIKE', "%{$search}%")
    //                 ->orWhere('d.diag_tb_case_no', 'LIKE', "%{$search}%");
    //         })
    //         ->orderBy('p.id', 'desc')
    //         ->paginate($perPage);

    //     $totalPatients = DB::table('tbl_patients')->count();

    //     return view('admin.patient', compact('patients', 'totalPatients', 'perPage'));
    // }

    public function patient(Request $request)
    {
        $totalPatients = Cache::remember('total_patients_count', 60, fn() => Patient::count());
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $patients = DB::table('tbl_patients as p')
            ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->join('tbl_treatment_outcomes as to', 'p.id', '=', 'to.patient_id')
            ->select(
                'p.id',
                'p.pat_full_name',
                'p.pat_sex',
                'p.pat_date_of_birth',
                'p.pat_civil_status',
                DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
                'p.pat_current_region',
                'p.pat_current_province',
                'p.pat_current_city_mun',
                'p.pat_current_address',
                'p.pat_current_zip_code',
                'p.pat_contact_number',
                'p.pat_other_contact',
                'p.pat_philhealth_no',
                'p.pat_nationality',
                'd.diag_tb_case_no',
                'd.diag_diagnosis_date',
                'to.out_outcome as status'
            )
            ->when($search, function ($query, $search) {
                $query->whereRaw("MATCH(p.pat_full_name) AGAINST(? IN BOOLEAN MODE)", [$search])
                    ->orWhere('d.diag_tb_case_no', 'LIKE', "{$search}%");
            })
            ->orderBy('p.id', 'desc')
            ->paginate($perPage);

        return view('admin.patient', compact('patients', 'totalPatients', 'perPage'));
    }


    public function patientProfile($id)
    {
        $patient = Patient::findOrFail($id);
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


    // Edit
    // public function edit($id)
    // {
    //     $patient = Patient::findOrFail($id);

    //     $diagnosis = Diagnosis::where('patient_id', $patient->id)->first();

    //     return view('patient.edit', compact('patient', 'diagnosis'));
    // }

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

        return redirect()->back()->with('success', 'Patient updated successfully!');
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
