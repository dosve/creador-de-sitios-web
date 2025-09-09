<?php

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
use App\Http\Controllers\Admin\DomainController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\PageController as AdminPageController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

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
    Route::get('/tags/{tag}', [AdminTagController::class, 'show'])->name('tags.show');
    Route::get('/tags/{tag}/edit', [AdminTagController::class, 'edit'])->name('tags.edit');
    Route::put('/tags/{tag}', [AdminTagController::class, 'update'])->name('tags.update');
    Route::delete('/tags/{tag}', [AdminTagController::class, 'destroy'])->name('tags.destroy');
    Route::patch('/tags/{tag}/toggle-status', [AdminTagController::class, 'toggleStatus'])->name('tags.toggle-status');

    // Gestión de componentes compartidos
    Route::get('/components', [ComponentController::class, 'index'])->name('components.index');
    Route::get('/components/{component}', [ComponentController::class, 'show'])->name('components.show');
    Route::get('/components/{component}/edit', [ComponentController::class, 'edit'])->name('components.edit');
    Route::put('/components/{component}', [ComponentController::class, 'update'])->name('components.update');
    Route::delete('/components/{component}', [ComponentController::class, 'destroy'])->name('components.destroy');
    Route::patch('/components/{component}/toggle-status', [ComponentController::class, 'toggleStatus'])->name('components.toggle-status');

    // Gestión de dominios
    Route::get('/domains', [DomainController::class, 'index'])->name('domains.index');
    Route::get('/domains/{domain}', [DomainController::class, 'show'])->name('domains.show');
    Route::get('/domains/{domain}/edit', [DomainController::class, 'edit'])->name('domains.edit');
    Route::put('/domains/{domain}', [DomainController::class, 'update'])->name('domains.update');
    Route::delete('/domains/{domain}', [DomainController::class, 'destroy'])->name('domains.destroy');
    Route::patch('/domains/{domain}/toggle-status', [DomainController::class, 'toggleStatus'])->name('domains.toggle-status');
    Route::patch('/domains/{domain}/verify', [DomainController::class, 'verify'])->name('domains.verify');
    Route::patch('/domains/{domain}/enable-ssl', [DomainController::class, 'enableSSL'])->name('domains.enable-ssl');

    // Gestión de media
    Route::get('/media', [MediaController::class, 'index'])->name('media.index');
    Route::get('/media/{mediaFile}', [MediaController::class, 'show'])->name('media.show');
    Route::get('/media/{mediaFile}/edit', [MediaController::class, 'edit'])->name('media.edit');
    Route::put('/media/{mediaFile}', [MediaController::class, 'update'])->name('media.update');
    Route::delete('/media/{mediaFile}', [MediaController::class, 'destroy'])->name('media.destroy');
    Route::patch('/media/{mediaFile}/toggle-status', [MediaController::class, 'toggleStatus'])->name('media.toggle-status');
    Route::get('/media/{mediaFile}/url', [MediaController::class, 'getFileUrl'])->name('media.url');

    // Reportes y estadísticas
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');

    // Configuraciones
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
});

