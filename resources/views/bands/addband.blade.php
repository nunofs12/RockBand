@extends('layouts.fo')

@section('title', 'Adicionar banda')

@section('content')
    <a href="{{ route('bands.all') }}" class="back-link">← Voltar às bandas</a>
    <div class="form-panel">
        <span class="eyebrow">ADMINISTRAÇÃO</span>
        <h1>Adicionar banda</h1>
        <p class="page-subtitle">Preenche os dados da nova banda.</p>
        <form method="POST" action="{{ route('bands.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="name_of_band">Nome da banda *</label>
                <input type="text" class="form-control" id="name_of_band" name="name_of_band" value="{{ old('name_of_band') }}" maxlength="100" required>
            </div>
            <div class="mb-4">
                <label class="form-label" for="photo_of_band">Fotografia</label>
                <input type="file" class="form-control" id="photo_of_band" name="photo_of_band" accept="image/png,image/jpeg,image/webp">
                <small class="form-text">JPG, PNG ou WEBP; máximo 4 MB.</small>
            </div>
            <div class="form-actions">
                <button class="btn btn-warning" type="submit">Guardar banda</button>
                <a class="btn btn-outline-secondary" href="{{ route('bands.all') }}">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
