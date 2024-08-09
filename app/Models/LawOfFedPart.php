<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawOfFedPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_header', 'law_of_federation_id', 'position'
    ];

    protected $table = 'law_of_fed_parts';

    public function law_of_federation() {
        return $this->belongsTo(LawOfFederation::class);
    }

    public function law_of_fed_sections() {
        return $this->hasMany(LawOfFedSection::class);
    }
}
