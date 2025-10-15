<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Website;

class WelcomeController extends Controller
{
    /**
     * Mostrar la página de bienvenida
     */
    public function index()
    {
        // Mostrar la página de bienvenida/landing page
        return view('welcome');
    }
}
