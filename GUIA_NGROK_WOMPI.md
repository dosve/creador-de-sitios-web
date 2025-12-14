# 🚀 Guía Rápida: Usar ngrok con Wompi

## ✅ ngrok está corriendo

**URL pública:** `https://ca7c0fbdeb1f.ngrok-free.app`

## 📋 Pasos para Probar

### 1. Accede a tu aplicación con la URL de ngrok

**Antes (no funciona):**
```
http://127.0.0.1:8000/mi-tienda
```

**Ahora (debe funcionar):**
```
https://ca7c0fbdeb1f.ngrok-free.app/mi-tienda
```

### 2. Verifica que todo cargue correctamente

- La página debe cargar normalmente
- Los estilos deben verse bien
- El carrito debe funcionar

### 3. Prueba el pago con Wompi

1. Agrega productos al carrito
2. Procede al checkout
3. Selecciona "Pago en línea"
4. Haz clic en "Confirmar"
5. El widget de Wompi debería abrirse sin error 403

## 🔍 Qué Esperar en la Consola

**Si funciona correctamente:**
```
✅ SDK de Wompi cargado correctamente
✅ WidgetCheckout disponible
💜 Iniciando checkout de Wompi
🔐 Generando firma de integridad...
✅ Firma de integridad generada correctamente
✅ WidgetCheckout creado correctamente con firma de integridad
✅ Widget de Wompi abierto
```

**Si aún hay problemas:**
- Verifica que estés usando la URL HTTPS de ngrok
- Asegúrate de que ngrok siga corriendo
- Revisa la consola para mensajes de error específicos

## 📝 Comandos Útiles

### Ver la URL actual de ngrok:
```powershell
(Invoke-WebRequest -Uri http://127.0.0.1:4040/api/tunnels -UseBasicParsing).Content | ConvertFrom-Json | Select-Object -ExpandProperty tunnels | Select-Object -First 1 -ExpandProperty public_url
```

### Ver el dashboard de ngrok:
Abre en tu navegador: `http://127.0.0.1:4040`

### Detener ngrok:
Presiona `Ctrl+C` en la terminal donde está corriendo ngrok

### Reiniciar ngrok:
```bash
ngrok http 8000
```
*(Nota: Cada vez que reinicias, obtienes una nueva URL)*

## ⚠️ Notas Importantes

1. **URL temporal:** La URL de ngrok cambia cada vez que lo reinicias (a menos que tengas cuenta de pago)
2. **ngrok debe estar corriendo:** Si cierras ngrok, la URL dejará de funcionar
3. **HTTPS automático:** ngrok proporciona HTTPS automáticamente, lo cual es necesario para Wompi
4. **Dominio público:** Esta URL es accesible desde internet, útil para testing

## 🎯 Resultado Esperado

Con ngrok, el widget de Wompi debería funcionar perfectamente porque:
- ✅ Tienes un dominio público (no localhost)
- ✅ Tienes HTTPS (requerido por Wompi)
- ✅ El código ya está correcto
- ✅ La firma de integridad está implementada

¡Deberías poder hacer pagos de prueba sin problemas! 🎉
