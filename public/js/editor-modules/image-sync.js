// Módulo de Sincronización de Imágenes
// Maneja la sincronización de imágenes antes de guardar y después de cargar

const ImageSync = {
  // Sincronizar imágenes antes de guardar
  syncBeforeSave: function(editor) {
    const allComponents = editor.DomComponents.getWrapper().find('*');
    const imageComponents = allComponents.filter(comp => {
      const type = comp.get('type');
      const tagName = comp.get('tagName');
      return type === 'image' || tagName === 'img';
    });
    
    imageComponents.forEach((imgComp) => {
      const imageSrc = imgComp.get('image-src');
      const attrsSrc = imgComp.getAttributes().src;
      const domSrc = imgComp.view && imgComp.view.el ? imgComp.view.el.src : null;
      const defaultImageSrc = '/images/default-image.jpg';
      
      // Validar y determinar el src final: priorizar image-src, luego DOM, luego attrs, luego default
      let finalSrc;
      if (imageSrc && imageSrc.trim() && imageSrc !== 'undefined' && imageSrc !== defaultImageSrc && imageSrc !== '' && imageSrc !== 'null') {
        finalSrc = imageSrc.trim();
      } else if (domSrc && domSrc.trim() && domSrc !== 'undefined' && domSrc !== defaultImageSrc && domSrc !== '' && domSrc !== 'null') {
        finalSrc = domSrc.trim();
      } else if (attrsSrc && attrsSrc.trim() && attrsSrc !== 'undefined' && attrsSrc !== defaultImageSrc && attrsSrc !== '' && attrsSrc !== 'null') {
        finalSrc = attrsSrc.trim();
      } else {
        finalSrc = defaultImageSrc;
      }
      
      // ✅ CRÍTICO: Actualizar atributos del modelo PRIMERO
      imgComp.setAttributes({ src: finalSrc });
      
      // ✅ CRÍTICO: Actualizar el DOM directamente (getHtml() lee del DOM)
      if (imgComp.view && imgComp.view.el) {
        const el = imgComp.view.el;
        el.src = finalSrc;
        el.setAttribute('src', finalSrc);
        // Forzar actualización removiendo y agregando el atributo
        el.removeAttribute('src');
        el.setAttribute('src', finalSrc);
      } else {
        console.warn('⚠️ No se encontró view.el para componente de imagen al sincronizar');
      }
      
      // Sincronizar image-src para mantener consistencia
      if (imgComp.get('image-src') !== finalSrc) {
        imgComp.set('image-src', finalSrc, { silent: true });
      }
      
      // Forzar renderizado para asegurar que los cambios se apliquen
      if (imgComp.view) {
        imgComp.view.render();
      }
    });
  },
  
  // Sincronizar imágenes después de cargar contenido
  syncAfterLoad: function(editor) {
    setTimeout(() => {
      const imageComponents = editor.DomComponents.getWrapper().find('*').filter(comp => {
        const type = comp.get('type');
        const tagName = comp.get('tagName');
        return type === 'image' || tagName === 'img';
      });
      
      imageComponents.forEach(imgComp => {
        const currentSrc = imgComp.getAttributes().src;
        // Validar que el src sea válido
        if (currentSrc && typeof currentSrc === 'string' && currentSrc.trim() && currentSrc !== 'undefined' && currentSrc !== 'null' && currentSrc !== '') {
          // Sincronizar image-src con el src del atributo
          if (imgComp.get('image-src') !== currentSrc.trim()) {
            imgComp.set('image-src', currentSrc.trim(), { silent: true });
          }
        }
      });
    }, 500);
  }
};
