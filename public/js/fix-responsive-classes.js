/**
 * 🔧 NORMALIZADOR DE CLASES RESPONSIVE
 * Ejecuta UNA SOLA VEZ al cargar - sin intervalos ni loops infinitos
 */

console.log('%c🔧 [RESPONSIVE-FIX] Cargado', 'color: #4dabf7; font-weight: bold;');

// Mapa de clases a corregir
const classFixMap = {
  'p--10px-': 'p-[10px]',
  'min-h--360px-': 'min-h-[360px]',
  'min-h--200px-': 'min-h-[200px]',
  'w--full-': 'w-full',
  'h--auto-': 'h-auto',
  'md-flex-row': 'md:flex-row',
  'p--4-': 'p-4',
  'py--16-': 'py-16'
};

/**
 * Función para arreglar clases en un elemento
 */
function fixElementClasses(element) {
  if (!element || !element.className) return false;

  const oldClass = String(element.className);
  let newClass = oldClass;
  let changed = false;

  Object.keys(classFixMap).forEach((wrongClass) => {
    if (newClass.includes(wrongClass)) {
      // ✅ CASO ESPECIAL: Si es padding corrupto (p--10px-), verificar si ya hay otro padding
      if (wrongClass === 'p--10px-') {
        // Verificar si ya hay otra clase de padding válida (p-0, p-2, p-4, etc.)
        const hasPadding = newClass.match(/\bp-(\d+|\[[\d]+px\])\b/);
        if (hasPadding) {
          // Ya tiene padding válido, solo remover el corrupto
          newClass = newClass.split(wrongClass).join('');
          console.log('%c⚠️ Padding corrupto removido (ya existe padding válido):', 'color: #ffa94d;', {
            el: element.id || element.tagName,
            hasPadding: hasPadding[0]
          });
          changed = true;
          return; // No reemplazar por p-[10px]
        }
      }
      
      // Reemplazo normal para clases corruptas
      newClass = newClass.split(wrongClass).join(classFixMap[wrongClass]);
      changed = true;
    }
  });

  if (changed) {
    // Limpiar espacios múltiples
    newClass = newClass.replace(/\s+/g, ' ').trim();
    element.setAttribute('class', newClass);
    console.log('%c✅ Clase corregida:', 'color: #51cf66;', {
      el: element.id || element.tagName,
      old: oldClass.substring(0, 50),
      new: newClass.substring(0, 50)
    });
  }

  return changed;
}

/**
 * Función principal para ejecutar corrección
 */
window.fixResponsiveClasses = function() {
  const allElements = document.querySelectorAll('[class]');
  let fixedCount = 0;

  console.log(`%c🔍 Analizando ${allElements.length} elementos...`, 'color: #4dabf7;');

  allElements.forEach((el) => {
    if (fixElementClasses(el)) {
      fixedCount++;
    }
  });

  console.log(`%c✅ [RESPONSIVE-FIX] ${fixedCount} elementos corregidos`, 'color: #51cf66; font-weight: bold;');
  return fixedCount;
};

// Ejecutar UNA SOLA VEZ cuando el DOM esté listo
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => window.fixResponsiveClasses(), 500);
  });
} else {
  setTimeout(() => window.fixResponsiveClasses(), 500);
}

console.log('%c✅ Listo - usa window.fixResponsiveClasses() para ejecutar\n', 'color: #51cf66;');
