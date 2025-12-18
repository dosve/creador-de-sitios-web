// Módulo del Componente Google Maps
// Componente de mapa de Google Maps embebido

(function() {
  'use strict';
  
  function registerGoogleMapsComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Google Maps');
      return;
    }
    
    editor.DomComponents.addType('google-maps', {
      isComponent: (el) => {
        // Detectar contenedor de Google Maps
        if (el.tagName === 'DIV' && (
          el.classList.contains('google-maps-container') || 
          el.classList.contains('google-maps-embed') ||
          el.getAttribute('data-gjs-type') === 'google-maps'
        )) {
          return { type: 'google-maps' };
        }
        // Detectar iframe de Google Maps
        if (el.tagName === 'IFRAME' && (
          el.src.includes('google.com/maps') || 
          el.src.includes('maps.google.com')
        )) {
          return { type: 'google-maps' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Google Maps',
          icon: '<i class="fa fa-map-marker"></i>',
          draggable: true,
          droppable: false,
          selectable: true,
          editable: false,   // ✅ BLOQUEADO: No edición directa
          removable: true,
          copyable: true,
          badgable: true,
          stylable: true,
          highlightable: true,
          resizable: false,
          layerable: true,
          attributes: {
            'data-gjs-type': 'google-maps',
            'data-gjs-name': 'Google Maps',
            'data-gjs-editable': 'false'
          },
          'map-url': '',
          'map-height': '450',
          'map-width': '100%',
          traits: [
            {
              type: 'text',
              name: 'map-url',
              label: 'URL del Mapa o Coordenadas',
              placeholder: 'Pega la URL de embed de Google Maps, coordenadas (lat, lng), URL de visualización (@) o código HTML de iframe',
              changeProp: 1
            },
            {
              type: 'text',
              name: 'map-height',
              label: 'Altura (px)',
              placeholder: '450',
              changeProp: 1
            },
            {
              type: 'text',
              name: 'map-width',
              label: 'Ancho',
              placeholder: '100%',
              changeProp: 1
            }
          ]
        },
        init() {
          
          // Sincronizar valores iniciales desde el iframe existente
          const syncInitialValues = () => {
            if (this.view && this.view.el) {
              const el = this.view.el;
              
              // Buscar iframe en el DOM
              let iframe = el.querySelector('iframe');
              
              // Si no está en el DOM, buscar en componentes de GrapesJS
              if (!iframe) {
                const findIframeInComponents = (component) => {
                  if (component.get('tagName') === 'iframe') {
                    return component;
                  }
                  let found = null;
                  component.components().each(child => {
                    if (!found) {
                      found = findIframeInComponents(child);
                    }
                  });
                  return found;
                };
                
                const iframeComponent = findIframeInComponents(this);
                if (iframeComponent && iframeComponent.view && iframeComponent.view.el) {
                  iframe = iframeComponent.view.el;
                }
              }
              
              if (iframe && iframe.src) {
                const currentUrl = this.get('map-url');
                // Solo actualizar si no hay URL configurada o si es diferente
                if (!currentUrl || currentUrl !== iframe.src) {
                  this.set('map-url', iframe.src, { silent: true });
                }
                
                // Detectar altura y ancho del contenedor
                const container = el.classList.contains('google-maps-container') ? el : el.querySelector('.google-maps-container');
                if (container) {
                  const height = container.style.height || '450px';
                  const width = container.style.width || '100%';
                  
                  const heightValue = height.toString().replace('px', '').trim();
                  const widthValue = width.toString().trim();
                  
                  if (heightValue && heightValue !== this.get('map-height')) {
                    this.set('map-height', heightValue, { silent: true });
                  }
                  if (widthValue && widthValue !== this.get('map-width')) {
                    this.set('map-width', widthValue, { silent: true });
                  }
                }
                
              }
            }
          };
          
          setTimeout(syncInitialValues, 100);
          this.on('component:mount', syncInitialValues);
          this.on('component:selected', syncInitialValues);
          this.on('component:update', syncInitialValues);
          
          // Event listeners para traits
          this.on('change:map-url', this.updateMapUrl, this);
          this.on('change:map-height', this.updateMapHeight, this);
          this.on('change:map-width', this.updateMapWidth, this);
          
          // Proteger elementos internos
          const protectElements = () => {
            this.components().each(child => {
              // Proteger iframe
              if (child.get('tagName') === 'iframe') {
                child.set({
                  selectable: false,
                  hoverable: false,
                  draggable: false,
                  editable: false,
                  removable: false,
                  droppable: false
                });
                child.addAttributes({
                  'data-gjs-editable': 'false',
                  'data-gjs-selectable': 'false',
                  'data-gjs-draggable': 'false',
                  'data-gjs-droppable': 'false'
                });
              }
              
              // Proteger contenedores
              if (child.get('tagName') === 'div') {
                child.set({
                  editable: false,
                  droppable: false
                });
                child.addAttributes({
                  'data-gjs-editable': 'false',
                  'data-gjs-droppable': 'false'
                });
              }
              
              // Recursivamente proteger hijos
              if (child.components().length > 0) {
                child.components().each(grandchild => {
                  if (grandchild.get('tagName') === 'iframe') {
                    grandchild.set({
                      selectable: false,
                      hoverable: false,
                      draggable: false,
                      editable: false,
                      removable: false
                    });
                  }
                });
              }
            });
          };
          
          setTimeout(protectElements, 100);
          this.on('component:mount', protectElements);
          this.on('component:add', () => {
            setTimeout(protectElements, 100);
          });
        },
        updateMapUrl() {
          let mapUrl = this.get('map-url') || '';
          console.log('🗺️ Actualizando URL del mapa:', mapUrl);
          
          if (!mapUrl || !mapUrl.trim()) {
            console.warn('⚠️ URL del mapa vacía');
            return;
          }
          
          mapUrl = mapUrl.trim();
          
          // Guardar el código original completo para extraer width y height
          const originalCode = mapUrl;
          
          // Detectar si el usuario pega coordenadas (lat, lng)
          // Formato: "3.9945306413555097, -73.76823493122525" o "3.9945306413555097,-73.76823493122525"
          const coordPattern = /^(-?\d+\.?\d*)\s*,\s*(-?\d+\.?\d*)$/;
          const coordMatch = mapUrl.match(coordPattern);
          
          if (coordMatch && coordMatch[1] && coordMatch[2]) {
            const lat = coordMatch[1].trim();
            const lng = coordMatch[2].trim();
            console.log('📍 Coordenadas detectadas:', { lat, lng });
            
            // Convertir coordenadas a URL de embed de Google Maps
            mapUrl = `https://www.google.com/maps?q=${lat},${lng}&hl=es&z=15&output=embed`;
            
            console.log('✅ Coordenadas convertidas a URL de embed:', mapUrl);
            
            // Actualizar el trait con la URL convertida
            this.set('map-url', mapUrl, { silent: true });
          }
          
          // Si el usuario pega código HTML de iframe, extraer la URL
          if (mapUrl.includes('<iframe') || mapUrl.includes('<iframe')) {
            console.log('📋 Detectado código HTML de iframe, extrayendo URL...');
            
            // Buscar el atributo src en el iframe (puede estar en diferentes formatos)
            // Formato 1: src="url" o src='url'
            // Formato 2: src=url (sin comillas)
            let srcMatch = mapUrl.match(/src\s*=\s*["']([^"']+)["']/i);
            
            if (!srcMatch) {
              // Intentar sin comillas
              srcMatch = mapUrl.match(/src\s*=\s*([^\s>]+)/i);
            }
            
            if (srcMatch && srcMatch[1]) {
              const extractedUrl = srcMatch[1].trim();
              console.log('✅ URL extraída del iframe:', extractedUrl);
              
              // Extraer width y height del código original completo
              const widthMatch = originalCode.match(/width\s*=\s*["']?([^"'\s>]+)["']?/i);
              const heightMatch = originalCode.match(/height\s*=\s*["']?([^"'\s>]+)["']?/i);
              
              if (widthMatch && widthMatch[1]) {
                let width = widthMatch[1].trim();
                // Si es solo un número, asumir que son píxeles
                if (/^\d+$/.test(width)) {
                  width = `${width}px`;
                }
                // Guardar en el trait
                this.set('map-width', width, { silent: false });
                console.log('   Ancho extraído y guardado:', width);
              }
              
              if (heightMatch && heightMatch[1]) {
                let height = heightMatch[1].trim();
                // Si es solo un número, guardarlo como número (sin px) para el trait
                if (/^\d+$/.test(height)) {
                  // Guardar solo el número para el trait
                  this.set('map-height', height, { silent: false });
                  console.log('   Altura extraída y guardada:', height);
                } else {
                  // Si tiene px, quitar px para el trait
                  height = height.replace('px', '').trim();
                  this.set('map-height', height, { silent: false });
                  console.log('   Altura extraída y guardada:', height);
                }
              }
              
              // Aplicar dimensiones después de guardar los traits
              // Usar un pequeño delay para asegurar que los traits se hayan guardado
              setTimeout(() => {
                if (widthMatch && widthMatch[1]) {
                  this.updateMapWidth();
                }
                if (heightMatch && heightMatch[1]) {
                  this.updateMapHeight();
                }
                console.log('✅ Dimensiones aplicadas al contenedor');
              }, 100);
              
              // Actualizar el trait con solo la URL limpia
              mapUrl = extractedUrl;
              this.set('map-url', mapUrl, { silent: true });
            } else {
              console.error('❌ No se pudo extraer la URL del iframe');
              console.log('   Código recibido:', mapUrl.substring(0, 200));
              
              // Mostrar mensaje al usuario
              if (window.editor && window.editor.Notification) {
                window.editor.Notification.add({
                  type: 'error',
                  title: 'Error al extraer URL',
                  message: 'No se pudo extraer la URL del código iframe. Por favor, pega solo la URL que está en el atributo src="..."'
                });
              }
              return;
            }
          }
          
          // Detectar y manejar URLs cortas de Google Maps (goo.gl o maps.app.goo.gl)
          if (mapUrl.includes('goo.gl/') || mapUrl.includes('maps.app.goo.gl/')) {
            console.log('🔗 Detectada URL corta de Google Maps');
            
            // Extraer el ID de la URL corta
            const shortUrlMatch = mapUrl.match(/(?:goo\.gl|maps\.app\.goo\.gl)\/([A-Za-z0-9_-]+)/);
            if (shortUrlMatch && shortUrlMatch[1]) {
              const shortId = shortUrlMatch[1];
              console.log('   ID extraído:', shortId);
              
              // Intentar expandir la URL corta usando un servicio proxy o directamente
              // Nota: Las URLs cortas de Google Maps no funcionan directamente en iframes
              // Necesitamos expandirlas o usar un método alternativo
              
              // Opción 1: Intentar usar un servicio para expandir (puede fallar por CORS)
              // Opción 2: Mostrar instrucciones al usuario
              
              // Por ahora, intentaremos usar la URL corta directamente
              // Si no funciona, el usuario deberá usar "Insertar un mapa" en Google Maps
              
              console.warn('⚠️ Las URLs cortas de Google Maps no funcionan directamente en iframes.');
              console.warn('   Por favor, usa "Compartir" > "Insertar un mapa" en Google Maps para obtener la URL de embed.');
              
              // Intentar usar la URL corta directamente (puede que funcione en algunos casos)
              // Pero lo más probable es que no funcione
              const finalUrl = `https://maps.app.goo.gl/${shortId}`;
              
              // Mostrar mensaje al usuario
              if (window.editor && window.editor.Notification) {
                window.editor.Notification.add({
                  type: 'warning',
                  title: 'URL corta detectada',
                  message: 'Las URLs cortas de Google Maps no funcionan en iframes. Por favor, en Google Maps: 1) Haz clic en "Compartir", 2) Selecciona "Insertar un mapa", 3) Copia la URL de embed que comienza con "https://www.google.com/maps/embed?pb=..."'
                });
              }
              
              // Continuar con el proceso, pero probablemente no funcionará
              // El usuario necesitará usar la URL de embed correcta
              mapUrl = finalUrl;
            }
          }
          
          // Convertir URL de visualización de Google Maps a URL de embed
          if (mapUrl.includes('@') && mapUrl.includes('google.com/maps')) {
            console.log('🔄 Detectada URL de visualización, convirtiendo a embed...');
            
            // Extraer coordenadas de formato: @lat,lng,zoom o @lat,lng
            // Ejemplo: https://www.google.com/maps/@3.9910783,-73.7718717,14.5z
            let lat, lng, zoom;
            
            // Intentar formato completo: @lat,lng,zoomz
            const coordMatch = mapUrl.match(/@(-?\d+\.?\d*),(-?\d+\.?\d*),?(\d+\.?\d*)?z?/);
            if (coordMatch) {
              lat = coordMatch[1];
              lng = coordMatch[2];
              zoom = coordMatch[3] || '15';
              
              // Convertir a URL de embed usando el formato estándar
              // Formato: https://www.google.com/maps?q=lat,lng&hl=es&z=zoom&output=embed
              mapUrl = `https://www.google.com/maps?q=${lat},${lng}&hl=es&z=${Math.round(parseFloat(zoom))}&output=embed`;
              
              console.log('✅ URL convertida a embed:', mapUrl);
              console.log('   Coordenadas:', { lat, lng, zoom });
              
              // Actualizar el trait con la URL convertida
              this.set('map-url', mapUrl, { silent: true });
            } else {
              console.warn('⚠️ No se pudieron extraer coordenadas de la URL de visualización');
              // Intentar usar la URL directamente, puede que funcione
            }
          }
          
          // Validar que sea una URL de Google Maps
          if (!mapUrl.includes('google.com/maps') && !mapUrl.includes('maps.google.com') && !mapUrl.includes('goo.gl') && !mapUrl.includes('maps.app.goo.gl')) {
            console.warn('⚠️ La URL no parece ser de Google Maps:', mapUrl);
            // Continuar de todas formas, puede ser una URL válida
          }
          
          // Procesar la URL final después de un pequeño delay
          // para asegurar que las dimensiones se hayan aplicado primero
          setTimeout(() => {
            this.processMapUrl(mapUrl);
          }, 150);
        },
        processMapUrl(mapUrl) {
          // Este método procesa la URL final y actualiza el iframe
          console.log('🔄 Procesando URL final:', mapUrl);
          
          if (!this.view || !this.view.el) {
            console.warn('⚠️ Vista no disponible');
            return;
          }
          
          const el = this.view.el;
          
          // Buscar iframe en el DOM
          let iframe = el.querySelector('iframe');
          
          // Si no existe iframe, buscar en componentes de GrapesJS
          let iframeComponent = null;
          const findIframe = (component) => {
            if (component.get('tagName') === 'iframe') {
              return component;
            }
            let found = null;
            component.components().each(child => {
              if (!found) {
                found = findIframe(child);
              }
            });
            return found;
          };
          
          iframeComponent = findIframe(this);
          
          // Si no existe iframe, crear la estructura completa
          if (!iframe && !iframeComponent) {
            console.log('🔨 Creando estructura de iframe...');
            
            let width = this.get('map-width') || '100%';
            let height = this.get('map-height') || '450';
            
            // Asegurar formato correcto
            if (width && !width.includes('%') && !width.includes('px')) {
              width = `${width}px`;
            }
            // Height debe ser solo el número para el trait, pero usamos px para el estilo
            const heightNum = height.toString().replace('px', '').trim();
            const heightPx = `${heightNum}px`;
            
            console.log('   Dimensiones a aplicar:', { width, height: heightPx });
            
            // Limpiar componentes existentes
            this.components().reset();
            
            // Crear wrapper usando GrapesJS
            const wrapperComponent = this.components().add({
              tagName: 'div',
              attributes: {
                class: 'google-maps-container'
              },
              style: {
                width: width,
                height: heightPx,
                position: 'relative',
                overflow: 'hidden'
              }
            });
            
            // Agregar iframe al wrapper
            wrapperComponent.components().add({
              tagName: 'iframe',
              attributes: {
                frameborder: '0',
                allowfullscreen: '',
                loading: 'lazy',
                referrerpolicy: 'no-referrer-when-downgrade',
                src: mapUrl
              },
              style: {
                width: '100%',
                height: '100%',
                border: '0'
              }
            });
            
            // Aplicar estilos también directamente en el DOM después de crear
            setTimeout(() => {
              if (wrapperComponent.view && wrapperComponent.view.el) {
                const el = wrapperComponent.view.el;
                el.style.width = width;
                el.style.height = heightPx;
                el.style.setProperty('width', width, 'important');
                el.style.setProperty('height', heightPx, 'important');
                console.log('✅ Estilos aplicados directamente en DOM:', { width, height: heightPx });
              }
            }, 100);
            
            // Proteger el iframe
            setTimeout(() => {
              const newIframeComponent = findIframe(this);
              if (newIframeComponent) {
                newIframeComponent.set({
                  selectable: false,
                  hoverable: false,
                  draggable: false,
                  editable: false,
                  removable: false,
                  droppable: false
                });
              }
            }, 150);
            
            console.log('✅ Estructura de iframe creada');
          } else {
            // Actualizar iframe existente
            if (iframe) {
              // Forzar actualización del src
              iframe.removeAttribute('src');
              setTimeout(() => {
                iframe.src = mapUrl;
                iframe.setAttribute('src', mapUrl);
                console.log('✅ URL del iframe actualizada en DOM:', mapUrl);
              }, 10);
            }
            
            if (iframeComponent) {
              iframeComponent.addAttributes({
                src: mapUrl
              });
              
              // Actualizar también en el DOM si existe la vista
              if (iframeComponent.view && iframeComponent.view.el) {
                iframeComponent.view.el.removeAttribute('src');
                setTimeout(() => {
                  iframeComponent.view.el.src = mapUrl;
                  iframeComponent.view.el.setAttribute('src', mapUrl);
                }, 10);
              }
              
              console.log('✅ URL del iframe actualizada en modelo:', mapUrl);
            }
            
            // Aplicar dimensiones actuales al contenedor existente
            setTimeout(() => {
              this.updateMapWidth();
              this.updateMapHeight();
            }, 50);
          }
          
          // Forzar actualización visual y re-render
          if (this.view) {
            setTimeout(() => {
              if (this.view && this.view.el) {
                const updatedIframe = this.view.el.querySelector('iframe');
                if (updatedIframe) {
                  // Forzar recarga del iframe
                  const currentSrc = updatedIframe.src;
                  updatedIframe.src = '';
                  setTimeout(() => {
                    updatedIframe.src = mapUrl;
                    console.log('🔄 Iframe recargado con nueva URL');
                  }, 50);
                }
                
                // Aplicar dimensiones al contenedor
                const container = this.view.el.querySelector('.google-maps-container') || this.view.el;
                if (container) {
                  const width = this.get('map-width') || '100%';
                  let height = this.get('map-height') || '450';
                  height = height.toString().replace('px', '');
                  container.style.setProperty('width', width, 'important');
                  container.style.setProperty('height', `${height}px`, 'important');
                }
                
                // Re-renderizar la vista
                if (this.view.render) {
                  this.view.render();
                }
              }
            }, 100);
          }
          
          console.log('✅ URL del mapa procesada completamente:', mapUrl);
        },
        updateMapHeight() {
          let height = this.get('map-height') || '450';
          console.log('🗺️ Actualizando altura del mapa:', height);
          
          // Asegurar que height sea un número (sin px)
          height = height.toString().replace('px', '').trim();
          const heightPx = `${height}px`;
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          let container = el.classList.contains('google-maps-container') ? el : el.querySelector('.google-maps-container');
          
          // Si no existe contenedor, el mismo elemento es el contenedor
          if (!container) {
            container = el;
          }
          
          if (container) {
            // Actualizar en el DOM directamente
            container.style.height = heightPx;
            container.setAttribute('style', container.getAttribute('style') || '');
            
            // Actualizar también en el modelo de GrapesJS
            const findContainer = (component) => {
              if (component.get('tagName') === 'div') {
                const classes = component.getAttributes().class || '';
                if (classes.includes('google-maps-container')) {
                  return component;
                }
              }
              let found = null;
              component.components().each(child => {
                if (!found) {
                  found = findContainer(child);
                }
              });
              return found;
            };
            
            const containerComponent = findContainer(this);
            if (containerComponent) {
              const currentStyle = containerComponent.getStyle() || {};
              containerComponent.setStyle({
                ...currentStyle,
                height: heightPx
              });
              console.log('✅ Altura actualizada en modelo:', heightPx);
            }
            
            // Forzar actualización visual
            if (container instanceof HTMLElement) {
              container.style.setProperty('height', heightPx, 'important');
            }
            
            console.log('✅ Altura actualizada en DOM:', heightPx);
          }
        },
        updateMapWidth() {
          let width = this.get('map-width') || '100%';
          console.log('🗺️ Actualizando ancho del mapa:', width);
          
          // Asegurar formato correcto
          if (width && !width.includes('%') && !width.includes('px')) {
            width = `${width}px`;
          }
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          let container = el.classList.contains('google-maps-container') ? el : el.querySelector('.google-maps-container');
          
          // Si no existe contenedor, el mismo elemento es el contenedor
          if (!container) {
            container = el;
          }
          
          if (container) {
            // Actualizar en el DOM directamente
            container.style.width = width;
            container.setAttribute('style', container.getAttribute('style') || '');
            
            // Actualizar también en el modelo de GrapesJS
            const findContainer = (component) => {
              if (component.get('tagName') === 'div') {
                const classes = component.getAttributes().class || '';
                if (classes.includes('google-maps-container')) {
                  return component;
                }
              }
              let found = null;
              component.components().each(child => {
                if (!found) {
                  found = findContainer(child);
                }
              });
              return found;
            };
            
            const containerComponent = findContainer(this);
            if (containerComponent) {
              const currentStyle = containerComponent.getStyle() || {};
              containerComponent.setStyle({
                ...currentStyle,
                width: width
              });
              console.log('✅ Ancho actualizado en modelo:', width);
            }
            
            // Forzar actualización visual
            if (container instanceof HTMLElement) {
              container.style.setProperty('width', width, 'important');
            }
            
            console.log('✅ Ancho actualizado en DOM:', width);
          }
        }
      },
      view: {
        onRender() {
          const el = this.el;

          // Proteger el contenedor principal
          el.setAttribute('contenteditable', 'false');
          el.setAttribute('data-gjs-editable', 'false');
          
          // Proteger elementos internos
          const protectElements = (container) => {
            if (!container) return;
            
            // Proteger iframes
            const iframes = container.querySelectorAll('iframe');
            iframes.forEach(iframe => {
              iframe.setAttribute('contenteditable', 'false');
              iframe.setAttribute('data-gjs-editable', 'false');
              iframe.setAttribute('data-gjs-selectable', 'false');
              iframe.setAttribute('data-gjs-draggable', 'false');
              iframe.setAttribute('data-gjs-droppable', 'false');
            });
            
            // Proteger contenedores internos
            const containers = container.querySelectorAll('.google-maps-container, .google-maps-embed');
            containers.forEach(containerEl => {
              if (containerEl !== el) {
                containerEl.setAttribute('contenteditable', 'false');
                containerEl.setAttribute('data-gjs-editable', 'false');
                containerEl.setAttribute('data-gjs-droppable', 'false');
              }
            });
          };
          
          protectElements(el);
          
          // Observar cambios en el DOM
          const observer = new MutationObserver(() => {
            protectElements(el);
          });
          
          observer.observe(el, {
            childList: true,
            subtree: true
          });
          
          this._mapsObserver = observer;

          el.addEventListener('click', (e) => {
            e.stopPropagation();

            if (window.editor) {
              window.editor.select(this.model);
            }
          });
        },
        onRemove() {
          if (this._mapsObserver) {
            this._mapsObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  if (typeof window !== 'undefined' && window.editor) {
    registerGoogleMapsComponent(window.editor);
  } else {
    const checkEditor = setInterval(() => {
      if (typeof window !== 'undefined' && window.editor) {
        registerGoogleMapsComponent(window.editor);
        clearInterval(checkEditor);
      }
    }, 100);
    
    setTimeout(() => {
      clearInterval(checkEditor);
    }, 10000);
  }
  
  if (typeof window !== 'undefined') {
    window.registerGoogleMapsComponent = registerGoogleMapsComponent;
  }
})();
