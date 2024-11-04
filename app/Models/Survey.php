<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $table = 'Survey';

    protected $primaryKey = 'survey_id';

    protected $fillable = [
        'survey_date', 'doctor_id', 'patient_id', 'visit_id', 'doctor_filled', 'patient_filled', 'final_score', 'part'
    ];

    // Relationships
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function surveyAnswers()
    {
        return $this->hasMany(SurveyAnswer::class, 'survey_id', 'survey_id');
    }
}
