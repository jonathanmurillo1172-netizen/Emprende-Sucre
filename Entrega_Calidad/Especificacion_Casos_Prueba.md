# Especificación de Casos de Prueba

## Plantilla: Caso de prueba (11.2)

| ID | Requisito | Precondición | Pasos | Resultado esperado | Resultado real | Estado | Evidencia |
|---|---|---|---|---|---|---|---|
| TC-001 | RF_01/RQ_Login | Usuario registrado y activo | 1) Ir a /login<br>2) Ingresar credenciales válidas<br>3) Click en 'Ingresar' | Redirección al Dashboard correcto según rol | Redirección exitosa | Pass | [Captura] |
| TC-002 | RF_02/RQ_CrearProducto | Usuario Emprendedor logueado | 1) Ir a Mis Productos<br>2) Click 'Nuevo'<br>3) Llenar formulario<br>4) Guardar | Producto creado y visible en lista | Producto aparece en lista | Pass | [Captura] |
| TC-003 | RF_03/RQ_Busqueda | Usuario en Home | 1) Ingresar texto en buscador<br>2) Esperar resultados | Listado filtrado asíncronamente | Filtro correcto | Pass | [Captura] |
