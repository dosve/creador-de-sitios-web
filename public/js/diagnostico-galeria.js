/**
 * Script de Diagnóstico para Galería de Imágenes en GrapesJS
 * Coloca este código en la consola del navegador dentro del editor
 */

console.log('=== DIAGNÓSTICO DE GALERÍA DE IMÁGENES ===\n');

// 1. Verificar editor
console.log('1. VERIFICANDO EDITOR:');
if (typeof window.editor !== 'undefined' && window.editor) {
  console.log('✓ Editor disponible');
  console.log('  - DomComponents:', !!window.editor.DomComponents);
  console.log('  - AssetManager:', !!window.editor.AssetManager);
  console.log('  - Modal:', !!window.editor.Modal);
  console.log('  - TraitManager:', !!window.editor.TraitManager);
} else {
  console.error('✗ Editor NO disponible. Abre el editor primero.');
}

// 2. Verificar AssetManager
console.log('\n2. VERIFICANDO ASSET MANAGER:');
if (window.editor && window.editor.AssetManager) {
  const am = window.editor.AssetManager;
  console.log('✓ AssetManager disponible');
  console.log('  - getAll():', typeof am.getAll);
  console.log('  - add():', typeof am.add);
  console.log('  - open():', typeof am.open);
  console.log('  - on():', typeof am.on);
  console.log('  - off():', typeof am.off);
  console.log('  - Assets cargados:', am.getAll().length);
} else {
  console.error('✗ AssetManager NO disponible');
}

// 3. Probar API de Galería
console.log('\n3. PROBANDO API DE GALERÍA:');
fetch('/creator/media/api/list')
  .then(response => {
    console.log('  - Status HTTP:', response.status, response.statusText);
    if (!response.ok) throw new Error('HTTP ' + response.status);
    return response.json();
  })
  .then(data => {
    if (data.success) {
      console.log('✓ API funcionando');
      console.log('  - Imágenes disponibles:', data.files.length);
      if (data.files.length > 0) {
        console.log('  - Primera imagen:', data.files[0]);
      }
    } else {
      console.error('✗ API retornó error:', data.error);
    }
  })
  .catch(error => {
    console.error('✗ Error al llamar API:', error);
  });

// 4. Verificar componente background-image
console.log('\n4. VERIFICANDO COMPONENTE BACKGROUND-IMAGE:');
if (window.editor && window.editor.DomComponents) {
  const type = window.editor.DomComponents.getType('background-image');
  if (type) {
    console.log('✓ Componente "background-image" registrado');
    console.log('  - Model:', !!type.model);
    console.log('  - View:', !!type.view);
  } else {
    console.error('✗ Componente "background-image" NO registrado');
  }
}

// 5. Verificar componente container
console.log('\n5. VERIFICANDO COMPONENTE CONTAINER:');
if (window.editor && window.editor.DomComponents) {
  const type = window.editor.DomComponents.getType('container');
  if (type) {
    console.log('✓ Componente "container" registrado');
  } else {
    console.error('✗ Componente "container" NO registrado');
  }
}

// 6. Prueba manual: Abrir modal de galería
console.log('\n6. PRUEBA MANUAL:');
console.log('Ejecuta esto para abrir el modal de galería:');
console.log(`
  const am = window.editor.AssetManager;
  fetch('/creator/media/api/list')
    .then(r => r.json())
    .then(data => {
      am.getAll().reset();
      data.files.forEach(f => {
        am.add({type: 'image', src: f.url, name: f.filename});
      });
      am.open({types: ['image']});
    });
`);

console.log('\n=== FIN DE DIAGNÓSTICO ===');
