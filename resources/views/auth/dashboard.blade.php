@extends('layouts.fo')

@section('title', 'Dashboard')

@section('content')
    <div class="dashboard-welcome">
        <span class="eyebrow">ÁREA RESERVADA</span>
        <h1>Olá, {{ Auth::user()->name }}<span class="heading-dot">.</span></h1>
        <p>Bem-vindo ao teu Dashboard RockBand.</p>
        @if (Auth::user()->user_type === \App\Models\User::TYPE_ADMIN)
            <span class="dashboard-role">Perfil: Administrador — podes adicionar, editar e apagar bandas e álbuns.</span>
        @else
            <span class="dashboard-role">Perfil: User — podes editar bandas e álbuns.</span>
        @endif
    </div>
    <div class="dashboard-stats">
        <div class="stat-card"><strong>{{ $bandsCount }}</strong><span>Bandas</span></div>
        <div class="stat-card"><strong>{{ $albumsCount }}</strong><span>Álbuns</span></div>
    </div>
    <a class="btn btn-warning mt-4" href="{{ route('bands.all') }}">Ver catálogo de bandas</a>
@endsection
