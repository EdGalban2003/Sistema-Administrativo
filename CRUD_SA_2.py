import mysql.connector

try:
    # Intentar conectar a la base de datos
    conexion = mysql.connector.connect(
        host="localhost",
        user="Admin",
        password="xztj-ARgQGavgh@K",
        database="sistema_administrativo"
    )

    # Si la conexión es exitosa, muestra un mensaje de éxito
    print("Conexión exitosa a la base de datos")
    
    # Luego puedes realizar operaciones en la base de datos usando 'cursor', si es necesario.
    cursor = conexion.cursor()
    # Realiza tus operaciones con la base de datos aquí

except mysql.connector.Error as e:
    # En caso de error, muestra un mensaje de error
    print(f"Error al conectar a la base de datos: {e}")
    


#######################################
#CURD PARA LA TABLA CLIENTES
#######################################


# Función para verificar si un cliente existe por su cédula
def cliente_existe_por_cedula(cedula):
    try:
        query = "SELECT COUNT(*) FROM Cliente WHERE Cedula_Cliente = %s"
        cursor.execute(query, (cedula,))
        resultado = cursor.fetchone()
        return resultado[0] > 0
    except mysql.connector.Error as e:
        print(f"Error al verificar la existencia del cliente: {e}")
        return False
    

    
# Función para crear un cliente
def crear_cliente(id_cliente, cedula, nombre, apellido, telefono, correo, direccion):
    try:
        query = "INSERT INTO Cliente (ID_Cliente, Cedula_Cliente, Nombre_Cliente, Apellido_Cliente, Telefono_Cliente, Correo_Cliente, Direccion_Cliente) VALUES (%s, %s, %s, %s, %s, %s, %s)"
        valores = (id_cliente, cedula, nombre, apellido, telefono, correo, direccion)
        cursor.execute(query, valores)
        conexion.commit()
        print("Cliente creado con éxito.")
    except mysql.connector.Error as e:
        print(f"Error al crear el cliente: {e}")

# # Solicitar datos al usuario desde el terminal
# id_cliente = input("ID del cliente: ")
# cedula = input("Cédula del cliente: ")
# nombre = input("Nombre del cliente: ")
# apellido = input("Apellido del cliente: ")
# telefono = input("Teléfono del cliente: ")
# correo = input("Correo del cliente: ")
# direccion = input("Dirección del cliente: ")

# # Llamar a la función para crear un cliente
# crear_cliente(id_cliente, cedula, nombre, apellido, telefono, correo, direccion)




# Función para modificar los datos de un cliente por su cédula
def modificar_cliente_por_cedula(cedula, nuevo_nombre, nuevo_apellido, nuevo_telefono, nuevo_correo, nueva_direccion):
    if cliente_existe_por_cedula(cedula):
        try:
            query = "UPDATE Cliente SET Nombre_Cliente = %s, Apellido_Cliente = %s, Telefono_Cliente = %s, Correo_Cliente = %s, Direccion_Cliente = %s WHERE Cedula_Cliente = %s"
            valores = (nuevo_nombre, nuevo_apellido, nuevo_telefono, nuevo_correo, nueva_direccion, cedula)
            cursor.execute(query, valores)
            conexion.commit()
            print("Datos del cliente actualizados con éxito.")
        except mysql.connector.Error as e:
            print(f"Error al actualizar los datos del cliente: {e}")
    else:
        print(f"No existe un cliente con cédula {cedula} en la base de datos.")

# # Solicitar cédula del cliente al usuario desde la terminal
# cedula = input("Introduce la cédula del cliente cuyos datos deseas modificar: ")

# # Llamar a la función para modificar los datos del cliente por cédula
# if cliente_existe_por_cedula(cedula):
#     nuevo_nombre = input("Nuevo nombre del cliente: ")
#     nuevo_apellido = input("Nuevo apellido del cliente: ")
#     nuevo_telefono = input("Nuevo teléfono del cliente: ")
#     nuevo_correo = input("Nuevo correo del cliente: ")
#     nueva_direccion = input("Nueva dirección del cliente: ")
#     modificar_cliente_por_cedula(cedula, nuevo_nombre, nuevo_apellido, nuevo_telefono, nuevo_correo, nueva_direccion)
# else:
#     print(f"No se encontró un cliente con cédula {cedula}.")





