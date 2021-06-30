<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChartRequest;
use App\Services\Chart\Chart;
use Illuminate\Http\JsonResponse;

class EchartsController extends Controller
{
    private Chart $service;

    public function __construct(Chart $service)
    {
        $this->service = $service;
    }

    public function __invoke(ChartRequest $request): JsonResponse|array
    {
        return $this->service->handler($request->all());
    }
}
