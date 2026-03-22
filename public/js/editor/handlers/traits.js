
// Lógica de traits y TraitManager para el editor

/**
 * Renderiza traits personalizados para un componente
 * @param {object} component - Componente de GrapesJS
 */
function renderCustomTraits(component) {
  const traitsContainer = document.querySelector('.traits-container');
  if (!traitsContainer) return;
  traitsContainer.innerHTML = '';
  let traits = [];
  const convertTraitToPlain = (trait) => {
    if (trait && trait.get && typeof trait.get === 'function') {
      if (trait.toJSON && typeof trait.toJSON === 'function') {
        const json = trait.toJSON();
        if (!json.type && trait.get('type')) json.type = trait.get('type');
        return json;
      }
      const plain = {};
      ['type', 'name', 'label', 'placeholder', 'options', 'text', 'command', 'content', 'changeProp'].forEach(prop => {
        const value = trait.get(prop);
        if (value !== undefined && value !== null) plain[prop] = value;
      });
      if (trait.attributes) Object.assign(plain, trait.attributes);
      return plain;
    }
    return trait;
  // Fin de función renderTraits
  if (component.getTraits && typeof component.getTraits === 'function') {
    const traitsCollection = component.getTraits();
    if (traitsCollection) {
      if (traitsCollection.toJSON && typeof traitsCollection.toJSON === 'function') {
        traits = traitsCollection.toJSON();
      } else if (traitsCollection.length !== undefined) {
        traits = Array.from(traitsCollection).map(convertTraitToPlain);
      } else if (Array.isArray(traitsCollection)) {
        traits = traitsCollection.map(convertTraitToPlain);
      } else {
        traits = [convertTraitToPlain(traitsCollection)];
      }
    }
  } else if (component.get('traits')) {
    const traitsCollection = component.get('traits');
    if (traitsCollection.toJSON && typeof traitsCollection.toJSON === 'function') {
      traits = traitsCollection.toJSON();
    } else if (Array.isArray(traitsCollection)) {
      traits = traitsCollection.map(convertTraitToPlain);
    } else {
      traits = [convertTraitToPlain(traitsCollection)];
    }
  }

  if (traits.length === 0) {
    traitsContainer.innerHTML = '<div class="text-gray-500 text-sm p-4">No hay propiedades disponibles</div>';
    return;
  }

  traits.forEach(trait => {
    if (trait && trait.get && typeof trait.get === 'function') {
      trait = trait.toJSON ? trait.toJSON() : {
        type: trait.get('type'),
        name: trait.get('name'),
        label: trait.get('label'),
        placeholder: trait.get('placeholder'),
        options: trait.get('options'),
        text: trait.get('text'),
        command: trait.get('command'),
        content: trait.get('content'),
        changeProp: trait.get('changeProp'),
        ...trait.attributes
      };
    }
    if (!trait || !trait.type) return;
    const traitElement = createTraitElement(trait, component);
    if (traitElement) traitsContainer.appendChild(traitElement);
  });
// Fin de función principal TraitManager

/**
 * Crea un elemento de trait para el panel
 * @param {object} trait
 * @param {object} component
 */
function createTraitElement(trait, component) {
  if (!trait || !trait.type) return null;
  const container = document.createElement('div');
  container.className = 'gjs-trt-trait custom-trait';
  container.setAttribute('data-trait-name', trait.name || '');
  const label = document.createElement('label');
  label.className = 'gjs-trt-label';
  label.textContent = trait.label || trait.name || 'Sin nombre';
  container.appendChild(label);
  const fieldContainer = document.createElement('div');
  fieldContainer.className = 'gjs-trt-field';
  let input;
  switch (trait.type) {
    case 'text':
      input = document.createElement('input');
      input.type = 'text';
      input.className = 'gjs-trt-input';
      input.placeholder = trait.placeholder || '';
      input.value = component.get(trait.name) || '';
      break;
    case 'textarea':
      input = document.createElement('textarea');
      input.className = 'gjs-trt-textarea';
      input.placeholder = trait.placeholder || '';
      input.value = component.get(trait.name) || '';
      break;
    case 'select':
      input = document.createElement('select');
      input.className = 'gjs-trt-select';
      if (trait.options) {
        trait.options.forEach(option => {
          const optionElement = document.createElement('option');
          optionElement.value = option.value;
          optionElement.textContent = option.name;
          input.appendChild(optionElement);
        });
      }
      input.value = component.get(trait.name) || '';
      break;
    case 'checkbox':
      input = document.createElement('input');
      input.type = 'checkbox';
      input.className = 'gjs-trt-checkbox';
      input.checked = component.get(trait.name) || false;
      break;
    case 'button':
      input = document.createElement('button');
      input.type = 'button';
      input.className = 'gjs-trt-button';
      input.textContent = trait.text || trait.label;
      if (trait.command) {
        input.addEventListener('click', () => trait.command(editor));
      }
      break;
    case 'custom':
      fieldContainer.innerHTML = trait.content || '';
      container.appendChild(fieldContainer);
      return container;
    default:
      return null;
  }
  if (input && trait.type !== 'button') {
    if (trait.name) {
      component.on(`change:${trait.name}`, (model, value) => {
        if (input.type === 'checkbox') {
          input.checked = value || false;
        } else {
          input.value = value || '';
        }
      });
    }
    input.addEventListener('change', (e) => {
      const value = e.target.type === 'checkbox' ? e.target.checked : e.target.value;
      component.set(trait.name, value);
    });
    input.addEventListener('input', (e) => {
      const value = e.target.type === 'checkbox' ? e.target.checked : e.target.value;
      component.set(trait.name, value);
    });
  }
  fieldContainer.appendChild(input);
  container.appendChild(fieldContainer);
  return container;
}

/**
 * Actualiza las etiquetas de traits según el dispositivo activo
 */
function updateTraitLabelsForDevice(editor) {
  if (!editor || !editor.getDevice) return;
  const currentDevice = editor.getDevice();
  const traitsContainer = document.querySelector('.traits-container');
  if (!traitsContainer) return;
  const deviceLabels = {
    'Desktop': 'Desktop',
    'Tablet': 'Tablet',
    'Mobile': 'Mobile'
  };
  const deviceName = deviceLabels[currentDevice] || 'Desktop';
  let deviceIndicator = document.querySelector('.device-indicator');
  if (!deviceIndicator) {
    deviceIndicator = document.createElement('div');
    deviceIndicator.className = 'p-2 mb-3 border border-blue-200 rounded-md device-indicator bg-blue-50';
    deviceIndicator.style.fontSize = '0.75rem';
    traitsContainer.insertBefore(deviceIndicator, traitsContainer.firstChild);
  }
  const deviceIcons = {
    'Desktop': '🖥️',
    'Tablet': '📱',
    'Mobile': '📱'
  };
  deviceIndicator.innerHTML = `
    <div class="flex items-center gap-2">
      <span class="text-blue-600 font-semibold">${deviceIcons[deviceName] || '🖥️'} Editando: ${deviceName}</span>
      <span class="text-gray-500 text-xs">Las propiedades marcadas con (${deviceName}) se aplicarán a este dispositivo</span>
    </div>
  `;
  const traitLabels = traitsContainer.querySelectorAll('.gjs-trt-label');
  traitLabels.forEach(label => {
    const labelText = label.textContent || '';
    if (labelText.includes('(Desktop)') || labelText.includes('(Tablet)') || labelText.includes('(Mobile)')) {
      label.classList.remove('font-bold', 'text-blue-600', 'bg-blue-50', 'px-2', 'py-1', 'rounded');
      if (labelText.includes(`(${deviceName})`)) {
        label.classList.add('font-bold', 'text-blue-600', 'bg-blue-50', 'px-2', 'py-1', 'rounded');
      }
    }
  });
}

/**
 * Fuerza la actualización del TraitManager
 */
function forceTraitManagerUpdate(editor, component) {
  if (!editor.TraitManager) return;
  const targetComponent = component || editor.getSelected();
  if (targetComponent) {
    try {
      const traitsContainer = document.querySelector('.traits-container');
      if (traitsContainer) traitsContainer.innerHTML = '';
      if (editor.TraitManager.collection) editor.TraitManager.collection.reset();
      if (typeof editor.TraitManager.render === 'function') editor.TraitManager.render();
    } catch (error) {
      // Error updating traits
    }
  }
}
      const traitsCollection = component.get('traits');
      if (traitsCollection.toJSON && typeof traitsCollection.toJSON === 'function') {
        traits = traitsCollection.toJSON();
      } else if (Array.isArray(traitsCollection)) {
        traits = traitsCollection.map(convertTraitToPlain);
      } else {
        traits = [convertTraitToPlain(traitsCollection)];
      }
    }
    if (traits.length === 0) {
      traitsContainer.innerHTML = '<div class="text-gray-500 text-sm p-4">No hay propiedades disponibles</div>';
      return;
    }
    traits.forEach(trait => {
      if (trait && trait.get && typeof trait.get === 'function') {
        trait = trait.toJSON ? trait.toJSON() : {
          type: trait.get('type'),
          name: trait.get('name'),
          label: trait.get('label'),
          placeholder: trait.get('placeholder'),
          options: trait.get('options'),
          text: trait.get('text'),
          command: trait.get('command'),
          content: trait.get('content'),
          changeProp: trait.get('changeProp'),
          ...trait.attributes
        };
      }
      if (!trait || !trait.type) return;
      // Aquí deberías llamar a tu función createTraitElement(trait, component)
      // y agregar el resultado a traitsContainer
    });
  };

  // Puedes agregar aquí más lógica relacionada con TraitManager
// Fin de archivo traits.js
export { renderCustomTraits, createTraitElement, updateTraitLabelsForDevice, forceTraitManagerUpdate };
