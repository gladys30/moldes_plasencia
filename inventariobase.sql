-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.24 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para inventario_movil_plasencia
CREATE DATABASE IF NOT EXISTS `inventario_movil_plasencia` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `inventario_movil_plasencia`;

-- Volcando estructura para procedimiento inventario_movil_plasencia.actualizar_mobiliario
DELIMITER //
CREATE PROCEDURE `actualizar_mobiliario`(
	IN `pa_mobil` VARCHAR(50),
	IN `pa_cant` INT,
	IN `pa_descrip` VARCHAR(50),
	IN `pa_id_mobil` INT
)
BEGIN
      
                        
        UPDATE mobiliario SET mobiliario.nombre_mobiliario = pa_mobil, mobiliario.cant_mobiliario = pa_cant, 
		                        mobiliario.descripcion_mobiliario =  pa_descrip 

                   WHERE mobiliario.id_mobiliario = pa_id_mobil;
                   
                   
                   
                   
                   
                  
                
        END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.actualizar_moldes
DELIMITER //
CREATE PROCEDURE `actualizar_moldes`(
            IN `pa_id_molde` INT,
            IN `pa_bueno` INT,
            IN `pa_irregular` INT,
            IN `pa_malo` INT,
            IN `pa_bodega` INT,
            IN `pa_reparacion` INT,
            IN `pa_salon` INT
        )
BEGIN
        
        
         DECLARE nuevo_total_estado INT;
         DECLARE nuevo_total_ubicacion INT; 
                        
                        
                        SET nuevo_total_estado = pa_bueno+ pa_irregular+ pa_malo;
                        SET nuevo_total_ubicacion = pa_bodega + pa_reparacion + pa_salon;
                        if  nuevo_total_estado = nuevo_total_ubicacion then
                        
        UPDATE moldes SET moldes.bueno = pa_bueno, moldes.irregulares = pa_irregular, moldes.malos =  pa_malo , 
                moldes.reparacion=pa_reparacion, moldes.bodega= pa_bodega, moldes.salon = pa_salon , moldes.total = nuevo_total_estado
                   WHERE moldes.id_molde = pa_id_molde;
                   
                   else
                   
                   SELECT "No se puede actualizar";
                   
                   END if;
                
        END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.actualizar_usuarios
DELIMITER //
CREATE PROCEDURE `actualizar_usuarios`(
	IN `pa_id_usuario` INT,
	IN `pa_codigo` INT,
	IN `pa_nombre` VARCHAR(50),
	IN `pa_id_planta` INT,
	IN `pa_correo` VARCHAR(50)
)
BEGIN
                
                UPDATE users 
                SET 
                      users.nombre_usuario = pa_nombre, 
                      users.correo = pa_correo,
                      users.codigo=pa_codigo,
                      users.id_planta =  pa_id_planta 
                      
        
                WHERE users.id_usuario = pa_id_usuario;
                        
                END//
DELIMITER ;

