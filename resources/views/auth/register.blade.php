@extends('layouts.auth')
@section('title', 'Registro')

@section('content')
<h5 class="fw-semibold mb-1">Criar conta</h5>
<p class="text-muted small mb-4">Preencha os dados para se registrar</p>

@if($errors->any())
<div class="alert alert-danger py-2">
    <ul class="mb-0 ps-3">
        @foreach($errors->all() as $error)
        <li class="small">{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label small fw-semibold">Nome completo</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}" placeholder="Seu nome" required autofocus>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label small fw-semibold">E-mail</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="seu@email.com" required>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label small fw-semibold">Senha</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" class="form-control" placeholder="Mínimo 8 caracteres" required>
        </div>
    </div>
    <div class="mb-4">
        <label class="form-label small fw-semibold">Confirmar senha</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Repita a senha" required>
        </div>
    </div>
    <button type="submit" class="btn btn-primary w-100 py-2">
        <i class="bi bi-person-plus me-1"></i> Criar conta
    </button>
</form>

<hr class="my-4">
<p class="text-center text-muted small mb-0">
    Já tem conta?
    <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Entrar</a>
</p>
@endsection