<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class UserRequest extends FormRequest
{
    protected $mess = 'Thêm bản ghi lỗi';

    protected function failedValidation(Validator $validator) 
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(
            [
                'ok' => '0',
                'errors' => $errors,
                'status_code' => 422,
                'mess' => $this->mess,
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }

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
    * @param  \Illuminate\Validation\Validator  $validator
    * @return void
    */
    public function withValidator (Validator $validator)
    {
        $validator->after(function($validator)
        {   if ($this->user) {
                if (!$this->checkUser()) {
                    $this->mess = 'Thêm bản ghi lỗi, bản ghi không tồn tại';
                    $validator->errors()->add('exception', 'Bản ghi lời không tồn tại');
                }
            }             
        });
    }

    public function checkUser () {
        $user = User::find($this->user);

        if (empty($user)) {    
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // dd($this->all(), $this);
        if ($this->user) {
            return [
                'name' => 'required|string:255',
                'date_of_birth' => 'required|date_format:"Y-m-d"',
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'identity_card' => 'required|string:255|max:12|unique:users,identity_card,'.$this->user,
                'address' => 'required|string:255',
                'gender' => 'required|integer|min:0|max:1',
                'ward_id' => 'required|exists:wards,id',
                'address' => 'required|string:255',
                'description' => 'nullable|string',
                'email' => 'required|email|unique:users,email,'.$this->user,
                'password' => 'nullable|string:255',
                'role_id' => 'required|exists:roles,id',
                'is_active' => 'required|integer|min:0|max:1'
            ];
        }

        return [
            'name' => 'required|string:255',
            'date_of_birth' => 'required|date_format:"Y-m-d"',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'identity_card' => 'required|string:255|unique:users,identity_card|max:12',
            'address' => 'required|string:255',
            'gender' => 'required|integer|min:0|max:1',
            'ward_id' => 'required|exists:wards,id',
            'address' => 'required|string:255',
            'description' => 'nullable|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string:255',
            'role_id' => 'required|exists:roles,id',
            'is_active' => 'required|integer|min:0|max:1'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Yêu cầu không để trống',
            'name.string' => 'Dữ liệu không đúng định dạng',
            'date_of_birth.required' => 'Yêu cầu không để trống',
            'date_of_birth.date_format' => 'Dữ liệu ko đúng định dạng',
            'phone.required' => 'Yêu cầu không để trống',
            'phone.regex' => 'Dữ liệu không đúng định dạng',
            'phone.min' => 'Dữ liệu ko đúng định dạng',
            'identity_card.required' => 'Yêu cầu không để trống',
            'identity_card.string' => 'Dữ liệu không đúng định dạng',
            'identity_card.unique' => 'Dữ liệu trùng',
            'identity_card.max' => 'CCCD/Mã định danh có độ dài từ 12 số trở xuống',
            'address.required' => 'Yêu cầu không để trống',
            'address.string' => 'Dữ liệu không đúng định dạng',
            'gender.required' => 'Yêu cầu không để trống',
            'gender.integer' => 'Dữ liệu ko đúng định dạng',
            'gender.min' => 'Dữ liệu ko đúng định dạng',
            'gender.max' => 'Dữ liệu ko đúng định dạng',
            'ward_id.required' => 'Yêu cầu không để trống',
            'ward_id.exists' => 'Dữ liệu không tồn tại',
            'description.string' => 'Dữ liệu không đúng định dạng',
            'email.required' => 'Yêu cầu không để trống',
            'email.unique' => 'Dữ liệu trùng',
            'email.email' => 'Dữ liệu ko đúng định dạng',
            'password.required' => 'Yêu cầu không để trống',
            'password.string' => 'Dữ liệu không đúng định dạng',
            'role_id.required' => 'Yêu cầu không để trống',
            'role_id.exists' => 'Dữ liệu không tồn tại',
            'is_active.required' => 'Yêu cầu không để trống',
            'is_active.integer' => 'Dữ liệu ko đúng định dạng',
            'is_active.min' => 'Dữ liệu ko đúng định dạng',
            'is_active.max' => 'Dữ liệu ko đúng định dạng',
        ];
    }
}
