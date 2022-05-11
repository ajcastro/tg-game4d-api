<?php

namespace App\Models\Traits;

trait SetActiveStatus
{
    public function setActive($is_active = true)
    {
        $this->is_active = $is_active ?? true;
        return $this;
    }
}
