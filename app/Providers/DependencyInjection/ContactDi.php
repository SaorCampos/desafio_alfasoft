<?php

namespace App\Providers\DependencyInjection;

use App\Core\Repositories\Contact\IContactRepository;
use App\Core\Services\Contact\IContactCreateService;
use App\Core\Services\Contact\IContactDeleteService;
use App\Core\Services\Contact\IContactListingService;
use App\Core\Services\Contact\IContactUpdateService;
use App\Data\Repositories\Contact\ContactRepository;
use App\Domain\Services\Contact\ContactCreateService;
use App\Domain\Services\Contact\ContactDeleteService;
use App\Domain\Services\Contact\ContactListingService;
use App\Domain\Services\Contact\ContactUpdateService;

class ContactDi extends DependencyInjection
{
    protected function servicesConfiguration(): array
    {
        return [
            [IContactListingService::class, ContactListingService::class],
            [IContactCreateService::class, ContactCreateService::class],
            [IContactUpdateService::class, ContactUpdateService::class],
            [IContactDeleteService::class, ContactDeleteService::class],
        ];
    }

    protected function repositoriesConfigurations(): array
    {
        return [
            [IContactRepository::class, ContactRepository::class]
        ];
    }
}
