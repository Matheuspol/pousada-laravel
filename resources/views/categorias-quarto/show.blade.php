@extends('layouts.app')
@section('title', 'Detalhes da Categoria')
@section('page-title', 'Detalhes da Categoria')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-tag me-2 text-muted"></i>{{ $categoria->nome }}</h6>
                <div class="d-flex gap-2">
                    <a href="{{ route('categorias-quarto.edit', encrypt($categoria->id)) }}" class="btn btn-sm btn-outline-warning">
                        <i class="bi bi-pencil me-1"></i>Editar
                    </a>
                    <a href="{{ route('categorias-quarto.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Voltar
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                <dl class="row mb-0">
                    <dt class="col-sm-4 text-muted small">Nome</dt>
                    <dd class="col-sm-8 fw-semibold">{{ $categoria->nome }}</dd>

                    <dt class="col-sm-4 text-muted small">Capacidade</dt>
                    <dd class="col-sm-8">{{ $categoria->capacidade }} pessoa(s)</dd>

                    <dt class="col-sm-4 text-muted small">Descrição</dt>
                    <dd class="col-sm-8">{{ $categoria->descricao ?: '—' }}</dd>

                    <dt class="col-sm-4 text-muted small">Quartos vinculados</dt>
                    <dd class="col-sm-8">{{ $categoria->quartos()->count() }}</dd>

                    <dt class="col-sm-4 text-muted small">Criado em</dt>
                    <dd class="col-sm-8">{{ $categoria->created_at->format('d/m/Y H:i') }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection