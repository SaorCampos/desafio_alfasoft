<?php

namespace App\Domain\Services\Contact;

use App\Core\ApplicationModels\Pagination;
use App\Core\ApplicationModels\PaginatedList;
use App\Core\Dtos\ContactDto;
use App\Core\Repositories\Contact\IContactRepository;
use App\Core\Services\Contact\IContactListingService;
use App\Http\Requests\Contact\ContactListingRequest;

class ContactListingService implements IContactListingService
{
    public function __construct(
        private IContactRepository $contactRepository,
    )
    {}

    public function getAllContacts(ContactListingRequest $request, Pagination $pagination): PaginatedList
    {
        return $this->contactRepository->getAllContacts($request, $pagination);
    }
    public function getContactById(int $id): ?ContactDto
    {
        return $this->contactRepository->getContactById($id);
    }
}