// Rutas para usuarios creadores
Route::middleware(['auth', 'role:creator'])->prefix('creator')->name('creator.')->group(function () {
    Route::get('/dashboard', [CreatorDashboard::class, 'index'])->name('dashboard');
    Route::resource('websites', WebsiteController::class);

    // Rutas de páginas
    Route::get('websites/{website}/pages', [PageController::class, 'index'])->name('pages.index');
    Route::get('websites/{website}/pages/create', [PageController::class, 'create'])->name('pages.create');
    Route::post('websites/{website}/pages', [PageController::class, 'store'])->name('pages.store');
    Route::get('websites/{website}/pages/{page}', [PageController::class, 'show'])->name('pages.show');
    Route::get('websites/{website}/pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
    Route::put('websites/{website}/pages/{page}', [PageController::class, 'update'])->name('pages.update');
    Route::delete('websites/{website}/pages/{page}', [PageController::class, 'destroy'])->name('pages.destroy');
    Route::get('websites/{website}/pages/{page}/editor', [PageController::class, 'editor'])->name('pages.editor');
    Route::post('websites/{website}/pages/{page}/save', [PageController::class, 'saveContent'])->name('pages.save');

    // Rutas de versiones de páginas
    Route::get('websites/{website}/pages/{page}/versions', [PageController::class, 'versions'])->name('pages.versions');
    Route::get('websites/{website}/pages/{page}/versions/{version}', [PageController::class, 'showVersion'])->name('pages.version-show');
    Route::post('websites/{website}/pages/{page}/versions/{version}/restore', [PageController::class, 'restoreVersion'])->name('pages.version-restore');
    Route::get('websites/{website}/pages/{page}/compare/{version1}/{version2}', [PageController::class, 'compareVersions'])->name('pages.compare-versions');

    // Rutas de plantillas
    Route::get('templates', [TemplateController::class, 'index'])->name('templates.index');
    Route::get('templates/{template}', [TemplateController::class, 'show'])->name('templates.show');
    Route::get('templates/{template}/preview', [TemplateController::class, 'preview'])->name('templates.preview');
    Route::post('websites/{website}/templates/{template}/apply', [TemplateController::class, 'apply'])->name('templates.apply');

    // Rutas del blog
    Route::get('websites/{website}/blog', [BlogPostController::class, 'index'])->name('blog.index');
    Route::get('websites/{website}/blog/create', [BlogPostController::class, 'create'])->name('blog.create');
    Route::post('websites/{website}/blog', [BlogPostController::class, 'store'])->name('blog.store');
    Route::get('websites/{website}/blog/{blogPost}', [BlogPostController::class, 'show'])->name('blog.show');
    Route::get('websites/{website}/blog/{blogPost}/edit', [BlogPostController::class, 'edit'])->name('blog.edit');
    Route::put('websites/{website}/blog/{blogPost}', [BlogPostController::class, 'update'])->name('blog.update');
    Route::delete('websites/{website}/blog/{blogPost}', [BlogPostController::class, 'destroy'])->name('blog.destroy');

    // Rutas de categorías
    Route::get('websites/{website}/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('websites/{website}/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('websites/{website}/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('websites/{website}/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('websites/{website}/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('websites/{website}/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Rutas de etiquetas
    Route::get('websites/{website}/tags', [TagController::class, 'index'])->name('tags.index');
    Route::get('websites/{website}/tags/create', [TagController::class, 'create'])->name('tags.create');
    Route::post('websites/{website}/tags', [TagController::class, 'store'])->name('tags.store');
    Route::get('websites/{website}/tags/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit');
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

    // Rutas de biblioteca multimedia
    Route::get('websites/{website}/media', [MediaFileController::class, 'index'])->name('media.index');
    Route::post('websites/{website}/media', [MediaFileController::class, 'store'])->name('media.store');
    Route::get('websites/{website}/media/{mediaFile}', [MediaFileController::class, 'show'])->name('media.show');
    Route::put('websites/{website}/media/{mediaFile}', [MediaFileController::class, 'update'])->name('media.update');
    Route::delete('websites/{website}/media/{mediaFile}', [MediaFileController::class, 'destroy'])->name('media.destroy');
    Route::get('websites/{website}/media/{mediaFile}/url', [MediaFileController::class, 'getFileUrl'])->name('media.url');

    // Rutas de SEO
    Route::get('websites/{website}/seo', [SeoController::class, 'index'])->name('seo.index');
    Route::get('websites/{website}/seo/edit', [SeoController::class, 'edit'])->name('seo.edit');
    Route::put('websites/{website}/seo', [SeoController::class, 'update'])->name('seo.update');
    Route::get('websites/{website}/seo/sitemap', [SeoController::class, 'sitemap'])->name('seo.sitemap');
    Route::get('websites/{website}/seo/robots', [SeoController::class, 'robots'])->name('seo.robots');
    Route::post('websites/{website}/seo/generate-sitemap', [SeoController::class, 'generateSitemap'])->name('seo.generate-sitemap');
    Route::get('websites/{website}/seo/preview/{page?}', [SeoController::class, 'preview'])->name('seo.preview');
});

// Redirección después del login
Route::get('/home', function () {
    if (auth()->check() && auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('creator.dashboard');
})->middleware('auth');
