<?php

namespace App\Http\Filters\Teacher;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ByGender
{
    public function __construct(protected Request $request){}

    public function handle(Builder $builder, \Closure $next)
    {
        $builder->whereHas('userDetails', function($query){
            $query->when($this->request->filled('gender'),
                fn($query) => $query->where('gender', $this->request->gender)
            );
        });

        return $next($builder);
    }
}
