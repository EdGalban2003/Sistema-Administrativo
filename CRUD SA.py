import mysql.connector

# Conectarse a la base de datos
def conectar():
    try:
        conexion = mysql.connector.connect(
            host='    ',
            user='     ',
            password='    ',
            database='Prueba1'
        )
        return conexion
    except mysql.connector.Error as error:
        print(f"Error al conectarse a la base de datos: {error}")
        return None

# Función para añadir un cliente
def agregar_cliente(cedula, nombre, apellido, telefono, correo, direccion):
    conexion = conectar()
    if conexion:
        try:
            cursor = conexion.cursor()
            consulta = "INSERT INTO Cliente (Cedula_Cliente, Nombre_Cliente, Apellido_Cliente, Telefono_Cliente, Correo_Cliente, Direccion_Cliente) VALUES (%s, %s, %s, %s, %s, %s)"
            datos = (cedula, nombre, apellido, telefono, correo, direccion)
            cursor.execute(consulta, datos)
            conexion.commit()
            print("Cliente agregado exitosamente")
        except mysql.connector.Error as error:
            print(f"Error al agregar cliente: {error}")
        finally:
            cursor.close()
            conexion.close()

# Función para modificar un cliente por ID
def modificar_cliente_por_id(id_cliente, nuevo_nombre, nuevo_apellido, nuevo_telefono, nuevo_correo, nueva_direccion):
    conexion = conectar()
    if conexion:
        try:
            cursor = conexion.cursor()
            consulta = "UPDATE Cliente SET Nombre_Cliente = %s, Apellido_Cliente = %s, Telefono_Cliente = %s, Correo_Cliente = %s, Direccion_Cliente = %s WHERE ID_Cliente = %s"
            datos = (nuevo_nombre, nuevo_apellido, nuevo_telefono, nuevo_correo, nueva_direccion, id_cliente)
            cursor.execute(consulta, datos)
            conexion.commit()
            print("Cliente modificado exitosamente")
        except mysql.connector.Error as error:
            print(f"Error al modificar cliente: {error}")
        finally:
            cursor.close()
            conexion.close()

# Función para eliminar un cliente por ID
def eliminar_cliente_por_id(id_cliente):
    conexion = conectar()
    if conexion:
        try:
            cursor = conexion.cursor()
            consulta = "DELETE FROM Cliente WHERE ID_Cliente = %s"
            datos = (id_cliente,)
            cursor.execute(consulta, datos)
            conexion.commit()
            print("Cliente eliminado exitosamente")
        except mysql.connector.Error as error:
            print(f"Error al eliminar cliente: {error}")
        finally:
            cursor.close()
            conexion.close()

# Función para consultar un cliente por ID
def consultar_cliente_por_id(id_cliente):
    conexion = conectar()
    if conexion:
        try:
            cursor = conexion.cursor()
            consulta = "SELECT * FROM Cliente WHERE ID_Cliente = %s"
            datos = (id_cliente,)
            cursor.execute(consulta, datos)
            resultado = cursor.fetchone()
            if resultado:
                print("Información del cliente:")
                print("ID:", resultado[0])
                print("Cédula:", resultado[1])
                print("Nombre:", resultado[2])
                print("Apellido:", resultado[3])
                print("Teléfono:", resultado[4])
                print("Correo:", resultado[5])
                print("Dirección:", resultado[6])
            else:
                print("Cliente no encontrado")
        except mysql.connector.Error as error:
            print(f"Error al consultar cliente: {error}")
        finally:
            cursor.close()
            conexion.close()

# Ejemplos de uso
# Para agregar un cliente:
# agregar_cliente(123456789, "Juan", "Pérez", 123456789, "juan@example.com", "Calle 123")

# Para modificar un cliente por ID:
# modificar_cliente_por_id(1, "Nuevo Nombre", "Nuevo Apellido", 987654321, "nuevo@example.com", "Nueva Dirección")

# Para eliminar un cliente por ID:
# eliminar_cliente_por_id(1)

# Para consultar un cliente por ID:
# consultar_cliente_por_id(1)

# Función para agregar un proveedor
def agregar_proveedor(nombre_comercial, nombre_proveedor, apellido_proveedor, tipo_documento, numero_documento, telefono, correo, direccion):
    conexion = conectar()
    if conexion:
        try:
            cursor = conexion.cursor()
            consulta = "INSERT INTO Proveedor (Nombre_Comercial_Proveedor, Nombre_Proveedor, Apellido_Proveedor, Tipo_Documento, Numero_Documento, Telefono_Proveedor, Correo_Proveedor, Direccion_Proveedor) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)"
            datos = (nombre_comercial, nombre_proveedor, apellido_proveedor, tipo_documento, numero_documento, telefono, correo, direccion)
            cursor.execute(consulta, datos)
            conexion.commit()
            print("Proveedor agregado exitosamente")
        except mysql.connector.Error as error:
            print(f"Error al agregar proveedor: {error}")
        finally:
            cursor.close()
            conexion.close()

# Función para modificar un proveedor por ID
def modificar_proveedor_por_id(id_proveedor, nuevo_nombre_comercial, nuevo_nombre_proveedor, nuevo_apellido_proveedor, nuevo_tipo_documento, nuevo_numero_documento, nuevo_telefono, nuevo_correo, nueva_direccion):
    conexion = conectar()
    if conexion:
        try:
            cursor = conexion.cursor()
            consulta = "UPDATE Proveedor SET Nombre_Comercial_Proveedor = %s, Nombre_Proveedor = %s, Apellido_Proveedor = %s, Tipo_Documento = %s, Numero_Documento = %s, Telefono_Proveedor = %s, Correo_Proveedor = %s, Direccion_Proveedor = %s WHERE ID_Proveedor = %s"
            datos = (nuevo_nombre_comercial, nuevo_nombre_proveedor, nuevo_apellido_proveedor, nuevo_tipo_documento, nuevo_numero_documento, nuevo_telefono, nuevo_correo, nueva_direccion, id_proveedor)
            cursor.execute(consulta, datos)
            conexion.commit()
            print("Proveedor modificado exitosamente")
        except mysql.connector.Error as error:
            print(f"Error al modificar proveedor: {error}")
        finally:
            cursor.close()
            conexion.close()

# Función para eliminar un proveedor por ID
def eliminar_proveedor_por_id(id_proveedor):
    conexion = conectar()
    if conexion:
        try:
            cursor = conexion.cursor()
            consulta = "DELETE FROM Proveedor WHERE ID_Proveedor = %s"
            datos = (id_proveedor,)
            cursor.execute(consulta, datos)
            conexion.commit()
            print("Proveedor eliminado exitosamente")
        except mysql.connector.Error as error:
            print(f"Error al eliminar proveedor: {error}")
        finally:
            cursor.close()
            conexion.close()

# Función para consultar un proveedor por ID
def consultar_proveedor_por_id(id_proveedor):
    conexion = conectar()
    if conexion:
        try:
            cursor = conexion.cursor()
            consulta = "SELECT * FROM Proveedor WHERE ID_Proveedor = %s"
            datos = (id_proveedor,)
            cursor.execute(consulta, datos)
            resultado = cursor.fetchone()
            if resultado:
                print("Información del proveedor:")
                print("ID:", resultado[0])
                print("Nombre Comercial:", resultado[1])
                print("Nombre:", resultado[2])
                print("Apellido:", resultado[3])
                print("Tipo de Documento:", resultado[4])
                print("Número de Documento:", resultado[5])
                print("Teléfono:", resultado[6])
                print("Correo:", resultado[7])
                print("Dirección:", resultado[8])
            else:
                print("Proveedor no encontrado")
        except mysql.connector.Error as error:
            print(f"Error al consultar proveedor: {error}")
        finally:
            cursor.close()
            conexion.close()

# Ejemplos de uso
# Para agregar un proveedor:
# agregar_proveedor("Mi Empresa", "Juan", "Pérez", "Cédula", "123456789", 987654321, "proveedor@example.com", "Calle 456")

# Para modificar un proveedor por ID:
# modificar_proveedor_por_id(1, "Nuevo Nombre Comercial", "Nuevo Nombre", "Nuevo Apellido", "RUC", "9876543210", 123456789, "nuevo_proveedor@example.com", "Nueva Dirección")

# Para eliminar un proveedor por ID:
# eliminar_proveedor_por_id(1)

