<?php

namespace App\Http\Requests\Contact;

use App\Http\Requests\BaseRequest;
/**
 * @property string $nome
 * @property string $telefone
 * @property string $email
 */
class ContactUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "nome" => "string|min:5",
            "telefone" => [
                "regex:/^\(\d{2}\)\s\d{5}-\d{4}$/",
            ],
            "email" => "email|unique:contacts,email",
        ];
    }

    public function messages(): array
    {
        return [
            "telefone.regex" => "O campo telefone deve estar no formato (99) 99999-9999.",
        ];
    }
}
