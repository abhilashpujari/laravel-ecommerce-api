<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BaseService
{
    public function mapDataToModel(Request $request, Model $model)
    {
        $data = $request->only($model->getFillable());
        $model->fill($data);
    }
}
