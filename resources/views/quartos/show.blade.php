@extends('layouts.app')
@section('title', 'Detalhes do Quarto')
@section('page-title', 'Detalhes do Quarto')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-door-closed me-2 text-muted"></i>Quarto Nº {{ $quarto->numero }}</h6>
                <div class="d-flex gap-2">
                    <a href="{{ route('quartos.edit', encrypt($quarto->id)) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil me-1"></i>Editar</a>
                    <a href="{{ route('quartos.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
                </div>
            </div>
            <div class="card-body p-4">
                <dl class="row mb-0">
                    <dt class="col-sm-4 text-muted small">Número</dt>
                    <dd class="col-sm-8 fw-bold">{{ $quarto->numero }}</dd>

                    <dt class="col-sm-4 text-muted small">Categoria</dt>
                    <dd class="col-sm-8">{{ $quarto->categoria->nome ?? '—' }}</dd>

                    <dt class="col-sm-4 text-muted small">Capacidade</dt>
                    <dd class="col-sm-8">{{ $quarto->categoria->capacidade ?? '—' }} pessoa(s)</dd>

                    <dt class="col-sm-4 text-muted small">Preço/Diária</dt>
                    <dd class="col-sm-8">R$ {{ number_format($quarto->preco_diaria, 2, ',', '.') }}</dd>

                    <dt class="col-sm-4 text-muted small">Status</dt>
                    <dd class="col-sm-8">
                        <span class="badge badge-{{ $quarto->status }} px-2 py-1">
                            {{ \App\Models\Quarto::statusLabel($quarto->status) }}
                        </span>
                    </dd>

                    <dt class="col-sm-4 text-muted small">Descrição</dt>
                    <dd class="col-sm-8">{{ $quarto->descricao ?: '—' }}</dd>

                    <dt class="col-sm-4 text-muted small">Cadastrado em</dt>
                    <dd class="col-sm-8">{{ $quarto->created_at->format('d/m/Y H:i') }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection