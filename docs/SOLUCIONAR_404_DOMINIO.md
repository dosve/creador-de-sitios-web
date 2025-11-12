# 🔧 Solucionar Error 404 en Dominios Vinculados

## ❌ Problema

Al acceder a `id-moda.com/sobre-nosotros` aparece:
```
404 NOT FOUND
```

---

## 🔍 Diagnóstico

Hay **3 posibles causas** para este error:

### **1. El dominio no está verificado en la base de datos** ❌
### **2. La página "sobre-nosotros" no está publicada** ❌  
### **3. La página no existe o tiene otro slug** ❌

---

## ✅ SOLUCIÓN PASO A PASO

### **PASO 1: Verificar el Dominio en la Base de Datos**

Ejecuta este comando para ver los logs:

```bash
tail -f storage/logs/laravel.log
```

Luego accede a: `http://id-moda.com/sobre-nosotros`

**Busca estos mensajes en el log:**

```
=== SHOWPAGEBYDOMAIN DEBUG ===
Host: id-moda.com
Slug de página: sobre-nosotros
Dominio encontrado: SÍ (ID: X) o NO
```

#### **Si dice "Dominio encontrado: NO":**

El dominio no está en la base de datos o no está verificado. Verifica:

1. **Ve a:** Panel de Administración → Dominios
2. **Busca:** `id-moda.com`
3. **Verifica que tenga:**
   - ✅ `is_verified = true`
   - ✅ `status = active`
   - ✅ `website_id` asignado

**Solución rápida por SQL:**
```sql
SELECT * FROM domains WHERE domain = 'id-moda.com';

-- Si no existe, créalo:
INSERT INTO domains (domain, website_id, is_verified, status, created_at, updated_at) 
VALUES ('id-moda.com', [TU_WEBSITE_ID], 1, 'active', NOW(), NOW());
```

---

### **PASO 2: Verificar que la Página Existe y Está Publicada**

En el log verás:

```
📋 Todas las páginas del sitio: {...}
📋 Páginas publicadas: {...}
```

#### **Verifica:**

1. **La página "sobre-nosotros" existe** en la lista
2. **La página está publicada** (aparece en "Páginas publicadas")

#### **Si NO aparece en páginas publicadas:**

1. **Ve a:** Panel de Creador → Páginas
2. **Busca:** La página "Sobre Nosotros"
3. **Verifica el slug:** Debe ser exactamente `sobre-nosotros`
4. **Publica la página:**
   - Click en editar
   - Marca "✅ Publicada"
   - Guardar

---

### **PASO 3: Verificar el Slug de la Página**

Es posible que la página tenga un slug diferente. En el log verás:

```
📋 Todas las páginas del sitio: {
  "Sobre Nosotros": "acerca-de",  ← El slug real
  "Inicio": "inicio",
  ...
}
```

**Si el slug es diferente:**

Opción 1: **Cambiar la URL** a la correcta:
```
http://id-moda.com/acerca-de  ← Usa el slug correcto
```

Opción 2: **Cambiar el slug** de la página:
```
1. Editar la página
2. Cambiar slug a: sobre-nosotros
3. Guardar
```

---

## 🚀 Solución Rápida (Lo Más Común)

### **Problema #1: Página no publicada**

```bash
# Verifica y publica la página
1. Ve a: Creador → Páginas
2. Encuentra "Sobre Nosotros"
3. Editar → ✅ Publicada → Guardar
```

### **Problema #2: Dominio no verificado**

```sql
-- Verifica en base de datos
SELECT * FROM domains WHERE domain = 'id-moda.com';

-- Si is_verified = 0, actualízalo:
UPDATE domains SET is_verified = 1, status = 'active' WHERE domain = 'id-moda.com';
```

### **Problema #3: Slug incorrecto**

```bash
# Ve a: Creador → Páginas → Sobre Nosotros
# Verifica que el slug sea: sobre-nosotros
# Si es diferente, cámbialo
```

---

## 🔍 Checklist de Verificación

Marca cada item cuando lo verifiques:

- [ ] El dominio `id-moda.com` está en la tabla `domains`
- [ ] El dominio tiene `is_verified = 1`
- [ ] El dominio tiene `status = 'active'`
- [ ] El dominio tiene un `website_id` asignado
- [ ] La página "Sobre Nosotros" existe
- [ ] La página tiene slug = `sobre-nosotros`
- [ ] La página está publicada (`is_published = 1`)
- [ ] El sitio tiene una plantilla aplicada

---

## 📊 Consulta SQL de Diagnóstico

Ejecuta esto para ver todo:

```sql
-- Ver dominios
SELECT 
    d.id,
    d.domain,
    d.is_verified,
    d.status,
    d.website_id,
    w.name as website_name,
    w.is_published as website_published
FROM domains d
LEFT JOIN websites w ON d.website_id = w.id
WHERE d.domain = 'id-moda.com';

-- Ver páginas del sitio
SELECT 
    p.id,
    p.title,
    p.slug,
    p.is_published,
    p.is_home
FROM pages p
WHERE p.website_id = [TU_WEBSITE_ID]
ORDER BY p.title;
```

---

## 🎯 Caso Más Probable

**La página no está publicada.**

**Solución:**
1. Ve al panel de creador
2. Páginas → "Sobre Nosotros"
3. Editar
4. Marca "✅ Página publicada"
5. Guardar
6. Recarga `id-moda.com/sobre-nosotros`
7. ✅ Debería funcionar

---

## 📞 Ayuda Adicional

**Ver los logs en tiempo real:**
```bash
tail -f storage/logs/laravel.log
```

**Luego accede a:**
```
http://id-moda.com/sobre-nosotros
```

**Y me compartes** los mensajes que aparecen en el log para ayudarte mejor.

---

**Última actualización:** 5 de Noviembre, 2025  
**Estado:** Debug activado - Listos para solucionar

