@extends('layouts.fo')

@section('title', 'Todas as bandas')

@section('content')
    <div class="page-heading">
        <div>
            <span class="eyebrow">CATÁLOGO MUSICAL</span>
            <h1>As nossas bandas<span class="heading-dot">.</span></h1>
            <p class="page-subtitle">Explora as bandas e descobre os álbuns de cada uma.</p>
        </div>
        @auth
            {{-- Bloqueio no Blade por perfil: só o administrador vê o botão de adicionar. --}}
            @if (Auth::user()->user_type === \App\Models\User::TYPE_ADMIN)
                <a href="{{ route('bands.add') }}" class="btn btn-warning">+ Adicionar banda</a>
            @endif
        @endauth
    </div>

    <div class="table-responsive rock-table-wrap">
        <table class="table table-hover align-middle rock-table">
            <thead>
                <tr>
                    <th scope="col">Imagem</th>
                    <th scope="col">Nome da banda</th>
                    <th scope="col">N.º de álbuns</th>
                    <th scope="col" class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bands as $band)
                    <tr>
                        <td>
                            @if ($band->photo_of_band)
                                <img class="band-photo" src="{{ asset($band->photo_of_band) }}" alt="Fotografia de {{ $band->name_of_band }}">
                            @else
                                <span class="image-placeholder" aria-label="Sem imagem">♫</span>
                            @endif
                        </td>
                        <td class="band-name">{{ $band->name_of_band }}</td>
                        <td><span class="number-pill">{{ $band->albums_count }}</span></td>
                        <td>
                            <div class="action-buttons">
                                <a class="btn btn-outline-dark btn-sm" href="{{ route('bands.show', $band) }}">Ver álbuns</a>
                                @auth
                                    <a class="btn btn-outline-primary btn-sm" href="{{ route('bands.edit', $band) }}">Editar</a>
                                    @if (Auth::user()->user_type === \App\Models\User::TYPE_ADMIN)
                                        <form action="{{ route('bands.delete', $band) }}" method="POST" onsubmit="return confirm('Apagar esta banda e todos os seus álbuns?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Apagar</button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="empty-state">Ainda não existem bandas no catálogo.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @guest
        <p class="helper-note">Podes consultar o catálogo sem conta. <a href="{{ route('login') }}">Inicia sessão</a> para editar.</p>
    @endguest
@endsection
