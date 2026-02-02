/**
 * Script de Logging Mejorado para Galería de Imágenes
 * Se ejecuta automáticamente en el editor
 */

(function() {
  'use strict';

  console.log('%c[GALERÍA] Iniciando sistema de logging', 'color: #4dabf7; font-weight: bold');

  // Esperar a que el editor esté disponible
  const checkEditor = setInterval(() => {
    if (window.editor && window.editor.DomComponents) {
      clearInterval(checkEditor);
      
      console.log('%c[GALERÍA] Editor disponible. Registrando interceptores...', 'color: #51cf66; font-weight: bold');

      // Sistema de debug mejorado
      window.__galleryDebug = {
        apiCallCount: 0,
        selectionCount: 0,
        lastApiCall: null,
        lastAssetManagerState: null,
        lastError: null,
        lastSelection: null,
        selectionHistory: [],

        logApiCall: function(url, response = null) {
          this.apiCallCount++;
          this.lastApiCall = {
            timestamp: new Date(),
            url: url,
            callNumber: this.apiCallCount,
            response: response
          };
          console.log(`%c[GALERÍA #${this.apiCallCount}] Llamada API a: ${url}`, 'color: #ffd43b; font-weight: bold');
          if (response) {
            console.log('%c  ↳ Imágenes cargadas: ' + (response.files?.length || 0), 'color: #51cf66');
          }
        },

        logSelection: function(asset, imageUrl) {
          this.selectionCount++;
          this.lastSelection = {
            timestamp: new Date(),
            asset: asset,
            imageUrl: imageUrl,
            selectionNumber: this.selectionCount
          };
          this.selectionHistory.push(this.lastSelection);
          console.log(`%c[GALERÍA - SELECCIÓN #${this.selectionCount}] Imagen seleccionada`, 'color: #51cf66; font-weight: bold; font-size: 12px');
          console.log(`%c  ├─ URL: ${imageUrl}`, 'color: #4dabf7; font-family: monospace');
          console.log(`%c  └─ Actualizado: Sí ✅`, 'color: #51cf66; font-family: monospace');
        },

        logAssetManagerState: function() {
          const am = window.editor.AssetManager;
          if (am) {
            this.lastAssetManagerState = {
              assetCount: am.getAll().length,
              hasOpen: typeof am.open === 'function',
              hasOn: typeof am.on === 'function',
              hasOff: typeof am.off === 'function'
            };
            console.log('%c[GALERÍA] AssetManager state:', 'color: #4dabf7', this.lastAssetManagerState);
          }
        },

        logError: function(error) {
          this.lastError = {
            timestamp: new Date(),
            message: error.message || error,
            stack: error.stack
          };
          console.error('%c[GALERÍA] ERROR:', 'color: #ff6b6b; font-weight: bold', error);
        }
      };

      // Interceptar fetch global para rastrear llamadas a la API
      const originalFetch = window.fetch;
      window.fetch = function(...args) {
        const url = args[0];
        if (typeof url === 'string' && url.includes('/creator/media')) {
          // Llamar al fetch original sin consumir el body
          return originalFetch.apply(this, args)
            .then(response => {
              // Clonar la response para poder leer el body sin afectar al original
              if (typeof url === 'string' && url.includes('/creator/media/api/list')) {
                // Clonar para lectura sin afectar al flujo original
                response.clone().json()
                  .then(data => {
                    window.__galleryDebug.logApiCall(url, data);
                  })
                  .catch(error => {
                    // Ignorar errores en la clonación de debug
                    console.debug('[DEBUG] Error clonando response para logging:', error);
                  });
              }
              // Devolver la response original sin consumir
              return response;
            })
            .catch(error => {
              if (typeof url === 'string' && url.includes('/creator/media')) {
                window.__galleryDebug.logError(error);
              }
              throw error;
            });
        }
        return originalFetch.apply(this, args);
      };

      // Exportar helper para debug
      window.debugGallery = function() {
        console.log('%c━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━', 'color: #51cf66; font-weight: bold');
        console.log('%cDEBUG: GALERÍA DE IMÁGENES', 'color: #51cf66; font-weight: bold; font-size: 16px');
        console.log('%c━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━', 'color: #51cf66; font-weight: bold');
        
        console.log('\n📊 ESTADÍSTICAS:');
        console.log('  Llamadas API realizadas:', window.__galleryDebug.apiCallCount);
        console.log('  Imágenes seleccionadas:', window.__galleryDebug.selectionCount);
        if (window.__galleryDebug.lastApiCall) {
          console.log('  Última llamada API:', window.__galleryDebug.lastApiCall.url);
          console.log('  Imágenes en galería:', window.__galleryDebug.lastApiCall.response?.files?.length || 0);
        }
        
        console.log('\n🖼️ ÚLTIMA SELECCIÓN:');
        if (window.__galleryDebug.lastSelection) {
          console.log('  URL:', window.__galleryDebug.lastSelection.imageUrl);
          console.log('  Número:', window.__galleryDebug.lastSelection.selectionNumber);
        } else {
          console.log('  Sin selecciones aún');
        }
        
        console.log('\n🔧 ASSET MANAGER:');
        window.__galleryDebug.logAssetManagerState();
        
        console.log('\n⚠️ ÚLTIMO ERROR:');
        if (window.__galleryDebug.lastError) {
          console.log('  ', window.__galleryDebug.lastError.message);
        } else {
          console.log('  Sin errores registrados ✅');
        }

        console.log('\n📜 HISTORIAL DE SELECCIONES:');
        if (window.__galleryDebug.selectionHistory.length > 0) {
          window.__galleryDebug.selectionHistory.forEach((sel, idx) => {
            console.log(`  ${idx + 1}. ${sel.imageUrl}`);
          });
        } else {
          console.log('  Vacío');
        }
        
        console.log('%c━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━', 'color: #51cf66; font-weight: bold');
      };

      // Hacer logging disponible globalmente
      window.logGallerySelection = function(url) {
        window.__galleryDebug.logSelection(null, url);
      };

      console.log('%c[GALERÍA] Sistema de logging activo. Ejecuta window.debugGallery() para ver el estado.', 'color: #51cf66; font-weight: bold');
    }
  }, 100);
})();
