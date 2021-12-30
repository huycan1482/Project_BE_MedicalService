<?php

namespace App\Http\Requests;

use App\Province;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ProvinceRequest extends FormRequest
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
        {   if ($this->province) {
                if (!$this->checkProvince()) {
                    $this->mess = 'Thêm bản ghi lỗi, bản ghi không tồn tại';
                    $validator->errors()->add('exception', 'Bản ghi lời không tồn tại');
                }
            }             
        });
    }

    public function checkProvince () {
        $province = Province::find($this->province);

        if (empty($province)) {    
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
        if ($this->province) {
            return [
                'name' => 'required|string:255|unique:provinces,name,'.$this->province,
                'code' => 'required|string:255|unique:provinces,code,'.$this->province,
            ];
        }

        return [
            'name' => 'required|string:255|unique:provinces,name',
            'code' => 'required|string:255|unique:provinces,code',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Yêu cầu không để trống',
            'name.string' => 'Dữ liệu không đúng định dạng',
            'name.unique' => 'Dữ liệu trùng',
            'code.required' => 'Yêu cầu không để trống',
            'code.string' => 'Dữ liệu không đúng định dạng',
            'code.unique' => 'Dữ liệu trùng',
        ];
    }
}
