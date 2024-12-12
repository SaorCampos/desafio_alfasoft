<?php

namespace App\Core\Services\Contact;

use App\Core\Dtos\ContactDto;
use App\Http\Requests\Contact\ContactCreateRequest;

interface IContactCreateService
{
    public function createContact(ContactCreateRequest $request): ContactDto;
}
