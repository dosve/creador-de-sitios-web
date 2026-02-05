/**
 * 🎨 Panel Visual de Diagnóstico Responsive
 * Crea un panel en la página que muestra el estado del responsive en tiempo real
 */

window.showResponsiveDashboard = function() {
  // Crear estilos CSS para el dashboard
  const style = document.createElement('style');
  style.textContent = `
    .responsive-dashboard {
      position: fixed;
      bottom: 20px;
      right: 20px;
      width: 380px;
      max-height: 600px;
      background: white;
      border: 2px solid #ff6b6b;
      border-radius: 8px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
      z-index: 999999;
      font-family: 'Courier New', monospace;
      overflow-y: auto;
      font-size: 12px;
      line-height: 1.4;
    }
    
    .responsive-dashboard-header {
      background: #ff6b6b;
      color: white;
      padding: 12px;
      font-weight: bold;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 2px solid #ff6b6b;
    }
    
    .responsive-dashboard-close {
      background: rgba(255,255,255,0.3);
      border: 1px solid white;
      color: white;
      width: 24px;
      height: 24px;
      border-radius: 50%;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
    }
    
    .responsive-dashboard-close:hover {
      background: rgba(255,255,255,0.5);
    }
    
    .responsive-dashboard-content {
      padding: 12px;
    }
    
    .dashboard-section {
      margin-bottom: 12px;
      padding: 8px;
      background: #f5f5f5;
      border-left: 3px solid #4dabf7;
      border-radius: 4px;
    }
    
    .dashboard-section-title {
      font-weight: bold;
      color: #ff6b6b;
      margin-bottom: 6px;
      text-transform: uppercase;
      font-size: 11px;
    }
    
    .dashboard-item {
      display: flex;
      justify-content: space-between;
      margin: 4px 0;
      padding: 2px 0;
    }
    
    .dashboard-label {
      color: #666;
      flex: 1;
    }
    
    .dashboard-value {
      color: #333;
      font-weight: bold;
      text-align: right;
      flex: 0 0 auto;
      margin-left: 10px;
    }
    
    .status-ok {
      color: #51cf66;
    }
    
    .status-error {
      color: #ff6b6b;
    }
    
    .status-warning {
      color: #ffa94d;
    }
    
    .status-info {
      color: #4dabf7;
    }
    
    .dashboard-button {
      width: 100%;
      padding: 8px;
      margin: 4px 0;
      border: 1px solid #ddd;
      background: #f9f9f9;
      border-radius: 4px;
      cursor: pointer;
      font-family: 'Courier New', monospace;
      font-size: 11px;
      font-weight: bold;
      transition: all 0.2s;
    }
    
    .dashboard-button:hover {
      background: #e3f2fd;
      border-color: #4dabf7;
      color: #4dabf7;
    }
    
    .dashboard-button.danger {
      background: #ffebee;
      border-color: #ff6b6b;
      color: #ff6b6b;
    }
    
    .dashboard-button.danger:hover {
      background: #ff6b6b;
      color: white;
    }
  `;
  document.head.appendChild(style);
  
  // Crear el dashboard
  const dashboard = document.createElement('div');
  dashboard.className = 'responsive-dashboard';
  dashboard.id = 'responsive-dashboard';
  
  function updateDashboard() {
    const viewport = window.innerWidth;
    const isMobile = viewport < 768;
    
    // Contar elementos problemáticos
    const badClasses = ['p--10px-', 'min-h--360px-', 'w--full-', 'md-flex-row'];
    let badCount = 0;
    badClasses.forEach(cls => {
      try {
        badCount += document.querySelectorAll(`.${cls}`).length;
      } catch (e) {}
    });
    
    const containers = document.querySelectorAll('.container-flex').length;
    const columns = document.querySelectorAll('.column-flex').length;
    const mediaQueries = Array.from(document.styleSheets).reduce((acc, sheet) => {
      try {
        return acc + (sheet.cssRules ? Array.from(sheet.cssRules).filter(r => r.media).length : 0);
      } catch (e) {
        return acc;
      }
    }, 0);
    
    dashboard.innerHTML = `
      <div class="responsive-dashboard-header">
        🎯 RESPONSIVE DASHBOARD
        <span class="responsive-dashboard-close" onclick="document.getElementById('responsive-dashboard').remove()" title="Cerrar">✕</span>
      </div>
      
      <div class="responsive-dashboard-content">
        
        <div class="dashboard-section">
          <div class="dashboard-section-title">📐 Viewport Actual</div>
          <div class="dashboard-item">
            <span class="dashboard-label">Ancho:</span>
            <span class="dashboard-value ${isMobile ? 'status-warning' : 'status-info'}">${viewport}px</span>
          </div>
          <div class="dashboard-item">
            <span class="dashboard-label">Tipo:</span>
            <span class="dashboard-value ${isMobile ? 'status-warning' : 'status-info'}">${isMobile ? '📱 Móvil' : '🖥️  Desktop'}</span>
          </div>
        </div>
        
        <div class="dashboard-section">
          <div class="dashboard-section-title">🔍 Elementos Encontrados</div>
          <div class="dashboard-item">
            <span class="dashboard-label">Contenedores:</span>
            <span class="dashboard-value status-info">${containers}</span>
          </div>
          <div class="dashboard-item">
            <span class="dashboard-label">Columnas:</span>
            <span class="dashboard-value status-info">${columns}</span>
          </div>
        </div>
        
        <div class="dashboard-section">
          <div class="dashboard-section-title">⚠️  Problemas Detectados</div>
          <div class="dashboard-item">
            <span class="dashboard-label">Clases mal formadas:</span>
            <span class="dashboard-value ${badCount > 0 ? 'status-error' : 'status-ok'}">${badCount}</span>
          </div>
          <div class="dashboard-item">
            <span class="dashboard-label">Media queries:</span>
            <span class="dashboard-value ${mediaQueries > 0 ? 'status-ok' : 'status-warning'}">${mediaQueries}</span>
          </div>
        </div>
        
        <div class="dashboard-section">
          <div class="dashboard-section-title">🔧 Acciones Disponibles</div>
          <button class="dashboard-button" onclick="window.investigateResponsive()">🔎 Investigar Completo</button>
          <button class="dashboard-button" onclick="window.debugResponsiveClasses()">📊 Diagnóstico Detallado</button>
          <button class="dashboard-button danger" onclick="window.fixResponsiveClasses(); setTimeout(() => location.reload(), 500)">🔨 Reparar y Recargar</button>
        </div>
        
        <div class="dashboard-section" style="border-left-color: #a8e6cf;">
          <div class="dashboard-section-title">💡 Próximo Paso</div>
          <p style="margin: 0; color: #666; font-size: 11px;">
            ${badCount > 0 ? 
              '❌ Se encontraron clases mal formadas. Haz clic en "Reparar" arriba.' : 
              isMobile ? 
              '📱 Estás en móvil. Verifica que las columnas se apilen verticalmente.' : 
              '✅ No hay problemas obvios. Revisa la página visualmente.'
            }
          </p>
        </div>
      </div>
    `;
  }
  
  document.body.appendChild(dashboard);
  updateDashboard();
  
  // Actualizar cada 2 segundos
  setInterval(updateDashboard, 2000);
  
  console.log('%c✅ Dashboard responsivo visible en la esquina inferior derecha', 'color: #51cf66; font-weight: bold;');
};

// Auto-mostrar el dashboard si estamos en desarrollo (localhost)
if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
  window.addEventListener('load', () => {
    console.log('%c💡 TIP: Usa window.showResponsiveDashboard() para ver el panel de diagnóstico', 'color: #ffd43b; font-weight: bold;');
  });
}
