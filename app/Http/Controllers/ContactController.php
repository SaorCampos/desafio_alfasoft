<?php

namespace App\Http\Controllers;

use App\Support\Models\BaseResponse;
use App\Core\ApplicationModels\Pagination;
use Symfony\Component\HttpFoundation\Response;
use App\Core\Services\Contact\IContactCreateService;
use App\Core\Services\Contact\IContactDeleteService;
use App\Core\Services\Contact\IContactUpdateService;
use App\Http\Requests\Contact\ContactListingRequest;
use App\Core\Services\Contact\IContactListingService;
use App\Http\Requests\Contact\ContactCreateRequest;
use App\Http\Requests\Contact\ContactUpdateRequest;

class ContactController extends Controller
{
    public function __construct(
        private IContactListingService $contactListingService,
        private IContactCreateService $contactCreateService,
        private IContactUpdateService $contactUpdateService,
        private IContactDeleteService $contactDeleteService,
    )
    {}

    public function getAllContacts(ContactListingRequest $request): Response
    {
        $list = $this->contactListingService->getAllContacts(
            request: $request,
            pagination: Pagination::createFromRequest($request)
        );
        return BaseResponse::builder()
            ->setData($list)
            ->setMessage('Contatos Listados com sucesso!')
            ->response();
    }
    public function getContactById(int $id): Response
    {
        $contact = $this->contactListingService->getContactById($id);
        return BaseResponse::builder()
            ->setData($contact)
            ->setMessage('Contato encontrado com sucesso!')
            ->response();
    }
    public function createContact(ContactCreateRequest $request): Response
    {
        $contact = $this->contactCreateService->createContact($request);
        return BaseResponse::builder()
            ->setData($contact)
            ->setMessage('Contato criado com sucesso!')
            ->response();
    }
    public function updateContact(int $id, ContactUpdateRequest $request): Response
    {
        $contact = $this->contactUpdateService->updateContact($id, $request);
        return BaseResponse::builder()
            ->setData($contact)
            ->setMessage('Contato atualizado com sucesso!')
            ->response();
    }
    public function deleteContact(int $id): Response
    {
        $this->contactDeleteService->deleteContact($id);
        return BaseResponse::builder()
            ->setMessage('Contato deletado com sucesso!')
            ->response();
    }
}
