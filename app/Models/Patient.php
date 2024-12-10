<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;

class Patient extends Authenticatable
{
    protected $table = 'Patient';

    protected $fillable = [
        'fullname', 'username', 'email', 'password', 'phone', 'doctor_id', 'status', 'uniprot_id', 'id'
    ];

    // Relationships
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
    public function gameResults()
    {
        return $this->hasMany(ParkinsonGameResult::class, 'patient_id');
    }
    public function typingGameResults()
    {
        return $this->hasMany(TypingTestResult::class, 'patient_id');
    }
    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }
}
