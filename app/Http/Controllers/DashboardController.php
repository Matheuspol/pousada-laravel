<?php

namespace App\Http\Controllers;

use App\Models\CategoriaQuarto;
use App\Models\Hospede;
use App\Models\Funcionario;
use App\Models\Quarto;
use App\Models\Reserva;

class DashboardController extends Controller
{
    /**
     * Exibe o dashboard com resumo das entidades.
     */
    public function index()
    {
        $totais = [
            'categorias'   => CategoriaQuarto::count(),
            'hospedes'     => Hospede::count(),
            'funcionarios' => Funcionario::count(),
            'quartos'      => Quarto::count(),
            'reservas'     => Reserva::count(),
        ];

        $reservasRecentes = Reserva::with(['hospede', 'quarto'])
            ->latest()
            ->take(5)
            ->get();

        $quartosDisponiveis = Quarto::where('status', 'disponivel')->count();

        return view('dashboard.index', compact('totais', 'reservasRecentes', 'quartosDisponiveis'));
    }
}
