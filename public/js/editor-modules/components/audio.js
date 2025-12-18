// Módulo del Componente Audio
// Componente de reproductor de audio con controles

(function() {
  'use strict';
  
  function registerAudioComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Audio');
      return;
    }
    
    editor.DomComponents.addType('audio', {
      isComponent: (el) => {
        // Detectar contenedor de audio
        if (el.tagName === 'DIV' && (
          el.classList.contains('audio-player') ||
          el.getAttribute('data-gjs-type') === 'audio'
        )) {
          return { type: 'audio' };
        }
        // Detectar elemento audio HTML5
        if (el.tagName === 'AUDIO') {
          return { type: 'audio' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Reproductor de Audio',
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
            'data-gjs-type': 'audio',
            'data-gjs-name': 'Reproductor de Audio',
            'data-gjs-editable': 'false'
          },
          'audio-url': '',
          'audio-title': 'Título del Audio',
          'audio-artist': 'Artista o Descripción',
          'autoplay': false,
          'loop': false,
          'controls': true,
          'muted': false,
          traits: [
            {
              type: 'button',
              name: 'select-audio',
              label: '📁 Seleccionar Audio',
              text: 'Abrir Galería de Audios',
              full: true,
              command: (editor) => {
                const component = editor.getSelected();
                if (component && component.get('type') === 'audio') {
                  const am = editor.AssetManager;
                  const modal = editor.Modal;
                  
                  fetch('/creator/media/api/list')
                    .then(response => response.json())
                    .then(data => {
                      if (data.success && data.files && data.files.length > 0) {
                        am.getAll().reset();
                        // Filtrar solo audios
                        const audioFiles = data.files.filter(file => {
                          const ext = file.filename.split('.').pop().toLowerCase();
                          return ['mp3', 'wav', 'ogg', 'm4a', 'aac', 'flac'].includes(ext);
                        });
                        
                        audioFiles.forEach(file => {
                          am.add({
                            type: 'audio',
                            src: file.url,
                            name: file.filename
                          });
                        });
                        console.log('✅ Audios cargados desde biblioteca:', audioFiles.length);
                      } else {
                        console.warn('⚠️ No se encontraron audios en la biblioteca');
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
                          component.set('audio-url', newSrc, { silent: false });
                          component.updateAudio();
                          modal.close();
                          setTimeout(() => {
                            if (editor.TraitManager) {
                              editor.TraitManager.render();
                            }
                          }, 150);
                        }
                      };
                      
                      am.onClick(onClickHandler);
                      modal.setTitle('Seleccionar Audio desde Galería')
                        .setContent(am.render())
                        .open();
                      
                      console.log('✅ Galería de audios abierta');
                    })
                    .catch(error => {
                      console.error('❌ Error al cargar audios desde la biblioteca:', error);
                      am.onClick((asset) => {
                        let newSrc = asset.get('src') || asset.get('url') || asset.src || asset.url;
                        if (newSrc && component) {
                          component.set('audio-url', newSrc, { silent: false });
                          component.updateAudio();
                          modal.close();
                          setTimeout(() => {
                            if (editor.TraitManager) {
                              editor.TraitManager.render();
                            }
                          }, 150);
                        }
                      });
                      modal.setTitle('Seleccionar Audio desde Galería')
                        .setContent(am.render())
                        .open();
                    });
                }
              }
            },
            {
              type: 'text',
              name: 'audio-url',
              label: 'URL del Audio',
              placeholder: 'https://ejemplo.com/audio.mp3',
              changeProp: 1
            },
            {
              type: 'text',
              name: 'audio-title',
              label: 'Título',
              placeholder: 'Título del Audio',
              changeProp: 1
            },
            {
              type: 'text',
              name: 'audio-artist',
              label: 'Artista/Descripción',
              placeholder: 'Artista o Descripción',
              changeProp: 1
            },
            {
              type: 'checkbox',
              name: 'autoplay',
              label: 'Reproducción Automática',
              changeProp: 1
            },
            {
              type: 'checkbox',
              name: 'loop',
              label: 'Repetir',
              changeProp: 1
            },
            {
              type: 'checkbox',
              name: 'controls',
              label: 'Mostrar Controles',
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
          console.log('🎵 Inicializando componente Audio...');
          
          this.on('change:audio-url', this.updateAudio, this);
          this.on('change:audio-title', this.updateTitle, this);
          this.on('change:audio-artist', this.updateArtist, this);
          this.on('change:autoplay', this.updateAutoplay, this);
          this.on('change:loop', this.updateLoop, this);
          this.on('change:controls', this.updateControls, this);
          this.on('change:muted', this.updateMuted, this);
          
          // Proteger TODOS los elementos internos - NO edición directa
          const protectElements = () => {
            const protectRecursive = (component) => {
              // Proteger el componente actual completamente
              component.set({
                selectable: false,
                hoverable: false,
                draggable: false,
                editable: false,  // ✅ BLOQUEADO: No edición directa
                removable: false,
                droppable: false
              });
              component.addAttributes({
                'data-gjs-editable': 'false',
                'data-gjs-selectable': 'false',
                'data-gjs-draggable': 'false',
                'data-gjs-droppable': 'false',
                'contenteditable': 'false'
              });
              
              // Proteger recursivamente todos los hijos
              component.components().each(grandchild => {
                protectRecursive(grandchild);
              });
            };
            
            this.components().each(child => {
              protectRecursive(child);
            });
            
          };
          
          setTimeout(protectElements, 100);
          this.on('component:mount', protectElements);
          this.on('component:add', () => {
            setTimeout(protectElements, 100);
          });
        },
        updateAudio() {
          const audioUrl = this.get('audio-url') || '';
          console.log('🎵 Actualizando URL del audio:', audioUrl);
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const audio = el.querySelector('audio');
          const source = audio?.querySelector('source');
          
          if (audio && audioUrl) {
            if (source) {
              source.src = audioUrl;
              source.setAttribute('src', audioUrl);
            } else {
              const newSource = document.createElement('source');
              newSource.src = audioUrl;
              newSource.type = 'audio/mpeg';
              audio.appendChild(newSource);
            }
            audio.load();
            
            // Actualizar también en el modelo de GrapesJS
            const findAudio = (component) => {
              if (component.get('tagName') === 'audio') {
                return component;
              }
              let found = null;
              component.components().each(child => {
                if (!found) {
                  found = findAudio(child);
                }
              });
              return found;
            };
            
            const audioComponent = findAudio(this);
            if (audioComponent) {
              const sourceComponent = audioComponent.components().at(0);
              if (sourceComponent) {
                sourceComponent.setAttributes({ src: audioUrl });
              }
            }
          }
        },
        updateTitle() {
          const title = this.get('audio-title') || 'Título del Audio';
          console.log('📝 Actualizando título:', title);
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const titleEl = el.querySelector('h3');
          
          if (titleEl) {
            titleEl.textContent = title;
            
            // Actualizar también en el modelo de GrapesJS
            const findTitle = (component) => {
              if (component.get('tagName') === 'h3') {
                return component;
              }
              let found = null;
              component.components().each(child => {
                if (!found) {
                  found = findTitle(child);
                }
              });
              return found;
            };
            
            const titleComponent = findTitle(this);
            if (titleComponent) {
              titleComponent.set('content', title);
            }
          }
        },
        updateArtist() {
          const artist = this.get('audio-artist') || '';
          console.log('📝 Actualizando artista/descripción:', artist);
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const artistEl = el.querySelector('p');
          
          if (artistEl) {
            artistEl.textContent = artist;
            
            // Actualizar también en el modelo de GrapesJS
            const findArtist = (component) => {
              if (component.get('tagName') === 'p') {
                return component;
              }
              let found = null;
              component.components().each(child => {
                if (!found) {
                  found = findArtist(child);
                }
              });
              return found;
            };
            
            const artistComponent = findArtist(this);
            if (artistComponent) {
              artistComponent.set('content', artist);
            }
          }
        },
        updateAutoplay() {
          const autoplay = this.get('autoplay') === true;
          console.log('▶️ Actualizando autoplay:', autoplay);
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const audio = el.querySelector('audio');
          
          if (audio) {
            audio.autoplay = autoplay;
            if (autoplay) {
              audio.setAttribute('autoplay', '');
            } else {
              audio.removeAttribute('autoplay');
            }
          }
        },
        updateLoop() {
          const loop = this.get('loop') === true;
          console.log('🔁 Actualizando loop:', loop);
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const audio = el.querySelector('audio');
          
          if (audio) {
            audio.loop = loop;
            if (loop) {
              audio.setAttribute('loop', '');
            } else {
              audio.removeAttribute('loop');
            }
          }
        },
        updateControls() {
          const controls = this.get('controls') !== false;
          console.log('🎛️ Actualizando controles:', controls);
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const audio = el.querySelector('audio');
          
          if (audio) {
            audio.controls = controls;
            if (controls) {
              audio.setAttribute('controls', '');
            } else {
              audio.removeAttribute('controls');
            }
          }
        },
        updateMuted() {
          const muted = this.get('muted') === true;
          console.log('🔇 Actualizando muted:', muted);
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const audio = el.querySelector('audio');
          
          if (audio) {
            audio.muted = muted;
            if (muted) {
              audio.setAttribute('muted', '');
            } else {
              audio.removeAttribute('muted');
            }
          }
        }
      },
      view: {
        onRender() {
          const el = this.el;
          console.log('🎵 Vista de Audio renderizada');

          // Proteger el contenedor principal
          el.setAttribute('contenteditable', 'false');
          el.setAttribute('data-gjs-editable', 'false');
          
          // Proteger TODOS los elementos internos - NO edición directa
          const protectElements = (container) => {
            if (!container) return;
            
            // Proteger TODOS los elementos (audio, textos, iconos, etc.)
            const allElements = container.querySelectorAll('*');
            allElements.forEach(el => {
              el.setAttribute('contenteditable', 'false');
              el.setAttribute('data-gjs-editable', 'false');
              el.setAttribute('data-gjs-selectable', 'false');
              el.setAttribute('data-gjs-draggable', 'false');
              el.setAttribute('data-gjs-droppable', 'false');
            });
            
            // También proteger el contenedor mismo
            container.setAttribute('contenteditable', 'false');
            container.setAttribute('data-gjs-editable', 'false');
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
          
          this._audioObserver = observer;
          
        },
        onRemove() {
          if (this._audioObserver) {
            this._audioObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  if (typeof window !== 'undefined' && window.editor) {
    registerAudioComponent(window.editor);
  } else {
    const checkEditor = setInterval(() => {
      if (typeof window !== 'undefined' && window.editor) {
        registerAudioComponent(window.editor);
        clearInterval(checkEditor);
      }
    }, 100);
    
    setTimeout(() => {
      clearInterval(checkEditor);
    }, 10000);
  }
  
  if (typeof window !== 'undefined') {
    window.registerAudioComponent = registerAudioComponent;
  }
})();