# Para consultar un proveedor por ID:
# consultar_proveedor_por_id(1)

# Función para agregar un producto
def agregar_producto(nombre, codigo, detalle, cantidad, precio_venta, precio_costo, fecha_ingreso, descuento, promocion):
    conexion = conectar()
    if conexion:
        try:
            cursor = conexion.cursor()
            consulta = "INSERT INTO Productos (Nombre_Producto, Codigo_Producto, Detalle_Producto, Cantidad_Producto, Precio_Venta, Precio_Costo, Fecha_Ingreso, Descuento, Promocion) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)"
            datos = (nombre, codigo, detalle, cantidad, precio_venta, precio_costo, fecha_ingreso, descuento, promocion)
            cursor.execute(consulta, datos)
            conexion.commit()
            print("Producto agregado exitosamente")
        except mysql.connector.Error as error:
            print(f"Error al agregar producto: {error}")
        finally:
            cursor.close()
            conexion.close()

# Función para modificar un producto por ID
def modificar_producto_por_id(id_producto, nuevo_nombre, nuevo_codigo, nuevo_detalle, nueva_cantidad, nuevo_precio_venta, nuevo_precio_costo, nueva_fecha_ingreso, nuevo_descuento, nueva_promocion):
    conexion = conectar()
    if conexion:
        try:
            cursor = conexion.cursor()
            consulta = "UPDATE Productos SET Nombre_Producto = %s, Codigo_Producto = %s, Detalle_Producto = %s, Cantidad_Producto = %s, Precio_Venta = %s, Precio_Costo = %s, Fecha_Ingreso = %s, Descuento = %s, Promocion = %s WHERE ID_Producto = %s"
            datos = (nuevo_nombre, nuevo_codigo, nuevo_detalle, nueva_cantidad, nuevo_precio_venta, nuevo_precio_costo, nueva_fecha_ingreso, nuevo_descuento, nueva_promocion, id_producto)
            cursor.execute(consulta, datos)
            conexion.commit()
            print("Producto modificado exitosamente")
        except mysql.connector.Error as error:
            print(f"Error al modificar producto: {error}")
        finally:
            cursor.close()
            conexion.close()

# Función para eliminar un producto por ID
def eliminar_producto_por_id(id_producto):
    conexion = conectar()
    if conexion:
        try:
            cursor = conexion.cursor()
            consulta = "DELETE FROM Productos WHERE ID_Producto = %s"
            datos = (id_producto,)
            cursor.execute(consulta, datos)
            conexion.commit()
            print("Producto eliminado exitosamente")
        except mysql.connector.Error as error:
            print(f"Error al eliminar producto: {error}")
        finally:
            cursor.close()
            conexion.close()

# Función para consultar un producto por ID
def consultar_producto_por_id(id_producto):
    conexion = conectar()
    if conexion:
        try:
            cursor = conexion.cursor()
            consulta = "SELECT * FROM Productos WHERE ID_Producto = %s"
            datos = (id_producto,)
            cursor.execute(consulta, datos)
            resultado = cursor.fetchone()
            if resultado:
                print("Información del producto:")
                print("ID:", resultado[0])
                print("Nombre:", resultado[1])
                print("Código:", resultado[2])
                print("Detalle:", resultado[3])
                print("Cantidad:", resultado[4])
                print("Precio de Venta:", resultado[5])
                print("Precio de Costo:", resultado[6])
                print("Fecha de Ingreso:", resultado[7])
                print("Descuento:", resultado[8])
                print("Promoción:", resultado[9])
            else:
                print("Producto no encontrado")
        except mysql.connector.Error as error:
            print(f"Error al consultar producto: {error}")
        finally:
            cursor.close()
            conexion.close()

# Ejemplos de uso
# Para agregar un producto:
# agregar_producto("Producto 1", "P001", "Descripción del producto 1", 100, 50.0, 30.0, "2023-10-01", 0.0, 0.0)

# Para modificar un producto por ID:
# modificar_producto_por_id(1, "Nuevo Producto", "P002", "Nuevo Descripción", 150, 60.0, 35.0, "2023-10-02", 5.0, 0.0)

# Para eliminar un producto por ID:
# eliminar_producto_por_id(1)

# Para consultar un producto por ID:
# consultar_producto_por_id(1)