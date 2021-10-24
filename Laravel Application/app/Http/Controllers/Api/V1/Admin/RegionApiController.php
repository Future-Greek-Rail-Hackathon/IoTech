<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegionRequest;
use App\Http\Requests\UpdateRegionRequest;
use App\Http\Resources\Admin\RegionResource;
use App\Models\Region;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegionApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('region_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RegionResource(Region::with(['points', 'managers'])->get());
    }

    public function store(StoreRegionRequest $request)
    {
        $region = Region::create($request->all());
        $region->points()->sync($request->input('points', []));
        $region->managers()->sync($request->input('managers', []));

        return (new RegionResource($region))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Region $region)
    {
        abort_if(Gate::denies('region_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RegionResource($region->load(['points', 'managers']));
    }

    public function update(UpdateRegionRequest $request, Region $region)
    {
        $region->update($request->all());
        $region->points()->sync($request->input('points', []));
        $region->managers()->sync($request->input('managers', []));

        return (new RegionResource($region))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Region $region)
    {
        abort_if(Gate::denies('region_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $region->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
