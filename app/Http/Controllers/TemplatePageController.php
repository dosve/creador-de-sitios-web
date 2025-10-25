<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplatePageController extends Controller
{
  /**
   * Mostrar una página específica de una plantilla
   */
  public function show(Request $request, $template, $page)
  {
    // Verificar si existe el archivo de la plantilla
    $templatePath = "templates.{$template}.{$page}";

    if (!view()->exists($templatePath)) {
      abort(404, 'Página no encontrada');
    }

    return view($templatePath);
  }

  /**
   * Mostrar el blog de academia online
   */
  public function blog()
  {
    return view('templates.academia-online.blog');
  }

  /**
   * Mostrar el contacto de academia online
   */
  public function contacto()
  {
    return view('templates.academia-online.contacto');
  }
}
