<?php

namespace App\Http\Requests\Contact;

use App\Http\Requests\BaseRequest;
/**
 * @property string $nome
 * @property string $telefone
 * @property string $email
 */
class ContactListingRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "nome" => "string",
            "telefone" => "string",
            "email" => "string",
        ];
    }
}
