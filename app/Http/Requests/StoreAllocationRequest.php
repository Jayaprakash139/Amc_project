<?php

namespace App\Http\Requests;

use App\Models\Allocation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAllocationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('allocation_create');
    }

    public function rules()
    {
        return [
            'school_id' => [
               
                'integer',
            ],
            'sublocation_id' => [
                'required',
                'integer',
            ],
            'asset_name' => [
                'string',
                'required',
            ],
            'asset_code' => [
                'string',
                'required',
            ],
            'value' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'status_id' => [
                'required',
                'integer',
            ],
            'custody_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
