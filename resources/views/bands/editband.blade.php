@extends('layouts.fo')

@section('title', 'Editar '.$band->name_of_band)

@section('content')
    <a href="{{ route('bands.all') }}" class="back-link">← Voltar às bandas</a>
    <div class="form-panel">
        <span class="eyebrow">EDIÇÃO DE BANDA</span>
        <h1>Editar {{ $band->name_of_band }}</h1>
        <p class="page-subtitle">Podes alterar o nome e a fotografia da banda.</p>
        <form method="POST" action="{{ route('bands.update', $band) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label" for="name_of_band">Nome da banda *</label>
                <input type="text" class="form-control" id="name_of_band" name="name_of_band" value="{{ old('name_of_band', $band->name_of_band) }}" maxlength="100" required>
            </div>
            <div class="mb-4">
                <label class="form-label" for="photo_of_band">Nova fotografia (opcional)</label>
                @if ($band->photo_of_band)
                    <div class="image-preview"><img src="{{ asset($band->photo_of_band) }}" alt="Fotografia atual da banda"></div>
                @endif
                <input type="file" class="form-control" id="photo_of_band" name="photo_of_band" accept="image/png,image/jpeg,image/webp">
                <small class="form-text">Deixa vazio para manter a fotografia atual.</small>
            </div>
            <div class="form-actions">
                <button class="btn btn-warning" type="submit">Guardar alterações</button>
                <a class="btn btn-outline-secondary" href="{{ route('bands.all') }}">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
