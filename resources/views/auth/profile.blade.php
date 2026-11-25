@extends('layouts.fo')
@section('content')
<div class="form-panel"><h1>O meu perfil</h1>
<form method="POST" action="{{ route('user-profile-information.update') }}">@csrf @method('PUT')
<label class="form-label" for="name">Nome</label><input class="form-control mb-3" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
<label class="form-label" for="email">Email</label><input class="form-control mb-3" id="email" name="email" type="email" value="{{ old('email', Auth::user()->email) }}" required>
<button class="btn btn-warning">Guardar perfil</button></form>
<hr><h2>Alterar palavra-passe</h2>
<form method="POST" action="{{ route('user-password.update') }}">@csrf @method('PUT')
@foreach (['current_password'=>'Palavra-passe atual','password'=>'Nova palavra-passe','password_confirmation'=>'Confirmar nova palavra-passe'] as $field=>$label)
<label class="form-label" for="{{ $field }}">{{ $label }}</label><input class="form-control mb-3" id="{{ $field }}" name="{{ $field }}" type="password" required>
@endforeach
<button class="btn btn-warning">Alterar palavra-passe</button></form></div>
@endsection
