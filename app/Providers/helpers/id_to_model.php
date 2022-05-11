<?php

if (!function_exists('id_to_model')) {
    /**
     * Return the model with given id.
     */
    function id_to_model($model, $id)
    {
        $instance = new $model;
        $instance->id = $id;
        return $instance;
    }
}
