{{-- ============================================================ --}}
{{-- resources/views/categorias-quarto/index.blade.php           --}}
{{-- ============================================================ --}}
@extends('layouts.app')
@section('title', 'Categorias de Quarto')
@section('page-title', 'Categorias de Quarto')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between py-3 px-4">
        <h6 class="mb-0 fw-semibold"><i class="bi bi-tag me-2 text-muted"></i>Listagem</h6>
        <a href="{{ route('categorias-quarto.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Nova Categoria
        </a>
    </div>

    {{-- Pesquisa --}}
    <div class="px-4 pt-3">
        <form method="GET" action="{{ route('categorias-quarto.index') }}" class="d-flex gap-2">
            <input type="text" name="busca" class="form-control form-control-sm" style="max-width:300px"
                placeholder="Pesquisar por nome ou descrição..." value="{{ $busca }}">
            <button type="submit" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-search"></i>
            </button>
            @if($busca)
            <a href="{{ route('categorias-quarto.index') }}" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-x-lg"></i>
            </a>
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
                        <th>Capacidade</th>
                        <th>Descrição</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categorias as $cat)
                    <tr>
                        <td class="px-4 text-muted small">{{ $cat->id }}</td>
                        <td class="fw-semibold">{{ $cat->nome }}</td>
                        <td>{{ $cat->capacidade }} pessoa(s)</td>
                        <td class="text-muted small">{{ Str::limit($cat->descricao, 60) ?: '—' }}</td>
                        <td class="text-center">
                            <a href="{{ route('categorias-quarto.show', encrypt($cat->id)) }}"
                                class="btn btn-sm btn-outline-info me-1" title="Ver">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('categorias-quarto.edit', encrypt($cat->id)) }}"
                                class="btn btn-sm btn-outline-warning me-1" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST"
                                action="{{ route('categorias-quarto.destroy', encrypt($cat->id)) }}"
                                style="display:inline"
                                onsubmit="return confirm('Excluir esta categoria?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Excluir">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Nenhuma categoria encontrada.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3">
            {{ $categorias->links() }}
        </div>
    </div>
</div>
@endsection