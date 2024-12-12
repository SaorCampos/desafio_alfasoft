<?php

namespace App\Data\Repositories\Contact;

use App\Core\ApplicationModels\Pagination;
use App\Core\ApplicationModels\PaginatedList;
use App\Core\Dtos\ContactDto;
use App\Core\Repositories\Contact\IContactRepository;
use App\Http\Requests\Contact\ContactListingRequest;
use App\Models\Contact;

class ContactRepository implements IContactRepository
{
    public function getAllContacts(ContactListingRequest $request, Pagination $pagination): PaginatedList
    {
        $query = Contact::query()
            ->from('contacts as c')
            ->select([
                'c.id',
                'c.nome',
                'c.email',
                'c.telefone',
                'c.criado_em',
                'c.atualizado_em',
                'c.deletado_em',
            ])
            ->withTrashed();

        $filters = $this->getFilters($request);
        foreach ($filters as $filter) {
            $query->whereRaw($filter[0] . " COLLATE utf8mb4_general_ci LIKE ?", [$filter[1]]);
        }

        $paginatedQuery = $query->paginate(
            $pagination->perPage,
            ['*'],
            'page',
            $pagination->page
        );

        return PaginatedList::fromPaginatedQuery(
            query: $paginatedQuery,
            pagination: $pagination,
            dtoClass: ContactDto::class
        );
    }
    private function getFilters(ContactListingRequest $request): array
    {
        $filters = [];
        if (!is_null($request->nome)) {
            $filters[] = ['c.nome', '%' . strtolower($request->nome) . '%'];
        }
        if (!is_null($request->email)) {
            $filters[] = ['c.email', '%' . strtolower($request->email) . '%'];
        }
        if (!is_null($request->telefone)) {
            $filters[] = ['c.telefone', '%' . strtolower($request->telefone) . '%'];
        }
        return $filters;
    }
    public function getContactById(int $id): ?ContactDto
    {
        $query = Contact::query()
            ->from('contacts as c')
            ->select([
                'c.id',
                'c.nome',
                'c.email',
                'c.telefone',
                'c.criado_em',
                'c.atualizado_em',
                'c.deletado_em',
            ])
            ->withTrashed()
            ->where('c.id', '=', $id)->first();
        if (is_null($query)) {
            return null;
        }
        return $query->mapTo(ContactDto::class);
    }
    public function createContact(Contact $contact): Contact
    {
        return Contact::query()->create($contact->toArray());
    }
    public function updateContact(int $id, Contact $contact): bool
    {
        $contactData = $contact->toArray();
        $contactData['criado_em'] = optional($contact->criado_em)->format('Y-m-d H:i:s');
        $contactData['atualizado_em'] = optional($contact->atualizado_em)->format('Y-m-d H:i:s');
        $contactData['deletado_em'] = optional($contact->deletado_em)->format('Y-m-d H:i:s');
        return Contact::query()->where('id', '=', $id)->update($contactData);
    }
    public function deleteContact(int $id): bool
    {
        return Contact::query()->where('id', '=', $id)->delete();
    }
}
