<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Entity
{
    use HasFactory, SoftDeletes;
    protected $table = 'contacts';

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'criado_em',
        'atualizado_em',
        'deletado_em',
    ];
}
