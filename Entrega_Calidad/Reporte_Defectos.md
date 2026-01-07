# Registro de Defectos

## Plantilla: Registro de defectos (11.3)

| ID | Módulo | Severidad | Prioridad | Pasos para reproducir | Esperado/Real | Estado | Evidencia |
|---|---|---|---|---|---|---|---|
| BUG-001 | Autenticación | Crítica | P1 | 1) Login con clave errónea<br>2) Observar mensaje | Esperado: 'Error credenciales'<br>Real: Error 500 (Simulado) | Cerrado | [Log] |
| BUG-002 | Productos | Media | P2 | 1) Subir imagen > 2MB | Esperado: Validación bloquea<br>Real: Sube y rompe layout | Abierto | [Link] |
