import mysql.connector
import hashlib
import os
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

cursor = conexion.cursor()

def create_user():
    print("Registro de Usuario")
    nombre = input("Nombre: ")
    apellido = input("Apellido: ")
    nombre_usuario = input("Nombre de usuario: ")
    correo = input("Correo: ")
    
    while True:
        contrasena = input("Contraseña: ")
        contrasena_confirm = input("Confirma la contraseña: ")

        if contrasena != contrasena_confirm:
            print("Las contraseñas no coinciden. Intenta de nuevo.")
        else:
            break

    if len(contrasena) < 8:
        print("La contraseña debe tener al menos 8 caracteres.")
        return

    if len(contrasena) > 16:
        print("La contraseña no debe exceder los 16 caracteres.")
        return
    
    contrasena_bytes = contrasena.encode('utf-8')  # Convierte la contraseña en bytes

    # Genera un valor aleatorio (salt) para añadir seguridad al hash de la contraseña
    salt = os.urandom(32)  # Genera un salt como bytes

    # Calcula el hash de la contraseña
    contrasena_hashed = hashlib.pbkdf2_hmac('sha256', contrasena_bytes, salt, 100000)

    # Inserta el usuario en la base de datos
    cursor.execute("INSERT INTO usuarios (Nombre_Personal, Apellido_Personal, Nombre_Usuario, Contraseña, Correo_Usuario, Salt) VALUES (%s, %s, %s, %s, %s, %s)",
                   (nombre, apellido, nombre_usuario, contrasena_hashed, correo, salt))
    conexion.commit()
    print("Usuario registrado con éxito")

def login():
    print("Inicio de Sesión")
    nombre_usuario = input("Nombre de usuario: ")
    contrasena = input("Contraseña: ")

    # Obtiene el usuario de la base de datos
    cursor.execute("SELECT Contraseña, Salt FROM usuarios WHERE Nombre_Usuario = %s", (nombre_usuario,))
    usuario = cursor.fetchone()

    if usuario:
        contrasena_hashed, salt = usuario
        contrasena_bytes = contrasena.encode('utf-8')  # Convierte la contraseña ingresada en bytes
        # Calcula el hash de la contraseña proporcionada
        contrasena_proveida_hashed = hashlib.pbkdf2_hmac('sha256', contrasena_bytes, salt, 100000)
        
        if contrasena_proveida_hashed == contrasena_hashed:
            print("Inicio de sesión exitoso")
        else:
            print("Contraseña incorrecta")
    else:
        print("Nombre de usuario no encontrado")
        
def change_password(nombre_usuario):
    print("Cambio de Contraseña")
    contrasena_actual = input("Contraseña actual: ")

    # Obtiene el usuario de la base de datos
    cursor.execute("SELECT Contraseña, Salt FROM usuarios WHERE Nombre_Usuario = %s", (nombre_usuario,))
    usuario = cursor.fetchone()

    if usuario:
        contrasena_hashed, salt = usuario
        contrasena_bytes = contrasena_actual.encode('utf-8')
        contrasena_proveida_hashed = hashlib.pbkdf2_hmac('sha256', contrasena_bytes, salt, 100000)
        
        if contrasena_proveida_hashed == contrasena_hashed:
            while True:
                nueva_contrasena = input("Nueva contraseña: ")
                nueva_contrasena_confirm = input("Confirma la nueva contraseña: ")

                if nueva_contrasena != nueva_contrasena_confirm:
                    print("Las contraseñas no coinciden. Intenta de nuevo.")
                else:
                    break

            if len(nueva_contrasena) < 8:
                print("La nueva contraseña debe tener al menos 8 caracteres.")
                return

            if len(nueva_contrasena) > 16:
                print("La nueva contraseña no debe exceder los 16 caracteres.")
                return

            nueva_contrasena_bytes = nueva_contrasena.encode('utf-8')
            nuevo_salt = os.urandom(32)
            nueva_contrasena_hashed = hashlib.pbkdf2_hmac('sha256', nueva_contrasena_bytes, nuevo_salt, 100000)

            # Actualiza la contraseña en la base de datos
            cursor.execute("UPDATE usuarios SET Contraseña = %s, Salt = %s WHERE Nombre_Usuario = %s",
                           (nueva_contrasena_hashed, nuevo_salt, nombre_usuario))
            conexion.commit()
            print("Contraseña cambiada con éxito")
        else:
            print("Contraseña actual incorrecta")
    else:
        print("Nombre de usuario no encontrado")      
        

while True:
    print("1. Iniciar sesión")
    print("2. Crear cuenta")
    print("3. Cambiar contraseña")
    print("4. Salir")
    opcion = input("Selecciona una opción: ")

    if opcion == "1":
        login()
    elif opcion == "2":
        create_user()
    elif opcion == "3":
        nombre_usuario = input("Nombre de usuario: ")
        change_password(nombre_usuario)
    elif opcion == "4":
        break

conexion.close()