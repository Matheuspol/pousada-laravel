@extends('layouts.app')
@section('title', 'Reservas')
@section('page-title', 'Reservas')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between py-3 px-4">
        <h6 class="mb-0 fw-semibold"><i class="bi bi-calendar-check me-2 text-muted"></i>Listagem</h6>
        <a href="{{ route('reservas.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Nova Reserva
        </a>
    </div>
    <div class="px-4 pt-3 d-flex gap-2 flex-wrap">
        <form method="GET" action="{{ route('reservas.index') }}" class="d-flex gap-2 flex-wrap">
            <input type="text" name="busca" class="form-control form-control-sm" style="max-width:200px"
                placeholder="Hóspede ou nº do quarto..." value="{{ $busca }}">
            <select name="status" class="form-select form-select-sm" style="max-width:160px">
                <option value="">Todos os status</option>
                <option value="pendente" {{ $status === 'pendente'   ? 'selected' : '' }}>Pendente</option>
                <option value="confirmada" {{ $status === 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                <option value="cancelada" {{ $status === 'cancelada'  ? 'selected' : '' }}>Cancelada</option>
                <option value="finalizada" {{ $status === 'finalizada' ? 'selected' : '' }}>Finalizada</option>
            </select>
            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i></button>
            @if($busca || $status)
            <a href="{{ route('reservas.index') }}" class="btn btn-sm btn-outline-danger"><i class="bi bi-x-lg"></i></a>
            @endif
        </form>
    </div>
    <div class="card-body p-0 mt-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4">#</th>
                        <th>Hóspede</th>
                        <th>Quarto</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Valor Total</th>
                        <th>Status</th>
                        <th>Funcionário</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservas as $r)
                    <tr>
                        <td class="px-4 text-muted small">{{ $r->id }}</td>
                        <td class="fw-semibold">{{ $r->hospede->nome ?? '—' }}</td>
                        <td>Nº {{ $r->quarto->numero ?? '—' }}</td>
                        <td class="small">{{ $r->data_checkin->format('d/m/Y') }}</td>
                        <td class="small">{{ $r->data_checkout->format('d/m/Y') }}</td>
                        <td class="fw-semibold">R$ {{ number_format($r->valor_total, 2, ',', '.') }}</td>
                        <td>
                            <span class="badge badge-{{ $r->status }} px-2 py-1">
                                {{ \App\Models\Reserva::statusLabel($r->status) }}
                            </span>
                        </td>
                        <td class="small">{{ $r->funcionario->nome ?? '—' }}</td>
                        <td class="text-center">
                            <a href="{{ route('reservas.show', encrypt($r->id)) }}" class="btn btn-sm btn-outline-info me-1"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('reservas.edit', encrypt($r->id)) }}" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('reservas.destroy', encrypt($r->id)) }}" style="display:inline"
                                onsubmit="return confirm('Excluir esta reserva?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">Nenhuma reserva encontrada.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3">{{ $reservas->links() }}</div>
    </div>
</div>
@endsection