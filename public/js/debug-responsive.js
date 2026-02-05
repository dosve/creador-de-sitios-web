/**
 * 📊 DIAGNÓSTICO COMPLETO DE CLASES RESPONSIVE
 * Ejecuta: window.debugResponsiveClasses() en la consola
 */

window.debugResponsiveClasses = function() {
  console.log('%c═════════════════════════════════════════════════════', 'color: #ff6b6b; font-size: 14px;');
  console.log('%c📊 DIAGNÓSTICO COMPLETO DE RESPONSIVE', 'color: #ff6b6b; font-weight: bold; font-size: 16px;');
  console.log('%c═════════════════════════════════════════════════════\n', 'color: #ff6b6b; font-size: 14px;');
  
  // 1. Elementos con clases mal formadas
  console.log('%c🔍 PASO 1: Buscando clases mal formadas...', 'color: #4dabf7; font-weight: bold; font-size: 12px;');
  const badClasses = [
    'p--10px-',
    'min-h--360px-',
    'min-h--200px-',
    'w--full-',
    'h--auto-',
    'md-flex-row',
    'p--4-',
    'py--16-'
  ];
  
  let badElementsFound = 0;
  badClasses.forEach(badClass => {
    const escapedClass = badClass.replace(/[:.[\]]/g, '\\$&');
    const elements = document.querySelectorAll(`.${escapedClass}`);
    if (elements.length > 0) {
      console.log(`%c  ❌ Clase "${badClass}": ${elements.length} elemento(s)`, 'color: #ff6b6b; font-weight: bold;');
      elements.forEach((el, idx) => {
        console.log(`%c    [${idx}] ${el.tagName}#${el.id || '(sin id)'}`, 'color: #ff6b6b;', {
          className: el.className,
          html: el.outerHTML.substring(0, 100)
        });
      });
      badElementsFound += elements.length;
    }
  });
  
  if (badElementsFound === 0) {
    console.log('%c  ✅ NO se encontraron clases mal formadas - EXCELENTE', 'color: #51cf66; font-weight: bold;');
  } else {
    console.log(`%c  ⚠️ TOTAL: ${badElementsFound} clases mal formadas encontradas`, 'color: #ffa94d; font-weight: bold;');
  }
  
  // 2. Contenedores sin flex/grid
  console.log('%c\n🔍 PASO 2: Verificando display de contenedores...', 'color: #4dabf7; font-weight: bold; font-size: 12px;');
  const containers = document.querySelectorAll('.container-flex');
  let containerIssues = 0;
  
  console.log(`%c  Contenedores encontrados: ${containers.length}`, 'color: #4dabf7;');
  
  containers.forEach((container, idx) => {
    const computed = window.getComputedStyle(container);
    const display = computed.display;
    const className = container.className;
    
    if (display !== 'flex' && display !== 'grid') {
      console.log(`%c  ❌ Contenedor ${idx}: display="${display}" (esperado flex/grid)`, 'color: #ff6b6b; font-weight: bold;');
      console.log(`%c    Classes: ${className.substring(0, 80)}`, 'color: #ff6b6b;');
      containerIssues++;
    } else {
      if (idx < 3) {
        console.log(`%c  ✅ Contenedor ${idx}: display="${display}"`, 'color: #51cf66;');
        console.log(`%c    Classes: ${className.substring(0, 80)}`, 'color: #51cf66;');
      }
    }
  });
  
  if (containerIssues === 0) {
    console.log(`%c  ✅ Todos los ${containers.length} contenedores tienen display correcto`, 'color: #51cf66; font-weight: bold;');
  }

  // 2.1 Dirección computada real (para comparar con el editor)
  console.log('%c\n🔍 PASO 2.1: Dirección computada de contenedores...', 'color: #4dabf7; font-weight: bold; font-size: 12px;');
  containers.forEach((container, idx) => {
    if (idx > 5) return; // Limitar a 6 para no saturar
    const computed = window.getComputedStyle(container);
    const direction = computed.flexDirection;
    const id = container.id || '(sin id)';
    console.log(`%c  Contenedor ${idx} (${id}): flex-direction = ${direction}`, 'color: #51cf66;');
    console.log(`%c    Classes: ${container.className}`, 'color: #888;');
  });
  
  // 3. Columnas en móvil
  console.log('%c\n🔍 PASO 3: Analizando columnas en dispositivo actual...', 'color: #4dabf7; font-weight: bold; font-size: 12px;');
  const viewport = window.innerWidth;
  const isMobile = viewport < 768;
  const columns = document.querySelectorAll('.column-flex, [class*="md:w-"], [class*="md\\:w"]');
  
  console.log(`%c  📐 Viewport: ${viewport}px`, 'color: #4dabf7;');
  console.log(`%c  📱 Tipo: ${isMobile ? 'MÓVIL (<768px)' : 'DESKTOP (≥768px)'}`, isMobile ? 'color: #ff6b6b;' : 'color: #51cf66;');
  console.log(`%c  📊 Elementos encontrados: ${columns.length}`, 'color: #4dabf7;');
  
  let mobileIssues = 0;
  columns.forEach((col, idx) => {
    const computed = window.getComputedStyle(col);
    const width = computed.width;
    const colWidth = parseFloat(width);
    const parentElement = col.parentElement;
    const containerWidth = parentElement ? parseFloat(window.getComputedStyle(parentElement).width) : window.innerWidth;
    const widthPercent = (colWidth / containerWidth * 100).toFixed(1);
    
    if (idx < 5) {
      const status = isMobile && colWidth < containerWidth * 0.95 ? '⚠️' : '✅';
      console.log(
        `%c  ${status} Columna ${idx}: ${widthPercent}% del contenedor (${colWidth.toFixed(0)}px / ${containerWidth.toFixed(0)}px)`,
        isMobile && colWidth < containerWidth * 0.95 ? 'color: #ffa94d;' : 'color: #51cf66;'
      );
      console.log(`%c    Classes: ${col.className.substring(0, 60)}`, 'color: #888;');
    }
    
    if (isMobile && colWidth < containerWidth * 0.95) {
      mobileIssues++;
    }
  });
  
  if (mobileIssues > 0 && isMobile) {
    console.log(`%c  ❌ PROBLEMA: ${mobileIssues} columna(s) NO ocupan 100% en móvil`, 'color: #ff6b6b; font-weight: bold;');
  } else if (isMobile) {
    console.log(`%c  ✅ Las columnas ocupan ~100% en móvil`, 'color: #51cf66; font-weight: bold;');
  }
  
  // 4. CSS Cargado
  console.log('%c\n🔍 PASO 4: Verificando archivos CSS cargados...', 'color: #4dabf7; font-weight: bold; font-size: 12px;');
  const links = document.querySelectorAll('link[rel="stylesheet"]');
  let cssLoaded = {
    responsiveFix: false,
    grapes: false,
    tailwind: false
  };
  
  links.forEach(link => {
    const href = link.href;
    const loaded = link.sheet ? '✅ Cargado' : '❌ NO cargado';
    
    if (href.includes('responsive-fix')) {
      console.log(`%c  ${loaded}: responsive-fix.css`, link.sheet ? 'color: #51cf66;' : 'color: #ff6b6b;');
      cssLoaded.responsiveFix = !!link.sheet;
    } else if (href.includes('grapes')) {
      console.log(`%c  ${loaded}: grapes.min.css`, link.sheet ? 'color: #51cf66;' : 'color: #ff6b6b;');
      cssLoaded.grapes = !!link.sheet;
    } else if (href.includes('tailwind')) {
      console.log(`%c  ${loaded}: tailwind.css`, link.sheet ? 'color: #51cf66;' : 'color: #ff6b6b;');
      cssLoaded.tailwind = !!link.sheet;
    }
  });
  
  // 5. Scripts Cargados
  console.log('%c\n🔍 PASO 5: Verificando scripts de responsive...', 'color: #4dabf7; font-weight: bold; font-size: 12px;');
  console.log(`%c  ${window.fixResponsiveClasses ? '✅' : '❌'} window.fixResponsiveClasses() disponible`, 
    window.fixResponsiveClasses ? 'color: #51cf66;' : 'color: #ff6b6b;');
  console.log(`%c  ${window.debugResponsiveClasses ? '✅' : '❌'} window.debugResponsiveClasses() disponible`, 
    window.debugResponsiveClasses ? 'color: #51cf66;' : 'color: #ff6b6b;');
  
  // 6. Resumen Final
  console.log('%c\n═════════════════════════════════════════════════════', 'color: #51cf66; font-size: 14px;');
  console.log('%c📊 RESUMEN EJECUTIVO:', 'color: #51cf66; font-weight: bold; font-size: 14px;');
  console.log('%c═════════════════════════════════════════════════════', 'color: #51cf66; font-size: 14px;');
  
  const summary = {
    'Clases mal formadas': badElementsFound,
    'Contenedores con problemas': containerIssues,
    'Columnas con problemas en móvil': mobileIssues,
    'Viewport actual': `${viewport}px (${isMobile ? '📱 Móvil' : '🖥️ Desktop'})`,
    'CSS responsive-fix cargado': cssLoaded.responsiveFix ? '✅ SÍ' : '❌ NO',
    'CSS grapes cargado': cssLoaded.grapes ? '✅ SÍ' : '❌ NO',
    'Total contenedores': containers.length,
    'Total columnas': columns.length
  };
  
  Object.keys(summary).forEach(key => {
    const value = summary[key];
    const color = key.includes('problemas') && value > 0 ? 'color: #ff6b6b; font-weight: bold;' : 'color: #51cf66;';
    console.log(`%c  • ${key}: %c${value}`, 'color: #888;', color);
  });
  
  console.log('%c═════════════════════════════════════════════════════\n', 'color: #51cf66; font-size: 14px;');
  
  // 7. Recomendaciones
  if (badElementsFound > 0) {
    console.log('%c💡 RECOMENDACIÓN: Encontradas clases mal formadas. Ejecuta:', 'color: #ffd43b; font-weight: bold;');
    console.log('%c   window.fixResponsiveClasses()\n', 'color: #ffd43b; font-family: monospace; font-weight: bold;');
  }
  
  if (mobileIssues > 0 && isMobile) {
    console.log('%c⚠️ ALERTA: Las columnas NO son 100% ancho en móvil', 'color: #ff6b6b; font-weight: bold;');
    console.log('%c   Recarga la página: Ctrl+F5 o Cmd+Shift+R\n', 'color: #ff6b6b;');
  }
  
  if (!cssLoaded.responsiveFix) {
    console.log('%c❌ CRÍTICO: CSS responsive-fix.css NO está cargado', 'color: #ff6b6b; font-weight: bold;');
    console.log('%c   Verifica que el archivo exista en: /public/css/responsive-fix.css\n', 'color: #ff6b6b;');
  }
  
  return {
    badElementsFound,
    containerIssues,
    mobileIssues,
    viewport,
    isMobile,
    cssLoaded,
    totalContainers: containers.length,
    totalColumns: columns.length
  };
};

// NO ejecutar automáticamente - solo disponible cuando el usuario lo necesite
// Ejecutar con: window.debugResponsiveClasses()

console.log('%c✅ Herramientas de diagnóstico listas. Usa window.debugResponsiveClasses() para ver detalles.\n', 'color: #51cf66;');

