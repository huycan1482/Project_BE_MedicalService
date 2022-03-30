<?php

namespace App\Http\Requests;

use App\Session;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class SessionRequest extends FormRequest
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
        {   
            if ($this->route('session')) {
                if (!$this->checkExit()) {
                    $this->mess = 'Thêm bản ghi lỗi, bản ghi không tồn tại';
                    $validator->errors()->add('exception', 'Bản ghi lời không tồn tại');
                }
            }             
        });
    }

    public function checkExit () {
        $session = Session::find($this->route('session'));

        if (empty($session)) {    
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
        // dd($this->route('session'));
        return [
            'start_at' => 'required|date_format:"Y-m-d"',
            'end_at' => 'required|after:start_at|date_format:"Y-m-d"',
            'address' => 'required|string:255',
            // 'quantity' => 'required|integer',
            // 'actual_quantity' => 'required|integer|lte:quantity',
            'status_id' => 'required|integer|min:0|max:2'
        ];
    }

    public function messages()
    {
        return [
            'start_at.required' => 'Yêu cầu không để trống',
            'start_at.date_format' => 'Dữ liệu không đúng định dạng',
            'end_at.required' => 'Yêu cầu không để trống',
            'end_at.date_format' => 'Dữ liệu không đúng định dạng',
            'end_at.after' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu',
            'address.required' => 'Yêu cầu không để trống',
            'address.string' => 'Dữ liệu không đúng định dạng',
            'abbreviation.unique' => 'Dữ liệu trùng',
            // 'quantity.required' => 'Yêu cầu không để trống',
            // 'quantity.integer' => 'Dữ liệu ko đúng định dạng',
            // 'actual_quantity.required' => 'Yêu cầu không để trống',
            // 'actual_quantity.integer' => 'Dữ liệu ko đúng định dạng',
            // 'actual_quantity.lte' => 'Số lượng thực tế phải ít hơn hoặc bằng số lượng dự kiến',
            'status_id.required' => 'Yêu cầu không để trống',
            'status_id.integer' => 'Dữ liệu ko đúng định dạng',
            'status_id.min' => 'Dữ liệu ko đúng định dạng',
            'status_id.max' => 'Dữ liệu ko đúng định dạng',
        ];
    }
}
