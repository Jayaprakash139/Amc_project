<?php

namespace App\Http\Requests;

use App\Models\AmcStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAmcStatusRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('amc_status_edit');
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