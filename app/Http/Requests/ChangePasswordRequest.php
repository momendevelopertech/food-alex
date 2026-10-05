<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
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
    public function rules()
    {
        return [
            'old_password'          => ['required', 'string', 'min:6'],
            'password'              => ['required', 'string', 'min:6'],
            'password_confirmation' => ['required', 'string', 'min:6'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->checkOldPassword()) {
                $validator->errors()->add('old_password', strtolower(trans('all.message.old_password')));
            }
            if ($this->password !== $this->password_confirmation) {
                $validator->errors()->add('password_confirmation', strtolower(trans('all.message.password_confirmation')));
            }
        });
    }

    public function checkOldPassword()
    {
        $old_password = request('old_password');
        return Hash::check($old_password, auth()->user()->password);
    }
}
