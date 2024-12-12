<?php

namespace App\Core\Services\Contact;

use App\Core\Dtos\ContactDto;
use App\Http\Requests\Contact\ContactUpdateRequest;

interface IContactUpdateService
{
    public function updateContact(int $id, ContactUpdateRequest $request): ContactDto;
}
