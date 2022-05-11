<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Schema;

trait HasAllowableFields
{
    public static function tableColumns()
    {
        return Schema::getColumnListing((new static)->getTable());
        // return memo([__CLASS__, __METHOD__], function () {
        //     return Schema::getColumnListing((new static)->getTable());
        // });
    }

    public static function allowableFields()
    {
        return collect(static::tableColumns())->diff((new static)->getHidden())->values()->all();
    }
}