# Función para consultar clientes por cédula
def consultar_cliente_por_cedula(cedula):
    try:
        query = "SELECT * FROM Cliente WHERE Cedula_Cliente = %s"
        cursor.execute(query, (cedula,))
        resultado = cursor.fetchall()
        return resultado
    except mysql.connector.Error as e:
        print(f"Error al consultar cliente por cédula: {e}")
        return None

# # Solicitar cédula al usuario desde la terminal
# cedula = input("Introduce la cédula del cliente a consultar: ")

# # Llamar a la función para consultar el cliente por cédula
# resultado = consultar_cliente_por_cedula(cedula)

# if resultado:
#     print("Cliente encontrado:")
#     for row in resultado:
#         print(f"ID: {row[0]}")
#         print(f"Cédula: {row[1]}")
#         print(f"Nombre: {row[2]}")
#         print(f"Apellido: {row[3]}")
#         print(f"Teléfono: {row[4]}")
#         print(f"Correo: {row[5]}")
#         print(f"Dirección: {row[6]}")
# else:
#     print("Cliente no encontrado.")




# Función para consultar clientes por nombre
def consultar_cliente_por_nombre(nombre):
    try:
        query = "SELECT * FROM Cliente WHERE Nombre_Cliente LIKE %s"
        cursor.execute(query, (f"%{nombre}%",))
        resultado = cursor.fetchall()
        return resultado
    except mysql.connector.Error as e:
        print(f"Error al consultar cliente por nombre: {e}")
        return None

# # Solicitar nombre al usuario desde la terminal
# nombre = input("Introduce el nombre del cliente a consultar: ")

# # Llamar a la función para consultar el cliente por nombre
# resultado = consultar_cliente_por_nombre(nombre)

# if resultado:
#     print("Clientes encontrados:")
#     for row in resultado:
#         print(f"ID: {row[0]}")
#         print(f"Cédula: {row[1]}")
#         print(f"Nombre: {row[2]}")
#         print(f"Apellido: {row[3]}")
#         print(f"Teléfono: {row[4]}")
#         print(f"Correo: {row[5]}")
#         print(f"Dirección: {row[6]}")
# else:
#     print("No se encontraron clientes con ese nombre.")




# Función para eliminar un cliente por su cédula
def eliminar_cliente_por_cedula(cedula):
    if cliente_existe_por_cedula(cedula):
        try:
            query = "DELETE FROM Cliente WHERE Cedula_Cliente = %s"
            cursor.execute(query, (cedula,))
            conexion.commit()
            print(f"Cliente con cédula {cedula} eliminado con éxito.")
        except mysql.connector.Error as e:
            print(f"Error al eliminar el cliente: {e}")
    else:
        print(f"No existe un cliente con cédula {cedula} en la base de datos.")

# # Solicitar cédula del cliente al usuario desde la terminal
# cedula = input("Introduce la cédula del cliente que deseas eliminar: ")

# # Llamar a la función para eliminar el cliente por cédula
# eliminar_cliente_por_cedula(cedula)




#######################################
#CURD PARA LA TABLA PROVEEDORES
#######################################
#
# Función para crear un proveedor
def crear_proveedor(nombre_comercial, nombre, apellido, tipo_documento, numero_documento, telefono, correo, direccion):
    query = "INSERT INTO Proveedor (Nombre_Comercial_Proveedor, Nombre_Proveedor, Apellido_Proveedor, Tipo_Documento, Numero_Documento, Telefono_Proveedor, Correo_Proveedor, Direccion_Proveedor) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)"
    valores = (nombre_comercial, nombre, apellido, tipo_documento, numero_documento, telefono, correo, direccion)
    cursor.execute(query, valores)
    conexion.commit()
    print("Proveedor creado con éxito.")

