<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $relapse = $this->reports->relapse($perPage);
        return view('reports.relapse', compact('relapse'));
    }

    public function bacteriologicallyConfirmed(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $bacteriologicallyConfirmed = $this->reports->bacteriologicallyConfirmed($perPage);
        return view('reports.bacteriologically-confirmed', compact('bacteriologicallyConfirmed'));
    }

    public function clinicallyDiagnosed(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $clinicallyDiagnosed = $this->reports->clinicallyDiagnosed($perPage);
        return view('reports.clinically-diagnosed', compact('clinicallyDiagnosed'));
    }

    public function pulmonary(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $pulmonary = $this->reports->pulmonary($perPage);
        return view('reports.pulmonary', compact('pulmonary'));
    }

    public function extraPulmonary(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $extraPulmonary = $this->reports->extraPulmonary($perPage);
        return view('reports.extra-pulmonary', compact('extraPulmonary'));
    }

    public function ongoingTreatment(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $ongoingPatients = $this->reports->ongoingTreatment($perPage);
        return view('reports.ongoing-treatment', compact('ongoingPatients'));
    }

    public function barangayCases(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $brgyCases = $this->reports->barangayCases($perPage);
        return view('reports.barangay-cases', compact('brgyCases'));
    }

    public function intensiveTreatment(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $intensive = $this->reports->intensiveTreatment($perPage);
        return view('reports.intensive-treatment', compact('intensive'));
    }

    public function maintenanceTreatment(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $maintenanceTreatment = $this->reports->maintenanceTreatment($perPage);
        return view('reports.maintenance-treatment', compact('maintenanceTreatment'));
    }

    public function underage(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $underage = $this->reports->underage($perPage);
        return view('reports.underage', compact('underage'));
    }

    public function sputumMonitoring(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $sputum = $this->reports->sputumMonitoring($perPage);
        return view('reports.sputum-monitoring', compact('sputum'));
    }

    public function cured(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $cured = $this->reports->cured($perPage);
        return view('reports.cured', compact('cured'));
    }

    public function treatmentCompleted(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $treatmentCompleted = $this->reports->treatmentCompleted($perPage);
        return view('reports.treatment-completed', compact('treatmentCompleted'));
    }

    public function lostToFollowUp(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $lostToFollowUp = $this->reports->lostToFollowUp($perPage);
        return view('reports.lost-to-follow-up', compact('lostToFollowUp'));
    }

    public function expired(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $expired = $this->reports->expired($perPage);
        return view('reports.expired', compact('expired'));
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
}
