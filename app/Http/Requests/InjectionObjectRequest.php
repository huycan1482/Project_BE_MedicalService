<?php

namespace App\Http\Requests;

use App\InjectionObject;
use App\Nationality;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class InjectionObjectRequest extends FormRequest
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
        {   if ($this->route('object')) {
                if (!$this->checkObject()) {
                    $this->mess = 'Thêm bản ghi lỗi, bản ghi không tồn tại';
                    $validator->errors()->add('exception', 'Bản ghi lời không tồn tại');
                }
            }             
        });
    }

    public function checkObject () {
        $object = InjectionObject::find($this->route('object'));

        if (empty($object)) {    
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
        // if ($this->route('object')) {
        //     return [
        //         'name' => 'required|string:255|unique:nationalities,name,'.$this->nationality,
        //         'abbreviation' => 'required|string:255|unique:nationalities,abbreviation,'.$this->nationality,
        //         'is_active' => 'required|integer|min:0|max:1'
        //     ];
        // }

        return [
            'resident_id' => 'required|exists:residents,id',
            'session_id' => 'required|exists:sessions,id',
        ];
    }

    public function messages()
    {
        return [
            'resident_id.required' => 'Yêu cầu không để trống',
            'resident_id.exists' => 'Dữ liệu không tồn tại',
            'session_id.required' => 'Yêu cầu không để trống',
            'session_id.exists' => 'Dữ liệu không tồn tại',
        ];
    }
}
