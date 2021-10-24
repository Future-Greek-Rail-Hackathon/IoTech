<?php

namespace App\Http\Requests;

use App\Models\MaintenanceEventType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreMaintenanceEventTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('maintenance_event_type_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
        ];
    }
}
