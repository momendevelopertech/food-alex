<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KioskMachineRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'machine_id' => ['required', 'string', 'max:190', Rule::unique("kiosk_machines", "machine_id")->ignore($this->route('kioskMachine.id'))],
            'branch_id'  => ['required', 'numeric', 'max:24'],
            'user_id'    => ['required', 'numeric', 'max:24'],
            'username'   => ['required', 'string', 'max:190', Rule::unique("kiosk_machines", "username")->ignore($this->route('kioskMachine.id'))],
            'password'              => [
                $this->route('kioskMachine.id') ? 'nullable' : 'required',
                'string',
                'min:6'
            ],
            'status'     => ['required', 'numeric', 'max:24'],
        ];
    }

    public function messages(): array
    {
        return [
            'machine_id.required' => trans('all.message.machine_id_required'),
            'branch_id.required'  => trans('all.message.branch_id_required'),
            'user_id.required'    => trans('all.message.user_id_required')
        ];
    }
}