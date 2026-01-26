@extends('layouts.master')

@section('content')
    <h1>Modificar película</h1>

    <form method="POST" action="{{ url('/catalog/edit/' . $pelicula->id) }}">
        @method('PUT')
        @csrf
        <div class="form-group">
            <label>Título</label>
            <input name="title" type="text" class="form-control" value="{{ $pelicula->title }}">
        </div>

        <div class="form-group">
            <label>Año</label>
            <input name="year" type="text" class="form-control" value="{{ $pelicula->year }}">
        </div>

        <div class="form-group">
            <label>Director</label>
            <input name="director" type="text" class="form-control" value="{{ $pelicula->director }}">
        </div>

        <div class="form-group">
            <label>Sinopsis</label>
            <textarea name="synopsis" class="form-control">{{ $pelicula->synopsis }}</textarea>
        </div>

        <br>

        <button class="btn btn-primary">
            Modificar película
        </button>

        <a href="{{ url('/catalog') }}" class="btn btn-secondary">
            Volver
        </a>
    </form>
@endsection
