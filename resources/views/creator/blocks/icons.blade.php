{{-- Bloques de Iconos --}}
{
  id: 'icon',
  label: '<b>Icono</b>',
  category: 'Básicos',
  attributes: {
    class: 'gjs-block-icon'
  },
  content: {
    type: 'icon',
    tagName: 'div',
    name: 'Icono',
    editable: false,
    droppable: false,
    removable: true,
    selectable: true,
    attributes: {
      class: 'icon-container',
      'data-gjs-type': 'icon',
      'data-gjs-name': 'Icono',
      'data-gjs-editable': 'false'
    }
    // Los traits están definidos en el componente icon.js
  }
},
{
  id: 'icon-box',
  label: '<b>Caja de Icono</b>',
  category: 'Básicos',
  attributes: {
    class: 'gjs-block-icon-box'
  },
  content: {
    type: 'icon-box',
    tagName: 'div',
    name: 'Caja de Icono',
    editable: false,
    droppable: false,
    removable: true,
    selectable: true,
    attributes: {
      class: 'icon-box-container',
      'data-gjs-type': 'icon-box',
      'data-gjs-name': 'Caja de Icono',
      'data-gjs-editable': 'false'
    }
    // Los traits están definidos en el componente icon-box.js
  }
},
{
  id: 'icon-list',
  label: '<b>Lista con Iconos</b>',
  category: 'Básicos',
  attributes: {
    class: 'gjs-block-icon-list'
  },
  content: {
    type: 'icon-list',
    tagName: 'div',
    name: 'Lista con Iconos',
    editable: false,
    droppable: false,
    removable: true,
    selectable: true,
    attributes: {
      class: 'icon-list-container',
      'data-gjs-type': 'icon-list',
      'data-gjs-name': 'Lista con Iconos',
      'data-gjs-editable': 'false'
    }
    // Los traits están definidos en el componente icon-list.js
  }
}

