<?php

if (!function_exists('model_id')) {
    /**
     * Return the model id if given parameter is a model.
     * Return the parameter if it is already a integer or string id value.
     *
     * @param mixed $model
     * @return mixed
     */
    function model_id($model)
    {
        return is_object($model) && method_exists($model, 'getKey')
            ? $model->getKey()
            : $model;
    }
}
