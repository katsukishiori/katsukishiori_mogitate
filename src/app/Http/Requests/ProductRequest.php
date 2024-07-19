<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'price' => ['required', 'string', 'between:0,10000',],
            'season' => ['required', 'array'],
            'season.*' => 'in:春,夏,秋,冬',
            'description' => ['required'],
            'document' => ['required', 'mimes:jpeg,png',],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'price.string' => '数値で入力してください',
            'price.between' => '0~10000円以内で入力してください',
            'season.required' => '季節を選択してください',
            'season.array' => '季節は配列形式で送信される必要があります',
            'season.*.in' => '季節は春、夏、秋、冬のいずれかである必要があります',
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
            'document.required' => '商品画像を登録してください',
            'document.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
        ];
    }
}
