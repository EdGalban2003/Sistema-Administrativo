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
  `ID_Cliente` INT NOT NULL,
  `Cedula_Cliente` INT NOT NULL,
  `Nombre_Cliente` VARCHAR(45) NOT NULL,
  `Apellido_Cliente` VARCHAR(45) NOT NULL,
  `Telefono_Cliente` INT(20) NULL,
  `Correo_Cliente` VARCHAR(45) NULL,
  `Direccion_Cliente` TEXT NULL,
  PRIMARY KEY (`ID_Cliente`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Recibos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Recibos` (
  `ID_Recibo` INT NOT NULL,
  `Fecha_Recibo` DATE NOT NULL,
  `Hora_Recibo` TIME NOT NULL,
  `Cliente_ID_Cliente` INT NOT NULL,
  PRIMARY KEY (`ID_Recibo`, `Cliente_ID_Cliente`),
  INDEX `fk_Factura_Cliente1_idx` (`Cliente_ID_Cliente` ASC),
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
  `ID_Producto` INT NOT NULL,
  `Nombre_Producto` VARCHAR(45) NOT NULL,
  `Codigo_Producto` VARCHAR(45) NOT NULL,
  `Detalle_Producto` TEXT NULL,
  `Cantidad_Producto` INT(11) NOT NULL,
  `Precio_Venta` DECIMAL(10,2) NOT NULL,
  `Precio_Costo` DECIMAL(10,2) NOT NULL,
  `Fecha_Ingreso` DATE NOT NULL,
  `Descuento` DECIMAL(10,2) NULL,
  `Promocion` DECIMAL(10,2) NULL,
  PRIMARY KEY (`ID_Producto`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Detalle_Factura`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Detalle_Factura` (
  `ID_Detalle_Factura` INT NOT NULL,
  `Cantidad` INT NOT NULL,
  `Total_Pago` DECIMAL(10,2) NOT NULL,
  `Productos_ID_Producto` INT NOT NULL,
  `Recibos_ID_Recibo` INT NOT NULL,
  `Recibos_Cliente_ID_Cliente` INT NOT NULL,
  PRIMARY KEY (`ID_Detalle_Factura`, `Productos_ID_Producto`, `Recibos_ID_Recibo`, `Recibos_Cliente_ID_Cliente`),
  INDEX `fk_Detalle_Factura_Productos1_idx` (`Productos_ID_Producto` ASC),
  INDEX `fk_Detalle_Factura_Recibos1_idx` (`Recibos_ID_Recibo` ASC, `Recibos_Cliente_ID_Cliente` ASC),
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
  `ID_Categoria` INT NOT NULL,
  `Nombre_Categoria` VARCHAR(45) NOT NULL,
  `Detalle_Categoria` VARCHAR(45) NOT NULL,
  `Productos_ID_Producto` INT NOT NULL,
  PRIMARY KEY (`ID_Categoria`, `Productos_ID_Producto`),
  INDEX `fk_Categorias_Productos1_idx` (`Productos_ID_Producto` ASC),
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
  `ID_Proveedor` INT NOT NULL,
  `Nombre_Comercial_Proveedor` VARCHAR(45) NOT NULL,
  `Nombre_Proveedor` VARCHAR(45) NOT NULL,
  `Apellido_Proveedor` VARCHAR(45) NOT NULL,
  `Tipo_Documento` VARCHAR(45) NOT NULL,
  `Numero_Documento` VARCHAR(45) NOT NULL,
  `Telefono_Proveedor` INT(20) NOT NULL,
  `Correo_Proveedor` VARCHAR(45) NOT NULL,
  `Direccion_Proveedor` TEXT NOT NULL,
  `Productos_ID_Producto` INT NOT NULL,
  PRIMARY KEY (`ID_Proveedor`, `Productos_ID_Producto`),
  INDEX `fk_Proveedor_Productos1_idx` (`Productos_ID_Producto` ASC),
  CONSTRAINT `fk_Proveedor_Productos1`
    FOREIGN KEY (`Productos_ID_Producto`)
    REFERENCES `Sistema_Administrativo`.`Productos` (`ID_Producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Forma_de_Pago`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Forma_de_Pago` (
  `ID_FormaPago` INT NOT NULL,
  `Nombre_FormaPago` VARCHAR(45) NOT NULL,
  `Descripcion` TEXT NOT NULL,
  `Recibos_ID_Recibo` INT NOT NULL,
  `Recibos_Cliente_ID_Cliente` INT NOT NULL,
  PRIMARY KEY (`ID_FormaPago`, `Recibos_ID_Recibo`, `Recibos_Cliente_ID_Cliente`),
  INDEX `fk_Forma_de_Pago_Recibos1_idx` (`Recibos_ID_Recibo` ASC, `Recibos_Cliente_ID_Cliente` ASC),
  CONSTRAINT `fk_Forma_de_Pago_Recibos1`
    FOREIGN KEY (`Recibos_ID_Recibo` , `Recibos_Cliente_ID_Cliente`)
    REFERENCES `Sistema_Administrativo`.`Recibos` (`ID_Recibo` , `Cliente_ID_Cliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Devoluciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Devoluciones` (
  `ID_Devolucion` INT NOT NULL,
  `Fecha_Devolucion` DATE NOT NULL,
  `Hora_Devolucion` TIME NOT NULL,
  `Cantidad` INT(11) NOT NULL,
  `Motivo_Devolucion` TEXT NOT NULL,
  `Detalles_Adicionales` TEXT NULL,
  `Cliente_ID_Cliente` INT NOT NULL,
  `Recibos_ID_Recibo` INT NOT NULL,
  `Recibos_Cliente_ID_Cliente` INT NOT NULL,
  PRIMARY KEY (`ID_Devolucion`, `Cliente_ID_Cliente`, `Recibos_ID_Recibo`, `Recibos_Cliente_ID_Cliente`),
  INDEX `fk_Devoluciones_Cliente1_idx` (`Cliente_ID_Cliente` ASC),
  INDEX `fk_Devoluciones_Recibos1_idx` (`Recibos_ID_Recibo` ASC, `Recibos_Cliente_ID_Cliente` ASC),
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
  `ID_Usuario` INT NOT NULL,
  `Nombre_Personal` VARCHAR(45) NOT NULL,
  `Apellido_Personal` VARCHAR(45) NOT NULL,
  `Nombre_Usuario` VARCHAR(45) NOT NULL,
  `Contraseña` VARCHAR(45) NOT NULL,
  `Correo_Usuario` VARCHAR(45) NOT NULL,
  `Fecha_Registro` DATE NOT NULL,
  `Hora_Registro` TIME NOT NULL,
  `Salt` TEXT NOT NULL,
  PRIMARY KEY (`ID_Usuario`),
  UNIQUE INDEX `CorreoElectronico_UNIQUE` (`Correo_Usuario` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Roles` (
  `ID_Rol` INT NOT NULL,
  `Nombre_Rol` VARCHAR(45) NOT NULL,
  `Descripcion_Rol` TEXT NULL,
  `Usuarios_ID_Usuario` INT NOT NULL,
  PRIMARY KEY (`ID_Rol`, `Usuarios_ID_Usuario`),
  INDEX `fk_Roles_Usuarios1_idx` (`Usuarios_ID_Usuario` ASC),
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
  `ID_Permiso` INT NOT NULL,
  `Nombre_Permiso` VARCHAR(45) NOT NULL,
  `Descripcion_Permiso` TEXT NULL,
  `Usuarios_ID_Usuario` INT NOT NULL,
  PRIMARY KEY (`ID_Permiso`, `Usuarios_ID_Usuario`),
  INDEX `fk_Permisos_Usuarios1_idx` (`Usuarios_ID_Usuario` ASC),
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
  `ID_CierreCaja` INT NOT NULL,
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
  INDEX `fk_CierreCaja_Usuarios1_idx` (`Usuarios_ID_Usuario` ASC),
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
  `ID_Auditoria` INT NOT NULL,
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
  `ID_Reembolsos` INT NOT NULL,
  `Fecha_Reembolso` DATE NOT NULL,
  `Hora_Reembolso` TIME NOT NULL,
  `Monto_Reembolso` DECIMAL(10,2) NOT NULL,
  `Motivo_Reembolso` TEXT NOT NULL,
  `Detalles_Adicionales` TEXT NULL,
  `Cliente_ID_Cliente` INT NOT NULL,
  `Recibos_ID_Recibo` INT NOT NULL,
  `Recibos_Cliente_ID_Cliente` INT NOT NULL,
  PRIMARY KEY (`ID_Reembolsos`, `Cliente_ID_Cliente`, `Recibos_ID_Recibo`, `Recibos_Cliente_ID_Cliente`),
  INDEX `fk_Reembolsos_Cliente1_idx` (`Cliente_ID_Cliente` ASC),
  INDEX `fk_Reembolsos_Recibos1_idx` (`Recibos_ID_Recibo` ASC, `Recibos_Cliente_ID_Cliente` ASC),
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
  `ID_Manual` INT NOT NULL,
  `Titulo_Manual` VARCHAR(45) NOT NULL,
  `Contenido_Manual` LONGTEXT NOT NULL,
  `Palabras_Clave` TEXT NULL,
  PRIMARY KEY (`ID_Manual`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Informacion_Negocio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Informacion_Negocio` (
  `ID_InformacionNegocio` INT NOT NULL,
  `Nombre_Comercial_Negocio` VARCHAR(45) NOT NULL,
  `Tipo_Documento` VARCHAR(45) NOT NULL,
  `Numero_Documento` VARCHAR(45) NOT NULL,
  `Telefono_Negocio` INT(20) NOT NULL,
  `Correo_Negocio` VARCHAR(45) NOT NULL,
  `Direccion_Negocio` TEXT NOT NULL,
  `Fecha_Registro` DATE NOT NULL,
  `Hora_Registro` TIME NOT NULL,
  `Actividad_Comercial` TEXT NOT NULL,
  PRIMARY KEY (`ID_InformacionNegocio`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sistema_Administrativo`.`Impuestos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Sistema_Administrativo`.`Impuestos` (
  `ID_Impuestos` INT NOT NULL,
  `Nombre_Impuesto` VARCHAR(45) NOT NULL,
  `Tasa_Impuesto` DECIMAL(10,2) NOT NULL,
  `Descripcion_Impuesto` TEXT NULL,
  `Productos_ID_Producto` INT NOT NULL,
  PRIMARY KEY (`ID_Impuestos`, `Productos_ID_Producto`),
  INDEX `fk_Impuestos_Productos1_idx` (`Productos_ID_Producto` ASC),
  CONSTRAINT `fk_Impuestos_Productos1`
    FOREIGN KEY (`Productos_ID_Producto`)
    REFERENCES `Sistema_Administrativo`.`Productos` (`ID_Producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
