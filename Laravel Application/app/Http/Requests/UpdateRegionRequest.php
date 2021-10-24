<?php

namespace App\Http\Requests;

use App\Models\Region;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateRegionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('region_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'points.*' => [
                'integer',
            ],
            'points' => [
                'required',
                'array',
            ],
            'managers.*' => [
                'integer',
            ],
            'managers' => [
                'required',
                'array',
            ],
        ];
    }
}
