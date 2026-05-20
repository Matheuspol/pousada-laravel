@extends('layouts.app')
@section('title', 'Quartos')
@section('page-title', 'Quartos')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between py-3 px-4">
        <h6 class="mb-0 fw-semibold"><i class="bi bi-door-closed me-2 text-muted"></i>Listagem</h6>
        <a href="{{ route('quartos.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Novo Quarto
        </a>
    </div>
    <div class="px-4 pt-3 d-flex gap-2 flex-wrap">
        <form method="GET" action="{{ route('quartos.index') }}" class="d-flex gap-2 flex-wrap">
            <input type="text" name="busca" class="form-control form-control-sm" style="max-width:200px"
                placeholder="Número ou descrição..." value="{{ $busca }}">
            <select name="status" class="form-select form-select-sm" style="max-width:160px">
                <option value="">Todos os status</option>
                <option value="disponivel" {{ $status === 'disponivel'  ? 'selected' : '' }}>Disponível</option>
                <option value="ocupado" {{ $status === 'ocupado'     ? 'selected' : '' }}>Ocupado</option>
                <option value="manutencao" {{ $status === 'manutencao'  ? 'selected' : '' }}>Em Manutenção</option>
            </select>
            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i></button>
            @if($busca || $status)
            <a href="{{ route('quartos.index') }}" class="btn btn-sm btn-outline-danger"><i class="bi bi-x-lg"></i></a>
            @endif
        </form>
    </div>
    <div class="card-body p-0 mt-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4">Número</th>
                        <th>Categoria</th>
                        <th>Preço/Diária</th>
                        <th>Status</th>
                        <th>Descrição</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quartos as $q)
                    <tr>
                        <td class="px-4 fw-bold">{{ $q->numero }}</td>
                        <td>{{ $q->categoria->nome ?? '—' }}</td>
                        <td>R$ {{ number_format($q->preco_diaria, 2, ',', '.') }}</td>
                        <td>
                            <span class="badge badge-{{ $q->status }} px-2 py-1">
                                {{ \App\Models\Quarto::statusLabel($q->status) }}
                            </span>
                        </td>
                        <td class="small text-muted">{{ Str::limit($q->descricao, 50) ?: '—' }}</td>
                        <td class="text-center">
                            <a href="{{ route('quartos.show', encrypt($q->id)) }}" class="btn btn-sm btn-outline-info me-1"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('quartos.edit', encrypt($q->id)) }}" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('quartos.destroy', encrypt($q->id)) }}" style="display:inline"
                                onsubmit="return confirm('Excluir este quarto?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Nenhum quarto encontrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3">{{ $quartos->links() }}</div>
    </div>
</div>
@endsection