// Módulo del Componente YouTube Video
// Componente de video de YouTube embebido

(function() {
  'use strict';
  
  function registerYouTubeVideoComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente YouTube Video');
      return;
    }
    
    editor.DomComponents.addType('youtube-video', {
      isComponent: (el) => {
        if (el.tagName === 'DIV' && (el.classList.contains('youtube-container') || el.getAttribute('data-gjs-type') === 'youtube-video')) {
          return { type: 'youtube-video' };
        }
      },
      model: {
        defaults: {
          name: 'YouTube',
          icon: '<i class="fa fa-youtube-play"></i>',
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
            'data-gjs-type': 'youtube-video',
            'data-gjs-name': 'YouTube',
            'data-gjs-editable': 'false'
          },
          'video-id': 'dQw4w9WgXcQ',
          'aspect-ratio': '56.25',
          'autoplay': false,
          'controls': '1',
          traits: [
            {
              type: 'text',
              name: 'video-id',
              label: 'ID del Video de YouTube',
              placeholder: 'Ej: dQw4w9WgXcQ',
              changeProp: 1
            },
            {
              type: 'select',
              name: 'aspect-ratio',
              label: 'Proporción',
              changeProp: 1,
              options: [
                { value: '56.25', name: '16:9 (Estándar)' },
                { value: '75', name: '4:3 (Clásico)' },
                { value: '100', name: '1:1 (Cuadrado)' }
              ]
            },
            {
              type: 'checkbox',
              name: 'autoplay',
              label: 'Reproducir automáticamente',
              changeProp: 1
            },
            {
              type: 'checkbox',
              name: 'controls',
              label: 'Mostrar controles',
              changeProp: 1,
              valueTrue: '1',
              valueFalse: '0'
            }
          ]
        },
        init() {
          console.log('🎬 Inicializando componente de YouTube...');
          
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
          
          const iframe = findIframe(this);
          if (iframe) {
            const src = iframe.getAttributes().src || '';
            const match = src.match(/embed\/([^?&]+)/);
            if (match && match[1]) {
              this.set('video-id', match[1], { silent: true });
              console.log('📺 Video ID extraído del iframe:', match[1]);
            }
          }
          
          this.on('change:video-id', this.handleVideoIdChange);
          this.on('change:aspect-ratio', this.handleAspectRatioChange);
          this.on('change:autoplay', this.handleAutoplayChange);
          this.on('change:controls', this.handleControlsChange);
          
          const traits = this.get('traits');
          console.log('✅ Componente YouTube inicializado:', {
            traits: traits,
            cantidadTraits: traits?.length || 0,
            videoId: this.get('video-id'),
            aspectRatio: this.get('aspect-ratio'),
            selectable: this.get('selectable'),
            hoverable: this.get('hoverable')
          });
          
          // Proteger elementos internos (iframe y contenedores)
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
                console.log('📺 Iframe de YouTube protegido');
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
          
          this.handleAspectRatioChange();
        },
        handleVideoIdChange() {
          const videoId = this.get('video-id');
          const autoplay = this.get('autoplay') ? '1' : '0';
          const controls = this.get('controls') || '1';
          
          console.log('📺 Cambiando video ID a:', videoId);
          console.log('   Autoplay:', autoplay);
          console.log('   Controls:', controls);
          
          if (videoId && videoId.trim()) {
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
            
            const iframe = findIframe(this);
            console.log('🔍 Iframe encontrado:', !!iframe);
            
            if (iframe) {
              const newSrc = `https://www.youtube.com/embed/${videoId.trim()}?autoplay=${autoplay}&controls=${controls}`;
              
              iframe.addAttributes({
                src: newSrc,
                allow: 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture',
                allowfullscreen: ''
              });
              
              if (iframe.view && iframe.view.el) {
                const el = iframe.view.el;
                const parent = el.parentNode;
                const classes = el.className;
                
                const newIframe = document.createElement('iframe');
                newIframe.src = newSrc;
                newIframe.className = classes;
                newIframe.setAttribute('frameborder', '0');
                newIframe.setAttribute('allowfullscreen', '');
                newIframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
                
                if (parent) {
                  parent.replaceChild(newIframe, el);
                  iframe.view.el = newIframe;
                  console.log('🎬 Iframe reemplazado completamente en el DOM');
                } else {
                  el.setAttribute('src', '');
                  setTimeout(() => {
                    el.setAttribute('src', newSrc);
                    el.src = newSrc;
                  }, 10);
                  console.log('🎬 Src del iframe actualizado con delay');
                }
              }
              
              console.log('✅ URL del iframe actualizada:', newSrc);
            } else {
              console.warn('⚠️ No se encontró el iframe dentro del componente');
              console.log('   Componentes hijos:', this.components().length);
            }
          }
        },
        handleAspectRatioChange() {
          const aspectRatio = this.get('aspect-ratio') || '56.25';
          console.log('🎨 handleAspectRatioChange llamado, aspectRatio:', aspectRatio);
          
          const wrapper = this.components().at(0);
          console.log('   Wrapper encontrado:', !!wrapper);
          
          if (wrapper) {
            const currentStyle = wrapper.getAttributes().style || '';
            console.log('   Estilo actual del wrapper:', currentStyle);
            
            const styleObj = {};
            
            if (currentStyle) {
              currentStyle.split(';').forEach(rule => {
                const [prop, val] = rule.split(':').map(s => s.trim());
                if (prop && val) {
                  styleObj[prop] = val;
                }
              });
            }
            
            styleObj['padding-bottom'] = `${aspectRatio}%`;
            
            const newStyle = Object.entries(styleObj)
              .map(([prop, val]) => `${prop}: ${val}`)
              .join('; ');
            
            console.log('   Nuevo estilo calculado:', newStyle);
            
            wrapper.addAttributes({ style: newStyle });
            
            const verifyStyle = wrapper.getAttributes().style;
            console.log('✅ Estilo verificado después de aplicar:', verifyStyle);
            
            if (wrapper.view && wrapper.view.el) {
              wrapper.view.el.style.paddingBottom = `${aspectRatio}%`;
              console.log('   ✅ Estilo aplicado también al DOM directamente');
            }
          } else {
            console.error('❌ No se encontró el wrapper del componente YouTube');
          }
        },
        handleAutoplayChange() {
          this.handleVideoIdChange();
        },
        handleControlsChange() {
          this.handleVideoIdChange();
        }
      },
      view: {
        onRender() {
          const el = this.el;
          console.log('🎨 Vista de YouTube renderizada:', {
            elemento: el,
            classes: el.className,
            selectable: this.model.get('selectable')
          });

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
            const containers = container.querySelectorAll('.youtube-container, .youtube-wrapper');
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
          
          this._youtubeObserver = observer;

          el.addEventListener('click', (e) => {
            console.log('🖱️ Clic detectado en componente YouTube');
            e.stopPropagation();

            if (window.editor) {
              window.editor.select(this.model);
              console.log('✅ Componente YouTube seleccionado manualmente');
            }
          });
          
          setTimeout(() => {
            this.model.handleAspectRatioChange();
            console.log('✅ Aspect ratio aplicado al renderizar');
          }, 100);
          
          console.log('✅ Vista de YouTube lista (sin modificar pointer-events)');
        },
        onRemove() {
          if (this._youtubeObserver) {
            this._youtubeObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  if (typeof window !== 'undefined' && window.editor) {
    registerYouTubeVideoComponent(window.editor);
  } else {
    const checkEditor = setInterval(() => {
      if (typeof window !== 'undefined' && window.editor) {
        registerYouTubeVideoComponent(window.editor);
        clearInterval(checkEditor);
      }
    }, 100);
    
    setTimeout(() => {
      clearInterval(checkEditor);
    }, 10000);
  }
  
  if (typeof window !== 'undefined') {
    window.registerYouTubeVideoComponent = registerYouTubeVideoComponent;
  }
})();
