<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class LawOfFedSection extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'section_header', 'section_body', 'law_of_federation_id', 'law_of_fed_part_id'
    ];

    protected $table = 'law_of_fed_sections';

    public function law_of_fed_part() {
        return $this->belongsTo(LawOfFedPart::class);
    }
}
