<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectMatterIndex extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_matter_index'
    ];

    protected $table = 'subject_matter_indices';
}
