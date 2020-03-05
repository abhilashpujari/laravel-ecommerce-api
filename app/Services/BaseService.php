<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BaseService
{
    public function delete(Model $model, array $options = [])
    {
        try {
            $model->delete();
        } catch (Exception $e) {
        }
    }

    public function find(Model $model, $id)
    {
        return $model::find($id);
    }

    public function findOneBy($table, array $criteria, array $orderBy = null)
    {
        $queryTable = DB::table($table);
        foreach ($criteria as $key => $value) {
            $queryTable->where($key, '=', $value);
        }

        if ($orderBy) {
            foreach ($orderBy as $columnName => $sort) {
                $queryTable->orderBy($columnName, $sort);
            }
        }

        return $queryTable->first();
    }

    public function save(Model $model, array $options = [])
    {
        $model->save($options);
    }

    public function update(Model $model, array $options = [])
    {
        $model->update($options);
    }

    protected function mapDataToModel(Request $request, Model $model)
    {
        $data = $request->only($model->getFillable());
        $model->fill($data);
    }
}
