<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\Reports\ReportRepositoryInterface;

class ReportGenerationController extends Controller
{
    public function __construct(private ReportRepositoryInterface $reports) {}

    public function newlyDiagnosed(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        
        $new = $this->reports->newlyDiagnosed($perPage, $startDate, $endDate);
        
        return view('reports.newly-diagnosed', compact('new', 'startDate', 'endDate'));
    }

    public function relapse(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $relapse = $this->reports->relapse($perPage, $startDate, $endDate);

        return view('reports.relapse', compact('relapse', 'startDate', 'endDate'));
    }


    public function bacteriologicallyConfirmed(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $bacteriologicallyConfirmed = $this->reports->bacteriologicallyConfirmed($perPage, $startDate, $endDate);
        
        return view('reports.bacteriologically-confirmed', compact('bacteriologicallyConfirmed', 'startDate', 'endDate'));
    }

    public function clinicallyDiagnosed(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $clinicallyDiagnosed = $this->reports->clinicallyDiagnosed($perPage, $startDate, $endDate);
        
        return view('reports.clinically-diagnosed', compact('clinicallyDiagnosed', 'startDate', 'endDate'));
    }

    public function pulmonary(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $pulmonary = $this->reports->pulmonary($perPage, $startDate, $endDate);
        return view('reports.pulmonary', compact('pulmonary', 'startDate', 'endDate'));
    }

    public function extraPulmonary(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $extraPulmonary = $this->reports->extraPulmonary($perPage, $startDate, $endDate);

        return view('reports.extra-pulmonary', compact('extraPulmonary', 'startDate', 'endDate'));
    }

    public function ongoingTreatment(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $ongoingPatients = $this->reports->ongoingTreatment($perPage, $startDate, $endDate);

        return view('reports.ongoing-treatment', compact('ongoingPatients', 'startDate', 'endDate'));
    }

    public function barangayCases(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $barangay = $request->query('barangay');

        // Fetch distinct barangays for dropdown
        $barangays = DB::table('tbl_patients')
            ->select('pat_permanent_address')
            ->distinct()
            ->orderBy('pat_permanent_address')
            ->pluck('pat_permanent_address');

        $brgyCases = $this->reports->barangayCases($perPage, $startDate, $endDate, $barangay);

        return view('reports.barangay-cases', compact('brgyCases', 'barangays', 'startDate', 'endDate', 'barangay'));
    }


    public function intensiveTreatment(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        
        $intensive = $this->reports->intensiveTreatment($perPage, $startDate, $endDate);

        return view('reports.intensive-treatment', compact('intensive', 'startDate', 'endDate'));
    }

    public function maintenanceTreatment(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        
        $maintenanceTreatment = $this->reports->maintenanceTreatment($perPage, $startDate, $endDate);

        return view('reports.maintenance-treatment', compact('maintenanceTreatment', 'startDate', 'endDate'));
    }

    public function underage(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $underage = $this->reports->underage($perPage, $startDate, $endDate);
        return view('reports.underage', compact('underage', 'startDate', 'endDate'));
    }

    public function sputumMonitoring(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $sputum = $this->reports->sputumMonitoring($perPage, $startDate, $endDate);

        return view('reports.sputum-monitoring', compact('sputum', 'startDate', 'endDate'));
    }

    public function cured(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $cured = $this->reports->cured($perPage, $startDate, $endDate);

        return view('reports.cured', compact('cured', 'startDate', 'endDate'));
    }

    public function treatmentCompleted(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $treatmentCompleted = $this->reports->treatmentCompleted($perPage, $startDate, $endDate);

        return view('reports.treatment-completed', compact('treatmentCompleted', 'startDate', 'endDate'));
    }

    public function lostToFollowUp(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $lostToFollowUp = $this->reports->lostToFollowUp($perPage, $startDate, $endDate);

        return view('reports.lost-to-follow-up', compact('lostToFollowUp', 'startDate', 'endDate'));
    }

    public function expired(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $expired = $this->reports->expired($perPage, $startDate, $endDate);

        return view('reports.expired', compact('expired', 'startDate', 'endDate'));
    }

    public function brgyCasesNotification(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $brgyCasesNotification = $this->reports->brgyCasesNotification($perPage);
        return view('reports.barangay-cases-notification', compact('brgyCasesNotification'));
    }

    public function quarterlyCasesNotification(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $quarterlyCasesNotification = $this->reports->quarterlyCasesNotification($perPage);
        return view('reports.quarterly-cases-notification', compact('quarterlyCasesNotification'));
    }

    public function quarterlyTBClassification(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $quarterlyTBClassification = $this->reports->quarterlyTBClassification($perPage);
        return view('reports.quarterly-tb-classification', compact('quarterlyTBClassification'));
    }

    public function quarterlyAnatomicalSite(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $quarterlyAnatomicalSite = $this->reports->quarterlyAnatomicalSite($perPage);
        return view('reports.quarterly-anatomical-site', compact('quarterlyAnatomicalSite'));
    }

    public function quarterlyTreatmentOutcome(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $quarterlyOutcome = $this->reports->quarterlyTreatmentOutcome($perPage);
        return view('reports.quarterly-treatment-outcome', compact('quarterlyOutcome'));
    }

    public function adverseEvent(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        
        $adverseEvent = $this->reports->adverseEvent($perPage, $startDate, $endDate);
        
        return view('reports.adverse-event', compact('adverseEvent', 'startDate', 'endDate'));
    }
}
