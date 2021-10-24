<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePointRequest;
use App\Http\Requests\UpdatePointRequest;
use App\Http\Resources\Admin\PointResource;
use App\Models\Point;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PointsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('point_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PointResource(Point::with(['sensors'])->get());
    }

    public function store(StorePointRequest $request)
    {
        $point = Point::create($request->all());
        $point->sensors()->sync($request->input('sensors', []));

        return (new PointResource($point))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Point $point)
    {
        abort_if(Gate::denies('point_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PointResource($point->load(['sensors']));
    }

    public function update(UpdatePointRequest $request, Point $point)
    {
        $point->update($request->all());
        $point->sensors()->sync($request->input('sensors', []));

        return (new PointResource($point))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Point $point)
    {
        abort_if(Gate::denies('point_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $point->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
