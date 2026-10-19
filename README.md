# Thunder

Sistema de punto de venta (POS), comandas e inventario para restaurantes y negocios gastronómicos.

Desarrollado por Evilnapsis.

---

## Módulos

1. **Punto de Venta (`/pos`)**:
   - Buscador de platillos y filtro por categorías.
   - Cuadrícula de productos con imagen y precio.
   - Carrito de venta en tiempo real.
   - Asignación de mesa, mesero y cantidad de comensales para procesar la orden.

2. **Dashboard (`/` o `/home`)**:
   - Métricas de ventas del día, ocupación de mesas, compras del mes y productos activos.
   - Gráfica de ventas recientes.
   - Disponibilidad de mesas en piso.
   - Listado de ventas y compras recientes.

3. **Monitor de Mesas (`/monitor`)**:
   - Mapa de mesas con indicación de libres y ocupadas.
   - Apertura rápida de mesa con comanda y número de comensales.

4. **Comandas y Cuentas (`/orders`)**:
   - Listado de comandas activas e históricas.
   - Detalle de comanda (`/orders/detail/{id}`) para cobro y liberación de mesa.

5. **Inventario e Ingredientes**:
   - **Ingredientes (`/ingredients`)**: Catálogo de insumos con costos y unidades.
   - **Inventario (`/inventory`)**: Existencias actuales de insumos en almacén.
   - **Historial (`/inventory/history/{id}`)**: Entradas y salidas por ingrediente.
   - **Abastecimiento (`/supply`)**: Registro de compras y entradas a almacén.
   - **Compras (`/purchases`)**: Historial de compras registradas.

6. **Platillos (`/products`)**:
   - Catálogo de platillos, bebidas y postres con precio, categoría y área de preparación.
   - Categorías (`/products/categories`).

7. **Mesas (`/tables`)**:
   - Registro y edición de mesas del restaurante.

8. **Reportes (`/reports`)**:
   - Consulta de ventas por rango de fechas y exportación a formato CSV.

9. **Usuarios (`/users`)**:
   - Administración de usuarios (administradores, meseros y cajeros).

---

## Estructura de la Base de Datos

- `user`: Usuarios del sistema (administradores, meseros, cajeros).
- `item`: Mesas del restaurante con su capacidad.
- `category`: Categorías del menú.
- `product`: Platillos y bebidas del catálogo.
- `ingredient`: Insumos e ingredientes en almacén.
- `product_ingredient`: Insumos asignados a cada platillo.
- `sell`: Comandas y cuentas generadas por mesa.
- `operation`: Detalle de platillos vendidos en cada cuenta.
- `sell2`: Registros de compras o movimientos de almacén.
- `operation2`: Detalle de entradas o salidas de ingredientes.

---

## Requisitos e Instalación

- Servidor web Apache con `mod_rewrite` habilitado.
- PHP 8.0 o superior con extensiones `pdo`, `pdo_mysql`, `mbstring`.
- Base de datos MySQL / MariaDB (nombre de base de datos: `thunder`).

Para crear la estructura de la base de datos:
```bash
mysql -u root -p thunder < schema.sql
```

Credenciales por defecto:
- Usuario: `admin`
- Contraseña: `admin`