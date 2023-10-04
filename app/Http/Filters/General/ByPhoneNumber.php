<?php

namespace App\Http\Filters\General;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ByPhoneNumber
{
    public function __construct(protected Request $request){}

    public function handle(Builder $builder, \Closure $next)
    {
        $builder->whereHas('userDetails', function ($query) {
            $query->when($this->request->has('mobile'),
                fn($query) => $query->where('mobile', 'LIKE', '%' . $this->request->mobile . '%')
            );
        });

        return $next($builder);
    }
}
