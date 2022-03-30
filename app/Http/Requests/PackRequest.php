<?php

namespace App\Http\Requests;

use App\Pack;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class PackRequest extends FormRequest
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
        {   if ($this->route('pack')) {
                if (!$this->checkPack()) {
                    $this->mess = 'Thêm bản ghi lỗi, bản ghi không tồn tại';
                    $validator->errors()->add('exception', 'Bản ghi lời không tồn tại');
                }
            }             
        });
    }

    public function checkPack () {
        $pack = Pack::find($this->route('pack'));

        if (empty($pack)) {    
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
        if ($this->route('pack')) {
            return [
                'name' => 'required|string:255|unique:packs,name,'.$this->route('pack'),
                'expired' => 'required|after:today|date_format:"Y-m-d"',
                'vaccine_id' => 'required|exists:vaccines,id',
                'producer_id' => 'required|exists:producers,id',
                'is_active' => 'required|integer|min:0|max:1'
            ];
        }

        return [
            'name' => 'required|string:255|unique:packs,name',
            'expired' => 'required|after:today|date_format:"Y-m-d"',
            'producer_id' => 'required|exists:producers,id',
            'vaccine_id' => 'required|exists:vaccines,id',
            'is_active' => 'required|integer|min:0|max:1'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Yêu cầu không để trống',
            'name.string' => 'Dữ liệu không đúng định dạng',
            'name.unique' => 'Dữ liệu trùng',
            'expired.required' => 'Yêu cầu không để trống',
            'expired.after' => 'Yêu cầu ngày hết hạn sau ngày hôm nay',
            'expired.date_format' => 'Sai định dạng',
            'vaccine_id.required' => 'Yêu cầu không để trống',
            'vaccine_id.required' => 'Dữ liệu không tồn tại',
            'producer_id.required' => 'Yêu cầu không để trống',
            'producer_id.required' => 'Dữ liệu không tồn tại',
            'is_active.required' => 'Yêu cầu không để trống',
            'is_active.integer' => 'Dữ liệu ko đúng định dạng',
            'is_active.min' => 'Dữ liệu ko đúng định dạng',
            'is_active.max' => 'Dữ liệu ko đúng định dạng',
        ];
    }
}
