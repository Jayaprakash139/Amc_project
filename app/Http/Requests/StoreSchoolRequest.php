<?php

namespace App\Http\Requests;

use App\Models\School;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSchoolRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('school_create');
    }

    public function rules()
    {
        return [
           
            'name' => [
                'string',
                'required',
            ],
            'email' => [
                'required',
            ],
            'address' => [
                'required',
            ],
            'mobile_number' => [
                'string',
                'required',
            ],
        ];
    }
}
