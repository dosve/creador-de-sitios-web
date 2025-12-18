// Módulo del Componente Icon Box
// Componente unificado de caja de icono estilo Elementor con traits y protección

(function() {
  'use strict';
  
  function registerIconBoxComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente IconBox');
      return;
    }
    
    editor.DomComponents.addType('icon-box', {
      isComponent: (el) => {
        // Verificar que el sea un elemento DOM válido
        if (!el || typeof el !== 'object' || !el.nodeType) {
          return false;
        }
        
        if (el.classList && (el.classList.contains('icon-box-container') || el.classList.contains('icon-box') || el.classList.contains('icon-box-horizontal'))) {
          return { type: 'icon-box' };
        }
        if (el.tagName === 'DIV' && el.querySelector && typeof el.querySelector === 'function' && 
            (el.querySelector('.icon-box') || el.querySelector('.icon-box-horizontal') || el.querySelector('.icon-wrapper'))) {
          return { type: 'icon-box' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Caja de Icono',
          tagName: 'div',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          hoverable: true,
          highlightable: true,
          badgable: false,
          attributes: {
            class: 'icon-box-container',
            'data-gjs-type': 'icon-box',
            'data-gjs-name': 'Caja de Icono',
            'data-gjs-editable': 'false',
            'data-gjs-highlightable': 'true'
          },
          'icon-box-layout': 'vertical',
          'icon-box-type': 'lightning',
          'icon-box-title': 'Título del Feature',
          'icon-box-description': 'Descripción del feature o servicio que ofreces. Explica los beneficios de forma clara.',
          'icon-box-color': '#2563eb',
          'icon-box-bg-color': '#dbeafe',
          'icon-box-link': '',
          traits: [
            {
              type: 'select',
              name: 'icon-box-layout',
              label: 'Layout',
              changeProp: 1,
              options: [
                { value: 'vertical', name: 'Vertical (Centrado)' },
                { value: 'horizontal', name: 'Horizontal' }
              ]
            },
            {
              type: 'select',
              name: 'icon-box-type',
              label: 'Tipo de Icono',
              changeProp: 1,
              options: [
                { value: 'lightning', name: 'Rayo' },
                { value: 'star', name: 'Estrella' },
                { value: 'heart', name: 'Corazón' },
                { value: 'check', name: 'Check' },
                { value: 'shield', name: 'Escudo' },
                { value: 'clock', name: 'Reloj' },
                { value: 'chart', name: 'Gráfico' },
                { value: 'users', name: 'Usuarios' },
                { value: 'globe', name: 'Globo' },
                { value: 'rocket', name: 'Cohete' },
                { value: 'user', name: 'Usuario' },
                { value: 'mail', name: 'Email' },
                { value: 'phone', name: 'Teléfono' },
                { value: 'home', name: 'Casa' },
                { value: 'settings', name: 'Configuración' },
                { value: 'search', name: 'Búsqueda' }
              ]
            },
            {
              type: 'text',
              name: 'icon-box-title',
              label: 'Título',
              placeholder: 'Título del Feature',
              changeProp: 1
            },
            {
              type: 'textarea',
              name: 'icon-box-description',
              label: 'Descripción',
              placeholder: 'Descripción del feature...',
              rows: 3,
              changeProp: 1
            },
            {
              type: 'color',
              name: 'icon-box-color',
              label: 'Color del Icono',
              changeProp: 1,
              placeholder: '#2563eb'
            },
            {
              type: 'color',
              name: 'icon-box-bg-color',
              label: 'Color de Fondo del Icono',
              changeProp: 1,
              placeholder: '#dbeafe'
            },
            {
              type: 'text',
              name: 'icon-box-link',
              label: 'Enlace (opcional)',
              placeholder: 'https://ejemplo.com',
              changeProp: 1
            }
          ]
        },
        init() {
          this.on('change:icon-box-layout', this.updateLayout, this);
          this.on('change:icon-box-type', this.updateIcon, this);
          this.on('change:icon-box-title', this.updateTitle, this);
          this.on('change:icon-box-description', this.updateDescription, this);
          this.on('change:icon-box-color', this.updateColors, this);
          this.on('change:icon-box-bg-color', this.updateColors, this);
          this.on('change:icon-box-link', this.updateLink, this);
          
          // Proteger TODOS los elementos internos
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
                // Ignorar errores al proteger componentes individuales
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
              // Ignorar errores generales de protección
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
            shield: 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
            clock: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
            chart: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
            users: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
            globe: 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            rocket: 'M13 10V3L4 14h7v7l9-11h-7z',
            user: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
            mail: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
            phone: 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',
            home: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
            settings: 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z',
            search: 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'
          };
          return icons[type] || icons.lightning;
        },
        updateLayout() {
          if (!this.view || !this.view.el) return;
          
          const layout = this.get('icon-box-layout') || 'vertical';
          this.renderIconBox();
          this.view.render();
        },
        updateIcon() {
          if (!this.view || !this.view.el) return;
          
          const type = this.get('icon-box-type') || 'lightning';
          const iconPath = this.getIconPath(type);
          
          const el = this.view.el;
          const iconSvg = el.querySelector('.icon-wrapper svg path');
          
          if (iconSvg) {
            iconSvg.setAttribute('d', iconPath);
          }
          
          this.view.render();
        },
        updateTitle() {
          const title = this.get('icon-box-title') || '';
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const titleEl = el.querySelector('.icon-box-title');
          
          if (titleEl) {
            titleEl.textContent = title;
          }
          
          this.view.render();
        },
        updateDescription() {
          const description = this.get('icon-box-description') || '';
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const descEl = el.querySelector('.icon-box-description');
          
          if (descEl) {
            descEl.textContent = description;
          }
          
          this.view.render();
        },
        updateColors() {
          if (!this.view || !this.view.el) return;
          
          const color = this.get('icon-box-color') || '#2563eb';
          const bgColor = this.get('icon-box-bg-color') || '#dbeafe';
          
          const el = this.view.el;
          const iconWrapper = el.querySelector('.icon-wrapper');
          const iconSvg = el.querySelector('.icon-wrapper svg');
          
          if (iconWrapper) {
            iconWrapper.style.setProperty('background-color', bgColor, 'important');
          }
          
          if (iconSvg) {
            iconSvg.style.setProperty('color', color, 'important');
          }
          
          this.view.render();
        },
        updateLink() {
          const link = this.get('icon-box-link') || '';
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const layout = this.get('icon-box-layout') || 'vertical';
          
          // Si hay enlace, envolver en <a>, si no, quitar el <a>
          if (link) {
            const boxDiv = el.querySelector('.icon-box, .icon-box-horizontal');
            if (boxDiv && boxDiv.parentElement.tagName !== 'A') {
              const linkEl = document.createElement('a');
              linkEl.href = link;
              linkEl.className = 'icon-box-link block';
              linkEl.setAttribute('data-gjs-editable', 'false');
              linkEl.setAttribute('data-gjs-selectable', 'false');
              boxDiv.parentNode.insertBefore(linkEl, boxDiv);
              linkEl.appendChild(boxDiv);
            } else if (boxDiv && boxDiv.parentElement.tagName === 'A') {
              boxDiv.parentElement.href = link;
            }
          } else {
            const linkEl = el.querySelector('.icon-box-link');
            if (linkEl && linkEl.tagName === 'A') {
              const boxDiv = linkEl.querySelector('.icon-box, .icon-box-horizontal');
              if (boxDiv) {
                linkEl.parentNode.insertBefore(boxDiv, linkEl);
                linkEl.remove();
              }
            }
          }
          
          this.view.render();
        },
        renderIconBox() {
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const layout = this.get('icon-box-layout') || 'vertical';
          const type = this.get('icon-box-type') || 'lightning';
          const title = this.get('icon-box-title') || 'Título del Feature';
          const description = this.get('icon-box-description') || '';
          const color = this.get('icon-box-color') || '#2563eb';
          const bgColor = this.get('icon-box-bg-color') || '#dbeafe';
          const link = this.get('icon-box-link') || '';
          const iconPath = this.getIconPath(type);
          
          // Limpiar contenido existente
          el.innerHTML = '';
          
          let boxDiv;
          
          if (layout === 'horizontal') {
            boxDiv = document.createElement('div');
            boxDiv.className = 'icon-box-horizontal flex items-start p-6 bg-white rounded-lg hover:shadow-lg transition-shadow';
            boxDiv.setAttribute('data-gjs-editable', 'false');
            boxDiv.setAttribute('data-gjs-selectable', 'false');
            
            // Icono
            const iconWrapper = document.createElement('div');
            iconWrapper.className = 'icon-wrapper flex-shrink-0 flex items-center justify-center w-12 h-12 mr-4 rounded-full';
            iconWrapper.style.setProperty('background-color', bgColor, 'important');
            iconWrapper.setAttribute('data-gjs-editable', 'false');
            iconWrapper.setAttribute('data-gjs-selectable', 'false');
            
            const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            svg.setAttribute('class', 'w-6 h-6');
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
            
            // Contenido
            const contentDiv = document.createElement('div');
            contentDiv.className = 'flex-1';
            contentDiv.setAttribute('data-gjs-editable', 'false');
            contentDiv.setAttribute('data-gjs-selectable', 'false');
            
            const titleEl = document.createElement('h3');
            titleEl.className = 'icon-box-title text-lg font-semibold text-gray-900 mb-2';
            titleEl.setAttribute('data-gjs-editable', 'false');
            titleEl.setAttribute('data-gjs-selectable', 'false');
            titleEl.setAttribute('contenteditable', 'false');
            titleEl.textContent = title;
            
            const descEl = document.createElement('p');
            descEl.className = 'icon-box-description text-gray-600';
            descEl.setAttribute('data-gjs-editable', 'false');
            descEl.setAttribute('data-gjs-selectable', 'false');
            descEl.setAttribute('contenteditable', 'false');
            descEl.textContent = description;
            
            contentDiv.appendChild(titleEl);
            contentDiv.appendChild(descEl);
            
            boxDiv.appendChild(iconWrapper);
            boxDiv.appendChild(contentDiv);
          } else {
            // Vertical
            boxDiv = document.createElement('div');
            boxDiv.className = 'icon-box text-center p-6 bg-white rounded-lg hover:shadow-lg transition-shadow';
            boxDiv.setAttribute('data-gjs-editable', 'false');
            boxDiv.setAttribute('data-gjs-selectable', 'false');
            
            // Icono
            const iconWrapper = document.createElement('div');
            iconWrapper.className = 'icon-wrapper inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full';
            iconWrapper.style.setProperty('background-color', bgColor, 'important');
            iconWrapper.setAttribute('data-gjs-editable', 'false');
            iconWrapper.setAttribute('data-gjs-selectable', 'false');
            
            const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            svg.setAttribute('class', 'w-8 h-8');
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
            
            // Título
            const titleEl = document.createElement('h3');
            titleEl.className = 'icon-box-title text-xl font-semibold text-gray-900 mb-2';
            titleEl.setAttribute('data-gjs-editable', 'false');
            titleEl.setAttribute('data-gjs-selectable', 'false');
            titleEl.setAttribute('contenteditable', 'false');
            titleEl.textContent = title;
            
            // Descripción
            const descEl = document.createElement('p');
            descEl.className = 'icon-box-description text-gray-600';
            descEl.setAttribute('data-gjs-editable', 'false');
            descEl.setAttribute('data-gjs-selectable', 'false');
            descEl.setAttribute('contenteditable', 'false');
            descEl.textContent = description;
            
            boxDiv.appendChild(iconWrapper);
            boxDiv.appendChild(titleEl);
            boxDiv.appendChild(descEl);
          }
          
          // Envolver en enlace si existe
          if (link) {
            const linkEl = document.createElement('a');
            linkEl.href = link;
            linkEl.className = 'icon-box-link block';
            linkEl.setAttribute('data-gjs-editable', 'false');
            linkEl.setAttribute('data-gjs-selectable', 'false');
            linkEl.appendChild(boxDiv);
            el.appendChild(linkEl);
          } else {
            el.appendChild(boxDiv);
          }
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
          
          const layout = this.get('icon-box-layout') || 'vertical';
          const type = this.get('icon-box-type') || 'lightning';
          const title = this.get('icon-box-title') || 'Título del Feature';
          const description = this.get('icon-box-description') || '';
          const color = this.get('icon-box-color') || '#2563eb';
          const bgColor = this.get('icon-box-bg-color') || '#dbeafe';
          const link = this.get('icon-box-link') || '';
          const iconPath = this.getIconPath(type);
          
          // Escapar HTML
          const escapeHtml = (text) => {
            if (!text) return '';
            const map = {
              '&': '&amp;',
              '<': '&lt;',
              '>': '&gt;',
              '"': '&quot;',
              "'": '&#039;'
            };
            return String(text).replace(/[&<>"']/g, m => map[m]);
          };
          
          let innerHTML = '';
          
          if (layout === 'horizontal') {
            innerHTML += '<div class="icon-box-horizontal flex items-start p-6 bg-white rounded-lg hover:shadow-lg transition-shadow" style="';
            innerHTML += '">';
            innerHTML += '<div class="icon-wrapper flex-shrink-0 flex items-center justify-center w-12 h-12 mr-4 rounded-full" style="background-color: ' + bgColor + ';">';
            innerHTML += '<svg class="w-6 h-6" style="color: ' + color + ';" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
            innerHTML += '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="' + iconPath + '"></path>';
            innerHTML += '</svg>';
            innerHTML += '</div>';
            innerHTML += '<div class="flex-1">';
            innerHTML += '<h3 class="icon-box-title text-lg font-semibold text-gray-900 mb-2">' + escapeHtml(title) + '</h3>';
            innerHTML += '<p class="icon-box-description text-gray-600">' + escapeHtml(description) + '</p>';
            innerHTML += '</div>';
            innerHTML += '</div>';
          } else {
            innerHTML += '<div class="icon-box text-center p-6 bg-white rounded-lg hover:shadow-lg transition-shadow">';
            innerHTML += '<div class="icon-wrapper inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full" style="background-color: ' + bgColor + ';">';
            innerHTML += '<svg class="w-8 h-8" style="color: ' + color + ';" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
            innerHTML += '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="' + iconPath + '"></path>';
            innerHTML += '</svg>';
            innerHTML += '</div>';
            innerHTML += '<h3 class="icon-box-title text-xl font-semibold text-gray-900 mb-2">' + escapeHtml(title) + '</h3>';
            innerHTML += '<p class="icon-box-description text-gray-600">' + escapeHtml(description) + '</p>';
            innerHTML += '</div>';
          }
          
          // Envolver en enlace si existe
          if (link) {
            innerHTML = '<a href="' + escapeHtml(link) + '" class="icon-box-link block">' + innerHTML + '</a>';
          }
          
          const finalHTML = '<' + tagName + (attrsStr ? ' ' + attrsStr : '') + '>' + innerHTML + '</' + tagName + '>';
          return finalHTML;
        }
      },
      view: {
        onRender() {
          const el = this.el;
          const component = this.model;
          
          // Proteger el contenedor principal pero mantenerlo seleccionable
          el.setAttribute('contenteditable', 'false');
          el.setAttribute('data-gjs-editable', 'false');
          el.setAttribute('data-gjs-selectable', 'true');
          el.setAttribute('data-gjs-highlightable', 'true');
          el.setAttribute('data-gjs-hoverable', 'true');
          
          // Renderizar la caja de icono
          component.renderIconBox();
          
          // Proteger todos los elementos internos
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
          
          // Observar cambios en el DOM SOLO para nuevos elementos (childList)
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
          
          this._iconBoxObserver = observer;
        },
        onRemove() {
          if (this._iconBoxObserver) {
            this._iconBoxObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  // Auto-registrar si el editor está disponible
  if (typeof window !== 'undefined' && window.editor) {
    registerIconBoxComponent(window.editor);
  }
  
  // Exportar para registro manual
  if (typeof window !== 'undefined') {
    window.registerIconBoxComponent = registerIconBoxComponent;
  }
})();
