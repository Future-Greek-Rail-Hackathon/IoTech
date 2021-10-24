<?php

namespace App\Http\Requests;

use App\Models\Thing;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateThingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('thing_edit');
    }

    public function rules()
    {
        return [
            'type_id' => [
                'required',
                'integer',
            ],
            'name' => [
                'string',
                'nullable',
            ],
            'eui' => [
                'string',
                'required',
                'unique:things,eui,' . request()->route('thing')->id,
            ],
            'installed_at' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
