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
        // 基本のバリデーションルール
        $rules = [
            'name' => ['required'],
            'price' => ['required', 'numeric', 'between:0,10000'],
            'season' => ['required'],
            'description' => ['required', 'max:120'],
        ];

        // フォームのメソッドに応じて画像フィールドのバリデーションを追加
        if ($this->isMethod('post')) {
            // 新規作成時には画像が必須
            $rules['document'] = ['required', 'mimes:jpeg,png'];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            // 更新時には画像は任意
            $rules['document'] = ['nullable', 'mimes:jpeg,png'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'price.numeric' => '数値で入力してください',
            'price.between' => '0~10000円以内で入力してください',
            'season.required' => '季節を選択してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
            'document.required' => '商品画像を登録してください',
            'document.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
        ];
    }
}
