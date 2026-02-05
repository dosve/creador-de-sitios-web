console.log('%c✅✅✅ TEST-RESPONSIVE.JS CARGADO CORRECTAMENTE ✅✅✅', 'color: #51cf66; font-size: 16px; font-weight: bold;');

// Simple test function
window.testResponsive = function() {
  console.log('%c📊 TEST RESPONSIVE FUNCTION EJECUTADA', 'color: #4dabf7; font-weight: bold;');
  return {
    loaded: true,
    timestamp: new Date().toISOString(),
    viewport: window.innerWidth + 'px',
    message: 'Si ves esto, el JS está cargando correctamente'
  };
};

console.log('%c✅ window.testResponsive() está disponible', 'color: #51cf66;');
