// Sistema de Carga de Componentes
// Permite registrar componentes desde módulos externos

const ComponentLoader = {
  components: [],
  
  // Registrar un componente para cargar después
  register: function(componentName, componentDefinition) {
    this.components.push({
      name: componentName,
      definition: componentDefinition
    });
  },
  
  // Cargar todos los componentes registrados
  loadAll: function(editor) {
    this.components.forEach(comp => {
      if (editor && editor.DomComponents) {
        editor.DomComponents.addType(comp.name, comp.definition);
      }
    });
    console.log(`✅ Cargados ${this.components.length} componentes desde módulos`);
  }
};
