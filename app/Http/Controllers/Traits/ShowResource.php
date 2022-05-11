<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Resources\Json\JsonResource;

trait ShowResource
{
    use GetsRecord;

    public function show($id)
    {
        $record = $this->getRecord($id);
        return new JsonResource($record);
    }
}
