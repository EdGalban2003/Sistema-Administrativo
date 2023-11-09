####################
Para Tabla Auditoria
####################

DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Añadir_Auditoria
AFTER INSERT ON Auditoria
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Auditoria';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Auditoria');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_Auditoria
AFTER DELETE ON Auditoria
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Auditoria';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Auditoria');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_Auditoria
AFTER UPDATE ON Auditoria
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Auditoria';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Auditoria');
END;
$$

DELIMITER ;





####################
Para Tabla Clientes:
####################

DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Agregar_Cliente
AFTER INSERT ON Cliente
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Cliente';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Cliente');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_Cliente
AFTER DELETE ON Cliente
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Cliente';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Cliente');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_Cliente
AFTER UPDATE ON Cliente
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Cliente';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Cliente');
END;
$$

DELIMITER ;




#######################
Para Tabla Proveedores:
#######################

DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Agregar_Proveedor
AFTER INSERT ON Proveedor
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Proveedores';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Proveedores');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_Proveedor
AFTER DELETE ON Proveedor
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Proveedores';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Proveedores');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_Proveedor
AFTER UPDATE ON Proveedor
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Proveedores';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Proveedores');
END;
$$

DELIMITER ;



#####################
Para Tabla Productos:
#####################

DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Añadir_Producto
AFTER INSERT ON Productos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Productos';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Productos');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_Producto
AFTER DELETE ON Productos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Productos';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Productos');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_Producto
AFTER UPDATE ON Productos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Productos';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Productos');
END;
$$

DELIMITER ;





####################################
Para Tabla Productos Tienen Impuestos:
####################################

DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_ProImp
AFTER DELETE ON Productos_has_Impuestos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Productos Tienen Impuestos';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Productos Tienen Impuestos');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_ProImp
AFTER UPDATE ON Productos_has_Impuestos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Productos Tienen Impuestos';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Productos Tienen Impuestos');
END;
$$

DELIMITER ;




######################
Para Tabla Inventario:
######################

DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Añadir_Inventario
AFTER INSERT ON Inventario
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Inventario';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en PInventario');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_Inventario
AFTER DELETE ON Inventario
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Inventario';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en PInventario');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_Inventario
AFTER UPDATE ON Inventario
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Inventario';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en PInventario');
END;
$$

DELIMITER ;





###############################
Para Tabla Informacion Negocio:
###############################

DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Añadir_InfoNeg
AFTER INSERT ON Informacion_Negocio
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en InfoNeg';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en InfoNeg');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_InfoNeg
AFTER DELETE ON Informacion_Negocio
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en InfoNeg';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en InfoNeg');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_InfoNeg
AFTER UPDATE ON Informacion_Negocio
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en InfoNeg';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en InfoNeg');
END;
$$

DELIMITER ;





######################
Para Tabla Categorias:
######################

DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Añadir_Categorias
AFTER INSERT ON Categorias
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Categorias';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Categorias');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_Categorias
AFTER DELETE ON Categorias
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Categorias';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Categorias');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_Categorias
AFTER UPDATE ON Categorias
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Categorias';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Categorias');
END;
$$

DELIMITER ;





###################
Para Tabla Recibos:
###################

DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Añadir_Recibos
AFTER INSERT ON Recibos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Recibos';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Recibos');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_Recibos
AFTER DELETE ON Recibos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Recibos';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Recibos');
END;
$$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_Recibos
AFTER UPDATE ON Recibos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Recibos';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Recibos');
END;
$$

DELIMITER ;





####################################
Para Tabla Recibos Tienen Impuestos:
####################################

DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_RecImp
AFTER DELETE ON Recibos_has_Impuestos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Recibos Tienen Impuestos';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Recibos Tienen Impuestos');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_RecImp
AFTER UPDATE ON Recibos_has_Impuestos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Recibos Tienen Impuestos';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Recibos Tienen Impuestos');
END;
$$

DELIMITER ;





