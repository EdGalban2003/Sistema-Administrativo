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
def crear_cliente(cedula, nombre, apellido, telefono, correo, direccion):
    try:
        query = "INSERT INTO Cliente (Cedula_Cliente, Nombre_Cliente, Apellido_Cliente, Telefono_Cliente, Correo_Cliente, Direccion_Cliente) VALUES (%s, %s, %s, %s, %s, %s)"
        valores = (cedula, nombre, apellido, telefono, correo, direccion)
        cursor.execute(query, valores)
        conexion.commit()
        print("Cliente creado con éxito.")
    except mysql.connector.Error as e:
        print(f"Error al crear el cliente: {e}")

# # Solicitar datos al usuario desde el terminal
# cedula = input("Cédula del cliente: ")
# nombre = input("Nombre del cliente: ")
# apellido = input("Apellido del cliente: ")
# telefono = input("Teléfono del cliente: ")
# correo = input("Correo del cliente: ")
# direccion = input("Dirección del cliente: ")

# # Llamar a la función para crear un cliente
# crear_cliente(cedula, nombre, apellido, telefono, correo, direccion)




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




# Función para verificar si un proveedor existe por su número de documento
def proveedor_existe_por_numero_documento(numero_documento):
    try:
        query = "SELECT COUNT(*) FROM Proveedor WHERE Numero_Documento = %s"
        cursor.execute(query, (numero_documento,))
        resultado = cursor.fetchone()
        return resultado[0] > 0
    except mysql.connector.Error as e:
        print(f"Error al verificar la existencia del proveedor: {e}")
        return False




# Función para crear un proveedor
def crear_proveedor(nombre_comercial, nombre, apellido, tipo_documento, numero_documento, telefono, correo, direccion):
    try:
        query = "INSERT INTO Proveedor (Nombre_Comercial_Proveedor, Nombre_Proveedor, Apellido_Proveedor, Tipo_Documento, Numero_Documento, Telefono_Proveedor, Correo_Proveedor, Direccion_Proveedor) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s)"
        valores = (nombre_comercial, nombre, apellido, tipo_documento, numero_documento, telefono, correo, direccion)
        cursor.execute(query, valores)
        conexion.commit()
        print("Proveedor creado con éxito.")
    except mysql.connector.Error as e:
        print(f"Error al crear el proveedor: {e}")

# # Solicitar datos al usuario desde el terminal para crear un proveedor
# nombre_comercial = input("Nombre Comercial del proveedor: ")
# nombre = input("Nombre del proveedor: ")
# apellido = input("Apellido del proveedor: ")
# tipo_documento = input("Tipo de documento del proveedor: ")
# numero_documento = input("Número de documento del proveedor: ")
# telefono = input("Teléfono del proveedor: ")
# correo = input("Correo del proveedor: ")
# direccion = input("Dirección del proveedor: ")

# # Llamar a la función para crear un proveedor
# crear_proveedor( nombre_comercial, nombre, apellido, tipo_documento, numero_documento, telefono, correo, direccion)




# Función para modificar los datos de un proveedor por su número de documento
def modificar_proveedor_por_numero_documento(numero_documento, nuevo_nombre, nuevo_apellido, nuevo_tipo_documento, nuevo_numero_documento, nuevo_telefono, nuevo_correo, nueva_direccion):
    if proveedor_existe_por_numero_documento(numero_documento):
        try:
            query = "UPDATE Proveedor SET Nombre_Proveedor = %s, Apellido_Proveedor = %s, Tipo_Documento = %s, Numero_Documento = %s, Telefono_Proveedor = %s, Correo_Proveedor = %s, Direccion_Proveedor = %s WHERE Numero_Documento = %s"
            valores = (nuevo_nombre, nuevo_apellido, nuevo_tipo_documento, nuevo_numero_documento, nuevo_telefono, nuevo_correo, nueva_direccion, numero_documento)
            cursor.execute(query, valores)
            conexion.commit()
            print("Datos del proveedor actualizados con éxito.")
        except mysql.connector.Error as e:
            print(f"Error al actualizar los datos del proveedor: {e}")
    else:
        print(f"No existe un proveedor con número de documento {numero_documento} en la base de datos.")

# # Solicitar número de documento del proveedor al usuario desde la terminal
# numero_documento = input("Introduce el número de documento del proveedor cuyos datos deseas modificar: ")

