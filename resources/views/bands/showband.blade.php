@extends('layouts.fo')

@section('title', 'Álbuns de '.$band->name_of_band)

@section('content')
    <a class="back-link" href="{{ route('bands.all') }}">← Voltar às bandas</a>
    <section class="band-hero">
        <div class="band-hero-photo">
            @if ($band->photo_of_band)
                <img src="{{ asset($band->photo_of_band) }}" alt="Fotografia de {{ $band->name_of_band }}">
            @else
                <span>♫</span>
            @endif
        </div>
        <div>
            <span class="eyebrow">DISCOGRAFIA</span>
            <h1>{{ $band->name_of_band }}<span class="heading-dot">.</span></h1>
            <p>{{ $band->albums->count() }} {{ $band->albums->count() === 1 ? 'álbum' : 'álbuns' }} no catálogo</p>
            @auth
                <a href="{{ route('bands.edit', $band) }}" class="btn btn-outline-light btn-sm">Editar banda</a>
            @endauth
        </div>
    </section>

    <div class="page-heading album-heading">
        <div>
            <h2>Álbuns</h2>
            <p class="page-subtitle">Discografia de {{ $band->name_of_band }}.</p>
        </div>
        @auth
            @if (Auth::user()->user_type === \App\Models\User::TYPE_ADMIN)
                <a href="{{ route('albums.add', $band) }}" class="btn btn-warning">+ Adicionar álbum</a>
            @endif
        @endauth
    </div>

    <div class="table-responsive rock-table-wrap">
        <table class="table table-hover align-middle rock-table">
            <thead>
                <tr>
                    <th scope="col">Capa</th>
                    <th scope="col">Nome do álbum</th>
                    <th scope="col">Data de lançamento</th>
                    <th scope="col" class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($band->albums as $album)
                    <tr>
                        <td>
                            @if ($album->album_cover)
                                <img class="album-cover" src="{{ asset($album->album_cover) }}" alt="Capa de {{ $album->album_name }}">
                            @else
                                <span class="image-placeholder album-placeholder" aria-label="Sem capa">♪</span>
                            @endif
                        </td>
                        <td class="band-name">{{ $album->album_name }}</td>
                        <td>{{ $album->release_date ? $album->release_date->format('Y') : '—' }}</td>
                        <td>
                            <div class="action-buttons">
                                @auth
                                    <a href="{{ route('albums.edit', $album) }}" class="btn btn-outline-primary btn-sm">Editar</a>
                                    @if (Auth::user()->user_type === \App\Models\User::TYPE_ADMIN)
                                        <form action="{{ route('albums.delete', $album) }}" method="POST" onsubmit="return confirm('Apagar este álbum?');">
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
                    <tr><td colspan="4" class="empty-state">Esta banda ainda não tem álbuns.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
