@extends('layouts.master')

@section('content')
    <h1>Modificar película</h1>

    <form>
        <div class="form-group">
            <label>Título</label>
            <input type="text" class="form-control" value="{{ $pelicula['title'] }}">
        </div>

        <div class="form-group">
            <label>Año</label>
            <input type="text" class="form-control" value="{{ $pelicula['year'] }}">
        </div>

        <div class="form-group">
            <label>Director</label>
            <input type="text" class="form-control" value="{{ $pelicula['director'] }}">
        </div>

        <div class="form-group">
            <label>Sinopsis</label>
            <textarea class="form-control">{{ $pelicula['synopsis'] }}</textarea>
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
