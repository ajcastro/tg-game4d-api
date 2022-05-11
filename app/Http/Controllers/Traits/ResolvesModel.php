<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Database\Eloquent\Model;

trait ResolvesModel
{
    /**
     * The resource model
     *
     * @var string|\Illuminate\Database\Eloquent\Model
     */
    protected $model;

    protected function model(): Model
    {
        if (is_string($this->model)) {
            return $this->model::make();
        }

        if ($this->model instanceof Model) {
            return $this->model;
        }

        return $this->query->getModel();
    }
}
