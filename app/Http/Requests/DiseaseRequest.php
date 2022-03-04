<?php

namespace App\Http\Requests;

use App\Disease;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class DiseaseRequest extends FormRequest
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
        {   if ($this->disease) {
                if (!$this->checkDisease()) {
                    $this->mess = 'Thêm bản ghi lỗi, bản ghi không tồn tại';
                    $validator->errors()->add('exception', 'Bản ghi lời không tồn tại');
                }
            }             
        });
    }

    public function checkDisease () {
        $disease = Disease::find($this->disease);

        if (empty($disease)) {    
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
        if ($this->disease) {
            return [
                'name' => 'required|string:255|unique:diseases,name,'.$this->disease,
                'description' => 'required|string',
                'is_active' => 'required|integer|min:0|max:1'
            ];
        }

        return [
            'name' => 'required|string:255|unique:diseases,name',
            'description' => 'required|string',
            'is_active' => 'required|integer|min:0|max:1'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Yêu cầu không để trống',
            'name.string' => 'Dữ liệu không đúng định dạng',
            'name.unique' => 'Dữ liệu trùng',
            'description.required' => 'Yêu cầu không để trống',
            'description.string' => 'Dữ liệu không đúng định dạng',
            'is_active.required' => 'Yêu cầu không để trống',
            'is_active.integer' => 'Dữ liệu ko đúng định dạng',
            'is_active.min' => 'Dữ liệu ko đúng định dạng',
            'is_active.max' => 'Dữ liệu ko đúng định dạng',
        ];
    }
}
