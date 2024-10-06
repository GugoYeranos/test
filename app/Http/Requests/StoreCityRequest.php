<?php

namespace App\Http\Requests;

use App\Http\Services\RussianToEnglishTransliterator;
use Illuminate\Foundation\Http\FormRequest;

class StoreCityRequest extends FormRequest
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
            'name' => 'required|string|max:255'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле "Город" обязательно для заполнения.',
            'name.string' => 'Поле "Город" должно быть строкой.',
            'name.alpha' => 'Поле "Имя" должно содержать только буквы.',
            'name.max' => 'Поле "Город" не должно превышать :max символов.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'hh_id' => 0,
            'slug' =>  app(RussianToEnglishTransliterator::class)->transliterate($this->name),
        ]);
    }
}
