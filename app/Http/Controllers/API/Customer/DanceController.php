<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\DanceCollection;
use App\Models\Dance;
use App\Traits\ApiResponser;

class DanceController extends Controller
{
    use ApiResponser;

    public function list()
    {
        $dances = Dance::all();
        return $this->successResponse(200, trans('api.public.done'), 200, new DanceCollection($dances));
    }
}
