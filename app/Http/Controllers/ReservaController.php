<?php

namespace App\Http\Controllers;

// Models (camada Model do MVC)
use App\Models\Reserva;
use App\Models\Hospede;
use App\Models\Quarto;
use App\Models\Funcionario;

use Illuminate\Http\Request;

/* Controller responsável por intermediar a comunicação 
entre as Views, Models e Banco de Dados */
class ReservaController extends Controller
{
    // Exibe a tela de listagem das reservas (View)
    public function index(Request $request)
    {
        // Recebe filtros informados pelo usuário
        $busca  = $request->input('busca');
        $status = $request->input('status');

        // Consulta os dados através do Model
        $reservas = Reserva::with(['hospede', 'quarto', 'funcionario'])
            ->when($busca, function ($query, $busca) {
                $query->whereHas('hospede', fn($q) => $q->where('nome', 'like', "%{$busca}%"))
                    ->orWhereHas('quarto', fn($q) => $q->where('numero', 'like', "%{$busca}%"));
            })
            ->when($status, fn($q) => $q->where('status', $status))
            ->orderBy('data_checkin', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Envia os dados para a View
        return view('reservas.index', compact('reservas', 'busca', 'status'));
    }

    // Carrega a tela de cadastro de reserva
    public function create()
    {
        // Busca dados necessários para os selects da View
        $hospedes     = Hospede::orderBy('nome')->get();
        $quartos      = Quarto::where('status', 'disponivel')->orderBy('numero')->get();
        $funcionarios = Funcionario::orderBy('nome')->get();

        return view('reservas.create', compact('hospedes', 'quartos', 'funcionarios'));
    }

    // Salva uma nova reserva no banco
    public function store(Request $request)
    {
        // Validação dos dados recebidos da View
        $data = $request->validate([
            'hospede_id'     => 'required|exists:hospedes,id',
            'quarto_id'      => 'required|exists:quartos,id',
            'funcionario_id' => 'required|exists:funcionarios,id',
            'data_checkin'   => 'required|date',
            'data_checkout'  => 'required|date|after:data_checkin',
            'status'         => 'required|in:pendente,confirmada,cancelada,finalizada',
            'observacoes'    => 'nullable|string',
        ]);

        // Busca informações do quarto pelo Model
        $quarto = Quarto::findOrFail($data['quarto_id']);

        // Regra de negócio: cálculo do valor da reserva
        $checkin  = \Carbon\Carbon::parse($data['data_checkin']);
        $checkout = \Carbon\Carbon::parse($data['data_checkout']);
        $dias     = $checkin->diffInDays($checkout);

        $data['valor_total'] = $quarto->preco_diaria * $dias;

        // Grava a reserva no banco
        Reserva::create($data);

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva criada com sucesso!');
    }

    // Exibe os detalhes de uma reserva
    public function show(string $id)
    {
        $realId = decrypt($id);

        // Busca a reserva e seus relacionamentos
        $reserva = Reserva::with(['hospede', 'quarto.categoria', 'funcionario'])
            ->findOrFail($realId);

        return view('reservas.show', compact('reserva'));
    }

    // Carrega a tela de edição
    public function edit(string $id)
    {
        $realId = decrypt($id);

        // Busca os dados necessários para a edição
        $reserva      = Reserva::findOrFail($realId);
        $hospedes     = Hospede::orderBy('nome')->get();
        $quartos      = Quarto::orderBy('numero')->get();
        $funcionarios = Funcionario::orderBy('nome')->get();

        return view('reservas.edit', compact(
            'reserva',
            'hospedes',
            'quartos',
            'funcionarios'
        ));
    }

    // Atualiza uma reserva existente
    public function update(Request $request, string $id)
    {
        $realId  = decrypt($id);
        $reserva = Reserva::findOrFail($realId);

        // Valida os dados enviados pela View
        $data = $request->validate([
            'hospede_id'     => 'required|exists:hospedes,id',
            'quarto_id'      => 'required|exists:quartos,id',
            'funcionario_id' => 'required|exists:funcionarios,id',
            'data_checkin'   => 'required|date',
            'data_checkout'  => 'required|date|after:data_checkin',
            'status'         => 'required|in:pendente,confirmada,cancelada,finalizada',
            'observacoes'    => 'nullable|string',
        ]);

        // Recalcula o valor total da reserva
        $quarto = Quarto::findOrFail($data['quarto_id']);

        $checkin  = \Carbon\Carbon::parse($data['data_checkin']);
        $checkout = \Carbon\Carbon::parse($data['data_checkout']);
        $dias     = $checkin->diffInDays($checkout);

        $data['valor_total'] = $quarto->preco_diaria * $dias;

        // Atualiza o registro no banco
        $reserva->update($data);

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva atualizada com sucesso!');
    }

    // Exclui uma reserva
    public function destroy(string $id)
    {
        $realId = decrypt($id);

        // Busca e remove o registro do banco
        $reserva = Reserva::findOrFail($realId);
        $reserva->delete();

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva excluída com sucesso!');
    }
}