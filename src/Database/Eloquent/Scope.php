<?php

namespace Turovskiy\WpEloquent\Database\Eloquent;

interface Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Turovskiy\WpEloquent\Database\Eloquent\Builder  $builder
     * @param  \Turovskiy\WpEloquent\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model);
}
