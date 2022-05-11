<?php

namespace App\Http\Queries\Contracts;

interface QueryContract
{
    public function withAllDeclarations();

    public function withFields();

    public function withInclude();

    public function withFilter();

    public function withSort();
}
