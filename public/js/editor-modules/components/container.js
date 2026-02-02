// Módulo del Componente Container
// Contenedor flexible estilo Elementor con sistema de layout

(function() {
  'use strict';
  
  function registerContainerComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Container');
      return;
    }
    
    editor.DomComponents.addType('container', {
      isComponent: (el) => {
        if (el.classList && el.classList.contains('container-flex')) {
          return { type: 'container' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Contenedor',
          tagName: 'div',
          editable: false,
          draggable: true,        // ✅ NUEVO: Permitir arrastrar contenedores
          droppable: true,        // ✅ Permitir soltar elementos dentro
          removable: true,
          selectable: true,
          'container-layout-mode': 'flex', // Valor por defecto
          'container-children-responsive': 'auto', // Valor por defecto para hijos responsive
          'container-direction': 'flex-col', // Desktop: columna vertical
          'container-direction-tablet': '', // Tablet: heredar de Desktop (vacío = herencia)
          'container-direction-mobile': '', // Mobile: heredar de Tablet/Desktop (vacío = herencia)
          'container-bg-image': '',
          'container-bg-size': 'cover',
          'container-bg-position': 'center center',
          'container-bg-repeat': 'no-repeat',
          'container-bg-attachment': 'scroll',
          'container-bg-color': '',
          attributes: {
            // ✅ RESPONSIVE: Usa flex-col en móvil (base), md:flex-row en tablet/desktop
            // Los contenedores se apilarán automáticamente en pantallas pequeñas
            class: 'container-flex flex flex-col md:flex-row gap-4 p-[10px] w-full',
            'data-gjs-name': 'Contenedor',
            'data-gjs-editable': 'false'
          },
          traits: [
            {
              type: 'select',
              name: 'container-layout-mode',
              label: 'Modo de Distribución',
              changeProp: 1,
              options: [
                { value: 'flex', name: 'Flexible (Flexbox) – fila o columna' },
                { value: 'grid-equal', name: 'Columnas Equitativas (Grid)' }
              ]
            },
            {
              type: 'select',
              name: 'container-direction-responsive',
              label: '📱 Dirección',
              changeProp: 1,
              options: [
                { value: '', name: 'Heredar de nivel superior' },
                { value: 'flex-col', name: 'Vertical (Columna)' },
                { value: 'flex-row', name: 'Horizontal (Fila)' },
                { value: 'flex-col-reverse', name: 'Vertical Invertido' },
                { value: 'flex-row-reverse', name: 'Horizontal Invertido' }
              ]
            },
            {
              type: 'select',
              name: 'container-wrap',
              label: 'Ajuste de Línea',
              changeProp: 1,
              options: [
                { value: 'flex-wrap', name: 'Envolver (Wrap)' },
                { value: 'flex-nowrap', name: 'Sin Envolver (No Wrap)' },
                { value: 'flex-wrap-reverse', name: 'Envolver Invertido' }
              ]
            },
            {
              type: 'select',
              name: 'container-justify',
              label: 'Alineación Horizontal',
              changeProp: 1,
              options: [
                { value: 'justify-start', name: 'Inicio' },
                { value: 'justify-center', name: 'Centro' },
                { value: 'justify-end', name: 'Final' },
                { value: 'justify-between', name: 'Espacio Entre' },
                { value: 'justify-around', name: 'Espacio Alrededor' },
                { value: 'justify-evenly', name: 'Espacio Uniforme' }
              ]
            },
            {
              type: 'select',
              name: 'container-align',
              label: 'Alineación Vertical',
              changeProp: 1,
              options: [
                { value: 'items-start', name: 'Inicio' },
                { value: 'items-center', name: 'Centro' },
                { value: 'items-end', name: 'Final' },
                { value: 'items-stretch', name: 'Estirar' },
                { value: 'items-baseline', name: 'Línea Base' }
              ]
            },
            {
              type: 'select',
              name: 'container-gap',
              label: 'Espacio entre Elementos',
              changeProp: 1,
              options: [
                { value: 'gap-0', name: 'Sin Espacio' },
                { value: 'gap-1', name: 'Muy Pequeño (4px)' },
                { value: 'gap-2', name: 'Pequeño (8px)' },
                { value: 'gap-4', name: 'Normal (16px)' },
                { value: 'gap-6', name: 'Mediano (24px)' },
                { value: 'gap-8', name: 'Grande (32px)' },
                { value: 'gap-12', name: 'Extra Grande (48px)' }
              ]
            },
            {
              type: 'select',
              name: 'container-width',
              label: 'Ancho del Contenedor',
              changeProp: 1,
              options: [
                { value: 'w-full', name: 'Ancho Completo (100%)' },
                { value: 'w-auto', name: 'Automático' },
                { value: 'container', name: 'Contenedor Responsive' },
                { value: 'max-w-7xl', name: 'Muy Ancho (1280px)' },
                { value: 'max-w-6xl', name: 'Ancho (1152px)' },
                { value: 'max-w-4xl', name: 'Mediano (896px)' },
                { value: 'max-w-2xl', name: 'Pequeño (672px)' },
                { value: 'max-w-xl', name: 'Extra Pequeño (576px)' }
              ]
            },
            {
              type: 'select',
              name: 'container-padding',
              label: 'Espaciado Interno (Border)',
              changeProp: 1,
              options: [
                { value: 'p-[10px]', name: '10px (por defecto)' },
                { value: 'p-0', name: 'Sin Espaciado' },
                { value: 'p-2', name: 'Muy Pequeño (8px)' },
                { value: 'p-4', name: 'Pequeño (16px)' },
                { value: 'p-6', name: 'Normal (24px)' },
                { value: 'p-8', name: 'Grande (32px)' },
                { value: 'p-12', name: 'Extra Grande (48px)' }
              ]
            },
            {
              type: 'select',
              name: 'container-gap',
              label: 'Espaciado entre Elementos',
              changeProp: 1,
              options: [
                { value: 'gap-0', name: 'Sin Espaciado' },
                { value: 'gap-1', name: 'Muy Pequeño (4px)' },
                { value: 'gap-2', name: 'Pequeño (8px)' },
                { value: 'gap-4', name: 'Normal (16px)' },
                { value: 'gap-6', name: 'Mediano (24px)' },
                { value: 'gap-8', name: 'Grande (32px)' },
                { value: 'gap-10', name: 'Extra Grande (40px)' },
                { value: 'gap-12', name: 'Muy Grande (48px)' }
              ]
            },
            {
              type: 'select',
              name: 'container-margin',
              label: 'Margen Externo',
              changeProp: 1,
              options: [
                { value: '', name: 'Sin Margen' },
                { value: 'mx-auto', name: 'Centrado Horizontal' },
                { value: 'm-0', name: 'Sin Margen' },
                { value: 'm-4', name: 'Pequeño (16px)' },
                { value: 'm-8', name: 'Mediano (32px)' },
                { value: 'm-12', name: 'Grande (48px)' }
              ]
            },
            {
              type: 'button',
              name: 'select-bg-image-gallery',
              label: '📁 Seleccionar Fondo (Galería)',
              text: 'Elegir imagen de fondo',
              full: true,
              command: (editor) => {
                // console.log('%c🟦 BOTÓN CONTENEDOR PRESIONADO', 'color: #0066ff; font-weight: bold; font-size: 13px');
                
                const component = editor.getSelected();
                if (component && component.get('type') === 'container') {
                  // console.log('1️⃣ Componente container válido');
                  const am = editor.AssetManager;
                  const modal = editor.Modal;

                  // console.log('2️⃣ Iniciando fetch...');
                  fetch('/creator/media/api/list')
                    .then(response => {
                      // console.log('3️⃣ Fetch OK:', response.status);
                      return response.json();
                    })
                    .then(data => {
                      // console.log('4️⃣ JSON recibido:', data?.files?.length, 'imágenes');
                      
                      if (data.success && data.files && data.files.length > 0) {
                        // console.log('5️⃣ Limpiando AssetManager...');
                        am.getAll().reset();
                        
                        // console.log('6️⃣ Agregando imágenes...');
                        data.files.forEach(file => {
                          am.add({
                            type: 'image',
                            src: file.url,
                            name: file.filename,
                            alt: file.alt_text || file.filename
                          });
                        });
                      }

                      const onClickHandler = (asset) => {
                        // console.log('🔵 onClick Handler ejecutado');
                        // console.log('   → Asset:', asset);
                        
                        let newSrc = null;
                        if (typeof asset.get === 'function') {
                          newSrc = asset.get('src') || asset.get('url');
                          // console.log('   → Método get() encontrado');
                        }
                        if (!newSrc) {
                          newSrc = asset.src || asset.url || (asset.el && asset.el.src);
                          // console.log('   → Propiedades directas encontradas');
                        }
                        if (!newSrc && asset.attributes) {
                          newSrc = asset.attributes.src || asset.attributes.url;
                          // console.log('   → Atributos encontrados');
                        }

                        // console.log('   → newSrc final:', newSrc);
                        
                        if (!newSrc || typeof newSrc !== 'string' || newSrc.trim() === '') {
                          console.warn('❌ URL inválida en imagen de fondo');
                          return;
                        }

                        // console.log('🔵 Imagen seleccionada:', newSrc);
                        component.set('container-bg-image', newSrc, { silent: false });
                        if (typeof component.updateBackground === 'function') {
                          component.updateBackground();
                        }
                        
                        component.trigger('change:container-bg-image');
                        component.trigger('change:attributes');
                        
                        if (editor.TraitManager) {
                          editor.TraitManager.render();
                        }
                        
                        modal.close();
                        // console.log('🔵 Modal cerrado');
                      };

                      // console.log('7️⃣ Registrando onclick en elementos del modal...');
                      
                      // Obtener todos los assets como array
                      let assetsArray = [];
                      if (am && am.getAll) {
                        const allAssets = am.getAll();
                        console.log('   → getAll() retornó:', typeof allAssets, allAssets.length);
                        
                        // Si es una colección Backbone, usar .models
                        if (allAssets.models) {
                          assetsArray = allAssets.models;
                          console.log('   → Usando .models:', assetsArray.length);
                        } else if (allAssets.at) {
                          // Si tiene método .at(), iterarlo
                          for (let i = 0; i < allAssets.length; i++) {
                            assetsArray.push(allAssets.at(i));
                          }
                          console.log('   → Usando .at():', assetsArray.length);
                        } else {
                          // Convertir a array si es necesario
                          for (let i = 0; i < allAssets.length; i++) {
                            assetsArray.push(allAssets[i]);
                          }
                          console.log('   → Conversión directa:', assetsArray.length);
                        }
                        
                        console.log('   → assetsArray convertido:', assetsArray.length, 'items');
                        assetsArray.forEach((asset, idx) => {
                          if (asset) {
                            const src = asset.get ? asset.get('src') : asset.src;
                            console.log(`      [${idx}]: ${src}`);
                          } else {
                            console.log(`      [${idx}]: undefined`);
                          }
                        });
                      }
                      
                      // Usar setTimeout para que el modal se renderice primero
                      setTimeout(() => {
                        console.log('   → Buscando elementos con clase gjs-am-asset...');
                        const assetElements = document.querySelectorAll('.gjs-am-asset');
                        console.log('   → Encontrados:', assetElements.length, 'elementos');
                        
                        assetElements.forEach((el, idx) => {
                          el.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            
                            console.log(`🔵 Elemento ${idx + 1} clickeado`);
                            
                            // Obtener el índice correcto del elemento dentro de su contenedor
                            const container = el.parentElement;
                            const allAssetEls = container ? Array.from(container.querySelectorAll('.gjs-am-asset')) : [];
                            const clickedIdx = allAssetEls.indexOf(el);
                            
                            console.log('   → Índice en contenedor:', clickedIdx);
                            console.log('   → Assets array disponibles:', assetsArray.length);
                            
                            let url = null;
                            
                            // Intento 1: obtener directamente del array convertido
                            if (clickedIdx >= 0 && clickedIdx < assetsArray.length) {
                              const asset = assetsArray[clickedIdx];
                              console.log('   → Asset encontrado:', asset);
                              
                              if (asset) {
                                if (asset.get) {
                                  url = asset.get('src') || asset.get('url');
                                } else {
                                  url = asset.src || asset.url;
                                }
                                console.log('   → URL del asset:', url);
                              }
                            }
                            
                            // Intento 2: data attribute
                            if (!url) {
                              url = el.getAttribute('data-src');
                              if (url) console.log('   → URL de data-src:', url);
                            }
                            
                            // Intento 3: style backgroundImage
                            if (!url) {
                              const bgImage = el.style.backgroundImage;
                              if (bgImage) {
                                url = bgImage.replace(/url\(['"]?([^'")]+)['"]?\)/g, '$1');
                                console.log('   → URL de backgroundImage:', url);
                              }
                            }
                            
                            // Intento 4: img tag dentro
                            if (!url) {
                              const img = el.querySelector('img');
                              if (img) {
                                url = img.src;
                                console.log('   → URL de img.src:', url);
                              }
                            }
                            
                            if (url && url.trim()) {
                              console.log('🔵 ✅ Imagen seleccionada:', url);
                              component.set('container-bg-image', url, { silent: false });
                              if (typeof component.updateBackground === 'function') {
                                component.updateBackground();
                              }
                              
                              component.trigger('change:container-bg-image');
                              component.trigger('change:attributes');
                              
                              if (editor.TraitManager) {
                                editor.TraitManager.render();
                              }
                              
                              modal.close();
                              console.log('🔵 ✅ Modal cerrado');
                            } else {
                              console.warn('❌ No se encontró URL válida');
                            }
                          }, true);
                        });
                        
                        console.log('   ✅ Listeners registrados en todos los elementos');
                      }, 100);
                      
                      console.log('%c8️⃣ LLAMANDO am.open()', 'color: #00cc00; font-weight: bold; font-size: 12px');
                      try {
                        const result = am.open({ types: ['image'] });
                        console.log('%c✅ am.open() completado', 'color: #00cc00; font-weight: bold; font-size: 12px');
                        console.log('   → Resultado:', result);
                      } catch(e) {
                        console.error('   ❌ Error en am.open():', e.message);
                      }
                    })
                    .catch((error) => {
                      console.error('❌ Error en fetch:', error);
                      modal.close();
                    });
                } else {
                  console.warn('❌ Componente no válido');
                }
              }
            },
            {
              type: 'text',
              name: 'container-bg-image',
              label: 'Imagen de Fondo (URL)',
              placeholder: 'https://tusitio.com/imagen.jpg',
              changeProp: 1
            },
            {
              type: 'select',
              name: 'container-bg-size',
              label: 'Tamaño de Fondo',
              changeProp: 1,
              options: [
                { value: 'cover', name: 'Cover (cubrir)' },
                { value: 'contain', name: 'Contain (contener)' },
                { value: 'auto', name: 'Auto' }
              ]
            },
            {
              type: 'select',
              name: 'container-bg-position',
              label: 'Posición de Fondo',
              changeProp: 1,
              options: [
                { value: 'center center', name: 'Centro' },
                { value: 'top center', name: 'Arriba' },
                { value: 'bottom center', name: 'Abajo' },
                { value: 'center left', name: 'Izquierda' },
                { value: 'center right', name: 'Derecha' },
                { value: 'top left', name: 'Arriba Izquierda' },
                { value: 'top right', name: 'Arriba Derecha' },
                { value: 'bottom left', name: 'Abajo Izquierda' },
                { value: 'bottom right', name: 'Abajo Derecha' }
              ]
            },
            {
              type: 'select',
              name: 'container-bg-repeat',
              label: 'Repetir Fondo',
              changeProp: 1,
              options: [
                { value: 'no-repeat', name: 'No repetir' },
                { value: 'repeat', name: 'Repetir' },
                { value: 'repeat-x', name: 'Repetir X' },
                { value: 'repeat-y', name: 'Repetir Y' }
              ]
            },
            {
              type: 'select',
              name: 'container-bg-attachment',
              label: 'Fondo Fijo',
              changeProp: 1,
              options: [
                { value: 'scroll', name: 'Normal' },
                { value: 'fixed', name: 'Fijo (parallax)' }
              ]
            },
            {
              type: 'color',
              name: 'container-bg-color',
              label: 'Color de Fondo',
              changeProp: 1
            },
            {
              type: 'range',
              name: 'container-bg-color-opacity',
              label: 'Transparencia del Color (%)',
              min: 0,
              max: 100,
              step: 5,
              changeProp: 1,
              default: 100
            },
            {
              type: 'select',
              name: 'container-title-color',
              label: '🎨 Color del Título',
              changeProp: 1,
              options: [
                { value: '#ffffff', name: 'Blanco' },
                { value: '#000000', name: 'Negro' },
                { value: '#1f2937', name: 'Gris Oscuro' },
                { value: '#6b7280', name: 'Gris' },
                { value: '#ef4444', name: 'Rojo' },
                { value: '#f97316', name: 'Naranja' },
                { value: '#eab308', name: 'Amarillo' },
                { value: '#22c55e', name: 'Verde' },
                { value: '#06b6d4', name: 'Cian' },
                { value: '#3b82f6', name: 'Azul' },
                { value: '#8b5cf6', name: 'Púrpura' },
                { value: '#ec4899', name: 'Rosa' }
              ]
            },
            {
              type: 'select',
              name: 'container-text-color',
              label: '🎨 Color del Párrafo',
              changeProp: 1,
              options: [
                { value: '#ffffff', name: 'Blanco' },
                { value: '#000000', name: 'Negro' },
                { value: '#1f2937', name: 'Gris Oscuro' },
                { value: '#6b7280', name: 'Gris' },
                { value: '#ef4444', name: 'Rojo' },
                { value: '#f97316', name: 'Naranja' },
                { value: '#eab308', name: 'Amarillo' },
                { value: '#22c55e', name: 'Verde' },
                { value: '#06b6d4', name: 'Cian' },
                { value: '#3b82f6', name: 'Azul' },
                { value: '#8b5cf6', name: 'Púrpura' },
                { value: '#ec4899', name: 'Rosa' }
              ]
            },
            {
              type: 'select',
              name: 'container-children-responsive',
              label: 'Hijos Responsive',
              changeProp: 1,
              options: [
                { value: 'auto', name: 'Automático (Según layout)' },
                { value: 'full-width', name: 'Ancho Completo en Móvil' },
                { value: 'equal-responsive', name: 'Equitativos Responsive' }
              ]
            }
          ]
        },
        init() {
          console.log('🎬 [INIT] Container init() ejecutado');
          console.log('📦 [INIT] Componente:', this.getName());
          console.log('🏗️ [INIT] Container-layout-mode:', this.get('container-layout-mode'));
          console.log('🔀 [INIT] Container-direction:', this.get('container-direction'));
          console.log('🔀 [INIT] Container-direction-tablet:', this.get('container-direction-tablet'));
          console.log('🔀 [INIT] Container-direction-mobile:', this.get('container-direction-mobile'));
          
          // Asegurar que el valor por defecto esté establecido
          if (!this.get('container-layout-mode')) {
            this.set('container-layout-mode', 'flex', { silent: true });
          }
          
          const syncInitialValues = () => {
            // ✅ SOLO sincronizar en la carga inicial, nunca después
            if (this.get('_syncDone')) {
              console.log('⏭️ [SYNC] Saltando syncInitialValues - ya ejecutado');
              return;
            }
            console.log('🔄 [SYNC] Ejecutando syncInitialValues por primera vez');
            this.set('_syncDone', true, { silent: true });
            if (this.view && this.view.el) {
              const el = this.view.el;
              const classList = (el.className || '').split(' ').filter(c => c.trim());
              
              if (!classList.includes('container-flex')) {
                el.classList.add('container-flex');
              }
              // Detectar modo de layout
              const isGrid = classList.includes('grid');
              const isFlex = classList.includes('flex');
              const layoutMode = isGrid ? 'grid-equal' : (isFlex ? 'flex' : 'flex');
              // Establecer sin silent para que el TraitManager lo detecte
              const currentMode = this.get('container-layout-mode');
              if (currentMode !== layoutMode) {
                this.set('container-layout-mode', layoutMode, { silent: false });
              } else if (!currentMode) {
                // Si no tiene valor, establecer el por defecto
                this.set('container-layout-mode', 'flex', { silent: false });
              }
              
              if (!isGrid && !isFlex) {
                el.classList.add('flex');
              }
              
              // Detectar dirección - buscar tanto clases directas como responsive
              const directionMatch = classList.find(c => c.match(/^flex-(row|col)(-reverse)?$/));
              const mdDirectionMatch = classList.find(c => c.match(/^md:flex-(row|col)(-reverse)?$/));
              
              const existingDesktopDir = this.get('container-direction') || '';
              const existingTabletDir = this.get('container-direction-tablet') || '';
              const existingMobileDir = this.get('container-direction-mobile') || '';

              // ✅ Solo sincronizar si el valor está vacío, para no sobrescribir configuraciones del usuario
              if (directionMatch) {
                // La clase directa es para MOBILE (mobile-first approach)
                if (!existingMobileDir) {
                  this.set('container-direction-mobile', directionMatch, { silent: true });
                }
                
                // Si hay md: class, es para TABLET/DESKTOP
                if (mdDirectionMatch) {
                  if (!existingTabletDir) {
                    this.set('container-direction-tablet', mdDirectionMatch, { silent: true });
                  }
                  // Extraer dirección base para desktop (sin md:)
                  const baseDirection = mdDirectionMatch.replace('md:', '');
                  if (!existingDesktopDir) {
                    this.set('container-direction', baseDirection, { silent: true });
                  }
                } else {
                  // Si solo hay clase directa (sin md:), usar eso para desktop también
                  if (!existingDesktopDir) {
                    this.set('container-direction', directionMatch, { silent: true });
                  }
                  // Tablet está vacío = herencia de Desktop
                  if (!existingTabletDir) {
                    this.set('container-direction-tablet', '', { silent: true });
                  }
                }
              } else if (mdDirectionMatch) {
                // Si solo hay clase responsive, extraer la dirección base
                const baseDirection = mdDirectionMatch.replace('md:', '');
                if (!existingDesktopDir) {
                  this.set('container-direction', baseDirection, { silent: true });
                }
                if (!existingTabletDir) {
                  this.set('container-direction-tablet', mdDirectionMatch, { silent: true });
                }
                // Mobile está vacío = herencia de Tablet
                if (!existingMobileDir) {
                  this.set('container-direction-mobile', '', { silent: true });
                }
              } else {
                // Si no hay ninguna dirección, pero el elemento tiene 'flex', aplicar mobile-first por defecto
                if (classList.includes('flex') && !classList.some(c => c.match(/^flex-(row|col)(-reverse)?$/) || c.match(/^md:flex-(row|col)(-reverse)?$/))) {
                  // Aplicar flex-col por defecto en mobile si no hay configuración previa
                  if (!el.classList.contains('flex-col')) {
                    el.classList.add('flex-col');
                    if (!existingMobileDir) {
                      this.set('container-direction-mobile', '', { silent: true }); // Herencia
                    }
                    if (!existingDesktopDir) {
                      this.set('container-direction', 'flex-col', { silent: true });
                    }
                    if (!existingTabletDir) {
                      this.set('container-direction-tablet', '', { silent: true }); // Herencia
                    }
                    this.setAttributes({ class: el.className });
                  }
                }
              }
              
              const wrapMatch = classList.find(c => c.match(/^flex-(wrap|nowrap)(-reverse)?$/));
              if (wrapMatch) {
                this.set('container-wrap', wrapMatch, { silent: true });
              }
              
              const justifyMatch = classList.find(c => c.match(/^justify-(start|center|end|between|around|evenly)$/));
              if (justifyMatch) {
                this.set('container-justify', justifyMatch, { silent: true });
              }
              
              const alignMatch = classList.find(c => c.match(/^items-(start|center|end|stretch|baseline)$/));
              if (alignMatch) {
                this.set('container-align', alignMatch, { silent: true });
              }
              
              const gapMatch = classList.find(c => c.match(/^gap-([0-9]+|\[\d+px\])$/));
              // ✅ Solo sincronizar si no es el valor por defecto (gap-4) o si ya hay un valor en el modelo
              if (gapMatch && gapMatch !== 'gap-4' && !this.get('container-gap')) {
                this.set('container-gap', gapMatch, { silent: true });
              } else if (gapMatch === 'gap-4' && !this.get('container-gap')) {
                // Si es el default y no hay valor en el modelo, establecerlo
                this.set('container-gap', 'gap-4', { silent: true });
              }
              
              const widthMatch = classList.find(c => c.match(/^(w-(full|auto)|container|max-w-(7xl|6xl|4xl|2xl|xl))$/));
              if (widthMatch) {
                this.set('container-width', widthMatch, { silent: true });
              }
              
              const paddingMatch = classList.find(c => c.match(/^p-[0-9]+$/) || c === 'p-[10px]');
              // ✅ CRÍTICO: Solo sincronizar si NO es el valor por defecto Y si el modelo está vacío
              const currentPadding = this.get('container-padding');
              console.log('🔍 [SYNC-PADDING] paddingMatch:', paddingMatch, 'currentPadding:', currentPadding);
              
              if (paddingMatch && paddingMatch !== 'p-[10px]' && !currentPadding) {
                console.log('✅ [SYNC-PADDING] Sincronizando padding diferente al default:', paddingMatch);
                this.set('container-padding', paddingMatch, { silent: true });
              } else if (paddingMatch === 'p-[10px]' && !currentPadding) {
                console.log('⏭️ [SYNC-PADDING] Ignorando default p-[10px] - modelo queda vacío');
              } else if (currentPadding) {
                console.log('⏭️ [SYNC-PADDING] Ya hay valor en modelo:', currentPadding, '- no sobrescribir');
              }
              
              const marginMatch = classList.find(c => c.match(/^(mx-auto|m-[0-9]+)$/));
              if (marginMatch) {
                this.set('container-margin', marginMatch, { silent: true });
              }
              
              // ✅ NUEVO: Sincronizar desde propiedades del modelo si las clases no están en HTML
              // Esto asegura que si el modelo tiene valores, se usen esos
              if (!justifyMatch && this.get('container-justify')) {
                // Ya tiene un valor en el modelo, mantenerlo
              } else if (!justifyMatch) {
                // Sin valor en clase ni en modelo, establecer default
                this.set('container-justify', 'justify-start', { silent: true });
              }
              
              if (!alignMatch && this.get('container-align')) {
                // Ya tiene un valor en el modelo, mantenerlo
              } else if (!alignMatch) {
                // Sin valor en clase ni en modelo, establecer default
                this.set('container-align', 'items-start', { silent: true });
              }
            }
          };
          
          setTimeout(() => {
            syncInitialValues();
            // Aplicar dirección con comportamiento mobile-first después de sincronizar
            setTimeout(() => {
              this.updateDirection();
              // Si el modo es grid-equal, aplicar el layout
              if (this.get('container-layout-mode') === 'grid-equal') {
                setTimeout(() => {
                  this.updateLayoutMode();
                }, 50);
              } else {
                // En modo flex, actualizar layout y hijos responsive después de inicializar
                setTimeout(() => {
                  this.updateLayoutMode();
                  this.updateChildrenResponsive();
                }, 100);
              }
            }, 50);
          }, 100);
          this.on('component:mount', () => {
            syncInitialValues();
            // Aplicar dirección con comportamiento mobile-first después de sincronizar
            setTimeout(() => {
              this.updateDirection();
              if (this.get('container-layout-mode') === 'grid-equal') {
                setTimeout(() => this.updateLayoutMode(), 50);
              } else {
                // En modo flex, actualizar layout y hijos responsive después de montar
                setTimeout(() => {
                  this.updateLayoutMode();
                  this.updateChildrenResponsive();
                }, 100);
              }
            }, 50);
          });
          this.on('component:selected', () => {
            syncInitialValues();
            // Aplicar dirección con comportamiento mobile-first después de sincronizar
            setTimeout(() => {
              this.updateDirection();
              
              // ✅ Mostrar/ocultar traits según dispositivo (con delay para que el TraitManager renderice)
              setTimeout(() => {
                this.updateVisibleTraitsForDevice();
              }, 100);
              
              if (this.get('container-layout-mode') === 'grid-equal') {
                setTimeout(() => this.updateLayoutMode(), 50);
              } else {
                // En modo flex, actualizar layout y hijos responsive
                setTimeout(() => {
                  this.updateLayoutMode();
                  this.updateChildrenResponsive();
                }, 100);
              }
              
              // 🎯 Sincronizar el trait responsive con el valor actual del dispositivo
              if (window.editor && window.editor.getDevice) {
                const currentDevice = window.editor.getDevice();
                let directionValue = '';
                
                if (currentDevice === 'Desktop') {
                  directionValue = this.get('container-direction') || 'flex-col';
                } else if (currentDevice === 'Tablet') {
                  const tabletValue = this.get('container-direction-tablet') || '';
                  directionValue = tabletValue.replace('md:', '');
                } else if (currentDevice === 'Mobile') {
                  directionValue = this.get('container-direction-mobile') || '';
                }
                
                this.set('container-direction-responsive', directionValue, { silent: true });
                
                // Mostrar información en la consola
                const deviceConfig = {
                  'Desktop': { emoji: '🖥️', breakpoint: 'Sin breakpoint (escritorio)' },
                  'Tablet': { emoji: '📱', breakpoint: 'md: (768px+)' },
                  'Mobile': { emoji: '📱', breakpoint: 'Sin breakpoint (móvil, < 768px)' }
                };
                const config = deviceConfig[currentDevice] || deviceConfig['Desktop'];
                console.log(`%c${config.emoji} Editando contenedor en: ${currentDevice} (${config.breakpoint})`, 'color: #4dabf7; font-weight: bold; font-size: 12px;');
              }
            }, 50);
          });
          
          // Listener para cambios en layout mode - debe ejecutarse inmediatamente
          this.on('change:container-layout-mode', () => {
            setTimeout(() => {
              this.updateLayoutMode();
            }, 50);
          });
          
          // Listener para mantener los estilos de grid después de que GrapesJS los procese
          this.on('change:style', () => {
            if (this.get('container-layout-mode') === 'grid-equal') {
              const gridCols = this.get('grid-template-cols');
              const childCount = this.get('grid-columns-count');
              if (gridCols && childCount && this.view && this.view.el) {
                const el = this.view.el;
                // Re-aplicar los estilos de grid si fueron removidos
                setTimeout(() => {
                  const currentCols = window.getComputedStyle(el).gridTemplateColumns;
                  if (!currentCols.includes('repeat') && !currentCols.includes('fr')) {
                    
                    // Re-aplicar usando CSS rule
                    if (window.editor && window.editor.Css) {
                      const componentId = this.getId();
                      if (componentId) {
                        let cssRule = window.editor.Css.getRule(`#${componentId}`);
                        if (!cssRule) {
                          cssRule = window.editor.Css.setRule(`#${componentId}`, {});
                        }
                        const currentStyles = cssRule.getStyle() || {};
                        currentStyles['display'] = 'grid';
                        currentStyles['grid-template-columns'] = gridCols;
                        currentStyles['grid-auto-rows'] = 'auto';
                        currentStyles['grid-auto-flow'] = 'row';
                        cssRule.setStyle(currentStyles);
                      }
                    }
                    
                    // También usar addStyle si está disponible
                    if (typeof this.addStyle === 'function') {
                      this.addStyle({
                        'display': 'grid',
                        'grid-template-columns': gridCols,
                        'grid-auto-rows': 'auto',
                        'grid-auto-flow': 'row'
                      });
                    }
                    
                    el.style.setProperty('display', 'grid', 'important');
                    el.style.setProperty('grid-template-columns', gridCols, 'important');
                    el.style.setProperty('grid-auto-rows', 'auto', 'important');
                    el.style.setProperty('grid-auto-flow', 'row', 'important');
                  }
                }, 50);
              }
            }
          });
          
          // ✅ Listener para el trait DINÁMICO de dirección responsive
          this.on('change:container-direction-responsive', () => {
            console.log('🔥 [DIRECTION-LISTENER] Cambio detectado en container-direction-responsive');
            console.log('📊 [DIRECTION-LISTENER] Componente:', this.getName());
            
            const currentDevice = window.editor ? window.editor.getDevice() : 'Desktop';
            const value = this.get('container-direction-responsive') || '';
            
            console.log('📱 [DIRECTION-LISTENER] Device actual:', currentDevice);
            console.log('📝 [DIRECTION-LISTENER] Nuevo valor:', value);
            
            if (currentDevice === 'Desktop') {
              // En desktop, guardar directamente
              console.log('💾 [DIRECTION-LISTENER] Guardando en container-direction (Desktop):', value);
              this.set('container-direction', value, { silent: true });
            } else if (currentDevice === 'Tablet') {
              // En tablet, agregar prefijo md:
              const tabletValue = value ? ('md:' + value) : '';
              console.log('💾 [DIRECTION-LISTENER] Guardando en container-direction-tablet (Tablet):', tabletValue);
              this.set('container-direction-tablet', tabletValue, { silent: true });
            } else if (currentDevice === 'Mobile') {
              // En mobile, sin prefijo
              console.log('💾 [DIRECTION-LISTENER] Guardando en container-direction-mobile (Mobile):', value);
              this.set('container-direction-mobile', value, { silent: true });
            }
            
            console.log('🔄 [DIRECTION-LISTENER] Llamando updateDirection()...');
            this.updateDirection();
            setTimeout(() => {
              if (this.get('container-layout-mode') === 'flex') {
                console.log('🔄 [DIRECTION-LISTENER] Llamando updateLayoutMode()...');
                this.updateLayoutMode();
              }
            }, 50);
          });
          
          this.on('change:container-wrap', this.updateWrap, this);
          this.on('change:container-justify', this.updateJustify, this);
          this.on('change:container-align', this.updateAlign, this);
          this.on('change:container-gap', () => {
            // Si está en modo grid, actualizar también el layout
            if (this.get('container-layout-mode') === 'grid-equal') {
              setTimeout(() => this.updateLayoutMode(), 50);
            } else {
              this.updateGap();
            }
          });
          this.on('change:container-width', this.updateWidth, this);
          this.on('change:container-padding', () => {
            console.log('🔔 [EVENT] change:container-padding disparado');
            this.updatePadding();
          });
          this.on('change:container-margin', this.updateMargin, this);
          this.on('change:container-bg-image', this.updateBackground, this);
          this.on('change:container-bg-size', this.updateBackground, this);
          this.on('change:container-bg-position', this.updateBackground, this);
          this.on('change:container-bg-repeat', this.updateBackground, this);
          this.on('change:container-bg-attachment', this.updateBackground, this);
          this.on('change:container-bg-color', this.updateBackground, this);
          this.on('change:container-bg-color-opacity', this.updateBackground, this);
          this.on('change:container-title-color', () => {
            console.log('🎨 [EVENT] change:container-title-color triggered');
            this.updateTextColors();
          });
          this.on('change:container-text-color', () => {
            console.log('🎨 [EVENT] change:container-text-color triggered');
            this.updateTextColors();
          });
          this.on('change:container-children-responsive', () => {
            // Actualizar layout cuando cambie el modo responsive
            setTimeout(() => {
              this.updateLayoutMode();
            }, 50);
          });
          
          // Escuchar cambios en los hijos para actualizar grid si es necesario
          this.on('component:add', () => {
            setTimeout(() => {
              // Actualizar layout para aplicar clases responsive a todos los hijos
              this.updateLayoutMode();
              // Forzar actualización de hijos después de un pequeño delay
              setTimeout(() => {
                this.updateChildrenResponsive();
              }, 100);
            }, 200);
          });
          
          this.on('component:remove', () => {
            setTimeout(() => {
              // Actualizar layout para aplicar clases responsive a los hijos restantes
              this.updateLayoutMode();
              // Forzar actualización de hijos después de un pequeño delay
              setTimeout(() => {
                this.updateChildrenResponsive();
              }, 100);
            }, 200);
          });
          
          // Escuchar cuando los hijos se monten para aplicar clases responsive
          this.on('component:mount', () => {
            setTimeout(() => {
              this.updateChildrenResponsive();
            }, 300);
          });
          
          // Listener para cambios de dispositivo - actualizar dirección cuando cambie el modo
          if (window.editor) {
            window.editor.on('change:device', () => {
              // Cuando cambia el dispositivo, actualizar la dirección para asegurar mobile-first
              setTimeout(() => {
                if (this.get('container-layout-mode') === 'flex') {
                  this.updateDirection();
                  this.updateLayoutMode();
                  this.updateChildrenResponsive();
                }
                
                // ✅ Mostrar/ocultar traits según el dispositivo actual (con delay)
                setTimeout(() => {
                  this.updateVisibleTraitsForDevice();
                }, 50);
              }, 100);
            });
            
            window.editor.on('component:update', (component) => {
              if (component === this && this.get('container-layout-mode') === 'grid-equal') {
                setTimeout(() => {
                  const gridCols = this.get('grid-template-cols');
                  if (gridCols && this.view && this.view.el) {
                    const el = this.view.el;
                    const currentCols = window.getComputedStyle(el).gridTemplateColumns;
                    if (!currentCols.includes('repeat') && !currentCols.includes('fr')) {
                      // Re-aplicar usando CSS rule
                      if (window.editor && window.editor.Css) {
                        const componentId = this.getId();
                        if (componentId) {
                          let cssRule = window.editor.Css.getRule(`#${componentId}`);
                          if (!cssRule) {
                            cssRule = window.editor.Css.setRule(`#${componentId}`, {});
                          }
                          const currentStyles = cssRule.getStyle() || {};
                          currentStyles['display'] = 'grid';
                          currentStyles['grid-template-columns'] = gridCols;
                          currentStyles['grid-auto-rows'] = 'auto';
                          currentStyles['grid-auto-flow'] = 'row';
                          cssRule.setStyle(currentStyles);
                        }
                      }
                      
                      // También usar addStyle si está disponible
                      if (typeof this.addStyle === 'function') {
                        this.addStyle({
                          'display': 'grid',
                          'grid-template-columns': gridCols,
                          'grid-auto-rows': 'auto',
                          'grid-auto-flow': 'row'
                        });
                      }
                    }
                  }
                }, 100);
              }
            });
          }

          // ✅ Restaurar fondo/overlay al cargar el componente (canvas iframe)
          setTimeout(() => {
            if (this.view && this.view.el) {
              this.updateBackground();
              this.updateTextColors();
            } else {
              setTimeout(() => {
                if (this.view && this.view.el) {
                  this.updateBackground();
                  this.updateTextColors();
                }
              }, 200);
            }
          }, 200);
        },
        updateLayoutMode() {
          console.log('🔄 [UPDATE-LAYOUT] updateLayoutMode() llamado');
          
          const layoutMode = this.get('container-layout-mode') || 'flex';
          console.log('🔄 [UPDATE-LAYOUT] Layout mode:', layoutMode);
          
          if (!this.view || !this.view.el) {
            console.warn('⚠️ No hay vista o elemento disponible');
            return;
          }
          
          const el = this.view.el;
          const currentAttrs = this.getAttributes();
          // ✅ CORRECCIÓN: Usar el.className primero (clase actual del DOM) luego fallback al modelo
          let currentClass = el.className || currentAttrs.class || '';
          console.log('🔄 [UPDATE-LAYOUT] Clase actual al iniciar:', currentClass);
          
          const classList = currentClass.split(' ').filter(c => c.trim());
          
          console.log('🔄 [UPDATE-LAYOUT] classList INITIAL:', classList);
          
          // Remover SOLO clases de grid y la clase "flex" base (pero PRESERVAR flex-col, flex-row, etc.)
          // Incluyendo todas las variantes de Tailwind (grid-cols-1, grid-cols-2, md:grid-cols-*, etc.)
          const filteredClasses = classList.filter(cls => {
            // Remover si es:
            // - grid o cualquier variante de grid (grid-cols-*, md:grid-cols-*, etc.)
            // - SOLO la clase "flex" (exactamente "flex", no flex-*)
            // - "flex" como clase standalone seguida de espacio o fin de cadena
            const isGridClass = cls.match(/^(md:|lg:|xl:|sm:)?grid(-cols-|-auto-)?/);
            const isStandaloneFlexClass = cls === 'flex'; // SOLO "flex" exacto, no "flex-col"
            
            return !isGridClass && !isStandaloneFlexClass;
          });
          classList.length = 0;
          classList.push(...filteredClasses);
          
          console.log('🔄 [UPDATE-LAYOUT] classList DESPUÉS limpiar grid/flex base:', classList);
          
          if (layoutMode === 'grid-equal') {
            // Modo Grid: columnas equitativas
            classList.push('grid');
            
            // Remover todas las clases de flex-direction ya que grid no las usa
            for (let i = classList.length - 1; i >= 0; i--) {
              if (classList[i].match(/^flex-(row|col)(-reverse)?$/)) {
                classList.splice(i, 1);
              }
            }
            
            // Función para aplicar grid
            const applyGrid = () => {
              // Obtener hijos usando el modelo de GrapesJS para contar correctamente
              const components = this.components();
              const childCount = components.length;
              const responsiveMode = this.get('container-children-responsive') || 'auto';
              
              if (childCount > 0) {
                // Si el modo responsive está activado, usar clases de Tailwind
                if (responsiveMode === 'full-width' || responsiveMode === 'equal-responsive') {
                  // Remover clases de grid-cols anteriores
                  const gridColsToRemove = [];
                  Array.from(el.classList).forEach(cls => {
                    if (cls.match(/grid-cols-|md:grid-cols-|lg:grid-cols-|xl:grid-cols-|sm:grid-cols-/)) {
                      gridColsToRemove.push(cls);
                    }
                  });
                  gridColsToRemove.forEach(cls => el.classList.remove(cls));
                  
                  // Aplicar clases responsive de grid según número de hijos
                  if (childCount === 2) {
                    classList.push('grid-cols-1', 'md:grid-cols-2');
                  } else if (childCount === 3) {
                    classList.push('grid-cols-1', 'md:grid-cols-2', 'lg:grid-cols-3');
                  } else if (childCount === 4) {
                    classList.push('grid-cols-1', 'md:grid-cols-2', 'lg:grid-cols-4');
                  } else if (childCount > 4) {
                    classList.push('grid-cols-1', 'md:grid-cols-2', 'lg:grid-cols-3', 'xl:grid-cols-4');
                  }
                  
                  // No usar grid-template-columns inline si usamos clases de Tailwind
                  // Solo aplicar gap
                  const gap = this.get('container-gap') || 'gap-4';
                  if (!classList.some(c => c.startsWith('gap-'))) {
                    classList.push(gap);
                  }
                  
                  // Aplicar clases responsive a los hijos
                  components.forEach((component, index) => {
                    const childEl = component.view ? component.view.el : null;
                    if (!childEl) return;
                    
                    // Remover clases de width anteriores
                    if (childEl.classList) {
                      const classesToRemove = [
                        'w-full', 'w-auto', 'w-1/2', 'w-1/3', 'w-1/4', 'w-2/3', 'w-3/4',
                        'md:w-full', 'md:w-1/2', 'md:w-1/3', 'md:w-1/4', 'md:w-2/3', 'md:w-3/4',
                        'lg:w-full', 'lg:w-1/2', 'lg:w-1/3', 'lg:w-1/4', 'lg:w-2/3', 'lg:w-3/4',
                        'xl:w-full', 'xl:w-1/2', 'xl:w-1/3', 'xl:w-1/4', 'xl:w-2/3', 'xl:w-3/4',
                        'sm:w-full', 'sm:w-1/2', 'sm:w-1/3', 'sm:w-1/4', 'sm:w-2/3', 'sm:w-3/4'
                      ];
                      classesToRemove.forEach(cls => childEl.classList.remove(cls));
                    }
                    
                    // Limpiar estilos inline de width
                    childEl.style.removeProperty('width');
                    childEl.style.removeProperty('max-width');
                    childEl.style.removeProperty('min-width');
                    childEl.style.removeProperty('flex');
                    childEl.style.removeProperty('flex-grow');
                    childEl.style.removeProperty('flex-shrink');
                    childEl.style.removeProperty('flex-basis');
                    childEl.style.removeProperty('display');
                    
                    childEl.style.setProperty('box-sizing', 'border-box', 'important');
                    childEl.setAttribute('data-grid-item', 'true');
                  });
                  
                  // Aplicar clases actualizadas
                  const newClass = classList.filter(c => c).join(' ').replace(/\s+/g, ' ').trim();
                  el.className = newClass;
                  this.setAttributes({ class: newClass });
                  
                  // Limpiar estilos inline de grid ya que usamos clases de Tailwind
                  el.style.removeProperty('display');
                  el.style.removeProperty('grid-template-columns');
                  el.style.removeProperty('grid-auto-rows');
                  el.style.removeProperty('grid-auto-flow');
                  
                  return; // Salir temprano si usamos clases de Tailwind
                }
                
                // Modo automático: usar grid-template-columns inline (comportamiento original)
                // CRÍTICO: Remover TODAS las clases de grid-cols-* de Tailwind que puedan interferir
                const classesToRemove = [];
                Array.from(el.classList).forEach(cls => {
                  if (cls.match(/grid-cols-|md:grid-cols-|lg:grid-cols-|xl:grid-cols-|sm:grid-cols-/)) {
                    classesToRemove.push(cls);
                  }
                });
                classesToRemove.forEach(cls => el.classList.remove(cls));
                if (classesToRemove.length > 0) {
                  console.log(`🗑️ Clases removidas: ${classesToRemove.join(', ')}`);
                }
                
                // Guardar la configuración del grid en el modelo para persistencia
                const gridColsValue = `repeat(${childCount}, 1fr)`;
                this.set('grid-columns-count', childCount, { silent: true });
                this.set('grid-template-cols', gridColsValue, { silent: true });
                
                // CRÍTICO: Guardar estilos usando el sistema de CSS de GrapesJS para persistencia
                if (window.editor && window.editor.Css) {
                  let componentId = this.getId();
                  
                  // Si no tiene ID, crear uno
                  if (!componentId || componentId.startsWith('i')) {
                    componentId = `container-${Date.now()}-${Math.floor(Math.random() * 1000)}`;
                    this.addAttributes({ id: componentId });
                  }
                  
                  if (componentId) {
                    let cssRule = window.editor.Css.getRule(`#${componentId}`);
                    if (!cssRule) {
                      cssRule = window.editor.Css.setRule(`#${componentId}`, {});
                    }
                    const currentStyles = cssRule.getStyle() || {};
                    currentStyles['display'] = 'grid';
                    currentStyles['grid-template-columns'] = gridColsValue;
                    currentStyles['grid-auto-rows'] = 'auto';
                    currentStyles['grid-auto-flow'] = 'row';
                    cssRule.setStyle(currentStyles);
                  }
                }
                
                // También usar addStyle si está disponible
                if (typeof this.addStyle === 'function') {
                  this.addStyle({
                    'display': 'grid',
                    'grid-template-columns': gridColsValue,
                    'grid-auto-rows': 'auto',
                    'grid-auto-flow': 'row'
                  });
                }
                
                // Aplicar como inline para que se vea inmediatamente
                el.style.setProperty('display', 'grid', 'important');
                el.style.setProperty('grid-template-columns', gridColsValue, 'important');
                el.style.setProperty('grid-auto-rows', 'auto', 'important');
                el.style.setProperty('grid-auto-flow', 'row', 'important');
                
                // Asegurar que gap esté configurado
                const gap = this.get('container-gap') || 'gap-4';
                if (!classList.some(c => c.startsWith('gap-'))) {
                  classList.push(gap);
                }
                
                // Aplicar estilos a los hijos (modo automático - grid se encarga del layout)
                components.forEach((component, index) => {
                  const childEl = component.view ? component.view.el : null;
                  if (!childEl) return;
                  
                  // Remover clases de flex y width de los hijos
                  if (childEl.classList) {
                    const classesToRemove = ['flex-1', 'flex-grow', 'flex-shrink', 'flex-basis-auto', 
                      'w-full', 'w-auto', 'w-1/2', 'w-1/3', 'w-1/4', 'w-2/3', 'w-3/4',
                      'md:w-full', 'md:w-1/2', 'md:w-1/3', 'md:w-1/4', 'md:w-2/3', 'md:w-3/4',
                      'lg:w-full', 'lg:w-1/2', 'lg:w-1/3', 'lg:w-1/4', 'lg:w-2/3', 'lg:w-3/4',
                      'xl:w-full', 'xl:w-1/2', 'xl:w-1/3', 'xl:w-1/4', 'xl:w-2/3', 'xl:w-3/4',
                      'sm:w-full', 'sm:w-1/2', 'sm:w-1/3', 'sm:w-1/4', 'sm:w-2/3', 'sm:w-3/4'];
                    classesToRemove.forEach(cls => childEl.classList.remove(cls));
                  }
                  
                  // Limpiar estilos inline relacionados con width, flex y display
                  childEl.style.setProperty('width', 'auto', 'important');
                  childEl.style.setProperty('max-width', 'none', 'important');
                  childEl.style.setProperty('min-width', '0', 'important');
                  childEl.style.setProperty('flex', 'none', 'important');
                  childEl.style.setProperty('flex-grow', '0', 'important');
                  childEl.style.setProperty('flex-shrink', '0', 'important');
                  childEl.style.setProperty('flex-basis', 'auto', 'important');
                  
                  // Asegurar que no tenga display block
                  const computedDisplay = window.getComputedStyle(childEl).display;
                  if (computedDisplay === 'block') {
                    childEl.style.setProperty('display', 'inline-block', 'important');
                  }
                  
                  childEl.style.setProperty('box-sizing', 'border-box', 'important');
                  childEl.style.setProperty('overflow', 'visible', 'important');
                  childEl.setAttribute('data-grid-item', 'true');
                });
              } else {
                // Si no hay hijos, usar auto-fill para columnas responsivas
                el.style.setProperty('display', 'grid', 'important');
                el.style.setProperty('grid-template-columns', 'repeat(auto-fill, minmax(200px, 1fr))', 'important');
                el.style.setProperty('grid-auto-rows', 'auto', 'important');
                el.style.setProperty('grid-auto-flow', 'row', 'important');
              }
              
              // Aplicar clases actualizadas
              const newClass = classList.filter(c => c).join(' ').replace(/\s+/g, ' ').trim();
              el.className = newClass;
              this.setAttributes({ class: newClass });
              
              // Forzar recálculo del layout
              void el.offsetHeight; // Trigger reflow
              
              // Verificar después del reflow
              setTimeout(() => {
                const computedDisplay = window.getComputedStyle(el).display;
                const computedGridCols = window.getComputedStyle(el).gridTemplateColumns;
                
                // Verificar si el grid se aplicó correctamente
                if (computedDisplay !== 'grid') {
                  el.style.setProperty('display', 'grid', 'important');
                }
                
                // Si el grid-template-columns no tiene el formato correcto, forzarlo
                if (!computedGridCols.includes('repeat') && !computedGridCols.includes('fr')) {
                  const childCount = this.components().length;
                  el.style.setProperty('grid-template-columns', `repeat(${childCount}, 1fr)`, 'important');
                }
              }, 100);
            };
            
            // Aplicar grid inmediatamente y también después de un pequeño delay para asegurar
            applyGrid();
            setTimeout(applyGrid, 100);
            setTimeout(applyGrid, 300);
            
          } else {
            // Modo Flex: contenedores flexibles
            console.log('🔄 [UPDATE-LAYOUT] Entrando en modo FLEX');
            console.log('🔄 [UPDATE-LAYOUT] classList ANTES de agregar flex:', classList);
            
            classList.push('flex');
            console.log('🔄 [UPDATE-LAYOUT] classList DESPUÉS de agregar flex:', classList);
            
            // Limpiar estilos de grid del modelo
            if (window.editor && window.editor.Css) {
              const componentId = this.getId();
              if (componentId) {
                const cssRule = window.editor.Css.getRule(`#${componentId}`);
                if (cssRule) {
                  const currentStyles = cssRule.getStyle() || {};
                  delete currentStyles['display'];
                  delete currentStyles['grid-template-columns'];
                  delete currentStyles['grid-auto-rows'];
                  delete currentStyles['grid-auto-flow'];
                  cssRule.setStyle(currentStyles);
                }
              }
            }
            
            // Limpiar usando setStyle si está disponible
            if (typeof this.setStyle === 'function') {
              const currentStyles = this.getStyle() || {};
              delete currentStyles['display'];
              delete currentStyles['grid-template-columns'];
              delete currentStyles['grid-auto-rows'];
              delete currentStyles['grid-auto-flow'];
              this.setStyle(currentStyles);
            }
            
            this.set('grid-columns-count', null, { silent: true });
            this.set('grid-template-cols', null, { silent: true });
            
            // Remover estilos inline de grid
            el.style.removeProperty('grid-template-columns');
            el.style.removeProperty('grid-auto-rows');
            el.style.removeProperty('grid-auto-flow');
            el.style.removeProperty('display');
            
            // Aplicar estilos responsive a los hijos (estilo Elementor)
            const components = this.components();
            const responsiveMode = this.get('container-children-responsive') || 'auto';
            const childCount = components.length;
            const directionMobile = this.get('container-direction-mobile') || '';
            const direction = this.get('container-direction') || 'flex-col'; // Por defecto: columna
            
            // Detectar si el contenedor está en columna
            const isColumnOnDesktop = direction === 'flex-col' || direction === 'flex-col-reverse';
            // En móvil, por defecto siempre se apilan verticalmente (flex-col) a menos que se especifique otra dirección
            const isColumnOnMobile = directionMobile === 'flex-col' || 
                                    directionMobile === 'flex-col-reverse' ||
                                    (directionMobile === ''); // Por defecto, móvil usa flex-col
            const isRowOnDesktop = direction === 'flex-row' || direction === 'flex-row-reverse';
            
            components.forEach((component, index) => {
              const childEl = component.view ? component.view.el : null;
              if (!childEl || !childEl.classList) return;
              
              // Remover clases responsive anteriores
              const classesToRemove = [
                'flex-1', 'flex-grow', 'flex-shrink', 'flex-basis-auto',
                'w-full', 'w-auto', 'w-1/2', 'w-1/3', 'w-1/4', 'w-2/3', 'w-3/4',
                'md:w-full', 'md:w-1/2', 'md:w-1/3', 'md:w-1/4', 'md:w-2/3', 'md:w-3/4',
                'lg:w-full', 'lg:w-1/2', 'lg:w-1/3', 'lg:w-1/4', 'lg:w-2/3', 'lg:w-3/4',
                'xl:w-full', 'xl:w-1/2', 'xl:w-1/3', 'xl:w-1/4', 'xl:w-2/3', 'xl:w-3/4',
                'sm:w-full', 'sm:w-1/2', 'sm:w-1/3', 'sm:w-1/4', 'sm:w-2/3', 'sm:w-3/4',
                'md:flex-1', 'lg:flex-1', 'xl:flex-1'
              ];
              classesToRemove.forEach(cls => childEl.classList.remove(cls));
              
              // SIEMPRE aplicar w-full en móvil (por defecto responsive)
              // Tailwind es mobile-first, así que w-full se aplica desde móvil
              childEl.classList.add('w-full');
              
              // Aplicar clases responsive según el modo (estilo Elementor)
              if (responsiveMode === 'full-width') {
                // En desktop: si está en fila, usar flex-1; si está en columna, mantener w-full
                if (isRowOnDesktop) {
                  childEl.classList.add('md:flex-1');
                }
                // Si está en columna, ya tiene w-full aplicado
              } else if (responsiveMode === 'equal-responsive') {
                // En desktop: distribución equitativa según número de hijos (solo si está en fila)
                if (isRowOnDesktop) {
                  if (childCount === 2) {
                    childEl.classList.add('md:w-1/2');
                  } else if (childCount === 3) {
                    childEl.classList.add('md:w-1/2', 'lg:w-1/3');
                  } else if (childCount === 4) {
                    childEl.classList.add('md:w-1/2', 'lg:w-1/4');
                  } else if (childCount > 4) {
                    // Para más de 4 hijos, usar distribución flexible
                    childEl.classList.add('md:w-1/2', 'lg:w-1/3', 'xl:w-1/4');
                  }
                }
                // Si está en columna, ya tiene w-full aplicado
              } else {
                // Modo automático: SIEMPRE w-full en móvil
                // En desktop: si está en fila, usar flex-1; si está en columna, mantener w-full
                if (isRowOnDesktop) {
                  childEl.classList.add('md:flex-1');
                }
                // Si está en columna, ya tiene w-full aplicado
              }
              
              // Remover estilos inline de width
              childEl.style.removeProperty('width');
              childEl.style.removeProperty('max-width');
              childEl.style.removeProperty('min-width');
              childEl.removeAttribute('data-grid-item');
            });
            
            console.log('🔄 [UPDATE-LAYOUT] classList ANTES de join:', classList);
            const newClass = classList.filter(c => c).join(' ').replace(/\s+/g, ' ').trim();
            console.log('🔄 [UPDATE-LAYOUT] newClass FINAL:', newClass);
            console.log('🔄 [UPDATE-LAYOUT] Aplicando clase final al elemento');
            
            el.className = newClass;
            this.setAttributes({ class: newClass });
            
            // Forzar actualización de hijos responsive después de actualizar el layout
            setTimeout(() => {
              this.updateChildrenResponsive();
            }, 50);
          }
        },
        updateVisibleTraitsForDevice() {
          // ✅ Actualizar el valor del trait dinámico según el dispositivo actual
          console.log('🎯 [UPDATE-TRAITS] updateVisibleTraitsForDevice llamado');
          
          if (!window.editor) {
            console.warn('⚠️ [UPDATE-TRAITS] window.editor no disponible');
            return;
          }
          
          const currentDevice = window.editor.getDevice();
          let directionValue = '';
          
          if (currentDevice === 'Desktop') {
            // Obtener valor de desktop
            directionValue = this.get('container-direction') || '';
            console.log('📱 [UPDATE-TRAITS] Desktop - valor container-direction:', directionValue);
          } else if (currentDevice === 'Tablet') {
            // Obtener valor de tablet (quitar prefijo md:)
            directionValue = (this.get('container-direction-tablet') || '').replace('md:', '');
            console.log('📱 [UPDATE-TRAITS] Tablet - valor container-direction-tablet (sin md:):', directionValue);
            // ✅ Si Tablet está vacío, mostrar como vacío (no mostrar fallback)
            // El usuario puede ver que está vacío y sabe que está usando herencia
          } else if (currentDevice === 'Mobile') {
            // Obtener valor de mobile
            directionValue = this.get('container-direction-mobile') || '';
            console.log('📱 [UPDATE-TRAITS] Mobile - valor container-direction-mobile:', directionValue);
            // ✅ Si Mobile está vacío, mostrar como vacío (no mostrar fallback)
          }
          
          // Actualizar el trait dinámico sin disparar el listener
          console.log('✏️ [UPDATE-TRAITS] Estableciendo container-direction-responsive a:', directionValue);
          this.set('container-direction-responsive', directionValue, { silent: true });
          
          // ✅ Forzar actualización del trait y del input visible
          try {
            const trait = this.getTrait && this.getTrait('container-direction-responsive');
            if (trait) {
              trait.set('value', directionValue);
              if (trait.view && trait.view.el) {
                const input = trait.view.el.querySelector('select, input, textarea');
                if (input) {
                  input.value = directionValue;
                }
              }
            }
          } catch (e) {
            console.warn('⚠️ [UPDATE-TRAITS] Error actualizando input del trait:', e);
          }
          
          // Forzar re-render del TraitManager para mostrar el nuevo valor
          if (window.editor.TraitManager) {
            try {
              console.log('🎨 [UPDATE-TRAITS] Renderizando TraitManager...');
              window.editor.TraitManager.render();
            } catch (e) {
              console.warn('⚠️ [UPDATE-TRAITS] Error al renderizar TraitManager:', e);
            }
          }
        },
        updateDirection() {
          console.log('🔍 [UPDATE-DIRECTION] updateDirection() llamado');
          
          const layoutMode = this.get('container-layout-mode') || 'flex';
          console.log('🔍 [UPDATE-DIRECTION] Layout mode:', layoutMode);
          
          // Solo aplicar dirección si está en modo flex
          if (layoutMode === 'flex') {
            if (this.view && this.view.el) {
              const el = this.view.el;
              const currentAttrs = this.getAttributes();
              let currentClass = el.className || currentAttrs.class || '';
              
              console.log('🔍 [UPDATE-DIRECTION] Clase actual ANTES:', currentClass);
              
              if (!currentClass.includes('flex')) {
                currentClass = (currentClass + ' flex').trim();
              }
              
              // Remover todas las clases de dirección (incluyendo responsive)
              const classArray = currentClass.split(/\s+/).filter(c => {
                return c.trim() && 
                       !c.match(/^flex-(row|col)(-reverse)?$/) &&
                       !c.match(/^md:flex-(row|col)(-reverse)?$/) &&
                       !c.match(/^lg:flex-(row|col)(-reverse)?$/) &&
                       !c.match(/^xl:flex-(row|col)(-reverse)?$/) &&
                       !c.match(/^sm:flex-(row|col)(-reverse)?$/);
              });
              currentClass = classArray.join(' ').trim();
              
              console.log('🔍 [UPDATE-DIRECTION] Clase SIN direcciones:', currentClass);
              
              // ✅ CAMBIO: Obtener SOLO la dirección del dispositivo actual, SIN herencia
              // Cada dispositivo es independiente. La herencia solo ocurre en el UI cuando muestras el trait.
              const currentDevice = window.editor ? window.editor.getDevice() : 'Desktop';
              let directionToApply = '';
              
              if (currentDevice === 'Desktop') {
                directionToApply = this.get('container-direction') || 'flex-col';
                console.log('🔍 [UPDATE-DIRECTION] Desktop - dirección:', directionToApply);
              } else if (currentDevice === 'Tablet') {
                // En tablet, quitar md: para aplicar, pero comparar en updateDirection con herencia
                let tabletDir = this.get('container-direction-tablet') || '';
                if (!tabletDir) {
                  // Si Tablet está vacío, usar Desktop como fallback SOLO para mostrar
                  const desktopDir = this.get('container-direction') || 'flex-col';
                  tabletDir = desktopDir.includes('md:') ? desktopDir : 'md:' + desktopDir;
                  console.log('🔍 [UPDATE-DIRECTION] Tablet - heredando de Desktop:', tabletDir);
                } else {
                  console.log('🔍 [UPDATE-DIRECTION] Tablet - dirección propia:', tabletDir);
                }
                directionToApply = tabletDir;
              } else if (currentDevice === 'Mobile') {
                let mobileDir = this.get('container-direction-mobile') || '';
                if (!mobileDir) {
                  // Si Mobile está vacío, usar Tablet como fallback
                  let tabletDir = this.get('container-direction-tablet') || '';
                  if (!tabletDir) {
                    // Si Tablet también está vacío, usar Desktop
                    const desktopDir = this.get('container-direction') || 'flex-col';
                    mobileDir = desktopDir;
                  } else {
                    // Si Tablet tiene valor, quitar md: para aplicar en mobile
                    mobileDir = tabletDir.replace('md:', '');
                  }
                  console.log('🔍 [UPDATE-DIRECTION] Mobile - heredando:', mobileDir);
                } else {
                  console.log('🔍 [UPDATE-DIRECTION] Mobile - dirección propia:', mobileDir);
                }
                directionToApply = mobileDir;
              }
              
              console.log('🔍 [UPDATE-DIRECTION] Dirección a aplicar:', directionToApply);
              
              // ✅ Aplicar SOLO la dirección del dispositivo actual
              // NO hacer herencia global, cada dispositivo es independiente
              currentClass = (currentClass + ' ' + directionToApply).trim();
              
              console.log('🔍 [UPDATE-DIRECTION] Clase DESPUÉS agregar dirección:', currentClass);
              
              // Limpiar espacios múltiples y clases vacías
              const finalClassArray = currentClass.split(/\s+/).filter(c => c.trim() && c !== 'md:' && c !== 'lg:' && c !== 'xl:' && c !== 'sm:');
              currentClass = finalClassArray.join(' ').trim();
              
              console.log('🔍 [UPDATE-DIRECTION] Clase FINAL después limpiar:', currentClass);
              
              // Remover estilos inline de flex-direction que puedan interferir
              el.style.removeProperty('flex-direction');
              
              // Forzar aplicación de clases directamente en el elemento
              console.log('💾 [UPDATE-DIRECTION] Aplicando clase al elemento:', currentClass);
              el.className = currentClass;
              this.setAttributes({ class: currentClass });
              
              console.log('✅ [UPDATE-DIRECTION] updateDirection() completado');
            }
          }
        },
        updateWrap() {
          const wrap = this.get('container-wrap') || 'flex-wrap';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = el.className || currentAttrs.class || '';
            if (!currentClass.includes('flex')) {
              currentClass = (currentClass + ' flex').trim();
            }
            currentClass = currentClass.replace(/flex-(wrap|nowrap)(-reverse)?/g, '').trim();
            currentClass = (currentClass + ' ' + wrap).trim();
            currentClass = currentClass.replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateJustify() {
          const justify = this.get('container-justify') || 'justify-start';
          // Usar la dirección base de Desktop
          const direction = this.get('container-direction') || 'flex-col';
          const isColumn = direction === 'flex-col' || direction === 'flex-col-reverse';

          const mapJustifyToItems = (val) => {
            if (val.includes('start')) return 'items-start';
            if (val.includes('center')) return 'items-center';
            if (val.includes('end')) return 'items-end';
            return 'items-stretch';
          };

          const classToApply = isColumn ? mapJustifyToItems(justify) : justify;
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = el.className || currentAttrs.class || '';
            if (!currentClass.includes('flex')) {
              currentClass = (currentClass + ' flex').trim();
            }
            currentClass = currentClass
              .replace(/justify-(start|center|end|between|around|evenly)/g, '')
              .replace(/items-(start|center|end|stretch|baseline)/g, '')
              .trim();
            currentClass = (currentClass + ' ' + classToApply).trim();
            currentClass = currentClass.replace(/\s+/g, ' ');
            el.className = currentClass;
            // ✅ MEJORADO: Forzar atributo en el elemento y en el modelo
            el.setAttribute('class', currentClass);
            this.setAttributes({ class: currentClass });
            // ✅ Log para debug
            console.log('🔄 [updateJustify] Clase actualizada:', classToApply, 'Nueva clase completa:', currentClass);
          }
        },
        updateAlign() {
          const align = this.get('container-align') || 'items-start';
          const direction = this.get('container-direction') || 'flex-col';
          const isColumn = direction === 'flex-col' || direction === 'flex-col-reverse';

          const mapItemsToJustify = (val) => {
            if (val.includes('start')) return 'justify-start';
            if (val.includes('center')) return 'justify-center';
            if (val.includes('end')) return 'justify-end';
            return 'justify-start';
          };

          const classToApply = isColumn ? mapItemsToJustify(align) : align;
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = el.className || currentAttrs.class || '';
            if (!currentClass.includes('flex')) {
              currentClass = (currentClass + ' flex').trim();
            }
            currentClass = currentClass
              .replace(/items-(start|center|end|stretch|baseline)/g, '')
              .replace(/justify-(start|center|end|between|around|evenly)/g, '')
              .trim();
            currentClass = (currentClass + ' ' + classToApply).trim();
            currentClass = currentClass.replace(/\s+/g, ' ');
            el.className = currentClass;
            // ✅ MEJORADO: Forzar atributo en el elemento y en el modelo
            el.setAttribute('class', currentClass);
            this.setAttributes({ class: currentClass });
            // ✅ Log para debug
            console.log('🔄 [updateAlign] Clase actualizada:', classToApply, 'Nueva clase completa:', currentClass);
          }
        },
        updateGap() {
          const gap = this.get('container-gap') || 'gap-4';
          const layoutMode = this.get('container-layout-mode') || 'flex';
          
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = el.className || currentAttrs.class || '';
            
            // Remover gap anterior (tanto gap-4 como gap-[10px])
            currentClass = currentClass.replace(/gap-[0-9]+|gap-\[\d+px\]/g, '').trim();
            
            // Agregar nuevo gap
            currentClass = (currentClass + ' ' + gap).trim();
            currentClass = currentClass.replace(/\s+/g, ' ');
            
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateWidth() {
          const width = this.get('container-width') || 'w-full';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = el.className || currentAttrs.class || '';
            if (!currentClass.includes('flex')) {
              currentClass = (currentClass + ' flex').trim();
            }
            currentClass = currentClass.replace(/w-(full|auto)|container|max-w-(7xl|6xl|4xl|2xl|xl)/g, '').trim();
            if (width) {
              currentClass = (currentClass + ' ' + width).trim();
            }
            currentClass = currentClass.replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updatePadding() {
          const padding = this.get('container-padding');
          console.log('🎨 [UPDATE-PADDING] Llamado con padding:', padding);
          
          if (!padding) {
            console.log('⏭️ [UPDATE-PADDING] Sin padding en modelo - manteniendo HTML');
            return;
          }
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = el.className || currentAttrs.class || '';
            
            console.log('📋 [UPDATE-PADDING] Clase antes:', currentClass);
            
            if (!currentClass.includes('flex')) {
              currentClass = (currentClass + ' flex').trim();
            }
            
            // 🔧 Remover TODAS las clases de padding (con y sin corchetes)
            // Usar split/filter para evitar problemas con regex y caracteres especiales
            const classList = currentClass.split(' ').filter(c => {
              // Remover si es p-[10px], p-0, p-2, p-4, etc.
              return !c.match(/^p-(\d+|\[\d+px\])$/);
            });
            
            // Reconstruir y agregar el nuevo padding
            currentClass = classList.join(' ') + ' ' + padding;
            currentClass = currentClass.replace(/\s+/g, ' ').trim();
            
            console.log('📋 [UPDATE-PADDING] Clase después:', currentClass);
            
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateMargin() {
          const margin = this.get('container-margin') || '';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = el.className || currentAttrs.class || '';
            if (!currentClass.includes('flex')) {
              currentClass = (currentClass + ' flex').trim();
            }
            currentClass = currentClass.replace(/mx-auto|m-[0-9]+/g, '').trim();
            if (margin) {
              currentClass = (currentClass + ' ' + margin).trim();
            }
            currentClass = currentClass.replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        // Helper para convertir color (hex/rgb/rgba) a RGB
        hexToRgb(color) {
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
        },
        updateBackground() {
          console.log('🔄 [updateBackground] Iniciando...');
          
          let imageUrl = (this.get('container-bg-image') || '').trim();
          const bgSize = this.get('container-bg-size') || 'cover';
          const bgPosition = this.get('container-bg-position') || 'center center';
          const bgRepeat = this.get('container-bg-repeat') || 'no-repeat';
          const bgAttachment = this.get('container-bg-attachment') || 'scroll';
          let bgColor = (this.get('container-bg-color') || '').trim();
          let bgColorOpacity = parseFloat(this.get('container-bg-color-opacity') || '100'); // Transparencia del color 0-100

          // ✅ NUEVO: Fallback PRIORITARIO desde data-attributes (más confiable que el modelo)
          if (this.view && this.view.el) {
            const el = this.view.el;
            
            // 1. Intentar desde data-attributes primero (valores guardados persistentes)
            const dataOverlayColor = el.getAttribute('data-bg-overlay-color');
            const dataOverlayOpacity = el.getAttribute('data-bg-overlay-opacity');
            
            if (dataOverlayColor && !bgColor) {
              bgColor = dataOverlayColor.trim();
              console.log('🔍 [updateBackground] Color recuperado desde data-attribute:', bgColor);
              this.set('container-bg-color', bgColor, { silent: true });
            }
            
            if (dataOverlayOpacity && !Number.isFinite(bgColorOpacity)) {
              bgColorOpacity = parseFloat(dataOverlayOpacity);
              console.log('🔍 [updateBackground] Opacity recuperada desde data-attribute:', bgColorOpacity);
              this.set('container-bg-color-opacity', bgColorOpacity, { silent: true });
            }
            
            // 2. Si aún no hay datos, intentar desde inline style
            if (!imageUrl || !bgColor) {
              const inlineStyle = el.getAttribute('style') || '';
              const styleMap = inlineStyle.split(';').reduce((acc, part) => {
                const [k, v] = part.split(':').map(s => (s || '').trim());
                if (k) acc[k] = v || '';
                return acc;
              }, {});
              
              if (!imageUrl) {
                const bgImg = styleMap['background-image'] || el.style.backgroundImage;
                if (bgImg && bgImg.includes('url(')) {
                  // Extraer solo la URL, sin el linear-gradient
                  const urlMatch = bgImg.match(/url\(["']?([^"')]+)["']?\)/);
                  if (urlMatch) {
                    imageUrl = urlMatch[1].trim();
                    console.log('🔍 [updateBackground] Imagen recuperada desde inline style:', imageUrl);
                    this.set('container-bg-image', imageUrl, { silent: true });
                  }
                }
              }
              
              if (!bgColor) {
                const bgCol = styleMap['background-color'] || el.style.backgroundColor;
                if (bgCol) {
                  bgColor = bgCol.trim();
                  console.log('🔍 [updateBackground] Color recuperado desde background-color:', bgColor);
                  this.set('container-bg-color', bgColor, { silent: true });
                }
              }
            }
          }
          
          console.log('🔍 [updateBackground] Valores finales:', {
            imageUrl: imageUrl.substring(0, 50),
            bgColor,
            bgColorOpacity
          });

          const style = { ...(this.getStyle() || {}) };

          // Calcular linear-gradient con overlay si hay imagen + color
          const rgbForOverlay = this.hexToRgb(bgColor);
          const opacityForOverlay = Number.isFinite(bgColorOpacity)
            ? Math.min(100, Math.max(0, bgColorOpacity)) / 100
            : 1;
          const overlayGradient = (imageUrl && bgColor && rgbForOverlay)
            ? `linear-gradient(rgba(${rgbForOverlay.r}, ${rgbForOverlay.g}, ${rgbForOverlay.b}, ${opacityForOverlay}), rgba(${rgbForOverlay.r}, ${rgbForOverlay.g}, ${rgbForOverlay.b}, ${opacityForOverlay})), url("${imageUrl}")`
            : null;

          // Aplicar imagen de fondo si existe
          if (imageUrl) {
            // ✅ Si hay color + imagen, usar linear-gradient; si solo imagen, usar url()
            if (overlayGradient) {
              style['background-image'] = overlayGradient;
              console.log('🎨 [updateBackground] Aplicando linear-gradient al modelo:', overlayGradient.substring(0, 100));
            } else {
              style['background-image'] = `url("${imageUrl}")`;
            }
            style['background-size'] = bgSize;
            style['background-position'] = bgPosition;
            style['background-repeat'] = bgRepeat;
            style['background-attachment'] = bgAttachment;
            style['position'] = 'relative'; // Necesario para overlay
          } else {
            delete style['background-image'];
            delete style['background-size'];
            delete style['background-position'];
            delete style['background-repeat'];
            delete style['background-attachment'];
          }

          // ✅ NUEVO: Si hay AMBOS imagen y color, NO usar background-color
          // En su lugar, se usará un overlay ::before con transparencia
          if (bgColor && !imageUrl) {
            // SOLO color (sin imagen)
            style['background-color'] = bgColor;
          } else if (bgColor && imageUrl) {
            // Imagen + Color: NO usar background-color, será un overlay
            delete style['background-color'];
            console.log('🎨 [updateBackground] Imagen + Color: usando linear-gradient en modelo');
          } else {
            delete style['background-color'];
          }

          this.setStyle(style);

          // Persistir también como inline style para asegurar render en página real
          const attrs = this.getAttributes() || {};
          const inline = (attrs.style || '').split(';').reduce((acc, part) => {
            const [k, v] = part.split(':').map(s => (s || '').trim());
            if (k && !k.startsWith('background')) acc[k] = v || '';
            return acc;
          }, {});

          // Aplicar imagen
          if (imageUrl) {
            // ✅ Si hay overlay, usar linear-gradient; si solo imagen, usar url()
            if (overlayGradient) {
              inline['background-image'] = overlayGradient;
            } else {
              inline['background-image'] = `url("${imageUrl}")`;
            }
            inline['background-size'] = bgSize;
            inline['background-position'] = bgPosition;
            inline['background-repeat'] = bgRepeat;
            inline['background-attachment'] = bgAttachment;
            inline['position'] = 'relative';
          } else {
            delete inline['background-image'];
            delete inline['background-size'];
            delete inline['background-position'];
            delete inline['background-repeat'];
            delete inline['background-attachment'];
          }

          // ✅ Aplicar color SOLO si no hay imagen
          if (bgColor && !imageUrl) {
            inline['background-color'] = bgColor;
          } else {
            delete inline['background-color'];
          }

          const inlineStyle = Object.entries(inline)
            .filter(([k, v]) => k && v)
            .map(([k, v]) => `${k}: ${v}`)
            .join('; ');

          this.setAttributes({ style: inlineStyle });

          // Aplicar en el DOM también (para el canvas del editor)
          if (this.view && this.view.el) {
            const el = this.view.el;
            
            console.log('🔍 [updateBackground] Aplicando en DOM:', {
              hasImage: !!imageUrl,
              hasColor: !!bgColor,
              hasOverlay: !!overlayGradient,
              opacity: bgColorOpacity,
              overlayPreview: overlayGradient ? overlayGradient.substring(0, 80) + '...' : 'none'
            });
            
            // Imagen
            if (imageUrl) {
              if (overlayGradient) {
                el.style.setProperty('background-image', overlayGradient, 'important');
                console.log('✅ [updateBackground] linear-gradient aplicado al DOM con !important');
              } else {
                el.style.setProperty('background-image', `url("${imageUrl}")`, 'important');
                console.log('✅ [updateBackground] url() simple aplicado al DOM');
              }
              el.style.setProperty('background-size', bgSize, 'important');
              el.style.setProperty('background-position', bgPosition, 'important');
              el.style.setProperty('background-repeat', bgRepeat, 'important');
              el.style.setProperty('background-attachment', bgAttachment, 'important');
              el.style.setProperty('position', 'relative', 'important');
            } else {
              el.style.removeProperty('background-image');
              el.style.removeProperty('background-size');
              el.style.removeProperty('background-position');
              el.style.removeProperty('background-repeat');
              el.style.removeProperty('background-attachment');
            }

            // Color - SOLO si no hay imagen
            if (bgColor && !imageUrl) {
              el.style.setProperty('background-color', bgColor, 'important');
            } else {
              el.style.removeProperty('background-color');
            }

            // ✅ Verificar qué valor tiene realmente en el DOM después de aplicar
            const computedBgImage = el.style.backgroundImage;
            console.log('🔎 [updateBackground] Valor REAL en DOM después de aplicar:', {
              backgroundImage: computedBgImage ? computedBgImage.substring(0, 100) + '...' : 'none',
              hasLinearGradient: computedBgImage ? computedBgImage.includes('linear-gradient') : false,
              hasUrl: computedBgImage ? computedBgImage.includes('url(') : false
            });

            // ✅ NUEVO: Si hay imagen + color, crear overlay con ::before
            if (bgColor && imageUrl) {
              // Generar o reutilizar ID único para el overlay
              let overlayId = el.getAttribute('data-bg-overlay');
              if (!overlayId) {
                overlayId = `overlay-${this.ccid || Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
              }
              
              // ✅ SIEMPRE actualizar los data-attributes (para que persistan al arrastrar)
              el.setAttribute('data-bg-overlay', overlayId);
              el.setAttribute('data-bg-overlay-color', bgColor);
              el.setAttribute('data-bg-overlay-opacity', String(bgColorOpacity));
              
              console.log('💾 [updateBackground] Data-attributes actualizados:', {
                overlayId,
                color: bgColor,
                opacity: bgColorOpacity
              });
              
              // También actualizar en el modelo de atributos
              if (typeof this.addAttributes === 'function') {
                this.addAttributes({
                  'data-bg-overlay': overlayId,
                  'data-bg-overlay-color': bgColor,
                  'data-bg-overlay-opacity': String(bgColorOpacity)
                });
              }
              
              // Convertir opacity de porcentaje (0-100) a decimal (0-1)
              const opacity = Number.isFinite(bgColorOpacity)
                ? Math.min(100, Math.max(0, bgColorOpacity)) / 100
                : 1;
              const rgbColor = this.hexToRgb(bgColor);
              
              if (rgbColor) {
                // ✅ IMPORTANTE: El canvas está en un iframe, necesitamos el documento del iframe
                const canvasDoc = el.ownerDocument || document;
                
                // Crear CSS inline para el overlay en el documento del canvas
                let styleTag = canvasDoc.getElementById('overlay-styles');
                if (!styleTag) {
                  styleTag = canvasDoc.createElement('style');
                  styleTag.id = 'overlay-styles';
                  canvasDoc.head.appendChild(styleTag);
                }
                
                // Eliminar regla anterior de este overlay si existe
                const oldRule = `[data-bg-overlay="${overlayId}"]::before`;
                if (styleTag.textContent.includes(oldRule)) {
                  // Limpiar regla vieja (simple replace)
                  const lines = styleTag.textContent.split('\n');
                  let inBlock = false;
                  const newLines = [];
                  for (let line of lines) {
                    if (line.includes(oldRule)) {
                      inBlock = true;
                    }
                    if (!inBlock) {
                      newLines.push(line);
                    }
                    if (inBlock && line.includes('}')) {
                      inBlock = false;
                    }
                  }
                  styleTag.textContent = newLines.join('\n');
                }
                
                // Agregar regla CSS actualizada para este overlay específico
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
                
                styleTag.textContent += cssRule;
                
                console.log('🎨 [Overlay] Aplicado con transparencia:', {
                  id: overlayId,
                  color: bgColor,
                  opacity: bgColorOpacity + '%',
                  rgba: `rgba(${rgbColor.r}, ${rgbColor.g}, ${rgbColor.b}, ${opacity})`,
                  document: canvasDoc === document ? 'MAIN' : 'IFRAME'
                });
              }
            } else {
              // ✅ Limpiar data-attributes si ya no hay imagen + color
              if (!imageUrl || !bgColor) {
                console.log('🧹 [updateBackground] Limpiando data-attributes (no hay imagen+color)');
                el.removeAttribute('data-bg-overlay');
                el.removeAttribute('data-bg-overlay-color');
                el.removeAttribute('data-bg-overlay-opacity');
              }
            }
          }
        },
        updateTextColors() {
          const titleColor = (this.get('container-title-color') || '').trim();
          const textColor = (this.get('container-text-color') || '').trim();

          console.log('🎨 [updateTextColors] Ejecutado:');
          console.log('  → titleColor:', titleColor);
          console.log('  → textColor:', textColor);

          if (!this.view || !this.view.el) {
            console.log('  ⚠️ No hay view o elemento disponible');
            return;
          }

          const el = this.view.el;

          // Buscar elementos con clase de título
          const titleElements = el.querySelectorAll('[data-type="title"], .container-title, h1, h2, h3, h4, h5, h6');
          console.log('  📝 Elementos título encontrados:', titleElements.length);
          titleElements.forEach((titleEl, i) => {
            if (titleColor) {
              titleEl.style.setProperty('color', titleColor, 'important');
              console.log(`    → Título ${i}: color aplicado`);
            } else {
              titleEl.style.removeProperty('color');
            }
          });

          // Buscar elementos con clase de texto
          const textElements = el.querySelectorAll('[data-type="text"], .container-text, p, .paragraph');
          console.log('  📄 Elementos texto encontrados:', textElements.length);
          textElements.forEach((textEl, i) => {
            if (textColor) {
              textEl.style.setProperty('color', textColor, 'important');
              console.log(`    → Texto ${i}: color aplicado`);
            } else {
              textEl.style.removeProperty('color');
            }
          });
        },
        updateChildrenResponsive() {
          // Función auxiliar para actualizar clases responsive de los hijos
          const layoutMode = this.get('container-layout-mode') || 'flex';
          if (layoutMode !== 'flex') return; // Solo para modo flex
          
          if (!this.view || !this.view.el) return;
          
          const components = this.components();
          const responsiveMode = this.get('container-children-responsive') || 'auto';
          const childCount = components.length;
          const directionMobile = this.get('container-direction-mobile') || '';
          const direction = this.get('container-direction') || 'flex-col'; // Por defecto: columna
          
          // Detectar si el contenedor está en columna
          const isColumnOnDesktop = direction === 'flex-col' || direction === 'flex-col-reverse';
          // En móvil, por defecto siempre se apilan verticalmente (flex-col) a menos que se especifique otra dirección
          const isColumnOnMobile = directionMobile === 'flex-col' || 
                                  directionMobile === 'flex-col-reverse' ||
                                  (directionMobile === ''); // Por defecto, móvil usa flex-col
          const isRowOnDesktop = direction === 'flex-row' || direction === 'flex-row-reverse';
          
          components.forEach((component, index) => {
            const childEl = component.view ? component.view.el : null;
            if (!childEl || !childEl.classList) return;
            
            // Remover clases responsive anteriores
            const classesToRemove = [
              'flex-1', 'flex-grow', 'flex-shrink', 'flex-basis-auto',
              'w-full', 'w-auto', 'w-1/2', 'w-1/3', 'w-1/4', 'w-2/3', 'w-3/4',
              'md:w-full', 'md:w-1/2', 'md:w-1/3', 'md:w-1/4', 'md:w-2/3', 'md:w-3/4',
              'lg:w-full', 'lg:w-1/2', 'lg:w-1/3', 'lg:w-1/4', 'lg:w-2/3', 'lg:w-3/4',
              'xl:w-full', 'xl:w-1/2', 'xl:w-1/3', 'xl:w-1/4', 'xl:w-2/3', 'xl:w-3/4',
              'sm:w-full', 'sm:w-1/2', 'sm:w-1/3', 'sm:w-1/4', 'sm:w-2/3', 'sm:w-3/4',
              'md:flex-1', 'lg:flex-1', 'xl:flex-1'
            ];
            classesToRemove.forEach(cls => childEl.classList.remove(cls));
            
            // SIEMPRE aplicar w-full en móvil (por defecto responsive)
            // Tailwind es mobile-first, así que w-full se aplica desde móvil
            childEl.classList.add('w-full');
            
            // Aplicar clases responsive según el modo (estilo Elementor)
            if (responsiveMode === 'full-width') {
              // En desktop: si está en fila, usar flex-1; si está en columna, mantener w-full
              if (isRowOnDesktop) {
                childEl.classList.add('md:flex-1');
              }
              // Si está en columna, ya tiene w-full aplicado
            } else if (responsiveMode === 'equal-responsive') {
              // En desktop: distribución equitativa según número de hijos (solo si está en fila)
              if (isRowOnDesktop) {
                if (childCount === 2) {
                  childEl.classList.add('md:w-1/2');
                } else if (childCount === 3) {
                  childEl.classList.add('md:w-1/2', 'lg:w-1/3');
                } else if (childCount === 4) {
                  childEl.classList.add('md:w-1/2', 'lg:w-1/4');
                } else if (childCount > 4) {
                  // Para más de 4 hijos, usar distribución flexible
                  childEl.classList.add('md:w-1/2', 'lg:w-1/3', 'xl:w-1/4');
                }
              }
              // Si está en columna, ya tiene w-full aplicado
            } else {
              // Modo automático: SIEMPRE w-full en móvil
              // En desktop: si está en fila, usar flex-1; si está en columna, mantener w-full
              if (isRowOnDesktop) {
                childEl.classList.add('md:flex-1');
              }
              // Si está en columna, ya tiene w-full aplicado
            }
            
            // Remover estilos inline de width para que las clases de Tailwind funcionen
            childEl.style.removeProperty('width');
            childEl.style.removeProperty('max-width');
            childEl.style.removeProperty('min-width');
          });
        }
      }
    });
    
  }
  
  if (typeof window !== 'undefined' && window.editor) {
    registerContainerComponent(window.editor);
  } else {
    const checkEditor = setInterval(() => {
      if (typeof window !== 'undefined' && window.editor) {
        registerContainerComponent(window.editor);
        clearInterval(checkEditor);
      }
    }, 100);
    
    setTimeout(() => {
      clearInterval(checkEditor);
    }, 10000);
  }
  
  if (typeof window !== 'undefined') {
    window.registerContainerComponent = registerContainerComponent;
    
    // 🎯 Función para verificar configuración responsive del contenedor seleccionado
    window.showContainerResponsiveConfig = function() {
      if (!window.editor) {
        console.error('❌ Editor no disponible');
        return;
      }
      
      const selected = window.editor.getSelected();
      if (!selected || selected.get('type') !== 'container') {
        console.log('%c⚠️ Selecciona un contenedor primero', 'color: #ff6b6b; font-weight: bold;');
        return;
      }
      
      const currentDevice = window.editor.getDevice();
      const direction = selected.get('container-direction') || 'No definido';
      const directionTablet = selected.get('container-direction-tablet') || 'No definido';
      const directionMobile = selected.get('container-direction-mobile') || 'No definido';
      const layoutMode = selected.get('container-layout-mode') || 'flex';
      const gap = selected.get('container-gap') || 'gap-4';
      
      console.log('%c━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━', 'color: #4dabf7; font-weight: bold;');
      console.log('%c📊 CONFIGURACIÓN RESPONSIVE DEL CONTENEDOR', 'color: #4dabf7; font-size: 16px; font-weight: bold;');
      console.log('%c━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━', 'color: #4dabf7; font-weight: bold;');
      console.log('%cDispositivo Activo: ' + currentDevice, 'color: #51cf66; font-weight: bold; font-size: 14px;');
      console.log('%c━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━', 'color: #4dabf7;');
      console.log('%c🖥️  DESKTOP:', 'color: #4dabf7; font-weight: bold;');
      console.log(`   Dirección: ${direction}`);
      console.log('%c📱 TABLET (768px+):', 'color: #4dabf7; font-weight: bold;');
      console.log(`   Dirección: ${directionTablet}`);
      console.log('%c📱 MÓVIL (< 768px):', 'color: #4dabf7; font-weight: bold;');
      console.log(`   Dirección: ${directionMobile}`);
      console.log('%c━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━', 'color: #4dabf7;');
      console.log('%cModo Layout: ' + layoutMode, 'color: #51cf66;');
      console.log('%cEspacio entre elementos: ' + gap, 'color: #51cf66;');
      console.log('%c━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━', 'color: #4dabf7; font-weight: bold;');
    };
  }
})();

// ✅ Función global para verificar configuración responsive (AFUERA del IIFE)
window.showContainerResponsiveConfig = function() {
  if (!window.editor) {
    console.error('❌ Editor no disponible');
    return;
  }
  
  const selected = window.editor.getSelected();
  if (!selected || selected.get('type') !== 'container') {
    console.log('%c⚠️ Selecciona un contenedor primero', 'color: #ff6b6b; font-weight: bold;');
    return;
  }
  
  const currentDevice = window.editor.getDevice();
  const direction = selected.get('container-direction') || 'No definido';
  const directionTablet = selected.get('container-direction-tablet') || 'No definido';
  const directionMobile = selected.get('container-direction-mobile') || 'No definido';
  const layoutMode = selected.get('container-layout-mode') || 'flex';
  const gap = selected.get('container-gap') || 'gap-4';
  
  console.log('%c━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━', 'color: #4dabf7; font-weight: bold;');
  console.log('%c📊 CONFIGURACIÓN RESPONSIVE DEL CONTENEDOR', 'color: #4dabf7; font-size: 16px; font-weight: bold;');
  console.log('%c━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━', 'color: #4dabf7; font-weight: bold;');
  console.log('%cDispositivo Activo: ' + currentDevice, 'color: #51cf66; font-weight: bold; font-size: 14px;');
  console.log('%c━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━', 'color: #4dabf7;');
  console.log('%c🖥️  DESKTOP:', 'color: #4dabf7; font-weight: bold;');
  console.log(`   Dirección: ${direction}`);
  console.log('%c📱 TABLET (768px+):', 'color: #4dabf7; font-weight: bold;');
  console.log(`   Dirección: ${directionTablet}`);
  console.log('%c📱 MÓVIL (< 768px):', 'color: #4dabf7; font-weight: bold;');
  console.log(`   Dirección: ${directionMobile}`);
  console.log('%c━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━', 'color: #4dabf7;');
  console.log('%cModo Layout: ' + layoutMode, 'color: #51cf66;');
  console.log('%cEspacio entre elementos: ' + gap, 'color: #51cf66;');
  console.log('%c━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━', 'color: #4dabf7; font-weight: bold;');
};