# Plan de Calidad (ISO/IEC 25010)

## 1. Introducción
Este documento define los requisitos de calidad y las métricas para el proyecto, siguiendo el modelo ISO/IEC 25010.

## 2. Requisitos de Calidad (Plantilla 11.1)

| Campo | Contenido |
|---|---|
| **Característica (ISO 25010)** | **Seguridad** |
| Subcaracterística | Confidencialidad |
| Métrica | # vulnerabilidades críticas detectadas por SAST |
| Meta | 0 vulnerabilidades críticas en release |
| Método de medición | Escaneo estático con Larastan y revisión manual de dependencias |

| Campo | Contenido |
|---|---|
| **Característica (ISO 25010)** | **Adecuación Funcional** |
| Subcaracterística | Completitud funcional |
| Métrica | Cobertura de pruebas automatizadas |
| Meta | >= 70% de cobertura de código |
| Método de medición | PHPUnit Code Coverage Report |

| Campo | Contenido |
|---|---|
| **Característica (ISO 25010)** | **Mantenibilidad** |
| Subcaracterística | Modificabilidad |
| Métrica | Complejidad Ciclomática |
| Meta | <= 10 por método |
| Método de medición | Larastan / PHPStan con nivel de regla estricto |

| Campo | Contenido |
|---|---|
| **Característica (ISO 25010)** | **Eficiencia de desempeño** |
| Subcaracterística | Comportamiento temporal |
| Métrica | Tiempo de respuesta del endpoint principal (Home) |
| Meta | < 500ms (p95) |
| Método de medición | Pruebas de carga (Apache Benchmark / JMeter) |

| Campo | Contenido |
|---|---|
| **Característica (ISO 25010)** | **Usabilidad** |
| Subcaracterística | Estética de la interfaz de usuario |
| Métrica | Cumplimiento de paleta de colores y diseño responsivo |
| Meta | 100% vistas responsivas en móvil/desktop |
| Método de medición | Inspección visual y herramientas de desarrollo de navegador |

| Campo | Contenido |
|---|---|
| **Característica (ISO 25010)** | **Fiabilidad** |
| Subcaracterística | Disponibilidad |
| Métrica | Tasa de éxito en peticiones HTTP (200 OK) |
| Meta | 99.9% uptime durante pruebas |
| Método de medición | Monitoreo de logs de servidor |

| Campo | Contenido |
|---|---|
| **Característica (ISO 25010)** | **Compatibilidad** |
| Subcaracterística | Coexistencia |
| Métrica | Compatibilidad con navegadores (Chrome, Firefox, Edge) |
| Meta | Funcionalidad completa en las 3 últimas versiones |
| Método de medición | Pruebas manuales cruzadas |

## 3. Evidencia
| Evidencia | Link a reporte, captura, archivo |
|---|---|
| Reporte de Cobertura | `Entrega_Calidad/Informe_Pruebas.md` |
| Reporte SAST | `Entrega_Calidad/Reporte_Seguridad.md` |
