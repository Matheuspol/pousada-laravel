@extends('layouts.app')
@section('title', 'Funcionários')
@section('page-title', 'Funcionários')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between py-3 px-4">
        <h6 class="mb-0 fw-semibold"><i class="bi bi-person-badge me-2 text-muted"></i>Listagem</h6>
        <a href="{{ route('funcionarios.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Novo Funcionário
        </a>
    </div>
    <div class="px-4 pt-3">
        <form method="GET" action="{{ route('funcionarios.index') }}" class="d-flex gap-2">
            <input type="text" name="busca" class="form-control form-control-sm" style="max-width:320px"
                placeholder="Nome, CPF ou cargo..." value="{{ $busca }}">
            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i></button>
            @if($busca)
            <a href="{{ route('funcionarios.index') }}" class="btn btn-sm btn-outline-danger"><i class="bi bi-x-lg"></i></a>
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
                        <th>Cargo</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($funcionarios as $f)
                    <tr>
                        <td class="px-4 text-muted small">{{ $f->id }}</td>
                        <td class="fw-semibold">{{ $f->nome }}</td>
                        <td class="small">{{ $f->cpf }}</td>
                        <td><span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $f->cargo }}</span></td>
                        <td class="small">{{ $f->email ?: '—' }}</td>
                        <td class="small">{{ $f->telefone ?: '—' }}</td>
                        <td class="text-center">
                            <a href="{{ route('funcionarios.show', encrypt($f->id)) }}" class="btn btn-sm btn-outline-info me-1"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('funcionarios.edit', encrypt($f->id)) }}" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('funcionarios.destroy', encrypt($f->id)) }}" style="display:inline"
                                onsubmit="return confirm('Excluir este funcionário?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Nenhum funcionário encontrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3">{{ $funcionarios->links() }}</div>
    </div>
</div>
@endsection