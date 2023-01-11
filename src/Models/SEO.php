<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SEO extends Model
{
    protected $table = 'seo';
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::addGlobalScope('locale', function (Builder $builder) {
            $builder->where('locale', app()->getLocale());
        });

        static::saving(function ($model) {
            $model->locale = app()->getLocale();
            $model->link = rtrim($model->link, '/');
        });
    }
}
