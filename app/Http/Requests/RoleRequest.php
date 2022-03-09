<?php

namespace App\Http\Requests;

use App\Role;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class RoleRequest extends FormRequest
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
        {   if ($this->role) {
                if (!$this->checkRole()) {
                    $this->mess = 'Thêm bản ghi lỗi, bản ghi không tồn tại';
                    $validator->errors()->add('exception', 'Bản ghi lời không tồn tại');
                }
            }             
        });
    }

    public function checkRole () {
        $role = Role::find($this->role);

        if (empty($role)) {    
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
        if ($this->role) {
            return [
                'name' => 'required|string:255|unique:roles,name,'.$this->role,
                'level' => 'required|integer|min:0|max:5',
                'ward_id' => 'required|exists:wards,id',
                'description' => 'required|string',
                'is_active' => 'required|integer|min:0|max:1',
            ];
        }

        return [
            'name' => 'required|string:255|unique:roles,name',
            'level' => 'required|integer|min:0|max:5',
            'ward_id' => 'required|exists:wards,id',
            'description' => 'required|string',
            'is_active' => 'required|integer|min:0|max:1',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Yêu cầu không để trống',
            'name.string' => 'Dữ liệu không đúng định dạng',
            'name.unique' => 'Dữ liệu trùng',
            'level.required' => 'Yêu cầu không để trống',
            'level.integer' => 'Dữ liệu ko đúng định dạng',
            'level.min' => 'Dữ liệu ko đúng định dạng',
            'level.max' => 'Dữ liệu ko đúng định dạng',
            'ward_id.required' => 'Yêu cầu không để trống',
            'ward_id.exists' => 'Dữ liệu không tồn tại',
            'description.required' => 'Yêu cầu không để trống',
            'description.string' => 'Dữ liệu ko đúng định dạng',
            'is_active.required' => 'Yêu cầu không để trống',
            'is_active.integer' => 'Dữ liệu ko đúng định dạng',
            'is_active.min' => 'Dữ liệu ko đúng định dạng',
            'is_active.max' => 'Dữ liệu ko đúng định dạng',
        ];
    }
}
