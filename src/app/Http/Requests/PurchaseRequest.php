<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'payment_method' =>'required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = Auth::user();

            if (!$user || !$user->postcode || !$user->address) {
                $validator->errors()->add('user_id', '配送先住所を登録してください');
            }
        });
    }

    public function messages()
    {
        return [
            'payment_method.required' => '支払い方法を選択してください',
        ];
    }

    public function getRedirectUrl()
    {
        $id = $this->route('id') ?? $this->input('item_id');

        return route('item.purchase', ['id' => $id]);
    }
}
