<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class LawOfFederation extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'category', 'law_no', 'title', 'law_date', 'description', 'subsidiary_legislation', 'tags', 'area_of_law'
    ];

    protected $table = 'laws_of_federations';

    public function law_of_fed_parts() {
        return $this->hasMany(LawOfFedPart::class);
    }

    public function law_of_fed_sections() {
        return $this->hasMany(LawOfFedSection::class);
    }
}
