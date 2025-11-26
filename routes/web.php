<?php

// LOG: Debug de rutas
file_put_contents(storage_path('logs/debug.log'), "=== RUTAS CARGADAS ===\n", FILE_APPEND);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Creator\DashboardController as CreatorDashboard;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\MediaFileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\SharedComponentController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\TagController as AdminTagController;
use App\Http\Controllers\Admin\ComponentController;
use App\Http\Controllers\ContentImportController;
use App\Http\Controllers\Admin\DomainController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\PageController as AdminPageController;

// Ruta raíz - mostrar el sitio web real
Route::get('/', [App\Http\Controllers\WebsiteController::class, 'showRoot'])->name('website.root');

// Ruta para servir CSS de plantillas
Route::get('/template-css/{template}', function ($template) {
    $cssPath = resource_path("views/templates/{$template}/styles.css");

    if (!file_exists($cssPath)) {
        abort(404);
    }

    $cssContent = file_get_contents($cssPath);

    return response($cssContent)
        ->header('Content-Type', 'text/css')
        ->header('Cache-Control', 'public, max-age=3600');
})->name('template.css');

// Ruta de bienvenida/landing page
Route::get('/bienvenida', [App\Http\Controllers\WelcomeController::class, 'index'])->name('welcome');

// Ruta temporal para test
Route::get('/test-pages', function () {
    $website = \App\Models\Website::first();
    $pages = $website ? $website->pages()->latest()->get() : collect();
    return view('creator.pages.test', compact('website', 'pages'));
})->name('test.pages');

// Ruta pública de planes
Route::get('/planes', function () {
    $plans = \App\Models\Plan::where('is_active', true)->orderBy('price')->get();
    return view('plans', compact('plans'));
})->name('plans');

// Rutas de autenticación OAuth2 (Recomendado)
Route::get('/auth/oauth/redirect', [App\Http\Controllers\Auth\OAuthController::class, 'redirect'])->name('oauth.redirect');
Route::get('/auth/oauth/callback', [App\Http\Controllers\Auth\OAuthController::class, 'callback'])->name('oauth.callback');
Route::post('/auth/oauth/handle-token', [App\Http\Controllers\Auth\OAuthController::class, 'handleToken'])->name('oauth.handle-token');

// Rutas de autenticación tradicional (Legacy - para usuarios antiguos)
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

// Rutas de verificación 2FA
Route::get('/two-factor', [App\Http\Controllers\Auth\TwoFactorController::class, 'show'])->name('two-factor.show');
Route::post('/two-factor/verify', [App\Http\Controllers\Auth\TwoFactorController::class, 'verify'])->name('two-factor.verify');

