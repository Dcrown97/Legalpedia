<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawOfFedSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'SectionHeader', 'SectionBody', 'LawId', 'PartId'
    ];

    protected $table = 'law_of_fed_sections';

    public function law_of_fed_part() {
        return $this->belongsTo(LawOfFedPart::class);
    }
}
