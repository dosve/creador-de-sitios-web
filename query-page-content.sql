-- ============================================
-- CONSULTA PARA COMPARAR CONTENIDO LOCAL VS PRODUCCIÓN
-- ============================================

-- 1. CONSULTAR LA PÁGINA DE INICIO CON SU CONTENIDO
-- Esta consulta muestra la página de inicio y su html_content
SELECT 
    p.id,
    p.website_id,
    p.title,
    p.slug,
    p.is_home,
    p.is_published,
    LENGTH(p.html_content) as content_length,
    LEFT(p.html_content, 500) as content_preview,
    w.name as website_name,
    w.template_id,
    w.slug as website_slug
FROM pages p
INNER JOIN websites w ON p.website_id = w.id
WHERE p.is_home = 1
    AND w.template_id = 'dosve-empresa'
ORDER BY p.id DESC
LIMIT 1;

-- ============================================
-- 2. CONSULTA COMPLETA DEL HTML_CONTENT
-- Esta consulta muestra el html_content completo (puede ser muy largo)
SELECT 
    p.id,
    p.title,
    p.html_content
FROM pages p
INNER JOIN websites w ON p.website_id = w.id
WHERE p.is_home = 1
    AND w.template_id = 'dosve-empresa'
ORDER BY p.id DESC
LIMIT 1;

-- ============================================
-- 3. VERIFICAR SI CONTIENE CÓDIGO BLADE SIN PROCESAR
-- Esta consulta busca patrones de código Blade en el contenido
SELECT 
    p.id,
    p.title,
    CASE 
        WHEN p.html_content LIKE '%@if%' THEN 'SÍ - Contiene @if'
        WHEN p.html_content LIKE '%@include%' THEN 'SÍ - Contiene @include'
        WHEN p.html_content LIKE '%{{%' THEN 'SÍ - Contiene {{ }}'
        ELSE 'NO - No contiene código Blade aparente'
    END as tiene_blade,
    LENGTH(p.html_content) as content_length
FROM pages p
INNER JOIN websites w ON p.website_id = w.id
WHERE p.is_home = 1
    AND w.template_id = 'dosve-empresa'
ORDER BY p.id DESC
LIMIT 1;

-- ============================================
-- 4. CONSULTA SIMPLE PARA COPIAR EL CONTENIDO
-- Esta consulta solo muestra el html_content para copiar fácilmente
SELECT html_content
FROM pages
WHERE id = (
    SELECT p.id
    FROM pages p
    INNER JOIN websites w ON p.website_id = w.id
    WHERE p.is_home = 1
        AND w.template_id = 'dosve-empresa'
    ORDER BY p.id DESC
    LIMIT 1
);

