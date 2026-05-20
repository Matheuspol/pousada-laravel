@extends('layouts.app')
@section('title', 'Hóspedes')
@section('page-title', 'Hóspedes')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between py-3 px-4">
        <h6 class="mb-0 fw-semibold"><i class="bi bi-people me-2 text-muted"></i>Listagem</h6>
        <a href="{{ route('hospedes.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Novo Hóspede
        </a>
    </div>

    <div class="px-4 pt-3">
        <form method="GET" action="{{ route('hospedes.index') }}" class="d-flex gap-2">
            <input type="text" name="busca" class="form-control form-control-sm" style="max-width:320px"
                placeholder="Nome, CPF, e-mail ou cidade..." value="{{ $busca }}">
            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i></button>
            @if($busca)
            <a href="{{ route('hospedes.index') }}" class="btn btn-sm btn-outline-danger"><i class="bi bi-x-lg"></i></a>
            @endif
        </form>
    </div>

    <div class="card-body p-0 mt-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4">#</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Cidade/UF</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hospedes as $h)
                    <tr>
                        <td class="px-4 text-muted small">{{ $h->id }}</td>
                        <td class="fw-semibold">{{ $h->nome }}</td>
                        <td class="small">{{ $h->cpf }}</td>
                        <td class="small">{{ $h->email ?: '—' }}</td>
                        <td class="small">{{ $h->telefone ?: '—' }}</td>
                        <td class="small">{{ $h->cidade ? $h->cidade . ($h->estado ? '/' . $h->estado : '') : '—' }}</td>
                        <td class="text-center">
                            <a href="{{ route('hospedes.show', encrypt($h->id)) }}" class="btn btn-sm btn-outline-info me-1"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('hospedes.edit', encrypt($h->id)) }}" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('hospedes.destroy', encrypt($h->id)) }}" style="display:inline"
                                onsubmit="return confirm('Excluir este hóspede?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Nenhum hóspede encontrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3">{{ $hospedes->links() }}</div>
    </div>
</div>
@endsection