#####################
Para Tabla Impuestos:
#####################

DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Añadir_Impuestos
AFTER INSERT ON Impuestos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Impuestos';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Impuestos');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_Impuestos
AFTER DELETE ON Impuestos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Impuestos';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Impuestos');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_Impuestos
AFTER UPDATE ON Impuestos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Impuestos';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Impuestos');
END;
$$

DELIMITER ;





###########################
Para Tabla Detalle_Recibos:
###########################

DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Añadir_DetRec
AFTER INSERT ON Detalle_Recibos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Detalle De Recibos';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Detalle de Recibos');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_DetRec
AFTER DELETE ON Detalle_Recibos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Detalle De Recibos';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Detalle de Recibos');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_DetRec
AFTER UPDATE ON Detalle_Recibos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Detalle De Recibos';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Detalle de Recibos');
END;
$$

DELIMITER ;





########################
Para Tabla Devoluciones:
########################

DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Añadir_Devoluciones
AFTER INSERT ON Devoluciones
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Detalle De Devoluciones';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Detalle de Devoluciones');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_Devoluciones
AFTER DELETE ON Devoluciones
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Detalle De Devoluciones';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Detalle de Devoluciones');
END;
$$

DELIMITER ;


DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_Devoluciones
AFTER UPDATE ON Devoluciones
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Detalle De Devoluciones';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Detalle de Devoluciones');
END;
$$

DELIMITER ;




######################
Para Tabla Reembolsos:
######################

DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Añadir_Reembolsos
AFTER INSERT ON Reembolsos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Detalle De Reembolsos';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Detalle de Reembolsos');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_Reembolsos
AFTER DELETE ON Reembolsos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Detalle De Reembolsos';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Detalle de Reembolsos');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_Reembolsos
AFTER UPDATE ON Reembolsos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Detalle De Reembolsos';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Detalle de Reembolsos');
END;
$$

DELIMITER ;





#########################
Para Tabla Forma de pago:
#########################

DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Añadir_ForPag
AFTER INSERT ON Forma_de_Pago
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Detalle De Forma de Pago';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Detalle de Forma de Pago');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_ForPag
AFTER DELETE ON Forma_de_Pago
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Detalle De Forma de Pago';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Detalle de Forma de Pago');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_ForPag
AFTER UPDATE ON Forma_de_Pago
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Detalle De Forma de Pago';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Detalle de Forma de Pago');
END;
$$

DELIMITER ;





####################
Para Tabla Usuarios:
####################

DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Añadir_Usuarios
AFTER INSERT ON Usuarios
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Usuarios';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Usuarios');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_Usuarios
AFTER DELETE ON Usuarios
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Usuarios';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Usuarios');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_Usuarios
AFTER UPDATE ON Usuarios
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Usuarios';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Usuarios');
END;
$$

DELIMITER ;



#################
Para Tabla Roles:
#################

DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Añadir_Roles
AFTER INSERT ON Roles
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Roles';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Roles');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_Roles
AFTER DELETE ON Roles
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Roles';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Roles');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_Roles
AFTER UPDATE ON Roles
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Roles';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Roles');
END;
$$

DELIMITER ;





####################
Para Tabla Permisos:
####################

DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Añadir_Permisos
AFTER INSERT ON Permisos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Permisos';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Permisos');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_Permisos
AFTER DELETE ON Permisos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Permisos';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Permisos');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_Permisos
AFTER UPDATE ON Permisos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Permisos';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Permisos');
END;
$$

DELIMITER ;


##########################
Para Tabla Cierre de Caja:
##########################

DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Añadir_CierreCaja
AFTER INSERT ON CierreCaja
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Cierre de Caja';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Cierre de Caja');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_CierreCaja
AFTER DELETE ON CierreCaja
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Cierre de Caja';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Cierre de Caja');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_CierreCaja
AFTER UPDATE ON CierreCaja
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Operación en Cierre de Caja';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Cierre de Caja');
END;
$$

DELIMITER ;
