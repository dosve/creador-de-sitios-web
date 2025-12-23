// Módulo del Componente Icon
// Componente de icono simple estilo Elementor con traits y protección

(function() {
  'use strict';
  
  function registerIconComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Icon');
      return;
    }
    
    editor.DomComponents.addType('icon', {
      isComponent: (el) => {
        if (!el || typeof el !== 'object' || !el.nodeType) {
          return false;
        }
        
        // ✅ CRÍTICO: Verificar primero si tiene el atributo data-gjs-type para evitar conflictos
        const gjsType = el.getAttribute && el.getAttribute('data-gjs-type');
        if (gjsType === 'icon') {
          return { type: 'icon' };
        }
        // Si tiene otro tipo definido (como icon-box), no es icon
        if (gjsType && gjsType !== 'icon') {
          return false;
        }
        
        if (el.classList && el.classList.contains('icon-container')) {
          return { type: 'icon' };
        }
        
        // ✅ CRÍTICO: Solo detectar como icon si NO tiene estructura de icon-box
        // Un icon-box tiene .icon-box-title o .icon-box-description, un icon individual no
        if (el.tagName === 'DIV' && el.querySelector && typeof el.querySelector === 'function') {
          const hasIconWrapper = el.querySelector('.icon-wrapper');
          const hasIconBoxStructure = el.querySelector('.icon-box-title') || el.querySelector('.icon-box-description') || 
                                     el.querySelector('.icon-box') || el.querySelector('.icon-box-horizontal');
          
          // Solo es icon si tiene icon-wrapper PERO NO tiene estructura de icon-box
          if (hasIconWrapper && !hasIconBoxStructure) {
            return { type: 'icon' };
          }
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Icono',
          tagName: 'div',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          hoverable: true,
          highlightable: true,
          badgable: false,
          attributes: {
            class: 'icon-container',
            'data-gjs-type': 'icon',
            'data-gjs-name': 'Icono',
            'data-gjs-editable': 'false',
            'data-gjs-highlightable': 'true'
          },
          'icon-type': 'lightning',
          'icon-size': 'large',
          'icon-color': '#2563eb',
          'icon-link': '',
          traits: [
            {
              type: 'select',
              name: 'icon-type',
              label: 'Tipo de Icono',
              changeProp: 1,
              options: [
                { value: 'lightning', name: 'Rayo' },
                { value: 'star', name: 'Estrella' },
                { value: 'heart', name: 'Corazón' },
                { value: 'check', name: 'Check' },
                { value: 'user', name: 'Usuario' },
                { value: 'mail', name: 'Email' },
                { value: 'phone', name: 'Teléfono' },
                { value: 'home', name: 'Casa' },
                { value: 'settings', name: 'Configuración' },
                { value: 'search', name: 'Búsqueda' },
                { value: 'shield', name: 'Escudo' },
                { value: 'clock', name: 'Reloj' },
                { value: 'chart', name: 'Gráfico' },
                { value: 'users', name: 'Usuarios' },
                { value: 'globe', name: 'Globo' },
                { value: 'rocket', name: 'Cohete' }
              ]
            },
            {
              type: 'select',
              name: 'icon-size',
              label: 'Tamaño',
              changeProp: 1,
              options: [
                { value: 'small', name: 'Pequeño (32px)' },
                { value: 'medium', name: 'Mediano (48px)' },
                { value: 'large', name: 'Grande (64px)' },
                { value: 'xlarge', name: 'Extra Grande (96px)' }
              ]
            },
            {
              type: 'color',
              name: 'icon-color',
              label: 'Color del Icono',
              changeProp: 1,
              placeholder: '#2563eb'
            },
            {
              type: 'text',
              name: 'icon-link',
              label: 'Enlace (opcional)',
              placeholder: 'https://ejemplo.com',
              changeProp: 1
            }
          ]
        },
        init() {
          this.on('change:icon-type', this.updateIcon, this);
          this.on('change:icon-size', this.updateSize, this);
          this.on('change:icon-color', this.updateColor, this);
          this.on('change:icon-link', this.updateLink, this);
          
          const protectElements = () => {
            const protectRecursive = (component) => {
              if (!component || typeof component.set !== 'function' || typeof component.get !== 'function') {
                return;
              }
              
              try {
                const componentType = component.get('type');
                if (componentType === 'image' || componentType === 'video' || componentType === 'link' || 
                    componentType === 'button' || componentType === 'text' || componentType === 'heading' ||
                    componentType === 'paragraph') {
                  return;
                }
                
                const tagName = component.get('tagName');
                if (!tagName || (tagName !== 'div' && tagName !== 'span' && tagName !== 'p' && 
                    tagName !== 'h1' && tagName !== 'h2' && tagName !== 'h3' && tagName !== 'h4' && 
                    tagName !== 'h5' && tagName !== 'h6' && tagName !== 'button' && tagName !== 'nav' &&
                    tagName !== 'section' && tagName !== 'article' && tagName !== 'svg' && tagName !== 'path')) {
                  return;
                }
                
                component.set({
                  selectable: false,
                  hoverable: false,
                  draggable: false,
                  editable: false,
                  removable: false,
                  droppable: false
                });
                
                if (typeof component.addAttributes === 'function') {
                  component.addAttributes({
                    'data-gjs-editable': 'false',
                    'data-gjs-selectable': 'false',
                    'data-gjs-draggable': 'false',
                    'data-gjs-droppable': 'false',
                    'data-gjs-removable': 'false',
                    'contenteditable': 'false'
                  });
                }
              } catch (e) {
                // Ignorar errores
              }
            };
            
            try {
              if (this.components && typeof this.components === 'function') {
                this.components().each(child => {
                  if (child) {
                    protectRecursive(child);
                  }
                });
              }
            } catch (e) {
              // Ignorar errores
            }
          };
          
          setTimeout(protectElements, 100);
          this.on('component:mount', protectElements);
          this.on('component:add', () => {
            setTimeout(protectElements, 100);
          });
        },
        getIconPath(type) {
          const icons = {
            lightning: 'M13 10V3L4 14h7v7l9-11h-7z',
            star: 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z',
            heart: 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
            check: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            user: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
            mail: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
            phone: 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',
            home: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
            settings: 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z',
            search: 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
            shield: 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
            clock: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
            chart: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
            users: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
            globe: 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            rocket: 'M13 10V3L4 14h7v7l9-11h-7z'
          };
          return icons[type] || icons.lightning;
        },
        getIconSize(size) {
          const sizes = {
            small: 'w-8 h-8',
            medium: 'w-12 h-12',
            large: 'w-16 h-16',
            xlarge: 'w-24 h-24'
          };
          return sizes[size] || sizes.large;
        },
        updateIcon() {
          if (!this.view || !this.view.el) return;
          
          const type = this.get('icon-type') || 'lightning';
          const iconPath = this.getIconPath(type);
          
          const el = this.view.el;
          const iconSvg = el.querySelector('.icon-wrapper svg path');
          
          if (iconSvg) {
            iconSvg.setAttribute('d', iconPath);
          }
          
          this.view.render();
        },
        updateSize() {
          if (!this.view || !this.view.el) return;
          
          const size = this.get('icon-size') || 'large';
          const sizeClass = this.getIconSize(size);
          
          const el = this.view.el;
          const iconSvg = el.querySelector('.icon-wrapper svg');
          
          if (iconSvg) {
            iconSvg.className = sizeClass + ' ' + (iconSvg.className.split(' ').find(c => c.startsWith('text-')) || 'text-blue-600');
          }
          
          this.view.render();
        },
        updateColor() {
          if (!this.view || !this.view.el) return;
          
          const color = this.get('icon-color') || '#2563eb';
          
          const el = this.view.el;
          const iconSvg = el.querySelector('.icon-wrapper svg');
          
          if (iconSvg) {
            iconSvg.style.setProperty('color', color, 'important');
          }
          
          this.view.render();
        },
        updateLink() {
          const link = this.get('icon-link') || '';
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          
          if (link) {
            const iconWrapper = el.querySelector('.icon-wrapper');
            if (iconWrapper && iconWrapper.parentElement.tagName !== 'A') {
              const linkEl = document.createElement('a');
              linkEl.href = link;
              linkEl.className = 'icon-link';
              linkEl.setAttribute('data-gjs-editable', 'false');
              linkEl.setAttribute('data-gjs-selectable', 'false');
              iconWrapper.parentNode.insertBefore(linkEl, iconWrapper);
              linkEl.appendChild(iconWrapper);
            } else if (iconWrapper && iconWrapper.parentElement.tagName === 'A') {
              iconWrapper.parentElement.href = link;
            }
          } else {
            const linkEl = el.querySelector('.icon-link');
            if (linkEl && linkEl.tagName === 'A') {
              const iconWrapper = linkEl.querySelector('.icon-wrapper');
              if (iconWrapper) {
                linkEl.parentNode.insertBefore(iconWrapper, linkEl);
                linkEl.remove();
              }
            }
          }
          
          this.view.render();
        },
        toHTML() {
          const tagName = this.get('tagName') || 'div';
          const attrs = this.getAttributes();
          let attrsArray = [];
          for (let key in attrs) {
            if (attrs.hasOwnProperty(key) && key !== 'content') {
              const val = attrs[key];
              attrsArray.push(`${key}="${String(val).replace(/"/g, '&quot;')}"`);
            }
          }
          const attrsStr = attrsArray.join(' ');
          
          const type = this.get('icon-type') || 'lightning';
          const size = this.get('icon-size') || 'large';
          const color = this.get('icon-color') || '#2563eb';
          const link = this.get('icon-link') || '';
          const iconPath = this.getIconPath(type);
          const sizeClass = this.getIconSize(size);
          
          let innerHTML = '';
          innerHTML += '<div class="icon-wrapper inline-flex items-center justify-center">';
          innerHTML += '<svg class="' + sizeClass + '" style="color: ' + color + ';" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
          innerHTML += '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="' + iconPath + '"></path>';
          innerHTML += '</svg>';
          innerHTML += '</div>';
          
          if (link) {
            innerHTML = '<a href="' + link.replace(/"/g, '&quot;') + '" class="icon-link">' + innerHTML + '</a>';
          }
          
          const finalHTML = '<' + tagName + (attrsStr ? ' ' + attrsStr : '') + ' class="icon-container text-center p-4">' + innerHTML + '</' + tagName + '>';
          return finalHTML;
        }
      },
      view: {
        onRender() {
          const el = this.el;
          const component = this.model;
          
          el.setAttribute('contenteditable', 'false');
          el.setAttribute('data-gjs-editable', 'false');
          el.setAttribute('data-gjs-selectable', 'true');
          el.setAttribute('data-gjs-highlightable', 'true');
          el.setAttribute('data-gjs-hoverable', 'true');
          
          // ✅ CRÍTICO: Sincronizar valores desde el DOM cuando se renderiza
          // Esto asegura que los valores guardados se carguen correctamente
          let iconWrapper = el.querySelector('.icon-wrapper');
          if (iconWrapper) {
            const svg = iconWrapper.querySelector('svg');
            const path = iconWrapper.querySelector('path');
            
            if (path && path.getAttribute('d')) {
              // Intentar identificar el tipo de icono desde el path guardado
              const savedPath = path.getAttribute('d');
              const iconTypes = ['lightning', 'star', 'heart', 'check', 'user', 'mail', 'phone', 'home', 'settings', 'search', 'shield', 'clock', 'chart', 'users', 'globe', 'rocket'];
              
              let detectedType = 'lightning'; // Por defecto
              for (const iconType of iconTypes) {
                const expectedPath = component.getIconPath(iconType);
                if (expectedPath === savedPath) {
                  detectedType = iconType;
                  break;
                }
              }
              
              // Sincronizar el tipo de icono al modelo si es diferente
              const currentType = component.get('icon-type');
              if (currentType !== detectedType) {
                component.set('icon-type', detectedType, { silent: true });
                console.log('✅ [Icon] Tipo de icono sincronizado desde DOM:', detectedType);
              }
              
              // Sincronizar el tamaño desde las clases del SVG
              if (svg) {
                // ✅ CRÍTICO: Convertir className a string (puede ser DOMTokenList o SVGAnimatedString)
                const svgClasses = (typeof svg.className === 'string' ? svg.className : 
                                   (svg.className?.baseVal || svg.className?.value || svg.getAttribute('class') || '')) || '';
                const sizeMap = {
                  'w-8 h-8': 'small',
                  'w-12 h-12': 'medium',
                  'w-16 h-16': 'large',
                  'w-24 h-24': 'xlarge'
                };
                
                for (const [sizeClass, sizeValue] of Object.entries(sizeMap)) {
                  if (String(svgClasses).includes(sizeClass)) {
                    const currentSize = component.get('icon-size');
                    if (currentSize !== sizeValue) {
                      component.set('icon-size', sizeValue, { silent: true });
                      console.log('✅ [Icon] Tamaño sincronizado desde DOM:', sizeValue);
                    }
                    break;
                  }
                }
                
                // Sincronizar el color desde el estilo
                const svgColor = svg.style.color || svg.getAttribute('style');
                if (svgColor) {
                  const colorMatch = svgColor.match(/color:\s*([^;]+)/);
                  if (colorMatch) {
                    const detectedColor = colorMatch[1].trim();
                    const currentColor = component.get('icon-color');
                    if (currentColor !== detectedColor) {
                      component.set('icon-color', detectedColor, { silent: true });
                      console.log('✅ [Icon] Color sincronizado desde DOM:', detectedColor);
                    }
                  }
                }
              }
              
              // Sincronizar el enlace si existe
              const linkEl = el.querySelector('.icon-link');
              if (linkEl && linkEl.tagName === 'A') {
                const linkHref = linkEl.getAttribute('href') || '';
                const currentLink = component.get('icon-link');
                if (currentLink !== linkHref) {
                  component.set('icon-link', linkHref, { silent: true });
                  console.log('✅ [Icon] Enlace sincronizado desde DOM:', linkHref);
                }
              }
            }
          }
          
          if (!iconWrapper) {
            const type = component.get('icon-type') || 'lightning';
            const size = component.get('icon-size') || 'large';
            const color = component.get('icon-color') || '#2563eb';
            const link = component.get('icon-link') || '';
            const iconPath = component.getIconPath(type);
            const sizeClass = component.getIconSize(size);
            
            iconWrapper = document.createElement('div');
            iconWrapper.className = 'icon-wrapper inline-flex items-center justify-center';
            iconWrapper.setAttribute('data-gjs-editable', 'false');
            iconWrapper.setAttribute('data-gjs-selectable', 'false');
            
            const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            svg.setAttribute('class', sizeClass);
            svg.style.setProperty('color', color, 'important');
            svg.setAttribute('fill', 'none');
            svg.setAttribute('stroke', 'currentColor');
            svg.setAttribute('viewBox', '0 0 24 24');
            svg.setAttribute('data-gjs-editable', 'false');
            svg.setAttribute('data-gjs-selectable', 'false');
            
            const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            path.setAttribute('stroke-linecap', 'round');
            path.setAttribute('stroke-linejoin', 'round');
            path.setAttribute('stroke-width', '2');
            path.setAttribute('d', iconPath);
            path.setAttribute('data-gjs-editable', 'false');
            path.setAttribute('data-gjs-selectable', 'false');
            
            svg.appendChild(path);
            iconWrapper.appendChild(svg);
            
            if (link) {
              const linkEl = document.createElement('a');
              linkEl.href = link;
              linkEl.className = 'icon-link';
              linkEl.setAttribute('data-gjs-editable', 'false');
              linkEl.setAttribute('data-gjs-selectable', 'false');
              linkEl.appendChild(iconWrapper);
              el.appendChild(linkEl);
            } else {
              el.appendChild(iconWrapper);
            }
          } else {
            // ✅ CRÍTICO: Si el icono ya existe, actualizarlo desde el modelo
            // Esto asegura que si el modelo tiene un valor diferente, se actualice el DOM
            const type = component.get('icon-type') || 'lightning';
            const size = component.get('icon-size') || 'large';
            const color = component.get('icon-color') || '#2563eb';
            const link = component.get('icon-link') || '';
            const iconPath = component.getIconPath(type);
            const sizeClass = component.getIconSize(size);
            
            const svg = iconWrapper.querySelector('svg');
            const path = iconWrapper.querySelector('path');
            
            if (svg && path) {
              // Actualizar el path del icono
              const currentPath = path.getAttribute('d');
              if (currentPath !== iconPath) {
                path.setAttribute('d', iconPath);
              }
              
              // Actualizar el tamaño
              // ✅ CRÍTICO: Convertir className a string antes de usar métodos de string
              const currentSvgClasses = (typeof svg.className === 'string' ? svg.className : 
                                        (svg.className?.baseVal || svg.className?.value || svg.getAttribute('class') || '')) || '';
              const currentSizeClass = String(currentSvgClasses).split(' ').find(c => c.startsWith('w-') && c.includes('h-'));
              if (!String(currentSvgClasses).includes(sizeClass)) {
                const otherClasses = String(currentSvgClasses).split(' ').filter(c => !c.startsWith('w-') || !c.includes('h-')).join(' ');
                svg.setAttribute('class', sizeClass + (otherClasses ? ' ' + otherClasses : ''));
              }
              
              // Actualizar el color
              const currentColor = svg.style.color || '';
              if (currentColor !== color) {
                svg.style.setProperty('color', color, 'important');
              }
            }
            
            // Actualizar el enlace si es necesario
            const linkEl = el.querySelector('.icon-link');
            if (link && (!linkEl || linkEl.tagName !== 'A')) {
              // Crear enlace si no existe
              const newLinkEl = document.createElement('a');
              newLinkEl.href = link;
              newLinkEl.className = 'icon-link';
              newLinkEl.setAttribute('data-gjs-editable', 'false');
              newLinkEl.setAttribute('data-gjs-selectable', 'false');
              iconWrapper.parentNode.insertBefore(newLinkEl, iconWrapper);
              newLinkEl.appendChild(iconWrapper);
            } else if (link && linkEl && linkEl.tagName === 'A') {
              // Actualizar href si el enlace existe
              if (linkEl.getAttribute('href') !== link) {
                linkEl.setAttribute('href', link);
              }
            } else if (!link && linkEl && linkEl.tagName === 'A') {
              // Remover enlace si ya no es necesario
              const iconWrapperInLink = linkEl.querySelector('.icon-wrapper');
              if (iconWrapperInLink) {
                linkEl.parentNode.insertBefore(iconWrapperInLink, linkEl);
                linkEl.remove();
              }
            }
          }
          
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
          
          let isProtecting = false;
          const observer = new MutationObserver((mutations) => {
            const hasNewChildren = mutations.some(mutation => 
              mutation.type === 'childList' && mutation.addedNodes.length > 0
            );
            
            if (hasNewChildren && !isProtecting) {
              isProtecting = true;
              protectAllElements(el);
              setTimeout(() => {
                isProtecting = false;
              }, 50);
            }
          });
          
          observer.observe(el, {
            childList: true,
            subtree: true,
            attributes: false
          });
          
          this._iconObserver = observer;
        },
        onRemove() {
          if (this._iconObserver) {
            this._iconObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  if (typeof window !== 'undefined' && window.editor) {
    registerIconComponent(window.editor);
  }
  
  if (typeof window !== 'undefined') {
    window.registerIconComponent = registerIconComponent;
  }
})();