-- Volcando estructura para tabla inventario_movil_plasencia.area
CREATE TABLE IF NOT EXISTS `area` (
  `id_area` int(11) NOT NULL AUTO_INCREMENT,
  `id_planta` int(11) NOT NULL DEFAULT '0',
  `nombre_area` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_area`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla inventario_movil_plasencia.area: 5 rows
DELETE FROM `area`;
/*!40000 ALTER TABLE `area` DISABLE KEYS */;
INSERT INTO `area` (`id_area`, `id_planta`, `nombre_area`) VALUES
	(1, 1, 'control'),
	(2, 1, 'capa'),
	(3, 1, 'pilones'),
	(4, 1, 'rezago'),
	(5, 1, 'despalillo');
/*!40000 ALTER TABLE `area` ENABLE KEYS */;

-- Volcando estructura para procedimiento inventario_movil_plasencia.buscar_remision
DELIMITER //
CREATE PROCEDURE `buscar_remision`(
	IN `pa_fecha_inicio` VARCHAR(50),
	IN `pa_fecha_fin` VARCHAR(50),
	IN `pa_id_planta` INT
)
BEGIN

if pa_fecha_inicio= 0 && pa_fecha_fin = 0 then 

select *
  from remisiones
 where remisiones.id_planta = pa_id_planta;
 
else

select *
  from remisiones
 where remisiones.fecha between pa_fecha_inicio AND pa_fecha_fin AND 
 		remisiones.id_planta = pa_id_planta;
 		
END if ;
END//
DELIMITER ;

-- Volcando estructura para tabla inventario_movil_plasencia.departamento
CREATE TABLE IF NOT EXISTS `departamento` (
  `id_depto` int(11) NOT NULL AUTO_INCREMENT,
  `id_planta` int(11) NOT NULL DEFAULT '0',
  `nombre_depto` varchar(30) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_depto`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla inventario_movil_plasencia.departamento: 8 rows
DELETE FROM `departamento`;
/*!40000 ALTER TABLE `departamento` DISABLE KEYS */;
INSERT INTO `departamento` (`id_depto`, `id_planta`, `nombre_depto`) VALUES
	(1, 1, 'produccion'),
	(33, 1, 'preindustria'),
	(27, 1, 'empaque'),
	(28, 1, 'calidad'),
	(29, 1, 'suministro'),
	(30, 1, 'lavado'),
	(31, 1, 'catacion'),
	(32, 1, 'bodega');
/*!40000 ALTER TABLE `departamento` ENABLE KEYS */;

-- Volcando estructura para procedimiento inventario_movil_plasencia.distintos_moldes
DELIMITER //
CREATE PROCEDURE `distintos_moldes`()
BEGIN
        
                        DELETE FROM totales_plantas;
        
        
                                  SELECT DISTINCT(concat(x.nombre_figura,"  " , x.vitola)) as figura_vitola FROM ((SELECT  plantas.nombre_planta, vitolas.vitola, figura_tipos.nombre_figura, moldes.bueno,  moldes.irregulares, moldes.malos, 
                            moldes.bodega, moldes.reparacion, moldes.salon, moldes.id_molde, moldes.total
                            FROM plantas, moldes, figura_tipos, vitolas WHERE "1" = plantas.id_planta AND
                            moldes.id_planta = plantas.id_planta AND vitolas.id_planta = plantas.id_planta and figura_tipos.id_planta = plantas.id_planta 
                            AND moldes.id_figura = figura_tipos.id_figura AND
                            moldes.id_vitola = vitolas.id_vitola)
                                  union
                                  (SELECT  plantas.nombre_planta, vitolas.vitola, figura_tipos.nombre_figura, moldes.bueno,  moldes.irregulares, moldes.malos, 
                            moldes.bodega, moldes.reparacion, moldes.salon, moldes.id_molde, moldes.total
                            FROM plantas, moldes, figura_tipos, vitolas WHERE "2" = plantas.id_planta AND
                            moldes.id_planta = plantas.id_planta AND vitolas.id_planta = plantas.id_planta and figura_tipos.id_planta = plantas.id_planta 
                            AND moldes.id_figura = figura_tipos.id_figura AND
                            moldes.id_vitola = vitolas.id_vitola)
                            union
                            (SELECT  plantas.nombre_planta, vitolas.vitola, figura_tipos.nombre_figura, moldes.bueno,  moldes.irregulares, moldes.malos, 
                            moldes.bodega, moldes.reparacion, moldes.salon, moldes.id_molde, moldes.total
                            FROM plantas, moldes, figura_tipos, vitolas WHERE "3" = plantas.id_planta AND
                            moldes.id_planta = plantas.id_planta AND vitolas.id_planta = plantas.id_planta and figura_tipos.id_planta = plantas.id_planta 
                            AND moldes.id_figura = figura_tipos.id_figura AND
                            moldes.id_vitola = vitolas.id_vitola)
                            union
                            (SELECT  plantas.nombre_planta, vitolas.vitola, figura_tipos.nombre_figura, moldes.bueno,  moldes.irregulares, moldes.malos, 
                            moldes.bodega, moldes.reparacion, moldes.salon, moldes.id_molde, moldes.total
                            FROM plantas, moldes, figura_tipos, vitolas WHERE "4" = plantas.id_planta AND
                            moldes.id_planta = plantas.id_planta AND vitolas.id_planta = plantas.id_planta and figura_tipos.id_planta = plantas.id_planta 
                            AND moldes.id_figura = figura_tipos.id_figura AND
                            moldes.id_vitola = vitolas.id_vitola))x;
             
             
                       END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.eliminar_usuario
DELIMITER //
CREATE PROCEDURE `eliminar_usuario`(
	IN `pa_id_usuario` INT
)
BEGIN
        
        DELETE FROM users 
        WHERE users.id_usuario = pa_id_usuario;
                
        END//
DELIMITER ;

-- Volcando estructura para tabla inventario_movil_plasencia.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla inventario_movil_plasencia.failed_jobs: ~0 rows (aproximadamente)
DELETE FROM `failed_jobs`;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Volcando estructura para tabla inventario_movil_plasencia.figura_tipos
CREATE TABLE IF NOT EXISTS `figura_tipos` (
  `id_figura` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_figura` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_planta` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_figura`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla inventario_movil_plasencia.figura_tipos: ~3 rows (aproximadamente)
DELETE FROM `figura_tipos`;
/*!40000 ALTER TABLE `figura_tipos` DISABLE KEYS */;
INSERT INTO `figura_tipos` (`id_figura`, `nombre_figura`, `id_planta`, `created_at`, `updated_at`) VALUES
	(1, 'cabeza 1', '1', NULL, NULL),
	(2, 'cabeza 2', '1', NULL, NULL),
	(3, 'cabeza 3', '1', NULL, NULL);
/*!40000 ALTER TABLE `figura_tipos` ENABLE KEYS */;

-- Volcando estructura para procedimiento inventario_movil_plasencia.insertar_area
DELIMITER //
CREATE PROCEDURE `insertar_area`(
	IN `pa_id_planta` INT,
	IN `pa_nombre_area` VARCHAR(50)
)
BEGIN



if EXISTS(SELECT * FROM area WHERE pa_nombre_area = area.nombre_area ) then 
        
        SELECT "este departamento ya exista";
        
        ELSE
        INSERT INTO area(area.nombre_area, area.id_planta) VALUES(pa_nombre_area,pa_id_planta);
        
        
        
        END if ;





END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.insertar_depto
DELIMITER //
CREATE PROCEDURE `insertar_depto`(
	IN `pa_id_planta` INT,
	IN `pa_nombre_depto` VARCHAR(50)
)
BEGIN

 if EXISTS(SELECT * FROM departamento WHERE pa_nombre_depto = departamento.nombre_depto ) then 
        
        SELECT "este departamento ya exista";
        
        ELSE
        INSERT INTO departamento(departamento.nombre_depto, departamento.id_planta) VALUES(pa_nombre_depto,pa_id_planta);
        
        
        
        END if ;



END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.insertar_figura
DELIMITER //
CREATE PROCEDURE `insertar_figura`(
            IN `pa_id_planta` INT,
            IN `pa_nombre_figura` VARCHAR(50)
        )
BEGIN
        
        if EXISTS(SELECT * FROM figura_tipos WHERE figura_tipos.nombre_figura = pa_nombre_figura ) then
         SELECT"el registro ya existe";
        
        
        ELSE
        
            INSERT INTO figura_tipos(figura_tipos.nombre_figura, figura_tipos.id_planta)  VALUES(pa_nombre_figura, pa_id_planta);
            
        END if;
        
        
        END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.insertar_mobiliario
DELIMITER //
CREATE PROCEDURE `insertar_mobiliario`(
	IN `pa_id_planta` INT,
	IN `pa_id_depto` INT,
	IN `pa_id_area` INT,
	IN `pa_nombre_mobi` VARCHAR(50),
	IN `pa_cant_mobi` INT,
	IN `pa_descrip_mobi` VARCHAR(255)
)
BEGIN

                       if  EXISTS(SELECT * 
                            FROM plantas, mobiliario, area, departamento WHERE pa_id_planta = plantas.id_planta AND 
                            pa_id_depto = mobiliario.id_planta AND pa_id_area = mobiliario.id_planta and
                            
                          mobiliario.id_planta = plantas.id_planta AND pa_nombre_mobi = mobiliario.nombre_mobiliario ) then
                        
                        
                         SELECT "ya existe"; 
                        
                        ELSE 
                        
                        
                         INSERT INTO mobiliario(mobiliario.id_planta, mobiliario.id_depto, mobiliario.id_area,
                         mobiliario.nombre_mobiliario, mobiliario.cant_mobiliario,mobiliario.descripcion_mobiliario)
                         VALUES(pa_id_planta, pa_id_depto,pa_id_area, pa_nombre_mobi, pa_cant_mobi, pa_descrip_mobi);
                        
                       
                        
                                  SELECT "insertado correctamente";
                                  
                                  END if; 
                        
                         
                        
                        
                        
                      
                       
                        
                         
                                 
                                
                                  





END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.insertar_moldes
DELIMITER //
CREATE PROCEDURE `insertar_moldes`(
            IN `pa_id_planta` INT,
            IN `pa_id_vitola` INT,
            IN `pa_id_figura` INT,
            IN `pa_bueno` INT,
            IN `pa_irregular` INT,
            IN `pa_malo` INT,
            IN `pa_bodega` INT,
            IN `pa_reparacion` INT,
            IN `pa_salon` INT,
            IN `pa_fivi` VARCHAR(50)
        )
BEGIN
                        DECLARE `suma_estado`INT;
                        DECLARE `suma_ubicacion` INT; 
                        
                        SET suma_estado = pa_bueno+ pa_irregular+ pa_malo;
                        SET suma_ubicacion = pa_bodega + pa_reparacion + pa_salon;
                        
                        if  EXISTS(SELECT * FROM (SELECT  CONCAT(figura_tipos.nombre_figura, "  ",vitolas.vitola) AS fivi
                            FROM plantas, moldes, figura_tipos, vitolas WHERE "1" = plantas.id_planta AND
                            moldes.id_planta = "1" AND vitolas.id_planta = plantas.id_planta and figura_tipos.id_planta = plantas.id_planta 
                            AND moldes.id_figura = figura_tipos.id_figura AND
                            moldes.id_vitola = vitolas.id_vitola )x WHERE x.fivi = pa_fivi) then
                        
                        
                         SELECT "ya existe"; 
                        
                        ELSE 
                        if  suma_estado = suma_ubicacion then
                        
                        INSERT INTO moldes(moldes.id_planta, moldes.id_vitola, moldes.id_figura,
                         moldes.bueno, moldes.irregulares,moldes.malos, moldes.bodega,moldes.reparacion,moldes.salon, moldes.total)
                         VALUES(pa_id_planta, pa_id_vitola,pa_id_figura, pa_bueno, pa_irregular, pa_malo, pa_bodega, pa_reparacion, pa_salon, suma_estado);
                       
                        
                        ELSE 
                        
                                  SELECT "no se puede";
                                  END if ;
                                  END if; 
                          END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.insertar_moldes_planta2
DELIMITER //
CREATE PROCEDURE `insertar_moldes_planta2`(
            IN `pa_id_planta` INT,
            IN `pa_id_vitola` INT,
            IN `pa_id_figura ` INT,
            IN `pa_bueno ` INT,
            IN `pa_irregular` INT,
            IN `pa_malo ` INT,
            IN ` pa_bodega ` INT,
            IN `pa_reparacion` INT,
            IN ` pa_salon ` INT,
            IN ` pa_fivi` VARCHAR(50)
        )
BEGIN
           DECLARE suma_estado INT;
                        DECLARE suma_ubicacion INT; 
                        
                        
                        SET suma_estado = pa_bueno+ pa_irregular+ pa_malo;
                        SET suma_ubicacion = pa_bodega + pa_reparacion + pa_salon;
                        
                        if  EXISTS(SELECT * FROM (SELECT  CONCAT(figura_tipos.nombre_figura, "  "  ,vitolas.vitola) AS fivi
                            FROM plantas, moldes, figura_tipos, vitolas WHERE "2" = plantas.id_planta AND
                            moldes.id_planta = "2" AND vitolas.id_planta = plantas.id_planta and figura_tipos.id_planta = plantas.id_planta 
                            AND moldes.id_figura = figura_tipos.id_figura AND
                            moldes.id_vitola = vitolas.id_vitola )x WHERE x.fivi = pa_fivi) then
                        
                        
                         SELECT "ya existe"; 
                        
                        ELSE 
                        if  suma_estado = suma_ubicacion then
                        
                        INSERT INTO moldes(moldes.id_planta, moldes.id_vitola, moldes.id_figura,
                         moldes.bueno, moldes.irregulares,moldes.malos, moldes.bodega,moldes.reparacion,moldes.salon, moldes.total)
                         VALUES(pa_id_planta, pa_id_vitola,pa_id_figura, pa_bueno, pa_irregular, pa_malo, pa_bodega, pa_reparacion, pa_salon, suma_estado);
                       
                        
                        ELSE 
                        
                                  SELECT "no se puede";
                                  END if ;
                                  END if; 
        END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.insertar_moldes_planta3
DELIMITER //
CREATE PROCEDURE `insertar_moldes_planta3`(
            IN `pa_id_planta` INT,
            IN `pa_id_vitola` INT,
            IN `pa_id_figura ` INT,
            IN `pa_bueno ` INT,
            IN `pa_irregular` INT,
            IN `pa_malo ` INT,
            IN ` pa_bodega ` INT,
            IN `pa_reparacion` INT,
            IN ` pa_salon ` INT,
            IN ` pa_fivi` VARCHAR(50)
        )
BEGIN
           DECLARE suma_estado INT;
                        DECLARE suma_ubicacion INT; 
                        
                        
                        SET suma_estado = pa_bueno+ pa_irregular+ pa_malo;
                        SET suma_ubicacion = pa_bodega + pa_reparacion + pa_salon;
                        
                        if  EXISTS(SELECT * FROM (SELECT  CONCAT(figura_tipos.nombre_figura, "  "  ,vitolas.vitola) AS fivi
                            FROM plantas, moldes, figura_tipos, vitolas WHERE "3" = plantas.id_planta AND
                            moldes.id_planta = "3" AND vitolas.id_planta = plantas.id_planta and figura_tipos.id_planta = plantas.id_planta 
                            AND moldes.id_figura = figura_tipos.id_figura AND
                            moldes.id_vitola = vitolas.id_vitola )x WHERE x.fivi = pa_fivi) then
                        
                        
                         SELECT "ya existe"; 
                        
                        ELSE 
                        if  suma_estado = suma_ubicacion then
                        
                        INSERT INTO moldes(moldes.id_planta, moldes.id_vitola, moldes.id_figura,
                         moldes.bueno, moldes.irregulares,moldes.malos, moldes.bodega,moldes.reparacion,moldes.salon, moldes.total)
                         VALUES(pa_id_planta, pa_id_vitola,pa_id_figura, pa_bueno, pa_irregular, pa_malo, pa_bodega, pa_reparacion, pa_salon, suma_estado);
                       
                        
                        ELSE 
                        
                                  SELECT "no se puede";
                                  END if ;
                                  END if; 
        END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.insertar_moldes_planta4
DELIMITER //
CREATE PROCEDURE `insertar_moldes_planta4`(
            IN `pa_id_planta` INT,
            IN `pa_id_vitola` INT,
            IN `pa_id_figura ` INT,
            IN `pa_bueno ` INT,
            IN `pa_irregular` INT,
            IN `pa_malo ` INT,
            IN ` pa_bodega ` INT,
            IN `pa_reparacion` INT,
            IN ` pa_salon ` INT,
            IN ` pa_fivi` VARCHAR(50)
        )
BEGIN
           DECLARE suma_estado INT;
                        DECLARE suma_ubicacion INT; 
                        
                        
                        SET suma_estado = pa_bueno+ pa_irregular+ pa_malo;
                        SET suma_ubicacion = pa_bodega + pa_reparacion + pa_salon;
                        
                        if  EXISTS(SELECT * FROM (SELECT  CONCAT(figura_tipos.nombre_figura, "  "  ,vitolas.vitola) AS fivi
                            FROM plantas, moldes, figura_tipos, vitolas WHERE "4" = plantas.id_planta AND
                            moldes.id_planta = "4" AND vitolas.id_planta = plantas.id_planta and figura_tipos.id_planta = plantas.id_planta 
                            AND moldes.id_figura = figura_tipos.id_figura AND
                            moldes.id_vitola = vitolas.id_vitola )x WHERE x.fivi = pa_fivi) then
                        
                        
                         SELECT "ya existe"; 
                        
                        ELSE 
                        if  suma_estado = suma_ubicacion then
                        
                        INSERT INTO moldes(moldes.id_planta, moldes.id_vitola, moldes.id_figura,
                         moldes.bueno, moldes.irregulares,moldes.malos, moldes.bodega,moldes.reparacion,moldes.salon, moldes.total)
                         VALUES(pa_id_planta, pa_id_vitola,pa_id_figura, pa_bueno, pa_irregular, pa_malo, pa_bodega, pa_reparacion, pa_salon, suma_estado);
                       
                        
                        ELSE 
                        
                                  SELECT "no se puede";
                                  END if ;
                                  END if; 
        END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.insertar_remisiones
DELIMITER //
CREATE PROCEDURE `insertar_remisiones`(
            IN `pa_fecha` DATE,
            IN `pa_id_planta` INT,
            IN `pa_nombre_fabrica` VARCHAR(50),
            IN `pa_estado_moldes` VARCHAR(50),
            IN `pa_tipo_moldes` VARCHAR(50),
            IN `pa_cantidad` INT,
            IN `pa_chequear` INT
        )
BEGIN
         
          INSERT INTO remisiones(remisiones.fecha,remisiones.id_planta, remisiones.nombre_fabrica,
          remisiones.estado_moldes,remisiones.tipo_moldes,remisiones.cantidad,remisiones.chequear)
                  VALUES(pa_fecha,pa_id_planta, pa_nombre_fabrica,
                              pa_estado_moldes,pa_tipo_moldes,pa_cantidad,pa_chequear);
                    
        END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.insertar_totales_plantas
DELIMITER //
CREATE PROCEDURE `insertar_totales_plantas`(
            IN `pa_figura_vitola` VARCHAR(50)
        )
BEGIN
                
                
                 INSERT INTO totales_plantas(SELECT pa_figura_vitola, SUM(x.bueno) AS total_bueno, SUM(x.irregulares) AS total_irregulares, SUM(x.malos) AS total_malo,
                SUM(x.bodega) AS total_bodega, SUM(x.reparacion) AS total_reparacion, SUM(x.salon) AS total_salon  FROM  ((SELECT  plantas.nombre_planta, vitolas.vitola, figura_tipos.nombre_figura, moldes.bueno,  moldes.irregulares, moldes.malos, 
                                    moldes.bodega, moldes.reparacion, moldes.salon, moldes.id_molde, moldes.total
                                    FROM plantas, moldes, figura_tipos, vitolas WHERE "1" = plantas.id_planta AND
                                    moldes.id_planta = plantas.id_planta AND vitolas.id_planta = plantas.id_planta and figura_tipos.id_planta = plantas.id_planta 
                                    AND moldes.id_figura = figura_tipos.id_figura AND
                                    moldes.id_vitola = vitolas.id_vitola)
                                    UNION 
                                 ( SELECT  plantas.nombre_planta, vitolas.vitola, figura_tipos.nombre_figura, moldes.bueno,  moldes.irregulares, moldes.malos, 
                                    moldes.bodega, moldes.reparacion, moldes.salon, moldes.id_molde, moldes.total
                                    FROM plantas, moldes, figura_tipos, vitolas WHERE "2" = plantas.id_planta AND
                                    moldes.id_planta = plantas.id_planta AND vitolas.id_planta = plantas.id_planta and figura_tipos.id_planta = plantas.id_planta 
                                    AND moldes.id_figura = figura_tipos.id_figura AND
                                    moldes.id_vitola = vitolas.id_vitola )
                                          UNION 
                                          ( SELECT  plantas.nombre_planta, vitolas.vitola, figura_tipos.nombre_figura, moldes.bueno,  moldes.irregulares, moldes.malos, 
                                    moldes.bodega, moldes.reparacion, moldes.salon, moldes.id_molde, moldes.total
                                    FROM plantas, moldes, figura_tipos, vitolas WHERE "3" = plantas.id_planta AND
                                    moldes.id_planta = plantas.id_planta AND vitolas.id_planta = plantas.id_planta and figura_tipos.id_planta = plantas.id_planta 
                                    AND moldes.id_figura = figura_tipos.id_figura AND
                                    moldes.id_vitola = vitolas.id_vitola )
                                          UNION 
                                          ( SELECT  plantas.nombre_planta, vitolas.vitola, figura_tipos.nombre_figura, moldes.bueno,  moldes.irregulares, moldes.malos, 
                                    moldes.bodega, moldes.reparacion, moldes.salon, moldes.id_molde, moldes.total
                                    FROM plantas, moldes, figura_tipos, vitolas WHERE "4" = plantas.id_planta AND
                                    moldes.id_planta = plantas.id_planta AND vitolas.id_planta = plantas.id_planta and figura_tipos.id_planta = plantas.id_planta 
                                    AND moldes.id_figura = figura_tipos.id_figura AND
                                    moldes.id_vitola = vitolas.id_vitola ))x
                                          WHERE concat(x.nombre_figura,"  " , x.vitola) = pa_figura_vitola);
                                
      END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.insertar_usuarios
DELIMITER //
CREATE PROCEDURE `insertar_usuarios`(
	IN `pa_codigo` VARCHAR(50),
	IN `pa_nombre_usuario` VARCHAR(50),
	IN `pa_correo` VARCHAR(50),
	IN `pa_id_planta` INT,
	IN `pa_contrasenia` VARCHAR(1000)
)
BEGIN
 
  INSERT INTO users(users.codigo,users.nombre_usuario, users.correo,
  users.id_planta,users.contrasenia)
  
		  VALUES(pa_codigo,pa_nombre_usuario, pa_correo,
		  			pa_id_planta,pa_contrasenia);
            
END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.insertar_vitola
DELIMITER //
CREATE PROCEDURE `insertar_vitola`(
            IN `pa_id_planta` INT,
            IN `pa_nombre_vitola` VARCHAR(50)
        )
BEGIN
        
        if EXISTS(SELECT * FROM vitolas WHERE pa_nombre_vitola = vitolas.vitola ) then 
        
        SELECT "esta vitola ya exista";
        
        ELSE
        INSERT INTO vitolas(vitolas.vitola, vitolas.id_planta) VALUES(pa_nombre_vitola,pa_id_planta);
        
        
        
        END if ;
        
        
        END//
DELIMITER ;

-- Volcando estructura para tabla inventario_movil_plasencia.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=215 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla inventario_movil_plasencia.migrations: ~39 rows (aproximadamente)
DELETE FROM `migrations`;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(117, '2021_02_08_142211_insertar_moldes', 1),
	(126, '2021_02_10_215045_mostrar_moldes_actualizar', 1),
	(178, '2014_10_12_000000_create_users_table', 2),
	(179, '2014_10_12_100000_create_password_resets_table', 2),
	(180, '2019_08_19_000000_create_failed_jobs_table', 2),
	(181, '2021_02_03_141039_create_figura_tipos_table', 2),
	(182, '2021_02_03_141302_create_vitolas_table', 2),
	(183, '2021_02_03_141334_create_plantas_table', 2),
	(184, '2021_02_05_141118_create_moldes_table', 2),
	(185, '2021_02_08_165033_mostrar_figuras', 2),
	(186, '2021_02_08_165431_mostrar_vitolas', 2),
	(187, '2021_02_08_171943_insertar_tabla_moldes', 2),
	(188, '2021_02_09_145639_traer_id_vitola', 2),
	(189, '2021_02_09_145658_traer_id_figura', 2),
	(190, '2021_02_10_205619_insertar_vitola', 2),
	(191, '2021_02_10_205633_insertar_figura', 2),
	(192, '2021_02_10_214850_actualizar_moldes', 2),
	(193, '2021_02_15_090620_mostrar_sucursal', 2),
	(194, '2021_02_16_085116_mostrar_usuarios', 2),
	(195, '2021_02_16_093502_actualizar_usuarios', 2),
	(196, '2021_02_16_113807_eliminar_usuario', 2),
	(197, '2021_02_17_101438_moldes_paraiso', 2),
	(198, '2021_02_17_152345_create_totales_plantas', 2),
	(199, '2021_02_17_153436_insertar_totales_plantas', 2),
	(200, '2021_02_17_154516_distinto_molde', 2),
	(201, '2021_02_17_192651_mostrar_total_plantas', 2),
	(202, '2021_02_18_081213_create_tabla_usuarios', 2),
	(203, '2021_02_18_090447_insertar_moldes_planta2', 2),
	(204, '2021_02_18_090901_insertar_moldes_planta3', 2),
	(205, '2021_02_18_090912_insertar_moldes_planta4', 2),
	(206, '2021_02_18_091731_mostrar_datos_moldes', 2),
	(207, '2021_02_18_091747_mostrar_datos_actualizar', 2),
	(208, '2021_02_18_093622_moldes_moroceli', 2),
	(209, '2021_02_18_093636_moldes_san_marcos', 2),
	(210, '2021_02_18_093649_moldes_gualiqueme', 2),
	(211, '2021_02_22_084346_insertar_remisiones', 3),
	(212, '2021_02_22_084458_mostrar_remisiones_recibidas', 3),
	(213, '2021_02_22_084542_mostrar_remisiones_enviadas', 3),
	(214, '2021_02_22_085126_moldes_remision', 3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Volcando estructura para tabla inventario_movil_plasencia.mobiliario
CREATE TABLE IF NOT EXISTS `mobiliario` (
  `id_mobiliario` int(11) NOT NULL AUTO_INCREMENT,
  `id_planta` int(11) NOT NULL,
  `id_depto` int(11) NOT NULL DEFAULT '0',
  `id_area` int(11) NOT NULL DEFAULT '0',
  `nombre_mobiliario` varchar(50) NOT NULL DEFAULT '0',
  `cant_mobiliario` int(11) NOT NULL DEFAULT '0',
  `descripcion_mobiliario` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_mobiliario`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla inventario_movil_plasencia.mobiliario: 5 rows
DELETE FROM `mobiliario`;
/*!40000 ALTER TABLE `mobiliario` DISABLE KEYS */;
INSERT INTO `mobiliario` (`id_mobiliario`, `id_planta`, `id_depto`, `id_area`, `nombre_mobiliario`, `cant_mobiliario`, `descripcion_mobiliario`) VALUES
	(1, 1, 1, 1, 'chaveta', 45, 'filudas'),
	(2, 1, 31, 3, 'cenicero', 7, 'blancos'),
	(3, 1, 1, 1, 'goma', 6, 'simple'),
	(4, 1, 29, 1, 'chaveta', 5, 'blancos'),
	(5, 1, 33, 5, 'mesas', 25, 'blanca');
/*!40000 ALTER TABLE `mobiliario` ENABLE KEYS */;

-- Volcando estructura para procedimiento inventario_movil_plasencia.mobiliario_paraiso
DELIMITER //
CREATE PROCEDURE `mobiliario_paraiso`(
	IN `pa_depto` VARCHAR(50),
	IN `pa_area` VARCHAR(50)
)
BEGIN



        
        SELECT plantas.nombre_planta, departamento.nombre_depto, area.nombre_area, mobiliario.nombre_mobiliario,  mobiliario.cant_mobiliario, mobiliario.descripcion_mobiliario, 
        mobiliario.id_mobiliario
        FROM mobiliario, area, departamento, plantas WHERE  plantas.id_planta = "1" AND
        mobiliario.id_planta = plantas.id_planta AND departamento.id_planta = plantas.id_planta and area.id_planta = plantas.id_planta AND mobiliario.id_area = area.id_area AND
        mobiliario.id_depto = departamento.id_depto AND departamento.nombre_depto LIKE CONCAT("%", pa_depto, "%") AND area.nombre_area LIKE CONCAT("%", pa_area, "%")      ;
        
          
          
      



END//
DELIMITER ;

-- Volcando estructura para tabla inventario_movil_plasencia.moldes
CREATE TABLE IF NOT EXISTS `moldes` (
  `id_molde` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_planta` int(11) NOT NULL,
  `id_vitola` int(11) NOT NULL,
  `id_figura` int(11) NOT NULL,
  `bueno` int(11) NOT NULL,
  `irregulares` int(11) NOT NULL,
  `malos` int(11) NOT NULL,
  `reparacion` int(11) NOT NULL,
  `bodega` int(11) NOT NULL,
  `salon` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_molde`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla inventario_movil_plasencia.moldes: ~5 rows (aproximadamente)
DELETE FROM `moldes`;
/*!40000 ALTER TABLE `moldes` DISABLE KEYS */;
INSERT INTO `moldes` (`id_molde`, `id_planta`, `id_vitola`, `id_figura`, `bueno`, `irregulares`, `malos`, `reparacion`, `bodega`, `salon`, `total`, `created_at`, `updated_at`) VALUES
	(1, 1, 2, 1, 0, 0, 1, 0, 1, 0, 1, NULL, NULL),
	(2, 1, 1, 1, 0, 12, 0, 0, 0, 12, 12, NULL, NULL),
	(3, 1, 3, 3, 0, 0, 2, 2, 0, 0, 2, NULL, NULL),
	(4, 1, 4, 2, 0, 2, 0, 0, 0, 2, 2, NULL, NULL),
	(5, 1, 4, 3, 0, 2, 0, 0, 0, 2, 2, NULL, NULL);
/*!40000 ALTER TABLE `moldes` ENABLE KEYS */;

-- Volcando estructura para procedimiento inventario_movil_plasencia.moldes_gualiqueme
DELIMITER //
CREATE PROCEDURE `moldes_gualiqueme`(
            IN `pa_vitola ` VARCHAR(50),
            IN `pa_figura` VARCHAR(50)
        )
BEGIN
          SELECT  plantas.nombre_planta, vitolas.vitola, figura_tipos.nombre_figura, moldes.bueno,  moldes.irregulares, moldes.malos, 
                moldes.bodega, moldes.reparacion, moldes.salon,moldes.total, moldes.id_molde
                FROM plantas, moldes, figura_tipos, vitolas WHERE  plantas.id_planta = "4" AND
                moldes.id_planta = plantas.id_planta AND vitolas.id_planta = plantas.id_planta and figura_tipos.id_planta = plantas.id_planta AND moldes.id_figura = figura_tipos.id_figura AND
                moldes.id_vitola = vitolas.id_vitola AND vitolas.vitola LIKE CONCAT("%", pa_vitola, "%") AND figura_tipos.nombre_figura LIKE CONCAT("%", pa_figura, "%")      ;
                
        END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.moldes_moroceli
DELIMITER //
CREATE PROCEDURE `moldes_moroceli`(
            IN `pa_vitola` VARCHAR(50),
            IN `pa_figura` VARCHAR(50)
        )
BEGIN
         
                SELECT  plantas.nombre_planta, vitolas.vitola, figura_tipos.nombre_figura, moldes.bueno,  moldes.irregulares, moldes.malos, 
                moldes.bodega, moldes.reparacion, moldes.salon,moldes.total, moldes.id_molde
                FROM plantas, moldes, figura_tipos, vitolas WHERE  plantas.id_planta = "2" AND
                moldes.id_planta = plantas.id_planta AND vitolas.id_planta = plantas.id_planta and figura_tipos.id_planta = plantas.id_planta AND moldes.id_figura = figura_tipos.id_figura AND
                moldes.id_vitola = vitolas.id_vitola AND vitolas.vitola LIKE CONCAT("%", pa_vitola, "%") AND figura_tipos.nombre_figura LIKE CONCAT("%", pa_figura, "%")      ;
                
        END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.moldes_paraiso
DELIMITER //
CREATE PROCEDURE `moldes_paraiso`(
	IN `pa_vitola` VARCHAR(50),
	IN `pa_figura` VARCHAR(50)
)
BEGIN
        
        SELECT  plantas.nombre_planta, vitolas.vitola, figura_tipos.nombre_figura, moldes.bueno,  moldes.irregulares, moldes.malos, 
        moldes.bodega, moldes.reparacion, moldes.salon,moldes.total, moldes.id_molde
        FROM plantas, moldes, figura_tipos, vitolas WHERE  plantas.id_planta = "1" AND
        moldes.id_planta = plantas.id_planta AND vitolas.id_planta = plantas.id_planta and figura_tipos.id_planta = plantas.id_planta AND moldes.id_figura = figura_tipos.id_figura AND
        moldes.id_vitola = vitolas.id_vitola AND vitolas.vitola LIKE CONCAT("%", pa_vitola, "%") AND figura_tipos.nombre_figura LIKE CONCAT("%", pa_figura, "%")      ;
        
          
          
        END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.moldes_remision
DELIMITER //
CREATE PROCEDURE `moldes_remision`(
            IN `pa_idplanta` INT
        )
BEGIN
        
        SELECT id_molde, CONCAT(figura_tipos.nombre_figura, "  ",vitolas.vitola) AS fivi
                                    FROM plantas, moldes, figura_tipos, vitolas WHERE "1" = plantas.id_planta AND
                                    moldes.id_planta = pa_idplanta AND vitolas.id_planta = plantas.id_planta and figura_tipos.id_planta = plantas.id_planta 
                                    AND moldes.id_figura = figura_tipos.id_figura AND
                                   moldes.id_vitola = vitolas.id_vitola ;      
        
        END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.moldes_sanMarcos
DELIMITER //
CREATE PROCEDURE `moldes_sanMarcos`(
            IN `pa_vitola` VARCHAR(50),
            IN `pa_figura` VARCHAR(50)
        )
BEGIN
                
                SELECT  plantas.nombre_planta, vitolas.vitola, figura_tipos.nombre_figura, moldes.bueno,  moldes.irregulares, moldes.malos, 
                moldes.bodega, moldes.reparacion, moldes.salon,moldes.total, moldes.id_molde
                FROM plantas, moldes, figura_tipos, vitolas WHERE  plantas.id_planta = "3" AND
                moldes.id_planta = plantas.id_planta AND vitolas.id_planta = plantas.id_planta and figura_tipos.id_planta = plantas.id_planta AND moldes.id_figura = figura_tipos.id_figura AND
                moldes.id_vitola = vitolas.id_vitola AND vitolas.vitola LIKE CONCAT("%", pa_vitola, "%") AND figura_tipos.nombre_figura LIKE CONCAT("%", pa_figura, "%")      ;
                
                  
                  
                END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.mostrar_area
DELIMITER //
CREATE PROCEDURE `mostrar_area`(
	IN `pa_id_planta` INT
)
BEGIN

SELECT area.id_area, area.nombre_area  FROM area WHERE area.id_planta = pa_id_planta;

END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.mostrar_datos_actualizar
DELIMITER //
CREATE PROCEDURE `mostrar_datos_actualizar`(
            IN `pa_id_molde` INT
        )
BEGIN
        
        
        
        SELECT moldes.bueno, moldes.irregulares, moldes.malos, moldes.reparacion, 
        moldes.bodega, moldes.salon,moldes.total
        FROM moldes 
        where moldes.id_molde = pa_id_molde;
        END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.mostrar_datos_moldes
DELIMITER //
CREATE PROCEDURE `mostrar_datos_moldes`(
            IN `pa_id_planta` INT
        )
BEGIN
                            SELECT  plantas.nombre_planta, vitolas.vitola, figura_tipos.nombre_figura, moldes.bueno,  moldes.irregulares, moldes.malos, 
                            moldes.bodega, moldes.reparacion, moldes.salon, moldes.id_molde, moldes.total
                            FROM plantas, moldes, figura_tipos, vitolas WHERE pa_id_planta = plantas.id_planta AND
                            moldes.id_planta = plantas.id_planta AND vitolas.id_planta = plantas.id_planta and figura_tipos.id_planta = plantas.id_planta 
                            AND moldes.id_figura = figura_tipos.id_figura AND
                            moldes.id_vitola = vitolas.id_vitola; 
                END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.mostrar_depto
DELIMITER //
CREATE PROCEDURE `mostrar_depto`(
	IN `pa_id_planta` INT
)
BEGIN

 SELECT departamento.id_depto, departamento.nombre_depto  FROM departamento WHERE departamento.id_planta = pa_id_planta;


END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.mostrar_figura_tipos
DELIMITER //
CREATE PROCEDURE `mostrar_figura_tipos`( IN `pa_id_planta` INT )
BEGIN
        
            SELECT figura_tipos.id_figura, figura_tipos.nombre_figura FROM figura_tipos 
            WHERE figura_tipos.id_planta = pa_id_planta;
            
        END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.mostrar_mobi
DELIMITER //
CREATE PROCEDURE `mostrar_mobi`()
BEGIN



  SELECT plantas.nombre_planta, departamento.nombre_depto, area.nombre_area,  mobiliario.nombre_mobiliario, mobiliario.cant_mobiliario, 
        mobiliario.descripcion_mobiliario
        FROM plantas, mobiliario, area, departamento WHERE  plantas.id_planta = mobiliario.id_planta;

END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.mostrar_mobiliario
DELIMITER //
CREATE PROCEDURE `mostrar_mobiliario`(
	IN `pa_id_planta` INT
)
BEGIN

   SELECT mobiliario.id_mobiliario, plantas.nombre_planta, departamento.nombre_depto, area.nombre_area,  mobiliario.nombre_mobiliario, mobiliario.cant_mobiliario, 
        mobiliario.descripcion_mobiliario
        FROM plantas, mobiliario, area, departamento WHERE  plantas.id_planta = pa_id_planta AND
        mobiliario.id_planta = plantas.id_planta AND mobiliario.id_depto = departamento.id_depto and mobiliario.id_area = area.id_area;
        
          



END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.mostrar_moldes_actualizar
DELIMITER //
CREATE PROCEDURE `mostrar_moldes_actualizar`(
            IN `pa_id_molde` INT
        )
BEGIN
        
        SELECT moldes.id_molde,plantas.nombre_planta, vitolas.vitola , figura_tipos.nombre_figura , moldes.bueno, moldes.irregulares, moldes.malos, moldes.reparacion, moldes.bodega
          , moldes.salon , moldes.total FROM  moldes, vitolas , figura_tipos, plantas where moldes.id_molde = pa_id_molde AND moldes.id_vitola = vitolas.id_vitola AND 
          figura_tipos.id_figura = moldes.id_figura AND plantas.id_planta = moldes.id_planta;
          
          
        END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.mostrar_remisiones_enviadas
DELIMITER //
CREATE PROCEDURE `mostrar_remisiones_enviadas`(
            IN `pa_id_planta` INT
        )
BEGIN
        SELECT remisiones.id_remision, remisiones.fecha,remisiones.nombre_fabrica,remisiones.estado_moldes,
         remisiones.tipo_moldes,remisiones.cantidad
          FROM remisiones
           WHERE remisiones.id_planta = pa_id_planta;
   END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.mostrar_remisiones_recibidas
DELIMITER //
CREATE PROCEDURE `mostrar_remisiones_recibidas`(
            IN `pa_nombre_fabrica` VARCHAR(50)
        )
BEGIN
        SELECT remisiones.id_remision, remisiones.id_planta, plantas.nombre_planta, remisiones.fecha,remisiones.nombre_fabrica,remisiones.estado_moldes,remisiones.tipo_moldes,remisiones.cantidad, remisiones.chequear
            FROM remisiones, plantas 
                 WHERE remisiones.nombre_fabrica = pa_nombre_fabrica AND plantas.id_planta = remisiones.id_planta;
   END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.mostrar_sucursal
DELIMITER //
CREATE PROCEDURE `mostrar_sucursal`()
BEGIN
                    
                        SELECT plantas.id_planta,plantas.nombre_planta FROM plantas;
                        
                    END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.mostrar_total_todas_plantas
DELIMITER //
CREATE PROCEDURE `mostrar_total_todas_plantas`()
BEGIN
        
        
        SELECT totales_plantas.figura_vitola, totales_plantas.total_bueno, totales_plantas.total_irregulares
        ,totales_plantas.total_malo,totales_plantas.total_bodega,totales_plantas.total_repacion,totales_plantas.total_salon FROM totales_plantas;
        
        
        END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.mostrar_usuarios
DELIMITER //
CREATE PROCEDURE `mostrar_usuarios`()
BEGIN

            SELECT  users.id_usuario, plantas.nombre_planta,  users.nombre_usuario, users.correo,users.codigo
                               FROM plantas, users WHERE users.id_planta = plantas.id_planta;
           
           END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.mostrar_vitolas
DELIMITER //
CREATE PROCEDURE `mostrar_vitolas`(IN `pa_id_planta` INT )
BEGIN
             SELECT vitolas.id_vitola, vitolas.vitola as nombre_vitola FROM vitolas WHERE vitolas.id_planta = pa_id_planta;
        END//
DELIMITER ;

-- Volcando estructura para tabla inventario_movil_plasencia.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla inventario_movil_plasencia.password_resets: ~0 rows (aproximadamente)
DELETE FROM `password_resets`;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Volcando estructura para tabla inventario_movil_plasencia.planta
CREATE TABLE IF NOT EXISTS `planta` (
  `id_planta` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_planta` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_planta`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla inventario_movil_plasencia.planta: 0 rows
DELETE FROM `planta`;
/*!40000 ALTER TABLE `planta` DISABLE KEYS */;
/*!40000 ALTER TABLE `planta` ENABLE KEYS */;

-- Volcando estructura para tabla inventario_movil_plasencia.plantas
CREATE TABLE IF NOT EXISTS `plantas` (
  `id_planta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_planta` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_planta`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla inventario_movil_plasencia.plantas: ~2 rows (aproximadamente)
DELETE FROM `plantas`;
/*!40000 ALTER TABLE `plantas` DISABLE KEYS */;
INSERT INTO `plantas` (`id_planta`, `nombre_planta`, `created_at`, `updated_at`) VALUES
	(1, 'paraiso', NULL, NULL),
	(2, 'Moroceli', NULL, NULL);
/*!40000 ALTER TABLE `plantas` ENABLE KEYS */;

-- Volcando estructura para tabla inventario_movil_plasencia.remisiones
CREATE TABLE IF NOT EXISTS `remisiones` (
  `id_remision` int(11) NOT NULL AUTO_INCREMENT,
  `id_planta` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `nombre_fabrica` varchar(50) NOT NULL,
  `estado_moldes` varchar(50) NOT NULL,
  `tipo_moldes` varchar(50) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `chequear` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_remision`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla inventario_movil_plasencia.remisiones: 20 rows
DELETE FROM `remisiones`;
/*!40000 ALTER TABLE `remisiones` DISABLE KEYS */;
INSERT INTO `remisiones` (`id_remision`, `id_planta`, `fecha`, `nombre_fabrica`, `estado_moldes`, `tipo_moldes`, `cantidad`, `chequear`) VALUES
	(1, 1, '2021-02-22', 'San Marcos', 'Buenos', 'cabeza 1  50x2', 12, 0),
	(2, 1, '2021-02-22', 'San Marcos', 'Buenos', 'cabeza 1  50x2', 12, 0),
	(3, 1, '2021-02-22', 'Gualiqueme', 'Irregulares', 'cabeza 1  50x2', 2, 0),
	(4, 2, '2021-02-22', 'El Paraiso', 'Buenos', 'cabeza 1  50x2', 12, 1),
	(5, 2, '2021-02-22', 'El Paraiso', 'Buenos', 'cabeza 1  50x2', 10, 0),
	(6, 1, '2021-02-23', 'San Marcos', 'Buenos', 'cabeza 1  50x2', 1, 0),
	(7, 3, '2021-02-23', 'Paraíso Cigar', 'Buenos', 'cabeza 1  50x2', 12, 0),
	(8, 1, '2021-02-23', 'Gualiqueme', 'Buenos', 'cabeza 1  50x2', 33, 0),
	(9, 1, '2021-02-24', 'San Marcos', 'Buenos', 'cabeza 1  50x2', 7, 0),
	(10, 1, '2021-02-24', 'San Marcos', 'Buenos', 'cabeza 1  50x2', 7, 0),
	(11, 1, '2021-02-24', 'San Marcos', 'Buenos', 'cabeza 1  50x2', 7, 0),
	(12, 1, '2021-02-24', 'San Marcos', 'Buenos', 'cabeza 1  50x2', 7, 0),
	(13, 1, '2021-02-24', 'San Marcos', 'Buenos', 'cabeza 1  50x2', 7, 0),
	(14, 1, '2021-02-24', 'San Marcos', 'Buenos', 'cabeza 1  50x2', 7, 0),
	(15, 1, '2021-02-24', 'San Marcos', 'Buenos', 'cabeza 1  50x2', 7, 0),
	(16, 1, '2021-02-24', 'San Marcos', 'Buenos', 'cabeza 1  50x2', 7, 0),
	(17, 1, '2021-02-24', 'San Marcos', 'Buenos', 'cabeza 1  50x2', 7, 0),
	(18, 1, '2021-02-24', 'San Marcos', 'Buenos', 'cabeza 1  50x2', 7, 0),
	(19, 1, '2021-02-24', 'San Marcos', 'Buenos', 'cabeza 1  50x2', 7, 0),
	(20, 1, '2021-02-24', 'San Marcos', 'Buenos', 'cabeza 1  50x2', 7, 0);
/*!40000 ALTER TABLE `remisiones` ENABLE KEYS */;

-- Volcando estructura para tabla inventario_movil_plasencia.totales_plantas
CREATE TABLE IF NOT EXISTS `totales_plantas` (
  `figura_vitola` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_bueno` int(11) NOT NULL,
  `total_irregulares` int(11) NOT NULL,
  `total_malo` int(11) NOT NULL,
  `total_bodega` int(11) NOT NULL,
  `total_repacion` int(11) NOT NULL,
  `total_salon` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla inventario_movil_plasencia.totales_plantas: ~3 rows (aproximadamente)
DELETE FROM `totales_plantas`;
/*!40000 ALTER TABLE `totales_plantas` DISABLE KEYS */;
INSERT INTO `totales_plantas` (`figura_vitola`, `total_bueno`, `total_irregulares`, `total_malo`, `total_bodega`, `total_repacion`, `total_salon`) VALUES
	('cabeza 1  50x2', 0, 0, 1, 1, 0, 0),
	('cabeza 1  50x1', 0, 12, 0, 0, 0, 12),
	('cabeza 3  50x3', 0, 0, 2, 0, 2, 0);
/*!40000 ALTER TABLE `totales_plantas` ENABLE KEYS */;

-- Volcando estructura para procedimiento inventario_movil_plasencia.traer_id_area
DELIMITER //
CREATE PROCEDURE `traer_id_area`(
	IN `pa_id_planta` INT,
	IN `pa_area` VARCHAR(50)
)
BEGIN

SELECT id_area FROM area where area.nombre_area = pa_area AND id_planta = pa_id_planta;


END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.traer_id_depto
DELIMITER //
CREATE PROCEDURE `traer_id_depto`(
	IN `pa_id_planta` INT,
	IN `pa_depto` VARCHAR(50)
)
BEGIN

SELECT id_depto FROM departamento where departamento.nombre_depto = pa_depto AND departamento.id_planta = pa_id_planta;


END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.traer_id_figura
DELIMITER //
CREATE PROCEDURE `traer_id_figura`(
            IN `pa_id_planta` INT,
            IN `pa_figura` VARCHAR(50)
        )
BEGIN
         SELECT id_figura FROM figura_tipos where figura_tipos.nombre_figura = pa_figura AND id_planta = pa_id_planta;
        END//
DELIMITER ;

-- Volcando estructura para procedimiento inventario_movil_plasencia.traer_id_vitola
DELIMITER //
CREATE PROCEDURE `traer_id_vitola`(
            IN `pa_id_planta` INT,
            IN `pa_vitola` VARCHAR(50)
        )
BEGIN
           SELECT id_vitola FROM vitolas where vitola = pa_vitola AND id_planta = pa_id_planta;
        END//
DELIMITER ;

-- Volcando estructura para tabla inventario_movil_plasencia.users
CREATE TABLE IF NOT EXISTS `users` (
  `id_usuario` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_usuario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `id_planta` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contrasenia` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_usuario`) USING BTREE,
  UNIQUE KEY `users_email_unique` (`nombre_usuario`) USING BTREE,
  UNIQUE KEY `codigo` (`codigo`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla inventario_movil_plasencia.users: ~1 rows (aproximadamente)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id_usuario`, `codigo`, `nombre_usuario`, `correo`, `email_verified_at`, `id_planta`, `contrasenia`, `remember_token`, `created_at`, `updated_at`) VALUES
	(3, '1234', 'yoselin soto', 'yosesoto1998@gmail.com', NULL, '1', '$2y$10$IpZ5LMuwQRw/R6r.J.6GpuZxge/KeUyyAVAXKiy3r93eBRbR8k5Sm', NULL, '2021-04-26 09:55:34', '2021-04-26 09:55:34');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Volcando estructura para tabla inventario_movil_plasencia.vitolas
CREATE TABLE IF NOT EXISTS `vitolas` (
  `id_vitola` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vitola` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_planta` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_vitola`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla inventario_movil_plasencia.vitolas: ~3 rows (aproximadamente)
DELETE FROM `vitolas`;
/*!40000 ALTER TABLE `vitolas` DISABLE KEYS */;
INSERT INTO `vitolas` (`id_vitola`, `vitola`, `id_planta`, `created_at`, `updated_at`) VALUES
	(1, '50x1', '1', NULL, NULL),
	(2, '50x2', '1', NULL, NULL),
	(3, '50x3', '1', NULL, NULL),
	(4, '5 x 50', '1', NULL, NULL);
/*!40000 ALTER TABLE `vitolas` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
