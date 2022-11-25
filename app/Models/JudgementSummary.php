<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JudgementSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'summary_of_facts', 'held', 'issues', 'cases_cited', 'lp_citation', 'statutes_cited', 'judgement_date', 'other_citations',
        'holden_at_id', 'court_id', 'party_a_type_id', 'party_b_type_id', 'category_id', 'category', 'area_of_law', 'suit_no'
    ];

    protected $table = 'judgement_summaries';

    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    public function judgement()
    {
        return $this->hasOne(Judgement::class, 'suit_no', 'suit_no');
    }
    public function areaOfLaw()
    {
        return $this->hasOne(AreaOfLaw::class, 'id', 'area_of_law');
    }
}
