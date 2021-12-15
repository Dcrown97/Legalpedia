<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawOfFederation extends Model
{
    use HasFactory;

    protected $fillable = [
        'category', 'LawNo', 'Title', 'LawDate', 'Descr', 'SubsidiaryLegislation', 'Tags', 'area_of_law'
    ];

    protected $table = 'laws_of_federations';

    public function law_of_fed_parts() {
        return $this->hasMany(LawOfFedPart::class);
    }

    public function law_of_fed_sections() {
        return $this->hasMany(LawOfFedSection::class);
    }
}
