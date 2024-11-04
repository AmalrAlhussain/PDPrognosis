<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peptide extends Model
{
    protected $table = 'Peptide';

    protected $fillable = [
        'visit_id', 'visit_month', 'patient_id', 'UniProt', 'Peptide', 'PeptideAbundance'
    ];
}
