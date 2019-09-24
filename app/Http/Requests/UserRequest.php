<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                $dateNow = Carbon::today();
                return [
                    'email' => 'required|email|max:255|unique:users,email',
                    'password' => 'required|min:6',
                    'name' => 'required|max:50',
                    'address' => 'required',
                    'phone' => 'required|numeric|digits_between:10,15',
                    'department_id' => 'required|numeric',
                    'avatar' => 'image|max:5120',
                    'birth_day' => 'bail|required|date|before:' . $dateNow,
                ];
            }
            case 'PUT':
            {
                $dateNow = Carbon::today();
                return [
                    'email' => 'email|max:255|unique:users,email,' . $this->input('user_id'),
                    'name' => 'required|max:50',
                    'phone' => 'required|numeric|digits_between:10,15',
                    'department_id' => 'required|numeric',
                    'avatar' => 'image|max:5120',
                    'address' => 'required',
                    'birth_day' => 'bail|required|date|before:' . $dateNow,
                ];
            }
            case 'PATCH':
            {
                return [];
            }
            default:
                break;
        }
    }
}