# Función para consultar proveedores por nombre comercial
def consultar_proveedor_por_nombre_comercial(nombre_comercial):
    query = "SELECT * FROM Proveedor WHERE Nombre_Comercial_Proveedor LIKE %s"
    cursor.execute(query, (f"%{nombre_comercial}%",))
    resultado = cursor.fetchall()
    return resultado

# Función para consultar proveedores por número de documento
def consultar_proveedor_por_numero_documento(numero_documento):
    query = "SELECT * FROM Proveedor WHERE Numero_Documento = %s"
    cursor.execute(query, (numero_documento,))
    resultado = cursor.fetchall()
    return resultado

# Función para actualizar un proveedor por su ID
def actualizar_proveedor(id_proveedor, nombre_comercial, nombre, apellido, tipo_documento, numero_documento, telefono, correo, direccion):
    query = "UPDATE Proveedor SET Nombre_Comercial_Proveedor = %s, Nombre_Proveedor = %s, Apellido_Proveedor = %s, Tipo_Documento = %s, Numero_Documento = %s, Telefono_Proveedor = %s, Correo_Proveedor = %s, Direccion_Proveedor = %s WHERE ID_Proveedor = %s"
    valores = (nombre_comercial, nombre, apellido, tipo_documento, numero_documento, telefono, correo, direccion, id_proveedor)
    cursor.execute(query, valores)
    conexion.commit()
    print("Proveedor actualizado con éxito.")

# Función para eliminar un proveedor por su ID
def eliminar_proveedor(id_proveedor):
    query = "DELETE FROM Proveedor WHERE ID_Proveedor = %s"
    cursor.execute(query, (id_proveedor,))
    conexion.commit()
    print("Proveedor eliminado con éxito.")


#######################################
#CURD PARA LA TABLA PRODUCTOS
#######################################
#
# Función para crear un producto
def crear_producto(nombre, codigo, detalle, cantidad, precio_venta, precio_costo, fecha_ingreso, descuento, promocion):
    query = "INSERT INTO Productos (Nombre_Producto, Codigo_Producto, Detalle_Producto, Cantidad_Producto, Precio_Venta, Precio_Costo, Fecha_Ingreso, Descuento, Promocion) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)"
    valores = (nombre, codigo, detalle, cantidad, precio_venta, precio_costo, fecha_ingreso, descuento, promocion)
    cursor.execute(query, valores)
    conexion.commit()
    print("Producto creado con éxito.")

# Función para consultar productos por nombre
def consultar_producto_por_nombre(nombre):
    query = "SELECT * FROM Productos WHERE Nombre_Producto LIKE %s"
    cursor.execute(query, (f"%{nombre}%",))
    resultado = cursor.fetchall()
    return resultado

# Función para consultar productos por código
def consultar_producto_por_codigo(codigo):
    query = "SELECT * FROM Productos WHERE Codigo_Producto = %s"
    cursor.execute(query, (codigo,))
    resultado = cursor.fetchall()
    return resultado

# Función para actualizar un producto por su ID
def actualizar_producto(id_producto, nombre, codigo, detalle, cantidad, precio_venta, precio_costo, fecha_ingreso, descuento, promocion):
    query = "UPDATE Productos SET Nombre_Producto = %s, Codigo_Producto = %s, Detalle_Producto = %s, Cantidad_Producto = %s, Precio_Venta = %s, Precio_Costo = %s, Fecha_Ingreso = %s, Descuento = %s, Promocion = %s WHERE ID_Producto = %s"
    valores = (nombre, codigo, detalle, cantidad, precio_venta, precio_costo, fecha_ingreso, descuento, promocion, id_producto)
    cursor.execute(query, valores)
    conexion.commit()
    print("Producto actualizado con éxito.")

# Función para eliminar un producto por su ID
def eliminar_producto(id_producto):
    query = "DELETE FROM Productos WHERE ID_Producto = %s"
    cursor.execute(query, (id_producto,))
    conexion.commit()
    print("Producto eliminado con éxito.")
#######################################


