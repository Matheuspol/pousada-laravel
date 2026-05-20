<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Hospede;
use App\Models\Quarto;
use App\Models\Funcionario;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index(Request $request)
    {
        $busca  = $request->input('busca');
        $status = $request->input('status');

        $reservas = Reserva::with(['hospede', 'quarto', 'funcionario'])
            ->when($busca, function ($query, $busca) {
                $query->whereHas('hospede', fn($q) => $q->where('nome', 'like', "%{$busca}%"))
                      ->orWhereHas('quarto', fn($q) => $q->where('numero', 'like', "%{$busca}%"));
            })
            ->when($status, fn($q) => $q->where('status', $status))
            ->orderBy('data_checkin', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('reservas.index', compact('reservas', 'busca', 'status'));
    }

    public function create()
    {
        $hospedes     = Hospede::orderBy('nome')->get();
        $quartos      = Quarto::where('status', 'disponivel')->orderBy('numero')->get();
        $funcionarios = Funcionario::orderBy('nome')->get();
        return view('reservas.create', compact('hospedes', 'quartos', 'funcionarios'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'hospede_id'     => 'required|exists:hospedes,id',
            'quarto_id'      => 'required|exists:quartos,id',
            'funcionario_id' => 'required|exists:funcionarios,id',
            'data_checkin'   => 'required|date',
            'data_checkout'  => 'required|date|after:data_checkin',
            'status'         => 'required|in:pendente,confirmada,cancelada,finalizada',
            'observacoes'    => 'nullable|string',
        ], [
            'hospede_id.required'     => 'Selecione um hóspede.',
            'quarto_id.required'      => 'Selecione um quarto.',
            'funcionario_id.required' => 'Selecione um funcionário.',
            'data_checkin.required'   => 'A data de check-in é obrigatória.',
            'data_checkout.required'  => 'A data de check-out é obrigatória.',
            'data_checkout.after'     => 'O check-out deve ser após o check-in.',
        ]);

        // Calcula valor total automaticamente
        $quarto   = Quarto::findOrFail($data['quarto_id']);
        $checkin  = \Carbon\Carbon::parse($data['data_checkin']);
        $checkout = \Carbon\Carbon::parse($data['data_checkout']);
        $dias     = $checkin->diffInDays($checkout);

        $data['valor_total'] = $quarto->preco_diaria * $dias;

        Reserva::create($data);

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva criada com sucesso!');
    }

    public function show(string $id)
    {
        $realId  = decrypt($id);
        $reserva = Reserva::with(['hospede', 'quarto.categoria', 'funcionario'])->findOrFail($realId);
        return view('reservas.show', compact('reserva'));
    }

    public function edit(string $id)
    {
        $realId       = decrypt($id);
        $reserva      = Reserva::findOrFail($realId);
        $hospedes     = Hospede::orderBy('nome')->get();
        $quartos      = Quarto::orderBy('numero')->get();
        $funcionarios = Funcionario::orderBy('nome')->get();
        return view('reservas.edit', compact('reserva', 'hospedes', 'quartos', 'funcionarios'));
    }

    public function update(Request $request, string $id)
    {
        $realId  = decrypt($id);
        $reserva = Reserva::findOrFail($realId);

        $data = $request->validate([
            'hospede_id'     => 'required|exists:hospedes,id',
            'quarto_id'      => 'required|exists:quartos,id',
            'funcionario_id' => 'required|exists:funcionarios,id',
            'data_checkin'   => 'required|date',
            'data_checkout'  => 'required|date|after:data_checkin',
            'status'         => 'required|in:pendente,confirmada,cancelada,finalizada',
            'observacoes'    => 'nullable|string',
        ]);

        $quarto   = Quarto::findOrFail($data['quarto_id']);
        $checkin  = \Carbon\Carbon::parse($data['data_checkin']);
        $checkout = \Carbon\Carbon::parse($data['data_checkout']);
        $dias     = $checkin->diffInDays($checkout);

        $data['valor_total'] = $quarto->preco_diaria * $dias;

        $reserva->update($data);

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva atualizada com sucesso!');
    }

    public function destroy(string $id)
    {
        $realId  = decrypt($id);
        $reserva = Reserva::findOrFail($realId);
        $reserva->delete();

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva excluída com sucesso!');
    }
}
