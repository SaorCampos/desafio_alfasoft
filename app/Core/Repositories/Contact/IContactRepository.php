<?php

namespace App\Core\Repositories\Contact;

use App\Core\ApplicationModels\PaginatedList;
use App\Core\ApplicationModels\Pagination;
use App\Core\Dtos\ContactDto;
use App\Http\Requests\Contact\ContactListingRequest;
use App\Models\Contact;

interface IContactRepository
{
    public function getAllContacts(ContactListingRequest $request, Pagination $pagination): PaginatedList;
    public function getContactById(int $id): ?ContactDto;
    public function createContact(Contact $contact): Contact;
    public function updateContact(int $id, Contact $contact): bool;
    public function deleteContact(int $id): bool;
}
