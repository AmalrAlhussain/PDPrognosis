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

    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }
}
