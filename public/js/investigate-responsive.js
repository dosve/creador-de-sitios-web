/**
 * 🔎 INVESTIGACIÓN DETALLADA DE POR QUÉ NO ES RESPONSIVE
 * Ejecuta: window.investigateResponsive() en la consola
 */

window.investigateResponsive = function() {
  console.clear();
  console.log('%c╔════════════════════════════════════════════════════════════╗', 'color: #ff6b6b; font-size: 12px;');
  console.log('%c║  🔎 INVESTIGACIÓN COMPLETA: ¿POR QUÉ NO ES RESPONSIVE?     ║', 'color: #ff6b6b; font-weight: bold; font-size: 13px;');
  console.log('%c╚════════════════════════════════════════════════════════════╝\n', 'color: #ff6b6b; font-size: 12px;');

  // ============================================================================
  // 1️⃣  VERIFICAR TAMAÑO DE VENTANA
  // ============================================================================
  console.log('%c━━━ 1️⃣  TAMAÑO ACTUAL DE VENTANA ━━━', 'color: #ff6b6b; font-weight: bold; font-size: 12px;');
  const viewportWidth = window.innerWidth;
  const viewportHeight = window.innerHeight;
  const isSmallScreen = viewportWidth < 768;
  
  console.log(`%c  Ancho: ${viewportWidth}px`, isSmallScreen ? 'color: #ff6b6b; font-weight: bold;' : 'color: #51cf66;');
  console.log(`%c  Alto: ${viewportHeight}px`, 'color: #4dabf7;');
  console.log(`%c  Tipo: ${isSmallScreen ? '📱 MÓVIL (<768px) - DEBERÍA SER RESPONSIVE' : '🖥️  DESKTOP (≥768px)'}`, 
    isSmallScreen ? 'color: #ff6b6b; font-weight: bold;' : 'color: #4dabf7;');

  // ============================================================================
  // 2️⃣  VERIFICAR CONTENIDO RENDERIZADO
  // ============================================================================
  console.log('%c\n━━━ 2️⃣  CONTENIDO RENDERIZADO EN EL EDITOR ━━━', 'color: #ff6b6b; font-weight: bold; font-size: 12px;');
  
  const editorContent = document.querySelector('.gjs-frame');
  if (!editorContent) {
    console.log('%c  ❌ NO se encontró iframe del editor (.gjs-frame)', 'color: #ff6b6b; font-weight: bold;');
    console.log('%c  El editor podría no estar cargado.', 'color: #ff6b6b;');
  } else {
    console.log('%c  ✅ iframe del editor encontrado', 'color: #51cf66;');
    
    // Buscar dentro del iframe
    try {
      const frameDoc = editorContent.contentDocument || editorContent.contentWindow.document;
      const containers = frameDoc.querySelectorAll('.container-flex');
      const columns = frameDoc.querySelectorAll('.column-flex');
      
      console.log(`%c  📦 Contenedores encontrados: ${containers.length}`, 'color: #4dabf7;');
      console.log(`%c  📋 Columnas encontradas: ${columns.length}`, 'color: #4dabf7;');
      
      if (columns.length > 0) {
        console.log('%c\n  ANALIZANDO PRIMERA COLUMNA:', 'color: #748ffc; font-weight: bold;');
        const firstColumn = columns[0];
        const style = frameDoc.defaultView.getComputedStyle(firstColumn);
        
        console.log(`%c    - display: ${style.display}`, 'color: #748ffc;');
        console.log(`%c    - width: ${style.width}`, 'color: #748ffc;');
        console.log(`%c    - flexBasis: ${style.flexBasis}`, 'color: #748ffc;');
        console.log(`%c    - className: ${firstColumn.className.substring(0, 80)}`, 'color: #748ffc;');
        console.log(`%c    - HTML: ${firstColumn.outerHTML.substring(0, 100)}...`, 'color: #748ffc;');
        
        // Comprobar clases
        const classArray = firstColumn.className.split(' ');
        console.log('%c  CLASES INDIVIDUALES:', 'color: #748ffc; font-weight: bold;');
        classArray.slice(0, 8).forEach(cls => {
          if (cls.includes('--')) {
            console.log(`%c    ❌ ${cls} (MAL FORMADA)`, 'color: #ff6b6b;');
          } else if (cls.includes('w-') || cls.includes('md:')) {
            console.log(`%c    ✅ ${cls}`, 'color: #51cf66;');
          } else if (cls.trim()) {
            console.log(`%c    ℹ️  ${cls}`, 'color: #4dabf7;');
          }
        });
      }
    } catch (e) {
      console.log(`%c  ⚠️  No se pudo acceder al contenido del iframe: ${e.message}`, 'color: #ffa94d;');
    }
  }

  // ============================================================================
  // 3️⃣  VERIFICAR MEDIA QUERIES EN CSS
  // ============================================================================
  console.log('%c\n━━━ 3️⃣  MEDIA QUERIES EN CSS CARGADO ━━━', 'color: #ff6b6b; font-weight: bold; font-size: 12px;');
  
  let mediaQueryCount = 0;
  let responsiveRulesCount = 0;
  
  for (let i = 0; i < document.styleSheets.length; i++) {
    try {
      const sheet = document.styleSheets[i];
      const rules = sheet.cssRules || sheet.rules;
      
      if (rules) {
        for (let j = 0; j < rules.length; j++) {
          const rule = rules[j];
          if (rule.media) {
            mediaQueryCount++;
            if (rule.media.mediaText.includes('768')) {
              console.log(`%c  ✅ Media query encontrada: ${rule.media.mediaText}`, 'color: #51cf66; font-size: 11px;');
              responsiveRulesCount += rule.cssRules ? rule.cssRules.length : 0;
            }
          }
        }
      }
    } catch (e) {
      // Algunas hojas de estilos externas pueden lanzar excepciones
    }
  }
  
  console.log(`%c  Total media queries: ${mediaQueryCount}`, 'color: #4dabf7;');
  console.log(`%c  Reglas en media queries (768px+): ${responsiveRulesCount}`, 'color: #4dabf7;');

  // ============================================================================
  // 4️⃣  VERIFICAR CLASES MAL FORMADAS ESPECÍFICAMENTE
  // ============================================================================
  console.log('%c\n━━━ 4️⃣  CLASES MAL FORMADAS (GrapesJS escaping) ━━━', 'color: #ff6b6b; font-weight: bold; font-size: 12px;');
  
  const problematicClasses = [
    'p--10px-', 'min-h--360px-', 'min-h--200px-', 'w--full-', 
    'h--auto-', 'md-flex-row', 'p--4-', 'py--16-', 'md-w-'
  ];
  
  let encontradosProblematicos = 0;
  problematicClasses.forEach(badClass => {
    try {
      const elements = document.querySelectorAll(`.${badClass}`);
      if (elements.length > 0) {
        console.log(`%c  ❌ "${badClass}": ${elements.length} elemento(s)`, 'color: #ff6b6b; font-weight: bold;');
        encontradosProblematicos += elements.length;
        
        // Mostrar primer elemento
        if (elements[0]) {
          const el = elements[0];
          console.log(`%c    → ${el.tagName}#${el.id || '(sin-id)'} | ${el.className.substring(0, 60)}`, 'color: #ff6b6b; font-size: 10px;');
        }
      }
    } catch (e) {
      // Ignore selector errors
    }
  });
  
  if (encontradosProblematicos === 0) {
    console.log('%c  ✅ NO se encontraron clases mal formadas', 'color: #51cf66; font-weight: bold;');
  } else {
    console.log(`%c  ⚠️  TOTAL DE ELEMENTOS CON CLASES MAL FORMADAS: ${encontradosProblematicos}`, 'color: #ffa94d; font-weight: bold;');
  }

  // ============================================================================
  // 5️⃣  VERIFICAR FLEX EN CONTENEDORES
  // ============================================================================
  console.log('%c\n━━━ 5️⃣  CLASES FLEX EN CONTENEDORES ━━━', 'color: #ff6b6b; font-weight: bold; font-size: 12px;');
  
  const mainContainers = document.querySelectorAll('.container-flex');
  console.log(`%c  Contenedores con .container-flex: ${mainContainers.length}`, 'color: #4dabf7;');
  
  if (mainContainers.length > 0) {
    const firstContainer = mainContainers[0];
    const computed = window.getComputedStyle(firstContainer);
    
    console.log('%c  Primer contenedor (estilo computado):', 'color: #748ffc; font-weight: bold;');
    console.log(`%c    - display: ${computed.display}`, computed.display === 'flex' ? 'color: #51cf66;' : 'color: #ff6b6b;');
    console.log(`%c    - flexDirection: ${computed.flexDirection}`, computed.flexDirection === 'column' ? 'color: #51cf66;' : 'color: #4dabf7;');
    console.log(`%c    - flexWrap: ${computed.flexWrap}`, 'color: #4dabf7;');
    console.log(`%c    - gap: ${computed.gap}`, 'color: #4dabf7;');
    console.log(`%c    - className: ${firstContainer.className}`, 'color: #748ffc; font-size: 10px;');
    
    // Verificar si tiene las clases necesarias
    const classList = firstContainer.className;
    const hasFlexClass = classList.includes('flex');
    const hasFlexColClass = classList.includes('flex-col');
    const hasMdFlexRow = classList.includes('md:flex-row') || classList.includes('md-flex-row');
    
    console.log('%c  Clases importantes:', 'color: #748ffc; font-weight: bold;');
    console.log(`%c    - Tiene "flex": ${hasFlexClass ? '✅ SÍ' : '❌ NO'}`, hasFlexClass ? 'color: #51cf66;' : 'color: #ff6b6b;');
    console.log(`%c    - Tiene "flex-col": ${hasFlexColClass ? '✅ SÍ' : '❌ NO'}`, hasFlexColClass ? 'color: #51cf66;' : 'color: #ff6b6b;');
    console.log(`%c    - Tiene "md:flex-row": ${hasMdFlexRow ? '✅ SÍ' : '❌ NO'}`, hasMdFlexRow ? 'color: #51cf66;' : 'color: #ff6b6b;');
  }

  // ============================================================================
  // 6️⃣  VERIFICAR ANCHO DE COLUMNAS
  // ============================================================================
  console.log('%b━━━ 6️⃣  ANCHO DE COLUMNAS EN MÓVIL ━━━', 'color: #ff6b6b; font-weight: bold; font-size: 12px;');
  
  const columns = document.querySelectorAll('.column-flex');
  console.log(`%c  Total de columnas: ${columns.length}`, 'color: #4dabf7;');
  
  if (isSmallScreen && columns.length > 0) {
    console.log('%c  ⚠️  Estás en MÓVIL - verificando ancho de columnas:', 'color: #ff6b6b; font-weight: bold;');
    
    for (let i = 0; i < Math.min(3, columns.length); i++) {
      const col = columns[i];
      const computed = window.getComputedStyle(col);
      const width = computed.width;
      const parent = col.parentElement;
      const parentWidth = parent ? window.getComputedStyle(parent).width : 'unknown';
      
      console.log(`%c  Columna ${i}:`, 'color: #748ffc; font-weight: bold;');
      console.log(`%c    - Ancho: ${width}`, 'color: #748ffc;');
      console.log(`%c    - Ancho padre: ${parentWidth}`, 'color: #748ffc;');
      console.log(`%c    - ¿Es 100%?: ${width === parentWidth || width === '100%' ? '✅' : '❌'} ${width === '100%' ? 'CORRECTO - Responde bien' : 'PROBLEMA - No ocupa 100%'}`, 
        width === '100%' || width === parentWidth ? 'color: #51cf66;' : 'color: #ff6b6b;');
      console.log(`%c    - className: ${col.className.substring(0, 80)}`, 'color: #748ffc; font-size: 10px;');
    }
  } else if (!isSmallScreen) {
    console.log('%c  ℹ️  No estás en móvil (viewport ≥768px), así que las media queries no aplican', 'color: #4dabf7;');
  }

  // ============================================================================
  // 7️⃣  VERIFICAR SCRIPTS CARGADOS
  // ============================================================================
  console.log('%c\n━━━ 7️⃣  SCRIPTS DE RESPONSIVE CARGADOS ━━━', 'color: #ff6b6b; font-weight: bold; font-size: 12px;');
  
  console.log(`%c  window.fixResponsiveClasses: ${typeof window.fixResponsiveClasses === 'function' ? '✅ Disponible' : '❌ NO disponible'}`, 
    typeof window.fixResponsiveClasses === 'function' ? 'color: #51cf66;' : 'color: #ff6b6b;');
  console.log(`%c  window.debugResponsiveClasses: ${typeof window.debugResponsiveClasses === 'function' ? '✅ Disponible' : '❌ NO disponible'}`, 
    typeof window.debugResponsiveClasses === 'function' ? 'color: #51cf66;' : 'color: #ff6b6b;');
  console.log(`%c  window.investigateResponsive: ${typeof window.investigateResponsive === 'function' ? '✅ Disponible (actual)' : '❌ NO disponible'}`, 
    'color: #51cf66;');

  // ============================================================================
  // 8️⃣  RESUMEN Y RECOMENDACIONES
  // ============================================================================
  console.log('%c\n╔════════════════════════════════════════════════════════════╗', 'color: #ffd43b; font-size: 12px;');
  console.log('%c║  📋 RESUMEN Y RECOMENDACIONES                               ║', 'color: #ffd43b; font-weight: bold; font-size: 13px;');
  console.log('%c╚════════════════════════════════════════════════════════════╝\n', 'color: #ffd43b; font-size: 12px;');

  const recommendations = [];

  if (isSmallScreen) {
    recommendations.push({
      icon: '📱',
      title: 'Estás en móvil',
      action: 'Las media queries DEBERÍAN estar activas',
      color: '#ff6b6b'
    });
  }

  if (encontradosProblematicos > 0) {
    recommendations.push({
      icon: '❌',
      title: 'Clases mal formadas encontradas',
      action: 'Ejecuta: window.fixResponsiveClasses()',
      color: '#ff6b6b'
    });
  }

  if (mainContainers.length === 0) {
    recommendations.push({
      icon: '⚠️',
      title: 'No hay contenedores con clase .container-flex',
      action: 'Verifica que el HTML tenga esta clase',
      color: '#ffa94d'
    });
  }

  if (columns.length === 0) {
    recommendations.push({
      icon: '⚠️',
      title: 'No hay columnas con clase .column-flex',
      action: 'El contenido podría no estar renderizado',
      color: '#ffa94d'
    });
  }

  if (mediaQueryCount === 0) {
    recommendations.push({
      icon: '⚠️',
      title: 'NO se encontraron media queries en CSS',
      action: 'Verifica que responsive-fix.css esté cargado',
      color: '#ff6b6b'
    });
  }

  if (recommendations.length === 0) {
    console.log('%c✅ NO SE ENCONTRARON PROBLEMAS CRÍTICOS', 'color: #51cf66; font-weight: bold; font-size: 12px;');
    console.log('%c   Pero verifica en el navegador si se ve responsive.\n', 'color: #51cf66;');
  } else {
    recommendations.forEach((rec, idx) => {
      console.log(`%c${rec.icon} ${idx + 1}. ${rec.title}`, `color: ${rec.color}; font-weight: bold;`);
      console.log(`%c   → ${rec.action}\n`, `color: ${rec.color};`);
    });
  }

  // ============================================================================
  // 💡 PRÓXIMOS PASOS
  // ============================================================================
  console.log('%c━━━ 💡 PRÓXIMOS PASOS ━━━', 'color: #51cf66; font-weight: bold; font-size: 12px;');
  console.log('%c1️⃣  Recarga la página: Ctrl+F5 o Cmd+Shift+R', 'color: #51cf66;');
  console.log('%c2️⃣  Abre esta investigación de nuevo\n', 'color: #51cf66;');
  console.log('%c3️⃣  Si hay problemas, ejecuta:', 'color: #51cf66;');
  console.log('%c    - window.fixResponsiveClasses()  para normalizar clases', 'color: #51cf66; font-family: monospace;');
  console.log('%c    - window.debugResponsiveClasses()  para diagnóstico\n', 'color: #51cf66; font-family: monospace;');
  
  console.log('%c═════════════════════════════════════════════════════════════\n', 'color: #51cf66; font-size: 12px;');

  // Return object for programmatic use
  return {
    viewportWidth,
    viewportHeight,
    isSmallScreen,
    problematicElementsCount: encontradosProblematicos,
    mediaQueryCount,
    containerCount: mainContainers.length,
    columnCount: columns.length,
    hasFixFunction: typeof window.fixResponsiveClasses === 'function',
    timestamp: new Date().toISOString()
  };
};

console.log('%c✅ Comando listo: window.investigateResponsive()\n', 'color: #51cf66; font-weight: bold;');
