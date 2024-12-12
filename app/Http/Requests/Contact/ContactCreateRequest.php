<?php

namespace App\Http\Requests\Contact;

use App\Http\Requests\BaseRequest;
/**
 * @property string $nome
 * @property string $telefone
 * @property string $email
 */
class ContactCreateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "nome" => "string|required|min:5",
            "telefone" => [
                "required",
                "regex:/^\(\d{2}\)\s\d{5}-\d{4}$/",
            ],
            "email" => "email|required|unique:contacts,email",
        ];
    }

    public function messages(): array
    {
        return [
            "telefone.required" => "O campo telefone é obrigatório.",
            "telefone.regex" => "O campo telefone deve estar no formato (99) 99999-9999.",
        ];
    }
}
