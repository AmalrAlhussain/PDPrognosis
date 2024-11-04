<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $table = 'TestResult';

    protected $fillable = [
        'result_date', 'visit_id', 'protein_data', 'peptide_data', 'video_url'
    ];

    // Relationships
    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }
}
