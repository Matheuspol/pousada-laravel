@extends('layouts.app')
@section('title', 'Detalhes da Reserva')
@section('page-title', 'Detalhes da Reserva')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-calendar-check me-2 text-muted"></i>Reserva #{{ $reserva->id }}</h6>
                <div class="d-flex gap-2">
                    <a href="{{ route('reservas.edit', encrypt($reserva->id)) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil me-1"></i>Editar</a>
                    <a href="{{ route('reservas.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 rounded bg-light">
                            <p class="text-muted small mb-1">Hóspede</p>
                            <p class="fw-semibold mb-0">{{ $reserva->hospede->nome ?? '—' }}</p>
                            <p class="small text-muted mb-0">{{ $reserva->hospede->cpf ?? '' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded bg-light">
                            <p class="text-muted small mb-1">Quarto</p>
                            <p class="fw-semibold mb-0">Nº {{ $reserva->quarto->numero ?? '—' }}</p>
                            <p class="small text-muted mb-0">{{ $reserva->quarto->categoria->nome ?? '' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded bg-light">
                            <p class="text-muted small mb-1">Período</p>
                            <p class="fw-semibold mb-0">
                                {{ $reserva->data_checkin->format('d/m/Y') }} → {{ $reserva->data_checkout->format('d/m/Y') }}
                            </p>
                            <p class="small text-muted mb-0">
                                {{ $reserva->data_checkin->diffInDays($reserva->data_checkout) }} diária(s)
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded bg-light">
                            <p class="text-muted small mb-1">Valor Total</p>
                            <p class="fw-bold fs-5 mb-0 text-success">R$ {{ number_format($reserva->valor_total, 2, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <dl class="row mt-3 mb-0">
                    <dt class="col-sm-4 text-muted small">Status</dt>
                    <dd class="col-sm-8">
                        <span class="badge badge-{{ $reserva->status }} px-2 py-1">
                            {{ \App\Models\Reserva::statusLabel($reserva->status) }}
                        </span>
                    </dd>
                    <dt class="col-sm-4 text-muted small">Funcionário</dt>
                    <dd class="col-sm-8">{{ $reserva->funcionario->nome ?? '—' }} ({{ $reserva->funcionario->cargo ?? '' }})</dd>
                    <dt class="col-sm-4 text-muted small">Observações</dt>
                    <dd class="col-sm-8">{{ $reserva->observacoes ?: '—' }}</dd>
                    <dt class="col-sm-4 text-muted small">Criado em</dt>
                    <dd class="col-sm-8">{{ $reserva->created_at->format('d/m/Y H:i') }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection