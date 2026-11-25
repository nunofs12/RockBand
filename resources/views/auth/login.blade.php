@extends('layouts.fo')

@section('title', 'Entrar')

@section('content')
    <div class="auth-panel form-panel">
        <span class="eyebrow">BEM-VINDO DE VOLTA</span>
        <h1>Iniciar sessão</h1>
        <p class="page-subtitle">Entra na tua conta para editar o catálogo.</p>
        <form method="POST" action="{{ route('login.store') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" autocomplete="email" required autofocus>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Palavra-passe</label>
                <input type="password" id="password" name="password" class="form-control" autocomplete="current-password" required>
            </div>
            <button class="btn btn-warning w-100" type="submit">Entrar</button>
        </form>
        <p class="mt-3"><a href="{{ route('password.request') }}">Esqueci-me da palavra-passe</a></p>
        <p class="auth-alt">Ainda não tens conta? <a href="{{ route('register') }}">Registar</a></p>
    </div>
@endsection