# # Llamar a la función para modificar los datos del proveedor por número de documento
# if proveedor_existe_por_numero_documento(numero_documento):
#     nuevo_nombre = input("Nuevo nombre del proveedor: ")
#     nuevo_apellido = input("Nuevo apellido del proveedor: ")
#     nuevo_tipo_documento = input("Nuevo tipo de documento del proveedor: ")
#     nuevo_numero_documento = input("Nuevo número de documento del proveedor: ")
#     nuevo_telefono = input("Nuevo teléfono del proveedor: ")
#     nuevo_correo = input("Nuevo correo del proveedor: ")
#     nueva_direccion = input("Nueva dirección del proveedor: ")
#     modificar_proveedor_por_numero_documento(numero_documento, nuevo_nombre, nuevo_apellido, nuevo_tipo_documento, nuevo_numero_documento, nuevo_telefono, nuevo_correo, nueva_direccion)
# else:
#     print(f"No se encontró un proveedor con número de documento {numero_documento}.")




# Función para consultar proveedores por nombre comercial
def consultar_proveedor_por_nombre_comercial(nombre_comercial):
    try:
        query = "SELECT * FROM Proveedor WHERE Nombre_Comercial_Proveedor LIKE %s"
        cursor.execute(query, (f"%{nombre_comercial}%",))
        resultado = cursor.fetchall()
        return resultado
    except mysql.connector.Error as e:
        print(f"Error al consultar proveedor por nombre comercial: {e}")
        return None

# # Solicitar nombre comercial del proveedor al usuario desde la terminal
# nombre_comercial = input("Introduce el nombre comercial del proveedor a consultar: ")

# # Llamar a la función para consultar el proveedor por nombre comercial
# resultado = consultar_proveedor_por_nombre_comercial(nombre_comercial)

# if resultado:
#     print("Proveedor encontrado:")
#     for row in resultado:
#         print(f"ID: {row[0]}")
#         print(f"Nombre Comercial: {row[1]}")
#         print(f"Nombre: {row[2]}")
#         print(f"Apellido: {row[3]}")
#         print(f"Tipo de Documento: {row[4]}")
#         print(f"Número de Documento: {row[5]}")
#         print(f"Teléfono: {row[6]}")
#         print(f"Correo: {row[7]}")
#         print(f"Dirección: {row[8]}")
# else:
#     print("Proveedor no encontrado.")



# Función para consultar proveedores por número de documento
def consultar_proveedor_por_numero_documento(numero_documento):
    try:
        query = "SELECT * FROM Proveedor WHERE Numero_Documento = %s"
        cursor.execute(query, (numero_documento,))
        resultado = cursor.fetchall()
        return resultado
    except mysql.connector.Error as e:
        print(f"Error al consultar proveedor por número de documento: {e}")
        return None

# # Solicitar número de documento del proveedor al usuario desde la terminal
# numero_documento = input("Introduce el número de documento del proveedor a consultar: ")

# # Llamar a la función para consultar el proveedor por número de documento
# resultado = consultar_proveedor_por_numero_documento(numero_documento)

# if resultado:
#     print("Proveedor encontrado:")
#     for row in resultado:
#         print(f"ID: {row[0]}")
#         print(f"Nombre Comercial: {row[1]}")
#         print(f"Nombre: {row[2]}")
#         print(f"Apellido: {row[3]}")
#         print(f"Tipo de Documento: {row[4]}")
#         print(f"Número de Documento: {row[5]}")
#         print(f"Teléfono: {row[6]}")
#         print(f"Correo: {row[7]}")
#         print(f"Dirección: {row[8]}")
# else:
#     print("Proveedor no encontrado.")



# Función para eliminar un proveedor por su número de documento
def eliminar_proveedor_por_numero_documento(numero_documento):
    if proveedor_existe_por_numero_documento(numero_documento):
        try:
            query = "DELETE FROM Proveedor WHERE Numero_Documento = %s"
            cursor.execute(query, (numero_documento,))
            conexion.commit()
            print(f"Proveedor con número de documento {numero_documento} eliminado con éxito.")
        except mysql.connector.Error as e:
            print(f"Error al eliminar el proveedor: {e}")
    else:
        print(f"No existe un proveedor con número de documento {numero_documento} en la base de datos.")

# # Solicitar número de documento del proveedor al usuario desde la terminal
# numero_documento = input("Introduce el número de documento del proveedor que deseas eliminar: ")

