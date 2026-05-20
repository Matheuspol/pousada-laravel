@extends('layouts.app')
@section('title', 'Detalhes do Hóspede')
@section('page-title', 'Detalhes do Hóspede')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-person me-2 text-muted"></i>{{ $hospede->nome }}</h6>
                <div class="d-flex gap-2">
                    <a href="{{ route('hospedes.edit', encrypt($hospede->id)) }}" class="btn btn-sm btn-outline-warning">
                        <i class="bi bi-pencil me-1"></i>Editar
                    </a>
                    <a href="{{ route('hospedes.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Voltar
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                <dl class="row mb-0">
                    <dt class="col-sm-4 text-muted small">Nome</dt>
                    <dd class="col-sm-8 fw-semibold">{{ $hospede->nome }}</dd>

                    <dt class="col-sm-4 text-muted small">CPF</dt>
                    <dd class="col-sm-8">{{ $hospede->cpf }}</dd>

                    <dt class="col-sm-4 text-muted small">E-mail</dt>
                    <dd class="col-sm-8">{{ $hospede->email ?: '—' }}</dd>

                    <dt class="col-sm-4 text-muted small">Telefone</dt>
                    <dd class="col-sm-8">{{ $hospede->telefone ?: '—' }}</dd>

                    <dt class="col-sm-4 text-muted small">Cidade/UF</dt>
                    <dd class="col-sm-8">{{ $hospede->cidade ? $hospede->cidade . ($hospede->estado ? '/' . $hospede->estado : '') : '—' }}</dd>

                    <dt class="col-sm-4 text-muted small">Total de Reservas</dt>
                    <dd class="col-sm-8">{{ $hospede->reservas()->count() }}</dd>

                    <dt class="col-sm-4 text-muted small">Cadastrado em</dt>
                    <dd class="col-sm-8">{{ $hospede->created_at->format('d/m/Y H:i') }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection