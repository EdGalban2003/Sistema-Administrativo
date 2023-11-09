-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema Sistema_Administrativo
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema Sistema_Administrativo
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Sistema_Administrativo` DEFAULT CHARACTER SET utf8 ;
USE `Sistema_Administrativo` ;

-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Cliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Cliente` (
  `ID_Cliente` INT NOT NULL AUTO_INCREMENT,
  `Cedula_Cliente` INT NOT NULL,
  `Nombre_Cliente` VARCHAR(45) NOT NULL,
  `Apellido_Cliente` VARCHAR(45) NOT NULL,
  `Telefono_Cliente` VARCHAR(11) NOT NULL,
  `Correo_Cliente` VARCHAR(45) NULL,
  `Direccion_Cliente` TEXT NULL,
  PRIMARY KEY (`ID_Cliente`),
  UNIQUE INDEX `Cedula_Cliente_UNIQUE` (`Cedula_Cliente` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Recibos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Recibos` (
  `ID_Recibo` INT NOT NULL AUTO_INCREMENT,
  `Fecha_Recibo` DATE NOT NULL,
  `Hora_Recibo` TIME NOT NULL,
  `Cliente_ID_Cliente` INT NOT NULL,
  PRIMARY KEY (`ID_Recibo`, `Cliente_ID_Cliente`),
  INDEX `fk_Factura_Cliente1_idx` (`Cliente_ID_Cliente` ASC) ,
  CONSTRAINT `fk_Factura_Cliente1`
    FOREIGN KEY (`Cliente_ID_Cliente`)
    REFERENCES `Sistema_Administrativo`.`Cliente` (`ID_Cliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Productos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Productos` (
  `ID_Producto` INT NOT NULL AUTO_INCREMENT,
  `Nombre_Producto` VARCHAR(45) NOT NULL,
  `Codigo_Producto` VARCHAR(45) NOT NULL,
  `Detalle_Producto` TEXT NULL,
  `Cantidad_Producto` INT(11) NOT NULL,
  `Precio_Venta` DECIMAL(10,2) NOT NULL,
  `Precio_Costo` DECIMAL(10,2) NOT NULL,
  `Fecha_Ingreso` DATE NOT NULL,
  `Descuento` DECIMAL(10,2) NULL,
  `Promocion` DECIMAL(10,2) NULL,
  PRIMARY KEY (`ID_Producto`),
  UNIQUE INDEX `Codigo_Producto_UNIQUE` (`Codigo_Producto` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Detalle_Recibos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Detalle_Recibos` (
  `ID_Detalle_Recibos` INT NOT NULL AUTO_INCREMENT,
  `Cantidad` INT NOT NULL,
  `Total_Pago` DECIMAL(10,2) NOT NULL,
  `Precio_Unitario` DECIMAL(10,2) NOT NULL,
  `Subtotal` DECIMAL(10,2) NOT NULL,
  `Descuento_Por_Unidad` DECIMAL(10,2) NULL,
  `Productos_ID_Producto` INT NOT NULL,
  `Recibos_ID_Recibo` INT NOT NULL,
  `Recibos_Cliente_ID_Cliente` INT NOT NULL,
  PRIMARY KEY (`ID_Detalle_Recibos`, `Productos_ID_Producto`, `Recibos_ID_Recibo`, `Recibos_Cliente_ID_Cliente`),
  INDEX `fk_Detalle_Factura_Productos1_idx` (`Productos_ID_Producto` ASC) ,
  INDEX `fk_Detalle_Factura_Recibos1_idx` (`Recibos_ID_Recibo` ASC, `Recibos_Cliente_ID_Cliente` ASC) ,
  CONSTRAINT `fk_Detalle_Factura_Productos1`
    FOREIGN KEY (`Productos_ID_Producto`)
    REFERENCES `Sistema_Administrativo`.`Productos` (`ID_Producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Detalle_Factura_Recibos1`
    FOREIGN KEY (`Recibos_ID_Recibo` , `Recibos_Cliente_ID_Cliente`)
    REFERENCES `Sistema_Administrativo`.`Recibos` (`ID_Recibo` , `Cliente_ID_Cliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Categorias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Categorias` (
  `ID_Categoria` INT NOT NULL AUTO_INCREMENT,
  `Nombre_Categoria` VARCHAR(45) NOT NULL,
  `Detalle_Categoria` VARCHAR(45) NOT NULL,
  `Productos_ID_Producto` INT NOT NULL,
  PRIMARY KEY (`ID_Categoria`, `Productos_ID_Producto`),
  INDEX `fk_Categorias_Productos1_idx` (`Productos_ID_Producto` ASC) ,
  UNIQUE INDEX `Nombre_Categoria_UNIQUE` (`Nombre_Categoria` ASC) ,
  CONSTRAINT `fk_Categorias_Productos1`
    FOREIGN KEY (`Productos_ID_Producto`)
    REFERENCES `Sistema_Administrativo`.`Productos` (`ID_Producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Proveedor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Proveedor` (
  `ID_Proveedor` INT NOT NULL AUTO_INCREMENT,
  `Nombre_Comercial_Proveedor` VARCHAR(45) NOT NULL,
  `Nombre_Proveedor` VARCHAR(45) NOT NULL,
  `Apellido_Proveedor` VARCHAR(45) NOT NULL,
  `Tipo_Documento` VARCHAR(45) NOT NULL,
  `Numero_Documento` VARCHAR(45) NOT NULL,
  `Telefono_Proveedor` VARCHAR(11) NOT NULL,
  `Correo_Proveedor` VARCHAR(45) NOT NULL,
  `Direccion_Proveedor` TEXT NOT NULL,
  PRIMARY KEY (`ID_Proveedor`),
  UNIQUE INDEX `Nombre_Comercial_Proveedor_UNIQUE` (`Nombre_Comercial_Proveedor` ASC) ,
  UNIQUE INDEX `Numero_Documento_UNIQUE` (`Numero_Documento` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Forma_de_Pago`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Forma_de_Pago` (
  `ID_FormaPago` INT NOT NULL AUTO_INCREMENT,
  `Nombre_FormaPago` VARCHAR(45) NOT NULL,
  `Descripcion` TEXT NOT NULL,
  PRIMARY KEY (`ID_FormaPago`),
  UNIQUE INDEX `Nombre_FormaPago_UNIQUE` (`Nombre_FormaPago` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Devoluciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Devoluciones` (
  `ID_Devolucion` INT NOT NULL AUTO_INCREMENT,
  `Fecha_Devolucion` DATE NOT NULL,
  `Hora_Devolucion` TIME NOT NULL,
  `Cantidad` INT(11) NOT NULL,
  `Motivo_Devolucion` TEXT NOT NULL,
  `Detalles_Adicionales` TEXT NULL,
  `Cliente_ID_Cliente` INT NOT NULL,
  `Recibos_ID_Recibo` INT NOT NULL,
  `Recibos_Cliente_ID_Cliente` INT NOT NULL,
  PRIMARY KEY (`ID_Devolucion`, `Cliente_ID_Cliente`, `Recibos_ID_Recibo`, `Recibos_Cliente_ID_Cliente`),
  INDEX `fk_Devoluciones_Cliente1_idx` (`Cliente_ID_Cliente` ASC) ,
  INDEX `fk_Devoluciones_Recibos1_idx` (`Recibos_ID_Recibo` ASC, `Recibos_Cliente_ID_Cliente` ASC) ,
  CONSTRAINT `fk_Devoluciones_Cliente1`
    FOREIGN KEY (`Cliente_ID_Cliente`)
    REFERENCES `Sistema_Administrativo`.`Cliente` (`ID_Cliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Devoluciones_Recibos1`
    FOREIGN KEY (`Recibos_ID_Recibo` , `Recibos_Cliente_ID_Cliente`)
    REFERENCES `Sistema_Administrativo`.`Recibos` (`ID_Recibo` , `Cliente_ID_Cliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Usuarios` (
  `ID_Usuario` INT NOT NULL AUTO_INCREMENT,
  `Nombre_Personal` VARCHAR(45) NOT NULL,
  `Apellido_Personal` VARCHAR(45) NOT NULL,
  `Nombre_Usuario` VARCHAR(45) NOT NULL,
  `Contraseña` VARBINARY(32) NOT NULL,
  `Salt` VARBINARY(32) NOT NULL,
  `Correo_Usuario` VARCHAR(45) NOT NULL,
  `Fecha_Registro` DATE NOT NULL,
  `Hora_Registro` TIME NOT NULL,
  `Pregunta1` VARCHAR(255) NULL,
  `Respuesta1` VARCHAR(45) NULL,
  `Salt2` VARBINARY(32) NULL,
  `Pregunta2` VARCHAR(255) NULL,
  `Salt3` VARBINARY(32) NULL,
  `Respuesta2` VARCHAR(45) NULL,
  `Pregunta3` VARCHAR(255) NULL,
  `Salt4` VARBINARY(32) NULL,
  `Respuesta3` VARCHAR(45) NULL,
  PRIMARY KEY (`ID_Usuario`),
  UNIQUE INDEX `Nombre_Usuario_UNIQUE` (`Nombre_Usuario` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Roles` (
  `ID_Rol` INT NOT NULL AUTO_INCREMENT,
  `Nombre_Rol` VARCHAR(45) NOT NULL,
  `Descripcion_Rol` TEXT NULL,
  `Usuarios_ID_Usuario` INT NOT NULL,
  PRIMARY KEY (`ID_Rol`, `Usuarios_ID_Usuario`),
  INDEX `fk_Roles_Usuarios1_idx` (`Usuarios_ID_Usuario` ASC) ,
  UNIQUE INDEX `Nombre_Rol_UNIQUE` (`Nombre_Rol` ASC) ,
  CONSTRAINT `fk_Roles_Usuarios1`
    FOREIGN KEY (`Usuarios_ID_Usuario`)
    REFERENCES `Sistema_Administrativo`.`Usuarios` (`ID_Usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Permisos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Permisos` (
  `ID_Permiso` INT NOT NULL AUTO_INCREMENT,
  `Nombre_Permiso` VARCHAR(45) NOT NULL,
  `Descripcion_Permiso` TEXT NULL,
  `Usuarios_ID_Usuario` INT NOT NULL,
  PRIMARY KEY (`ID_Permiso`, `Usuarios_ID_Usuario`),
  INDEX `fk_Permisos_Usuarios1_idx` (`Usuarios_ID_Usuario` ASC) ,
  UNIQUE INDEX `Nombre_Permiso_UNIQUE` (`Nombre_Permiso` ASC) ,
  CONSTRAINT `fk_Permisos_Usuarios1`
    FOREIGN KEY (`Usuarios_ID_Usuario`)
    REFERENCES `Sistema_Administrativo`.`Usuarios` (`ID_Usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`CierreCaja`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`CierreCaja` (
  `ID_CierreCaja` INT NOT NULL AUTO_INCREMENT,
  `Num_Cajero` VARCHAR(45) NOT NULL,
  `Fecha_Cierre` DATE NOT NULL,
  `Hora_Cierre` TIME NOT NULL,
  `Efectivo` DECIMAL(10,2) NULL,
  `Tarjeta_Credito` DECIMAL(10,2) NULL,
  `Transferencia_Bancaria` DECIMAL(10,2) NULL,
  `Monto_Total` DECIMAL(10,2) NOT NULL,
  `Detalles` TEXT NULL,
  `Usuarios_ID_Usuario` INT NOT NULL,
  PRIMARY KEY (`ID_CierreCaja`, `Usuarios_ID_Usuario`),
  INDEX `fk_CierreCaja_Usuarios1_idx` (`Usuarios_ID_Usuario` ASC) ,
  CONSTRAINT `fk_CierreCaja_Usuarios1`
    FOREIGN KEY (`Usuarios_ID_Usuario`)
    REFERENCES `Sistema_Administrativo`.`Usuarios` (`ID_Usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Auditoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Auditoria` (
  `ID_Auditoria` INT NOT NULL AUTO_INCREMENT,
  `Fecha_Accion` DATE NOT NULL,
  `Hora_Accion` TIME NOT NULL,
  `Usuario` VARCHAR(45) NOT NULL,
  `Descripcion_Accion` TEXT NOT NULL,
  `Detalles_Adicionales` TEXT NOT NULL,
  PRIMARY KEY (`ID_Auditoria`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Reembolsos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Reembolsos` (
  `ID_Reembolsos` INT NOT NULL AUTO_INCREMENT,
  `Fecha_Reembolso` DATE NOT NULL,
  `Hora_Reembolso` TIME NOT NULL,
  `Monto_Reembolso` DECIMAL(10,2) NOT NULL,
  `Motivo_Reembolso` TEXT NOT NULL,
  `Detalles_Adicionales` TEXT NULL,
  `Cliente_ID_Cliente` INT NOT NULL,
  `Recibos_ID_Recibo` INT NOT NULL,
  `Recibos_Cliente_ID_Cliente` INT NOT NULL,
  PRIMARY KEY (`ID_Reembolsos`, `Cliente_ID_Cliente`, `Recibos_ID_Recibo`, `Recibos_Cliente_ID_Cliente`),
  INDEX `fk_Reembolsos_Cliente1_idx` (`Cliente_ID_Cliente` ASC) ,
  INDEX `fk_Reembolsos_Recibos1_idx` (`Recibos_ID_Recibo` ASC, `Recibos_Cliente_ID_Cliente` ASC) ,
  CONSTRAINT `fk_Reembolsos_Cliente1`
    FOREIGN KEY (`Cliente_ID_Cliente`)
    REFERENCES `Sistema_Administrativo`.`Cliente` (`ID_Cliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Reembolsos_Recibos1`
    FOREIGN KEY (`Recibos_ID_Recibo` , `Recibos_Cliente_ID_Cliente`)
    REFERENCES `Sistema_Administrativo`.`Recibos` (`ID_Recibo` , `Cliente_ID_Cliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Manual`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Manual` (
  `ID_Manual` INT NOT NULL AUTO_INCREMENT,
  `Titulo_Manual` VARCHAR(45) NOT NULL,
  `Contenido_Manual` LONGTEXT NOT NULL,
  `Palabras_Clave` TEXT NULL,
  PRIMARY KEY (`ID_Manual`),
  UNIQUE INDEX `Titulo_Manual_UNIQUE` (`Titulo_Manual` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Informacion_Negocio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Informacion_Negocio` (
  `ID_InformacionNegocio` INT NOT NULL AUTO_INCREMENT,
  `Nombre_Comercial_Negocio` VARCHAR(45) NOT NULL,
  `Tipo_Documento` VARCHAR(45) NOT NULL,
  `Numero_Documento` VARCHAR(45) NOT NULL,
  `Telefono_Negocio` VARCHAR(11) NOT NULL,
  `Correo_Negocio` VARCHAR(45) NOT NULL,
  `Direccion_Negocio` TEXT NOT NULL,
  `Fecha_Registro` DATE NOT NULL,
  `Hora_Registro` TIME NOT NULL,
  `Actividad_Comercial` TEXT NOT NULL,
  PRIMARY KEY (`ID_InformacionNegocio`),
  UNIQUE INDEX `Nombre_Comercial_Negocio_UNIQUE` (`Nombre_Comercial_Negocio` ASC) ,
  UNIQUE INDEX `Numero_Documento_UNIQUE` (`Numero_Documento` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Impuestos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Impuestos` (
  `ID_Impuestos` INT NOT NULL AUTO_INCREMENT,
  `Nombre_Impuesto` VARCHAR(45) NOT NULL,
  `Tasa_Impuesto` DECIMAL(10,2) NOT NULL,
  `Descripcion_Impuesto` TEXT NULL,
  PRIMARY KEY (`ID_Impuestos`),
  UNIQUE INDEX `Nombre_Impuesto_UNIQUE` (`Nombre_Impuesto` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Recibos_has_Impuestos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Recibos_has_Impuestos` (
  `Recibos_ID_Recibo` INT NOT NULL,
  `Recibos_Cliente_ID_Cliente` INT NOT NULL,
  `Impuestos_ID_Impuestos` INT NOT NULL,
  PRIMARY KEY (`Recibos_ID_Recibo`, `Recibos_Cliente_ID_Cliente`, `Impuestos_ID_Impuestos`),
  INDEX `fk_Recibos_has_Impuestos_Impuestos1_idx` (`Impuestos_ID_Impuestos` ASC) ,
  INDEX `fk_Recibos_has_Impuestos_Recibos1_idx` (`Recibos_ID_Recibo` ASC, `Recibos_Cliente_ID_Cliente` ASC) ,
  CONSTRAINT `fk_Recibos_has_Impuestos_Recibos1`
    FOREIGN KEY (`Recibos_ID_Recibo` , `Recibos_Cliente_ID_Cliente`)
    REFERENCES `Sistema_Administrativo`.`Recibos` (`ID_Recibo` , `Cliente_ID_Cliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Recibos_has_Impuestos_Impuestos1`
    FOREIGN KEY (`Impuestos_ID_Impuestos`)
    REFERENCES `Sistema_Administrativo`.`Impuestos` (`ID_Impuestos`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Inventario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Inventario` (
  `ID_Inventario` INT NOT NULL,
  `Entradas` INT NOT NULL,
  `Salidas` INT NOT NULL,
  `Descripcion` TEXT NULL,
  `Fecha_Transaccion` DATE NOT NULL,
  `Hora_Transaccion` TIME NOT NULL,
  `Usuario` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`ID_Inventario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Proveedor_has_Productos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Proveedor_has_Productos` (
  `Proveedor_ID_Proveedor` INT NOT NULL,
  `Productos_ID_Producto` INT NOT NULL,
  PRIMARY KEY (`Proveedor_ID_Proveedor`, `Productos_ID_Producto`),
  INDEX `fk_Proveedor_has_Productos_Productos1_idx` (`Productos_ID_Producto` ASC) ,
  INDEX `fk_Proveedor_has_Productos_Proveedor1_idx` (`Proveedor_ID_Proveedor` ASC) ,
  CONSTRAINT `fk_Proveedor_has_Productos_Proveedor1`
    FOREIGN KEY (`Proveedor_ID_Proveedor`)
    REFERENCES `Sistema_Administrativo`.`Proveedor` (`ID_Proveedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Proveedor_has_Productos_Productos1`
    FOREIGN KEY (`Productos_ID_Producto`)
    REFERENCES `Sistema_Administrativo`.`Productos` (`ID_Producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Productos_has_Inventario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Productos_has_Inventario` (
  `Productos_ID_Producto` INT NOT NULL,
  `Inventario_ID_Inventario` INT NOT NULL,
  PRIMARY KEY (`Productos_ID_Producto`, `Inventario_ID_Inventario`),
  INDEX `fk_Productos_has_Inventario_Inventario1_idx` (`Inventario_ID_Inventario` ASC) ,
  INDEX `fk_Productos_has_Inventario_Productos1_idx` (`Productos_ID_Producto` ASC) ,
  CONSTRAINT `fk_Productos_has_Inventario_Productos1`
    FOREIGN KEY (`Productos_ID_Producto`)
    REFERENCES `Sistema_Administrativo`.`Productos` (`ID_Producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Productos_has_Inventario_Inventario1`
    FOREIGN KEY (`Inventario_ID_Inventario`)
    REFERENCES `Sistema_Administrativo`.`Inventario` (`ID_Inventario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Productos_has_Impuestos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Productos_has_Impuestos` (
  `Productos_ID_Producto` INT NOT NULL,
  `Impuestos_ID_Impuestos` INT NOT NULL,
  PRIMARY KEY (`Productos_ID_Producto`, `Impuestos_ID_Impuestos`),
  INDEX `fk_Productos_has_Impuestos_Impuestos1_idx` (`Impuestos_ID_Impuestos` ASC) ,
  INDEX `fk_Productos_has_Impuestos_Productos1_idx` (`Productos_ID_Producto` ASC) ,
  CONSTRAINT `fk_Productos_has_Impuestos_Productos1`
    FOREIGN KEY (`Productos_ID_Producto`)
    REFERENCES `Sistema_Administrativo`.`Productos` (`ID_Producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Productos_has_Impuestos_Impuestos1`
    FOREIGN KEY (`Impuestos_ID_Impuestos`)
    REFERENCES `Sistema_Administrativo`.`Impuestos` (`ID_Impuestos`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Recibos_has_Forma_de_Pago`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Recibos_has_Forma_de_Pago` (
  `Recibos_ID_Recibo` INT NOT NULL,
  `Recibos_Cliente_ID_Cliente` INT NOT NULL,
  `Forma_de_Pago_ID_FormaPago` INT NOT NULL,
  PRIMARY KEY (`Recibos_ID_Recibo`, `Recibos_Cliente_ID_Cliente`, `Forma_de_Pago_ID_FormaPago`),
  INDEX `fk_Recibos_has_Forma_de_Pago_Forma_de_Pago1_idx` (`Forma_de_Pago_ID_FormaPago` ASC) ,
  INDEX `fk_Recibos_has_Forma_de_Pago_Recibos1_idx` (`Recibos_ID_Recibo` ASC, `Recibos_Cliente_ID_Cliente` ASC) ,
  CONSTRAINT `fk_Recibos_has_Forma_de_Pago_Recibos1`
    FOREIGN KEY (`Recibos_ID_Recibo` , `Recibos_Cliente_ID_Cliente`)
    REFERENCES `Sistema_Administrativo`.`Recibos` (`ID_Recibo` , `Cliente_ID_Cliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Recibos_has_Forma_de_Pago_Forma_de_Pago1`
    FOREIGN KEY (`Forma_de_Pago_ID_FormaPago`)
    REFERENCES `Sistema_Administrativo`.`Forma_de_Pago` (`ID_FormaPago`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
