<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawOfFedSched extends Model
{
    use HasFactory;

    protected $fillable = [
        'sched_header', 'sched_body', 'law_of_federation_id'
    ];

    protected $table = 'law_of_fed_scheds';

    public function law_of_federation() {
        return $this->belongsTo(LawOfFederation::class);
    }

    public function law_of_fed_sections() {
        return $this->hasMany(LawOfFedSection::class);
    }
}
