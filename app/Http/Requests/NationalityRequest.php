<?php

namespace App\Http\Requests;

use App\Nationality;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class NationalityRequest extends FormRequest
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
        {   if ($this->nationality) {
                if (!$this->checkNationality()) {
                    $this->mess = 'Thêm bản ghi lỗi, bản ghi không tồn tại';
                    $validator->errors()->add('exception', 'Bản ghi lời không tồn tại');
                }
            }             
        });
    }

    public function checkNationality () {
        $nationality = Nationality::find($this->nationality);

        if (empty($nationality)) {    
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
        if ($this->nationality) {
            return [
                'name' => 'required|string:255|unique:nationalities,name,'.$this->nationality,
                'abbreviation' => 'required|string:255|unique:nationalities,abbreviation,'.$this->nationality,
                'is_active' => 'required|integer|min:0|max:1'
            ];
        }

        return [
            'name' => 'required|string:255|unique:nationalities,name',
            'abbreviation' => 'required|string:255|unique:nationalities,abbreviation',
            'is_active' => 'required|integer|min:0|max:1'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Yêu cầu không để trống',
            'name.string' => 'Dữ liệu không đúng định dạng',
            'name.unique' => 'Dữ liệu trùng',
            'abbreviation.required' => 'Yêu cầu không để trống',
            'abbreviation.string' => 'Dữ liệu không đúng định dạng',
            'abbreviation.unique' => 'Dữ liệu trùng',
            'is_active.required' => 'Yêu cầu không để trống',
            'is_active.integer' => 'Dữ liệu ko đúng định dạng',
            'is_active.min' => 'Dữ liệu ko đúng định dạng',
            'is_active.max' => 'Dữ liệu ko đúng định dạng',
        ];
    }
}
