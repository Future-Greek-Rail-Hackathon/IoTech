<?php

namespace App\Http\Requests;

use App\Models\Point;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePointRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('point_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'latitude' => [
                'string',
                'required',
            ],
            'longitude' => [
                'string',
                'required',
            ],
            'sensors.*' => [
                'integer',
            ],
            'sensors' => [
                'array',
            ],
        ];
    }
}
