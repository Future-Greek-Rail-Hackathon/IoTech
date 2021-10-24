<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSensorTypeRequest;
use App\Http\Requests\UpdateSensorTypeRequest;
use App\Http\Resources\Admin\SensorTypeResource;
use App\Models\SensorType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SensorTypeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sensor_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SensorTypeResource(SensorType::all());
    }

    public function store(StoreSensorTypeRequest $request)
    {
        $sensorType = SensorType::create($request->all());

        return (new SensorTypeResource($sensorType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SensorType $sensorType)
    {
        abort_if(Gate::denies('sensor_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SensorTypeResource($sensorType);
    }

    public function update(UpdateSensorTypeRequest $request, SensorType $sensorType)
    {
        $sensorType->update($request->all());

        return (new SensorTypeResource($sensorType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SensorType $sensorType)
    {
        abort_if(Gate::denies('sensor_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sensorType->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
