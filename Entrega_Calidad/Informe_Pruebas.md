# Informe de Pruebas

## Plantilla: Informe de performance (11.4)

- **Objetivo de la prueba**: Verificar tiempos de respuesta del Home Page bajo carga para asegurar UX fluida.
- **Escenario de carga**: 50 usuarios concurrentes, ramp-up 10s, duración 1m.
- **Ambiente**: Local (Laragon, PHP 8.2, NVMe SSD).
- **Métricas**:
  - p95: 350ms
  - Throughput: 120 req/sec
  - Errores: 0%
- **Resultados y cuellos de botella**: La carga de imágenes sin lazy-loading afectaba el FCP (First Contentful Paint).
- **Optimización aplicada y comparación antes/después**:
  - Antes: p95 800ms
  - Después (con Lazy Loading): p95 350ms

## Resumen Ejecutivo de Pruebas Funcionales
Todas las pruebas críticas (Login, CRUD Productos) pasaron exitosamente.
