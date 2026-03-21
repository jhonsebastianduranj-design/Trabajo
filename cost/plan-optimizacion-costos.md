# Plan de Optimización de Costos Cloud

## 1. Estrategia de cómputo
- Usar **instancias reservadas** para la carga mínima (nodos base de Kubernetes y BD).
- Aplicar **instancias spot/preemptibles** para cargas batch o entornos de prueba.
- Definir políticas de **autoscaling** para crecer solo ante demanda.

## 2. Estrategia de almacenamiento
- Datos críticos en almacenamiento de alto desempeño solo cuando sea necesario.
- Aplicar **lifecycle policies**: 
  - 0-30 días: clase estándar.
  - 31-90 días: clase infrequent access.
  - +90 días: clase archivo/fría.

## 3. Gobierno y monitoreo financiero
- Etiquetado obligatorio (`entorno`, `aplicacion`, `centro_costo`, `owner`).
- Tableros FinOps con costo diario y tendencia mensual.
- Alertas de presupuesto al 70%, 90% y 100%.

## 4. KPIs de control
- Costo por transacción.
- Utilización media de CPU/RAM por nodo.
- Porcentaje de recursos ociosos.
- Costo mensual por ambiente (dev/qa/prod).

## 5. Meta de ahorro estimada
- 20% a 35% en 6 meses, dependiendo del grado de automatización de apagado y rightsizing.
