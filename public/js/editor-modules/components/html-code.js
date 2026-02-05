// Módulo del Componente HTML Code
// Componente de código HTML/CSS/JavaScript personalizado estilo Elementor con traits y protección

(function() {
  'use strict';
  
  function registerHtmlCodeComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente HTML Code');
      return;
    }
    
    editor.DomComponents.addType('html-code', {
      isComponent: (el) => {
        // Verificar que el sea un elemento DOM válido
        if (!el || typeof el !== 'object' || !el.nodeType) {
          return false;
        }
        
        if (el.classList && el.classList.contains('custom-html-block')) {
          return { type: 'html-code' };
        }
        if (el.tagName === 'DIV' && el.querySelector && typeof el.querySelector === 'function' && el.querySelector('.custom-html-block')) {
          return { type: 'html-code' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Código HTML',
          tagName: 'div',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          badgable: false,
          draggable: true,
          copyable: true,
          toolbar: [
            {
              attributes: { class: 'fa fa-arrows' },
              command: 'tlb-move'
            },
            {
              attributes: { class: 'fa fa-clone' },
              command: 'tlb-clone'
            },
            {
              attributes: { class: 'fa fa-trash' },
              command: 'tlb-delete'
            }
          ],
          attributes: {
            class: 'custom-html-block',
            'data-gjs-type': 'html-code',
            'data-gjs-name': 'Código HTML',
            'data-gjs-editable': 'false',
            style: 'background-color: transparent !important; width: 100% !important; display: block !important; min-height: auto !important;'
          },
          'html-content': '',
          'css-content': '',
          'js-content': '',
          traits: [
            {
              type: 'textarea',
              name: 'html-content',
              label: 'Código HTML',
              placeholder: '<div>Tu código HTML aquí</div>',
              rows: 6,
              changeProp: 1
            },
            {
              type: 'textarea',
              name: 'css-content',
              label: 'CSS (opcional)',
              placeholder: '.tu-clase { color: red; }',
              rows: 4,
              changeProp: 1
            },
            {
              type: 'textarea',
              name: 'js-content',
              label: 'JavaScript (opcional)',
              placeholder: 'console.log("Hola");',
              rows: 4,
              changeProp: 1
            }
          ]
        },
        init() {
          console.log('🎯 [HTMLCode] Inicializando listeners...');
          console.log('🔍 [HTMLCode] Traits definidos:', this.get('traits'));
          console.log('🔍 [HTMLCode] Valores iniciales:', {
            html: this.get('html-content'),
            css: this.get('css-content'),
            js: this.get('js-content')
          });
          
          // ✅ Listeners para cambios en los campos de entrada
          this.on('change:html-content', () => {
            console.log('✏️ [HTMLCode] html-content cambió');
            this.updateContent();
          });
          this.on('change:css-content', () => {
            console.log('✏️ [HTMLCode] css-content cambió');
            this.updateContent();
          });
          this.on('change:js-content', () => {
            console.log('✏️ [HTMLCode] js-content cambió');
            this.updateContent();
          });
          
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
                'data-gjs-removable': 'false',
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
        updateContent() {
          const htmlContent = this.get('html-content') || '';
          const cssContent = this.get('css-content') || '';
          const jsContent = this.get('js-content') || '';
          
          console.log('💻 [updateContent] Actualizando contenido HTML Code:', { 
            htmlLength: htmlContent.length,
            cssLength: cssContent.length,
            jsLength: jsContent.length,
            html: htmlContent.substring(0, 100), 
            css: cssContent.substring(0, 100), 
            js: jsContent.substring(0, 100) 
          });
          
          if (!this.view || !this.view.el) {
            console.warn('⚠️ [HTMLCode] Vista no disponible, reencolando updateContent');
            setTimeout(() => this.updateContent(), 100);
            return;
          }
          
          const el = this.view.el;
          
          // Si hay contenido, crear un contenedor para renderizarlo
          if (htmlContent.trim() || cssContent.trim() || jsContent.trim()) {
            console.log('✅ [updateContent] Hay contenido, renderizando preview...');
            
            // Buscar o crear contenedor de preview
            let previewContainer = el.querySelector('.html-code-preview');
            
            if (!previewContainer) {
              console.log('🔨 [updateContent] Creando contenedor de preview...');
              // Remover elementos de placeholder si existen
              const placeholder = el.querySelector('.flex.items-center.justify-center');
              const placeholderText = el.querySelector('.mt-2.text-xs');
              if (placeholder) placeholder.remove();
              if (placeholderText) placeholderText.remove();
              
              // Crear contenedor de preview (pointer-events: none para que los clics seleccionen el widget en el canvas)
              previewContainer = document.createElement('div');
              previewContainer.className = 'html-code-preview mt-4';
              previewContainer.setAttribute('data-gjs-editable', 'false');
              previewContainer.setAttribute('data-gjs-selectable', 'false');
              previewContainer.setAttribute('contenteditable', 'false');
              previewContainer.style.pointerEvents = 'none';
              previewContainer.style.width = '100%';
              previewContainer.style.display = 'block';
              previewContainer.style.minHeight = 'auto';
              el.appendChild(previewContainer);
              console.log('✅ [updateContent] Contenedor creado y agregado');
            }
            
            // Limpiar preview anterior y asegurar que los clics pasen al widget (edición desde panel)
            previewContainer.innerHTML = '';
            // ✅ CAMBIO: No usar pointer-events: none en el contenedor, sino permitir interacción
            previewContainer.style.pointerEvents = 'auto';
            previewContainer.style.width = '100%';
            previewContainer.style.display = 'block';
            previewContainer.style.minHeight = 'auto';
            
            // ✅ NUEVO: Marcar que hay contenido cargado
            el.setAttribute('data-has-content', 'true');
            
            // 🛡️ AISLAMIENTO: Crear Shadow DOM para aislar CSS y JS del resto de la página
            console.log('🛡️ [updateContent] Creando Shadow DOM para aislamiento...');
            
            // Limpiar y crear shadow root
            previewContainer.innerHTML = '';
            let shadowRoot = previewContainer.shadowRoot;
            if (!shadowRoot) {
              shadowRoot = previewContainer.attachShadow({ mode: 'open' });
            } else {
              // Limpiar shadow root anterior
              while (shadowRoot.firstChild) {
                shadowRoot.removeChild(shadowRoot.firstChild);
              }
            }
            
            // ✅ NUEVO: Agregar estilos base para que Tailwind y otros estilos funcionen
            const baseStyle = document.createElement('style');
            baseStyle.textContent = `
              :host {
                display: block;
                width: 100%;
                all: initial;
              }
              * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
              }
              body {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                font-size: 16px;
                line-height: 1.5;
                color: inherit;
              }
              .isolated-content {
                width: 100% !important;
                display: block !important;
                min-height: auto !important;
              }
            `;
            shadowRoot.appendChild(baseStyle);
            
            // Crear contenedor interno dentro del Shadow DOM
            const isolatedContainer = document.createElement('div');
            isolatedContainer.className = 'isolated-content';
            isolatedContainer.style.width = '100%';
            isolatedContainer.style.display = 'block';
            isolatedContainer.style.minHeight = 'auto';
            
            // Agregar CSS AISLADO dentro del Shadow DOM
            if (cssContent.trim()) {
              console.log('📦 [updateContent] Agregando CSS aislado...');
              const style = document.createElement('style');
              style.textContent = cssContent;
              shadowRoot.appendChild(style);
              console.log('✅ CSS aplicado al Shadow DOM');
            }
            
            // Agregar HTML AISLADO
            if (htmlContent.trim()) {
              console.log('📦 [updateContent] Agregando HTML aislado...');
              isolatedContainer.innerHTML = htmlContent;
              shadowRoot.appendChild(isolatedContainer);
              console.log('✅ HTML renderizado en Shadow DOM');
            }
            
            // Agregar JavaScript AISLADO (ejecutado en contexto del Shadow DOM)
            if (jsContent.trim()) {
              console.log('📦 [updateContent] Agregando JavaScript aislado...');
              try {
                // Crear script dentro del Shadow DOM con acceso al contenedor
                const script = document.createElement('script');
                
                // Modificar el JS para usar shadowRoot en lugar de document
                let modifiedJs = jsContent;
                
                // Reemplazar document.getElementById con shadowRoot.querySelector
                modifiedJs = modifiedJs.replace(/document\.getElementById\(['"]([^'"]+)['"]\)/g, 'shadowRoot.querySelector("#$1")');
                modifiedJs = modifiedJs.replace(/document\.querySelector/g, 'shadowRoot.querySelector');
                modifiedJs = modifiedJs.replace(/document\.querySelectorAll/g, 'shadowRoot.querySelectorAll');
                modifiedJs = modifiedJs.replace(/document\.getElementsByClassName/g, 'shadowRoot.querySelectorAll');
                
                // Ejecutar en contexto aislado
                const isolatedFunction = new Function('shadowRoot', modifiedJs);
                isolatedFunction(shadowRoot);
                
                console.log('✅ JavaScript ejecutado en contexto aislado');
              } catch (err) {
                console.error('❌ Error al ejecutar JavaScript aislado:', err);
                const errorMsg = document.createElement('div');
                errorMsg.style.cssText = 'color: red; padding: 10px; border: 1px solid red; margin: 10px; font-family: monospace;';
                errorMsg.textContent = `Error en JavaScript: ${err.message}`;
                shadowRoot.appendChild(errorMsg);
              }
            }
            
            console.log('✅ [updateContent] Contenido aislado en Shadow DOM');
            console.log('✅ [updateContent] Preview completamente renderizado - CSS y HTML aplicados');
          } else {
            // Si no hay contenido, mostrar placeholder
            console.log('📭 [updateContent] Sin contenido, mostrando placeholder');
            const previewContainer = el.querySelector('.html-code-preview');
            if (previewContainer) {
              previewContainer.remove();
            }
            
            // Asegurar que existe el placeholder
            if (!el.querySelector('.flex.items-center.justify-center')) {
              const placeholderDiv = document.createElement('div');
              placeholderDiv.className = 'flex items-center justify-center text-gray-500';
              placeholderDiv.setAttribute('data-gjs-editable', 'false');
              placeholderDiv.setAttribute('data-gjs-selectable', 'false');
              placeholderDiv.setAttribute('contenteditable', 'false');
              
              const svg = document.createElement('svg');
              svg.className = 'w-8 h-8 mr-2';
              svg.setAttribute('fill', 'none');
              svg.setAttribute('stroke', 'currentColor');
              svg.setAttribute('viewBox', '0 0 24 24');
              svg.setAttribute('data-gjs-editable', 'false');
              svg.setAttribute('data-gjs-selectable', 'false');
              
              const path = document.createElement('path');
              path.setAttribute('stroke-linecap', 'round');
              path.setAttribute('stroke-linejoin', 'round');
              path.setAttribute('stroke-width', '2');
              path.setAttribute('d', 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4');
              path.setAttribute('data-gjs-editable', 'false');
              path.setAttribute('data-gjs-selectable', 'false');
              svg.appendChild(path);
              
              const span = document.createElement('span');
              span.className = 'text-sm font-medium';
              span.setAttribute('data-gjs-editable', 'false');
              span.setAttribute('data-gjs-selectable', 'false');
              span.textContent = 'Bloque de Código HTML/CSS/JavaScript';
              
              placeholderDiv.appendChild(svg);
              placeholderDiv.appendChild(span);
              el.appendChild(placeholderDiv);
              
              const placeholderText = document.createElement('p');
              placeholderText.className = 'mt-2 text-xs text-center text-gray-400';
              placeholderText.setAttribute('data-gjs-editable', 'false');
              placeholderText.setAttribute('data-gjs-selectable', 'false');
              placeholderText.textContent = 'Haz clic para editar el código personalizado';
              el.appendChild(placeholderText);
            }
          }
        },
        toHTML() {
          console.log('💾 [HtmlCode] toHTML() llamado - serializando componente');
          
          const htmlContent = this.get('html-content') || '';
          const cssContent = this.get('css-content') || '';
          const jsContent = this.get('js-content') || '';
          
          const tagName = this.get('tagName') || 'div';
          const attrs = this.getAttributes();
          
          // Construir atributos como string
          let attrsArray = [];
          for (let key in attrs) {
            if (attrs.hasOwnProperty(key) && attrs[key] !== null && attrs[key] !== undefined && attrs[key] !== '') {
              const value = String(attrs[key]).replace(/"/g, '&quot;');
              attrsArray.push(`${key}="${value}"`);
            }
          }
          
          const attrsStr = attrsArray.join(' ');
          
          // Construir el contenido HTML final con scoped styles
          let innerHTML = '';
          
          // Si hay contenido HTML, CSS o JS, generar el scope
          if (htmlContent.trim() || cssContent.trim() || jsContent.trim()) {
            // Generar ID único para scope del CSS
            const scopeId = `html-code-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
            
            // Agregar contenedor con clase única para scope y ancho 100%
            innerHTML += `<div class="${scopeId}" style="width: 100%; display: block;">`;
            
            // ✅ Agregar CSS DIRECTAMENTE sin scope - simplemente dentro de <style>
            if (cssContent.trim()) {
              console.log('💾 [toHTML] Agregando CSS:', cssContent.substring(0, 100));
              innerHTML += `<style>${cssContent}</style>`;
            }
            
            // Agregar HTML si existe
            if (htmlContent.trim()) {
              console.log('💾 [toHTML] Agregando HTML:', htmlContent.substring(0, 100));
              innerHTML += htmlContent;
            }
            
            // Cerrar contenedor con scope
            innerHTML += '</div>';
            
            // Agregar JavaScript si existe (con contexto del contenedor)
            if (jsContent.trim()) {
              console.log('💾 [toHTML] Agregando JavaScript:', jsContent.substring(0, 100));
              innerHTML += `<script>
                (function() {
                  // Ejecutar en contexto del contenedor
                  const container = document.querySelector('.${scopeId}');
                  if (!container) return;
                  
                  // Modificar document.getElementById para buscar dentro del contenedor
                  const originalGetElementById = document.getElementById.bind(document);
                  document.getElementById = function(id) {
                    return container.querySelector('#' + id) || originalGetElementById(id);
                  };
                  
                  ${jsContent}
                })();
              </script>`;
            }
          } else {
            // Si no hay contenido, mantener la estructura del placeholder
            innerHTML = `
              <div class="flex items-center justify-center text-gray-500" data-gjs-editable="false" data-gjs-selectable="false" contenteditable="false">
                <svg class="w-8 h-8 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" data-gjs-editable="false" data-gjs-selectable="false">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" data-gjs-editable="false" data-gjs-selectable="false"></path>
                </svg>
                <span class="text-sm font-medium" data-gjs-editable="false" data-gjs-selectable="false">Bloque de Código HTML/CSS/JavaScript</span>
              </div>
              <p class="mt-2 text-xs text-center text-gray-400" data-gjs-editable="false" data-gjs-selectable="false">Haz clic para editar el código personalizado</p>
            `;
          }
          
          const finalHTML = `<${tagName}${attrsStr ? ' ' + attrsStr : ''}>${innerHTML}</${tagName}>`;
          
          console.log('✅ [HtmlCode] toHTML - HTML generado (primeros 200 chars):', finalHTML.substring(0, 200));
          
          return finalHTML;
        }
      },
      view: {
        onRender() {
          const el = this.el;
          const component = this.model;
          
          console.log('💻 Vista de HTML Code renderizada');
          
          // Proteger el contenedor principal
          el.setAttribute('contenteditable', 'false');
          el.setAttribute('data-gjs-editable', 'false');
          
          // No forzar fondo ni borde para el contenido generado
          el.style.setProperty('background-color', 'transparent', 'important');
          el.style.setProperty('border', 'none', 'important');
          
          // Proteger TODOS los elementos internos
          const protectAllElements = (container) => {
            if (!container) return;
            
            const allElements = container.querySelectorAll('*');
            allElements.forEach(element => {
              element.setAttribute('contenteditable', 'false');
              element.setAttribute('data-gjs-editable', 'false');
              element.setAttribute('data-gjs-selectable', 'false');
              element.setAttribute('data-gjs-draggable', 'false');
              element.setAttribute('data-gjs-droppable', 'false');
              element.setAttribute('data-gjs-removable', 'false');
            });
          };
          
          protectAllElements(el);
          
          // Aplicar contenido inicial si existe
          const htmlContent = component.get('html-content') || '';
          const cssContent = component.get('css-content') || '';
          const jsContent = component.get('js-content') || '';
          
          if (htmlContent.trim() || cssContent.trim() || jsContent.trim()) {
            // Si hay contenido, actualizar
            component.updateContent();
          }
          
          // ✅ NUEVO: Observar cambios externos (e.g., desde IA)
          const changeObserver = new MutationObserver(() => {
            protectAllElements(el);
          });
          
          changeObserver.observe(el, {
            childList: true,
            subtree: true
          });
          
          this._htmlCodeObserver = changeObserver;
          
          console.log('✅ Vista de HTML Code lista');
        },
        onRemove() {
          if (this._htmlCodeObserver) {
            this._htmlCodeObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  // Auto-registrar si el editor está disponible
  if (typeof window !== 'undefined' && window.editor) {
    registerHtmlCodeComponent(window.editor);
  }
  
  // Exportar para registro manual
  if (typeof window !== 'undefined') {
    window.registerHtmlCodeComponent = registerHtmlCodeComponent;
  }
})();
