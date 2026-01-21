@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-sm-4">
            <img src="{{ $pelicula->poster }}" style="width:100%" />
        </div>
        <div class="col-sm-8">
            <h1>{{ $pelicula->title }}</h1>
            <h4><strong>Año:</strong> {{ $pelicula->year }}</h4>
            <h4><strong>Director:</strong> {{ $pelicula->director }}</h4>
            <br>
            <p><strong>Resumen:</strong> {{ $pelicula->synopsis }}</p>
            <br>
            <p><strong>Estado:</strong> {{ $pelicula->rented ? 'Película actualmente alquilada' : 'Película disponible' }}
            </p>
            @if ($pelicula->rented)
                <a class="btn btn-danger">Devolver película</a>
            @else
                <a class="btn btn-primary">Alquilar película</a>
            @endif
            <a href="{{ url('/catalog/edit/' . $pelicula->id) }}" class="btn btn-warning">
                ✏️ Editar película
            </a>
            <a href="{{ url('/catalog') }}" class="btn btn-outline-dark">&lt; Volver al listado</a>
        </div>
    </div>
@endsection
