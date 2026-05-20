<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';

    protected $fillable = [
        'hospede_id',
        'quarto_id',
        'funcionario_id',
        'data_checkin',
        'data_checkout',
        'valor_total',
        'status',
        'observacoes',
    ];

    protected $casts = [
        'data_checkin'  => 'date',
        'data_checkout' => 'date',
    ];

    public function hospede()
    {
        return $this->belongsTo(Hospede::class, 'hospede_id');
    }

    public function quarto()
    {
        return $this->belongsTo(Quarto::class, 'quarto_id');
    }

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'funcionario_id');
    }

    public static function statusLabel(string $status): string
    {
        return match ($status) {
            'pendente'   => 'Pendente',
            'confirmada' => 'Confirmada',
            'cancelada'  => 'Cancelada',
            'finalizada' => 'Finalizada',
            default      => $status,
        };
    }
}
