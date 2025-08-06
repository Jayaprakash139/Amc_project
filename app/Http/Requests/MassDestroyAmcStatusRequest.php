<?php

namespace App\Http\Requests;

use App\Models\AmcStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAmcStatusRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('amc_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:amc_statuses,id',
        ];
    }