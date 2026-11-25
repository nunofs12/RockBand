@extends('layouts.fo')

@section('title', 'Editar '.$album->album_name)

@section('content')
    <a href="{{ route('bands.show', $band) }}" class="back-link">← Voltar aos álbuns</a>
    <div class="form-panel">
        <span class="eyebrow">EDIÇÃO DE ÁLBUM</span>
        <h1>Editar álbum</h1>
        <p class="page-subtitle">Álbum de <strong>{{ $band->name_of_band }}</strong>.</p>
        <form method="POST" action="{{ route('albums.update', $album) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label" for="album_name">Nome do álbum *</label>
                <input type="text" class="form-control" id="album_name" name="album_name" value="{{ old('album_name', $album->album_name) }}" maxlength="150" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="release_year">Ano de lançamento *</label>
                <input type="number" class="form-control" id="release_year" name="release_year" value="{{ old('release_year', $album->release_date?->format('Y')) }}" min="1900" max="2100" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="record_lable">Editora (opcional)</label>
                <input type="text" class="form-control" id="record_lable" name="record_lable" value="{{ old('record_lable', $album->record_lable) }}" maxlength="150">
            </div>
            <div class="mb-4">
                <label class="form-label" for="album_cover">Nova capa (opcional)</label>
                @if ($album->album_cover)
                    <div class="image-preview"><img class="preview-cover" src="{{ asset($album->album_cover) }}" alt="Capa atual de {{ $album->album_name }}"></div>
                @endif
                <input type="file" class="form-control" id="album_cover" name="album_cover" accept="image/png,image/jpeg,image/webp">
                <small class="form-text">Deixa vazio para manter a capa atual.</small>
            </div>
            <div class="form-actions">
                <button class="btn btn-warning" type="submit">Guardar alterações</button>
                <a class="btn btn-outline-secondary" href="{{ route('bands.show', $band) }}">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
