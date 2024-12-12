<?php

namespace App\Domain\Services\Contact;

use App\Core\Dtos\ContactDto;
use App\Http\Requests\Contact\ContactUpdateRequest;
use App\Core\Services\Contact\IContactUpdateService;
use App\Core\Repositories\Contact\IContactRepository;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;

class ContactUpdateService implements IContactUpdateService
{
    public function __construct(
        private IContactRepository $contactRepository,
    )
    {}

    public function updateContact(int $id, ContactUpdateRequest $request): ContactDto
    {
        $contactForUpdate = $this->contactRepository->getContactById($id);
        if(!$contactForUpdate) {
            throw new HttpResponseException(response()->json(['message' => 'Contato não encotrado.'], 404));
        }
        $contact = $this->mapContactUpdateRequest($request);
        $bool = $this->contactRepository->updateContact($id, $contact);
        if(!$bool) {
            throw new HttpResponseException(response()->json(['message' => 'Erro ao atualizar contato.'], 500));
        }
        return $this->contactRepository->getContactById($id);
    }
    private function mapContactUpdateRequest(ContactUpdateRequest $request): Contact
    {
        $contact = new Contact();
        $contact->nome = $request->nome;
        $contact->telefone = $request->telefone;
        $contact->email = $request->email;
        $contact->atualizado_em = Carbon::now()->format('Y-m-d H:i:s');
        return $contact;
    }
}
