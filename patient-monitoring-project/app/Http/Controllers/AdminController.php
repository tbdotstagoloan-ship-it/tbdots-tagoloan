<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\returnArgument;
use App\Models\Patient;
use App\Models\Diagnosis;
use App\Models\Treatment;
use App\Models\Outcome;

class AdminController extends Controller
{
    public function index()
    {
        $totalPatients = DB::table('tbl_patients')->count();

        $totalStaff = DB::table('users')->count();

        $totalPhysician = DB::table('tbl_diagnosis')
            ->distinct('diag_attending_physician')
            ->count('diag_attending_physician');

        $pulmonary = DB::table('tbl_tb_classifications')
            ->where('clas_anatomical_site', 'Pulmonary')->count();

        $extra = DB::table('tbl_tb_classifications')
            ->where('clas_anatomical_site', 'Extra-pulmonary')->count();

        return view('admin.index', compact(
            'totalPatients',
            'totalPhysician',
            'totalStaff',
            'pulmonary',
            'extra'
        ));
    }

    // public function patient(Request $request)
    // {
    //     $patients = DB::table('tbl_patients as p')
    //         ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
    //         ->select(
    //             'p.id',
    //             'p.pat_full_name',
    //             'p.pat_sex',
    //             DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
    //             'p.pat_current_address',
    //             'p.pat_contact_number',
    //             'd.diag_diagnosis_date',
    //         )
    //         ->orderBy('d.diag_diagnosis_date', 'desc')
    //         ->paginate(10);

    //     $totalPatients = DB::table('tbl_patients')->count();

    //     return view('admin.patient', compact('patients', 'totalPatients'));
    // }

    public function patient(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10); // default 10

        $patients = DB::table('tbl_patients as p')
            ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->select(
                'p.id',
                'p.pat_full_name',
                'p.pat_sex',
                DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
                'p.pat_current_address',
                'd.diag_tb_case_no',
                'd.diag_diagnosis_date',
            )
            ->when($search, function ($query, $search) {
                $query->where('p.pat_full_name', 'LIKE', "%{$search}%")
                    ->orWhere('p.pat_contact_number', 'LIKE', "%{$search}%")
                    ->orWhere('p.pat_current_address', 'LIKE', "%{$search}%");
            })
            ->orderBy('d.diag_tb_case_no', 'desc')
            ->paginate($perPage);

        $totalPatients = DB::table('tbl_patients')->count();

        return view('admin.patient', compact('patients', 'totalPatients', 'perPage'));
    }


    public function patientProfile()
    {
        return view('admin.patient-profile');
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

    public function store(Request $request, $patientId)
    {
        $request->validate([
            'sput_date_collected' => 'required|date',
            'sput_smear_result'   => 'nullable|string',
            'sput_xpert_result'   => 'required|string',
        ]);

        $patient = Patient::findOrFail($patientId);

        $patient->sputum_monitorings()->create([
            'sput_date_collected' => $request->sput_date_collected,
            'sput_smear_result'   => $request->sput_smear_result,
            'sput_xpert_result'   => $request->sput_xpert_result,
        ]);

        return back()->with('success', 'Sputum result added successfully.');
    }

    public function storeAdverseEvent(Request $request, $patientId)
    {
        $request->validate([
            'adv_ae_date' => 'required|date',
            'adv_specific_ae' => 'required|string|max:255',
            'adv_fda_reported_date' => 'nullable|date',
        ]);

        $patient = Patient::findOrFail($patientId);

        $patient->adverseEvents()->create([
            'adv_ae_date' => $request->adv_ae_date,
            'adv_specific_ae' => $request->adv_specific_ae,
            'adv_fda_reported_date' => $request->adv_fda_reported_date,
        ]);

        return back()->with('success', 'Adverse event added successfully.');
    }

    public function storeProgress(Request $request, $patientId)
    {
        $request->validate([
            'prog_date' => 'required|date',
            'prog_problem' => 'required|string',
            'prog_action_taken' => 'required|string',
            'prog_plan' => 'required|string',
        ]);

        $patient = Patient::findOrFail($patientId);

        $patient->Progress()->create([
            'prog_date' => $request->prog_date,
            'prog_problem' => $request->prog_problem,
            'prog_action_taken' => $request->prog_action_taken,
            'prog_plan' => $request->prog_plan,
        ]);

        return back()->with('success', 'Patient Progress added successfully.');
    }

    public function storeCloseContact(Request $request, $patientId)
    {
        $request->validate([
            'con_name' => 'required|string|max:255',
            'con_age' => 'required|integer',
            'con_sex' => 'required|string',
            'con_relationship' => 'required|string|max:255',
            'con_initial_screening' => 'nullable|date',
            'con_follow_up' => 'nullable|date',
            'con_remarks' => 'nullable|string|max:255',
        ]);

        $patient = Patient::findOrFail($patientId);

        $patient->close_contacts()->create([
            'con_name' => $request->con_name,
            'con_age' => $request->con_age,
            'con_sex' => $request->con_sex,
            'con_relationship' => $request->con_relationship,
            'con_initial_screening' => $request->con_initial_screening,
            'con_follow_up' => $request->con_follow_up,
            'con_remarks' => $request->con_remarks,
        ]);

        return back()->with('success', 'Close contact added successfully.');
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

    public function add()
    {
        

        return view ('patient.add-result');
    }

    // Update
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $patient->update([
            'pat_full_name',
            'pat_date_of_birth',
            'pat_age',
            'pat_sex',
            'pat_civil_status',
            'pat_permanent_address',
            'pat_permanent_city_mun',
            'pat_permanent_region',
            'pat_permanent_zip_code',
            'pat_current_address',
            'pat_current_city_mun',
            'pat_current_region',
            'pat_current_zip_code',
            'pat_contact_number',
            'pat_other_contact',
            'pat_philhealth_no',
            'pat_nationality'
        ]);

        $patient->update($request->all());

        return redirect()->route('admin.patient')->with('success', 'Patient updated successfully!');
    }

    // View
    public function view($id)
    {
        $patient = Patient::with([
            'diagnosingFacility',
            'screenings.labTests',
            'diagnosis.tbClassification',
            'treatmentFacilities.treatmentHistories',
            'hivInfos',
            'baselineInfos',
            'comorbidities',
            'treatmentRegimens',
            'treatmentOutcomes',
            'prescribedDrugs',
            'txSupporters',
            'adherences',
            'adverseEvents',
            'progress',
            'close_contacts',
            'sputum_monitorings',
            'chestXrays',
            'postTreatment'

        ])->findOrFail($id);

        return view('admin.patient-profile', compact('patient'));
    }

    // Delete
    public function destroy($id)
    {

        $patient = Patient::findOrFail($id);
        $patient->delete();

        return redirect()->back()->with('success', 'Patient deleted successfully.');
    }


}
