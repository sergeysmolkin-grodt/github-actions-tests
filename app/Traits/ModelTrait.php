<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait ModelTrait
{
    /**
     * @param array $data
     * @param Model $model
     * @return array
     */
    public function getFillableDataForModel(array $data, Model $model): array
    {
        $fillableFields = $model->getFillable();
        return array_intersect_key($data, array_flip($fillableFields));
    }
}
