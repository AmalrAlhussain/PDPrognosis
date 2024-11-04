<?php

namespace App\Models;
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    protected $table = 'SurveyAnswer';

    protected $fillable = [
        'survey_id', 'question_id', 'answered_by', 'answer_text'
    ];

    // Relationships
    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id', 'survey_id');
    }

    public function question()
    {
        return $this->belongsTo(SurveyQuestion::class);
    }
}
