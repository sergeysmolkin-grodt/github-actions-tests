<?php

namespace App\Http\Filters\General;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
class ByEmail
{
    public function __construct(protected Request $request){}

    public function handle(Builder $builder, \Closure $next)
    {
        return $next($builder)
            ->when($this->request->has('email'),
                fn($query) => $query->where('email', 'LIKE', '%' . $this->request->email . '%')
            );
    }
}
