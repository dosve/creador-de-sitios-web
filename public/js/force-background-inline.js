// ✅ CRÍTICO: Forzar estilos inline de fondo ANTES de guardar la página
// Esta función asegura que los colores y imágenes de fondo se guarden en el HTML
// y no se pierdan en producción
//
// IMPORTANTE: Si hay AMBOS imagen y color de fondo:
// - La imagen se coloca como background-image
// - El color se convierte a un overlay DIV encima con rgba transparente

function forceBackgroundStylesToInline(editor) {
  try {
    const wrapper = editor.DomComponents.getWrapper();
    if (!wrapper) {
      console.warn('⚠️ [Inline] No wrapper encontrado');
      return;
    }

    const allComponents = wrapper.find('*');
    let processedCount = 0;

    allComponents.forEach(component => {
      if (!component || !component.view || !component.view.el) return;

      const el = component.view.el;
      const type = component.get('type');

      // ===== CONTENEDORES =====
      if (type === 'container') {
        const bgImage = component.get('container-bg-image');
        const bgColor = component.get('container-bg-color');
        const bgSize = component.get('container-bg-size') || 'cover';
        const bgPosition = component.get('container-bg-position') || 'center center';
        const bgRepeat = component.get('container-bg-repeat') || 'no-repeat';
        const bgAttachment = component.get('container-bg-attachment') || 'scroll';
        const bgColorOpacity = component.get('container-bg-color-opacity') || '100'; // 0-100

        // Parsear estilos existentes del elemento
        let currentStyle = el.getAttribute('style') || '';
        const styles = {};

        if (currentStyle) {
          currentStyle.split(';').forEach(prop => {
            const [key, value] = prop.split(':').map(s => s.trim());
            if (key && !key.startsWith('background')) {
              styles[key] = value;
            }
          });
        }

        // Agregar estilos de imagen de fondo
        if (bgImage) {
          // ✅ Si hay imagen + color, crear linear-gradient con overlay
          if (bgColor) {
            const opacity = Number.isFinite(parseFloat(bgColorOpacity))
              ? Math.min(100, Math.max(0, parseFloat(bgColorOpacity))) / 100
              : 1;
            const rgbColor = hexToRgb(bgColor);
            
            if (rgbColor) {
              // Usar linear-gradient con el color overlay + la imagen
              styles['background-image'] = `linear-gradient(rgba(${rgbColor.r}, ${rgbColor.g}, ${rgbColor.b}, ${opacity}), rgba(${rgbColor.r}, ${rgbColor.g}, ${rgbColor.b}, ${opacity})), url("${bgImage}")`;
              console.log('🎨 [Inline] Guardando linear-gradient con overlay:', {
                color: bgColor,
                opacity: bgColorOpacity,
                rgba: `rgba(${rgbColor.r}, ${rgbColor.g}, ${rgbColor.b}, ${opacity})`
              });
            } else {
              // Si no se puede parsear el color, usar solo la imagen
              styles['background-image'] = `url("${bgImage}")`;
            }
          } else {
            // Solo imagen, sin overlay
            styles['background-image'] = `url("${bgImage}")`;
          }
          
          styles['background-size'] = bgSize;
          styles['background-position'] = bgPosition;
          styles['background-repeat'] = bgRepeat;
          styles['background-attachment'] = bgAttachment;
          styles['position'] = 'relative'; // Necesario para overlay absoluto
        }

        // ✅ Aplicar color SOLO si no hay imagen
        if (bgColor && !bgImage) {
          styles['background-color'] = bgColor;
        }

        // ✅ ANTIGUO: Ya no necesitamos este bloque, se maneja arriba
        /*
        // ✅ NUEVO: Si hay AMBOS imagen y color, usar overlay en lugar de background-color directo
        if (bgImage && bgColor) {
          // NO usar background-color, usar overlay en su lugar
          console.log('🎨 [Inline] Detectado imagen + color: usando overlay transparente');
          
          // El overlay se maneja en CSS o con pseudo-elemento
          // Por ahora guardamos las propiedades para que el CSS pueda usarlas
          // Asegurar que el contenedor tiene position relative
          styles['position'] = 'relative';
          
        } else if (bgColor) {
          // Si SOLO hay color (sin imagen), usar background-color normal
          styles['background-color'] = bgColor;
        }
        */

        // Reconstruir atributo style
        const newStyle = Object.entries(styles)
          .filter(([k, v]) => k && v)
          .map(([k, v]) => `${k}: ${v}`)
          .join('; ');

        if (newStyle) {
          el.setAttribute('style', newStyle);
          component.addAttributes({ style: newStyle });
          processedCount++;

          console.log('✅ [Inline] Estilos forzados en contenedor:', {
            bgImage: !!bgImage,
            bgColor: bgColor || 'sin color',
            ambos: bgImage && bgColor,
            opacity: bgColorOpacity,
            clase: el.className.substring(0, 30)
          });
        }

        // ✅ NUEVO: Agregar CSS para el overlay si hay imagen + color
        if (bgImage && bgColor) {
          const opacity = Number.isFinite(parseFloat(bgColorOpacity))
            ? Math.min(100, Math.max(0, parseFloat(bgColorOpacity))) / 100
            : 1;
          const rgbColor = hexToRgb(bgColor);
          
          if (rgbColor) {
            const overlayId = `overlay-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
            el.setAttribute('data-bg-overlay', overlayId);
            component.addAttributes({ 'data-bg-overlay': overlayId });

            // El CSS será agregado en un <style> global
            const cssRule = `
[data-bg-overlay="${overlayId}"]::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(${rgbColor.r}, ${rgbColor.g}, ${rgbColor.b}, ${opacity});
  pointer-events: none;
  z-index: 1;
}
[data-bg-overlay="${overlayId}"] > * {
  position: relative;
  z-index: 2;
}`;

            // Guardar en atributo para procesarlo luego
            component.addAttributes({ 'data-overlay-css': cssRule });
            console.log('📐 [Inline] Overlay CSS generado para overlay:', overlayId);
          }
        }
      }

      // ===== IMAGEN DE FONDO =====
      if (type === 'background-image') {
        const bgImage = component.get('background-image-url');

        if (bgImage) {
          let currentStyle = el.getAttribute('style') || '';
          const styles = {};

          if (currentStyle) {
            currentStyle.split(';').forEach(prop => {
              const [key, value] = prop.split(':').map(s => s.trim());
              if (key) styles[key] = value;
            });
          }

          styles['background-image'] = `url('${bgImage}')`;
          styles['background-size'] = 'cover';
          styles['background-position'] = 'center';

          const newStyle = Object.entries(styles)
            .filter(([k, v]) => k && v)
            .map(([k, v]) => `${k}: ${v}`)
            .join('; ');

          if (newStyle) {
            el.setAttribute('style', newStyle);
            component.addAttributes({ style: newStyle });
            processedCount++;

            console.log('✅ [Inline] Estilos forzados en background-image:', { url: bgImage.substring(0, 50) });
          }
        }
      }
    });

    console.log(`📊 [Inline] Total de ${processedCount} componentes procesados con estilos inline`);
    
    // ✅ RECOLECTAR CSS de todos los overlays para agregarlo al CSS de la página
    const overlayCSS = collectOverlayCSS(editor);
    if (overlayCSS) {
      console.log('📐 [Inline] CSS de overlays generado:', overlayCSS.length, 'caracteres');
    }
    
    return { processedCount, overlayCSS };
  } catch (error) {
    console.error('❌ [Inline] Error al forzar estilos inline:', error);
    return { processedCount: 0, overlayCSS: '' };
  }
}

// ✅ Recolectar CSS de todos los overlays para guardarlo en el CSS de la página
function collectOverlayCSS(editor) {
  try {
    const wrapper = editor.DomComponents.getWrapper();
    if (!wrapper) return '';

    const allComponents = wrapper.find('*');
    const cssRules = [];

    allComponents.forEach(component => {
      const type = component.get('type');
      if (type === 'container') {
        const bgImage = component.get('container-bg-image');
        const el = component.view && component.view.el;
        const attrColor = el ? el.getAttribute('data-bg-overlay-color') : '';
        const attrOpacity = el ? el.getAttribute('data-bg-overlay-opacity') : '';
        const bgColor = component.get('container-bg-color') || attrColor;
        const bgColorOpacity = component.get('container-bg-color-opacity') || attrOpacity || '100';
        
        if (bgImage && bgColor) {
          const overlayId = component.view?.el?.getAttribute('data-bg-overlay');
          if (overlayId) {
            const opacity = Number.isFinite(parseFloat(bgColorOpacity))
              ? Math.min(100, Math.max(0, parseFloat(bgColorOpacity))) / 100
              : 1;
            const rgbColor = hexToRgb(bgColor);
            
            if (rgbColor) {
              const cssRule = `
[data-bg-overlay="${overlayId}"]::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(${rgbColor.r}, ${rgbColor.g}, ${rgbColor.b}, ${opacity}) !important;
  pointer-events: none;
  z-index: 1;
}
[data-bg-overlay="${overlayId}"] > * {
  position: relative;
  z-index: 2;
}`;
              cssRules.push(cssRule);
            }
          }
        }
      }
    });

    return cssRules.join('\n');
  } catch (error) {
    console.error('❌ [collectOverlayCSS] Error:', error);
    return '';
  }
}

// ✅ Función auxiliar: Convertir hex a RGB
function hexToRgb(color) {
  if (!color) return null;
  const trimmed = String(color).trim();

  // rgb() / rgba()
  const rgbMatch = trimmed.match(/^rgba?\((\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})(?:\s*,\s*(\d*\.?\d+))?\)$/i);
  if (rgbMatch) {
    return {
      r: Math.min(255, parseInt(rgbMatch[1], 10)),
      g: Math.min(255, parseInt(rgbMatch[2], 10)),
      b: Math.min(255, parseInt(rgbMatch[3], 10))
    };
  }

  // hex #RGB o #RRGGBB
  let hex = trimmed.replace('#', '');
  if (hex.length === 3) {
    hex = hex.split('').map(c => c + c).join('');
  }
  if (hex.length !== 6) return null;

  const r = parseInt(hex.substring(0, 2), 16);
  const g = parseInt(hex.substring(2, 4), 16);
  const b = parseInt(hex.substring(4, 6), 16);
  return { r, g, b };
}

// Exportar funciones para uso en editor-config.js
if (typeof window !== 'undefined') {
  window.forceBackgroundStylesToInline = forceBackgroundStylesToInline;
  window.collectOverlayCSS = collectOverlayCSS;
}
