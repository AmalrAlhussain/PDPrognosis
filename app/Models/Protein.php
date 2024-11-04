<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Protein extends Model
{
    // Specify the table name if it's not the plural of the model name
    protected $table = 'protein';

    // Specify which columns can be mass-assigned
    protected $fillable = [
        'visit_id',
        'visit_month',
        'patient_id',
        'UniProt',
        'NPX'
    ];

    // Optional: Add any relationships if needed, for example with a patient or visit model
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_id');
    }
}
