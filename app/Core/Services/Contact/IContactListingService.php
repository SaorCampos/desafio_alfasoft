<?php

namespace App\Core\Services\Contact;

use App\Core\Dtos\ContactDto;
use App\Core\ApplicationModels\Pagination;
use App\Core\ApplicationModels\PaginatedList;
use App\Http\Requests\Contact\ContactListingRequest;

interface IContactListingService
{
    public function getAllContacts(ContactListingRequest $request, Pagination $pagination): PaginatedList;
    public function getContactById(int $id): ?ContactDto;
}
