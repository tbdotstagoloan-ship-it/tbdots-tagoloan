<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'tbl_patients';

    protected $fillable = [
        'pat_full_name',
        'pat_date_of_birth',
        'pat_age',
        'pat_sex',
        'pat_civil_status',
        'pat_permanent_address',
        'pat_permanent_city_mun',
        'pat_permanent_province',
        'pat_permanent_region',
        'pat_permanent_zip_code',
        'pat_current_address',
        'pat_current_city_mun',
        'pat_current_province',
        'pat_current_region',
        'pat_current_zip_code',
        'pat_contact_number',
        'pat_other_contact',
        'pat_philhealth_no',
        'pat_nationality',
        'user_id',
        'diagfacility_id',
        'pha_continuation_end'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Page 1
    public function diagnosingFacility()
    {
        return $this->belongsTo(DiagnosingFacility::class, 'diagfacility_id');
    }

    public function screenings()
    {
        return $this->hasMany(Screening::class, 'patient_id');
    }

    public function labTests()
    {
        return $this->hasMany(LaboratoryTest::class, 'patient_id');
    }

    public function diagnosis()
    {
        return $this->hasOne(Diagnosis::class, 'patient_id');
    }

    public function tbClassification()
    {
        return $this->hasOne(TBClassification::class, 'patient_id');
    }

    // Page 2
    public function treatmentFacilities()
    {
        return $this->hasMany(TreatmentFacility::class, 'patient_id');
    }

    public function treatmentHistories()
    {
        return $this->hasMany(TreatmentHistory::class, 'patient_id');
    }

    public function hivInfos()
    {
        return $this->hasMany(HIVInfo::class, 'patient_id');
    }

    public function baselineInfos()
    {
        return $this->hasMany(BaselineInfo::class, 'patient_id');
    }

    public function comorbidities()
    {
        return $this->hasMany(Comorbidity::class, 'patient_id');
    }

    public function treatmentRegimens()
    {
        return $this->hasMany(TreatmentRegimen::class, 'patient_id');
    }

    public function treatmentOutcomes()
    {
        return $this->hasMany(TreatmentOutcome::class, 'patient_id');
    }

    public function prescribedDrugs()
    {
        return $this->hasMany(PrescribedDrug::class, 'patient_id');
    }

    public function txSupporters()
    {
        return $this->hasMany(TxSupporter::class, 'patient_id');
    }

    public function adherences()
    {
        return $this->hasMany(Adherence::class, 'patient_id');
    }

    // Page 3
    public function adverseEvents()
    {
        return $this->hasMany(AdverseEvent::class, 'patient_id');
    }

    public function progress()
    {
        return $this->hasMany(Progress::class, 'patient_id');
    }

    public function close_contacts()
    {
        return $this->hasMany(CloseContact::class, 'patient_id');
    }

    public function sputum_monitorings()
    {
        return $this->hasMany(SputumMonitoring::class, 'patient_id');
    }

    public function chestXrays()
    {
        return $this->hasMany(ChestXray::class, 'patient_id');
    }

    public function postTreatment()
    {
        return $this->hasMany(PostTreatmentFollowUp::class, 'patient_id');
    }

    public function medicationAdherences()
    {
        return $this->hasMany(MedicationAdherence::class, 'patient_id');
    }


}
