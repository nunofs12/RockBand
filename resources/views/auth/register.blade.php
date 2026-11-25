@extends('layouts.fo')

@section('title', 'Registar')

@section('content')
    <div class="auth-panel form-panel">
        <span class="eyebrow">JUNTA-TE À COMUNIDADE</span>
        <h1>Criar conta</h1>
        <p class="page-subtitle">Novas contas têm o perfil User, com permissão para editar.</p>
        <form method="POST" action="{{ route('register.store') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nome *</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" maxlength="100" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email *</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" autocomplete="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Palavra-passe (mínimo 8 caracteres) *</label>
                <input type="password" id="password" name="password" class="form-control" autocomplete="new-password" minlength="8" required>
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirmar palavra-passe *</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" autocomplete="new-password" minlength="8" required>
            </div>
            <button type="submit" class="btn btn-warning w-100">Criar conta</button>
        </form>
        <p class="auth-alt">Já tens conta? <a href="{{ route('login') }}">Entrar</a></p>
    </div>
@endsection
