// Módulo del Componente Video Unificado
// Componente de video que soporta HTML5, YouTube y Vimeo

(function() {
  'use strict';
  
  function registerVideoComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Video');
      return;
    }
    
    editor.DomComponents.addType('video', {
      isComponent: (el) => {
        // Detectar video HTML5
        if (el.tagName === 'VIDEO') {
          return { type: 'video' };
        }
        // Detectar contenedor de video
        if (el.tagName === 'DIV' && (
          el.classList.contains('video-container') || 
          el.classList.contains('youtube-container') ||
          el.classList.contains('vimeo-container') ||
          el.getAttribute('data-gjs-type') === 'video'
        )) {
          return { type: 'video' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Video',
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
            'data-gjs-type': 'video',
            'data-gjs-name': 'Video',
            'data-gjs-editable': 'false'
          },
          'video-type': 'html5',  // html5, youtube, vimeo
          'video-url': '',
          'video-id': '',
          'aspect-ratio': '56.25',
          'autoplay': false,
          'controls': true,
          'loop': false,
          'muted': false,
          traits: [
            {
              type: 'select',
              name: 'video-type',
              label: 'Tipo de Video',
              changeProp: 1,
              options: [
                { value: 'html5', name: 'Video HTML5' },
                { value: 'youtube', name: 'YouTube' },
                { value: 'vimeo', name: 'Vimeo' }
              ]
            },
            {
              type: 'button',
              name: 'select-video',
              label: '📁 Seleccionar Video (HTML5)',
              text: 'Abrir Galería de Videos',
              full: true,
              command: (editor) => {
                const component = editor.getSelected();
                if (component && component.get('type') === 'video') {
                  const am = editor.AssetManager;
                  const modal = editor.Modal;
                  
                  fetch('/creator/media/api/list')
                    .then(response => response.json())
                    .then(data => {
                      if (data.success && data.files && data.files.length > 0) {
                        am.getAll().reset();
                        // Filtrar solo videos
                        const videoFiles = data.files.filter(file => {
                          const ext = file.filename.split('.').pop().toLowerCase();
                          return ['mp4', 'webm', 'ogg', 'mov', 'avi'].includes(ext);
                        });
                        
                        videoFiles.forEach(file => {
                          am.add({
                            type: 'video',
                            src: file.url,
                            name: file.filename
                          });
                        });
                        console.log('✅ Videos cargados desde biblioteca:', videoFiles.length);
                      } else {
                        console.warn('⚠️ No se encontraron videos en la biblioteca');
                      }
                      
                      const onClickHandler = (asset) => {
                        let newSrc = null;
                        if (typeof asset.get === 'function') {
                          newSrc = asset.get('src') || asset.get('url');
                        }
                        if (!newSrc) {
                          newSrc = asset.src || asset.url || (asset.el && asset.el.src);
                        }
                        if (!newSrc && asset.attributes) {
                          newSrc = asset.attributes.src || asset.attributes.url;
                        }
                        
                        if (newSrc && component) {
                          // Cambiar a tipo HTML5 si no lo está
                          if (component.get('video-type') !== 'html5') {
                            component.set('video-type', 'html5', { silent: false });
                          }
                          component.set('video-url', newSrc, { silent: false });
                          component.updateVideoType();
                          modal.close();
                          setTimeout(() => {
                            if (editor.TraitManager) {
                              editor.TraitManager.render();
                            }
                          }, 150);
                        }
                      };
                      
                      am.onClick(onClickHandler);
                      modal.setTitle('Seleccionar Video desde Galería')
                        .setContent(am.render())
                        .open();
                      
                      console.log('✅ Galería de videos abierta');
                    })
                    .catch(error => {
                      console.error('❌ Error al cargar videos desde la biblioteca:', error);
                      am.onClick((asset) => {
                        let newSrc = asset.get('src') || asset.get('url') || asset.src || asset.url;
                        if (newSrc && component) {
                          if (component.get('video-type') !== 'html5') {
                            component.set('video-type', 'html5', { silent: false });
                          }
                          component.set('video-url', newSrc, { silent: false });
                          component.updateVideoType();
                          modal.close();
                          setTimeout(() => {
                            if (editor.TraitManager) {
                              editor.TraitManager.render();
                            }
                          }, 150);
                        }
                      });
                      modal.setTitle('Seleccionar Video desde Galería')
                        .setContent(am.render())
                        .open();
                    });
                }
              }
            },
            {
              type: 'text',
              name: 'video-url',
              label: 'URL del Video (HTML5)',
              placeholder: 'https://ejemplo.com/video.mp4',
              changeProp: 1
            },
            {
              type: 'text',
              name: 'video-id',
              label: 'ID del Video (YouTube/Vimeo)',
              placeholder: 'Ej: dQw4w9WgXcQ (YouTube) o 123456789 (Vimeo)',
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
              changeProp: 1
            },
            {
              type: 'checkbox',
              name: 'loop',
              label: 'Repetir video',
              changeProp: 1
            },
            {
              type: 'checkbox',
              name: 'muted',
              label: 'Silenciado',
              changeProp: 1
            }
          ]
        },
        init() {
          console.log('🎬 Inicializando componente de Video...');
          
          // Sincronizar valores iniciales
          const syncInitialValues = () => {
            if (this.view && this.view.el) {
              const el = this.view.el;
              
              // Detectar tipo de video
              const videoEl = el.querySelector('video');
              const iframeEl = el.querySelector('iframe');
              
              if (videoEl) {
                // Video HTML5
                this.set('video-type', 'html5', { silent: true });
                const sourceEl = videoEl.querySelector('source');
                if (sourceEl?.src) {
                  this.set('video-url', sourceEl.src, { silent: true });
                }
                if (videoEl.hasAttribute('controls')) {
                  this.set('controls', true, { silent: true });
                }
                if (videoEl.hasAttribute('autoplay')) {
                  this.set('autoplay', true, { silent: true });
                }
                if (videoEl.hasAttribute('loop')) {
                  this.set('loop', true, { silent: true });
                }
                if (videoEl.hasAttribute('muted')) {
                  this.set('muted', true, { silent: true });
                }
              } else if (iframeEl) {
                const iframeSrc = iframeEl.src || '';
                if (iframeSrc.includes('youtube.com') || iframeSrc.includes('youtu.be')) {
                  // YouTube
                  this.set('video-type', 'youtube', { silent: true });
                  const match = iframeSrc.match(/embed\/([^?&]+)/);
                  if (match && match[1]) {
                    this.set('video-id', match[1], { silent: true });
                  }
                  // Detectar aspect ratio del wrapper
                  const wrapper = iframeEl.closest('.relative');
                  if (wrapper && wrapper.style.paddingBottom) {
                    const pb = wrapper.style.paddingBottom;
                    const ratio = parseFloat(pb.replace('%', ''));
                    if (ratio) {
                      this.set('aspect-ratio', ratio.toString(), { silent: true });
                    }
                  }
                } else if (iframeSrc.includes('vimeo.com')) {
                  // Vimeo
                  this.set('video-type', 'vimeo', { silent: true });
                  const match = iframeSrc.match(/video\/(\d+)/);
                  if (match && match[1]) {
                    this.set('video-id', match[1], { silent: true });
                  }
                  // Detectar aspect ratio del wrapper
                  const wrapper = iframeEl.closest('.relative');
                  if (wrapper && wrapper.style.paddingBottom) {
                    const pb = wrapper.style.paddingBottom;
                    const ratio = parseFloat(pb.replace('%', ''));
                    if (ratio) {
                      this.set('aspect-ratio', ratio.toString(), { silent: true });
                    }
                  }
                }
              }
            }
          };
          
          setTimeout(syncInitialValues, 100);
          this.on('component:mount', syncInitialValues);
          this.on('component:selected', syncInitialValues);
          
          this.on('change:video-type', this.updateVideoType, this);
          this.on('change:video-url', this.updateVideoUrl, this);
          this.on('change:video-id', this.updateVideoId, this);
          this.on('change:aspect-ratio', this.updateAspectRatio, this);
          this.on('change:autoplay', this.updateAutoplay, this);
          this.on('change:controls', this.updateControls, this);
          this.on('change:loop', this.updateLoop, this);
          this.on('change:muted', this.updateMuted, this);
          
          // Proteger elementos internos
          const protectElements = () => {
            this.components().each(child => {
              if (child.get('tagName') === 'video' || child.get('tagName') === 'iframe') {
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
                  'data-gjs-draggable': 'false'
                });
              }
              
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
              
              if (child.components().length > 0) {
                child.components().each(grandchild => {
                  if (grandchild.get('tagName') === 'video' || grandchild.get('tagName') === 'iframe' || grandchild.get('tagName') === 'source') {
                    grandchild.set({
                      selectable: false,
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
        updateVideoType() {
          const videoType = this.get('video-type') || 'html5';
          console.log('🎬 Cambiando tipo de video a:', videoType);
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const container = el.classList.contains('video-container') ? el : el.querySelector('.video-container') || el;
          
          // Limpiar contenido actual
          container.innerHTML = '';
          
          if (videoType === 'html5') {
            // Crear video HTML5
            const video = document.createElement('video');
            video.className = 'w-full rounded-lg shadow-lg';
            video.controls = this.get('controls') !== false;
            video.autoplay = this.get('autoplay') === true;
            video.loop = this.get('loop') === true;
            video.muted = this.get('muted') === true;
            
            const source = document.createElement('source');
            source.src = this.get('video-url') || 'https://www.w3schools.com/html/mov_bbb.mp4';
            source.type = 'video/mp4';
            video.appendChild(source);
            
            video.appendChild(document.createTextNode('Tu navegador no soporta video HTML5.'));
            container.appendChild(video);
            
            // Actualizar componentes de GrapesJS
            this.components().reset();
            this.components(video);
            
          } else if (videoType === 'youtube') {
            // Crear iframe de YouTube
            const wrapper = document.createElement('div');
            wrapper.className = 'relative overflow-hidden rounded-lg';
            wrapper.style.paddingBottom = `${this.get('aspect-ratio') || '56.25'}%`;
            
            const iframe = document.createElement('iframe');
            iframe.className = 'absolute top-0 left-0 w-full h-full';
            iframe.src = `https://www.youtube.com/embed/${this.get('video-id') || 'dQw4w9WgXcQ'}?autoplay=${this.get('autoplay') ? '1' : '0'}&controls=${this.get('controls') !== false ? '1' : '0'}`;
            iframe.setAttribute('frameborder', '0');
            iframe.setAttribute('allowfullscreen', '');
            iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
            
            wrapper.appendChild(iframe);
            container.appendChild(wrapper);
            
            // Actualizar componentes de GrapesJS
            this.components().reset();
            this.components(wrapper);
            
          } else if (videoType === 'vimeo') {
            // Crear iframe de Vimeo
            const wrapper = document.createElement('div');
            wrapper.className = 'relative overflow-hidden rounded-lg';
            wrapper.style.paddingBottom = `${this.get('aspect-ratio') || '56.25'}%`;
            
            const iframe = document.createElement('iframe');
            iframe.className = 'absolute top-0 left-0 w-full h-full';
            iframe.src = `https://player.vimeo.com/video/${this.get('video-id') || ''}?autoplay=${this.get('autoplay') ? '1' : '0'}`;
            iframe.setAttribute('frameborder', '0');
            iframe.setAttribute('allowfullscreen', '');
            iframe.setAttribute('allow', 'autoplay; fullscreen; picture-in-picture');
            
            wrapper.appendChild(iframe);
            container.appendChild(wrapper);
            
            // Actualizar componentes de GrapesJS
            this.components().reset();
            this.components(wrapper);
          }
          
          // Forzar actualización
          if (this.view) {
            this.view.render();
          }
        },
        updateVideoUrl() {
          const videoType = this.get('video-type') || 'html5';
          if (videoType !== 'html5') return;
          
          const url = this.get('video-url') || '';
          if (!this.view || !this.view.el) return;
          
          const video = this.view.el.querySelector('video');
          if (video) {
            const source = video.querySelector('source');
            if (source) {
              source.src = url;
            } else {
              const newSource = document.createElement('source');
              newSource.src = url;
              newSource.type = 'video/mp4';
              video.appendChild(newSource);
            }
            video.load();
          }
        },
        updateVideoId() {
          const videoType = this.get('video-type') || 'youtube';
          if (videoType === 'html5') return;
          
          const videoId = this.get('video-id') || '';
          if (!this.view || !this.view.el) return;
          
          const iframe = this.view.el.querySelector('iframe');
          if (iframe) {
            if (videoType === 'youtube') {
              const autoplay = this.get('autoplay') ? '1' : '0';
              const controls = this.get('controls') !== false ? '1' : '0';
              iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=${autoplay}&controls=${controls}`;
            } else if (videoType === 'vimeo') {
              const autoplay = this.get('autoplay') ? '1' : '0';
              iframe.src = `https://player.vimeo.com/video/${videoId}?autoplay=${autoplay}`;
            }
          }
        },
        updateAspectRatio() {
          const videoType = this.get('video-type') || 'youtube';
          if (videoType === 'html5') return;
          
          const aspectRatio = this.get('aspect-ratio') || '56.25';
          if (!this.view || !this.view.el) return;
          
          const wrapper = this.view.el.querySelector('.relative.overflow-hidden');
          if (wrapper) {
            wrapper.style.paddingBottom = `${aspectRatio}%`;
          }
        },
        updateAutoplay() {
          this.updateVideoId();
        },
        updateControls() {
          const videoType = this.get('video-type') || 'html5';
          
          if (videoType === 'html5') {
            const controls = this.get('controls') !== false;
            if (this.view && this.view.el) {
              const video = this.view.el.querySelector('video');
              if (video) {
                video.controls = controls;
              }
            }
          } else {
            this.updateVideoId();
          }
        },
        updateLoop() {
          const videoType = this.get('video-type') || 'html5';
          if (videoType !== 'html5') return;
          
          const loop = this.get('loop') === true;
          if (this.view && this.view.el) {
            const video = this.view.el.querySelector('video');
            if (video) {
              video.loop = loop;
            }
          }
        },
        updateMuted() {
          const videoType = this.get('video-type') || 'html5';
          if (videoType !== 'html5') return;
          
          const muted = this.get('muted') === true;
          if (this.view && this.view.el) {
            const video = this.view.el.querySelector('video');
            if (video) {
              video.muted = muted;
            }
          }
        }
      },
      view: {
        onRender() {
          if (this.el) {
            this.el.setAttribute('contenteditable', 'false');
            this.el.setAttribute('data-gjs-editable', 'false');
            
            // Proteger elementos internos
            const protectElements = (container) => {
              if (!container) return;
              
              const videos = container.querySelectorAll('video');
              videos.forEach(video => {
                video.setAttribute('contenteditable', 'false');
                video.setAttribute('data-gjs-editable', 'false');
                video.setAttribute('data-gjs-selectable', 'false');
              });
              
              const iframes = container.querySelectorAll('iframe');
              iframes.forEach(iframe => {
                iframe.setAttribute('contenteditable', 'false');
                iframe.setAttribute('data-gjs-editable', 'false');
                iframe.setAttribute('data-gjs-selectable', 'false');
                iframe.setAttribute('data-gjs-draggable', 'false');
              });
            };
            
            protectElements(this.el);
            
            const observer = new MutationObserver(() => {
              protectElements(this.el);
            });
            
            observer.observe(this.el, {
              childList: true,
              subtree: true
            });
            
            this._videoObserver = observer;
          }
        },
        onRemove() {
          if (this._videoObserver) {
            this._videoObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  if (typeof window !== 'undefined' && window.editor) {
    registerVideoComponent(window.editor);
  } else {
    const checkEditor = setInterval(() => {
      if (typeof window !== 'undefined' && window.editor) {
        registerVideoComponent(window.editor);
        clearInterval(checkEditor);
      }
    }, 100);
    
    setTimeout(() => {
      clearInterval(checkEditor);
    }, 10000);
  }
  
  if (typeof window !== 'undefined') {
    window.registerVideoComponent = registerVideoComponent;
  }
})();
