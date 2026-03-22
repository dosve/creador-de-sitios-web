// Registro de componentes personalizados para GrapesJS

/**
 * Registra todos los componentes personalizados en el editor
 * @param {object} editor - Instancia de GrapesJS
 */
export function registerCustomComponents(editor) {
  const componentsToRegister = [
    'Image', 'Container', 'Heading', 'Paragraph', 'Button', 'Text',
    'Link', 'Divider', 'Separator', 'Table', 'HtmlCode', 'Spacer', 'Alert',
    'Icon', 'IconBox', 'IconList', 'StarRating', 'Quote', 'Code', 'Preformatted', 'Verse',
    'Toggle', 'Tabs', 'Accordion',
    'Carousel', 'Gallery', 'Video', 'GoogleMaps',
    'ImageBoxAdvanced', 'BackgroundImage', 'BackgroundColor', 'File', 'Audio', 'CounterAnimated',
    'SectionInner', 'Column'
  ];

  componentsToRegister.forEach(componentName => {
    const registerFn = window[`register${componentName}Component`];
    if (typeof registerFn === 'function') {
      registerFn(editor);
    }
  });
}
