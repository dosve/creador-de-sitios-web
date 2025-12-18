{{-- Bloques Básicos de WordPress --}}
{
  id: 'code',
  label: '<b>Código</b>',
  category: 'Básicos',
  content: {
    type: 'code',
    tagName: 'pre',
    name: 'Código',
    editable: false,
    droppable: false,
    removable: true,
    selectable: true,
    attributes: {
      class: 'code-container',
      'data-gjs-type': 'code',
      'data-gjs-name': 'Código',
      'data-gjs-editable': 'false'
    }
    // Los traits están definidos en el componente code.js
  }
},
{
  id: 'preformatted',
  label: '<b>Preformateado</b>',
  category: 'Básicos',
  content: {
    type: 'preformatted',
    tagName: 'pre',
    name: 'Preformateado',
    editable: false,
    droppable: false,
    removable: true,
    selectable: true,
    attributes: {
      class: 'preformatted-container',
      'data-gjs-type': 'preformatted',
      'data-gjs-name': 'Preformateado',
      'data-gjs-editable': 'false'
    }
    // Los traits están definidos en el componente preformatted.js
  }
},
{
  id: 'verse',
  label: '<b>Verso</b>',
  category: 'Básicos',
  content: {
    type: 'verse',
    tagName: 'div',
    name: 'Verso',
    editable: false,
    droppable: false,
    removable: true,
    selectable: true,
    attributes: {
      class: 'verse-container',
      'data-gjs-type': 'verse',
      'data-gjs-name': 'Verso',
      'data-gjs-editable': 'false'
    }
    // Los traits están definidos en el componente verse.js
  }
}