// Rutas para administradores
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Gestión de usuarios
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Gestión de sitios web
    Route::get('/websites', [App\Http\Controllers\Admin\WebsiteController::class, 'index'])->name('websites.index');
    Route::get('/websites/create', [App\Http\Controllers\Admin\WebsiteController::class, 'create'])->name('websites.create');
    Route::post('/websites', [App\Http\Controllers\Admin\WebsiteController::class, 'store'])->name('websites.store');
    Route::get('/websites/{website}', [App\Http\Controllers\Admin\WebsiteController::class, 'show'])->name('websites.show');
    Route::get('/websites/{website}/edit', [App\Http\Controllers\Admin\WebsiteController::class, 'edit'])->name('websites.edit');
    Route::put('/websites/{website}', [App\Http\Controllers\Admin\WebsiteController::class, 'update'])->name('websites.update');
    Route::delete('/websites/{website}', [App\Http\Controllers\Admin\WebsiteController::class, 'destroy'])->name('websites.destroy');
    Route::patch('/websites/{website}/toggle-status', [App\Http\Controllers\Admin\WebsiteController::class, 'toggleStatus'])->name('websites.toggle-status');

    // Gestión de páginas
    Route::get('/websites/{website}/pages', [AdminPageController::class, 'index'])->name('pages.index');
    Route::get('/websites/{website}/pages/create', [AdminPageController::class, 'create'])->name('pages.create');
    Route::post('/websites/{website}/pages', [AdminPageController::class, 'store'])->name('pages.store');
    Route::get('/websites/{website}/pages/{page}/editor', [AdminPageController::class, 'editor'])->name('pages.editor');
    Route::post('/websites/{website}/pages/{page}/save-editor', [AdminPageController::class, 'saveEditor'])->name('pages.save-editor');
    Route::get('/websites/{website}/pages/{page}/edit', [AdminPageController::class, 'edit'])->name('pages.edit');

    // Importación de contenido
    Route::get('/websites/{website}/import/pages/{templateSlug}', [ContentImportController::class, 'showImportPages'])->name('websites.import.pages');
    Route::post('/websites/{website}/import/pages/{templateSlug}', [ContentImportController::class, 'importPages'])->name('websites.import.pages');
    Route::get('/websites/{website}/import/blocks/{templateSlug}', [ContentImportController::class, 'showImportBlocks'])->name('websites.import.blocks');
    Route::post('/websites/{website}/import/blocks/{templateSlug}', [ContentImportController::class, 'importBlocks'])->name('websites.import.blocks');
    Route::get('/websites/{website}/pages/{page}', [AdminPageController::class, 'show'])->name('pages.show');
    Route::put('/websites/{website}/pages/{page}', [AdminPageController::class, 'update'])->name('pages.update');
    Route::delete('/websites/{website}/pages/{page}', [AdminPageController::class, 'destroy'])->name('pages.destroy');

    // Gestión de plantillas
    Route::get('/templates', [App\Http\Controllers\Admin\TemplateController::class, 'index'])->name('templates.index');
    Route::get('/templates/create', [App\Http\Controllers\Admin\TemplateController::class, 'create'])->name('templates.create');
    Route::post('/templates', [App\Http\Controllers\Admin\TemplateController::class, 'store'])->name('templates.store');
    Route::get('/templates/{template}', [App\Http\Controllers\Admin\TemplateController::class, 'show'])->name('templates.show');
    Route::get('/templates/{template}/edit', [App\Http\Controllers\Admin\TemplateController::class, 'edit'])->name('templates.edit');
    Route::put('/templates/{template}', [App\Http\Controllers\Admin\TemplateController::class, 'update'])->name('templates.update');
    Route::delete('/templates/{template}', [App\Http\Controllers\Admin\TemplateController::class, 'destroy'])->name('templates.destroy');
    Route::patch('/templates/{template}/toggle-status', [App\Http\Controllers\Admin\TemplateController::class, 'toggleStatus'])->name('templates.toggle-status');

    // Gestión de planes
    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/create', [PlanController::class, 'create'])->name('plans.create');
    Route::post('/plans', [PlanController::class, 'store'])->name('plans.store');
    Route::get('/plans/{plan}', [PlanController::class, 'show'])->name('plans.show');
    Route::get('/plans/{plan}/edit', [PlanController::class, 'edit'])->name('plans.edit');
    Route::put('/plans/{plan}', [PlanController::class, 'update'])->name('plans.update');
    Route::delete('/plans/{plan}', [PlanController::class, 'destroy'])->name('plans.destroy');
    Route::patch('/plans/{plan}/toggle-status', [PlanController::class, 'toggleStatus'])->name('plans.toggle-status');

    // Gestión de categorías
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [AdminCategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
    Route::patch('/categories/{category}/toggle-status', [AdminCategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

    // Gestión de etiquetas
    Route::get('/tags', [AdminTagController::class, 'index'])->name('tags.index');
    Route::get('/tags/create', [AdminTagController::class, 'create'])->name('tags.create');
    Route::post('/tags', [AdminTagController::class, 'store'])->name('tags.store');
    // TODO: Crear vistas para estas rutas
    // Route::get('/tags/{tag}', [AdminTagController::class, 'show'])->name('tags.show');
    // Route::get('/tags/{tag}/edit', [AdminTagController::class, 'edit'])->name('tags.edit');
    Route::put('/tags/{tag}', [AdminTagController::class, 'update'])->name('tags.update');
    Route::delete('/tags/{tag}', [AdminTagController::class, 'destroy'])->name('tags.destroy');
    Route::patch('/tags/{tag}/toggle-status', [AdminTagController::class, 'toggleStatus'])->name('tags.toggle-status');

    // Gestión de componentes compartidos
    Route::get('/components', [ComponentController::class, 'index'])->name('components.index');
    // TODO: Crear vistas para estas rutas
    // Route::get('/components/{component}', [ComponentController::class, 'show'])->name('components.show');
    // Route::get('/components/{component}/edit', [ComponentController::class, 'edit'])->name('components.edit');
    Route::put('/components/{component}', [ComponentController::class, 'update'])->name('components.update');
    Route::delete('/components/{component}', [ComponentController::class, 'destroy'])->name('components.destroy');
    Route::patch('/components/{component}/toggle-status', [ComponentController::class, 'toggleStatus'])->name('components.toggle-status');

    // Gestión de dominios
    Route::get('/domains', [DomainController::class, 'index'])->name('domains.index');
    // TODO: Crear vistas para estas rutas
    // Route::get('/domains/{domain}', [DomainController::class, 'show'])->name('domains.show');
    // Route::get('/domains/{domain}/edit', [DomainController::class, 'edit'])->name('domains.edit');
    Route::put('/domains/{domain}', [DomainController::class, 'update'])->name('domains.update');
    Route::delete('/domains/{domain}', [DomainController::class, 'destroy'])->name('domains.destroy');
    Route::patch('/domains/{domain}/toggle-status', [DomainController::class, 'toggleStatus'])->name('domains.toggle-status');
    Route::patch('/domains/{domain}/verify', [DomainController::class, 'verify'])->name('domains.verify');
    Route::patch('/domains/{domain}/enable-ssl', [DomainController::class, 'enableSSL'])->name('domains.enable-ssl');

    // Gestión de media
    Route::get('/media', [MediaController::class, 'index'])->name('media.index');
    // TODO: Crear vistas para estas rutas
    // Route::get('/media/{mediaFile}', [MediaController::class, 'show'])->name('media.show');
    // Route::get('/media/{mediaFile}/edit', [MediaController::class, 'edit'])->name('media.edit');
    Route::put('/media/{mediaFile}', [MediaController::class, 'update'])->name('media.update');
    Route::delete('/media/{mediaFile}', [MediaController::class, 'destroy'])->name('media.destroy');
    Route::patch('/media/{mediaFile}/toggle-status', [MediaController::class, 'toggleStatus'])->name('media.toggle-status');
    Route::get('/media/{mediaFile}/url', [MediaController::class, 'getFileUrl'])->name('media.url');

    // Reportes y estadísticas
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');

    // Configuraciones
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');

    // Configuración de plantillas
    Route::get('/websites/{website}/template-configuration', [App\Http\Controllers\Admin\TemplateConfigurationController::class, 'index'])->name('template-configuration.index');
    Route::get('/websites/{website}/template-configuration/{templateSlug}', [App\Http\Controllers\Admin\TemplateConfigurationController::class, 'show'])->name('template-configuration.show');
    Route::put('/websites/{website}/template-configuration/{templateSlug}', [App\Http\Controllers\Admin\TemplateConfigurationController::class, 'update'])->name('template-configuration.update');
    Route::post('/websites/{website}/template-configuration/{templateSlug}/customization', [App\Http\Controllers\Admin\TemplateConfigurationController::class, 'updateCustomization'])->name('template-configuration.update-customization');
    Route::post('/websites/{website}/template-configuration/{templateSlug}/settings', [App\Http\Controllers\Admin\TemplateConfigurationController::class, 'updateSettings'])->name('template-configuration.update-settings');
    Route::post('/websites/{website}/template-configuration/{templateSlug}/reset', [App\Http\Controllers\Admin\TemplateConfigurationController::class, 'reset'])->name('template-configuration.reset');
});

// Rutas para usuarios creadores
Route::middleware(['auth', 'role:creator'])->prefix('creator')->name('creator.')->group(function () {
    // Ruta raíz de creator - redirige al dashboard
    Route::get('/', function () {
        return redirect()->route('creator.dashboard');
    });

    // Selección de sitio web (sin middleware de sitio seleccionado)
    Route::get('/select-website', [App\Http\Controllers\Creator\SelectWebsiteController::class, 'index'])->name('select-website');
    Route::post('/select-website', [App\Http\Controllers\Creator\SelectWebsiteController::class, 'store'])->name('select-website.store');

    // Rutas que requieren sitio web seleccionado
    Route::middleware(['require.selected.website'])->group(function () {
        Route::get('/dashboard', [CreatorDashboard::class, 'index'])->name('dashboard');

        // Rutas de websites que usan sesión
        Route::get('websites', [WebsiteController::class, 'index'])->name('websites.index');
        Route::get('websites/create', [WebsiteController::class, 'create'])->name('websites.create');
        Route::post('websites', [WebsiteController::class, 'store'])->name('websites.store');
        Route::get('websites/show', function () {
            $website = \App\Models\Website::find(session('selected_website_id'));
            if (!$website) {
                return redirect()->route('creator.select-website');
            }
            app(\App\Http\Controllers\WebsiteController::class)->authorize('view', $website);
            $pages = $website->pages()->orderBy('sort_order')->get();
            return view('creator.websites.show', compact('website', 'pages'));
        })->name('websites.show');
        Route::delete('websites/{website}', [WebsiteController::class, 'destroy'])->name('websites.destroy');

        // Configuración general del sitio (dentro de config)
        Route::get('config/general', [WebsiteController::class, 'edit'])->name('config.general');
        Route::put('config/general', [WebsiteController::class, 'update'])->name('config.general.update');
        Route::patch('websites/{website}/toggle-publish', [WebsiteController::class, 'togglePublish'])->name('websites.toggle-publish');

        // Gestión de dominios personalizados
        Route::get('config/domain', [App\Http\Controllers\DomainController::class, 'index'])->name('creator.config.domain');
        Route::post('config/domain', [App\Http\Controllers\DomainController::class, 'store'])->name('domains.store');
        Route::post('config/domain/{domain}/verify', [App\Http\Controllers\DomainController::class, 'verify'])->name('domains.verify');
        Route::patch('config/domain/{domain}/set-primary', [App\Http\Controllers\DomainController::class, 'setPrimary'])->name('domains.set-primary');
        Route::delete('config/domain/{domain}', [App\Http\Controllers\DomainController::class, 'destroy'])->name('domains.destroy');

        // Rutas de páginas (usan sesión en lugar de parámetro website)
        Route::get('pages', [App\Http\Controllers\Creator\PageController::class, 'index'])->name('pages.index');
        Route::get('pages/create', [App\Http\Controllers\Creator\PageController::class, 'create'])->name('pages.create');
        Route::post('pages', [App\Http\Controllers\Creator\PageController::class, 'store'])->name('pages.store');
        Route::get('pages/{page}', [App\Http\Controllers\Creator\PageController::class, 'show'])->name('pages.show');
        Route::get('pages/{page}/edit', [App\Http\Controllers\Creator\PageController::class, 'edit'])->name('pages.edit');
        Route::put('pages/{page}', [App\Http\Controllers\Creator\PageController::class, 'update'])->name('pages.update');
        Route::delete('pages/{page}', [App\Http\Controllers\Creator\PageController::class, 'destroy'])->name('pages.destroy');
        Route::get('pages/{page}/editor', [PageController::class, 'editor'])->name('pages.editor');
        Route::post('pages/{page}/save', [PageController::class, 'saveContent'])->name('pages.save');
        Route::post('pages/{page}/set-home', [App\Http\Controllers\Creator\PageController::class, 'setHome'])->name('pages.set-home');

        // Importación de páginas prediseñadas
        Route::get('pages/import/{website}', [App\Http\Controllers\Creator\PageController::class, 'showImport'])->name('pages.import');
        Route::post('pages/import/{website}', [App\Http\Controllers\Creator\PageController::class, 'importPages'])->name('pages.import');
        Route::get('pages/template-pages/{website}', [App\Http\Controllers\Creator\PageController::class, 'getTemplatePages'])->name('pages.template-pages');

        // Importación universal de páginas por categoría
        Route::get('pages/import-categories/{website}', [App\Http\Controllers\UniversalPageImportController::class, 'showCategories'])->name('pages.import.categories');
        Route::get('pages/import-category/{website}/{category}', [App\Http\Controllers\UniversalPageImportController::class, 'showPagesForCategory'])->name('pages.import.category');
        Route::get('pages/import-template/{website}/{template}', [App\Http\Controllers\UniversalPageImportController::class, 'showTemplatePages'])->name('pages.import.template');
        Route::post('pages/import-store/{website}', [App\Http\Controllers\UniversalPageImportController::class, 'importPages'])->name('pages.import.store');

        // Vista previa de páginas
        Route::get('pages/preview/{website}/{pageSlug}', [App\Http\Controllers\UniversalPageImportController::class, 'previewPage'])->name('pages.preview');
        Route::get('pages/preview/{website}/{pageSlug}/{templateSlug}', [App\Http\Controllers\UniversalPageImportController::class, 'previewPage'])->name('pages.preview.template');

        // Vista previa del navegador de páginas
        Route::get('pages/navigator-preview/{pageSlug}', [App\Http\Controllers\PageNavigatorPreviewController::class, 'show'])->name('pages.navigator-preview');

        // Vista previa limpia (sin plantilla de administrador)
        Route::get('pages/preview/{pageSlug}', [App\Http\Controllers\PagePreviewController::class, 'show'])->name('pages.preview.clean');

        // Rutas AJAX para importación universal
        Route::get('api/pages/recommended/{category}', [App\Http\Controllers\UniversalPageImportController::class, 'getRecommendedPages'])->name('api.pages.recommended');
        Route::get('api/pages/templates/{category}', [App\Http\Controllers\UniversalPageImportController::class, 'getTemplatesForCategory'])->name('api.pages.templates');
        Route::get('api/pages/template-pages/{template}', [App\Http\Controllers\UniversalPageImportController::class, 'getTemplatePages'])->name('api.pages.template-pages');
        Route::get('api/pages/all-available', [App\Http\Controllers\UniversalPageImportController::class, 'getAllAvailablePages'])->name('api.pages.all-available');


        // Rutas de menús (usan sesión en lugar de parámetro website)
        Route::resource('menus', App\Http\Controllers\Creator\MenuController::class);
        Route::post('menus/{menu}/items', [App\Http\Controllers\Creator\MenuController::class, 'storeItem'])->name('menus.items.store');
        Route::put('menus/{menu}/items/{menuItem}', [App\Http\Controllers\Creator\MenuController::class, 'updateItem'])->name('menus.items.update');
        Route::delete('menus/{menu}/items/{menuItem}', [App\Http\Controllers\Creator\MenuController::class, 'destroyItem'])->name('menus.items.destroy');
        Route::post('menus/{menu}/update-order', [App\Http\Controllers\Creator\MenuController::class, 'updateOrder'])->name('menus.update-order');

        // Rutas de versiones de páginas
        Route::get('websites/{website}/pages/{page}/versions', [PageController::class, 'versions'])->name('pages.versions');
        Route::get('websites/{website}/pages/{page}/versions/{version}', [PageController::class, 'showVersion'])->name('pages.version-show');
        Route::post('websites/{website}/pages/{page}/versions/{version}/restore', [PageController::class, 'restoreVersion'])->name('pages.version-restore');
        Route::get('websites/{website}/pages/{page}/compare/{version1}/{version2}', [PageController::class, 'compareVersions'])->name('pages.compare-versions');

        // Rutas de plantillas
        Route::get('templates', [TemplateController::class, 'index'])->name('templates.index');
        Route::get('templates/{slug}', [TemplateController::class, 'show'])->name('templates.show');
        Route::get('templates/{slug}/preview', [TemplateController::class, 'preview'])->name('templates.preview');
        Route::get('templates/{slug}/blog', [TemplateController::class, 'blog'])->name('templates.blog');
        Route::get('templates/{slug}/contacto', [TemplateController::class, 'contacto'])->name('templates.contacto');
        Route::post('websites/{website}/templates/{slug}/apply', [TemplateController::class, 'apply'])->name('templates.apply');

        // Rutas del blog (usan sesión en lugar de parámetro website)
        Route::get('blog', [App\Http\Controllers\Creator\BlogPostController::class, 'index'])->name('blog.index');
        Route::get('blog/create', [App\Http\Controllers\Creator\BlogPostController::class, 'create'])->name('blog.create');
        Route::post('blog', [App\Http\Controllers\Creator\BlogPostController::class, 'store'])->name('blog.store');
        Route::get('blog/{blogPost}', [App\Http\Controllers\Creator\BlogPostController::class, 'show'])->name('blog.show');
        Route::get('blog/{blogPost}/edit', [App\Http\Controllers\Creator\BlogPostController::class, 'edit'])->name('blog.edit');
        Route::put('blog/{blogPost}', [App\Http\Controllers\Creator\BlogPostController::class, 'update'])->name('blog.update');
        Route::delete('blog/{blogPost}', [App\Http\Controllers\Creator\BlogPostController::class, 'destroy'])->name('blog.destroy');

        // API para posts del blog (para el componente dinámico)
        Route::get('api/websites/{website}/blog-posts', [App\Http\Controllers\Creator\BlogPostController::class, 'apiIndex'])->name('api.blog.index');

        // Rutas de categorías (usan sesión en lugar de parámetro website)
        Route::get('categories', [App\Http\Controllers\Creator\CategoryController::class, 'index'])->name('categories.index');
        Route::get('categories/create', [App\Http\Controllers\Creator\CategoryController::class, 'create'])->name('categories.create');
        Route::post('categories', [App\Http\Controllers\Creator\CategoryController::class, 'store'])->name('categories.store');
        // TODO: Crear vista para esta ruta
        // Route::get('categories/{category}/edit', [App\Http\Controllers\Creator\CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{category}', [App\Http\Controllers\Creator\CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [App\Http\Controllers\Creator\CategoryController::class, 'destroy'])->name('categories.destroy');

        // Rutas de etiquetas
        Route::get('websites/{website}/tags', [App\Http\Controllers\Creator\TagController::class, 'index'])->name('tags.index');
        Route::get('websites/{website}/tags/create', [App\Http\Controllers\Creator\TagController::class, 'create'])->name('tags.create');
        Route::post('websites/{website}/tags', [App\Http\Controllers\Creator\TagController::class, 'store'])->name('tags.store');
        // TODO: Crear vista para esta ruta
        // Route::get('websites/{website}/tags/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit');
        Route::put('websites/{website}/tags/{tag}', [TagController::class, 'update'])->name('tags.update');
        Route::delete('websites/{website}/tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');

        // Rutas de componentes compartidos
        Route::get('websites/{website}/components', [SharedComponentController::class, 'index'])->name('components.index');
        Route::get('websites/{website}/components/create', [SharedComponentController::class, 'create'])->name('components.create');
        Route::post('websites/{website}/components', [SharedComponentController::class, 'store'])->name('components.store');
        Route::get('websites/{website}/components/{component}', [SharedComponentController::class, 'show'])->name('components.show');
        Route::get('websites/{website}/components/{component}/edit', [SharedComponentController::class, 'edit'])->name('components.edit');
        Route::put('websites/{website}/components/{component}', [SharedComponentController::class, 'update'])->name('components.update');
        Route::delete('websites/{website}/components/{component}', [SharedComponentController::class, 'destroy'])->name('components.destroy');
        Route::get('websites/{website}/components/{component}/duplicate', [SharedComponentController::class, 'duplicate'])->name('components.duplicate');
        Route::patch('websites/{website}/components/{component}/toggle-status', [SharedComponentController::class, 'toggleStatus'])->name('components.toggle-status');
        Route::get('websites/{website}/components/{component}/editor', [SharedComponentController::class, 'editor'])->name('components.editor');
        Route::post('websites/{website}/components/{component}/save', [SharedComponentController::class, 'saveContent'])->name('components.save');

        // Rutas de biblioteca multimedia (usan sesión en lugar de parámetro website)
        Route::get('media', [App\Http\Controllers\Creator\MediaFileController::class, 'index'])->name('media.index');
        Route::post('media', [App\Http\Controllers\Creator\MediaFileController::class, 'store'])->name('media.store');
        Route::delete('media/{mediaFile}', [App\Http\Controllers\Creator\MediaFileController::class, 'destroy'])->name('media.destroy');
        Route::get('media/{mediaFile}/url', [App\Http\Controllers\Creator\MediaFileController::class, 'getFileUrl'])->name('media.url');

        // Rutas de SEO (usan sesión en lugar de parámetro website)
        Route::get('seo', [App\Http\Controllers\Creator\SeoController::class, 'index'])->name('seo.index');
        Route::get('seo/edit', [App\Http\Controllers\Creator\SeoController::class, 'edit'])->name('seo.edit');
        Route::put('seo', [App\Http\Controllers\Creator\SeoController::class, 'update'])->name('seo.update');
        Route::get('websites/{website}/seo/sitemap', [SeoController::class, 'sitemap'])->name('seo.sitemap');
        Route::get('websites/{website}/seo/robots', [SeoController::class, 'robots'])->name('seo.robots');
        Route::post('websites/{website}/seo/generate-sitemap', [SeoController::class, 'generateSitemap'])->name('seo.generate-sitemap');
        Route::get('websites/{website}/seo/preview/{page?}', [SeoController::class, 'preview'])->name('seo.preview');

        // Rutas de formularios (usan sesión en lugar de parámetro website)
        Route::get('forms', [App\Http\Controllers\Creator\FormController::class, 'index'])->name('forms.index');
        Route::get('forms/create', [App\Http\Controllers\Creator\FormController::class, 'create'])->name('forms.create');
        Route::post('forms', [App\Http\Controllers\Creator\FormController::class, 'store'])->name('forms.store');
        Route::get('forms/{form}/edit', [App\Http\Controllers\Creator\FormController::class, 'edit'])->name('forms.edit');
        Route::get('forms/{form}/builder', [App\Http\Controllers\Creator\FormController::class, 'builder'])->name('forms.builder');
        Route::get('forms/{form}/submissions', [App\Http\Controllers\Creator\FormController::class, 'submissions'])->name('forms.submissions');
        Route::get('forms/{form}/submissions/{submission}', [App\Http\Controllers\Creator\FormController::class, 'showSubmission'])->name('forms.show-submission');
        Route::put('forms/{form}', [App\Http\Controllers\Creator\FormController::class, 'update'])->name('forms.update');
        Route::delete('forms/{form}', [App\Http\Controllers\Creator\FormController::class, 'destroy'])->name('forms.destroy');

        // Rutas API para el constructor de formularios
        Route::post('forms/{form}/fields', [App\Http\Controllers\Creator\FormController::class, 'addField'])->name('forms.add-field');
        Route::put('forms/{form}/fields/{field}', [App\Http\Controllers\Creator\FormController::class, 'updateField'])->name('forms.update-field');
        Route::delete('forms/{form}/fields/{field}', [App\Http\Controllers\Creator\FormController::class, 'deleteField'])->name('forms.delete-field');
        Route::post('forms/{form}/fields/reorder', [App\Http\Controllers\Creator\FormController::class, 'reorderFields'])->name('forms.reorder-fields');

        // Rutas de vista previa (usan el sitio de la sesión)
        Route::get('preview', [App\Http\Controllers\Creator\PreviewController::class, 'index'])->name('preview.index');
        Route::get('preview/pages/{page}', [App\Http\Controllers\Creator\PreviewController::class, 'page'])->name('preview.page');
        Route::get('preview/blog', [App\Http\Controllers\Creator\PreviewController::class, 'blog'])->name('preview.blog');
        Route::get('preview/blog/{blogPost}', [App\Http\Controllers\Creator\PreviewController::class, 'blogPost'])->name('preview.blog-post');
        Route::get('preview/contact', [App\Http\Controllers\Creator\PreviewController::class, 'contact'])->name('preview.contact');

        // Ruta de vista previa de plantillas
        // Ruta de preview movida arriba con las otras rutas de templates

        // Rutas de comentarios (usan sesión)
        Route::get('comments', [App\Http\Controllers\Creator\CommentController::class, 'index'])->name('comments.index');
        // TODO: Crear vista para esta ruta
        // Route::get('comments/{comment}', [App\Http\Controllers\Creator\CommentController::class, 'show'])->name('comments.show');
        Route::post('comments/{comment}/approve', [App\Http\Controllers\Creator\CommentController::class, 'approve'])->name('comments.approve');
        Route::post('comments/{comment}/unapprove', [App\Http\Controllers\Creator\CommentController::class, 'unapprove'])->name('comments.unapprove');
        Route::post('comments/{comment}/mark-spam', [App\Http\Controllers\Creator\CommentController::class, 'markAsSpam'])->name('comments.mark-spam');
        Route::post('comments/{comment}/mark-not-spam', [App\Http\Controllers\Creator\CommentController::class, 'markAsNotSpam'])->name('comments.mark-not-spam');
        Route::delete('comments/{comment}', [App\Http\Controllers\Creator\CommentController::class, 'destroy'])->name('comments.destroy');
        Route::post('comments/bulk-approve', [App\Http\Controllers\Creator\CommentController::class, 'bulkApprove'])->name('comments.bulk-approve');
        Route::post('comments/bulk-delete', [App\Http\Controllers\Creator\CommentController::class, 'bulkDelete'])->name('comments.bulk-delete');

        // TODO: Crear vistas para estas rutas de formularios de blog
        // Route::get('websites/{website}/blog/{blogPost}/forms', [App\Http\Controllers\Creator\FormController::class, 'blogIndex'])->name('forms.blog-index');
        // Route::get('websites/{website}/blog/{blogPost}/forms/create', [App\Http\Controllers\Creator\FormController::class, 'create'])->name('forms.blog-create');
        // Route::get('websites/{website}/blog/{blogPost}/forms/{form}/builder', [App\Http\Controllers\Creator\FormController::class, 'blogBuilder'])->name('forms.blog-builder');

        // Rutas de configuración de dominios (usan sesión)
        Route::get('config/domain', [App\Http\Controllers\Creator\DomainConfigController::class, 'index'])->name('config.domain');
        Route::post('config/domain', [App\Http\Controllers\Creator\DomainConfigController::class, 'store'])->name('config.domain.store');
        Route::put('config/domain/{domain}', [App\Http\Controllers\Creator\DomainConfigController::class, 'update'])->name('config.domain.update');
        Route::delete('config/domain/{domain}', [App\Http\Controllers\Creator\DomainConfigController::class, 'destroy'])->name('config.domain.destroy');
        Route::post('config/domain/{domain}/verify', [App\Http\Controllers\Creator\DomainConfigController::class, 'verify'])->name('config.domain.verify');

        // Rutas de configuración de seguridad (usan sesión)
        Route::get('config/security', [App\Http\Controllers\Creator\SecurityConfigController::class, 'index'])->name('config.security');
        Route::post('config/security/ssl', [App\Http\Controllers\Creator\SecurityConfigController::class, 'updateSsl'])->name('config.security.ssl');
        Route::post('config/security/generate-ssl', [App\Http\Controllers\Creator\SecurityConfigController::class, 'generateSsl'])->name('config.security.generate-ssl');
        Route::post('config/security/update', [App\Http\Controllers\Creator\SecurityConfigController::class, 'updateSecurity'])->name('config.security.update');

        // Rutas de configuración de API (usan sesión)
        Route::get('config/api', [App\Http\Controllers\Creator\ApiConfigController::class, 'show'])->name('config.api');
        Route::put('config/api', [App\Http\Controllers\Creator\ApiConfigController::class, 'update'])->name('config.api.update');
        Route::post('config/api/test', [App\Http\Controllers\Creator\ApiConfigController::class, 'test'])->name('config.api.test');

        // API para obtener la página actual
        Route::post('api/current-page', [App\Http\Controllers\Creator\ApiController::class, 'getCurrentPage'])->name('api.current-page');

        // Rutas de tienda en línea (usan sesión en lugar de parámetro website)
        Route::get('store/products', [App\Http\Controllers\Creator\StoreController::class, 'products'])->name('store.products');
        Route::get('store/categories', [App\Http\Controllers\Creator\StoreController::class, 'categories'])->name('store.categories');
        Route::get('store/orders', [App\Http\Controllers\Creator\StoreController::class, 'orders'])->name('store.orders');

        // Rutas de usuarios (usan sesión)
        Route::get('users', [App\Http\Controllers\Creator\UserController::class, 'index'])->name('users.index');

        // Rutas de integraciones (usan sesión)
        Route::get('integrations/epayco', [App\Http\Controllers\Creator\IntegrationController::class, 'epayco'])->name('integrations.epayco');
        Route::post('integrations/epayco', [App\Http\Controllers\Creator\IntegrationController::class, 'epaycoStore'])->name('integrations.epayco.store');
        Route::get('integrations/admin-negocios', [App\Http\Controllers\Creator\IntegrationController::class, 'adminNegocios'])->name('integrations.admin-negocios');
        Route::post('integrations/admin-negocios', [App\Http\Controllers\Creator\IntegrationController::class, 'adminNegociosStore'])->name('integrations.admin-negocios.store');
        Route::post('integrations/admin-negocios/test-api', [App\Http\Controllers\Creator\IntegrationController::class, 'testApiConnection'])->name('integrations.admin-negocios.test-api');

        // Configuración de plantillas para creator (rutas simplificadas)
        Route::get('template-configuration', [App\Http\Controllers\Creator\TemplateConfigurationController::class, 'index'])->name('template-configuration.index');
        Route::get('template-configuration/{templateSlug}', [App\Http\Controllers\Creator\TemplateConfigurationController::class, 'show'])->name('template-configuration.show');
        Route::put('template-configuration/{templateSlug}', [App\Http\Controllers\Creator\TemplateConfigurationController::class, 'update'])->name('template-configuration.update');
        Route::post('template-configuration/{templateSlug}/customization', [App\Http\Controllers\Creator\TemplateConfigurationController::class, 'updateCustomization'])->name('template-configuration.update-customization');
        Route::post('template-configuration/{templateSlug}/settings', [App\Http\Controllers\Creator\TemplateConfigurationController::class, 'updateSettings'])->name('template-configuration.update-settings');
        Route::post('template-configuration/{templateSlug}/reset', [App\Http\Controllers\Creator\TemplateConfigurationController::class, 'reset'])->name('template-configuration.reset');
        Route::post('template-configuration/{templateSlug}/remove-logo', [App\Http\Controllers\Creator\TemplateConfigurationController::class, 'removeLogo'])->name('template-configuration.remove-logo');
    });
});

// Rutas de pago (sin autenticación para permitir callbacks de ePayco)
Route::get('/response', [App\Http\Controllers\PaymentController::class, 'handleResponse'])->name('payment.response');
Route::get('/payment/success', [App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/pending', [App\Http\Controllers\PaymentController::class, 'pending'])->name('payment.pending');
Route::get('/payment/error', [App\Http\Controllers\PaymentController::class, 'error'])->name('payment.error');

// ==========================================
// RUTAS PÚBLICAS DE TIENDA - Checkout y Autenticación de Clientes
// ==========================================

// Autenticación de clientes desde la tienda pública
Route::prefix('customer')->name('customer.')->group(function () {
    Route::post('/login', [App\Http\Controllers\CustomerAuthController::class, 'login'])->name('login');
    Route::post('/register', [App\Http\Controllers\CustomerAuthController::class, 'register'])->name('register');
    Route::post('/logout', [App\Http\Controllers\CustomerAuthController::class, 'logout'])->name('logout');
    Route::get('/check', [App\Http\Controllers\CustomerAuthController::class, 'check'])->name('check');
    Route::get('/me', [App\Http\Controllers\CustomerAuthController::class, 'me'])->name('me');
    Route::get('/addresses', [App\Http\Controllers\CustomerProfileController::class, 'apiAddresses'])->name('addresses.index');
    Route::post('/addresses', [App\Http\Controllers\CustomerProfileController::class, 'apiStoreAddress'])->name('addresses.store');
});

// Rutas de checkout y perfil de cliente público
Route::prefix('{website:slug}')->name('customer.')->group(function () {
    // Checkout
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/order/{orderNumber}', [App\Http\Controllers\CheckoutController::class, 'showOrder'])->name('order.show')->middleware('prevent.back');

    // Perfil de cliente (requieren autenticación)
    Route::get('/my-orders', [App\Http\Controllers\CheckoutController::class, 'myOrders'])->name('my-orders')->middleware('prevent.back');
    Route::get('/profile', [App\Http\Controllers\CustomerProfileController::class, 'index'])->name('profile')->middleware('prevent.back');
    Route::put('/profile', [App\Http\Controllers\CustomerProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\CustomerProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/addresses', [App\Http\Controllers\CustomerProfileController::class, 'addresses'])->name('addresses')->middleware('prevent.back');
    Route::post('/addresses', [App\Http\Controllers\CustomerProfileController::class, 'storeAddress'])->name('addresses.store');
    Route::put('/addresses/{id}', [App\Http\Controllers\CustomerProfileController::class, 'updateAddress'])->name('addresses.update');
    Route::delete('/addresses/{id}', [App\Http\Controllers\CustomerProfileController::class, 'deleteAddress'])->name('addresses.delete');
});

// Redirección después del login
Route::get('/home', function () {
    if (auth()->check() && auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('creator.select-website');
})->middleware('auth');

// Página de bienvenida (debe ir antes de las rutas con slug)
// COMENTADO: Esta ruta sobrescribía showRoot()
// Route::get('/', function () {
//     return view('welcome');
// })->name('welcome');

// Rutas específicas para plantillas
Route::get('/template/{template}', [App\Http\Controllers\TemplatePreviewController::class, 'index'])->name('template.preview');
Route::get('/template/{template}/blog', [App\Http\Controllers\TemplatePreviewController::class, 'blog'])->name('template.blog');
Route::get('/template/{template}/contacto', [App\Http\Controllers\TemplatePreviewController::class, 'contact'])->name('template.contact');
Route::get('/template/{template}/{page}', [App\Http\Controllers\TemplatePageController::class, 'show'])->name('template.page');

// Rutas específicas para academia online
Route::get('/academia-online', [App\Http\Controllers\TemplatePreviewController::class, 'index'])->name('academia.index');
Route::get('/academia-online/blog', [App\Http\Controllers\TemplatePreviewController::class, 'blog'])->name('academia.blog');
Route::get('/academia-online/contacto', [App\Http\Controllers\TemplatePreviewController::class, 'contact'])->name('academia.contacto');

// ==========================================
// RUTAS PARA CREADORWEB.EME10.COM (con 2 segmentos) - DEBEN IR PRIMERO
// ==========================================
// Rutas públicas del sitio web CON 2 segmentos: /website/page
Route::get('/{website:slug}/{page:slug}', [WebsiteController::class, 'showPagePublic'])->name('website.page.show');
Route::get('/{website:slug}/blog', [App\Http\Controllers\Creator\BlogPostController::class, 'publicIndex'])->name('website.blog.index');
Route::get('/{website:slug}/blog/{blogPost:slug}', [App\Http\Controllers\Creator\BlogPostController::class, 'publicShow'])->name('website.blog.show');

// Ruta del sitio web principal (homepage) - 1 segmento: /website
// Esta ruta maneja tanto creadorweb.eme10.com/website como dominios personalizados/pagina
Route::get('/{slug}', [WebsiteController::class, 'showPageOrWebsite'])
    ->name('website.show')
    ->where('slug', '^(?!creator|admin|login|register|logout|bienvenida|api|storage|css|js|fonts|images|blog|template|academia-online).*');