#######################################
#CURD PARA LA TABLA INFORMACION_NEGOCIO
#######################################
#
# Función para crear información de negocio
def crear_informacion_negocio(nombre_comercial, tipo_documento, numero_documento, telefono, correo, direccion, fecha_registro, hora_registro, actividad_comercial):
    query = "INSERT INTO Informacion_Negocio (Nombre_Comercial_Negocio, Tipo_Documento, Numero_Documento, Telefono_Negocio, Correo_Negocio, Direccion_Negocio, Fecha_Registro, Hora_Registro, Actividad_Comercial) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)"
    valores = (nombre_comercial, tipo_documento, numero_documento, telefono, correo, direccion, fecha_registro, hora_registro, actividad_comercial)
    cursor.execute(query, valores)
    conexion.commit()
    print("Información de negocio creada con éxito.")
    
# Función para actualizar información de negocio por su ID de proveedor
def actualizar_informacion_negocio(id_proveedor, nombre_comercial, tipo_documento, numero_documento, telefono, correo, direccion, fecha_registro, hora_registro, actividad_comercial):
    query = "UPDATE Informacion_Negocio SET Nombre_Comercial_Negocio = %s, Tipo_Documento = %s, Numero_Documento = %s, Telefono_Negocio = %s, Correo_Negocio = %s, Direccion_Negocio = %s, Fecha_Registro = %s, Hora_Registro = %s, Actividad_Comercial = %s WHERE ID_Proveedor = %s"
    valores = (nombre_comercial, tipo_documento, numero_documento, telefono, correo, direccion, fecha_registro, hora_registro, actividad_comercial, id_proveedor)
    cursor.execute(query, valores)
    conexion.commit()
    print("Información de negocio actualizada con éxito.")
    
# Función para eliminar información de negocio por su ID de proveedor
def eliminar_informacion_negocio(id_proveedor):
    query = "DELETE FROM Informacion_Negocio WHERE ID_Proveedor = %s"
    cursor.execute(query, (id_proveedor,))
    conexion.commit()
    print("Información de negocio eliminada con éxito.")
#######################################


#######################################
#CURD PARA LA TABLA CATEGORIAS
#######################################
#
# Función para crear una categoría
def crear_categoria(nombre, detalle):
    query = "INSERT INTO Categorias (Nombre_Categoria, Detalle_Categoria) VALUES (%s, %s)"
    valores = (nombre, detalle)
    cursor.execute(query, valores)
    conexion.commit()
    print("Categoría creada con éxito.")

# Función para consultar categorías por nombre
def consultar_categoria_por_nombre(nombre):
    query = "SELECT * FROM Categorias WHERE Nombre_Categoria LIKE %s"
    cursor.execute(query, (f"%{nombre}%",))
    resultado = cursor.fetchall()
    return resultado

# Función para consultar categorías por ID
def consultar_categoria_por_id(id_categoria):
    query = "SELECT * FROM Categorias WHERE ID_Categorias = %s"
    cursor.execute(query, (id_categoria,))
    resultado = cursor.fetchall()
    return resultado

# Función para actualizar una categoría por su ID
def actualizar_categoria(id_categoria, nombre, detalle):
    query = "UPDATE Categorias SET Nombre_Categoria = %s, Detalle_Categoria = %s WHERE ID_Categorias = %s"
    valores = (nombre, detalle, id_categoria)
    cursor.execute(query, valores)
    conexion.commit()
    print("Categoría actualizada con éxito.")

# Función para eliminar una categoría por su ID
def eliminar_categoria(id_categoria):
    query = "DELETE FROM Categorias WHERE ID_Categorias = %s"
    cursor.execute(query, (id_categoria,))
    conexion.commit()
    print("Categoría eliminada con éxito.")
#######################################


#######################################
#CURD PARA LA TABLA REEMBOLSOS
#######################################
#
# Función para crear un reembolso
def crear_reembolso(fecha_reembolso, hora_reembolso, monto_reembolso, motivo_reembolso, detalles_adicionales):
    query = "INSERT INTO Reembolsos (Fecha_Reembolso, Hora_Reembolso, Monto_Reembolso, Motivo_Reembolso, Detalles_Adicionales) VALUES (%s, %s, %s, %s, %s)"
    valores = (fecha_reembolso, hora_reembolso, monto_reembolso, motivo_reembolso, detalles_adicionales)
    cursor.execute(query, valores)
    conexion.commit()
    print("Reembolso creado con éxito.")

