@extends('layouts.app')
@section('title', 'Nova Reserva')
@section('page-title', 'Nova Reserva')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header py-3 px-4">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-calendar-plus me-2 text-muted"></i>Preencha os dados da reserva</h6>
            </div>
            <div class="card-body p-4">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $e)<li class="small">{{ $e }}</li>@endforeach
                    </ul>
                </div>
                @endif
                <form method="POST" action="{{ route('reservas.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Hóspede <span class="text-danger">*</span></label>
                            <select name="hospede_id" class="form-select @error('hospede_id') is-invalid @enderror" required>
                                <option value="">Selecione o hóspede...</option>
                                @foreach($hospedes as $h)
                                <option value="{{ $h->id }}" {{ old('hospede_id') == $h->id ? 'selected' : '' }}>
                                    {{ $h->nome }} — {{ $h->cpf }}
                                </option>
                                @endforeach
                            </select>
                            @error('hospede_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Quarto <span class="text-danger">*</span></label>
                            <select name="quarto_id" class="form-select @error('quarto_id') is-invalid @enderror" required>
                                <option value="">Selecione o quarto...</option>
                                @foreach($quartos as $q)
                                <option value="{{ $q->id }}" {{ old('quarto_id') == $q->id ? 'selected' : '' }}>
                                    Nº {{ $q->numero }} — {{ $q->categoria->nome ?? '' }} — R$ {{ number_format($q->preco_diaria, 2, ',', '.') }}/diária
                                </option>
                                @endforeach
                            </select>
                            @error('quarto_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Funcionário responsável <span class="text-danger">*</span></label>
                            <select name="funcionario_id" class="form-select @error('funcionario_id') is-invalid @enderror" required>
                                <option value="">Selecione o funcionário...</option>
                                @foreach($funcionarios as $f)
                                <option value="{{ $f->id }}" {{ old('funcionario_id') == $f->id ? 'selected' : '' }}>
                                    {{ $f->nome }} — {{ $f->cargo }}
                                </option>
                                @endforeach
                            </select>
                            @error('funcionario_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="pendente" {{ old('status') === 'pendente'   ? 'selected' : '' }}>Pendente</option>
                                <option value="confirmada" {{ old('status') === 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                                <option value="cancelada" {{ old('status') === 'cancelada'  ? 'selected' : '' }}>Cancelada</option>
                                <option value="finalizada" {{ old('status') === 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Data de Check-in <span class="text-danger">*</span></label>
                            <input type="date" name="data_checkin" class="form-control @error('data_checkin') is-invalid @enderror"
                                value="{{ old('data_checkin') }}" required>
                            @error('data_checkin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Data de Check-out <span class="text-danger">*</span></label>
                            <input type="date" name="data_checkout" class="form-control @error('data_checkout') is-invalid @enderror"
                                value="{{ old('data_checkout') }}" required>
                            @error('data_checkout')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Observações</label>
                            <textarea name="observacoes" rows="2" class="form-control"
                                placeholder="Informações adicionais sobre a reserva...">{{ old('observacoes') }}</textarea>
                        </div>
                    </div>
                    <div class="alert alert-info small mt-3 mb-0 py-2">
                        <i class="bi bi-info-circle me-1"></i>
                        O valor total será calculado automaticamente com base no preço da diária e número de dias.
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Salvar</button>
                        <a href="{{ route('reservas.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection