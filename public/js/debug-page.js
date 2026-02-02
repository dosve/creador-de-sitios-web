/**
 * 🔍 DIAGNÓSTICO DE PÁGINA
 * Ejecuta: window.debugPage() en consola
 */

window.debugPage = function() {
  console.clear();
  console.log('%c╔════════════════════════════════════════════════════════╗', 'color: #ff6b6b; font-size: 12px;');
  console.log('%c║  🔍 DIAGNÓSTICO COMPLETO DE PÁGINA                      ║', 'color: #ff6b6b; font-weight: bold; font-size: 13px;');
  console.log('%c╚════════════════════════════════════════════════════════╝\n', 'color: #ff6b6b; font-size: 12px;');

  // 1. Información General
  console.log('%c━━━ 1️⃣ INFORMACIÓN GENERAL ━━━', 'color: #4dabf7; font-weight: bold; font-size: 12px;');
  console.log(`%c  URL: ${window.location.href}`, 'color: #4dabf7;');
  console.log(`%c  Título: ${document.title}`, 'color: #4dabf7;');
  console.log(`%c  Hostname: ${window.location.hostname}`, 'color: #4dabf7;');
  console.log(`%c  Status Esperado: 200`, 'color: #4dabf7;');

  // 2. Variables Globales
  console.log('%c\n━━━ 2️⃣ VARIABLES GLOBALES ━━━', 'color: #4dabf7; font-weight: bold; font-size: 12px;');
  console.log(`%c  websiteId: ${window.websiteId || 'NO'}`, window.websiteId ? 'color: #51cf66;' : 'color: #ff6b6b;');
  console.log(`%c  websiteSlug: ${window.websiteSlug || 'NO'}`, window.websiteSlug ? 'color: #51cf66;' : 'color: #ff6b6b;');
  console.log(`%c  appBaseUrl: ${window.appBaseUrl || 'NO'}`, window.appBaseUrl ? 'color: #51cf66;' : 'color: #ff6b6b;');
  console.log(`%c  websiteApiKey: ${window.websiteApiKey ? 'Configurada ✅' : 'NO ❌'}`, window.websiteApiKey ? 'color: #51cf66;' : 'color: #ff6b6b;');
  console.log(`%c  websiteApiUrl: ${window.websiteApiUrl || 'NO'}`, window.websiteApiUrl ? 'color: #51cf66;' : 'color: #ff6b6b;');

  // 3. Contenido de la Página
  console.log('%c\n━━━ 3️⃣ CONTENIDO HTML ━━━', 'color: #4dabf7; font-weight: bold; font-size: 12px;');
  const pageContent = document.querySelector('#page-content');
  const hasPageContent = !!pageContent;
  console.log(`%c  #page-content existe: ${hasPageContent ? '✅ SÍ' : '❌ NO'}`, hasPageContent ? 'color: #51cf66;' : 'color: #ff6b6b;');
  
  if (hasPageContent) {
    const contentLength = pageContent.innerHTML.length;
    console.log(`%c  Largo del contenido: ${contentLength} caracteres`, contentLength > 100 ? 'color: #51cf66;' : 'color: #ffa94d;');
    
    // Búsqueda de elementos principales
    const sections = pageContent.querySelectorAll('section').length;
    const divs = pageContent.querySelectorAll('div').length;
    const articles = pageContent.querySelectorAll('article').length;
    console.log(`%c  Secciones: ${sections}`, 'color: #4dabf7;');
    console.log(`%c  Divs: ${divs}`, 'color: #4dabf7;');
    console.log(`%c  Artículos: ${articles}`, 'color: #4dabf7;');
  } else {
    console.log('%c  ⚠️ NO HAY CONTENIDO: #page-content no existe o está vacío', 'color: #ff6b6b; font-weight: bold;');
  }

  // 4. Scripts Cargados
  console.log('%c\n━━━ 4️⃣ SCRIPTS GLOBALES ━━━', 'color: #4dabf7; font-weight: bold; font-size: 12px;');
  console.log(`%c  PaymentHandlers: ${typeof window.PaymentHandlers !== 'undefined' ? '✅' : '❌'}`, typeof window.PaymentHandlers !== 'undefined' ? 'color: #51cf66;' : 'color: #ff6b6b;');
  console.log(`%c  window.editor: ${typeof window.editor !== 'undefined' ? '✅' : '❌'}`, typeof window.editor !== 'undefined' ? 'color: #51cf66;' : 'color: #ff6b6b;');
  console.log(`%c  window.WidgetCheckout: ${typeof window.WidgetCheckout !== 'undefined' ? '✅' : '❌'}`, typeof window.WidgetCheckout !== 'undefined' ? 'color: #51cf66;' : 'color: #ff6b6b;');

  // 5. Bloque de Blog
  console.log('%c\n━━━ 5️⃣ BLOQUE DE BLOG ━━━', 'color: #4dabf7; font-weight: bold; font-size: 12px;');
  const blogContainer = document.querySelector('#blog-posts-container');
  const dynamicBlog = document.querySelector('[data-dynamic-blog="true"]');
  const blogList = document.querySelector('.blog-list');
  
  console.log(`%c  #blog-posts-container: ${blogContainer ? '✅ Encontrado' : '❌ No'}`, blogContainer ? 'color: #51cf66;' : 'color: #888;');
  console.log(`%c  [data-dynamic-blog]: ${dynamicBlog ? '✅ Encontrado' : '❌ No'}`, dynamicBlog ? 'color: #51cf66;' : 'color: #888;');
  console.log(`%c  .blog-list: ${blogList ? '✅ Encontrado' : '❌ No'}`, blogList ? 'color: #51cf66;' : 'color: #888;');
  
  if (!blogContainer && !dynamicBlog && !blogList) {
    console.log('%c  ℹ️ Esta página NO tiene bloque de blog (normal)', 'color: #4dabf7;');
  }

  // 6. Estado de Carga
  console.log('%c\n━━━ 6️⃣ ESTADO DE CARGA ━━━', 'color: #4dabf7; font-weight: bold; font-size: 12px;');
  console.log(`%c  document.readyState: ${document.readyState}`, document.readyState === 'complete' ? 'color: #51cf66;' : 'color: #ffa94d;');
  console.log(`%c  DOMContentLoaded: ${document.readyState === 'interactive' || document.readyState === 'complete' ? '✅ SÍ' : '❌ NO'}`, 'color: #4dabf7;');

  // 7. Errores en Consola
  console.log('%c\n━━━ 7️⃣ ERRORES PREVIOS ━━━', 'color: #ff6b6b; font-weight: bold; font-size: 12px;');
  console.log('%c  Revisa la consola arriba para ver cualquier error (líneas rojas)', 'color: #ff6b6b;');
  console.log('%c  Si ves "DEBUG: Page not available" = Error de servidor', 'color: #ff6b6b;');
  console.log('%c  Si ves "⚠️ [BLOG SCRIPT] No se encontró" = Normal (página sin blog)', 'color: #ffa94d;');

  // 8. Resumen
  console.log('%c\n═════════════════════════════════════════════════════\n', 'color: #51cf66; font-size: 12px;');

  const summary = {
    'Página cargada': hasPageContent ? '✅ SÍ' : '❌ NO',
    'Contenido disponible': hasPageContent ? '✅ SÍ' : '❌ NO',
    'Variables configuradas': (window.websiteId && window.websiteSlug) ? '✅ SÍ' : '❌ NO',
    'Blog en página': (blogContainer || dynamicBlog || blogList) ? '✅ SÍ' : 'ℹ️ NO (normal)',
    'Status': document.readyState === 'complete' ? '✅ Cargado' : '⏳ Cargando...',
  };

  Object.keys(summary).forEach(key => {
    console.log(`%c  • ${key}: ${summary[key]}`, 'color: #888;');
  });

  console.log('%c═════════════════════════════════════════════════════\n', 'color: #51cf66; font-size: 12px;');

  return {
    hasPageContent,
    hasBlog: !!blogContainer || !!dynamicBlog || !!blogList,
    readyState: document.readyState,
    websiteConfigured: !!window.websiteId && !!window.websiteSlug,
    timestamp: new Date().toISOString()
  };
};

console.log('%c✅ Comando disponible: window.debugPage()', 'color: #51cf66; font-weight: bold;');