# # Llamar a la función para eliminar el proveedor por número de documento
# eliminar_proveedor_por_numero_documento(numero_documento)




#######################################
#CURD PARA LA TABLA PRODUCTOS
#######################################




# Función para verificar si un producto existe por su código
def producto_existe_por_codigo(codigo):
    try:
        query = "SELECT COUNT(*) FROM Productos WHERE Codigo_Producto = %s"
        cursor.execute(query, (codigo,))
        resultado = cursor.fetchone()
        return resultado[0] > 0
    except mysql.connector.Error as e:
        print(f"Error al verificar la existencia del producto: {e}")
        return False



# Función para crear un producto
def crear_producto(nombre, codigo, detalle, cantidad, precio_venta, precio_costo, fecha_ingreso, id_proveedor):
    try:
        query = "INSERT INTO Productos (Nombre_Producto, Codigo_Producto, Detalle_Producto, Cantidad_Producto, Precio_Venta, Precio_Costo, Fecha_Ingreso, Proveedor_ID_Proveedor) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)"
        valores = (nombre, codigo, detalle, cantidad, precio_venta, precio_costo, fecha_ingreso, id_proveedor)
        cursor.execute(query, valores)
        conexion.commit()
        print("Producto creado con éxito.")
    except mysql.connector.Error as e:
        print(f"Error al crear el producto: {e}")

# # Solicitar al usuario el ID del proveedor al que desea asociar el producto
# id_proveedor = input("Ingrese el ID del proveedor al que desea asociar el producto: ")

# # Solicitar datos al usuario desde el terminal para crear un producto
# nombre = input("Nombre del producto: ")
# codigo = input("Código del producto: ")
# detalle = input("Detalle del producto: ")
# cantidad = input("Cantidad del producto: ")
# precio_venta = input("Precio de venta del producto: ")
# precio_costo = input("Precio de costo del producto: ")
# fecha_ingreso = input("Fecha de ingreso del producto(Example:2023-10-20): ")

# # Llamar a la función para crear un producto, proporcionando el ID del proveedor
# crear_producto(nombre, codigo, detalle, cantidad, precio_venta, precio_costo, fecha_ingreso, id_proveedor)



# Función para actualizar la información de un producto por su Codigo_Producto
def actualizar_producto_por_codigo(codigo_producto, nuevo_nombre, nuevo_detalle, nueva_cantidad, nuevo_precio_venta):
    if producto_existe_por_codigo(codigo_producto):
        try:
            query = "UPDATE Productos SET Nombre_Producto = %s, Detalle_Producto = %s, Cantidad_Producto = %s, Precio_Venta = %s WHERE Codigo_Producto = %s"
            valores = (nuevo_nombre, nuevo_detalle, nueva_cantidad, nuevo_precio_venta, codigo_producto)
            cursor.execute(query, valores)
            conexion.commit()
            print("Información del producto actualizada con éxito.")
        except mysql.connector.Error as e:
            print(f"Error al actualizar la información del producto: {e}")
    else:
        print(f"No se encontró un producto con Codigo_Producto {codigo_producto} en la base de datos.")


# Solicitar el Codigo_Producto del producto al usuario desde la terminal
codigo_producto = input("Introduce el Codigo_Producto del producto que deseas actualizar: ")

# Llamar a la función para actualizar la información del producto por Codigo_Producto
if producto_existe_por_codigo(codigo_producto):
    nuevo_nombre = input("Nuevo nombre del producto: ")
    nuevo_detalle = input("Nuevo detalle del producto: ")
    nueva_cantidad = input("Nueva cantidad del producto: ")
    nuevo_precio_venta = input("Nuevo precio de venta del producto: ")
    actualizar_producto_por_codigo(codigo_producto, nuevo_nombre, nuevo_detalle, nueva_cantidad, nuevo_precio_venta)
else:
    print(f"No se encontró un producto con Codigo_Producto {codigo_producto}.")



















#######################################
#CURD PARA LA TABLA INFORMACION_NEGOCIO
#######################################


#######################################
#CURD PARA LA TABLA CATEGORIAS
#######################################



#######################################
#CURD PARA LA TABLA REEMBOLSOS
#######################################



#######################################
#CURD PARA LA TABLA DEVOLUCIONES
#######################################


# Cerrar la conexión
conexion.close()


