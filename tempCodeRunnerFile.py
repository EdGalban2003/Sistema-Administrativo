# Función para crear un producto
def crear_producto(nombre, codigo, detalle, cantidad, precio_venta, precio_costo, fecha_ingreso,):
    try:
        query = "INSERT INTO Productos (Nombre_Producto, Codigo_Producto, Detalle_Producto, Cantidad_Producto, Precio_Venta, Precio_Costo, Fecha_Ingreso) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)"
        valores = (nombre, codigo, detalle, cantidad, precio_venta, precio_costo, fecha_ingreso)
        cursor.execute(query, valores)
        conexion.commit()
        print("Producto creado con éxito.")
    except mysql.connector.Error as e:
        print(f"Error al crear el producto: {e}")

# Solicitar datos al usuario desde el terminal para crear un producto
nombre = input("Nombre del producto: ")
codigo = input("Código del producto: ")
detalle = input("Detalle del producto: ")
cantidad = input("Cantidad del producto: ")
precio_venta = input("Precio de venta del producto: ")
precio_costo = input("Precio de costo del producto: ")
fecha_ingreso = input("Fecha de ingreso del producto: ")


# Llamar a la función para crear un producto
crear_producto(nombre, codigo, detalle, cantidad, precio_venta, precio_costo, fecha_ingreso)