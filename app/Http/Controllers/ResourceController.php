<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CrudUserLog;
use App\Http\Controllers\Traits\DeleteResource;
use App\Http\Controllers\Traits\FillResource;
use App\Http\Controllers\Traits\GetsModel;
use App\Http\Controllers\Traits\PaginateOrListResource;
use App\Http\Controllers\Traits\ResolvesModel;
use App\Http\Controllers\Traits\ResolvesRequest;
use App\Http\Controllers\Traits\SaveResource;
use App\Http\Controllers\Traits\ShowResource;
use App\Http\Controllers\Traits\StoreResource;
use App\Http\Controllers\Traits\UpdateResource;

class ResourceController extends Controller
{
    use ResolvesModel;
    use ResolvesRequest;
    use PaginateOrListResource;
    use ShowResource;
    use StoreResource;
    use UpdateResource;
    use FillResource;
    use SaveResource;
    use DeleteResource;
}
