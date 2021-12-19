<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    use Sluggable;

    protected $fillable = [
        'name', 'description', 'price', 'features', 'permalink', 'validity', 'recur_date',
        'judgement_feature', 'lfn_feature', 'roc_feature', 'sroc_feature', 'form_feature', 'article_feature', 'maxim_feature', 'dict_feature',
        'resource_feature', 'slug', 'judg_start_year', 'judg_end_year'
    ];

    protected $table = 'packages';

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true
            ]
        ];
    }
}
