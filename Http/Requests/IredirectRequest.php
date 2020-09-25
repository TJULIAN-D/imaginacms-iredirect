<?php

namespace Modules\Iredirect\Http\Requests;

use App\Http\Requests\Request;

class IredirectRequest extends \Modules\Bcrud\Http\Requests\CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'from' => 'required|min:2',
            'to' => 'required|min:2',

        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'from.required' => trans('iredirect::common.messages.from is required'),
            'from.min:2'=> trans('iredirect::common.messages.from min 2 '),
            'to.required'=> trans('iredirect::common.messages.to is required'),
            'to.min:2'=> trans('iredirect::common.messages.to min 2 '),
        ];
    }
}