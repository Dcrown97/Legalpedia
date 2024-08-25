<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
class SummaryRatio extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'suit_no', 'heading', 'body'
    ];

    protected $table = 'summary_ratios';

    public function suit_no()
    {
        return $this->hasOne(JudgementSummary::class, 'suit_no', 'suit_no');
    }

}
