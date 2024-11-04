<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Authenticatable
{
    protected $table = 'Doctor';

    protected $fillable = [
        'fullname', 'username', 'email', 'password', 'phone', 'specialty', 'status'
    ];

    // Relationships
    public function patients()
    {
        return $this->hasMany(Patient::class);
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
