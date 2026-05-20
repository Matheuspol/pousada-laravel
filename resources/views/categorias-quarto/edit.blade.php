@extends('layouts.app')
@section('title', 'Editar Categoria')
@section('page-title', 'Editar Categoria de Quarto')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header py-3 px-4">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-pencil me-2 text-muted"></i>Editando: {{ $categoria->nome }}</h6>
            </div>
            <div class="card-body p-4">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                        <li class="small">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('categorias-quarto.update', encrypt($categoria->id)) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Nome <span class="text-danger">*</span></label>
                        <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                            value="{{ old('nome', $categoria->nome) }}" required>
                        @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Capacidade (pessoas) <span class="text-danger">*</span></label>
                        <input type="number" name="capacidade" class="form-control @error('capacidade') is-invalid @enderror"
                            value="{{ old('capacidade', $categoria->capacidade) }}" min="1" required>
                        @error('capacidade')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold small">Descrição</label>
                        <textarea name="descricao" rows="3" class="form-control">{{ old('descricao', $categoria->descricao) }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Atualizar
                        </button>
                        <a href="{{ route('categorias-quarto.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Voltar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection