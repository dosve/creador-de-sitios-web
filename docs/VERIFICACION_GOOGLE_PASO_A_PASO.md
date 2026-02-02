# 🚀 Guía Paso a Paso: Verificar tu Primer Sitio en Google

## 📋 Índice
1. Preparar tu sitio en el creador
2. Obtener código de Google
3. Agregar código en tu panel SEO
4. Verificar en Google Search Console
5. Ver resultados
6. Resolver problemas

---

## **PARTE 1: Preparar tu Sitio (5 minutos)**

### Paso 1.1 - Acceder al Panel del Sitio

```
1. Abre tu creador web: https://creadorweb.eme10.com
2. Inicia sesión
3. Selecciona tu sitio web
4. Haz clic en "SEO" en el menú lateral
```

### Paso 1.2 - Ir a Editar Configuración SEO

```
1. En la página de SEO, haz clic en "Editar" (botón azul)
2. Se abrirá el formulario de configuración
```

### Paso 1.3 - Completar Información Básica

**IMPORTANTE: Esto debe estar lleno ANTES de verificar**

```
Meta Título:
  - ¿De qué es tu sitio?
  - Ejemplo: "Mi Tienda Online - Productos de Calidad"
  - Máximo 60 caracteres ⚠️

Meta Descripción:
  - Describe brevemente qué ofreces
  - Ejemplo: "Venta online de ropa y accesorios con envío a todo el país"
  - Máximo 160 caracteres ⚠️

Imagen OG:
  - URL de una imagen (1200x630 píxeles)
  - Aparecerá cuando compartan en redes sociales
  - Ejemplo: https://tudominio.com/logo.jpg
```

**✅ Guardar estos datos ANTES de continuar**

---

## **PARTE 2: Obtener Código de Google (10 minutos)**

### Paso 2.1 - Acceder a Google Search Console

1. **Abre esta URL en tu navegador:**
   ```
   https://search.google.com/search-console
   ```

2. **Inicia sesión** con tu cuenta Google
   - Si no tienes cuenta: créala en https://accounts.google.com

3. **Verás algo así:**
   ```
   ┌─────────────────────────────┐
   │  Google Search Console      │
   │  ┌─────────────────────┐    │
   │  │ + Agregar propiedad │    │
   │  └─────────────────────┘    │
   └─────────────────────────────┘
   ```

### Paso 2.2 - Agregar Nueva Propiedad

1. **Haz clic en "Agregar propiedad"** (el botón azul)

2. **Se abrirá una ventana con dos opciones:**
   ```
   ┌──────────────────────────┐
   │ ¿Qué tipo de propiedad?  │
   │                          │
   │ [○] Dominio              │
   │     (ejemplo.com)        │
   │                          │
   │ [●] URL ← ELIGE ESTA    │
   │     (https://...)        │
   └──────────────────────────┘
   ```

3. **Selecciona "URL"** (la segunda opción)

### Paso 2.3 - Escribir tu Dominio

1. **En el campo de texto, escribe tu dominio COMPLETO:**

   **Si tienes dominio personalizado:**
   ```
   https://mitienda.com
   ```
   (incluye https://)

   **Si tienes subdominio:**
   ```
   https://mitienda.creadorweb.eme10.com
   ```
   (incluye https://)

2. **Haz clic en "Continuar"**

### Paso 2.4 - Elegir Método de Verificación

Se abrirá una ventana con varias opciones:

```
┌─────────────────────────────────────┐
│ Métodos de verificación             │
│                                     │
│ [○] Etiqueta HTML ← ELIGE ESTA    │
│ [○] Archivo HTML                    │
│ [○] Registro DNS                    │
│ [○] Proveedor de hospedaje          │
│ [○] Google Analytics                │
│ [○] Google Tag Manager              │
└─────────────────────────────────────┘
```

**Selecciona "Etiqueta HTML"** (es la más fácil)

### Paso 2.5 - Copiar el Código

Verás un código así:

```html
<meta name="google-site-verification" content="abcdef123456789XYZabcdef123456" />
```

**⚠️ IMPORTANTE: Copia SOLO el contenido entre comillas:**

```
abcdef123456789XYZabcdef123456
```

**Cómo copiar:**
```
1. Busca el botón "Copiar" (ícono de portapapeles)
2. O selecciona con el mouse y Ctrl+C
3. Guárdalo en un documento de texto por ahora
```

**❌ NO copies esto:**
```
google-site-verification: abcdef...
<meta name="..." ...>
```

**✅ SÍ copia solo esto:**
```
abcdef123456789XYZabcdef123456
```

---

## **PARTE 3: Agregar Código en tu Panel (5 minutos)**

### Paso 3.1 - Volver a tu Panel SEO

1. **Vuelve a tu creador web** (mantén abierta la ventana de Google en otra pestaña)

2. **Abre el formulario SEO:**
   ```
   Sitios → Tu Sitio → SEO → Editar
   ```

### Paso 3.2 - Buscar la Sección de Verificación

**Desplázate hacia abajo** hasta encontrar:

```
┌──────────────────────────────────────┐
│ Verificación en Buscadores           │
│                                      │
│ Esta sección tiene dos campos:       │
│ • Google Site Verification           │
│ • Microsoft Site Verification        │
└──────────────────────────────────────┘
```

### Paso 3.3 - Pegar el Código

1. **Haz clic en el campo "Google Site Verification"**

2. **Pega el código que copiaste:**
   ```
   abcdef123456789XYZabcdef123456
   ```

3. **Verifica que esté completo** (sin espacios extras)

### Paso 3.4 - Guardar Cambios

```
1. Ve al final del formulario
2. Haz clic en "Guardar Configuración" (botón azul)
3. Espera a que se guarde (mostrará confirmación)
```

**✅ Listo! El código está en tu sitio ahora.**

---

## **PARTE 4: Verificar en Google (2 minutos)**

### Paso 4.1 - Volver a Google Search Console

1. **Vuelve a la pestaña de Google Search Console**

2. **Deberías ver esta pantalla:**
   ```
   ┌──────────────────────────────┐
   │ Hemos detectado la etiqueta  │
   │                              │
   │    [Verificar] ← HAZ CLIC   │
   └──────────────────────────────┘
   ```

### Paso 4.2 - Hacer Clic en "Verificar"

```
1. Si no ves el botón, espera 5 segundos y recarga la página
2. Haz clic en "Verificar"
3. Google buscará el código en tu sitio
```

### Paso 4.3 - Esperar Resultado

```
⏳ Espera unos segundos...
```

**Si todo está bien, verás:**
```
┌──────────────────────────────────┐
│ ✅ Propiedad verificada          │
│                                  │
│ La verificación fue exitosa      │
└──────────────────────────────────┘
```

**🎉 ¡FELICIDADES! Tu sitio está verificado**

---

## **PARTE 5: Ver Resultados (Opcional)**

### Paso 5.1 - Acceso a Search Console

Ahora que está verificado, puedes:

```
1. Haz clic en tu propiedad
2. Verás el panel de control
3. Aquí aparecerán datos cuando Google indexe tu sitio
```

### Paso 5.2 - Enviar Sitemap (Importante)

Para que Google indexe más rápido:

```
1. En el menú izquierdo: "Sitemaps"
2. En el campo, escribe:
   https://tudominio.com/websites/{id}/seo/sitemap
3. Haz clic en "Enviar"
```

**Dónde encuentras {id}:**
- Ve a tu panel SEO
- En la URL verás algo como: `/websites/123/seo`
- Ese `123` es tu {id}

**Ejemplo completo:**
```
https://mitienda.com/websites/42/seo/sitemap
```

### Paso 5.3 - Ver Datos (Después de 24-48 horas)

Después de 1-2 días:

```
1. En Search Console
2. Verás en "Performance":
   - Clicks (cuántas veces hicieron clic en tu sitio)
   - Impresiones (cuántas veces apareció en Google)
   - CTR (porcentaje de clicks)
   - Posición promedio
```

---

## **PARTE 6: Resolver Problemas**

### ❌ Problema: "No encontramos la etiqueta"

**Causas posibles:**

1. **El código no se guardó:**
   ```
   ✓ Abre SEO → Editar
   ✓ Verifica que está el código en Google Site Verification
   ✓ Si no está, pégalo de nuevo y guarda
   ```

2. **El sitio no carga:**
   ```
   ✓ Verifica que tu dominio funciona en el navegador
   ✓ Abre https://tudominio.com/
   ✓ Debe cargar sin errores
   ```

3. **Google no ha visitado tu sitio:**
   ```
   ✓ Espera 5-10 minutos
   ✓ Haz clic en "Volver a verificar" (botón)
   ✓ Si sigue sin funcionar, contacta soporte
   ```

### ❌ Problema: "Código copiado incorrectamente"

**Solución:**
```
1. Abre Google Search Console de nuevo
2. Copia el código nuevamente
3. Asegúrate de copiar SOLO los números/letras
4. Sin "google-site-verification:" al inicio
5. Sin "<meta name..." al inicio
6. Pega en tu panel SEO
7. Guarda
8. Intenta verificar nuevamente
```

### ❌ Problema: "Mi dominio no funciona"

**Si es dominio personalizado:**
```
1. Verifica que el dominio está en tu cuenta
2. Que los DNS están configurados correctamente
3. Abre https://tudominio.com en navegador
4. Debe cargar sin errores
5. Si no carga, contacta soporte de hosting
```

**Si es subdominio:**
```
1. Debe funcionar automáticamente
2. Abre https://tusitio.creadorweb.eme10.com
3. Si no carga, contacta soporte
```

---

## **✅ CHECKLIST FINAL**

Antes de dar por completado, verifica:

```
☐ Meta título está completo (50-60 caracteres)
☐ Meta descripción está completa (150-160 caracteres)
☐ Imagen OG agregada (URL válida)
☐ Código de Google pegado en SEO → Verificación
☐ Código guardado en panel SEO
☐ Verificación exitosa en Google Search Console
☐ Sitemap enviado a Search Console
☐ Sitio accesible en https://tudominio.com
```

---

## **⏰ CRONOGRAMA**

```
INMEDIATO (hoy):
  ✓ Completar meta tags
  ✓ Pegar código de verificación
  ✓ Verificar en Google
  ✓ Enviar sitemap

24-48 HORAS:
  ✓ Google comienza a indexar
  ✓ Aparecen datos en Search Console

1-2 SEMANAS:
  ✓ Comienzan a aparecer en búsquedas
  ✓ Ves primeros clicks

1-3 MESES:
  ✓ Ranking mejora según contenido
  ✓ Tráfico orgánico aumenta
```

---

## **💡 CONSEJOS FINALES**

✅ **Haz esto para cada sitio que crees**
✅ **Mantén los meta tags actualizados**
✅ **Agrega contenido de calidad constantemente**
✅ **Verifica datos en Search Console cada semana**
✅ **Responde a comentarios y mensajes rápido**

---

## **🆘 ¿NECESITAS AYUDA?**

Si algo no funciona:

1. **Revisa esta guía nuevamente**
2. **Abre Google Search Console** - tiene mensajes de error específicos
3. **Contacta soporte técnico** del creador web
4. **Verifica en navegador** que tu sitio carga correctamente

---

## **📞 CONTACTO SOPORTE**

Emails o números de contacto según corresponda...

---

**Versión:** 1.0  
**Fecha:** 30 Enero 2026  
**Tiempo estimado:** 30 minutos para todo el proceso  
**Dificultad:** ⭐ Muy Fácil
