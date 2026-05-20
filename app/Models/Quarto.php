<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quarto extends Model
{
    use HasFactory;

    protected $table = 'quartos';

    protected $fillable = [
        'numero',
        'categoria_id',
        'preco_diaria',
        'status',
        'descricao',
    ];

    /**
     * Um quarto pertence a uma categoria.
     */
    public function categoria()
    {
        return $this->belongsTo(CategoriaQuarto::class, 'categoria_id');
    }

    /**
     * Um quarto pode ter muitas reservas.
     */
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'quarto_id');
    }

    /**
     * Rótulos legíveis para os status.
     */
    public static function statusLabel(string $status): string
    {
        return match ($status) {
            'disponivel'  => 'Disponível',
            'ocupado'     => 'Ocupado',
            'manutencao'  => 'Em Manutenção',
            default       => $status,
        };
    }
}
