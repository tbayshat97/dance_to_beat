<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\StaticPageCollection;
use App\Models\StaticPage;
use App\Traits\ApiResponser;

class StaticPageController extends Controller
{
    use ApiResponser;

    public function list()
    {
        $staticPages = StaticPage::all();
        return $this->successResponse(200, trans('api.public.done'), 200, new StaticPageCollection($staticPages));
    }
}
