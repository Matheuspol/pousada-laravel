@extends('layouts.auth')
@section('title', 'Login')

@section('content')
<h5 class="fw-semibold mb-1">Acessar sistema</h5>
<p class="text-muted small mb-4">Informe suas credenciais para continuar</p>

@if($errors->any())
<div class="alert alert-danger py-2">
    <i class="bi bi-exclamation-triangle me-1"></i>
    {{ $errors->first() }}
</div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label small fw-semibold">E-mail</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="seu@email.com" required autofocus>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label small fw-semibold">Senha</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
    </div>
    <div class="mb-4 form-check">
        <input type="checkbox" class="form-check-input" id="remember" name="remember">
        <label class="form-check-label small" for="remember">Manter conectado</label>
    </div>
    <button type="submit" class="btn btn-primary w-100 py-2">
        <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
    </button>
</form>

<hr class="my-4">
<p class="text-center text-muted small mb-0">
    Não tem conta?
    <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">Registre-se</a>
</p>
@endsection