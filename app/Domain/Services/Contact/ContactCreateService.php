<?php

namespace App\Domain\Services\Contact;

use App\Core\Dtos\ContactDto;
use App\Core\Repositories\Contact\IContactRepository;
use App\Core\Services\Contact\IContactCreateService;
use App\Http\Requests\Contact\ContactCreateRequest;
use App\Models\Contact;

class ContactCreateService implements IContactCreateService
{
    public function __construct(
        private IContactRepository $contactRepository
    )
    {}

    public function createContact(ContactCreateRequest $request): ContactDto
    {
        $contactForCreate = $this->mapContactFromRequest($request);
        $contactCreated = $this->contactRepository->createContact($contactForCreate);
        return $this->contactRepository->getContactById($contactCreated->id);
    }
    private function mapContactFromRequest(ContactCreateRequest $request): Contact
    {
        $contact = new Contact();
        $contact->nome = $request->nome;
        $contact->telefone = $request->telefone;
        $contact->email = $request->email;
        return $contact;
    }
}
