<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RockBand CRM') — RockBand</title>
    {{-- O mesmo padrão de layout master com Bootstrap usado no ServerSideFE. --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark rock-nav">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('bands.all') }}"><span class="brand-icon">♫</span> RockBand</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#rockNavbar" aria-controls="rockNavbar" aria-expanded="false" aria-label="Abrir menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="rockNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('bands.*') || request()->routeIs('home') ? 'active' : '' }}" href="{{ route('bands.all') }}">Bandas</a></li>
                    @auth
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a></li>
                    @endauth
                </ul>
                <div class="d-flex align-items-center flex-wrap gap-2 auth-links">
                    @auth
                        <a class="nav-link text-light" href="{{ route('profile') }}">Perfil</a>
                        <span class="nav-username">{{ Auth::user()->name }}</span>
                        @if (Auth::user()->user_type === \App\Models\User::TYPE_ADMIN)
                            <span class="role-pill">Administrador</span>
                        @else
                            <span class="role-pill role-user">User</span>
                        @endif
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">Sair</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Entrar</a>
                        <a href="{{ route('register') }}" class="btn btn-warning btn-sm">Registar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="container main-content">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if (session('message'))
            <div class="alert alert-success" role="status">{{ session('message') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <strong>Verifica os dados:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="container rock-footer">
        <span>ROCKBAND CRM</span>
        <span>Bandas, discos e boa música.</span>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
