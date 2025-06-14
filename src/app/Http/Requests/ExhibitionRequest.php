<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'image_path' => 'required|mimes:png,jpeg',
            'categories' => 'required',
            'status_id' => 'required',
            'name' => 'required',
            'description' => 'required|max:255',
            'price' => 'required|integer|min:0'

        ];
    }

    public function messages()
    {
        return [
            'image_path.required' => '商品画像を選択してください',
            'image_path.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'categories.required' => '商品のカテゴリーを選択してください',
            'status_id.required' => '商品の状態を選択してください',
            'name.required' => '商品名を入力してください',
            'description.required' => '商品の説明を入力してください',
            'description.max' => '商品の説明を255文字以内で入力してください',
            'price.required' => '販売価格を入力してください',
            'price.integer' => '販売価格を数値型で入力してください',
            'price.min' => '販売価格を0円以上で入力してください'
        ];
    }
}
