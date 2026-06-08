<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Funcionario extends Model
{
    use HasFactory;

    protected $table = 'funcionarios';

    protected $fillable = [
        'nome',
        'cpf',
        'cargo',
        'email',
        'telefone',
    ];

    // Um funcionário pode ter registrado muitas reservas.
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'funcionario_id');
    }
}
