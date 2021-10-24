<?php

namespace App\Http\Requests;

use App\Models\SensorType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSensorTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sensor_type_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
