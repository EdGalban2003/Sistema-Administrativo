import mysql.connector
from config2 import db_config2  # Importa las variables de configuración desde config.py

try:
    # Intentar conectar a la base de datos usando las variables de configuración importadas
    conexion = mysql.connector.connect(**db_config2)

    # Si la conexión es exitosa, muestra un mensaje de éxito
    print("Conexión exitosa a la base de datos")

    # Luego puedes realizar operaciones en la base de datos usando 'cursor', si es necesario.
    cursor = conexion.cursor()

except mysql.connector.Error as e:
    # En caso de error, muestra un mensaje de error
    print(f"Error al conectar a la base de datos: {e}")

try:
    # Nombre del nuevo usuario y su contraseña
    nuevo_usuario = "UserGuest4322"
    nueva_contrasena = "U$3rG#3stP@ss"

    # Comando SQL para crear un nuevo usuario
    crear_usuario_sql = f"CREATE USER '{nuevo_usuario}'@'localhost' IDENTIFIED BY '{nueva_contrasena}'"

    # Ejecutar el comando SQL
    cursor.execute(crear_usuario_sql)

    # Nombre de la base de datos y permisos deseados
    nombre_base_de_datos = "sistema_administrativo"

    # Comando SQL para otorgar permisos al nuevo usuario
    otorgar_permisos_sql = f"GRANT SELECT, INSERT, UPDATE, DELETE ON {nombre_base_de_datos}.* TO '{nuevo_usuario}'@'localhost'"

    # Ejecutar el comando SQL
    cursor.execute(otorgar_permisos_sql)

    # Guardar los cambios
    conexion.commit()

    print("Nuevo usuario creado con éxito y permisos otorgados")

except mysql.connector.Error as e:
    print(f"Error: {e}")
finally:
    # Cerrar el cursor y la conexión
    cursor.close()
    conexion.close()
