<?php

namespace App\Http\Requests;

use App\Models\MaintenanceEvent;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateMaintenanceEventRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('maintenance_event_edit');
    }

    public function rules()
    {
        return [
            'type_id' => [
                'required',
                'integer',
            ],
            'latitude' => [
                'string',
                'nullable',
            ],
            'longitude' => [
                'string',
                'nullable',
            ],
            'images' => [
                'array',
            ],
            'attachments' => [
                'array',
            ],
        ];
    }
}
