<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplatePreviewController extends Controller
{
  /**
   * Mostrar la página principal de una plantilla
   */
  public function index($template)
  {
    $templatePath = "templates.{$template}.template";

    if (!view()->exists($templatePath)) {
      abort(404, 'Plantilla no encontrada');
    }

    // Crear un mock del modelo Website
    $website = new class {
      public $name = 'Academia Online';
      public $slug = 'academia-online';

      public function menus()
      {
        return new class {
          public function where($field, $value)
          {
            return $this;
          }
          public function first()
          {
            return null; // No hay menú configurado, usará el fallback
          }
        };
      }
    };

    return view($templatePath, [
      'website' => $website,
      'customization' => [
        'header' => [],
        'footer' => []
      ]
    ]);
  }

  /**
   * Mostrar el blog de una plantilla
   */
  public function blog($template)
  {
    $templatePath = "templates.{$template}.blog";

    if (!view()->exists($templatePath)) {
      abort(404, 'Página de blog no encontrada');
    }

    // Crear un mock del modelo Website
    $website = new class {
      public $name = 'Academia Online';
      public $slug = 'academia-online';

      public function menus()
      {
        return new class {
          public function where($field, $value)
          {
            return $this;
          }
          public function first()
          {
            return null; // No hay menú configurado, usará el fallback
          }
        };
      }
    };

    return view($templatePath, [
      'website' => $website,
      'customization' => [
        'header' => [],
        'footer' => []
      ]
    ]);
  }

  /**
   * Mostrar el contacto de una plantilla
   */
  public function contact($template)
  {
    $templatePath = "templates.{$template}.contacto";

    if (!view()->exists($templatePath)) {
      abort(404, 'Página de contacto no encontrada');
    }

    // Crear un mock del modelo Website
    $website = new class {
      public $name = 'Academia Online';
      public $slug = 'academia-online';

      public function menus()
      {
        return new class {
          public function where($field, $value)
          {
            return $this;
          }
          public function first()
          {
            return null; // No hay menú configurado, usará el fallback
          }
        };
      }
    };

    return view($templatePath, [
      'website' => $website,
      'customization' => [
        'header' => [],
        'footer' => []
      ]
    ]);
  }

  /**
   * Mostrar una página específica de una plantilla
   */
  public function page($template, $page)
  {
    $templatePath = "templates.{$template}.{$page}";

    if (!view()->exists($templatePath)) {
      abort(404, 'Página no encontrada');
    }

    return view($templatePath);
  }
}
