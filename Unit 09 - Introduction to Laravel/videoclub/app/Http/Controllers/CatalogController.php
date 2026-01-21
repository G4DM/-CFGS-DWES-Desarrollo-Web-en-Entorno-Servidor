<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class CatalogController extends Controller
{
    /**
     * Muestra el listado completo del catálogo de películas
     */
    public function getIndex()
    {
        // Obtener todas las películas de la base de datos
        $arrayPeliculas = Movie::all();

        return view('catalog.index', [
            'arrayPeliculas' => $arrayPeliculas
        ]);
    }

    /**
     * Muestra el detalle de una película
     * @param int $id - Identificador de la película
     */
    public function getShow($id)
    {
        // Obtener la película por su id, si no existe lanza un error 404
        $pelicula = Movie::findOrFail($id);

        return view('catalog.show', [
            'pelicula' => $pelicula,
            'id' => $id
        ]);
    }

    /**
     * Muestra el formulario para crear una nueva película
     */
    public function getCreate()
    {
        return view('catalog.create');
    }

    /**
     * Muestra el formulario para editar una película existente
     * @param int $id - Identificador de la película
     */
    public function getEdit($id)
    {
        // Obtener la película por su id, si no existe lanza un error 404
        $pelicula = Movie::findOrFail($id);

        return view('catalog.edit', [
            'pelicula' => $pelicula,
            'id' => $id
        ]);
    }
}
