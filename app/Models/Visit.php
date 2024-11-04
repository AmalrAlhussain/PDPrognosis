<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $table = 'Visit';

    protected $fillable = [
        'visit_date', 'doctor_id', 'patient_id', 'score','visit_month', 'notes'
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

    public function testResults()
    {
        return $this->hasMany(TestResult::class);
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }
}
