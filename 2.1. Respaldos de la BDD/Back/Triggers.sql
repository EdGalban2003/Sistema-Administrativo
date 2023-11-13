####################
Para Tabla Auditoria
####################


DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_Auditoria
AFTER DELETE ON Auditoria
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Eliminado" Información de Seguimiento';

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
  SET accion = 'Ha "Modificado" Información de Seguimiento';

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
  SET accion = 'Ha "Añadido" un Clienter';

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
  SET accion = 'Ha "Eliminado" un Cliente';

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
  SET accion = 'Ha "Modificado" un Cliente';

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
  SET accion = 'Ha "Añadido" un Proveedor';

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
  SET accion = 'Ha "Eliminado" un Proveedor';

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
  SET accion = 'Ha "Modificado" un Proveedor';

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
  SET accion = 'Ha "Añadido" un Producto';

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
  SET accion = 'Ha "Eliminado" un Producto';

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
  SET accion = 'Ha "Modificado" un Producto';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Productos');
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
  SET accion = 'Ha "Añadido" Información de Inventario';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Inventario');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_Inventario
AFTER DELETE ON Inventario
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Eliminado" Información de Inventario';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Inventario');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_Inventario
AFTER UPDATE ON Inventario
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Modificado" Información de Inventario';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Inventario');
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
  SET accion = 'Ha "Añadido" información del Negocio';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Información de Negocio');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_InfoNeg
AFTER DELETE ON Informacion_Negocio
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Eliminado" información del Negocio';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Información de Negocio');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_InfoNeg
AFTER UPDATE ON Informacion_Negocio
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Modificado" información del Negocio';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Información de Negocio');
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
  SET accion = 'Ha "Añadido" una Categoria';

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
  SET accion = 'Ha "Eliminado" una Categoria';

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
  SET accion = 'Ha "Modificado" una Categoria';

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
  SET accion = 'Ha "Añadido" un Recibo';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Recibos');
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
  SET accion = 'Ha "Añadido" un Impuesto';

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
  SET accion = 'Ha "Eliminado" un Impuesto';

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
  SET accion = 'Ha "Modificado" un Impuesto';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Impuestos');
END;
$$

DELIMITER ;





##############################
Para Tabla Detalle de Recibos:
##############################

DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Añadir_DetRec
AFTER INSERT ON Detalle_Recibos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Añadido" Informacio de Detalle de un Recibo';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Recibos');
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
  SET accion = 'Ha "Añadido" una Devolución';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Devoluciones');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_Devoluciones
AFTER DELETE ON Devoluciones
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Eliminado" una Devolución';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Devoluciones');
END;
$$

DELIMITER ;


DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_Devoluciones
AFTER UPDATE ON Devoluciones
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Modificado" una Devolución';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Devoluciones');
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
  SET accion = 'Ha "Añadido" un Reembolso';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Reembolsos');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_Reembolsos
AFTER DELETE ON Reembolsos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Eliminado" un Reembolso';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Reembolsos');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_Reembolsos
AFTER UPDATE ON Reembolsos
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Modificado" un Reembolso';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Reembolsos');
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
  SET accion = 'Ha "Añadido" Información de Forma de Pago';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Forma de Pago');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_ForPag
AFTER DELETE ON Forma_de_Pago
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Eliminado" Información de Forma de Pago';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Forma de Pago');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_ForPag
AFTER UPDATE ON Forma_de_Pago
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Modificado" Información de Forma de Pago';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Forma de Pago');
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
  SET accion = 'Ha "Añadido" Información De Cierre de Caja';

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
  SET accion = 'Ha "Añadido" Información De Cierre de Caja';

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
  SET accion = 'Ha "Modificado" Información De Cierre de Caja';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Cierre de Caja');
END;
$$

DELIMITER ;





####################
Para Tabla Usuarios:
####################

DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Añadir_Usuario
AFTER INSERT ON Usuarios
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Añadido" Un usuario';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Usuarios');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Eliminar_Usuario
AFTER DELETE ON Usuarios
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Eliminado" un Usuario';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Usuarios');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Auditoria_Modificar_Usuario
AFTER UPDATE ON Usuarios
FOR EACH ROW
BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Modificado" un Usuario';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Usuarios');
END;
$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER Trigger_Adutoria_Registro_Cambio_Contraseña
AFTER UPDATE ON Usuarios
FOR EACH ROW
BEGIN
    IF NEW.Contraseña <> OLD.Contraseña THEN
        DECLARE accion VARCHAR(45);
        SET accion = 'Ha Cambiado la Contraseña';

        INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
        VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Usuarios');
    END IF;
END;

DELIMITER ;





-- ####################
-- Para Tabla Sesiones:
-- ####################



-- DELIMITER $$

-- CREATE TRIGGER Trigger_Auditoria_Inicio_Sesion
-- AFTER INSERT ON Sesiones
-- FOR EACH ROW
-- BEGIN
--   DECLARE accion VARCHAR(100);
--   SET accion = CONCAT('Inicio Sesión - Usuario: ', NEW.Nombre_Usuario);

--   INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
--   VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Usuarios');
-- END;
-- $$

-- DELIMITER ;



-- DELIMITER $$

-- CREATE TRIGGER Trigger_Auditoria_Cierre_Sesion
-- AFTER DELETE ON Sesiones
-- FOR EACH ROW
-- BEGIN
--   DECLARE accion VARCHAR(100);
--   SET accion = CONCAT('Cierre Sesión - Usuario: ', OLD.Nombre_Usuario);

--   INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
--   VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Usuarios');
-- END;
-- $$

-- DELIMITER ;
