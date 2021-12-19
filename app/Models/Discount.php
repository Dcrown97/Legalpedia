<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    use Sluggable;


    protected $fillable = [
        'name', 'validity_start_date', 'validity_end_date', 'discount_code', 'usage', 'percentage', 'package', 'slug'
    ];

    protected $table = 'discounts';

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'package',
                'onUpdate' => true
            ]
        ];
    }
}
