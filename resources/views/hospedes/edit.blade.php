@extends('layouts.app')
@section('title', 'Editar Hóspede')
@section('page-title', 'Editar Hóspede')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header py-3 px-4">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-pencil me-2 text-muted"></i>Editando: {{ $hospede->nome }}</h6>
            </div>
            <div class="card-body p-4">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $e)<li class="small">{{ $e }}</li>@endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('hospedes.update', encrypt($hospede->id)) }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Nome completo <span class="text-danger">*</span></label>
                            <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                                value="{{ old('nome', $hospede->nome) }}" required>
                            @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">CPF <span class="text-danger">*</span></label>
                            <input type="text" name="cpf" class="form-control @error('cpf') is-invalid @enderror"
                                value="{{ old('cpf', $hospede->cpf) }}" maxlength="14" required>
                            @error('cpf')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Telefone</label>
                            <input type="text" name="telefone" class="form-control" value="{{ old('telefone', $hospede->telefone) }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">E-mail</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $hospede->email) }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold small">Cidade</label>
                            <input type="text" name="cidade" class="form-control" value="{{ old('cidade', $hospede->cidade) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Estado (UF)</label>
                            <input type="text" name="estado" class="form-control" value="{{ old('estado', $hospede->estado) }}" maxlength="2">
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Atualizar</button>
                        <a href="{{ route('hospedes.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection