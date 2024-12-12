<?php

namespace App\Core\Dtos;

use App\Core\ApplicationModels\IArraySerializer;
use App\Core\Traits\ArraySerializer;
use App\Core\Traits\AutoMapper;

class ContactDto implements IArraySerializer
{
    use ArraySerializer, AutoMapper;

    public int $id;
    public string $nome;
    public string $email;
    public string $telefone;
    public ?string $criadoEm;
    public ?string $atualizadoEm;
    public ?string $deletadoEm;
}
