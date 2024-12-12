<?php

namespace App\Core\Services\Contact;

interface IContactDeleteService
{
    public function deleteContact(int $id): bool;
}
