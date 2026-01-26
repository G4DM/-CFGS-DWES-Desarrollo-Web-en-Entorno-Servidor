<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function getHome()
    {
        // Si el usuario no está autenticado
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Si está autenticado, muestra la vista
        return view('home');
    }
}
