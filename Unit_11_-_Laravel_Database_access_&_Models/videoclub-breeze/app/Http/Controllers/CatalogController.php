<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class CatalogController extends Controller
{
    public function getIndex()
    {
        // Obtener todas las películas de la base de datos
        $arrayPeliculas = Movie::all();

        return view('catalog.index', [
            'arrayPeliculas' => $arrayPeliculas
        ]);
    }

    public function getShow($id)
    {
        // Obtener la película por su id, si no existe lanza un error 404
        $pelicula = Movie::findOrFail($id);

        return view('catalog.show', [
            'pelicula' => $pelicula,
            'id' => $id
        ]);
    }

    public function getCreate()
    {
        return view('catalog.create');
    }

    public function postCreate(Request $request)
    {
        $pelicula = new Movie();
        $pelicula->title = $request->input('title');
        $pelicula->year = $request->input('year');
        $pelicula->director = $request->input('director');
        $pelicula->poster = $request->input('poster');
        $pelicula->synopsis = $request->input('synopsis');

        $pelicula->save();

        return redirect('/catalog')->with('success', 'Película creada correectamente.');
    }

    public function getEdit($id)
    {
        // Obtener la película por su id, si no existe lanza un error 404
        $pelicula = Movie::findOrFail($id);

        return view('catalog.edit', [
            'pelicula' => $pelicula,
            'id' => $id
        ]);
    }

    public function putEdit(Request $request, $id)
    {
        $pelicula = Movie::findOrFail($id);

        $pelicula->title = $request->title;
        $pelicula->year = $request->year;
        $pelicula->director = $request->director;
        $pelicula->synopsis = $request->synopsis;

        $pelicula->save();

        return redirect('/catalog/show/' . $pelicula->id);
    }
}
