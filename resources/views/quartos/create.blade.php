@extends('layouts.app')
@section('title', 'Novo Quarto')
@section('page-title', 'Novo Quarto')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header py-3 px-4">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-door-closed me-2 text-muted"></i> Preencha os dados </h6>
            </div>
            <div class="card-body p-4">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $e)<li class="small">{{ $e }}</li>@endforeach
                    </ul>
                </div>
                @endif
                <form method="POST" action="{{ route('quartos.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Número <span class="text-danger">*</span></label>
                            <input type="text" name="numero" class="form-control @error('numero') is-invalid @enderror"
                                value="{{ old('numero') }}" placeholder="Ex: 101" required>
                            @error('numero')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold small">Categoria <span class="text-danger">*</span></label>
                            <select name="categoria_id" class="form-select @error('categoria_id') is-invalid @enderror" required>
                                <option value="">Selecione...</option>
                                @foreach($categorias as $cat)
                                <option value="{{ $cat->id }}" {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nome }} ({{ $cat->capacidade }} pessoa(s))
                                </option>
                                @endforeach
                            </select>
                            @error('categoria_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Preço da Diária (R$) <span class="text-danger">*</span></label>
                            <input type="number" name="preco_diaria" class="form-control @error('preco_diaria') is-invalid @enderror"
                                value="{{ old('preco_diaria') }}" step="0.01" min="0" required>
                            @error('preco_diaria')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="disponivel" {{ old('status') === 'disponivel' ? 'selected' : '' }}>Disponível</option>
                                <option value="ocupado" {{ old('status') === 'ocupado'    ? 'selected' : '' }}>Ocupado</option>
                                <option value="manutencao" {{ old('status') === 'manutencao' ? 'selected' : '' }}>Em Manutenção</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Descrição</label>
                            <textarea name="descricao" rows="3" class="form-control"
                                placeholder="Comodidades, características especiais...">{{ old('descricao') }}</textarea>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Salvar</button>
                        <a href="{{ route('quartos.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection