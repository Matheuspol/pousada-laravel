<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hospede extends Model
{
    use HasFactory;

    protected $table = 'hospedes';

    protected $fillable = [
        'nome',
        'cpf',
        'email',
        'telefone',
        'cidade',
        'estado',
    ];

    /**
     * Um hóspede pode ter muitas reservas.
     */
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'hospede_id');
    }
}
