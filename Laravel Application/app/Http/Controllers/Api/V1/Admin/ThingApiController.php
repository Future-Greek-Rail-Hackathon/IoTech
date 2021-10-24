<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreThingRequest;
use App\Http\Requests\UpdateThingRequest;
use App\Http\Resources\Admin\ThingResource;
use App\Models\Thing;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ThingApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('thing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ThingResource(Thing::with(['type'])->get());
    }

    public function store(StoreThingRequest $request)
    {
        $thing = Thing::create($request->all());

        return (new ThingResource($thing))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Thing $thing)
    {
        abort_if(Gate::denies('thing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ThingResource($thing->load(['type']));
    }

    public function update(UpdateThingRequest $request, Thing $thing)
    {
        $thing->update($request->all());

        return (new ThingResource($thing))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Thing $thing)
    {
        abort_if(Gate::denies('thing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $thing->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
