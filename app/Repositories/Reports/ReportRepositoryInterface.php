<?php

namespace App\Repositories\Reports;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ReportRepositoryInterface
{
    public function newlyDiagnosed(int $perPage = 10): LengthAwarePaginator;
    public function relapse(int $perPage = 10): LengthAwarePaginator;
    public function bacteriologicallyConfirmed(int $perPage = 10): LengthAwarePaginator;
    public function clinicallyDiagnosed(int $perPage = 10): LengthAwarePaginator;
    public function pulmonary(int $perPage = 10): LengthAwarePaginator;
    public function extraPulmonary(int $perPage = 10): LengthAwarePaginator;
    public function ongoingTreatment(int $perPage = 10): LengthAwarePaginator;
    public function barangayCases(int $perPage = 10): LengthAwarePaginator;
    public function intensiveTreatment(int $perPage = 10): LengthAwarePaginator;
    public function maintenanceTreatment(int $perPage = 10): LengthAwarePaginator;
    public function underage(int $perPage = 10): LengthAwarePaginator;
    public function sputumMonitoring(int $perPage = 10): LengthAwarePaginator;
    public function cured(int $perPage = 10): LengthAwarePaginator;
    public function treatmentCompleted(int $perPage = 10): LengthAwarePaginator;
    public function lostToFollowUp(int $perPage = 10): LengthAwarePaginator;
    public function expired(int $perPage = 10): LengthAwarePaginator;
    public function brgyCasesNotification(int $perPage = 10): LengthAwarePaginator;
    public function quarterlyCasesNotification(int $perPage = 10): LengthAwarePaginator;
    public function quarterlyTBClassification(int $perPage = 10): LengthAwarePaginator;
    public function quarterlyAnatomicalSite(int $perPage = 10): LengthAwarePaginator;
    public function quarterlyTreatmentOutcome(int $perPage = 10): LengthAwarePaginator;
}
