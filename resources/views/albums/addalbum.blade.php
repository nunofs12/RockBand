@extends('layouts.fo')

@section('title', 'Adicionar álbum')

@section('content')
    <a href="{{ route('bands.show', $band) }}" class="back-link">← Voltar aos álbuns</a>
    <div class="form-panel">
        <span class="eyebrow">ADMINISTRAÇÃO</span>
        <h1>Adicionar álbum</h1>
        <p class="page-subtitle">Novo álbum de <strong>{{ $band->name_of_band }}</strong>.</p>
        <form method="POST" action="{{ route('albums.store', $band) }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="album_name">Nome do álbum *</label>
                <input type="text" class="form-control" id="album_name" name="album_name" value="{{ old('album_name') }}" maxlength="150" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="release_year">Ano de lançamento *</label>
                <input type="number" class="form-control" id="release_year" name="release_year" value="{{ old('release_year') }}" min="1900" max="2100" required>
                <small class="form-text">Nos dados fornecidos só existe o ano de lançamento.</small>
            </div>
            <div class="mb-3">
                <label class="form-label" for="record_lable">Editora (opcional)</label>
                <input type="text" class="form-control" id="record_lable" name="record_lable" value="{{ old('record_lable') }}" maxlength="150">
            </div>
            <div class="mb-4">
                <label class="form-label" for="album_cover">Capa do álbum</label>
                <input type="file" class="form-control" id="album_cover" name="album_cover" accept="image/png,image/jpeg,image/webp">
                <small class="form-text">JPG, PNG ou WEBP; máximo 4 MB.</small>
            </div>
            <div class="form-actions">
                <button class="btn btn-warning" type="submit">Guardar álbum</button>
                <a class="btn btn-outline-secondary" href="{{ route('bands.show', $band) }}">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