# Función para consultar reembolsos por fecha de reembolso
def consultar_reembolso_por_fecha(fecha_reembolso):
    query = "SELECT * FROM Reembolsos WHERE Fecha_Reembolso = %s"
    cursor.execute(query, (fecha_reembolso,))
    resultado = cursor.fetchall()
    return resultado

# Función para consultar reembolsos por ID
def consultar_reembolso_por_id(id_reembolso):
    query = "SELECT * FROM Reembolsos WHERE ID_Reembolsos = %s"
    cursor.execute(query, (id_reembolso,))
    resultado = cursor.fetchall()
    return resultado

# Función para actualizar un reembolso por su ID
def actualizar_reembolso(id_reembolso, fecha_reembolso, hora_reembolso, monto_reembolso, motivo_reembolso, detalles_adicionales):
    query = "UPDATE Reembolsos SET Fecha_Reembolso = %s, Hora_Reembolso = %s, Monto_Reembolso = %s, Motivo_Reembolso = %s, Detalles_Adicionales = %s WHERE ID_Reembolsos = %s"
    valores = (fecha_reembolso, hora_reembolso, monto_reembolso, motivo_reembolso, detalles_adicionales, id_reembolso)
    cursor.execute(query, valores)
    conexion.commit()
    print("Reembolso actualizado con éxito.")

# Función para eliminar un reembolso por su ID
def eliminar_reembolso(id_reembolso):
    query = "DELETE FROM Reembolsos WHERE ID_Reembolsos = %s"
    cursor.execute(query, (id_reembolso,))
    conexion.commit()
    print("Reembolso eliminado con éxito.")
#######################################


#######################################
#CURD PARA LA TABLA DEVOLUCIONES
#######################################
#
# Función para crear una devolución
def crear_devolucion(fecha_devolucion, hora_devolucion, cantidad_devolucion, motivo_devolucion, detalles_adicionales):
    query = "INSERT INTO Devoluciones (Fecha_Devolucion, Hora_Devolucion, Cantidad_Devolucion, Motivo_Devolucion, Detalles_Adicionales) VALUES (%s, %s, %s, %s, %s)"
    valores = (fecha_devolucion, hora_devolucion, cantidad_devolucion, motivo_devolucion, detalles_adicionales)
    cursor.execute(query, valores)
    conexion.commit()
    print("Devolución creada con éxito.")

# Función para consultar devoluciones por fecha de devolución
def consultar_devolucion_por_fecha(fecha_devolucion):
    query = "SELECT * FROM Devoluciones WHERE Fecha_Devolucion = %s"
    cursor.execute(query, (fecha_devolucion,))
    resultado = cursor.fetchall()
    return resultado

# Función para consultar devoluciones por ID
def consultar_devolucion_por_id(id_devolucion):
    query = "SELECT * FROM Devoluciones WHERE ID_Devolucion = %s"
    cursor.execute(query, (id_devolucion,))
    resultado = cursor.fetchall()
    return resultado

# Función para actualizar una devolución por su ID
def actualizar_devolucion(id_devolucion, fecha_devolucion, hora_devolucion, cantidad_devolucion, motivo_devolucion, detalles_adicionales):
    query = "UPDATE Devoluciones SET Fecha_Devolucion = %s, Hora_Devolucion = %s, Cantidad_Devolucion = %s, Motivo_Devolucion = %s, Detalles_Adicionales = %s WHERE ID_Devolucion = %s"
    valores = (fecha_devolucion, hora_devolucion, cantidad_devolucion, motivo_devolucion, detalles_adicionales, id_devolucion)
    cursor.execute(query, valores)
    conexion.commit()
    print("Devolución actualizada con éxito.")

# Función para eliminar una devolución por su ID
def eliminar_devolucion(id_devolucion):
    query = "DELETE FROM Devoluciones WHERE ID_Devolucion = %s"
    cursor.execute(query, (id_devolucion,))
    conexion.commit()
    print("Devolución eliminada con éxito.")
#######################################


# Cerrar la conexión
conexion.close()


