// Módulo de Utilidades para Carrusel
// Funciones para editar y eliminar imágenes del carrusel

(function() {
  'use strict';
  
  function editImage(slideNum) {
    console.log('🖼️ Editando imagen del slide:', slideNum);
    
    const editor = window.editor;
    if (!editor) {
      console.error('❌ Editor no disponible');
      return;
    }
    
    const component = editor.getSelected();
    if (!component) {
      console.error('❌ No hay componente seleccionado');
      return;
    }
    
    // Abrir el Asset Manager
    const am = editor.AssetManager;
    const modal = editor.Modal;
    
    // Configurar el callback cuando se seleccione una imagen
    am.onClick((asset) => {
      const newSrc = asset.get('src');
      console.log('🎠 Nueva imagen seleccionada para slide', slideNum, ':', newSrc);
      
      // Encontrar el contenedor del carrusel
      const carouselContainer = component.view.el.querySelector('.carousel-container') || 
                              component.view.el.querySelector('.carousel') || 
                              component.view.el;
      
      // Buscar la imagen específica del slide
      const existingImages = carouselContainer.querySelectorAll('.carousel-slide img') || 
                           carouselContainer.querySelectorAll('img') ||
                           [];
      
      if (existingImages[slideNum - 1]) {
        // Actualizar la imagen existente
        existingImages[slideNum - 1].src = newSrc;
        existingImages[slideNum - 1].setAttribute('src', newSrc);
        
        // Guardar en el componente
        component.set(`slide-${slideNum}`, newSrc);
        
        console.log(`✅ Slide ${slideNum} actualizado con nueva imagen`);
      } else {
        console.error(`❌ No se encontró el slide ${slideNum}`);
      }
      
      // Cerrar el modal
      modal.close();
      
      // Actualizar traits personalizados para mostrar la nueva imagen
      if (window.renderCustomTraits) {
        window.renderCustomTraits(component);
      }
    });
    
    // Mostrar el Asset Manager en un modal
    modal.setTitle(`Editar Imagen del Slide ${slideNum}`)
      .setContent(am.render())
      .open();
  }
  
  function deleteImage(slideNum) {
    console.log('🗑️ Eliminando imagen del slide:', slideNum);
    
    // Confirmar eliminación
    if (!confirm(`¿Estás seguro de que quieres eliminar la imagen del slide ${slideNum}?`)) {
      return;
    }
    
    const editor = window.editor;
    if (!editor) {
      console.error('❌ Editor no disponible');
      return;
    }
    
    const component = editor.getSelected();
    if (!component) {
      console.error('❌ No hay componente seleccionado');
      return;
    }
    
    // Encontrar el contenedor del carrusel
    const carouselContainer = component.view.el.querySelector('.carousel-container') || 
                            component.view.el.querySelector('.carousel') || 
                            component.view.el;
    
    // Buscar la imagen específica del slide
    const existingImages = carouselContainer.querySelectorAll('.carousel-slide img') || 
                         carouselContainer.querySelectorAll('img') ||
                         [];
    
    if (existingImages[slideNum - 1]) {
      // Reemplazar con imagen placeholder
      const placeholderSrc = `https://via.placeholder.com/800x400?text=Slide+${slideNum}`;
      existingImages[slideNum - 1].src = placeholderSrc;
      existingImages[slideNum - 1].setAttribute('src', placeholderSrc);
      
      // Limpiar del componente
      component.unset(`slide-${slideNum}`);
      
      console.log(`✅ Slide ${slideNum} eliminado (reemplazado con placeholder)`);
    } else {
      console.error(`❌ No se encontró el slide ${slideNum}`);
    }
    
    // Actualizar traits personalizados para ocultar la imagen eliminada
    if (window.renderCustomTraits) {
      window.renderCustomTraits(component);
    }
  }
  
  // Exportar funciones al objeto window
  if (typeof window !== 'undefined') {
    window.editImage = editImage;
    window.deleteImage = deleteImage;
  }
  
})();
