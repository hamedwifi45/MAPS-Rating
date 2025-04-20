<?php

namespace App\Http\Requests;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Http\FormRequest;

class ReviewFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $this->redirect = url()->previous() . '#review-div';
        return [
            'review' => 'required|min:5'
        ];
    }

    public function messages()
    {
        return ['review.required'=> 'يزلمي اكتبلك شي شغلة معقول مابتعرف تكتب' , 
                'review.min'=>'يزلمي معندك غير هالكلمة البسيطة اكتب شي واقعي'] ;
    }

    public function failedAuthorization(){
        throw new AuthenticationException('لا تمتلك صلاحية لتسجيل مراجعة فضلا سجل دخول للموقع');
    }
}
