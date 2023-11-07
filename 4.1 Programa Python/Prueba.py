import mysql.connector


from config import db_config  # Importa las variables de configuración desde config.py

try:
    # Intentar conectar a la base de datos usando las variables de configuración importadas
    conexion = mysql.connector.connect(**db_config)

    # Si la conexión es exitosa, muestra un mensaje de éxito
    print("Conexión exitosa a la base de datos")
    
    # Luego puedes realizar operaciones en la base de datos usando 'cursor', si es necesario.
    cursor = conexion.cursor()
    # Realiza tus operaciones con la base de datos aquí

except mysql.connector.Error as e:
    # En caso de error, muestra un mensaje de error
    print(f"Error al conectar a la base de datos: {e}")
