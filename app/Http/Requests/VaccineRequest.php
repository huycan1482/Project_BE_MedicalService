<?php

namespace App\Http\Requests;

use App\vaccine;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class VaccineRequest extends FormRequest
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
        {   if ($this->vaccine) {
                if (!$this->checkVaccine()) {
                    $this->mess = 'Thêm bản ghi lỗi, bản ghi không tồn tại';
                    $validator->errors()->add('exception', 'Bản ghi lời không tồn tại');
                }
            }             
        });
    }

    public function checkVaccine () {
        $vaccine = Vaccine::find($this->vaccine);

        if (empty($vaccine)) {    
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
        // dd($this->all());
        if ($this->vaccine) {
            return [
                'name' => 'required|string:255|unique:vaccines,name,'.$this->vaccine,
                'description' => 'required|string',
                'producer_id' => 'required|array',
                'disease_id' => 'required|array',
                'producer_id.*' => 'required|exists:producers,id',
                'disease_id.*' => 'required|exists:diseases,id',
                'is_active' => 'required|integer|min:0|max:1',
            ];
        }

        return [
            'name' => 'required|string:255|unique:vaccines,name',
            'description' => 'required|string',
            'producer_id' => 'required|array',
            'disease_id' => 'required|array',
            'producer_id.*' => 'required|exists:producers,id',
            'disease_id.*' => 'required|exists:diseases,id',
            'is_active' => 'required|integer|min:0|max:1'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Yêu cầu không để trống',
            'name.string' => 'Dữ liệu không đúng định dạng',
            'name.unique' => 'Dữ liệu trùng',
            'producer_id.required' => 'Yêu cầu không để trống',
            'disease_id.required' => 'Yêu cầu không để trống',
            'producer_id.array' => 'Sai kiểu dữ liệu',
            'disease_id.array' => 'Sai kiểu dữ liệU',
            'description.required' => 'Yêu cầu không để trống',
            'description.string' => 'Dữ liệu không đúng định dạng',
            'producer_id.*.required' => 'Yêu cầu không để trống',
            'producer_id.*.exists' => 'Dữ liệu không tồn tại',
            'disease_id.*.required' => 'Yêu cầu không để trống',
            'disease_id.*.exists' => 'Dữ liệu không tồn tại',
            'is_active.required' => 'Yêu cầu không để trống',
            'is_active.integer' => 'Dữ liệu ko đúng định dạng',
            'is_active.min' => 'Dữ liệu ko đúng định dạng',
            'is_active.max' => 'Dữ liệu ko đúng định dạng',
        ];
    }
}
