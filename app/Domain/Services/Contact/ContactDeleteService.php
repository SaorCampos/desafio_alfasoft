<?php

namespace App\Domain\Services\Contact;

use App\Core\Services\Contact\IContactDeleteService;
use App\Core\Repositories\Contact\IContactRepository;
use Illuminate\Http\Exceptions\HttpResponseException;

class ContactDeleteService implements IContactDeleteService
{
    public function __construct(
        private IContactRepository $contactRepository,
    )
    {}

    public function deleteContact(int $id): bool
    {
        if (!$this->contactRepository->getContactById($id)) {
            throw new HttpResponseException(response()->json(['message' => 'Contato não encotrado.'], 404));
        }
        return $this->contactRepository->deleteContact($id);
    }
}
