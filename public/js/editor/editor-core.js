import { initializeEditorAdvanced, initializeManagers } from './handlers/initialization.js';
import { registerGlobalListeners } from './handlers/listeners.js';
import { initializeLayerManager } from './handlers/layer-manager.js';
import { showEditorUI } from './utils/ui.js';
import { syncEditorComponents } from './utils/sync.js';
// Inicializar LayerManager
initializeLayerManager(editor);

// Mostrar UI del editor
showEditorUI();

// Sincronizar componentes visuales
syncEditorComponents(editor);
import { applyOverlayStylesToCanvas } from './utils/overlay.js';
// Listener para overlays en el canvas
editor.on('canvas:frame:load', () => {
	setTimeout(() => applyOverlayStylesToCanvas(editor), 150);
});
import { registerCustomComponents } from './components/register.js';
// Configuración principal e inicialización del editor
// Aquí se importarán y usarán los módulos


import { initDragDrop } from './handlers/drag-drop.js';
import { showProductsPlaceholder } from './handlers/placeholder.js';
import { initializeStyleManager, handleSectorClick } from './handlers/style-manager.js';
import { renderCustomTraits, createTraitElement, updateTraitLabelsForDevice, forceTraitManagerUpdate } from './handlers/traits.js';
import { registerEditorCommands } from './handlers/commands.js';
import { registerEditorEvents } from './handlers/events.js';
import { markUserEdits, fixContainerResponsiveClasses } from './utils/helpers.js';
import { logInfo, logWarn, logError } from './utils/logger.js';

// Configuración principal e inicialización del editor
// (Ajusta según tu lógica real de inicialización)
const editor = initializeEditorAdvanced(window.editorConfig);
initializeManagers(editor);
registerGlobalListeners(editor);

// Inicializar módulos
initDragDrop(editor);
initializeStyleManager(editor);
registerEditorCommands(editor);
registerEditorEvents(editor);
registerCustomComponents(editor);

// Ejemplo: mostrar placeholder de productos
showProductsPlaceholder(editor);

// Ejemplo: renderizar traits personalizados
editor.on('component:selected', (component) => {
	renderCustomTraits(component);
});

// Ejemplo: logging
logInfo('Editor inicializado y módulos integrados');
