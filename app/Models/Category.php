<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, Sluggable, HasEagerLimit;

    protected $guarded = [];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    //Model binding
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function scopeByCategory($query)
    {
        return $query->with(['recipes' => function ($recipes) {
            $recipes->published()->limit(3);
        }])->get()->filter(function ($item) {
            return $item->recipes->count() > 0;
        });
    }
}
