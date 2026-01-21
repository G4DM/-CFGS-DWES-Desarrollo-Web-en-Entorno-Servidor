<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatalogController extends Controller
{
    private $arrayPeliculas;

    public function __construct()
    {
        $this->arrayPeliculas = require __DIR__ . '/arrayPeliculas.php';
    }

    public function getIndex()
    {
        return view('catalog.index', [
            'arrayPeliculas' => $this->arrayPeliculas
        ]);
    }


    public function getShow($id)
    {
        if (!isset($this->arrayPeliculas[$id])) {
            abort(404, 'Película no encontrada');
        }

        $pelicula = $this->arrayPeliculas[$id];

        return view('catalog.show', [
            'pelicula' => $pelicula,
            'id' => $id
        ]);
    }


    public function getCreate()
    {
        return view('catalog.create');
    }

    public function getEdit($id)
    {
        if (!isset($this->arrayPeliculas[$id])) {
            abort(404, 'Película no encontrada');
        }

        $pelicula = $this->arrayPeliculas[$id];

        return view('catalog.edit', [
            'pelicula' => $pelicula,
            'id' => $id
        ]);
    }
}
