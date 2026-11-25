@extends('layouts.fo')
@section('content')
<div class="form-panel"><h1>Confirmar palavra-passe</h1>
<form method="POST" action="{{ route('password.confirm.store') }}">@csrf
<label class="form-label" for="password">Palavra-passe</label>
<input class="form-control mb-3" id="password" name="password" type="password" required>
<button class="btn btn-warning">Confirmar</button></form></div>
@endsection
