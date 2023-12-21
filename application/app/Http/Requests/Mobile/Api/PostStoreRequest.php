<?php

namespace App\Http\Requests\Mobile\Api;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'=>[
                'string',
                'required',
            ],
            'description'=>[
                'required',
                'string',
            ],
        ];
    }

    public function messages()
    {
        return [
            "title.required"=>"Введите название тему",
            "title.size"=>"Размер поста превышает 255 символов",
            "title.string"=>"Тема должна содержать только строковые значения",
        ];
    }
}
