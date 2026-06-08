<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoriaQuarto extends Model
{
    use HasFactory;

    protected $table = 'categorias_quarto';

    protected $fillable = [
        'nome',
        'descricao',
        'capacidade',
    ];

    // Uma categoria possui muitos quartos.
    public function quartos()
    {
        return $this->hasMany(Quarto::class, 'categoria_id');
    }
}
