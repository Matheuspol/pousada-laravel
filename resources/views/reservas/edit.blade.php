@extends('layouts.app')
@section('title', 'Editar Reserva')
@section('page-title', 'Editar Reserva')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header py-3 px-4">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-pencil me-2 text-muted"></i>Editando Reserva #{{ $reserva->id }}</h6>
            </div>
            <div class="card-body p-4">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $e)<li class="small">{{ $e }}</li>@endforeach
                    </ul>
                </div>
                @endif
                <form method="POST" action="{{ route('reservas.update', encrypt($reserva->id)) }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Hóspede <span class="text-danger">*</span></label>
                            <select name="hospede_id" class="form-select @error('hospede_id') is-invalid @enderror" required>
                                @foreach($hospedes as $h)
                                <option value="{{ $h->id }}" {{ old('hospede_id', $reserva->hospede_id) == $h->id ? 'selected' : '' }}>
                                    {{ $h->nome }} — {{ $h->cpf }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Quarto <span class="text-danger">*</span></label>
                            <select name="quarto_id" class="form-select @error('quarto_id') is-invalid @enderror" required>
                                @foreach($quartos as $q)
                                <option value="{{ $q->id }}" {{ old('quarto_id', $reserva->quarto_id) == $q->id ? 'selected' : '' }}>
                                    Nº {{ $q->numero }} — R$ {{ number_format($q->preco_diaria, 2, ',', '.') }}/diária
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Funcionário <span class="text-danger">*</span></label>
                            <select name="funcionario_id" class="form-select" required>
                                @foreach($funcionarios as $f)
                                <option value="{{ $f->id }}" {{ old('funcionario_id', $reserva->funcionario_id) == $f->id ? 'selected' : '' }}>
                                    {{ $f->nome }} — {{ $f->cargo }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Status</label>
                            <select name="status" class="form-select" required>
                                @foreach(['pendente' => 'Pendente','confirmada' => 'Confirmada','cancelada' => 'Cancelada','finalizada' => 'Finalizada'] as $val => $label)
                                <option value="{{ $val }}" {{ old('status', $reserva->status) === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Check-in <span class="text-danger">*</span></label>
                            <input type="date" name="data_checkin" class="form-control"
                                value="{{ old('data_checkin', $reserva->data_checkin->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Check-out <span class="text-danger">*</span></label>
                            <input type="date" name="data_checkout" class="form-control"
                                value="{{ old('data_checkout', $reserva->data_checkout->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Observações</label>
                            <textarea name="observacoes" rows="2" class="form-control">{{ old('observacoes', $reserva->observacoes) }}</textarea>
                        </div>
                    </div>
                    <div class="alert alert-info small mt-3 mb-0 py-2">
                        <i class="bi bi-info-circle me-1"></i>
                        O valor total será recalculado automaticamente.
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Atualizar</button>
                        <a href="{{ route('reservas.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection