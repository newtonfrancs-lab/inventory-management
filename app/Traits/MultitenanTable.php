<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Multitenantable {

    public static function bootMultitenantable()
    {
        if (auth()->check()) {
            // When fetching data, only show rows belonging to the user's company
            static::addGlobalScope('company_id', function (Builder $builder) {
                $builder->where('company_id', auth()->user()->company_id);
            });

            // When creating data, automatically set the company_id
            static::creating(function ($model) {
                $model->company_id = auth()->user()->company_id;
            });
        }
    }
}