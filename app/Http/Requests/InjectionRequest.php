<?php

namespace App\Http\Requests;

use App\Injection;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class InjectionRequest extends FormRequest
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
        {   if ($this->injection) {
                if (!$this->checkInjection()) {
                    $this->mess = 'Thêm bản ghi lỗi, bản ghi không tồn tại';
                    $validator->errors()->add('exception', 'Bản ghi lời không tồn tại');
                }
            }             
        });
    }

    public function checkInjection () {
        $injection = Injection::find($this->injection);

        if (empty($injection)) {    
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
        if ($this->route('injection')) {
            return [
                'pack_id' => 'required|exists:packs,id',
                // 'resident_id' => 'required|exists:residents,id',
                // 'object_id' => 'required|exists:objects,id',
                'priority_id' => 'required|exists:priorities,id',
                'type' => 'nullable|integer|min:0|max:1',
                'dose' => 'required|integer|min:1|max:3',
                'reaction_id' => 'required|integer|min:0|max:1',
                'watcher_id' => 'required|exists:users,id',
                'injector_id' => 'required|exists:users,id',
                'description' => 'nullable|string',
            ];
        }

        return [
            'pack_id' => 'required|exists:packs,id',
            'resident_id' => 'required|exists:residents,id',
            'object_id' => 'nullable|exists:objects,id',
            'priority_id' => 'required|exists:priorities,id',
            'type' => 'nullable|integer|min:0|max:1',
            'dose' => 'required|integer|min:1|max:3',
            'reaction_id' => 'required|integer|min:0|max:1',
            'watcher_id' => 'required|exists:users,id',
            'injector_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'pack_id.required' => 'Yêu cầu không để trống',
            'pack_id.exists' => 'Dữ liệu không tồn tại',
            'resident_id.required' => 'Yêu cầu không để trống',
            'resident_id.exists' => 'Dữ liệu không tồn tại',
            'object_id.required' => 'Yêu cầu không để trống',
            'object_id.exists' => 'Dữ liệu không tồn tại',
            'priority_id.required' => 'Yêu cầu không để trống',
            'priority_id.exists' => 'Dữ liệu không tồn tại',
            'type.integer' => 'Dữ liệu ko đúng định dạng',
            'type.min' => 'Dữ liệu ko đúng định dạng',
            'type.max' => 'Dữ liệu ko đúng định dạng',
            'dose.required' => 'Yêu cầu không để trống',
            'dose.integer' => 'Dữ liệu ko đúng định dạng',
            'dose.min' => 'Dữ liệu ko đúng định dạng',
            'dose.max' => 'Dữ liệu ko đúng định dạng',
            'dose.required' => 'Yêu cầu không để trống',
            'dose.integer' => 'Dữ liệu ko đúng định dạng',
            'dose.min' => 'Dữ liệu ko đúng định dạng',
            'dose.max' => 'Dữ liệu ko đúng định dạng',
            'reaction_id.required' => 'Yêu cầu không để trống',
            'reaction_id.exists' => 'Dữ liệu không tồn tại',
            'injector_id.required' => 'Yêu cầu không để trống',
            'injector_id.exists' => 'Dữ liệu không tồn tại',
            'description.string' => 'Dữ liệu ko đúng định dạng',
        ];
    }
}
