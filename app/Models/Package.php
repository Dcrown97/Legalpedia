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
        'resource_feature', 'slug', 'judg_start_year', 'judg_end_year', 'judg_single_year', 'lfn_single_year', 'lfn_start_year', 'lfn_end_year',
        'judg_cat', 'judg_court', 'lfn_cat', 'roc_cat', 'sroc_state', 'form_cat', 'article_cat', 'maxim_cat', 'dict_cat', 'resource_cat', 'team',
        'note', 'share', 'bookmark', 'is_active', 'ai_cat', 'ai_feature', 'ai_counsel', 'ai_counsel_cat'
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

    // public function setTestAttribute($value)
    // {
    //     // $this->attributes['test'] = json_encode($value);
    //     return $this->attributes['test'] = implode(',', $value);
    // }

    // public function getTestAttribute($value)
    // {
    //     // return $this->attributes['test'] = json_decode($value);
    //     return $this->attributes['test'] = $value;
    // }
}
