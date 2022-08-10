<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\WalkthroughCollection;
use App\Traits\ApiResponser;
use App\Models\Walkthrough;

class WalkthroughController extends Controller
{
    use ApiResponser;

    public function list()
    {
        $walkthrough = Walkthrough::all();
        return $this->successResponse(200, trans('api.public.done'), 200, new WalkthroughCollection($walkthrough));
    }
}
