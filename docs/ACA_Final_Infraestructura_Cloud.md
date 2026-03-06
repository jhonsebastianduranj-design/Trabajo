# Actividad de Construcción Académica (ACA) Final
## Diseño e Implementación de una Infraestructura Cloud Resiliente

## 1) Resumen ejecutivo
Se propone una **arquitectura híbrida** con componentes en nube pública (servicios elásticos, balanceo, Kubernetes gestionado y backup externo) y privada (datos sensibles, IAM corporativo y colaboración soberana con Nextcloud). El diseño prioriza: 
- Alta disponibilidad multi-zona.
- Seguridad por capas (IAM, red, cifrado y auditoría).
- Optimización de costos (reservas, autoscaling y almacenamiento por ciclo de vida).

---

## 2) Fase A — Diseño de Arquitectura

### 2.1 Diagrama de arquitectura de red, almacenamiento y virtualización
```mermaid
flowchart TB
    U[Usuarios/Clientes] --> CDN[CDN + WAF]
    CDN --> LB[Load Balancer L7]

    subgraph PublicCloud[Cloud Pública (VPC 10.10.0.0/16)]
      subgraph AZ1[AZ-1]
        K8S1[Kubernetes Nodes]
        APP1[Pods App]
      end
      subgraph AZ2[AZ-2]
        K8S2[Kubernetes Nodes]
        APP2[Pods App]
      end
      LB --> APP1
      LB --> APP2
      APP1 --> REDIS[(Redis Cache)]
      APP2 --> REDIS
      APP1 --> DBP[(PostgreSQL Administrado - Primario)]
      APP2 --> DBP
      DBR[(Read Replica)]
      DBP --> DBR
      BK[(Object Storage Backups)]
      DBP --> BK
      APP1 --> BK
      APP2 --> BK
    end

    subgraph OnPrem[Cloud Privada / On-Prem]
      NX[Nextcloud + Collabora]
      IDP[IdP/IAM Corporativo]
      NAS[(Almacenamiento NAS cifrado)]
      NX --> NAS
      IDP --> NX
    end

    PublicCloud <--> VPN[VPN/IPSec + BGP]
    VPN <--> OnPrem
    IDP --> APP1
    IDP --> APP2
```

### 2.2 Justificación del modelo de despliegue
**Modelo elegido: Híbrido** (pública + privada).

**Razones técnicas y de negocio:**
1. **Soberanía de datos:** Nextcloud e identidad corporativa se alojan en privado para control regulatorio.
2. **Elasticidad:** workloads web/API escalan en Kubernetes en nube pública bajo demanda.
3. **Resiliencia:** componentes críticos distribuidos en múltiples zonas de disponibilidad.
4. **Costo-beneficio:** se usa pública para picos de consumo y privada para cargas estables/estratégicas.
5. **Evolución gradual:** permite migración por fases sin interrumpir operación legacy.

### 2.3 Estrategia de almacenamiento y DR

#### Clasificación de datos
- **Caliente:** transaccional app (PostgreSQL + Redis).
- **Tibio:** archivos colaborativos de Nextcloud de acceso frecuente.
- **Frío:** respaldos históricos y logs de auditoría.

#### Estrategia de almacenamiento
- **Bloque SSD:** bases de datos y nodos críticos.
- **Objeto S3-compatible:** backups, snapshots y evidencias.
- **NAS privado cifrado:** repositorio colaborativo interno.

#### Parámetros DR propuestos
- **RTO (Recovery Time Objective):** 2 horas para servicio web/API; 4 horas para colaboración documental.
- **RPO (Recovery Point Objective):** 15 minutos para BD (WAL + réplica); 1 hora para archivos Nextcloud.

#### Plan de recuperación
1. Detección automática por monitoreo y alertas.
2. Failover a réplica de BD.
3. Restauración de servicios de app en clúster alterno.
4. Recuperación de archivos desde snapshots incrementales.
5. Verificación de integridad y apertura controlada del tráfico.

---

## 3) Fase B — Simulación técnica de laboratorio

### 3.1 Contenedores y Kubernetes
Se incluye un despliegue de referencia con:
- Deployment con 3 réplicas.
- Health checks (liveness/readiness).
- HPA para escalado automático por CPU.
- PodDisruptionBudget para resiliencia ante mantenimiento.
- Service tipo ClusterIP + Ingress.

Archivos: `k8s/app-deployment.yaml`, `k8s/app-service-hpa.yaml`.

### 3.2 Plataforma de colaboración propia (Nextcloud)
Se incluye `docker-compose` para simular:
- Nextcloud + MariaDB + Redis.
- Volúmenes persistentes.
- Segmentación de red interna.

Archivo: `nextcloud/docker-compose.yml`.

### 3.3 Bases de datos y balanceo
Se incluye simulación con:
- PostgreSQL en StatefulSet.
- Servicio interno para base de datos.
- NGINX como balanceador de carga externo para tráfico HTTP.

Archivos: `db-lb/postgres-statefulset.yaml`, `db-lb/nginx-lb.yaml`.

---

## 4) Fase C — Administración y Seguridad

### 4.1 IAM y políticas de acceso
Se aplican principios:
- **Least privilege** por rol.
- **MFA obligatorio** para operadores.
- **Separación de funciones** (Dev, Ops, Security, Auditor).

Se adjunta política ejemplo en `security/iam-policy-example.json`.

### 4.2 Cifrado y controles
- Cifrado en tránsito TLS 1.2+.
- Cifrado en reposo AES-256 en volúmenes y objetos.
- Gestión de secretos mediante Secret Manager/KMS.
- Auditoría centralizada (logs inmutables + retención 365 días).

### 4.3 Plan de optimización de costos
- Reservar capacidad base (instancias reservadas / savings plans).
- Spot/preemptible para jobs no críticos.
- Autoscaling horizontal y vertical.
- Política de apagado en ambientes no productivos.
- Storage lifecycle (caliente → tibio → frío).

Detalle en `cost/plan-optimizacion-costos.md`.

---

## 5) Criterios de evaluación cubiertos
- ✅ Selección argumentada de modelos de servicio y despliegue.
- ✅ Diseño de arquitectura con red, cómputo y almacenamiento.
- ✅ Simulación de contenedores, Kubernetes, Nextcloud, BD y balanceo.
- ✅ Definición de controles IAM y cifrado.
- ✅ Parámetros DR (RTO/RPO) y optimización de costos.

