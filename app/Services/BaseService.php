<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Exception;

class BaseService
{
    public function delete(Model $model, array $options = [])
    {
        try {
            $model->delete();
        } catch (Exception $e) {
        }
    }

    public function save(Model $model, array $options = [])
    {
        $model->save($options);
    }

    public function update(Model $model, array $options = [])
    {
        $model->update($options);
    }
}
