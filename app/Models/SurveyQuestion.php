<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    protected $table = 'SurveyQuestion';

    protected $fillable = [
        'part',
        'instructions',
        'question_text',
    ];

    // Relationships
    public function surveyAnswers()
    {
        return $this->hasMany(SurveyAnswer::class, 'question_id', 'question_id');
    }
}
