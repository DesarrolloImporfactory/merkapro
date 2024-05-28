<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
//echo 'funciona';
include 'sysadmin/vistas/db.php';
include 'sysadmin/vistas/php_conexion.php';


$tildes = $conexion->query("SET NAMES 'utf8'"); //Para que se inserten las tildes correctamente

mysqli_query($conexion, "ALTER TABLE `testimonios` ADD `id_producto` INT  NULL AFTER `date_added`;");
mysqli_query($conexion, "ALTER TABLE `perfil` ADD `habilitar_proveedor` INT  NULL AFTER `flotante`;");
mysqli_query($conexion, "ALTER TABLE `productos` ADD `tienda` VARCHAR(500)  NULL AFTER `valor4_producto`;");
mysqli_query($conexion, "ALTER TABLE `productos` ADD `drogshipin` INT  NULL DEFAULT '0' AFTER `tienda`;");
mysqli_query($conexion, "ALTER TABLE `productos` ADD `id_producto_origen` INT NULL AFTER `drogshipin`; ");
mysqli_query($conexion, "ALTER TABLE `provincia_laar` CHANGE `id_prov` `id_prov` SERIAL NOT NULL; ");
mysqli_query($conexion, "ALTER TABLE `provincia_laar` ADD `codigo_provincia` VARCHAR(500)  NULL AFTER `provincia`; ");
mysqli_query($conexion, "ALTER TABLE `provincia_laar` ADD `codigo_laar` VARCHAR(500)  NULL AFTER `provincia`;");
mysqli_query($conexion, "CREATE TABLE `ciudad_laar`(
  `id_ciudad` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50)  NULL,
  `nombre` varchar(150) NULL,
  `trayecto` varchar(10)  NULL,
  `provincia` varchar(100)  NULL,
  `codigoProvincia` varchar(100) NULL,
  `codigor` varchar(100) NULL,
  UNIQUE KEY `id_ciudad` (`id_ciudad`)
) ENGINE=InnoDB AUTO_INCREMENT=413 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;");

mysqli_query($conexion, "DELETE FROM `ciudad_laar`");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (20100101901, 'AMBATO', 'TP', 'TUNGURAHUA', '201001019', 16);");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (20100101902, 'BAÑOS DE AGUA SANTA', 'TE', 'TUNGURAHUA', '201001019', 16);");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001001, 'QUITO', 'TP', 'PICHINCHA', '201001001', 1);");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001002, 'CAYAMBE', 'TP', 'PICHINCHA', '201001001', 22);");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001003, 'TABACUNDO', 'TE', 'PICHINCHA', '201001001', 22); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001004, 'SANTO DOMINGO', 'TP', 'SANTO DOMINGO', '201001024', 45); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001005, 'SANGOLQUI', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001006, 'SAN RAFAEL', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001007, 'EL QUINCHE', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001008, 'MACHACHI', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001009, 'CUMBAYA', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001010, 'SAN MIGUEL DE LOS BANCOS', 'TE', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001011, 'LA CONCORDIA', 'TS', 'SANTO DOMINGO', '201001024', 56); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001012, 'PEDRO V. MALDONADO', 'TE', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001013, 'PUERTO QUITO', 'TE', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001014, 'GUAYLLABAMBA', 'TE', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001018, 'AMAGUAÑA', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001019, 'ALOAG', 'TE', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001020, 'TUMBACO', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001021, 'MITAD DEL MUNDO', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001022, 'CALACALI', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001024, 'CALDERON', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001025, 'PIFO', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001026, 'PUEMBO', 'TE', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001027, 'SAN ANTONIO IBARRA', 'TS', 'IMBABURA', '201001011', 67); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001028, 'POMASQUI', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001029, 'NANEGALITO', 'TE', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001030, 'MARCELINO MARIDUEÑA', 'TE', 'GUAYAS', '201001002', 57);  ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001031, 'ALANGASI', 'TS', 'PICHINCHA', '201001001', 1);  ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001032, '24 DE MAYO', 'TE', 'MANABI', '201001014', 40);  ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001033, 'CONOCOTO', 'TS', 'PICHINCHA', '201001001', 1);  ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001035, 'PEDRO MONCAYO', 'TE', 'PICHINCHA', '201001001', 22);  ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001036, 'PINTAG', 'TS', 'PICHINCHA', '201001001', 1);  ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001037, 'YARUQUI', 'TS', 'PICHINCHA', '201001001', 1);  ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001039, 'VALLE DE LOS CHILLOS', 'TS', 'PICHINCHA', '201001001', 1);  ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001040, 'VALLE HERMOSO', 'TE', 'SANTO DOMINGO', '201001024', 56);  ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001041, 'PUSUQUI', 'TS', 'PICHINCHA', '201001001', 1);  ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001042, 'AYORA', 'TE', 'PICHINCHA', '201001001', 22);  ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001043, 'AZCASUBI VIA AL QUINCHE', 'TE', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001045, 'JUAN MONTALVO', 'TE', 'PICHINCHA', '201001001', 22); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001046, 'ALOASI', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001047, 'LA ARMENIA', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001048, 'LLANO CHICO', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001049, 'LLANO GRANDE', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001051, 'MIRAVALLE', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001052, 'ORQUIDEAS', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001053, 'SAN ANTONIO DE PICHINCHA', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001054, 'SAN JOSE DE MORAN', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001056, 'TABABELA', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001057, 'UYUMBICHO', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001058, 'ZAMBISA', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001059, 'MONTERREY', 'TE', 'SANTO DOMINGO', '201001024', 56); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001060, 'LAS VILLEGAS', 'TE', 'SANTO DOMINGO', '201001024', 56); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001061, 'CUZUBAMBA', 'TE', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001062, 'ASCAZUBI', 'TE', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001063, 'CHECA', 'TE', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001064, 'Zambiza', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001065, 'Rumipamba', 'TP', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001066, 'RumiÃ±ahui', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001067, 'OtÃ³n', 'TE', 'PICHINCHA', '201001001', 22); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001068, 'Nono', 'TE', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001069, 'Mejía', 'TE', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001070, 'Guangopolo', 'TE', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001001071, 'El Chaupi', 'TE', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002001, 'GUAYAQUIL', 'TP', 'GUAYAS', '201001002', 11); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002002, 'DURAN', 'TS', 'GUAYAS', '201001002', 11); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002003, 'MILAGRO', 'TS', 'GUAYAS', '201001002', 57); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002004, 'SALINAS', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002005, 'PLAYAS', 'TE', 'GUAYAS', '201001002', 70); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002006, 'YAGUACHI', 'TE', 'GUAYAS', '201001002', 11); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002007, 'EL TRIUNFO', 'TE', 'GUAYAS', '201001002', 57); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002009, 'DAULE', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002010, 'SANTA ELENA', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002011, 'EL EMPALME', 'TE', 'LOS RIOS', '201001013', 42); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002013, 'LA LIBERTAD', 'TP', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002014, 'BALAO', 'TE', 'GUAYAS', '201001002', 65); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002015, 'NARANJAL', 'TE', 'GUAYAS', '201001002', 65); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002016, 'BALZAR', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002017, 'TENGUEL', 'TE', 'GUAYAS', '201001002', 65); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002018, 'JUJAN', 'TE', 'GUAYAS', '201001002', 19); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002019, 'SAMBORONDON', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002020, 'PASCUALES', 'TE', 'GUAYAS', '201001002', 11); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002021, 'NOBOL', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002022, 'PALESTINA', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002023, 'SANTA LUCIA', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002024, 'LOMAS DE SARGENTILLO', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002025, 'ISIDRO AYORA', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002027, 'CERECITA', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002028, 'PUERTO INCA', 'TE', 'GUAYAS', '201001002', 65); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002029, 'COLIMES', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002030, 'LAUREL', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002031, 'SALITRE', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002032, 'CHONGON', 'TE', 'GUAYAS', '201001002', 70); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002033, 'NARANJITO', 'TE', 'GUAYAS', '201001002', 57); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002034, 'ANCON', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002035, 'POSORJA', 'TE', 'GUAYAS', '201001002', 70); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002036, 'PALENQUE', 'TE', 'LOS RIOS', '201001013', 19); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002037, 'BUCAY', 'TE', 'GUAYAS', '201001002', 57); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002038, 'SIMON BOLIVAR', 'TE', 'GUAYAS', '201001002', 57); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002039, 'Km 26 via Duran Tambo', 'TE', 'GUAYAS', '201001002', 57); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002040, 'PEDRO CARBO', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002041, 'JULIO ANDRADE', 'TE', 'CARCHI', '201001006', 47); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002042, 'PROGRESO', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002043, 'MONJAS', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002046, 'ANCONCITO', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002048, 'BASE TAURA', 'TE', 'GUAYAS', '201001002', 57); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002049, 'EL DESEO', 'TE', 'GUAYAS', '201001002', 57); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002050, 'LORENZO DE GARAICOA', 'TE', 'GUAYAS', '201001002', 57); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002051, 'MARISCAL SUCRE', 'TE', 'GUAYAS', '201001002', 57); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002052, 'ROBERTO ASTUDILLO', 'TE', 'GUAYAS', '201001002', 57); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002053, 'MANUEL J. CALLE', 'TS', 'GUAYAS', '201001002', 57); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002054, 'CHIVERIA', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002055, 'COLORADAL', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002056, 'GENERAL VERNAZA', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002057, 'LA MARAVILLA', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002058, 'LAS ANIMAS', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002059, 'LOS TINTOS', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002060, 'PETRILLO', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002061, 'PUENTE LUCIA', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002062, 'SABANILLA', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002063, 'TARIFA', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002064, 'MATILDE ESTHER', 'TE', 'GUAYAS', '201001002', 57); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002065, 'BOCA DE CAÑA', 'TE', 'GUAYAS', '201001002', 11); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002066, 'SAMBORONDON (Pueblo)', 'TE', 'GUAYAS', '201001002', 11); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002067, 'BOLICHE', 'TE', 'GUAYAS', '201001002', 11); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002068, 'Virgen De FÃ¡tima Km 26', 'TE', 'GUAYAS', '201001002', 57); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002069, 'Velasco Ibarra (El Empalme)', 'TE', 'GUAYAS', '201001002', 42); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002070, 'San Antonio (Playas)', 'TE', 'GUAYAS', '201001002', 70); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002071, 'limonal', 'TE', 'GUAYAS', '201001002', 66); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002072, 'La Puntilla', 'TE', 'GUAYAS', '201001002', 11); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002073, 'Km 26 Virgen De FÃ¡tima', 'TE', 'GUAYAS', '201001002', 57); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002074, 'Ingenio San Carlos', 'TE', 'GUAYAS', '201001002', 57); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002075, 'General Villamil (Playas)', 'TE', 'GUAYAS', '201001002', 70); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002076, 'Eloy Alfaro DurÃ¡n', 'TE', 'GUAYAS', '201001002', 11); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002077, 'Data De Playas', 'TE', 'GUAYAS', '201001002', 70); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001002078, 'Cumanda Milagro', 'TE', 'GUAYAS', '201001002', 57); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003002, 'GIRON', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003003, 'GUALACEO', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003004, 'PAUTE', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003005, 'SANTA ISABEL', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003006, 'CHORDELEG', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003007, 'SIG SIG', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003008, 'PATATE', 'TE', 'TUNGURAHUA', '201001019', 16); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003009, 'EL TAMBO', 'TE', 'CAÑAR', '201001005', 18); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003011, 'CUENCA', 'TP', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003016, 'CHAULLABAMBA', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003017, 'CUMBE', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003018, 'YUNGUILLA', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003019, 'ZONA FRANCA', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003020, 'RICAURTE CUENCA', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003021, 'Llacao', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003022, 'Nulti', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003023, 'Paccha', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003024, 'San Fernando', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003025, 'San Joaquín', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003026, 'Sidcay', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003027, 'SimÃ³n Bolívar (Cab. en GaÃ±anzol)', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003028, 'Sinincay', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003029, 'Tomebamba', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003030, 'Turi', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003031, 'Victoria del Portete (Irquis)', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003032, 'Zhaglli (Shaglli)', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003033, 'Tarqui Cuenca', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003034, 'San Juan Cuenca', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003035, 'BaÃ±os Cuenca', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003036, 'Checa (Jidcay)', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003037, 'Chiquintad', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003038, 'Sosudel', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003039, 'Firma', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001003040, 'Sayausi', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001004001, 'GUARANDA', 'TP', 'BOLIVAR', '201001004', 29); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001004002, 'ECHEANDIA', 'TE', 'LOS RIOS', '201001013', 19); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001004003, 'SAN JOSE DE CHIMBO', 'TE', 'BOLIVAR', '201001004', 29); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001004006, 'SAN MIGUEL DE BOLIVAR', 'TE', 'BOLIVAR', '201001004', 29); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001004007, 'CALUMA', 'TE', 'LOS RIOS', '201001013', 19); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001004008, 'CHAMBO', 'TE', 'CHIMBORAZO', '201001008', 44); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001004011, 'SALINAS DE GUARANDA', 'TE', 'BOLIVAR', '201001004', 29); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001005001, 'AZOGUES', 'TP', 'CAÑAR', '201001005', 18); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001005002, 'LA TRONCAL', 'TE', 'CAÑAR', '201001005', 57); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001005003, 'CAÑAR', 'TP', 'CAÑAR', '201001005', 18); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001005004, 'BIBLIAN', 'TS', 'CAÑAR', '201001005', 18); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001005007, 'COJITAMBO', 'TE', 'CAÑAR', '201001005', 18); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001006001, 'TULCAN', 'TP', 'CARCHI', '201001006', 47); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001006002, 'MIRA', 'TE', 'CARCHI', '201001006', 67); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001006003, 'EL ANGEL', 'TE', 'CARCHI', '201001006', 47); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001006004, 'SAN GABRIEL', 'TE', 'CARCHI', '201001006', 47); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001006005, 'HUACA', 'TE', 'CARCHI', '201001006', 47); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001006006, 'BOLIVAR', 'TE', 'CARCHI', '201001006', 47); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001007001, 'LATACUNGA', 'TP', 'COTOPAXI', '201001007', 32); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001007002, 'SALCEDO', 'TS', 'COTOPAXI', '201001007', 32); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001007003, 'SAQUISILI', 'TE', 'COTOPAXI', '201001007', 32); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001007004, 'PUJILI', 'TE', 'COTOPAXI', '201001007', 32); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001007005, 'LA MANA', 'TE', 'LOS RIOS', '201001013', 42); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001007007, 'LASSO', 'TS', 'COTOPAXI', '201001007', 32); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001007008, 'PASTOCALLE', 'TE', 'COTOPAXI', '201001007', 32); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001007009, 'GUAYTACAMA', 'TE', 'COTOPAXI', '201001007', 32); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001007010, 'MULALO', 'TE', 'COTOPAXI', '201001007', 32); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001007011, 'TANICUCHI', 'TE', 'COTOPAXI', '201001007', 32); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001007012, 'BELISARIO QUEVEDO', 'TE', 'COTOPAXI', '201001007', 32); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001007013, 'SAN BUENAVENTURA BELLAVISTA. ', 'TE', 'COTOPAXI', '201001007', 32); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001007014, 'Tanicuchchi', 'TE', 'COTOPAXI', '201001007', 32); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001007015, 'Mulalao', 'TE', 'COTOPAXI', '201001007', 32); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001008001, 'RIOBAMBA', 'TP', 'CHIMBORAZO', '201001008', 44); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001008002, 'ALAUSI', 'TE', 'CHIMBORAZO', '201001008', 44); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001008003, 'CHUNCHI', 'TE', 'CHIMBORAZO','201001008', 44); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001008004, 'GUANO', 'TE', 'CHIMBORAZO', '201001008', 44); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001008005, 'CAJABAMBA', 'TE', 'CHIMBORAZO', '201001008', 44); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001008007, 'GUAMOTE', 'TE', 'CHIMBORAZO', '201001008', 44); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001008008, 'COLTA', 'TE', 'CHIMBORAZO', '201001008', 44); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001008010, 'LICAN', 'TE', 'CHIMBORAZO', '201001008', 44); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001008011, 'YARUQUIES', 'TE', 'CHIMBORAZO', '201001008', 44); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001008012, 'Cumanda Chimborazo', 'TE', 'CHIMBORAZO', '201001008', 57); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001009001, 'MACHALA', 'TP', 'EL ORO', '201001009', 36); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001009002, 'PASAJE', 'TE', 'EL ORO', '201001009', 36); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001009003, 'PORTOVELO', 'TE', 'EL ORO', '201001009', 36); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001009004, 'PIÑAS', 'TE', 'EL ORO', '201001009', 36); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001009005, 'ZARUMA', 'TE', 'EL ORO', '201001009', 36); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001009006, 'ARENILLAS', 'TE', 'EL ORO', '201001009', 36); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001009007, 'HUAQUILLAS', 'TE', 'EL ORO', '201001009', 36); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001009008, 'EL GUABO', 'TE', 'EL ORO', '201001009', 36); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001009009, 'SANTA ROSA', 'TE', 'EL ORO', '201001009', 36); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001009010, 'PUERTO BOLIVAR', 'TE', 'EL ORO', '201001009', 36); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001009011, 'EL CAMBIO', 'TE', 'EL ORO', '201001009', 36); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001009013, 'PONCE ENRIQUEZ', 'TE', 'AZUAY', '201001003', 65); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001009017, 'La PeaÃ±a', 'TE', 'EL ORO', '201001009', 36); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001009018, 'Loma De Franco', 'TE', 'EL ORO', '201001009', 36); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001009019, 'La Avanzada', 'TE', 'EL ORO', '201001009', 36); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001010001, 'ESMERALDAS', 'TP', 'ESMERALDAS', '201001010', 26); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001010003, 'ATACAMES', 'TS', 'ESMERALDAS', '201001010', 26);");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001010004, 'TONSUPA', 'TE', 'ESMERALDAS', '201001010', 26); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001010008, 'QUININDE', 'TP', 'ESMERALDAS', '201001010', 43); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001010009, 'PEDERNALES', 'TE', 'MANABI', '201001014', 39); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001010010, 'CUMANDA', 'TE', 'GUAYAS', '201001002', 57); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001010011, 'LA UNION', 'TE', 'ESMERALDAS', '201001010', 56); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001010013, 'VICHE', 'TE', 'ESMERALDAS', '201001010', 43); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001010016, 'TACHINA', 'TE', 'ESMERALDAS', '201001010', 26); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011001, 'ATUNTAQUI', 'TP', 'IMBABURA', '201001011', 67); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011002, 'OTAVALO', 'TP', 'IMBABURA', '201001011', 38); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011003, 'PIMAMPIRO', 'TE', 'IMBABURA', '201001011', 67); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011004, 'URCUQUI', 'TE', 'IMBABURA', '201001011', 30); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011005, 'IBARRA', 'TP', 'IMBABURA', '201001011', 30); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011006, 'COTACACHI', 'TE', 'IMBABURA', '201001011', 38); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011007, 'SAN PEDRO', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011009, 'ISLA BEJUCAL', 'TE', 'LOS RIOS', '201001013', 19); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011010, 'SAN PABLO IMBABURA', 'TE', 'IMBABURA', '201001011', 38); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011011, 'SAN ROQUE', 'TE', 'IMBABURA', '201001011', 67); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011012, 'GONZALEZ SUAREZ', 'TE', 'IMBABURA', '201001011', 38); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011013, 'PEGUCHE', 'TE', 'IMBABURA', '201001011', 38); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011014, 'QUIROGA', 'TE', 'IMBABURA', '201001011', 38); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011018, 'CARANQUI', 'TE', 'IMBABURA', '201001011', 30); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011019, 'YAGUARCOCHA', 'TS', 'IMBABURA', '201001011', 30); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011020, 'CHORLAVI', 'TS', 'IMBABURA', '201001011', 67); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011021, 'ANDRADE MARIN', 'TS', 'IMBABURA', '201001011', 67); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011022, 'ANTONIO ANTE', 'TS', 'IMBABURA', '201001011', 67); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011023, 'CHALTURA', 'TS', 'IMBABURA', '201001011', 67); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011025, 'NATABUELA', 'TS', 'IMBABURA', '201001011', 67); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011026, 'SAN JOSE', 'TS', 'IMBABURA', '201001011', 67); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011027, 'SAN LUIS', 'TS', 'IMBABURA', '201001011', 67); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011028, 'SANTA BERTHA', 'TS', 'IMBABURA', '201001011', 67); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011029, 'TIERRA BLANCA', 'TS', 'IMBABURA', '201001011', 67); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011030, 'PERUGACHI', 'TE', 'IMBABURA', '201001011', 38); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011031, 'San Miguel de Ibarra', 'TE', 'IMBABURA', '201001011', 30); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001011032, 'Quiroga Otavalo', 'TE', 'IMBABURA', '201001011', 38); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001012001, 'LOJA', 'TP', 'LOJA', '201001012', 34); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001012002, 'CATAMAYO', 'TE', 'LOJA', '201001012', 34); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001012003, 'CATARAMA', 'TE', 'LOS RIOS', '201001013', 19); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001012004, 'CARIAMANGA', 'TE', 'LOJA', '201001012', 34); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001012005, 'CATACOCHA', 'TE', 'LOJA', '201001012', 34); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001012006, 'MALACATOS', 'TE', 'LOJA', '201001012', 34); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001012007, 'VILCABAMBA', 'TE', 'LOJA', '201001012', 34); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001012009, 'SARAGURO', 'TE', 'LOJA', '201001012', 34); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001012010, 'GONZANAMA', 'TE', 'LOJA', '201001012', 34); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001012011, 'CELICA', 'TE', 'LOJA', '201001012', 34); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001012013, 'San Pedro de Vilcabamba', 'TE', 'LOJA', '201001012', 34); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001012014, 'San Pedro de La Bendita', 'TE', 'LOJA', '201001012', 34); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001012015, 'San Lucas', 'TE', 'LOJA', '201001012', 34); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001012016, 'Paltas', 'TE', 'LOJA', '201001012', 34); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001012017, 'Calvas', 'TE', 'LOJA', '201001012', 34); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013001, 'BABAHOYO', 'TP', 'LOS RIOS', '201001013', 19); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013002, 'QUEVEDO', 'TP', 'LOS RIOS', '201001013', 42); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013003, 'VENTANAS', 'TE', 'LOS RIOS', '201001013', 19); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013004, 'VALENCIA', 'TE', 'LOS RIOS', '201001013', 42); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013005, 'BUENA FE', 'TE', 'LOS RIOS', '201001013', 42); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013006, 'VINCES', 'TE', 'LOS RIOS', '201001013', 19); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013007, 'MOCACHE', 'TE', 'LOS RIOS', '201001013', 42); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013008, 'SAN JUAN', 'TE', 'LOS RIOS', '201001013', 19); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013009, 'MONTALVO', 'TE', 'LOS RIOS', '201001013', 19); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013010, 'PATRICIA PILAR', 'TS', 'LOS RIOS', '201001013', 45); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013012, 'PUEBLO VIEJO', 'TE', 'LOS RIOS', '201001013', 19); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013013, 'BABA', 'TE', 'LOS RIOS', '201001013', 19); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013014, 'SAN CAMILO', 'TE', 'LOS RIOS', '201001013', 42); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013015, 'SAN CARLOS', 'TE', 'LOS RIOS', '201001013', 42); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013016, 'RICAURTE LOS RIOS', 'TE', 'LOS RIOS', '201001013', 19); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013019, 'QUINSALOMA', 'TE', 'LOS RIOS', '201001013', 42); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013020, 'TRES POSTES', 'TE', 'GUAYAS', '201001002', 19); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013021, 'ISLA DE BEJUCAL', 'TE', 'LOS RIOS', '201001013', 19); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013022, 'San Juan Babahoyo', 'TE', 'LOS RIOS', '201001013', 19); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013023, 'San Jacinto de Buena Fe', 'TE', 'LOS RIOS', '201001013', 42); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013024, 'La UniÃ³n (Valencia)', 'TE', 'LOS RIOS', '201001013', 42); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013025, 'La Julia', 'TE', 'LOS RIOS', '201001013', 19); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013026, 'La Esperanza', 'TE', 'LOS RIOS', '201001013', 42); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001013027, 'Guare', 'TE', 'LOS RIOS', '201001013', 19); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014001, 'MANTA', 'TP', 'MANABI', '201001014', 37); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014002, 'PORTOVIEJO', 'TP', 'MANABI', '201001014', 40); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014003, 'BAHIA DE CARAQUEZ', 'TP', 'MANABI', '201001014', 20); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014004, 'CHONE', 'TS', 'MANABI', '201001014', 23); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014005, 'EL CARMEN', 'TP', 'MANABI', '201001014', 24); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014006, 'JIPIJAPA', 'TP', 'MANABI', '201001014', 60); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014007, 'PICHINCHA MANABI', 'TE', 'MANABI', '201001014', 42); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014008, 'SANTA ANA', 'TE', 'MANABI', '201001014', 40); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014009, 'JUNIN', 'TE', 'MANABI', '201001014', 23); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014010, 'CRUCITA', 'TE', 'MANABI', '201001014', 40); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014011, 'COLON', 'TE', 'MANABI', '201001014', 40); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014012, 'ROCAFUERTE', 'TE', 'MANABI', '201001014', 40); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014013, 'JARAMIJO', 'TE', 'MANABI', '201001014', 37); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014014, 'PAJAN', 'TE', 'MANABI', '201001014', 60); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014015, 'CHARAPOTO', 'TE', 'MANABI', '201001014', 40); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014016, 'CALCETA', 'TE', 'MANABI', '201001014', 23); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014017, 'TOSAGUA', 'TE', 'MANABI', '201001014', 23); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014018, 'SAN VICENTE', 'TE', 'MANABI', '201001014', 20); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014019, 'OLMEDO', 'TE', 'MANABI', '201001014', 40); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014020, 'MONTECRISTI', 'TE', 'MANABI', '201001014', 37); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014021, 'FLAVIO ALFARO', 'TE', 'MANABI', '201001014', 23); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014022, 'PUERTO LOPEZ', 'TE', 'MANABI', '201001014', 60); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014023, 'BALLENITA', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014024, 'JAMA', 'TE', 'MANABI', '201001014', 20); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014025, 'SAN JACINTO', 'TE', 'MANABI', '201001014', 11); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014026, 'TARQUI', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014027, 'LEONIDAS PLAZA', 'TE', 'MANABI', '201001014', 20); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014029, 'PUERTO CAYO', 'TE', 'MANABI', '201001014', 60); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014031, 'CALDERON DE PORTOVIEJO', 'TE', 'MANABI', '201001014', 40); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014032, 'CANUTO', 'TE', 'MANABI', '201001014', 23); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014033, 'ESTANCILLA', 'TE', 'MANABI', '201001014', 23); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014034, 'SAN ANTONIO DE CHONE', 'TE', 'MANABI', '201001014', 23); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014035, 'LA DELICIA KM. 29', 'TE', 'MANABI', '201001014', 24); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014036, 'ALAHUELA', 'TE', 'MANABI', '201001014', 40); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014037, 'PICOAZA (DENTRO DEL PERIMETRO URBANO)', 'TE', 'MANABI', '201001014', 40); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014038, 'SAN PLACIDO (DENTRO DEL PERIMETRO URBANO)', 'TE', 'MANABI', '201001014', 40); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014039, 'RIO CHICO (DENTRO DEL PERIMETRO URBANO)', 'TE', 'MANABI', '201001014', 40); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014040, 'RICAURTE MANABI', 'TE', 'MANABI', '201001014', 23); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014041, 'Tarqui Manabi', 'TE', 'MANABI', '201001014', 37); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014042, 'Sucre', 'TE', 'MANABI', '201001014', 20); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014043, 'Quiroga Chone', 'TE', 'MANABI', '201001014', 23); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001014044, 'colorado', 'TE', 'MANABI', '201001014', 37); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001015001, 'MACAS', 'TO', 'MORONA SANTIAGO', '201001015', 35); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001015002, 'GUALAQUIZA', 'TO', 'MORONA SANTIAGO', '201001015', 48); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001015003, 'YANTZAZA', 'TO', 'ZAMORA', '201001021', 48); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001016001, 'TENA', 'TO', 'NAPO', '201001016', 46); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001016002, 'OÑA', 'TE', 'AZUAY', '201001003', 15); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001016003, 'ARCHIDONA', 'TO', 'NAPO', '201001016', 46); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001016004, 'PTO. NAPO', 'TO', 'NAPO', '201001016', 46); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001016005, 'MISAHUALLI', 'TO', 'NAPO', '201001016', 46); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001016006, 'AROSEMENA TOLA', 'TO', 'NAPO', '201001016', 46); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001016007, 'Puerto Napo', 'TO', 'NAPO', '201001016', 46); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001016008, 'Carlos Julio Arosemena Tola', 'TO', 'NAPO', '201001016', 46); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001016009, 'Carlos Julio Arosemena', 'TO', 'NAPO', '201001016', 46); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001017001, 'FRANCISCO DE ORELLANA', 'TO', 'ORELLANA', '201001017', 25); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001017002, 'EL COCA', 'TO', 'ORELLANA', '201001017', 25); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001017003, 'LAGO AGRIO', 'TO', 'SUCUMBIOS', '201001022', 31); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001017004, 'SHELL', 'TO', 'PASTAZA', '201001018', 41); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001017006, 'LA JOYA DE LOS SACHAS', 'TO', 'ORELLANA', '201001017', 25); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001017007, 'SUCUA', 'TO', 'MORONA SANTIAGO', '201001015', 35); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001017009, 'NUEVO ISRAEL', 'TE', 'MANABI', '201001014', 24); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001017012, 'EL CHACO', 'TP', 'NAPO', '201001016', 71);");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001017016, 'LORETO', 'TO', 'ORELLANA', '201001017', 25); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001018001, 'PUYO', 'TO', 'PASTAZA', '201001018', 41);");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001019003, 'MACARA', 'TE', 'LOJA', '201001012', 34); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001019004, 'PELILEO', 'TE', 'TUNGURAHUA', '201001019', 16); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001019005, 'CEVALLOS', 'TE', 'TUNGURAHUA', '201001019', 16); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001019006, 'PILLARO', 'TE', 'TUNGURAHUA', '201001019', 16); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001019007, 'MOCHA', 'TE', 'TUNGURAHUA', '201001019', 16); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001019008, 'QUERO', 'TE', 'TUNGURAHUA', '201001019', 16); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001019009, 'TISALEO', 'TE', 'TUNGURAHUA', '201001019', 16); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001019011, 'HUAMBALO', 'TE', 'TUNGURAHUA', '201001019', 16); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001019012, 'Ulba', 'TE', 'TUNGURAHUA', '201001019', 16); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001019013, 'San Pedro De Pelileo', 'TE', 'TUNGURAHUA', '201001019', 16); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001019014, 'Betínez (Pachanlica)', 'TE', 'TUNGURAHUA', '201001019', 16); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001020001, 'PUERTO BAQUERIZO MORENO', 'TG', 'GALAPAGOS', '201001020', 27); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001020002, 'SANTA CRUZ', 'TG', 'GALAPAGOS', '201001020', 28); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001020003, 'SAN CRISTOBAL', 'TG', 'GALAPAGOS', '201001020', 27); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001021001, 'ZAMORA', 'TO', 'ZAMORA', '201001021', 48); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001021003, 'TAMBILLO', 'TS', 'PICHINCHA', '201001001', 1); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001021005, 'PANGUI', 'TO', 'ZAMORA', '201001021', 48); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001021006, 'CENTINELA DEL CONDOR', 'TO', 'ZAMORA', '201001021', 48); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001022001, 'NUEVA LOJA', 'TO', 'SUCUMBIOS', '201001022', 31); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001022002, 'SHUSHUFINDI', 'TO', 'SUCUMBIOS', '201001022', 31); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001023001, 'PUNTA CARNERO', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001023002, 'PUNTA BLANCA', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001023003, 'MONTAÑITA', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001023004, 'MAR BRAVO', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001023005, 'MUEY', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001023006, 'OLON', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001023007, 'PUERTO SANTA ROSA', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001023008, 'CADEATE', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001023009, 'CAPAES', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001023010, 'LIBERTADOR BOLIVAR', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001023011, 'MANGLARALTO', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001023012, 'MONTEVERDE', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001023013, 'PALMAR', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001023014, 'PROSPERIDAD', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001023015, 'PUNTA BARANDUA', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001023016, 'VALDIVIA', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001023017, 'SAN PABLO SANTA ELENA', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001023018, 'AYANGUE', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001023019, 'Punta Centinela', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001023020, 'El Tambo Santa Elena', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001023021, 'SANTA ROSA SANTA ELENA', 'TE', 'SANTA ELENA', '201001023', 33); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001024004, 'KM 14 QUEVEDO', 'TS', 'SANTO DOMINGO', '201001024', 45); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001024005, 'KM 24 QUEVEDO', 'TS', 'SANTO DOMINGO', '201001024', 45); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001024006, 'KM 38.5 QUEVEDO', 'TS', 'SANTO DOMINGO', '201001024', 45); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001024007, 'KM 41 QUEVEDO', 'TS', 'SANTO DOMINGO', '201001024', 45); ");
mysqli_query($conexion, "INSERT INTO ciudad_laar (codigo, nombre, trayecto, provincia, codigoProvincia, codigor) VALUES (201001024008, 'LUZ DE AMERICA', 'TS', 'SANTO DOMINGO', '201001024', 45); ");
mysqli_query($conexion, "DELETE FROM `provincia_laar`;");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('TUNGURAHUA', '201001019'); ");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('PICHINCHA', '201001001'); ");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('SANTO DOMINGO', '201001024'); ");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('IMBABURA', '201001011'); ");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('GUAYAS', '201001002'); ");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('MANABI', '201001014'); ");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('SANTA ELENA', '201001023'); ");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('LOS RIOS', '201001013'); ");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('CARCHI', '201001006'); ");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('AZUAY', '201001003'); ");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('CAÑAR', '201001005'); ");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('BOLIVAR', '201001004'); ");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('CHIMBORAZO', '201001008'); ");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('COTOPAXI', '201001007'); ");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('EL ORO', '201001009'); ");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('ESMERALDAS', '201001010'); ");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('LOJA', '201001012'); ");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('MORONA SANTIAGO', '201001015'); ");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('ZAMORA', '201001021'); ");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('NAPO', '201001016'); ");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('ORELLANA', '201001017'); ");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('SUCUMBIOS', '201001022'); ");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('PASTAZA', '201001018'); ");
mysqli_query($conexion, "INSERT INTO provincia_laar (provincia, codigo_provincia) VALUES ('GALAPAGOS', '201001020'); ");


mysqli_query($conexion, "ALTER TABLE `ciudad_laar` ADD `tipo` VARCHAR(100)  NULL AFTER `codigor`, ADD `costo` DOUBLE  NULL AFTER `tipo`, ADD `precio` DOUBLE  NULL AFTER `costo`; ");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001019007';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001019005';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001019008';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='20100101902';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001019004';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003008';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001019009';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001019011';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001019006';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001019014';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001019013';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001019012';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001003';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='PRINCIPAL', costo=2.8, precio=4.5 where codigo='201001001002';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001035';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001042';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001045';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='PRINCIPAL', costo=2.8, precio=4.5 where codigo='201001007001';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001007002';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001007003';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001007007';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001007009';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001007008';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001007010';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001007011';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001007012';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001007004';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001007015';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001007014';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='PRINCIPAL', costo=2.8, precio=4.5 where codigo='201001006001';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001006004';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001006003';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002041';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001006006';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001006005';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='PRINCIPAL', costo=2.8, precio=4.5 where codigo='201001011005';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001011018';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001011004';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001011031';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001011001';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001011021';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001011023';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001011027';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001011028';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001011029';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001011026';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001011025';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001011022';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001006002';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001011003';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001011011';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001011020';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='PRINCIPAL', costo=2.8, precio=4.5 where codigo='201001004001';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001004011';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001004003';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001004006';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='PRINCIPAL', costo=2.8, precio=4.5 where codigo='201001010001';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001010003';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001010004';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001010016';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='PRINCIPAL', costo=2.8, precio=4.5 where codigo='201001008001';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001008004';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001008005';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001008003';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001008010';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001008002';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001008007';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001008008';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001004008';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001008011';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001008012';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='PRINCIPAL', costo=2.8, precio=4.5 where codigo='201001001004';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001024008';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001013010';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001010009';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='PRINCIPAL', costo=2.8, precio=4.5 where codigo='201001011002';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001011006';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001011010';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001011032';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001011012';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001011030';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001011013';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='PRINCIPAL', costo=2.8, precio=4.5 where codigo='201001001001';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001031';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001019';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001046';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001018';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001033';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001009';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001014';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001047';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001048';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001049';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001008';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001051';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001021';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001002043';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001052';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001025';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001036';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001028';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001026';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001041';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001007';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001063';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001053';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001054';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001024';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001006';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001005';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001056';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001021003';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001020';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001057';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001039';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001037';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001058';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001013';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001012';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001010';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001029';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001022';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001061';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001071';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001070';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001069';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001068';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001067';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001066';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001065';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001064';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ORIENTE', costo=3.5, precio=5.5 where codigo='201001017012';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001001011';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001010011';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001059';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001040';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='PRINCIPAL', costo=2.8, precio=4.5 where codigo='201001014005';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001017009';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014035';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001010008';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001010013';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ORIENTE', costo=3.5, precio=5.5 where codigo='201001017006';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ORIENTE', costo=3.5, precio=5.5 where codigo='201001017016';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ORIENTE', costo=3.5, precio=5.5 where codigo='201001016001';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ORIENTE', costo=3.5, precio=5.5 where codigo='201001016003';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ORIENTE', costo=3.5, precio=5.5 where codigo='201001016005';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ORIENTE', costo=3.5, precio=5.5 where codigo='201001016006';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ORIENTE', costo=3.5, precio=5.5 where codigo='201001016009';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ORIENTE', costo=3.5, precio=5.5 where codigo='201001016008';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ORIENTE', costo=3.5, precio=5.5 where codigo='201001016007';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ORIENTE', costo=3.5, precio=5.5 where codigo='201001022002';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ORIENTE', costo=3.5, precio=5.5 where codigo='201001018001';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ORIENTE', costo=3.5, precio=5.5 where codigo='201001017004';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ORIENTE', costo=3.5, precio=5.5 where codigo='201001015001';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ORIENTE', costo=3.5, precio=5.5 where codigo='201001017007';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='PRINCIPAL', costo=2.8, precio=4.5 where codigo='201001005001';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001005004';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001005003';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003009';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='PRINCIPAL', costo=2.8, precio=4.5 where codigo='201001013001';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001013006';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002018';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002036';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001013020';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001011009';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001013013';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001004002';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001004007';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001013009';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001012003';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001013012';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001013016';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001013022';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001013003';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001013027';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001013025';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001014004';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001014016';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001014032';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001014033';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001014021';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001014040';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001014034';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001014009';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001014017';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='SECUNDARIO', costo=3.5, precio=5.5 where codigo='201001014043';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='PRINCIPAL', costo=2.8, precio=4.5 where codigo='201001003011';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003016';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003003';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003007';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003004';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003006';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003019';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003017';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003033';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003002';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003018';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003005';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001016002';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003021';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003022';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003023';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003024';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003025';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003026';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003027';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003028';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003029';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003030';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003031';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003032';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003034';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003036';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003037';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003040';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003039';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001003038';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='PRINCIPAL', costo=2.8, precio=4.5 where codigo='201001002001';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002002';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002072';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001010010';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002009';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002066';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002065';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002021';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002025';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002024';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002040';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002022';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002023';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002016';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002030';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002031';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002019';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002054';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002060';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002061';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002055';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002056';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002057';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002058';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002059';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002062';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002063';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002071';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002005';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002027';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002032';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002035';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002042';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002077';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002075';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002003';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002048';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002049';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002064';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002039';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002037';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002067';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002078';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002052';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002006';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002033';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002007';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001005002';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001030';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002053';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002038';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002051';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002050';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002074';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002068';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002015';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002014';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002017';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001009013';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002028';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='PRINCIPAL', costo=2.8, precio=4.5 where codigo='201001002013';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002010';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014023';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002004';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001023005';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001023007';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002034';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002046';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001023004';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001023001';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001023014';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001023011';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001023003';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001023006';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001023017';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001023002';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001023008';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001023009';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001023010';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001023012';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001023013';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001023015';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001011007';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001023016';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001023018';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001023020';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001023019';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='PRINCIPAL', costo=2.8, precio=4.5 where codigo='201001012001';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001012007';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001012002';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001012011';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001012009';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001012006';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001012010';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001019003';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001012017';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001012016';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001012015';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001012014';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001012013';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='PRINCIPAL', costo=2.8, precio=4.5 where codigo='201001009001';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001009004';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001009005';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001009003';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001009010';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001009006';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001009019';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001009002';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001009009';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001009007';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001009017';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001009011';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001009008';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001009018';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='PRINCIPAL', costo=2.8, precio=4.5 where codigo='201001014003';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014027';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014018';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014024';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014042';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='PRINCIPAL', costo=2.8, precio=4.5 where codigo='201001014001';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014020';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014013';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014044';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='PRINCIPAL', costo=2.8, precio=4.5 where codigo='201001014002';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014036';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014031';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014015';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014010';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014037';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014038';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014039';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014012';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001001032';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014019';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014008';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014011';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014006';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014029';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014022';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001014014';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='PRINCIPAL', costo=2.8, precio=4.5 where codigo='201001013002';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001013014';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001013005';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002011';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001007005';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001013004';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001013007';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001013019';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001013015';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001002069';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001013026';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001013024';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ESPECIAL', costo=3.5, precio=5.5 where codigo='201001013023';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ORIENTE', costo=3.5, precio=5.5 where codigo='201001021001';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ORIENTE', costo=3.5, precio=5.5 where codigo='201001015003';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ORIENTE', costo=3.5, precio=5.5 where codigo='201001021006';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='ORIENTE', costo=3.5, precio=5.5 where codigo='201001015002';");
mysqli_query($conexion, "UPDATE ciudad_laar SET tipo='PRINCIPAL', costo=2.8, precio=4.5 where codigo='20100101901';");
mysqli_query($conexion, "CREATE TABLE `origen_laar` (
  `id_origen` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `identificacion` varchar(100) NOT NULL,
  `provinciaO` varchar(100) NULL,
  `ciudadO` varchar(100) NULL,
  `nombreO` varchar(100)  NULL,
  `direccion` varchar(1200) NULL,
  `referencia` varchar(1200) NULL,
  `numeroCasa` varchar(100)  NULL,
  `postal` varchar(100) NULL,
  `telefono` varchar(15) NULL,
  `celular` varchar(15) NULL,
  UNIQUE KEY `id_origen` (`id_origen`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;");
mysqli_query($conexion, "INSERT INTO `origen_laar` (`id_origen`, `identificacion`, `provinciaO`, `ciudadO`, `nombreO`, `direccion`, `referencia`, `numeroCasa`, `postal`, `telefono`, `celular`) VALUES ('1', '99999999999', '201001001', '201001001001', 'Imporsuit', 'Biloxi', 'Biloxi', 's2556', '', '0999999998', '0999999999');");
mysqli_query($conexion, "ALTER TABLE `facturas_cot` ADD `guia_enviada` INT NULL DEFAULT '0' ; ");
mysqli_query($conexion, "ALTER TABLE `facturas_cot` ADD `transporte` VARCHAR(100) NULL AFTER `guia_enviada`; ");
mysqli_query($conexion, "CREATE TABLE `guia_laar`(
  `id_guia` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tienda` varchar(400)  NULL,
  `guia_sistema` varchar(400)  NULL,
  `guia_laar` varchar(400)  NULL,
  `fecha` datetime  NULL,
  `zpl` longtext  NULL,
    UNIQUE KEY `id_guia` (`id_guia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;");
mysqli_query($conexion, "ALTER TABLE `guia_laar` CHANGE `tienda` `tienda_venta` VARCHAR(400) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL; ");
mysqli_query($conexion, "ALTER TABLE `guia_laar` ADD `tienda_proveedor` VARCHAR(500) NULL AFTER `zpl`; ");
mysqli_query($conexion, "ALTER TABLE `guia_laar` ADD `url_guia` VARCHAR(400) NULL AFTER `tienda_proveedor`; ");
mysqli_query($conexion, "ALTER TABLE `guia_laar` ADD `id_pedido` INT  NULL AFTER `url_guia`; ");
mysqli_query($conexion, "ALTER TABLE `productos` CHANGE `stock_producto` `stock_producto` DOUBLE NULL; ");
mysqli_query($conexion, "ALTER TABLE `horizontal` ADD `posicion` INT NULL AFTER `estado`; ");
mysqli_query($conexion, "ALTER TABLE `detalle_fact_cot` CHANGE `desc_venta` `desc_venta` INT NULL; ");
mysqli_query($conexion, "ALTER TABLE `facturas_cot` ADD `identificacion` VARCHAR(20) NULL AFTER `transporte`, ADD `celular` VARCHAR(20) NULL AFTER `identificacion`, ADD `cod` BOOLEAN NULL AFTER `celular`, ADD `valor_seguro` DOUBLE NULL AFTER `cod`; ");

mysqli_query($conexion, "ALTER TABLE `users` ADD `token_act` VARCHAR(400) NULL AFTER `comision_users`, ADD `estado_token` INT NULL AFTER `token_act`, ADD `fecha_actualizacion` DATETIME NULL AFTER `estado_token`");

mysqli_query($conexion, "ALTER TABLE `tmp_ventas` ADD `drogshipin_tmp` INT NULL AFTER `session_id`");
mysqli_query($conexion, "ALTER TABLE `facturas_cot` ADD `drogshipin` INT NULL AFTER `valor_seguro`");
mysqli_query($conexion, "ALTER TABLE `facturas_cot` ADD `tienda` VARCHAR(500) NULL AFTER `drogshipin`");
mysqli_query($conexion, "ALTER TABLE `detalle_fact_cot` ADD `drogshipin_tmp` INT NULL AFTER `precio_venta`");
mysqli_query($conexion, "ALTER TABLE `detalle_fact_cot` ADD `id_producto_origen` INT NULL AFTER `drogshipin_tmp`");
mysqli_query($conexion, " ALTER TABLE `productos` ADD `id_marketplace` INT NULL AFTER `id_producto_origen`");

mysqli_query($conexion, "UPDATE `user_group` SET `permission` = 'Inicio,1,1,1;Productos,1,1,1;Proveedores,1,1,1;Clientes,1,1,1;Reportes,1,1,1;Configuracion,1,1,1;Usuarios,1,1,1;Permisos,1,1,1;Categorias,1,1,1;Ventas,1,1,1;Compras,1,1,1;Pedidos,1,1,1;Integraciones,1,1,1;Dominios,1,1,1;' WHERE `user_group`.`user_group_id` = 1;");

mysqli_query($conexion, "ALTER TABLE `perfil` ADD `favicon` TEXT NULL AFTER `habilitar_proveedor`;");

mysqli_query($conexion, "ALTER TABLE `guia_laar` ADD `identificacionO` VARCHAR(500) NULL AFTER `id_pedido`, ADD `ciudadO` VARCHAR(500) NULL AFTER `identificacionO`, ADD `nombreO` VARCHAR(500) NULL AFTER `ciudadO`, ADD `direccionO` VARCHAR(500) NULL AFTER `nombreO`, ADD `referenciaO` VARCHAR(500) NULL AFTER `direccionO`, ADD `numeroCasaO` VARCHAR(500) NULL AFTER `referenciaO`, ADD `postalO` VARCHAR(500) NULL AFTER `numeroCasaO`, ADD `telefonoO` VARCHAR(500) NULL AFTER `postalO`, ADD `celularO` VARCHAR(500) NULL AFTER `telefonoO`, ADD `identificacionD` VARCHAR(500) NULL AFTER `celularO`");
mysqli_query($conexion, "ALTER TABLE `guia_laar` ADD `ciudadD` VARCHAR(500) NULL AFTER `identificacionD`, ADD `nombreD` VARCHAR(500) NULL AFTER `ciudadD`, ADD `direccionD` VARCHAR(500) NULL AFTER `nombreD`, ADD `referenciaD` VARCHAR(500) NULL AFTER `direccionD`, ADD `numeroCasaD` VARCHAR(500) NULL AFTER `referenciaD`, ADD `postalD` VARCHAR(500)  NULL AFTER `numeroCasaD`, ADD `telefonoD` VARCHAR(500) NULL AFTER `postalD`, ADD `celularD` VARCHAR(500) NULL AFTER `telefonoD`, ADD `tipoServicio` VARCHAR(500) NULL AFTER `celularD`, ADD `noPiezas` INT NULL AFTER `tipoServicio`, ADD `peso` DOUBLE NULL AFTER `noPiezas`, ADD `valorDeclarado` DOUBLE NULL AFTER `peso`, ADD `contiene` VARCHAR(500) NULL AFTER `valorDeclarado`, ADD `cod` BOOLEAN NULL AFTER `contiene`, ADD `costoflete` DOUBLE NULL AFTER `cod`, ADD `costoproducto` DOUBLE NULL AFTER `costoflete`, ADD `tipocobro` VARCHAR(500) NULL AFTER `costoproducto`, ADD `comentario` VARCHAR(500)  NULL AFTER `tipocobro`");
mysqli_query($conexion, "ALTER TABLE `guia_laar` ADD `estado_guia` INT NOT NULL AFTER `comentario`");
mysqli_query($conexion, "CREATE TABLE `estado_courier` (
  `id_estado` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `alias` varchar(500) DEFAULT NULL,
  UNIQUE KEY `id_estado` (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci");
mysqli_query($conexion, "DELETE FROM `estado_courier`");

mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (1, '1', 'Envío listo para despachar', 'Pendiente')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (2, '1', 'Envío creado por procesar', 'Por Recolectar')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (3, '1', 'Envío Recolectado', 'Recolectado')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (4, '1', 'Ingreso en Bodega', 'En Bodega')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (5, '1', 'En proceso operativo', 'En Tránsito')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (6, '1', 'En zona para entrega al destino', 'Zona de Entrega')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (7, '1', 'Entregado', 'Entregado')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (8, '1', 'Anulacion de Guía', 'Anulado')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (9, '1', 'Devolucion al Cliente', 'Devolución/Entrega')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (10, '1', 'Facturado', 'Facturado')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (11, '1', 'En Ruta Regional/Confir. de Salida Confirmación de Salida', 'En Tránsito')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (12, '1', 'En Ruta Regional/Confir. de Llegada Confirmación de Llegada', 'En Tránsito')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (13, '1', 'Confirmación en Transito', 'En Tránsito')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (14, '1', 'En zona para entrega al destino/Novedad', 'Con Novedad')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (15, '1', 'Ingreso en Bodega / Por no entrega', 'Zona de Entrega')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (16, '1', 'Eliminacion Novedad', 'Zona de Entrega')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (17, '1', 'Envio Provicionalmente en Bodega', 'En Bodega')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (18, '1', 'Facturado', 'Facturado')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (19, '1', 'Confirmación de Llegada Automática por Zona', 'Zona de Entrega')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (20, '1', 'Guía sin la Confirmación de Salida De Regional por no pesar', 'En Tránsito')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (21, '1', 'Guía sin la Confirmación de Llegada De Regional por no pesar', 'En Tránsito')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (22, '1', 'Guía sin pesar electronicamente y sin registrar en manifiesto de zona', 'Zona de Entrega')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (23, '1', 'Guía Borrada del Manifiesto de Zona', 'Zona de Entrega')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (24, '1', 'Guía que no fue Registrada en Bodega', 'Zona de Entrega')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (25, '1', 'Liberado Aduana', 'Aduana')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (26, '1', 'No Liberado Aduana', 'Aduana')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (27, '1', 'Devolución Regional', 'Devolución Regional')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (28, '1', 'Registro en Zona por el Courier de Limites de Intentos', 'Zona de Entrega/Registro Limite')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (29, '1', 'Eliminacion Novedad Devolución', 'Reversa de Devolución')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (30, '1', 'Registro de Devolución en Zona de Entrega', 'Zona de Entrega/Registro Devolución')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (31, '1', 'Registro de Usuario que modifico POD PE', 'Digitación')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (32, '1', 'Registro de Usuario que modifico POD GC', 'Digitación')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (33, '1', 'Registro de Usuario que Elimino POD GC', 'Digitación')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (34, '1', 'Registro de Observacion Guia Retorno', 'Digitacion')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (35, '1', 'Registro del Cierre de COD Cartera para el Pago al Cliente', 'COD')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (36, '1', 'Registro del Cierre de COD Facturación para Cobro al Cliente', 'COD')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (37, '1', 'Registro de Usuario que Elimino POD UTILITARIO', 'Digitación')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (38, '1', 'Envío No Recolectado', 'No Recolectado')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (39, '1', 'Envío No Recolectado Cerrado', 'Cierre No Recolección')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (40, '1', 'Registro del Usuario que Ingreso la Devolución', 'Registro(Devolucion)')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (41, '1', 'Registro del Usuario que Ingreso los Datos Acutalizados', 'Registro(Actualizacion)')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (42, '1', 'Registro del Usuario que Ingreso el Mal Direccionado', 'Registro(Mal Direccionado)')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (43, '1', 'Registro del Usuario que Ingreso el Cambio Trayecto', 'Registro(Cambio Trayecto)')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (44, '1', 'Registro de Actualizacion de Guia Cliente (Dev, Actualizacion o Cambio Trayecto)', 'Registro(Dev-CTray-Act)')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (45, '1', 'Registro de Excepcion de un Cod por falta de pago', 'COD')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (46, '1', 'Registro de Deposito de COD', 'COD')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (47, '1', 'Registro Entregas Sabado/Feriado', 'SAC')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (48, '1', 'Registro de Novedad de COD x Inventario', 'COD')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (49, '1', 'Eliminacion COD', 'COD')");
mysqli_query($conexion, "INSERT INTO estado_courier (codigo, id_servicio, descripcion, alias) VALUES (50, '1', 'Actualizacion Valor COD', 'COD')");
mysqli_query($conexion, "INSERT INTO `currencies` (`id`, `name`, `symbol`, `precision`, `thousand_separator`, `decimal_separator`, `code`) VALUES (33, 'Sol', 'S/.', '2', ',', '.', 'PEN')");
mysqli_query($conexion, "UPDATE `currencies` SET `symbol` = 'COP$' WHERE `currencies`.`id` = 30;");

mysqli_query($conexion, "ALTER TABLE `facturas_cot` ADD `importado` INT NULL DEFAULT '0' AFTER `tienda`");
mysqli_query($conexion, "ALTER TABLE `facturas_cot` ADD `plataforma_importa` VARCHAR(500) NULL  AFTER `importado`");
mysqli_query($conexion, "CREATE TABLE `estado_guia_sistema` (
  `id_estado` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `estado` varchar(100) DEFAULT NULL,
  UNIQUE KEY `id_estado` (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci");
mysqli_query($conexion, "INSERT INTO `estado_guia_sistema` (`id_estado`, `estado`) VALUES (1, 'Confirmar'), (2, 'Pick y Pack '), (3, 'Despachado'), (4, 'Zona de entrega '), (5, 'Cobrado'), (6, 'Pagado '), (7, 'Liquidado'), (8, 'Anulado')");
//mysqli_query($conexion, "ALTER TABLE `facturas_cot` CHANGE `estado_factura` `estado_factura` INT(1) NOT NULL");
mysqli_query($conexion, "ALTER TABLE `facturas_cot` ADD `estado_guia_sistema` INT NULL AFTER `plataforma_importa`");
mysqli_query($conexion, "ALTER TABLE `guia_laar` ADD `valor_costo` DOUBLE  NULL AFTER `costoproducto`");
mysqli_query($conexion, "ALTER TABLE `facturas_cot` ADD `id_factura_origen` INT NULL AFTER `estado_guia_sistema`");
mysqli_query($conexion, "ALTER TABLE `tmp_cotizacion` ADD `drogshipin_tmp` INT NULL AFTER `session_id`, ADD `id_origen` INT NULL AFTER `drogshipin_tmp`, ADD `id_marketplace` INT NULL AFTER `id_origen`");
mysqli_query($conexion, "ALTER TABLE `guia_laar` CHANGE `cod` `cod` INT NULL DEFAULT NULL");
mysqli_query($conexion, "ALTER TABLE `tmp_ventas` DROP `id_marketplace`");
mysqli_query($conexion, "ALTER TABLE `tmp_ventas` DROP `id_origen`");
mysqli_query($conexion, "ALTER TABLE `tmp_cotizacion` DROP `id_marketplace`");
mysqli_query($conexion, "ALTER TABLE `tmp_cotizacion` DROP `id_origen`");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `precio` = '3.5' WHERE `codigo` = '201001001001'");

mysqli_query($conexion, "UPDATE `user_group` SET `permission` = 'Inicio,1,1,1;Productos,1,1,1;Proveedores,1,1,1;Clientes,1,1,1;Reportes,1,1,1;Configuracion,1,1,1;Usuarios,1,1,1;Permisos,1,1,1;Categorias,1,1,1;Ventas,1,1,1;Compras,1,1,1;Pedidos,1,1,1;Integraciones,1,1,1;Dominios,1,1,1;Wallets,1,1,1;' WHERE `user_group`.`user_group_id` = 1;");

mysqli_query($conexion, "CREATE TABLE `cabecera_cuenta_cobrar` (
  `id_cabecera` int(11) NOT NULL,
  `numero_factura` varchar(100) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `cliente` varchar(100) DEFAULT NULL,
  `tienda` varchar(100) DEFAULT NULL,
  `estado_guia` int(11) DEFAULT NULL,
  `estado_pedido` int(11) DEFAULT NULL,
  `total_venta` double DEFAULT NULL,
  `costo` double DEFAULT NULL,
  `precio_envio` double DEFAULT NULL,
  `monto_recibir` double DEFAULT NULL,
  `valor_cobrado` double DEFAULT 0,
  `valor_pendiente` double DEFAULT 0
)");

mysqli_query($conexion, "ALTER TABLE `cabecera_cuenta_cobrar`
ADD PRIMARY KEY (`id_cabecera`);");

mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001001027';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001001043';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001001060';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001001062';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001002020';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001002029';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001002070';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001002073';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001002076';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001003020';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001003035';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001005007';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001007013';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001011014';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001011019';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001012004';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001012005';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001013008';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001013021';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001014007';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001014025';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001014026';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001014041';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001016004';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001017001';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001017002';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001017003';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001020001';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001020002';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001020003';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001021005';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001022001';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001023021';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001024004';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001024005';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001024006';");
mysqli_query($conexion, "UPDATE `ciudad_laar` SET `costo`='3.5',`precio`='5.5' WHERE codigo='201001024007';");

mysqli_query($conexion, "UPDATE `user_group` SET `permission` = 'Inicio,1,1,1;Productos,1,1,1;Proveedores,1,1,1;Clientes,1,1,1;Reportes,1,1,1;Configuracion,1,1,1;Usuarios,1,1,1;Permisos,1,1,1;Categorias,1,1,1;Ventas,1,1,1;Compras,1,1,1;Pedidos,1,1,1;Integraciones,1,1,1;Dominios,1,1,1;Wallets,1,1,1;Datos,1,1,1;' WHERE `user_group`.`user_group_id` = 1;");

mysqli_query($conexion, "ALTER TABLE cabecera_cuenta_cobrar RENAME TO cabecera_cuenta_pagar;");

mysqli_query($conexion, "CREATE TABLE detalle_cuenta_cobrar( id_detalle_cpp int PRIMARY KEY AUTO_INCREMENT, valor double, id_cabecera_cpp int, signo varchar(2), metodo_pago varchar(50), id_pago int, FOREIGN KEY (id_cabecera_cpp) REFERENCES cabecera_cuenta_pagar(id_cabecera), FOREIGN KEY (id_pago) REFERENCES pagos(id_pago) );");

mysqli_query($conexion, "ALTER TABLE `provincia_laar` ADD `id_pais` INT NOT NULL DEFAULT '1' AFTER `codigo_provincia`;");
mysqli_query($conexion, " ALTER TABLE `perfil` ADD `pais` INT NOT NULL DEFAULT '1' AFTER `fiscal_empresa`;");
mysqli_query($conexion, "DELETE FROM `ciudad_laar` where pais=2");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Chachapoyas','0101',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Bagua','0102',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Bongará','0103',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Condorcanqui','0104',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Luya','0105',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Rodríguez de Mendoza','0106',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Utcubamba','0107',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Huaraz','0201',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Aija','0202',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Antonio Raymondi','0203',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Asunción','0204',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Bolognesi','0205',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Carhuaz','0206',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Carlos Fermín Fitzcarrald','0207',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Casma','0208',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Corongo','0209',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Huari','0210',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Huarmey','0211',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Huaylas','0212',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Mariscal Luzuriaga','0213',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Ocros','0214',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Pallasca','0215',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Pomabamba','0216',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Recuay','0217',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Santa','0218',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Sihuas','0219',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Yungay','0220',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Abancay','0301',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Andahuaylas','0302',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Antabamba','0303',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Aymaraes','0304',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Cotabambas','0305',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Chincheros','0306',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Grau','0307',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Arequipa','0401',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Camaná','0402',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Caravelí','0403',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Castilla','0404',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Caylloma','0405',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Condesuyos','0406',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Islay','0407',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('La Uniòn','0408',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Huamanga','0501',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Cangallo','0502',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Huanca Sancos','0503',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Huanta','0504',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('La Mar','0505',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Lucanas','0506',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Parinacochas','0507',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Pàucar del Sara Sara','0508',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Sucre','0509',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Víctor Fajardo','0510',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Vilcas Huamán','0511',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Cajamarca','0601',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Cajabamba','0602',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Celendín','0603',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Chota','0604',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Contumazá','0605',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Cutervo','0606',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Hualgayoc','0607',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Jaén','0608',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('San Ignacio','0609',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('San Marcos','0610',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('San Miguel','0611',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('San Pablo','0612',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Santa Cruz','0613',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Prov. Const. del Callao','0701',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Cusco','0801',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Acomayo','0802',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Anta','0803',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Calca','0804',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Canas','0805',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Canchis','0806',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Chumbivilcas','0807',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Espinar','0808',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('La Convención','0809',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Paruro','0810',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Paucartambo','0811',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Quispicanchi','0812',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Urubamba','0813',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Huancavelica','0901',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Acobamba','0902',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Angaraes','0903',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Castrovirreyna','0904',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Churcampa','0905',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Huaytará','0906',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Tayacaja','0907',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Huánuco','1001',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Ambo','1002',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Dos de Mayo','1003',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Huacaybamba','1004',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Huamalíes','1005',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Leoncio Prado','1006',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Marañón','1007',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Pachitea','1008',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Puerto Inca','1009',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Lauricocha ','1010',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Yarowilca ','1011',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Ica ','1101',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Chincha ','1102',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Nazca ','1103',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Palpa ','1104',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Pisco ','1105',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Huancayo ','1201',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Concepción ','1202',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Chanchamayo ','1203',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Jauja ','1204',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Junín ','1205',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Satipo ','1206',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Tarma ','1207',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Yauli ','1208',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Chupaca ','1209',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Trujillo ','1301',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Ascope ','1302',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Bolívar ','1303',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Chepén ','1304',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Julcán ','1305',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Otuzco ','1306',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Pacasmayo ','1307',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Pataz ','1308',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Sánchez Carrión ','1309',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Santiago de Chuco ','1310',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Gran Chimú ','1311',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Virú ','1312',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Chiclayo ','1401',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Ferreñafe ','1402',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Lambayeque ','1403',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Lima ','1501',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Barranca ','1502',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Cajatambo ','1503',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Canta ','1504',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Cañete ','1505',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Huaral ','1506',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Huarochirí ','1507',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Huaura ','1508',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Oyón ','1509',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Yauyos ','1510',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Maynas ','1601',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Alto Amazonas ','1602',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Loreto ','1603',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Mariscal Ramón Castilla ','1604',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Requena ','1605',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Ucayali ','1606',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Datem del Marañón ','1607',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Putumayo','1608',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Tambopata ','1701',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Manu ','1702',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Tahuamanu ','1703',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Mariscal Nieto ','1801',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('General Sánchez Cerro ','1802',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Ilo ','1803',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Pasco ','1901',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Daniel Alcides Carrión ','1902',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Oxapampa ','1903',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Piura ','2001',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Ayabaca ','2002',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Huancabamba ','2003',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Morropón ','2004',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Paita ','2005',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Sullana ','2006',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Talara ','2007',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Sechura ','2008',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Puno ','2101',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Azángaro ','2102',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Carabaya ','2103',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Chucuito ','2104',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('El Collao ','2105',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Huancané ','2106',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Lampa ','2107',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Melgar ','2108',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Moho ','2109',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('San Antonio de Putina ','2110',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('San Román ','2111',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Sandia ','2112',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Yunguyo ','2113',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Moyobamba ','2201',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Bellavista ','2202',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('El Dorado ','2203',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Huallaga ','2204',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Lamas ','2205',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Mariscal Cáceres ','2206',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Picota ','2207',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Rioja ','2208',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('San Martín ','2209',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Tocache ','2210',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Tacna ','2301',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Candarave ','2302',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Jorge Basadre ','2303',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Tarata ','2304',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Tumbes ','2401',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Contralmirante Villar ','2402',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Zarumilla ','2403',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Coronel Portillo ','2501',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Atalaya ','2502',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Padre Abad ','2503',2); ");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Purús','2504',2); ");

mysqli_query($conexion, "ALTER TABLE `facturas_cot` ADD `impreso` TINYINT NULL AFTER `id_factura_origen`;");
mysqli_query($conexion, "ALTER TABLE `guia_laar` ADD `id_transporte` INT NOT NULL DEFAULT '1' AFTER `estado_guia`;");
mysqli_query($conexion, "CREATE TABLE `caracteristicas_tienda` (  `id` int(11) NOT NULL AUTO_INCREMENT,   `id_producto` int(11) DEFAULT 0,  `texto` varchar(255) DEFAULT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci");

mysqli_query($conexion, "UPDATE `user_group` SET `permission` = 'Inicio,1,1,1;Productos,1,1,1;Proveedores,1,1,1;Clientes,1,1,1;Reportes,1,1,1;Configuracion,1,1,1;Usuarios,1,1,1;Permisos,1,1,1;Categorias,1,1,1;Ventas,1,1,1;Compras,1,1,1;Pedidos,1,1,1;Integraciones,1,1,1;Dominios,1,1,1;Wallets,1,1,1;Datos,1,1,1;Referidos,1,1,1;' WHERE `user_group`.`user_group_id` = 1;");
mysqli_query($conexion, "ALTER TABLE `perfil` ADD `nodevolucion` TINYINT NOT NULL DEFAULT '0'");
mysqli_query($conexion, "CREATE TABLE motorizado_guia ( id int NOT NULL PRIMARY KEY AUTO_INCREMENT, empleado_id int NOT NULL, guia_fast varchar(400) NOT NULL );");
mysqli_query($conexion, "CREATE TABLE `empresa_envio` (`id` int NOT NULL AUTO_INCREMENT, `nombre` varchar(20) UNIQUE DEFAULT NULL,  PRIMARY KEY (`id`)) ");
mysqli_query($conexion, "CREATE TABLE `trabajadores_envio` ( `id` int NOT NULL AUTO_INCREMENT, `nombre` varchar(20) DEFAULT NULL, `contacto` varchar(13) DEFAULT NULL, `placa` varchar(10) DEFAULT NULL, `empresa` int NOT NULL, `estado` tinyint DEFAULT '1', PRIMARY KEY (`id`), KEY `empresa` (`empresa`), CONSTRAINT `trabajadores_envio_ibfk_1` FOREIGN KEY (`empresa`) REFERENCES `empresa_envio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE) ");

mysqli_query($conexion, "INSERT INTO `empresa_envio` (`id`, `nombre`) VALUES (1, 'Laar Courier'), (2, 'Speed'), (3, 'Speed');");

mysqli_query($conexion, "DELETE FROM `ciudad_laar` where pais=2");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Antioquia','5','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Boyacá','15','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Córdoba','23','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Chocó','27','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Nariño','52','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Santander','68','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Meta','50','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Atlántico','8','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Bolívar','13','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Caldas','17','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Caquetá','18','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Cauca','19','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Cesar','20','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Cundinamarca','25','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Huila','41','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('La Guajira','44','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Magdalena','47','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Quindío','63','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Risaralda','66','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Sucre','70','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Tolima','73','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Arauca','81','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Casanare','85','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Putumayo','86','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Amazonas','91','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Guainía','94','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Vaupés','97','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Vichada','99','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Guaviare','95','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Archipiélago de San Andrés, Providencia y Santa Catalina','88','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Bogotá D.C.','11','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Norte de Santander','54','3');");
mysqli_query($conexion, "INSERT INTO `provincia_laar` (`provincia`,  `codigo_provincia`, `id_pais`) VALUES ('Valle del Cauca','76','3');");

mysqli_query($conexion, "ALTER TABLE `perfil` ADD `texto_slider` TEXT  NULL AFTER `nodevolucion`;");
mysqli_query($conexion, "ALTER TABLE `perfil` ADD `texto_btn_slider` TEXT NULL AFTER `texto_slider`;");
mysqli_query($conexion, "ALTER TABLE `perfil` ADD `enlace_btn_slider` TEXT NOT NULL AFTER `texto_btn_slider`;");
mysqli_query($conexion, "ALTER TABLE `perfil` ADD `titulo_slider` TEXT NULL AFTER `enlace_btn_slider`;");
mysqli_query($conexion, "ALTER TABLE `perfil` ADD `alineacion_slider` INT NOT NULL AFTER `titulo_slider`;");
mysqli_query($conexion, "CREATE TABLE `banner_adicional` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fondo_banner` text DEFAULT NULL,
  `titulo` text DEFAULT NULL,
  `texto_banner` text DEFAULT NULL,
  `texto_boton` text DEFAULT NULL,
  `enlace_boton` text DEFAULT NULL,
  `alineacion` int(11) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1");

mysqli_query($conexion, "UPDATE `perfil` SET `nodevolucion` = '1' WHERE `perfil`.`id_perfil` = 1;");


//$conexion_tienda  = mysqli_connect("localhost", "root", "Mark2demasiado..", "imporsuit_marketplace");
//$url = $_SERVER['HTTP_HOST'];
//
//$data = mysqli_query($conexion_tienda, "SELECT * from plataformas where url_imporsuit like '%$url%' ");
//$plataforma = mysqli_fetch_assoc($data);
//$id = $plataforma["id_plataforma"];


//mysqli_query($conexion, "ALTER TABLE `perfil` ADD `id_plataforma` INT NULL AFTER `alineacion_slider`;");
//
//mysqli_query($conexion, "UPDATE `perfil` SET `id_plataforma` = '$id' WHERE `perfil`.`id_perfil` = 1;");
//
//mysqli_query($conexion, "ALTER TABLE `clientes` DROP INDEX `codigo_producto`;");

//mysqli_close($conexion_tienda);


mysqli_query($conexion, "ALTER TABLE `productos` ADD `aplica_iva` INT NULL DEFAULT '0' AFTER `id_marketplace`;");

mysqli_query($conexion, "create table dropi (
	id_dropi int not null auto_increment primary key,
	usuario varchar(200) not null unique,
	contrasena_hash varchar(250) not null,
	token text default null,
	create_at datetime default current_timestamp(),
	update_at datetime default current_timestamp(),
	pais_id int not null
);");

mysqli_query($conexion, "ALTER TABLE `facturas_cot` ADD `facturada` INT NULL DEFAULT '0' AFTER `impreso`;");

mysqli_query($conexion, "ALTER TABLE `facturas_cot` ADD `factura_numero` INT NULL AFTER `facturada`;");

mysqli_query($conexion, "ALTER TABLE `perfil` ADD `caracteristicas_home` INT DEFAULT '0' NULL;");

mysqli_query($conexion, "ALTER TABLE `productos` ADD `destacado` INT DEFAULT '0' NULL;");

mysqli_query($conexion, "ALTER TABLE `caracteristicas_tienda` ADD `icon_text` varchar(100) NULL;");

mysqli_query($conexion, "ALTER TABLE `caracteristicas_tienda` ADD `enlace_icon` varchar(100) NULL;");

mysqli_query($conexion, "ALTER TABLE `caracteristicas_tienda` ADD `subtexto_icon` varchar(100) NULL;");

mysqli_query($conexion, "ALTER TABLE `caracteristicas_tienda` ADD `accion` INT DEFAULT 0 NULL;");


mysqli_query($conexion, "INSERT INTO `caracteristicas_tienda` (`id`,`id_producto`,  `texto`, `icon_text`, `subtexto_icon`, `accion`) VALUES (20,'0','Envío Gratis a todo el País','fa-truck','Llegamos a todo el País','1');");
mysqli_query($conexion, "INSERT INTO `caracteristicas_tienda` (`id`,`id_producto`,  `texto`, `icon_text`, `subtexto_icon`, `accion`) VALUES (21,'0','Pago Contra Entrega','fa-lock','Paga cuando recibes el producto','2');");
mysqli_query($conexion, "INSERT INTO `caracteristicas_tienda` (`id`,`id_producto`,  `texto`, `icon_text`, `subtexto_icon`, `accion`) VALUES (22,'0','Atención al cliente','fa-headset','Soporte 100% garantizado','2');");

mysqli_query($conexion, "ALTER TABLE `perfil` ADD `banner_opacidad` DOUBLE NULL DEFAULT '0.5' AFTER `caracteristicas_home`, ADD `banner_color_filtro` TEXT NULL AFTER `banner_opacidad`;");
mysqli_query($conexion, "CREATE TABLE ciudad_cotizacion (
  `id_cotizacion` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `provincia` varchar(100) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `cobertura_servientrega` tinyint(4) DEFAULT 0,
  `cobertura_laar` tinyint(4) DEFAULT 0,
  `cobertura_gintracom` tinyint(4) DEFAULT 0,
  `trayecto_servientrega` varchar(10) DEFAULT NULL,
  `trayecto_laar` varchar(10) DEFAULT NULL,
  `trayecto_gintracom` varchar(10) DEFAULT NULL,
  `codigo_provincia_servientrega` varchar(100) DEFAULT NULL,
  `codigo_provincia_laar` varchar(100) DEFAULT NULL,
  `codigo_ciudad_laar` varchar(100) DEFAULT NULL,
  `codigo_provincia_gintracom` varchar(100) DEFAULT NULL,
  `codigo_ciudad_gintracom` varchar(100) DEFAULT NULL,
  `codigo_ciudad_servientrega` varchar(100) DEFAULT NULL
)");
mysqli_query($conexion, "TRUNCATE TABLE `ciudad_cotizacion`;");

mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (1,'AZUAY','BANOS',1,1,0,'TE','TE','0','0','0','0','0','0','694'),
	 (2,'AZUAY','CHAULLABAMBA',0,1,0,'0','TE','0','','','','','','0'),
	 (3,'AZUAY','Checa/AZUAY',0,1,0,'0','TE','0','','','','','','0'),
	 (4,'AZUAY','CHILCAPAMBA',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (5,'AZUAY','Chiquintad',0,1,0,'0','TE','0','','','','','',''),
	 (6,'AZUAY','CHORDELEG',1,1,0,'TE','TE','0','0','201001003','201001003006','0','0','221'),
	 (7,'AZUAY','CUENCA',1,1,1,'TR','TP','TN','0','201001003','201001003011','1022','56247','4'),
	 (8,'AZUAY','CUMBE',1,1,0,'TE','TE','0','0','201001003','201001003017','0','0','498'),
	 (9,'AZUAY','EL PAN',1,0,0,'TE','0','0','0','0','0','0','0','497'),
	 (10,'AZUAY','Firma',0,1,0,'0','TE','0','','','','','','');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (11,'AZUAY','GIRON',1,1,0,'TE','TE','0','0','201001003','201001003002','0','0','34'),
	 (12,'AZUAY','GUACHAPALA',1,0,0,'TE','0','0','0','0','0','0','0','501'),
	 (13,'AZUAY','GUALACEO',1,1,0,'TR','TE','0','0','201001003','201001003003','0','0','19'),
	 (14,'AZUAY','LA UNION/AZUAY',1,0,0,'TE','0','0','0','0','0','0','0','503'),
	 (15,'AZUAY','Llacao',0,1,0,'0','TE','0','','','','','',''),
	 (16,'AZUAY','NABON',1,0,0,'TE','0','0','0','0','0','0','0','812'),
	 (17,'AZUAY','NULTI',0,1,0,'0','TE','0','','','','','',''),
	 (18,'AZUAY','ONA',1,1,0,'TE','TE','0','0','201001003','201001016002','0','0','814'),
	 (19,'AZUAY','PACCHA ',0,1,1,'0','TE','TN','0','201001003','201001003023','1022','59059','0'),
	 (20,'BOLIVAR','1ERO DE MAYO',1,0,1,'TE','0','TN','0','0','0','1023','57670','499');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (21,'BOLIVAR','4 ESQUINAS',1,0,0,'TE','0','0','0','0','0','0','0','689'),
	 (22,'BOLIVAR','ASUNCION',1,0,1,'TE','0','TE','0','0','0','1023','57672','696'),
	 (23,'BOLIVAR','BALZAPAMBA',1,0,0,'TE','0','0','0','0','0','0','0','507'),
	 (24,'BOLIVAR','CALUMA/BOLIVAR',1,0,0,'TE','0','0','0','0','0','0','0','72'),
	 (25,'BOLIVAR','CHILLANES',1,0,0,'TE','0','0','0','0','0','0','0','110'),
	 (26,'BOLIVAR','CHIMBO',1,0,1,'TE','0','TE','0','0','0','1023','56261','286'),
	 (27,'BOLIVAR','ECHEANDIA/BOLIVAR',1,0,0,'TE','0','0','0','0','0','0','0','382'),
	 (28,'BOLIVAR','GUARANDA',1,1,1,'TP','TP','TN','0','201001004','201001004001','1023','56264','44'),
	 (29,'BOLIVAR','LA MAGDALENA',1,0,1,'TE','0','TE','0','0','0','1023','57674','697'),
	 (30,'BOLIVAR','LAS NAVES',1,0,0,'TE','0','0','0','0','0','0','0','768');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (31,'BOLIVAR','PISAGUA ALTO',1,0,0,'TE','0','0','0','0','0','0','0','508'),
	 (32,'BOLIVAR','PISAGUA BAJO',1,0,0,'TE','0','0','0','0','0','0','0','509'),
	 (33,'BOLIVAR','RECINTO 24 DE MAYO',1,0,0,'TE','0','0','0','0','0','0','0','698'),
	 (34,'BOLIVAR','RECINTO EL PALMAR',1,0,0,'TE','0','0','0','0','0','0','0','699'),
	 (35,'BOLIVAR','RECINTO LA MARITZA',1,0,0,'TE','TP','0','0','0','0','0','0','700'),
	 (36,'BOLIVAR','SALINAS/BOLIVAR',1,0,0,'TE','0','0','0','0','0','0','0','701'),
	 (37,'BOLIVAR','SALINAS DE GUARANDA',0,1,0,'0','TE','0','0','201001004','201001004011','0','0','0'),
	 (38,'BOLIVAR','SAN JOSE DE CHIMBO',1,1,1,'TE','TE','TE','0','201001004','201001004003','1023','57681','500'),
	 (39,'BOLIVAR','SAN LORENZO/BOLIVAR',1,0,1,'TE','0','TE','0','0','0','1023','59063','771'),
	 (40,'BOLIVAR','SAN MIGUEL DE BOLIVAR',1,1,0,'TE','TE','0','0','201001004','201001004006','0','0','287');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (41,'BOLIVAR','SAN PABLO DE ATENAS',1,0,0,'TE','0','0','0','0','0','0','0','128'),
	 (42,'BOLIVAR','SAN PEDRO DE GUANUJO',1,0,1,'TE','0','TN','0','0','0','1023','57683','285'),
	 (43,'BOLIVAR','SAN SIMON',1,0,1,'TE','0','TE','0','0','0','1023','57684','511'),
	 (44,'BOLIVAR','SAN SIMON (YACOTO)',0,0,0,'0','0','0','0','0','0','0','0','511'),
	 (45,'BOLIVAR','SANTA FE',1,0,1,'TE','0','TE','0','0','0','1023','57685','512'),
	 (46,'BOLIVAR','VINCHOA',1,0,0,'TE','0','0','0','0','0','0','0','702'),
	 (47,'CANAR','AZOGUES',1,1,1,'TR','TP','TN','0','201001005','201001005001','1024','56277','99'),
	 (48,'CANAR','BIBLIAN',1,1,1,'TE','TE','TE','0','201001005','201001005004','1024','56278','392'),
	 (49,'CARCHI','BOLIVAR',1,1,0,'TE','TE','0','0','201001006','201001006006','0','0','271'),
	 (50,'CANAR','CAÑAR',1,1,1,'TE','TE','TN','0','201001005','201001005003','1024','56279','81');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (51,'CANAR','CHARCAY',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (52,'CARCHI','CHITAN DE NAVARRETES',1,0,0,'TE','0','0','0','0','0','0','0','703'),
	 (53,'CANAR','CHONTAMARCA',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (54,'CANAR','COCHANCAY',1,0,0,'TE','0','0','0','0','0','0','0','513'),
	 (55,'CANAR','COJITAMBO',1,0,1,'TE','0','TE','0','201001005','201001005007','1024','57688','692'),
	 (56,'CARCHI','CRISTOBAL COLON',1,0,0,'TE','0','0','0','0','0','0','0','272'),
	 (57,'CARCHI','CUESACA',1,0,0,'TE','0','0','0','0','0','0','0','704'),
	 (58,'CANAR','DELEG',1,0,0,'TE','0','0','0','0','0','0','0','679'),
	 (59,'CANAR','DUCUR',1,1,0,'TE','TE','0','0','0','0','0','0','514'),
	 (60,'CARCHI','EL ANGEL',1,1,0,'TE','TE','0','0','201001006','201001006003','0','0','273');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (61,'CARCHI','GARCIA MORENO',1,0,0,'TE','0','0','0','0','0','0','0','279'),
	 (62,'CANAR','GUAPAN',1,0,1,'TE','0','TN','0','0','0','1024','57690','515'),
	 (63,'CARCHI','HUACA',1,1,0,'TE','TE','0','0','201001006','201001006005','0','0','274'),
	 (64,'CANAR','INGAPIRCA',1,0,0,'TE','0','0','0','0','0','0','0','516'),
	 (65,'CANAR','JAVIER LOYOLA',1,0,1,'TE','0','TE','0','0','0','1024','57692','517'),
	 (66,'CANAR','JAVIN',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (67,'CARCHI','JULIO ANDRADE',1,1,0,'TE','TE','0','0','201001006','201001002041','0','0','275'),
	 (68,'CANAR','LA DOLOROSA',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (69,'CARCHI','LA PAZ',1,0,0,'TE','0','0','0','0','0','0','0','276'),
	 (70,'CANAR','LA PUNTILLA/CANAR',1,0,0,'TR','0','0','0','0','0','0','0','502');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (71,'CANAR','LA TRONCAL',1,1,1,'TE','TE','TN','0','201001005','201001005002','1024','56282','52'),
	 (72,'CANAR','LAS LAJAS',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (73,'CANAR','LUIS CORDERO',0,0,1,'0','0','TE','0','0','0','1024','59065','0'),
	 (74,'CANAR','MANUEL J. CALLE',0,0,1,'0','0','TE','0','0','0','1024','59066','0'),
	 (75,'CARCHI','MIRA/CARCHI',1,0,0,'TE','0','0','0','201001006','201001006002','0','0','251'),
	 (76,'CARCHI','PIOTER',1,0,0,'TE','0','0','0','0','0','0','0','124'),
	 (77,'CARCHI','SAN GABRIEL',1,1,0,'TE','TE','0','0','201001006','201001006004','0','0','51'),
	 (78,'CARCHI','SAN ISIDRO CARCHI SAN GABRIEL',1,0,0,'TE','0','0','0','0','0','0','0','278'),
	 (79,'CANAR','SAN MIGUEL',0,0,1,'0','0','TE','0','0','0','1024','59152','0'),
	 (80,'CARCHI','SANDIAL',1,0,0,'TE','0','0','0','0','0','0','0','705');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (81,'CARCHI','SANTA MARTHA DE CUBA',1,0,0,'TE','0','0','0','0','0','0','0','132'),
	 (82,'CANAR','SUSCAL',1,0,0,'TE','0','0','0','0','0','0','0','393'),
	 (83,'CANAR','TAMBO',1,1,0,'TE','TE','TE','0','201001005','201001003009','0','0','394'),
	 (84,'CARCHI','TULCAN',1,1,1,'TP','TP','TN','0','201001006','201001006001','1025','56289','39'),
	 (85,'CANAR','VOLUNTAD DE DIOS',1,0,0,'TE','0','0','0','0','0','0','0','506'),
	 (86,'CANAR','ZHUD',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (87,'CHIMBORAZO','ALAUSI',1,1,0,'TE','TE','0','','','','','','91'),
	 (88,'CHIMBORAZO','CAJABAMBA',1,1,0,'TE','TE','0','0','201001008','201001008005','0','0','678'),
	 (89,'CHIMBORAZO','CHAMBO',1,1,0,'TE','TE','0','0','201001008','201001004008','0','0','241'),
	 (90,'CHIMBORAZO','CHUNCHI',1,1,0,'TE','TE','0','0','0','0','0','0','248');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (91,'CHIMBORAZO','COLTA',1,1,0,'TE','TE','0','0','201001008','201001008008','0','0','242'),
	 (92,'CHIMBORAZO','CUMANDA/CHIMBORAZO',1,1,0,'TE','TE','0','0','201001008','201001008012','0','0','469'),
	 (93,'CHIMBORAZO','EL GUANO',1,1,0,'TE','TE','0','0','0','0','0','0','244'),
	 (94,'CHIMBORAZO','FLORES',0,0,1,'0','0','TE','0','0','0','1026','59068','0'),
	 (95,'CHIMBORAZO','GUAMOTE',1,1,0,'TE','TE','0','0','201001008','201001008007','0','0','243'),
	 (96,'CHIMBORAZO','GUANO',0,1,1,'0','TE','TE','','201001001','201001001070','','',''),
	 (97,'CHIMBORAZO','ILAPO',0,0,1,'0','0','TE','0','0','0','1026','59069','0'),
	 (98,'CHIMBORAZO','LICAN',1,1,1,'TE','TE','TE','0','201001008','201001008010','1026','57708','518'),
	 (99,'CHIMBORAZO','LICTO',0,0,1,'0','0','TE','0','0','0','1026','59070','0'),
	 (100,'CHIMBORAZO','PALLATANGA',1,0,0,'TE','0','0','0','0','0','0','0','467');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (101,'CHIMBORAZO','PENIPE',1,0,0,'TE','0','0','0','0','0','0','0','246'),
	 (102,'CHIMBORAZO','PUNGALA',0,0,0,'0','0','0','0','0','0','0','0','0'),
	 (103,'CHIMBORAZO','PUNIN',0,0,1,'0','0','TE','0','0','0','1026','59071','0'),
	 (104,'CHIMBORAZO','RECINTO EL BATAN',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (105,'CHIMBORAZO','RECINTO EL ROSARIO',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (106,'CHIMBORAZO','RECINTO SAN PEDRO',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (107,'CHIMBORAZO','RECITNO EL CHAGUE',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (108,'CHIMBORAZO','RECITNO FORTUNA BAJA',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (109,'CHIMBORAZO','RIOBAMBA',1,1,1,'TP','TP','TN','0','201001008','201001008001','1026','56276','43'),
	 (110,'CHIMBORAZO','SAN ANDRES',1,0,1,'TE','0','TE','0','0','0','1026','57709','677');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (111,'CHIMBORAZO','SAN JUAN/CHIMBORAZO',0,0,1,'0','0','TE','0','0','0','1026','59072','0'),
	 (112,'CHIMBORAZO','SAN LUIS (CHIMBORAZO)',1,0,1,'TE','0','TE','0','0','0','1026','57710','274'),
	 (113,'COTOPAXI','11 DE NOVIEMBRE (ILINCHISI)',0,0,1,'0','0','TE','0','0','0','1027','59075','0'),
	 (114,'COTOPAXI','ALAQUES (ALAQUEZ) ',0,1,0,'0','TP','0','0','0','0','0','0','0'),
	 (115,'COTOPAXI','ANCHILIVI',1,0,0,'TE','0','0','','','','','','709'),
	 (116,'COTOPAXI','BELISARIO QUEVEDO',1,1,1,'TE','TE','TE','0','201001007','201001007012','1027','57713','521'),
	 (117,'COTOPAXI','CHIPUALO',1,0,0,'TE','0','0','0','0','0','0','0','522'),
	 (118,'COTOPAXI','EL CARMEN ',0,0,0,'0','0','0','0','0','0','0','0','0'),
	 (119,'COTOPAXI','EL CORAZON',1,0,0,'TE','0','0','0','0','0','0','0','706'),
	 (120,'COTOPAXI','EL MORAL',0,1,0,'0','TE','0','0','0','0','0','0','0');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (121,'COTOPAXI','GUAYTACAMA',1,1,1,'TE','TE','TE','0','201001007','201001007009','1027','57716','523'),
	 (122,'COTOPAXI','LA MANA',1,1,1,'TE','TE','TN','0','201001013','201001007005','1027','56291','228'),
	 (123,'COTOPAXI','LA VICTORIA/COTOPAXI',1,0,0,'TE','0','0','0','0','0','0','0','711'),
	 (124,'COTOPAXI','LASSO',1,1,1,'TE','TE','TE','0','201001007','201001007007','1027','57717','257'),
	 (125,'COTOPAXI','LATACUNGA',1,1,1,'TP','TP','TN','0','201001007','201001007001','1027','56290','41'),
	 (126,'COTOPAXI','MORASPUNGO',1,0,0,'TE','0','0','0','0','0','0','0','712'),
	 (127,'COTOPAXI','MULALAO',1,1,1,'TE','TE','TE','0','201001007','201001007015','1027','57719','524'),
	 (128,'COTOPAXI','MULALILLO',1,0,0,'TE','0','0','0','0','0','0','0','525'),
	 (129,'COTOPAXI','MULALO',0,1,0,'0','TE','0','0','201001007','201001007010','0','0','0'),
	 (130,'COTOPAXI','MULLIQUINDIL',0,0,1,'0','0','TE','0','0','0','1027','59074','0');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (131,'COTOPAXI','PANGUA',1,0,0,'TE','0','0','0','0','0','0','0','707'),
	 (132,'COTOPAXI','PANZALEO',1,0,1,'TE','0','TN','0','0','0','1027','57721','526'),
	 (133,'COTOPAXI','PASTOCALLE',1,1,1,'TE','TE','TE','0','201001007','201001007008','1027','57722','527'),
	 (134,'COTOPAXI','PATAIN',1,0,0,'TE','0','0','0','0','0','0','0','528'),
	 (135,'COTOPAXI','POALO',1,0,1,'TE','0','TE','0','0','0','1027','57724','710'),
	 (136,'COTOPAXI','PUJILI',1,1,1,'TE','TE','TE','0','201001007','201001007004','1027','56293','258'),
	 (137,'COTOPAXI','RUMIPAMBA/COTOPAXI',1,0,0,'TE','0','0','0','0','0','0','0','529'),
	 (138,'COTOPAXI','SALCEDO',1,1,1,'TE','TE','TN','0','201001007','201001007002','1027','56295','66'),
	 (139,'COTOPAXI','SAN BUENAVENTURA -BELLAVISTA.',0,1,0,'0','TE','0','0','0','0','0','0','0'),
	 (140,'COTOPAXI','SAN MARCOS',1,0,0,'TE','0','0','0','0','0','0','0','530');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (141,'COTOPAXI','SAN MIGUEL',0,0,0,'0','0','0','0','0','0','0','0','0'),
	 (142,'COTOPAXI','SANTA ANA COTOPAXI',1,0,0,'TE','0','0','0','0','0','0','0','713'),
	 (143,'COTOPAXI','SAQUISILI',1,1,1,'TE','TE','TE','0','201001007','201001007003','1027','56296','256'),
	 (144,'COTOPAXI','SIGCHOS',1,0,0,'TE','0','0','0','0','0','0','0','708'),
	 (145,'COTOPAXI','TANICUCHCHI',0,1,0,'0','TE','0','0','201001007','201001007014','0','0','0'),
	 (146,'COTOPAXI','TANICUCHI',1,1,1,'TE','TE','TE','0','201001007','201001007011','1027','57728','531'),
	 (147,'COTOPAXI','TOACASO',1,0,1,'TE','0','TE','0','0','0','1027','57729','532'),
	 (148,'COTOPAXI','YANAYACU',1,0,0,'TE','0','0','0','0','0','0','0','533'),
	 (149,'EL ORO','3 CERRITOS PASAJE',1,0,0,'TE','0','','','','','','','534'),
	 (150,'EL ORO','ARENILLAS',1,1,0,'TE','TE','','','201001009','201001009006','','','65');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (151,'EL ORO','BARBONES',0,0,1,'0','0','TE','','','','1028','57734',''),
	 (152,'EL ORO','BELLAVISTA/EL ORO',0,0,1,'0','0','TE','0','0','0','1028','59076','0'),
	 (153,'EL ORO','BUENA VISTA',1,0,1,'TE','0','TE','0','0','0','1028','57736','365'),
	 (154,'EL ORO','CANA QUEMADA',1,0,1,'TE','0','TE','0','0','0','1028','57737','538'),
	 (155,'EL ORO','EL CAMBIO',1,1,1,'TE','TE','TE','0','201001009','201001009011','1028','57738','351'),
	 (156,'EL ORO','EL GUABO',1,1,1,'TE','TE','TE','0','201001009','201001009008','1028','56301','58'),
	 (157,'EL ORO','EL PACHE',1,0,0,'TE','0','0','0','0','0','0','0','540'),
	 (158,'EL ORO','EL PORTON',1,0,0,'TE','0','0','0','0','0','0','0','541'),
	 (159,'EL ORO','EL RETIRO',0,0,1,'0','0','TE','0','0','0','1028','59077','0'),
	 (160,'EL ORO','HUAQUILLAS',1,1,1,'TR','TE','TN','0','201001009','201001009007','1028','56302','35');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (161,'EL ORO','LA AVANZADA',1,1,1,'TE','TE','TE','0','201001009','201001009019','1028','57741','355'),
	 (162,'EL ORO','LA IBERIA',1,0,1,'TE','TE','TE','0','0','0','1028','57742','542'),
	 (163,'EL ORO','LA PEANA',1,1,1,'TE','TE','TE','0','201001009','201001009017','1028','57743','366'),
	 (164,'EL ORO','LA VICTORIA/EL ORO',1,0,0,'TE','0','0','0','0','0','0','0','818'),
	 (165,'EL ORO','LOMA DE FRANCO',1,1,0,'TE','TE','0','0','201001009','201001009018','0','0','368'),
	 (166,'EL ORO','MACHALA',1,1,1,'TR','TP','TN','0','201001009','201001009001','1028','56304','7'),
	 (167,'EL ORO','MARCABELI',1,0,0,'TE','0','0','0','0','0','0','0','488'),
	 (168,'EL ORO','PACCHA',1,0,0,'TE','0','0','0','0','0','0','0','759'),
	 (169,'EL ORO','PASAJE',1,1,1,'TE','TE','TN','0','201001009','201001009002','1028','56306','36'),
	 (170,'EL ORO','PINAS',1,1,0,'TE','TE','0','0','201001009','201001009004','0','0','50');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (171,'EL ORO','PORTOVELO',1,1,0,'TE','TE','0','0','201001009','201001009003','0','0','358'),
	 (172,'EL ORO','PUERTO BOLIVAR',1,1,1,'TE','TE','TN','0','201001009','201001009010','1028','55747','352'),
	 (173,'EL ORO','PUERTO HUALTACO',1,0,0,'TE','0','0','0','0','0','0','0','371'),
	 (174,'EL ORO','PUERTO JELI',1,0,0,'TE','0','0','0','0','0','0','0','544'),
	 (175,'EL ORO','RIO BONITO',1,0,0,'TE','0','0','0','0','0','0','0','545'),
	 (176,'EL ORO','SAN ANTONIO EL ORO',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (177,'EL ORO','SAN VICENTE DEL JOBO',1,0,0,'TE','0','0','0','0','0','0','0','547'),
	 (178,'ESMERALDAS','ATACAMES',1,1,1,'TE','TE','TE','0','201001010','201001010003','1029','56311','23'),
	 (179,'ESMERALDAS','BORBON',1,0,0,'TE','0','0','0','0','0','0','0','549'),
	 (180,'ESMERALDAS','ESMERALDAS',1,1,1,'TP','TP','TN','0','201001010','201001010001','1029','56313','10');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (181,'ESMERALDAS','LA CONCORDIA/ESMERALDAS',1,0,0,'TE','0','0','0','0','0','0','0','69'),
	 (182,'ESMERALDAS','LA INDEPENDENCIA',1,0,0,'TE','0','0','0','0','0','0','0','236'),
	 (183,'ESMERALDAS','LA UNION/ESMERALDAS',1,0,0,'TE','0','0','0','0','0','0','0','270'),
	 (184,'ESMERALDAS','LA Y DE CALDERON',1,0,0,'TE','0','0','0','0','0','0','0','716'),
	 (185,'ESMERALDAS','LAGARTO',1,0,0,'TE','0','0','0','0','0','0','0','714'),
	 (186,'ESMERALDAS','LAS PENAS',1,0,0,'TE','0','0','0','0','0','0','0','717'),
	 (187,'ESMERALDAS','MUISNE',1,0,0,'TE','0','0','0','0','0','0','0','119'),
	 (188,'ESMERALDAS','QUININDE',1,1,1,'TE','TE','TN','0','201001010','201001010008','1029','56315','96'),
	 (189,'ESMERALDAS','RIO VERDE',1,1,0,'TE','TP','0','0','0','0','0','0','715'),
	 (190,'ESMERALDAS','SAME',1,0,0,'TE','0','0','0','0','0','0','0','266');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (191,'ESMERALDAS','SAN LORENZO/ESMERALDAS',1,0,1,'TE','0','TN','0','0','0','1029','56317','490'),
	 (192,'ESMERALDAS','SAN MATEO',0,0,1,'0','0','TE','0','0','0','1029','59080','0'),
	 (193,'ESMERALDAS','SUA',1,0,1,'TE','0','TE','0','0','0','1029','57662','267'),
	 (194,'ESMERALDAS','TABIAZO',0,0,1,'0','0','TE','0','0','0','1029','59081','0'),
	 (195,'ESMERALDAS','TACHINA',1,1,1,'TE','TE','TE','0','201001010','201001010016','1029','57761','269'),
	 (196,'ESMERALDAS','TONCHIGUE',1,0,0,'TE','0','0','0','0','0','0','0','550'),
	 (197,'ESMERALDAS','TONSUPA',1,1,1,'TE','TE','TE','0','201001010','201001010004','1029','57661','268'),
	 (198,'ESMERALDAS','VICHE',1,1,0,'TE','TE','0','0','201001010','201001010013','0','0','496'),
	 (199,'ESMERALDAS','VUELTA LARGA',0,0,1,'0','0','TE','0','0','0','1029','59082','0'),
	 (200,'GALAPAGOS','ISABELA',0,1,0,'GAL','GAL','0','0','0','0','0','0','0');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (201,'GALAPAGOS','SAN CRISTOBAL',1,1,0,'GAL','GAL','0','0','201001020','201001020003','0','0','49'),
	 (202,'GALAPAGOS','SANTA CRUZ',1,1,0,'GAL','GAL','0','0','201001020','201001020002','0','0','468'),
	 (203,'GUAYAS','3 POSTES',1,0,0,'TE','0','0','','201001002','','1031','','567'),
	 (204,'GUAYAS','5 DE JUNIO MILAGRO',1,0,0,'TE','0','0','','201001002','','1031','','6'),
	 (205,'GUAYAS','ALFREDO BAQUERIZO MORENO',1,0,1,'TE','TE','TE','','201001002','','1031','56321','718'),
	 (206,'GUAYAS','BALAO',0,1,0,'0','TE','0','0','201001002','201001002014','0','0','337'),
	 (207,'GUAYAS','BALZAR',1,0,0,'TE','0','TE','','201001002','201001002016','','','45'),
	 (208,'GUAYAS','BASE TAURA',0,1,0,'0','TE','0','0','201001002','201001002048','0','0','331'),
	 (209,'GUAYAS','BOCA DE CANA',1,0,0,'TE','0','TE','','201001002','201001002065','','','568'),
	 (210,'GUAYAS','BOLICHE',1,1,1,'TE','TN','TE','','201001002','2010010012067','1031','57768','569');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (211,'GUAYAS','BUCAY',1,0,0,'TE','0','TE','','201001002','201001002037','1031','','68'),
	 (212,'GUAYAS','CERECITA',1,0,0,'TE','0','TE','','201001002','201001002027','','','323'),
	 (213,'GUAYAS','CHIVERIA',1,0,0,'TE','0','TE','','201001002','201001002054','','','682'),
	 (214,'GUAYAS','CHOBO',0,0,1,'0','0','TE','0','0','0','1031','59083','0'),
	 (215,'GUAYAS','CHONGON',1,0,0,'TR','0','TE','','201001002','201001002032','1031','','223'),
	 (216,'GUAYAS','CHURUTE',1,0,0,'TE','0','0','','201001002','201001009006','1031','','779'),
	 (217,'GUAYAS','COLIMES',1,0,0,'TE','0','0','','201001002','201001002029','1031','','316'),
	 (218,'GUAYAS','COLORADAL',1,0,0,'TE','0','TE','','201001002','201001002055','1031','','572'),
	 (219,'GUAYAS','CONSUELO',0,0,0,'0','0','0','','201001002','','1031','','0'),
	 (220,'GUAYAS','CUMANDA/GUAYAS',0,1,0,'0','TE','0','0','201001002','201001010010','0','0','0');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (221,'GUAYAS','CUMANDA MILAGRO',0,1,0,'0','TE','0','0','201001002','201001002078','0','0','0'),
	 (222,'GUAYAS','DATA DE PLAYAS',1,0,0,'TE','0','TE','','201001002','201001002077','','','573'),
	 (223,'GUAYAS','DAULE',1,1,1,'TR','TE','TE','','201001002','201001002009','1031','56326','25'),
	 (224,'GUAYAS','DURAN',1,1,1,'TR','TE','TE','','201001002','201001002002','1031','56327','24'),
	 (225,'GUAYAS','EL DESEO',1,0,0,'TE','0','TE','','201001002','201001002049','','','726'),
	 (226,'GUAYAS','EL EMPALME/GUAYAS',1,0,1,'TE','TE','TE','','201001002','201001002069','1031','56328','767'),
	 (227,'GUAYAS','EL MORRO',1,0,0,'TE','0','0','','201001002','','1031','','118'),
	 (228,'GUAYAS','EL TRIUNFO/GUAYAS',1,1,1,'TR','TE','TE','','201001002','201001002007','1031','56329','26'),
	 (229,'GUAYAS','ELOY ALFARO - DURÁN',0,1,0,'0','TE','0','0','201001002','201001002076','0','0','719'),
	 (230,'GUAYAS','ENGABAO',1,0,0,'TE','0','0','','201001002','','1031','','554');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (231,'GUAYAS','GENERAL ANTONIO ELIZALDE',1,0,0,'TE','0','0','','201001002','','1031','','720'),
	 (232,'GUAYAS','GENERAL VERNAZA',1,0,1,'TE','0','TE','','201001002','201001002056','1031','','111'),
	 (233,'GUAYAS','GENERAL VILLAMIL',0,1,0,'0','TE','0','0','201001002','201001002075','0','0','0'),
	 (234,'GUAYAS','GUAYAQUIL',1,1,1,'TR','TP','TN','','201001002','201001002001','1031','56331','1'),
	 (235,'GUAYAS','GUAYAS',0,1,0,'0','TE','0','0','0','0','0','0','0'),
	 (236,'GUAYAS','INGENIO SAN CARLOS',1,0,1,'TE','0','TE','','201001002','201001002074','1031','','727'),
	 (237,'GUAYAS','ISIDRO AYORA',1,0,1,'TE','0','TE','','201001002','201001002025','1031','','321'),
	 (238,'GUAYAS','JESUS MARIA',1,0,0,'TE','TP','TN','','201001002','','1031','','783'),
	 (239,'GUAYAS','JUJAN',1,0,1,'TE','0','TE','','201001002','201001002018','1031','57784','376'),
	 (240,'GUAYAS','JUNQUILLAL',1,0,0,'TE','0','0','','201001002','','1031','','784');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (241,'GUAYAS','KM 26 - VIRGEN DE FÁTIMA',0,1,0,'0','TE','0','0','0','0','0','0','0'),
	 (242,'GUAYAS','KM 26 VIA DURAN TAMBO',0,1,0,'0','TE','0','0','201001002','201001002039','0','0','0'),
	 (243,'GUAYAS','LA AURORA',0,0,0,'TR','0','0','','201001002','','1031','','0'),
	 (244,'GUAYAS','LA MARAVILLA',1,0,1,'TE','0','TE','','201001002','201001002057','1031','','553'),
	 (245,'GUAYAS','LA PUNTILLA/GUAYAS',1,1,1,'TR','TE','TE','','201001002','201001002072','1031','57787','18'),
	 (246,'GUAYAS','LA T DE SALITRE',1,0,0,'TE','0','0','','201001002','','1031','','555'),
	 (247,'GUAYAS','LA TOMA',1,1,1,'TE','TE','TE','0','201001002','201001002030','1031','59084','556'),
	 (248,'GUAYAS','LA VICTORIA/GUAYAS',1,1,0,'TE','TE','0','0','201001002','201001002024','0','0','787'),
	 (249,'GUAYAS','LAS ANIMAS',1,1,0,'TE','TE','0','0','201001002','201001002050','0','0','557'),
	 (250,'GUAYAS','LAUREL',0,1,1,'','TE','TE','','201001002','201001002030','1031','59084','');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (251,'GUAYAS','LIMONAL',0,1,1,'0','TE','TE','0','201001002','201001002071','1031','59085','0'),
	 (252,'GUAYAS','LOS TINTOS',1,1,1,'TE','TE','TE','0','201001002','201001002059','1031','57795','304'),
	 (253,'GUAYAS','MANUEL J CALLE',1,1,0,'TE','TE','0','0','0','0','0','0','769'),
	 (254,'GUAYAS','MARCELINO MARIDUENA',1,1,0,'TE','TE','0','0','201001002','201001001030','0','0','344'),
	 (255,'GUAYAS','MARISCAL SUCRE',1,1,1,'TE','TE','TE','0','201001002','201001002051','1031','57797','346'),
	 (256,'GUAYAS','MATILDE ESTHER',1,1,0,'TE','TE','0','0','201001002','201001002064','0','0','560'),
	 (257,'GUAYAS','MILAGRO',1,1,1,'TR','TE','TN','0','201001002','201001002003','1031','56334','6'),
	 (258,'GUAYAS','NARANJAL',1,1,1,'TE','TE','TN','0','201001002','201001002015','1031','56336','20'),
	 (259,'GUAYAS','NARANJITO',1,1,1,'TE','TE','TE','0','201001002','201001002033','1031','56337','345'),
	 (260,'GUAYAS','NOBOL',1,1,0,'TE','TE','0','0','201001002','201001002021','0','0','317');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (261,'GUAYAS','PALESTINA',1,1,0,'TE','TE','0','0','201001002','201001002022','0','0','315'),
	 (262,'GUAYAS','PEDRO CARBO',1,1,0,'TE','TE','0','0','201001002','201001002040','0','0','61'),
	 (263,'GUAYAS','PETRILLO',1,1,0,'TE','TE','0','0','201001002','201001002060','0','0','318'),
	 (264,'GUAYAS','PLAYAS',1,1,0,'TE','TE','0','0','201001002','201001002005','0','0','21'),
	 (265,'GUAYAS','POSORJA',1,1,0,'TE','TE','0','0','201001002','201001002035','0','0','327'),
	 (266,'GUAYAS','PROGRESO/GUAYAS',1,1,0,'TE','TE','0','0','201001002','201001002042','0','0','326'),
	 (267,'GUAYAS','PUENTE LUCIA',1,1,0,'TE','TE','0','0','201001002','201001002061','0','0','561'),
	 (268,'GUAYAS','PUERTO DEL ENGABAO',1,1,0,'TE','TE','0','0','0','0','0','0','562'),
	 (269,'GUAYAS','PUERTO INCA',1,1,0,'TE','TE','0','0','201001002','201001002028','0','0','332'),
	 (270,'GUAYAS','ROBERTO ASTUDILLO',1,1,1,'TE','TE','TE','0','201001002','201001002052','1031','57806','343');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (271,'GUAYAS','SABANILLA (PEDRO CARBO)',1,1,0,'TE','TE','0','0','0','0','0','0','312'),
	 (272,'GUAYAS','SALITRE',1,1,0,'TE','TE','0','0','201001002','201001002031','0','0','305'),
	 (273,'GUAYAS','SAMBORONDON',1,1,1,'TE','TE','TN','0','201001002','201001002019','1031','56343','60'),
	 (274,'GUAYAS','SAN ANTONIO PLAYAS',1,0,0,'TE','0','0','0','201001002','201001002070','0','0','574'),
	 (275,'GUAYAS','SAN ISIDRO GUAYAS',1,0,0,'TE','0','0','0','0','0','0','0','325'),
	 (276,'GUAYAS','SANTA LUCIA',1,1,0,'TE','TE','0','0','201001002','201001002023','0','0','314'),
	 (277,'GUAYAS','SIMON BOLIVAR/GUAYAS',1,1,0,'TE','TE','0','0','201001002','201001002038','0','0','479'),
	 (278,'GUAYAS','TARIFA',1,1,0,'TE','TE','0','0','201001002','201001002063','0','0','301'),
	 (279,'GUAYAS','TAURA',1,0,0,'TE','0','0','0','0','0','0','0','775'),
	 (280,'GUAYAS','TENGUEL',1,1,0,'TE','TE','0','0','201001002','201001002017','0','0','336');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (281,'LOJA','12 DE DICIEMBRE',0,0,0,'TE','0','0','','201001012','','','','0'),
	 (282,'IMBABURA','ADUANA',1,1,0,'TE','TS','0','0','0','0','0','0','575'),
	 (283,'LOJA','ALAMOR',1,0,0,'TE','0','0','','201001012','','','','433'),
	 (284,'LOJA','ALGARROBILLO',1,0,0,'TE','0','0','','201001012','','','','763'),
	 (285,'IMBABURA','ALPACHACA',1,0,1,'TE','0','TN','0','0','0','1032','57818','101'),
	 (286,'LOJA','AMALUZA',1,0,0,'TE','0','0','','201001012','','','','748'),
	 (287,'IMBABURA','ANDRADE MARIN',1,1,1,'TE','TS','TN','0','201001011','201001011021','1032','57819','102'),
	 (288,'IMBABURA','ANTONIO ANTE',1,0,1,'TE','0','TE','0','201001011','201001011022','1032','56346','728'),
	 (289,'IMBABURA','ATUNTAQUI',1,1,1,'TE','TS','TE','0','201001011','201001011001','1032','57820','54'),
	 (290,'LOJA','CALVAS',0,1,0,'','TE','0','0','201001012','201001012017','0','0','0');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (291,'IMBABURA','CANVALLE-MILAGRO',0,1,0,'0','TE','0','0','0','0','0','0','0'),
	 (292,'IMBABURA','CARANQUI',1,1,1,'TE','TE','TN','0','201001011','201001011018','1032','57821','107'),
	 (293,'LOJA','CARIAMANGA',1,1,0,'TE','TE','0','','201001012','201001012004','','','432'),
	 (294,'LOJA','CATACOCHA',1,1,0,'TE','TE','0','','201001012','201001012005','','','471'),
	 (295,'LOJA','CATAMAYO',1,1,0,'TE','TE','0','','201001012','201001012002','','','429'),
	 (296,'LOJA','CELICA',1,1,0,'TE','TE','0','','201001012','201001012011','','','584'),
	 (297,'LOJA','CHAGUARPAMBA',1,0,0,'TE','0','0','','201001012','','','','585'),
	 (298,'IMBABURA','CHALTURA',1,1,1,'TE','TS','TE','0','201001011','201001011023','1032','57822','108'),
	 (299,'IMBABURA','CHORLAVI',1,1,1,'TE','TS','TN','0','201001011','201001011020','1032','57823','576'),
	 (300,'IMBABURA','COTACACHI',1,1,1,'TE','TE','TE','0','201001011','201001011006','1032','56347','255');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (301,'LOJA','CRUZPAMBA',1,0,0,'TE','0','0','','201001012','','','','764'),
	 (302,'LOJA','EL CISNE',0,0,0,'TE','0','0','','201001012','','','','0'),
	 (303,'LOJA','EL EMPALME/LOJA',1,1,0,'TE','0','0','','201001012','201001002011','','','767'),
	 (304,'LOJA','EL INGENIO',1,0,0,'TE','0','0','','201001012','','','','754'),
	 (305,'LOJA','EL LUCERO',1,0,0,'TE','0','0','','201001012','','','','756'),
	 (306,'IMBABURA','EL OLIVO',1,0,1,'TE','0','TN','0','0','0','1032','57824','577'),
	 (307,'IMBABURA','EL RETORNO',1,0,1,'TE','0','TN','0','0','0','1032','57825','578'),
	 (308,'LOJA','EL TAMBO/LOJA',0,0,0,'TE','0','0','','201001012','201001003009','','','0'),
	 (309,'IMBABURA','EUGENIO ESPEJO (CALPAQUI) ',0,0,1,'0','0','TE','0','0','0','1032','59086','0'),
	 (310,'IMBABURA','GONZALEZ SUAREZ',0,1,0,'0','TE','0','0','201001011','201001011012','0','0','0');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (311,'LOJA','GONZANAMA',1,1,0,'TE','TE','0','','201001012','201001012010','','','112'),
	 (312,'IMBABURA','IBARRA',1,1,1,'TP','TP','TN','0','201001011','201001011005','1032','56348','40'),
	 (313,'IMBABURA','IMANTAG',0,0,1,'0','0','TE','0','0','0','1032','59088','0'),
	 (314,'IMBABURA','IMBAYA (SAN LUIS DE COBUENDO) ',0,0,1,'0','0','TE','0','0','0','1032','59089','0'),
	 (315,'LOJA','LA CEIBA',1,0,0,'TE','0','0','','201001012','','','','762'),
	 (316,'IMBABURA','LA ESPERANZA/IMBABURA',0,0,1,'0','0','TE','0','0','0','1032','59153','0'),
	 (317,'LOJA','LOJA',1,1,1,'TE','TP','TN','','201001012','201001012001','1033','56358','15'),
	 (318,'LOJA','MACARA',1,1,0,'TE','TE','0','','201001012','201001019003','','','434'),
	 (319,'LOJA','MALACATOS',1,1,0,'TE','TE','0','','201001012','201001012006','','','586'),
	 (320,'LOJA','MERCADILLO',0,0,0,'TE','','0','','201001012','','','','0');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (321,'IMBABURA','MIRA/IMBABURA',0,1,0,'0','TE','0','0','0','0','0','0','0'),
	 (322,'IMBABURA','NATABUELA',1,1,1,'TE','TS','TE','0','201001011','201001011025','1032','57826','122'),
	 (323,'LOJA','OLMEDO',1,1,0,'TE','0','0','','201001012','201001014019','','','732'),
	 (324,'IMBABURA','OTAVALO',1,1,1,'TE','TP','TN','0','201001011','201001011002','1032','56349','56'),
	 (325,'LOJA','PALTAS',1,0,0,'TE','0','0','','201001012','','','','758'),
	 (326,'IMBABURA','PEGUCHE',0,1,1,'0','TE','TN','0','201001011','201001011013','1032','59091','0'),
	 (327,'SANTA ELENA','ANCON',1,1,1,'TE','TE','TE','0','201001023','201001002034','4125','57980','483'),
	 (328,'SANTA ELENA','ANCONCITO',1,1,1,'TE','TE','TE','0','201001023','201001002046','4125','57981','482'),
	 (329,'SANTA ELENA','ATAHUALPA',1,0,0,'TE','0','0','0','0','0','0','0','806'),
	 (330,'SANTA ELENA','AYANGUE',1,1,0,'TE','TE','0','0','201001023','201001023018','0','0','807');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (331,'SANTA ELENA','BALLENITA',1,1,1,'TE','TE','TE','0','201001023','201001014023','4125','57984','63'),
	 (332,'SANTA ELENA','BARCELONA',1,0,0,'TE','0','0','0','0','0','0','0','808'),
	 (333,'SANTA ELENA','CADEATE',1,1,0,'TE','TE','0','0','201001023','201001023008','0','0','649'),
	 (334,'IMBABURA','PERUGACHI',0,1,0,'0','TE','0','0','201001011','201001011030','0','0','0'),
	 (335,'SANTA ELENA','CAPAES',1,1,0,'TE','TE','0','0','201001023','201001023009','0','0','650'),
	 (336,'IMBABURA','PIMAMPIRO',1,1,0,'TE','TE','0','0','201001011','201001011003','0','0','252'),
	 (337,'LOJA','PINDAL',1,0,0,'TE','','0','','201001012','','','','459'),
	 (338,'IMBABURA','PINSAQUI',1,0,0,'TE','0','0','0','0','0','0','0','579'),
	 (339,'LOJA','POZUL',1,0,0,'TE','0','0','','','','','','587'),
	 (340,'SANTA ELENA','CHANDUY',1,0,0,'TE','0','0','0','0','0','0','0','809');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (341,'SANTA ELENA','CURIA',1,0,0,'TE','0','0','0','0','0','0','0','810'),
	 (342,'SANTA ELENA','EL TAMBO/SANTA ELENA',1,0,0,'TE','0','0','0','201001023','201001023020','0','0','651'),
	 (343,'IMBABURA','PUERTO LAGO',1,0,0,'TE','0','0','0','0','0','0','0','580'),
	 (344,'SANTA ELENA','JAMBELI MONTEVERDE',1,0,0,'TE','0','0','0','0','0','0','0','654'),
	 (345,'SANTA ELENA','LA ENTRADA',1,0,0,'TE','0','0','0','0','0','0','0','811'),
	 (346,'LOS RIOS','BABA',1,1,1,'TE','TE','TE','0','201001013','201001013013','1034','56368','374'),
	 (347,'LOS RIOS','BABAHOYO',1,1,1,'TR','TP','TN','0','201001013','201001013001','1034','56370','8'),
	 (348,'LOS RIOS','BUENA FE',1,1,1,'TE','TE','TE','0','201001013','201001013005','1034','56369','46'),
	 (349,'LOS RIOS','CALUMA/LOS RIOS',0,1,0,'0','TE','0','0','201001013','201001004007','0','0','0'),
	 (350,'LOS RIOS','CARACOL',1,0,1,'TE','0','TE','0','0','0','1034','57854','589');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (351,'LOS RIOS','CATARAMA',1,1,0,'TE','TE','0','0','201001013','201001012003','0','0','385'),
	 (352,'LOS RIOS','ECHEANDIA/LOS RIOS',0,1,0,'0','TE','0','0','201001013','201001004002','0','0','0'),
	 (353,'LOS RIOS','EL EMPALME/LOS RIOS',0,1,0,'0','TE','0','0','201001013','201001002011','0','0','227'),
	 (354,'LOS RIOS','ENTRADA DE SAN JUAN',1,0,0,'TE','0','0','0','0','0','0','0','590'),
	 (355,'LOS RIOS','FEBRES CORDERO',1,0,0,'TE','0','0','0','0','0','0','0','781'),
	 (356,'LOS RIOS','FUMISA',1,0,0,'TE','0','0','0','0','0','0','0','591'),
	 (357,'LOS RIOS','GUARE',0,1,0,'0','TE','0','0','201001013','201001013027','0','0','0'),
	 (358,'LOS RIOS','GUARE DE BABA',1,0,0,'TE','0','0','0','0','0','0','0','782'),
	 (359,'LOS RIOS','ISLA DE BEJUCAL',1,1,0,'TE','TE','0','0','201001013','201001013021','0','0','375'),
	 (360,'LOS RIOS','LA 14 VIA EL PARAISO',1,0,0,'TE','0','0','0','0','0','0','0','734');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (361,'LOS RIOS','LA CARMELA - GUARE',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (362,'LOS RIOS','LA ESMERALDA',1,0,0,'TE','0','0','0','0','0','0','0','785'),
	 (363,'LOS RIOS','LA ESPERANZA/LOS RIOS',1,1,0,'TE','TE','0','0','201001013','201001013026','0','0','593'),
	 (364,'LOS RIOS','LA JULIA',1,1,0,'TE','TE','0','0','201001013','201001013025','0','0','594'),
	 (365,'LOS RIOS','LA UNION BABAHOYO',1,0,1,'TE','0','TE','0','0','0','1034','57866','381'),
	 (366,'LOS RIOS','LA UNION VALENCIA',1,1,1,'TE','TE','TN','0','201001013','201001013024','1034','57867','595'),
	 (367,'LOS RIOS','MATA DE CACAO',1,0,0,'TE','0','0','0','0','0','0','0','380'),
	 (368,'LOS RIOS','MOCACHE',1,1,1,'TE','TE','TE','0','201001013','201001013007','1034','56371','232'),
	 (369,'LOS RIOS','MONTALVO/LOS RIOS',1,1,0,'TE','TE','0','0','201001013','201001013009','0','0','377'),
	 (370,'LOS RIOS','NUEVA UNION (LOS RIOS)',1,0,0,'TE','0','0','0','0','0','0','0','596');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (371,'LOS RIOS','PALENQUE',1,1,0,'TE','TE','0','0','201001013','201001002036','0','0','378'),
	 (372,'LOS RIOS','PALMISA',1,0,0,'TE','0','0','0','0','0','0','0','597'),
	 (373,'LOS RIOS','PATRICIA PILAR/LOS RIOS',1,0,0,'TE','0','0','0','201001013','201001013010','0','0','280'),
	 (374,'LOS RIOS','PIMOCHA',1,0,1,'TE','0','TE','0','0','0','1034','57873','790'),
	 (375,'LOS RIOS','PROGRESO/LOS RIOS',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (376,'LOS RIOS','PUEBLO NUEVO LOS RIOS',1,0,0,'TE','0','0','0','0','0','0','0','733'),
	 (377,'LOS RIOS','PUEBLO VIEJO',1,1,1,'TE','TE','TE','0','201001013','201001013012','1034','56374','384'),
	 (378,'LOS RIOS','QUEVEDO',1,1,1,'TR','TP','TN','0','201001013','201001013002','1034','56375','9'),
	 (379,'LOS RIOS','QUINSALOMA',1,1,0,'TE','TE','0','0','201001013','201001013019','0','0','71'),
	 (380,'LOS RIOS','RECINTO 3 MARIAS',0,0,0,'TE','0','0','0','0','0','0','0','0');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (381,'LOS RIOS','RICAURTE/LOS RIOS',1,1,0,'TE','TE','0','0','0','0','0','0','387'),
	 (382,'LOS RIOS','SAN CAMILO',1,1,1,'TE','TE','TE','0','201001013','201001013014','1034','57876','55'),
	 (383,'LOS RIOS','SAN CARLOS',0,1,1,'0','TE','TE','0','201001013','201001013015','1034','57877','233'),
	 (384,'LOS RIOS','SAN CARLOS (LOS RIOS)',1,0,0,'TE','0','0','0','0','0','0','0','233'),
	 (385,'LOS RIOS','SAN JACINTO DE BUENA FE',0,1,0,'0','TE','0','0','201001013','201001013023','0','0','0'),
	 (386,'LOS RIOS','SAN JOSE DEL TAMBO',1,0,0,'TE','0','0','0','0','0','0','0','794'),
	 (387,'LOS RIOS','SAN JUAN/LOS RIOS',1,0,0,'TE','0','0','0','201001013','201001013008','0','0','386'),
	 (388,'LOS RIOS','SAN JUAN BABAHOYO',0,1,0,'0','TE','0','0','201001013','201001013022','0','0','386'),
	 (389,'LOS RIOS','SAN LUIS DE PAMBIL',1,0,0,'TE','0','0','0','0','0','0','0','735'),
	 (390,'LOS RIOS','TRES POSTES',0,1,0,'0','TE','0','0','0','0','0','0','0');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (391,'LOS RIOS','URDANETA',1,0,0,'TE','0','0','0','0','0','0','0','133'),
	 (392,'LOS RIOS','VALENCIA',1,1,1,'TE','TE','TE','0','201001013','201001013004','1034','56377','181'),
	 (393,'LOS RIOS','VENTANAS',1,1,1,'TR','TE','TN','0','201001013','201001013003','1034','56378','12'),
	 (394,'LOS RIOS','VINCES',1,1,1,'TE','TE','TN','0','201001013','201001013006','1034','56379','57'),
	 (395,'LOS RIOS','ZAPOTAL',0,0,1,'0','0','TE','0','0','0','1034','57881','134'),
	 (396,'LOS RIOS','ZAPOTAL (LOS RIOS)',1,0,0,'TE','0','0','0','0','0','0','0','134'),
	 (397,'LOS RIOS','ZULEMA',0,0,0,'0','0','0','0','0','0','0','0','774'),
	 (398,'MANABI','ABDON CALDERON (SAN FRANCISCO)',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (399,'MANABI','ALHAJUELA',1,1,1,'TE','TE','TE','0','0','','1035','57883','777'),
	 (400,'MANABI','ARENALES',1,0,0,'TE','0','0','0','0','0','0','0','601');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (401,'MANABI','ATAHUALPA MANABI',1,0,0,'TE','0','0','0','0','0','0','0','602'),
	 (402,'MANABI','AYACUCHO',1,0,0,'TE','0','0','0','0','0','0','0','778'),
	 (403,'MANABI','AYAMPE',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (404,'MANABI','BACHILLERO',1,0,0,'TE','0','0','0','0','0','0','0','103'),
	 (405,'MANABI','BAHIA DE CARAQUEZ',1,1,0,'TR','TP','0','0','201001014','201001014003','0','0','30'),
	 (406,'MANABI','BASE NAVAL JARAMIJO',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (407,'MANABI','BELLAVISTA/MANABI',1,0,0,'TE','0','0','0','0','0','0','0','105'),
	 (408,'MANABI','CALCETA',1,1,1,'TE','TS','TE','0','201001014','201001014016','1035','57890','53'),
	 (409,'MANABI','CALDERON (MANABI)',1,1,0,'TE','TE','0','0','0','0','0','0','397'),
	 (410,'MANABI','CANITAS',1,1,0,'TE','TE','0','0','0','0','0','0','606');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (411,'MANABI','CANOA',1,0,0,'TE','0','0','0','0','0','0','0','424'),
	 (412,'MANABI','CANUTO',1,1,1,'TE','TS','TE','0','201001014','201001014032','1035','57894','106'),
	 (413,'MANABI','CASCOL',1,0,0,'TE','0','0','0','0','0','0','0','427'),
	 (414,'MANABI','CERECITO (VIA CRUCITA)',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (415,'MANABI','CHARAPOTO',1,1,0,'TE','TE','0','0','201001014','201001014015','0','0','417'),
	 (416,'MANABI','CHEVE',1,0,0,'TE','0','0','0','0','0','0','0','607'),
	 (417,'MANABI','CHONE',1,1,1,'TR','TS','TN','0','201001014','201001014004','1035','56381','95'),
	 (418,'MANABI','CIUDAD ALFARO',1,0,0,'TE','0','0','0','0','0','0','0','608'),
	 (419,'MANABI','COAQUE',1,0,0,'TE','0','0','0','0','0','0','0','609'),
	 (420,'MANABI','COJIMIES',1,0,0,'TE','0','0','0','0','0','0','0','610');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (421,'MANABI','COLON',1,1,0,'TE','TE','0','0','201001014','201001014011','0','0','399'),
	 (422,'MANABI','COLORADO',1,1,0,'TE','TE','0','0','201001014','201001014044','0','0','684'),
	 (423,'MANABI','COSTA AZUL',0,1,0,'0','TE','0','0','0','0','0','0','0'),
	 (424,'MANABI','CRUCITA',1,1,1,'TE','TE','TE','0','201001014','201001014010','1035','57903','400'),
	 (425,'MANABI','DON JUAN',1,0,0,'TE','0','0','0','0','0','0','0','611'),
	 (426,'MANABI','EL CARMEN',1,1,1,'TE','TP','TN','0','201001014','201001014005','1035','56382','74'),
	 (427,'MANABI','EL MATAL',1,0,0,'TE','0','0','0','0','0','0','0','612'),
	 (428,'MANABI','EL NARANJO',1,0,0,'TE','0','0','0','0','0','0','0','780'),
	 (429,'MANABI','EL RODEO',1,0,0,'TE','0','0','0','0','0','0','0','613'),
	 (430,'MANABI','ESTANCILLA',0,1,0,'0','TS','0','0','201001014','201001014033','0','0','0');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (431,'MANABI','FLAVIO ALFARO',1,1,0,'TE','TS','0','0','201001014','201001014021','0','0','413'),
	 (432,'MANABI','HIGUERON (VIA CRUCITA)',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (433,'MANABI','JAMA',1,1,0,'TE','TE','0','0','201001014','201001014024','0','0','421'),
	 (434,'MANABI','JARAMIJO',1,1,1,'TE','TE','TE','0','201001014','201001014013','1035','56387','409'),
	 (435,'MANABI','JIPIJAPA',1,1,0,'TR','TE','0','0','201001014','201001014006','0','0','97'),
	 (436,'MANABI','JUNIN',1,1,0,'TE','TS','0','0','201001014','201001014009','0','0','414'),
	 (437,'MANABI','LA CHORRERA',1,0,0,'TE','0','0','0','0','0','0','0','739'),
	 (438,'MANABI','LA DELICIA KM. 29',0,1,0,'0','TE','0','0','201001014','201001014035','0','0','0'),
	 (439,'MANABI','LA ESTANCILLA',1,0,0,'TE','0','0','0','0','0','0','0','412'),
	 (440,'MANABI','LA SEGUA',0,0,0,'TE','0','0','0','0','0','0','0','0');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (441,'MANABI','LA SEQUITA',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (442,'MANABI','LAS TUNAS',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (443,'MANABI','LEONIDAS PLAZA',1,1,0,'TE','TE','0','0','201001014','201001014027','0','0','415'),
	 (444,'MANABI','LODANA',1,0,0,'TE','0','0','0','0','0','0','0','614'),
	 (445,'MANABI','LOS BAJOS',1,0,0,'TE','0','0','0','0','0','0','0','615'),
	 (446,'MANABI','MACHALILLA',1,0,0,'TE','0','0','0','0','0','0','0','117'),
	 (447,'MANABI','MANTA',1,1,1,'TR','TP','TN','0','201001014','201001014001','1035','56388','13'),
	 (448,'MANABI','MEJIA',1,0,0,'TE','0','0','0','0','0','0','0','788'),
	 (449,'MANABI','MONTECRISTI',1,1,1,'TE','TE','TE','0','201001014','201001014020','1035','56389','90'),
	 (450,'MANABI','NUEVO BRICENO',1,0,0,'TE','0','0','0','0','0','0','0','617');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (451,'MANABI','NUEVO ISRAEL',0,1,0,'0','TE','0','0','201001014','201001017009','0','0','0'),
	 (452,'MANABI','OLMEDO (MANABI)',1,1,0,'TE','TE','0','0','0','0','0','0','398'),
	 (453,'MANABI','PAJAN',1,1,0,'TE','TE','0','0','201001014','201001014014','0','0','425'),
	 (454,'MANABI','PAQUISHA',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (455,'MANABI','PAVON',1,0,0,'TE','0','0','0','0','0','0','0','789'),
	 (456,'MANABI','PEDERNALES',1,1,0,'TE','TS','0','0','201001014','201001010009','0','0','70'),
	 (457,'MANABI','PICHINCHA',1,1,0,'TE','TE','0','0','0','0','0','0','234'),
	 (458,'MANABI','PICOAZA DENTRO DEL PERIMETRO URBANO',0,1,0,'0','TE','0','0','201001014','201001014037','0','0','0'),
	 (459,'MANABI','PLAYA PRIETA',1,0,0,'TE','0','0','0','0','0','0','0','740'),
	 (460,'MANABI','PORTOVIEJO',1,1,1,'TR','TP','TN','0','201001014','201001014002','1035','56395','3');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (461,'MANABI','PUEBLO NUEVO',1,0,1,'TE','0','TE','0','0','0','1035','57874','126'),
	 (462,'MANABI','PUEBLO NUEVO /  MANABI',1,0,0,'TE','0','0','0','0','0','0','0','126'),
	 (463,'MANABI','PUERTO CAYO',0,1,0,'TE','TE','0','0','201001014','201001014029','0','0','0'),
	 (464,'MANABI','PUERTO CHICO',1,0,0,'TE','0','0','0','0','0','0','0','599'),
	 (465,'MANABI','PUERTO LOPEZ',1,1,0,'TE','TE','0','0','201001014','201001014022','0','0','426'),
	 (466,'MANABI','QUIROGA CHONE',0,1,0,'0','TS','0','0','201001014','201001014043','0','0','0'),
	 (467,'MANABI','RESBALON',1,0,0,'TE','0','0','0','0','0','0','0','792'),
	 (468,'MANABI','RICAURTE/MANABI',1,1,1,'TE','TS','TE','0','201001014','201001014040','1035','59150','737'),
	 (469,'MANABI','RIO CHICO',1,1,1,'TE','TE','TE','0','201001014','201001014039','1035','57921','599'),
	 (470,'MANABI','ROCAFUERTE',1,1,1,'TE','TE','TE','0','201001014','201001014012','1035','56396','401');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (471,'MANABI','SALAITE',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (472,'MANABI','SALANGO',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (473,'MANABI','SAN ANTONIO / MANABI',1,0,0,'TE','0','0','0','0','0','0','0','738'),
	 (474,'MANABI','SAN ANTONIO DE CHONE',0,1,0,'0','TS','0','0','201001014','201001014034','0','0','0'),
	 (475,'MANABI','SAN CLEMENTE',1,0,0,'TE','0','0','0','0','0','0','0','618'),
	 (476,'MANABI','SAN IGNACIO',1,0,0,'TE','0','0','0','0','0','0','0','793'),
	 (477,'MANABI','SAN ISIDRO / BAHIA',1,0,0,'TE','0','0','0','0','0','0','0','423'),
	 (478,'MANABI','SAN JACINTO',1,0,0,'TE','0','0','0','201001014','201001014025','0','0','419'),
	 (479,'MANABI','SAN PEDRO DE SUMA',0,0,1,'0','0','TE','0','0','0','1035','59099','0'),
	 (480,'MANABI','SAN PLACIDO',1,1,1,'TE','TE','TE','0','201001014','201001014038','1035','57927','619');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (481,'MANABI','SAN VICENTE',1,1,0,'TE','TE','0','0','201001014','201001014018','0','0','416'),
	 (482,'MANABI','SANCAN',1,0,0,'TE','0','0','0','0','0','0','0','620'),
	 (483,'MANABI','SANTA ANA / MANABI',1,1,0,'TE','TE','0','0','0','0','0','0','402'),
	 (484,'MANABI','SANTA RITA',0,0,0,'TR','0','0','0','0','0','0','0','0'),
	 (485,'MANABI','SESME',1,0,0,'TE','0','0','0','0','0','0','0','795'),
	 (486,'MANABI','SOSOTE',1,0,0,'TE','0','0','0','0','0','0','0','622'),
	 (487,'MANABI','SUCRE',0,1,0,'0','TE','0','0','201001014','201001014042','0','0','0'),
	 (488,'MANABI','SUCRE BAHIA',1,0,0,'TE','0','0','0','0','0','0','0','736'),
	 (489,'MANABI','TARQUI MANABÍ',0,1,0,'0','TE','0','0','201001014','201001014041','0','0','0'),
	 (490,'MANABI','TOSAGUA',1,1,1,'TE','TS','TE','0','201001014','201001014017','1035','56400','73');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (491,'MANABI','VALDEZ',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (492,'MANABI','ZAPALLO',1,0,0,'TE','0','0','0','0','0','0','0','796'),
	 (493,'MORONA SANTIAGO','GENERAL PROAÑO',0,0,1,'0','0','TE','0','0','0','1036','59100','0'),
	 (494,'MORONA SANTIAGO','GUALAQUIZA',1,1,0,'TE','TO','0','0','201001015','201001015002','0','0','33'),
	 (495,'MORONA SANTIAGO','HUAMBOYA',1,1,0,'TE','0','0','0','201001019','201001019011','0','0','800'),
	 (496,'MORONA SANTIAGO','LIMON INDANZA',1,0,0,'TE','0','0','0','0','0','0','0','494'),
	 (497,'MORONA SANTIAGO','LOGRONO',1,0,0,'TE','0','0','0','0','0','0','0','801'),
	 (498,'MORONA SANTIAGO','MACAS',1,1,1,'TE','TO','TN','0','201001015','201001015001','1036','57932','85'),
	 (499,'MORONA SANTIAGO','MENDEZ',1,0,0,'TE','0','0','0','0','0','0','0','495'),
	 (500,'MORONA SANTIAGO','PABLO SEXTO',1,0,0,'TE','0','0','0','0','0','0','0','802');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (501,'MORONA SANTIAGO','PALORA',1,0,0,'TE','0','0','0','0','0','0','0','297'),
	 (502,'MORONA SANTIAGO','RIO BLANCO',0,0,1,'0','0','TE','0','0','0','1036','59101','0'),
	 (503,'MORONA SANTIAGO','SAN ISIDRO',0,0,1,'0','0','TE','0','0','0','1036','59102','0'),
	 (504,'MORONA SANTIAGO','SEVILLA DON BOSCO',0,0,1,'0','0','TE','0','0','0','1036','59103','0'),
	 (505,'MORONA SANTIAGO','SUCUA',1,1,0,'TE','TO','0','0','201001015','201001017007','0','0','773'),
	 (506,'MORONA SANTIAGO','TIWINTZA',1,0,0,'TE','0','0','0','0','0','0','0','822'),
	 (507,'NAPO','ARCHIDONA',1,1,1,'TE','TO','TE','0','201001016','201001016003','1037','56413','624'),
	 (508,'NAPO','AROSEMENA TOLA',1,1,0,'TE','TO','0','0','201001016','201001016006','0','0','298'),
	 (509,'NAPO','BAEZA',1,0,0,'TE','0','0','0','0','0','0','0','489'),
	 (510,'NAPO','BORJA',1,0,0,'TE','0','0','0','0','0','0','0','492');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (511,'NAPO','CARLOS JULIO AROSEMENA',0,1,0,'0','TO','0','0','201001016','201001016009','0','0','0'),
	 (512,'NAPO','CARLOS JULIO AROSEMENA TOLA',0,1,0,'0','TO','0','0','201001016','201001016008','0','0','0'),
	 (513,'NAPO','COTUNDO',1,0,1,'TE','0','TE','0','0','0','1037','57938','741'),
	 (514,'NAPO','EL CHACO',1,1,0,'TE','TO','0','0','201001016','201001017012','0','0','491'),
	 (515,'NAPO','GONZALO PIZARRO',1,0,0,'TE','0','0','0','0','0','0','0','625'),
	 (516,'NAPO','MISAHUALLI',0,1,0,'0','TO','0','0','201001016','201001016005','0','0','0'),
	 (517,'NAPO','NUEVA ESPERANZA',1,0,0,'TE','0','0','0','0','0','0','0','626'),
	 (518,'NAPO','PANO ',0,0,1,'0','0','TE','0','0','0','1037','59104','0'),
	 (519,'NAPO','PUERTO MISAHUALLI',0,0,1,'0','0','TE','0','0','0','1037','59105','0'),
	 (520,'NAPO','PUERTO NAPO',1,1,1,'TE','TO','TE','0','201001016','201001016007','1037','57941','627');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (521,'NAPO','SAN PABLO DE USHPAYACU',0,0,1,'0','0','TE','0','0','0','1037','59106','0'),
	 (522,'NAPO','TAZAYACU',1,0,0,'TE','0','0','0','0','0','0','0','742'),
	 (523,'NAPO','TENA',1,1,1,'TE','TO','TN','0','201001016','201001016001','1037','56417','78'),
	 (524,'ORELLANA','EL COCA',1,1,1,'TE','TO','TN','0','201001017','201001017002','1038','57943','38'),
	 (525,'ORELLANA','JOYA DE LOS SACHAS',1,1,1,'TE','TO','TN','0','201001017','201001017006','1038','56420','291'),
	 (526,'ORELLANA','LORETO',1,1,0,'TE','TO','0','0','201001017','201001017016','0','0','116'),
	 (527,'ORELLANA','PUERTO FRANCISCO DE ORELLANA (EL COCA)',0,0,1,'0','0','TN','0','0','0','1038','57318','0'),
	 (528,'ORELLANA','FRANCISCO DE ORELLANA',0,0,1,'0','0','TN','0','201001017','201001017001','1038','56419','0'),
	 (529,'ORELLANA','ENOKANQUI ',0,0,1,'0','0','TE','0','0','0','1038','59107','0'),
	 (530,'ORELLANA','SAN CARLOS',0,0,1,'0','0','TE','0','0','0','1038','59109','0');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (531,'ORELLANA','SAN SEBASTIAN DEL COCA',0,0,1,'0','0','TE','0','0','0','1038','59110','0'),
	 (532,'ORELLANA','LAGO SAN PEDRO',0,0,1,'0','0','TE','0','0','0','1038','59108','0'),
	 (533,'ORELLANA','UNION MILAGREÑA',0,0,1,'0','0','TE','0','0','0','1038','59111','0'),
	 (534,'PASTAZA','10 DE AGOSTO',0,0,1,'TE','0','TE','0','0','0','1039','59112','0'),
	 (535,'PASTAZA','AMERICAS',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (536,'PASTAZA','ARAJUNO ',1,0,0,'TE','0','0','0','0','0','0','0','798'),
	 (537,'PASTAZA','EL CAPRICHO',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (538,'PASTAZA','EL TRIUNFO/PASTAZA',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (539,'PASTAZA','MERA',1,0,1,'TE','0','TE','0','0','0','1039','56423','296'),
	 (540,'PASTAZA','PUYO',1,1,1,'TE','TO','TN','0','201001018','201001018001','1039','57319','22');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (541,'PASTAZA','SAN JOSE',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (542,'PASTAZA','SANTA CLARA',1,0,0,'TE','0','0','0','0','0','0','0','293'),
	 (543,'PASTAZA','SHELL (EL PUYO)',1,0,1,'TE','0','TE','0','0','0','1039','57660','295'),
	 (544,'PASTAZA','TNT HUGO ORTIZ',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (545,'PASTAZA','SHELL ',0,1,1,'0','TO','TE','0','201001018','201001017004','1039','57660','295'),
	 (546,'PASTAZA','FATIMA',0,0,1,'0','0','TE','0','0','0','1039','59113','292'),
	 (547,'PICHINCHA','ALANGASI',1,1,1,'TL','TS','TE','0','201001001','201001001031','1040','57944','628'),
	 (548,'PICHINCHA','ALOAG',1,1,0,'TE','TE','0','0','201001001','201001001019','0','0','441'),
	 (549,'PICHINCHA','ALOASI',1,1,0,'TE','TS','0','0','201001001','201001001046','0','0','629'),
	 (550,'PICHINCHA','AMAGUANA',1,1,1,'TL','TS','TE','0','201001001','201001001018','1040','57947','442');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (551,'PICHINCHA','ASCAZUBI ',0,1,0,'0','TE','0','0','201001001','201001001062','0','0','0'),
	 (552,'PICHINCHA','AYORA',1,1,1,'TE','TE','TE','0','201001001','201001001042','1040','57948','630'),
	 (553,'PICHINCHA','BICENTENARIO - REPLICA MONTUFAR',0,1,0,'0','TS','0','0','0','0','0','0','0'),
	 (554,'PICHINCHA','CAJAS',0,1,0,'0','TE','0','0','0','0','0','0','0'),
	 (555,'PICHINCHA','CALACALI',1,1,0,'TL','TS','0','0','201001001','201001001022','0','0','631'),
	 (556,'PICHINCHA','CALDERON',1,1,1,'TL','TS','TN','0','201001001','201001001024','1040','57891','632'),
	 (557,'PICHINCHA','CAYAMBE',1,1,1,'TC','TP','TN','0','201001001','201001001002','1040','56426','48'),
	 (558,'PICHINCHA','CHECA/PICHINCHA',0,1,0,'0','TE','0','0','201001001','201001001063','0','0','0'),
	 (559,'PICHINCHA','COLINAS DEL NORTE',0,1,0,'0','TE','0','0','0','0','0','0','0'),
	 (560,'PICHINCHA','CONOCOTO',1,1,1,'TL','TS','TN','0','201001001','201001001033','1040','57951','444');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (561,'PICHINCHA','COTOGCHOA',0,0,1,'0','0','TE','0','0','0','1040','59114','0'),
	 (562,'PICHINCHA','CUMBAYA',1,1,1,'TL','TS','TN','0','201001001','201001001009','1040','57952','47'),
	 (563,'PICHINCHA','CUSUBAMBA',1,1,0,'TE','TE','0','0','0','0','0','0','633'),
	 (564,'PICHINCHA','EL CHAUPI',0,1,0,'0','TE','0','0','201001001','201001001071','0','0','0'),
	 (565,'PICHINCHA','EL QUINCHE',0,1,0,'0','TE','0','0','201001001','201001001007','0','0','0'),
	 (566,'PICHINCHA','GOLONDRINAS',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (567,'PICHINCHA','GUANGOPOLO',0,1,1,'0','TE','TN','0','201001001','201001001070','1040','59115','0'),
	 (568,'PICHINCHA','GUAYLLABAMBA',1,1,0,'TE','TE','0','0','201001001','201001001014','0','0','445'),
	 (569,'PICHINCHA','JUAN MONTALVO',1,1,0,'TE','TE','0','0','201001001','201001001045','0','0','635'),
	 (570,'PICHINCHA','LA ARMENIA',1,1,1,'TL','TS','TN','0','201001001','201001001047','1040','57957','636');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (571,'PICHINCHA','LA ESPERANZA/PICHINCHA',0,1,1,'0','TS','TE','0','201001013','201001013026','1040','59154','0'),
	 (572,'PICHINCHA','LA MERCED',0,0,1,'0','0','TN','0','0','0','1040','59117','113'),
	 (573,'PICHINCHA','LA ROLDOS',0,1,0,'0','TE','0','0','0','0','0','0','0'),
	 (574,'PICHINCHA','LA SEXTA',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (575,'PICHINCHA','LLANO CHICO',1,1,1,'TL','TS','TN','0','201001001','201001001048','1040','57958','637'),
	 (576,'PICHINCHA','LLANO GRANDE',1,1,1,'TL','TS','TN','0','201001001','201001001049','1040','57959','686'),
	 (577,'PICHINCHA','MACHACHI',1,1,0,'TC','TS','0','0','201001001','201001001008','0','0','455'),
	 (578,'PICHINCHA','MEJIA',1,1,0,'TE','TE','0','0','201001001','201001001069','0','0','743'),
	 (579,'PICHINCHA','MIRAVALLE',1,1,1,'TL','TS','TN','0','201001001','201001001051','1040','57961','687'),
	 (580,'PICHINCHA','MITAD DEL MUNDO',0,1,0,'0','TS','0','0','201001001','201001001021','0','0','29');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (581,'PICHINCHA','MONJAS',1,1,0,'TL','TS','0','0','201001001','201001002043','0','0','639'),
	 (582,'PICHINCHA','NANEGALITO',1,1,0,'TE','TE','0','0','201001001','201001001029','0','0','121'),
	 (583,'PICHINCHA','NAYON ',0,0,1,'0','0','TN','0','0','0','1040','59155','0'),
	 (584,'PICHINCHA','NONO',0,1,0,'0','TE','0','0','201001001','201001001068','0','0','0'),
	 (585,'PICHINCHA','OLMEDO (PESILLO)',0,0,0,'0','0','0','0','0','0','0','0','0'),
	 (586,'PICHINCHA','ORQUIDEAS',0,1,0,'0','TS','0','0','201001001','201001001052','0','0','0'),
	 (587,'PICHINCHA','OTON',0,1,1,'0','TE','TE','0','201001003','201001003023','1040','59156','0'),
	 (588,'PICHINCHA','PEDRO MONCAYO',0,1,1,'0','TE','TE','0','201001001','201001001035','1040','56428','0'),
	 (589,'PICHINCHA','PEDRO VICENTE MALDONADO',1,1,0,'TE','TE','0','0','0','0','0','0','451'),
	 (590,'PICHINCHA','PIFO',1,1,1,'TL','TS','TE','0','201001001','201001001025','1040','57964','448');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (591,'PICHINCHA','PINTAG',1,1,1,'TL','TS','TE','0','201001001','201001001036','1040','57965','641'),
	 (592,'PICHINCHA','PISULI',0,1,0,'0','TE','0','0','0','0','0','0','0'),
	 (593,'PICHINCHA','PLANADA',0,1,0,'0','TE','0','0','0','0','0','0','0'),
	 (594,'PICHINCHA','POMASQUI',1,1,1,'TL','TS','TE','0','201001001','201001001028','1040','57966','130'),
	 (595,'PICHINCHA','PUEMBO',1,1,1,'TL','TS','TN','0','201001001','201001001026','1040','57967','449'),
	 (596,'PICHINCHA','PUERTO QUITO',1,1,0,'TE','TE','0','0','201001001','201001001013','0','0','452'),
	 (597,'PICHINCHA','PUSUQUI',1,1,1,'TL','TS','TN','0','201001001','201001001041','1040','57968','463'),
	 (598,'PICHINCHA','QUINCHE',1,0,0,'TE','0','0','0','0','0','0','0','450'),
	 (599,'PICHINCHA','QUITO',1,1,1,'TL','TL','TN','0','201001001','201001001001','1040','56431','2'),
	 (600,'PICHINCHA','RUMIÑAHUI',0,1,1,'0','TE','TN','0','201001001','201001001066','1040','56432','0');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (601,'PICHINCHA','RUMIPAMBA/PICHINCHA',0,1,0,'0','TE','0','0','201001001','201001001065','0','0','0'),
	 (602,'PICHINCHA','SAN ANTONIO DE PICHINCHA',1,1,1,'TC','TS','TE','0','201001001','201001001053','1040','57970','642'),
	 (603,'PICHINCHA','SAN JOSE DE MORAN',1,1,1,'TC','TS','TN','0','201001001','201001001054','1040','57971','643'),
	 (604,'PICHINCHA','SAN JUAN DE CALDERON',1,0,1,'TC','0','TN','0','0','0','1040','57972','644'),
	 (605,'PICHINCHA','SAN MIGUEL DE LOS BANCOS',1,1,0,'TE','TE','0','0','201001001','201001001010','0','0','645'),
	 (606,'PICHINCHA','SAN MIGUEL DE OYACOTO',0,1,0,'0','TS','0','0','0','0','0','0','0'),
	 (607,'PICHINCHA','SAN RAFAEL',1,1,1,'TE','TS','TN','0','201001001','201001001006','1040','59094','27'),
	 (608,'PICHINCHA','SANGOLQUI',1,1,1,'TC','TS','TN','0','201001001','201001001005','1040','57974','28'),
	 (609,'PICHINCHA','TABABELA',1,1,1,'TC','TS','TE','0','201001001','201001001056','1040','57975','646'),
	 (610,'PICHINCHA','TABACUNDO',1,1,1,'TE','TE','TE','0','201001001','201001001003','1040','57976','454');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (611,'PICHINCHA','TAMBILLO',1,1,0,'TE','TS','0','0','201001001','201001021003','0','0','456'),
	 (612,'PICHINCHA','TOCACHI',0,0,1,'0','0','TE','0','0','0','1040','59157','0'),
	 (613,'PICHINCHA','TUMBACO',1,1,1,'TL','TS','TN','0','201001001','201001001020','1040','59158','31'),
	 (614,'PICHINCHA','TUPIGACHI',0,0,1,'0','TE','TE','0','0','0','1040','59159','0'),
	 (615,'PICHINCHA','UYUMBICHO',1,1,0,'TC','TS','0','0','201001001','201001001057','0','0','647'),
	 (616,'PICHINCHA','VALLE DE LOS CHILLOS',0,1,0,'0','TL','0','0','201001001','201001001039','0','0','0'),
	 (617,'PICHINCHA','YARUQUI',0,1,1,'0','TS','TE','0','201001001','201001001037','1040','59160','453'),
	 (618,'PICHINCHA','ZAMBISA',0,1,0,'0','TS','0','0','201001001','201001001058','0','0','648'),
	 (619,'SANTA ELENA','LA LIBERTAD',1,1,1,'TR','TP','TN','0','201001023','201001002013','4125','56435','14'),
	 (620,'SANTA ELENA','LIBERTADOR BOLIVAR',1,1,0,'TE','TE','0','0','201001023','201001023010','0','0','653');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (621,'LOJA','QUILANGA',1,0,0,'TE','0','0','0','0','0','0','0','755'),
	 (622,'IMBABURA','QUIROGA',1,1,1,'TE','TE','TE','0','201001011','201001011014','1032','57829','127'),
	 (623,'IMBABURA','QUIROGA OTAVALO',0,1,0,'0','TE','0','0','201001011','201001011032','0','0','127'),
	 (624,'SANTA ELENA','MANGLARALTO',1,1,0,'TE','TE','0','0','201001023','201001023011','0','0','480'),
	 (625,'SANTA ELENA','MAR BRAVA',0,1,0,'','TE','0','','','','','',''),
	 (626,'SANTA ELENA','MONTANITA',1,1,0,'TE','TE','0','0','201001023','201001023003','0','0','62'),
	 (627,'SANTA ELENA','MONTEVERDE',0,1,0,'','TE','0','','','','','',''),
	 (628,'SANTA ELENA','MUEY',1,1,1,'TE','TE','TE','0','201001023','201001023005','4125','57996','342'),
	 (629,'SANTA ELENA','OLON',1,1,0,'TE','TE','0','0','201001023','201001023006','0','0','655'),
	 (630,'SANTA ELENA','OLONCITO',1,0,0,'TE','0','0','0','0','0','0','0','655');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (631,'SANTA ELENA','PALMAR',1,1,0,'TE','TE','0','0','201001023','201001023013','0','0','477'),
	 (632,'LOJA','RIO PLAYAS',1,0,0,'TE','0','0','0','0','0','0','0','765'),
	 (633,'SANTA ELENA','PROSPERIDAD',1,1,0,'TE','TE','0','0','201001023','201001023014','0','0','656'),
	 (634,'SANTA ELENA','PUERTE SANTA ROSA',0,1,0,'','TE','0','','','','','',''),
	 (635,'SANTA ELENA','PUNTA BARANDUA',1,1,0,'TE','TE','0','0','201001023','201001023015','0','0','657'),
	 (636,'SANTA ELENA','PUNTA BLANCA',1,1,0,'TE','TE','0','0','201001023','201001023002','0','0','474'),
	 (637,'SANTA ELENA','PUNTA CARNERO',1,1,0,'TE','TE','0','0','201001023','201001023001','0','0','658'),
	 (638,'SANTA ELENA','PUNTA CENTINELA',1,1,0,'TE','TE','0','0','201001023','201001023019','0','0','475'),
	 (639,'LOJA','ROBLONES',1,0,0,'TE','0','0','0','0','0','0','0','761'),
	 (640,'LOJA','SABANILLA',1,0,0,'TE','0','0','0','0','0','0','0','760');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (641,'LOJA','SABIANGO',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (642,'IMBABURA','SAN ANTONIO ',0,0,0,'0','0','0','0','0','0','0','0','0'),
	 (643,'IMBABURA','SAN ANTONIO DE IBARRA',1,1,1,'TE','TS','TE','0','201001011','201001001027','1032','57830','250'),
	 (644,'SANTA ELENA','SALINAS/ SANTA ELENA',1,1,0,'TE','TE','0','0','201001023','201001002004','0','0','5'),
	 (645,'IMBABURA','SAN BLAS',0,0,1,'0','0','TE','0','0','0','1032','59092','0'),
	 (646,'SANTA ELENA','SAN JOSE',1,0,0,'TE','0','0','0','0','0','0','0','816'),
	 (647,'IMBABURA','SAN FRANCISCO DE NATABUELA',0,0,0,'0','0','0','0','0','0','0','0','0'),
	 (648,'SANTA ELENA','SAN PABLO / SANTA ELENA',1,1,0,'TE','TE','0','0','0','0','0','0','651'),
	 (649,'IMBABURA','SAN JOSE',0,1,0,'0','TS','0','0','201001011','201001011026','0','0','581'),
	 (650,'SANTA ELENA','SAN PEDRO',1,1,0,'TE','TE','0','0','201001023','201001011007','0','0','481');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (651,'LOJA','SAN JOSE',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (652,'IMBABURA','SAN JUAN DE ILUMAN',0,0,1,'0','0','TE','0','0','0','1032','59093','0'),
	 (653,'SANTO DOMINGO','ABRAHAM CALAZACÓN ',0,0,0,'0','0','0','0','0','0','0','0','0'),
	 (654,'SANTO DOMINGO','ALLURIQUIN',1,0,1,'TE','0','TE','0','0','0','4126','58011','282'),
	 (655,'SANTO DOMINGO','BOMBOLI',0,0,1,'0','0','TE','0','0','0','4126','59161','0'),
	 (656,'SANTO DOMINGO','CHIGUILPE ',0,0,1,'0','0','TE','0','0','0','4126','59162','0'),
	 (657,'SANTO DOMINGO','KM 14 QUEVEDO',1,1,0,'TE','TS','0','0','0','0','0','0','659'),
	 (658,'SANTO DOMINGO','KM 24 QUEVEDO',1,1,0,'TE','TS','0','0','0','0','0','0','660'),
	 (659,'SANTO DOMINGO','KM 38.5 VIA QUEVEDO',1,1,0,'TE','TS','0','0','0','0','0','0','661'),
	 (660,'SANTO DOMINGO','KM 41 VIA QUEVEDO',1,1,0,'TE','TS','0','0','0','0','0','0','662');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (661,'SANTO DOMINGO','LA CONCORDIA/SANTO DOMINGO',0,1,0,'0','TS','0','0','0','0','0','0','0'),
	 (662,'SANTO DOMINGO','LA UNION/SANTO DOMINGO',0,1,0,'0','TE','0','0','0','0','0','0','0'),
	 (663,'SANTO DOMINGO','LAS DELICIAS',1,0,0,'TE','0','0','0','0','0','0','0','688'),
	 (664,'SANTO DOMINGO','LUZ DE AMERICA',1,1,1,'TE','TS','TE','0','201001024','201001024008','4126','58017','663'),
	 (665,'SANTO DOMINGO','MONTERREY',0,1,0,'0','TE','0','0','0','0','0','0','0'),
	 (666,'SANTO DOMINGO','NUEVO ISRAEL',1,0,0,'TE','0','0','0','0','0','0','0','664'),
	 (667,'SANTO DOMINGO','PATRICIA PILAR/SANTO DOMINGO',0,1,0,'0','TS','0','0','0','0','0','0','0'),
	 (668,'SANTO DOMINGO','PUERTO LIMON',1,0,0,'TE','0','0','0','0','0','0','0','744'),
	 (669,'SANTO DOMINGO','RÍO TOACHI ',0,0,1,'0','0','TE','0','0','0','4126','59163','0'),
	 (670,'SANTO DOMINGO','SAN JACINTO DEL BUA',1,0,0,'TE','0','0','0','0','0','0','0','745');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (671,'SANTO DOMINGO','SANTO DOMINGO',1,1,1,'TE','TE','TN','0','201001024','201001001004','4126','56434','11'),
	 (672,'SANTO DOMINGO','VALLE HERMOSO',1,1,0,'TE','TE','0','0','0','0','0','0','665'),
	 (673,'SANTO DOMINGO','VILLEGAS',0,1,0,'0','TE','0','0','0','0','0','0','0'),
	 (674,'SUCUMBIOS','7 DE JULIO',1,0,1,'TE','0','TE','0','0','0','1041','58022','666'),
	 (675,'SUCUMBIOS','CASCALES',1,0,0,'TE','0','0','0','0','0','0','0','667'),
	 (676,'SUCUMBIOS','EL ENO',0,0,1,'0','0','TE','0','0','0','1041','59129','0'),
	 (677,'SUCUMBIOS','GENERAL FARFAN',0,0,1,'0','0','TE','0','0','0','1041','59130','0'),
	 (678,'SUCUMBIOS','JAMBELI',0,0,1,'0','0','TE','0','0','0','1041','59131','0'),
	 (679,'SUCUMBIOS','JIVINO VERDE',1,0,0,'TE','0','0','0','0','0','0','0','668'),
	 (680,'SUCUMBIOS','LAGO AGRIO',1,1,1,'TE','TO','TN','0','201001022','201001017003','1041','56441','17');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (681,'SUCUMBIOS','LUMBAQUI',1,0,0,'TE','0','0','0','0','0','0','0','670'),
	 (682,'SUCUMBIOS','NUEVA LOJA',0,1,1,'0','TO','TN','0','201001022','201001022001','1041','59164','0'),
	 (683,'SUCUMBIOS','PACAYACU',1,0,0,'TE','0','0','0','0','0','0','0','820'),
	 (684,'SUCUMBIOS','SAN PEDRO DE LOS COFANES',0,0,0,'0','0','0','0','0','0','0','0','0'),
	 (685,'SUCUMBIOS','SANTA CECILIA',1,0,1,'TE','0','TE','0','0','0','1041','58027','672'),
	 (686,'SUCUMBIOS','SHUSHUFINDI',1,1,1,'TE','TO','TN','0','201001022','201001022002','1041','56443','289'),
	 (687,'SUCUMBIOS','TARAPOA',1,0,0,'TE','0','0','0','0','0','0','0','821'),
	 (688,'TUNGURAHUA','AMBATILLO',1,0,0,'TE','0','0','0','0','0','0','0','797'),
	 (689,'TUNGURAHUA','AMBATO',1,1,1,'TP','TP','TN','0','201001019','20100101901','1042','56445','42'),
	 (690,'TUNGURAHUA','ATAHUALPA / CHISALATA',0,0,1,'0','0','TN','0','0','0','1042','59134','0');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (691,'TUNGURAHUA','BANOS DE AGUA SANTA',1,1,0,'TR','TE','0','0','201001019','20100101902','0','0','79'),
	 (692,'TUNGURAHUA','BETÍNEZ / PACHANLICA',0,1,0,'0','TE','0','0','201001019','201001019014','0','0','0'),
	 (693,'TUNGURAHUA','CEVALLOS',1,1,1,'TE','TE','TE','0','201001019','201001019005','1042','56447','265'),
	 (694,'TUNGURAHUA','CUNCHIBAMBA',0,0,0,'0','0','0','0','0','0','0','0','0'),
	 (695,'TUNGURAHUA','HUACHI GRANDE',0,0,1,'0','0','TN','0','0','0','1042','59166','0'),
	 (696,'TUNGURAHUA','HUAMBALO',1,1,0,'TE','TE','0','0','201001019','201001019011','0','0','746'),
	 (697,'TUNGURAHUA','IZAMBA',0,0,1,'0','0','TN','0','0','0','1042','59167','0'),
	 (698,'TUNGURAHUA','LAQUIGO',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (699,'TUNGURAHUA','MARTINEZ',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (700,'TUNGURAHUA','MOCHA',0,1,0,'0','TE','0','0','201001019','201001019007','0','0','262');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (701,'TUNGURAHUA','MONTALVO/TUNGURAHUA',0,1,0,'0','TE','0','0','0','0','0','0','0'),
	 (702,'TUNGURAHUA','MUNDUGLEO',0,0,1,'0','0','TN','0','0','0','1042','59168','0'),
	 (703,'TUNGURAHUA','PATATE',1,1,0,'TE','TE','0','0','201001019','201001003008','0','0','261'),
	 (704,'TUNGURAHUA','PELILEO',1,1,1,'TE','TE','TE','0','201001019','201001019004','1042','56450','259'),
	 (705,'TUNGURAHUA','PICAIGUA',0,0,1,'0','0','TN','0','0','0','1042','59169','0'),
	 (706,'TUNGURAHUA','PILLARO',1,1,0,'TE','TE','0','0','201001019','201001019006','0','0','260'),
	 (707,'TUNGURAHUA','PINLLO',0,0,1,'TE','0','TN','0','0','0','1042','59170','0'),
	 (708,'TUNGURAHUA','QUERO',1,1,1,'TE','TE','TE','0','201001019','201001019008','1042','56452','263'),
	 (709,'TUNGURAHUA','QUINCHICOTO',0,0,1,'0','0','TE','0','0','0','1042','59171','0'),
	 (710,'TUNGURAHUA','QUISAPINCHA',1,0,1,'TE','0','TE','0','0','0','1042','58031','791');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (711,'TUNGURAHUA','SALASACA',0,0,1,'0','0','TE','0','0','0','1042','59172','0'),
	 (712,'TUNGURAHUA','SAN PEDRO DE PELILEO',0,1,0,'0','TE','0','0','201001019','201001019013','0','0','0'),
	 (713,'TUNGURAHUA','SANTA ROSA (AMBATO)',1,0,1,'TE','0','TN','0','0','0','1042','58032','354'),
	 (714,'TUNGURAHUA','TISALEO',1,1,1,'TE','TE','TE','0','201001019','201001019009','1042','56453','264'),
	 (715,'TUNGURAHUA','TOTORAS',0,0,1,'0','0','TE','0','0','0','1042','59173','0'),
	 (716,'TUNGURAHUA','ULBA',0,1,0,'0','TE','0','0','201001019','201001019012','0','0','0'),
	 (717,'TUNGURAHUA','UNAMUNCHO',0,0,1,'0','0','TE','0','0','0','1042','59174','0'),
	 (718,'ZAMORA','28 DE MAYO',1,0,0,'TE','0','0','0','0','0','0','0','602'),
	 (719,'ZAMORA','CENTINELA DEL CONDOR',0,1,0,'0','TO','0','0','0','0','0','0','0'),
	 (720,'ZAMORA','CHAMICO',1,0,0,'TE','0','0','0','0','0','0','0','751');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (721,'ZAMORA','CHICAÑA',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (722,'ZAMORA','CHIMBUTZA',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (723,'ZAMORA','CHUCHUMBLETZA',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (724,'ZAMORA','CUMBARATZA',1,0,1,'TE','0','TE','0','','0','1043','58035','757'),
	 (725,'ZAMORA','EL PADMI',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (726,'ZAMORA','EL PANGUI',1,0,0,'TE','0','0','0','0','0','0','0','747'),
	 (727,'ZAMORA','GUADALUPE',1,0,0,'TE','0','0','0','0','0','0','0','753'),
	 (728,'ZAMORA','GUALAQUIZA',0,1,0,'0','TO','0','0','201001015','201001015002','0','0','0'),
	 (729,'ZAMORA','GUAYZIMI',1,0,0,'TE','0','0','0','0','0','0','0','799'),
	 (730,'ZAMORA','LOS ENCUENTROS',0,0,0,'TE','0','0','0','0','0','0','0','0');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (731,'ZAMORA','NAMIREZ',1,0,0,'TE','0','0','0','0','0','0','0','749'),
	 (732,'ZAMORA','PACHICUTZA',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (733,'ZAMORA','PALANDA',1,0,0,'TE','0','0','0','0','0','0','0','675'),
	 (734,'ZAMORA','PANGUINTZA',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (735,'ZAMORA','PAQUIZHA',1,0,0,'TE','0','0','0','0','0','0','0','750'),
	 (736,'ZAMORA','PIUNTZA',1,0,0,'TE','0','0','0','0','0','0','0','752'),
	 (737,'ZAMORA','SAN ROQUE',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (738,'ZAMORA','TIMBARA',0,0,1,'0','0','TE','0','0','0','1043','59147','0'),
	 (739,'ZAMORA','TUNDAYME',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (740,'ZAMORA','WUISMI',0,0,0,'TE','0','0','0','0','0','0','0','0');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (741,'ZAMORA','YANTZAZA',1,1,0,'TE','TO','0','0','201001021','201001015003','0','0','440'),
	 (742,'ZAMORA','ZAMORA',1,1,1,'TE','TO','TN','0','201001021','201001021001','1043','56461','16'),
	 (743,'ZAMORA','ZUMBA',1,0,0,'TE','0','0','0','0','0','0','0','676'),
	 (744,'ZAMORA','ZUMBI',1,0,0,'TE','0','0','0','0','0','0','0','804'),
	 (745,'AZUAY','PAUTE',1,1,0,'TE','TE','0','0','201001003','201001003004','0','0','460'),
	 (746,'AZUAY','PONCE ENRIQUEZ',1,1,0,'TE','TE','0','0','201001003','201001009013','0','0','770'),
	 (747,'AZUAY','PUCARA',1,0,0,'TE','0','0','0','0','0','0','0','815'),
	 (748,'AZUAY','RICAURTE/AZUAY',1,1,1,'TE','TE','TN','0','201001003','201001003020','1022','59148','695'),
	 (749,'AZUAY','SAN FERNANDO',1,1,0,'TE','TE','0','0','201001003','201001003024','0','0','37'),
	 (750,'AZUAY','SAN JOAQUIN',0,1,1,'0','TE','TN','0','201001003','201001003025','1022','59149','0');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (751,'AZUAY','San Juan Cuenca',0,1,0,'','TE','','','','','','',''),
	 (752,'AZUAY','SANTA ISABEL',1,1,0,'TE','TE','0','0','201001003','201001003005','0','0','64'),
	 (753,'AZUAY','SARAGURO',0,1,0,'0','TE','0','0','0','0','0','0','0'),
	 (754,'AZUAY','SAYUASI',1,1,1,'TE','TE','TE','0','0','0','1022','57668','819'),
	 (755,'AZUAY','SEVILLA DE ORO',1,0,0,'TE','0','0','0','0','0','0','0','504'),
	 (756,'AZUAY','SIDCAY',0,1,1,'0','TE','TE','0','201001003','201001003026','1022','59062','0'),
	 (757,'AZUAY','SIGSIG',1,1,0,'TE','TE','0','0','0','0','0','0','391'),
	 (758,'AZUAY','SIMÓN BOLIVAR/AZUAY',0,1,0,'','TE','','','','','','',''),
	 (759,'AZUAY','SININCAY',0,1,0,'','TE','','','','','','',''),
	 (760,'AZUAY','Sosudel',0,1,0,'','TE','','','','','','','');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (761,'AZUAY','TARQUI',1,1,0,'TE','TE','0','0','0','0','0','0','505'),
	 (762,'AZUAY','Tomebamba',0,1,0,'','TE','','','','','','',''),
	 (763,'AZUAY','Turi',0,1,0,'','TE','','','','','','',''),
	 (764,'AZUAY','VICTORIA DE PORTETE',0,1,0,'','TE','','','','','','',''),
	 (765,'AZUAY','YUNGUILLA',0,1,0,'','TE','','','','','','',''),
	 (766,'AZUAY','Zhaglli',0,1,0,'','TE','','','','','','',''),
	 (767,'AZUAY','ZONA FRANCA',0,1,0,'','TE','','','','','','',''),
	 (768,'CHIMBORAZO','SANTA ROSA DE AGUA CLARA',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (769,'CHIMBORAZO','YARUQUIES',1,1,1,'TE','TE','TN','0','201001008','201001008011','1026','57711','680'),
	 (770,'EL ORO','SANTA ROSA',1,1,0,'TE','TE','0','0','201001009','201001009009','0','0','32');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (771,'GUAYAS','VELASCO IBARRA (EL EMPALME)',0,1,0,'0','TE','0','0','201001002','201001002069','0','0','0'),
	 (772,'GUAYAS','VILLA NUEVA',1,0,0,'TE','0','0','0','0','0','0','0','565'),
	 (773,'GUAYAS','VIRGEN DE FATIMA KM 26',1,1,0,'TE','TE','0','0','0','0','0','0','566'),
	 (774,'GUAYAS','YAGUACHI',0,1,1,'0','TE','TE','0','201001002','201001002006','1031','56345','182'),
	 (775,'LOJA','SAN LUCAS',1,0,0,'TE','0','0','0','201001012','201001012015','0','0','588'),
	 (776,'SANTA ELENA','SANTA ELENA / SANTA ELENA',1,1,1,'TR','TE','TN','0','201001023','201001002010','4125','56436','59'),
	 (777,'SANTA ELENA','SANTA ROSA (SANTA ELENA)',1,0,0,'TE','0','0','0','0','0','0','0','340'),
	 (778,'IMBABURA','SAN LUIS ',0,1,0,'0','TS','0','0','201001011','201001011027','0','0','730'),
	 (779,'IMBABURA','SAN MIGUEL DE IBARRA',0,1,0,'0','TS','0','0','201001011','201001011031','0','0','0'),
	 (780,'SANTA ELENA','SINCHAL',1,0,0,'TE','0','0','0','0','0','0','0','817');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (781,'IMBABURA','SAN PABLO DEL LAGO',1,0,1,'TE','0','TE','0','0','0','1032','57832','254'),
	 (782,'IMBABURA','SAN PABLO IMBABURA',0,1,0,'0','TE','0','0','201001011','201001011010','0','0','0'),
	 (783,'SANTA ELENA','VALDIVIA',1,1,0,'TE','TE','0','0','201001023','201001023016','0','0','478'),
	 (784,'LOJA','SAN PEDRO',0,0,0,'TE','0','0','0','0','0','0','0','0'),
	 (785,'LOJA','SAN PEDRO DE LA BENDITA',0,1,0,'0','TE','0','0','201001012','201001012014','0','0','0'),
	 (786,'LOJA','SAN PEDRO DE VILCABAMBA',0,1,0,'0','TE','0','0','201001012','201001012013','0','0','0'),
	 (787,'COTOPAXI','ZUMBAHUA',1,0,0,'TE','0','0','0','0','0','0','0','803'),
	 (788,'EL ORO','SHUMIRAL',1,0,0,'TE','0','0','0','0','0','0','0','548'),
	 (789,'EL ORO','TORATA',0,0,1,'0','0','TE','0','0','0','1028','59078','0'),
	 (790,'EL ORO','VEITORIA',0,0,1,'0','0','TE','0','0','0','1028','59079','0');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (791,'EL ORO','ZARUMA',1,1,0,'TE','TE','0','0','201001009','201001009005','0','0','67'),
	 (792,'IMBABURA','SAN RAFAEL',0,0,0,'0','0','0','0','0','0','0','0','0'),
	 (793,'IMBABURA','SAN ROQUE',1,1,1,'TE','TE','TE','0','201001011','201001011011','1032','57833','129'),
	 (794,'LOJA','SAN SEBASTIÁN ',0,0,1,'0','0','TE','0','0','0','1033','59097','0'),
	 (795,'IMBABURA','SANTA BERTHA',0,1,0,'0','TS','0','0','201001011','201001011028','0','0','0'),
	 (796,'LOJA','SANTIAGO',1,0,0,'TE','0','0','0','0','0','0','0','683'),
	 (797,'LOJA','SARAGURO',1,0,0,'TE','0','0','0','201001012','201001012009','0','0','430'),
	 (798,'LOJA','SOZORANGA',1,0,0,'TE','0','0','0','0','0','0','0','131'),
	 (799,'LOJA','SUCRE',0,0,1,'0','0','TE','0','0','0','1033','59098','0'),
	 (800,'IMBABURA','TIERRA BLANCA',0,1,0,'0','TS','0','0','201001011','201001011029','0','0','0');");
mysqli_query($conexion, "INSERT INTO ciudad_cotizacion (id_cotizacion,provincia,ciudad,cobertura_servientrega,cobertura_laar,cobertura_gintracom,trayecto_servientrega,trayecto_laar,trayecto_gintracom,codigo_provincia_servientrega,codigo_provincia_laar,codigo_ciudad_laar,codigo_provincia_gintracom,codigo_ciudad_gintracom,codigo_ciudad_servientrega) VALUES
	 (801,'IMBABURA','TUMBACO',0,0,0,'0','0','0','0','0','0','0','0','0'),
	 (802,'IMBABURA','URCUQUI',1,1,1,'TE','TE','TE','0','201001011','201001011004','1032','59096','729'),
	 (803,'LOJA','VILCABAMBA',0,1,0,'0','TE','0','0','201001012','201001012007','0','0','431'),
	 (804,'IMBABURA','YACHAY',1,0,0,'TE','0','0','0','0','0','0','0','731'),
	 (805,'IMBABURA','YAGUARCOCHA',1,0,1,'TE','TE','TN','0','201001011','201001011019','1032','57836','583'),
	 (806,'LOJA','ZAPOTILLO',1,0,0,'TE','0','0','0','0','0','0','0','437'),
	 (807,'MANABI','10 DE AGOSTO',1,0,0,'TE','0','0','','201001014','','','','600'),
	 (808,'MANABI','24 DE MAYO',1,1,0,'TE','0','0','','201001014','201001001032','','','396');");



mysqli_query($conexion, "CREATE TABLE `cobertura_servientrega` (
  `id_cobertura` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `tipo_cobertura` varchar(20) NOT NULL,
  `costo` double DEFAULT NULL,
  `precio` double DEFAULT NULL
  );");

mysqli_query($conexion, "INSERT INTO cobertura_servientrega (id_cobertura,tipo_cobertura,costo,precio) VALUES
(1,'TL',2.04,4.75),
(2,'TC',3.15,4.75),
(3,'TP',3.48,5.0),
(4,'TR',3.86,5.3),
(5,'TE',4.66,5.8);
");

mysqli_query($conexion, "CREATE TABLE `cobertura_laar` (
	`id_cobertura` bigint UNSIGNED NOT NULL PRIMARY KEY,
	`tipo_cobertura` varchar(100) NOT NULL,
	`costo` double NOT NULL,
	`precio` double NOT NULL
  );");

mysqli_query($conexion, "INSERT INTO `cobertura_laar` (`id_cobertura`, `tipo_cobertura`, `costo`, `precio`) VALUES
(1, 'TP', 2.8, 4.5),
(2, 'TE', 3.5, 5.5),
(3, 'TL', 2.8, 3.5),
(4, 'TS', 3.5, 5.5),
(5, 'TO', 3.5, 5.5);
");

mysqli_query($conexion, "INSERT INTO `cobertura_laar` (`id_cobertura`, `tipo_cobertura`, `costo`, `precio`) VALUES
(6, 'GAL', 15,15)");
mysqli_query($conexion, "UPDATE `ciudad_cotizacion` SET `trayecto_laar` = 'TP', `trayecto_gintracom` = 'TN' WHERE `ciudad_cotizacion`.`id_cotizacion` = 239;");
mysqli_query($conexion, "ALTER TABLE `dropi` CHANGE `pais_id` `pais_id` INT NOT NULL DEFAULT '0';");

mysqli_query($conexion, "ALTER TABLE `perfil` ADD `whatsapp_flotante` INT DEFAULT 0 NOT NULL;");
mysqli_query($conexion, "ALTER TABLE `perfil` ADD `boton_compra_flotante` INT DEFAULT 0 NOT NULL;");
mysqli_query($conexion, "UPDATE `ciudad_cotizacion` SET `trayecto_laar` = 'TP', `cobertura_laar` = '1' WHERE `ciudad_cotizacion`.`id_cotizacion` = 190;");
mysqli_query($conexion, "UPDATE `ciudad_cotizacion` SET `trayecto_laar` = 'TL' WHERE `ciudad_cotizacion`.`id_cotizacion` = 618;");
mysqli_query($conexion, "UPDATE `ciudad_cotizacion` SET `cobertura_laar` = '1', `trayecto_laar`= 'TP' WHERE `ciudad_cotizacion`.`id_cotizacion` = 115;");
mysqli_query($conexion, "UPDATE `ciudad_cotizacion` SET `trayecto_laar` = 'TE' WHERE `ciudad_cotizacion`.`id_cotizacion` = 230;");
mysqli_query($conexion, "ALTER TABLE `users` ADD `cedula_facturacion` VARCHAR(13) NOT NULL AFTER `fecha_actualizacion`, ADD `correo_facturacion` VARCHAR(150) NOT NULL AFTER `cedula_facturacion`, ADD `direccion_facturacion` VARCHAR(200) NOT NULL AFTER `correo_facturacion`;");

mysqli_query($conexion, "CREATE TABLE `cobertura_gintracom` (
	`id_cobertura` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`trayecto` varchar(10) NOT NULL,
	`precio` float NOT NULL
  );");

mysqli_query($conexion, "INSERT INTO `cobertura_gintracom` (`id_cobertura`, `trayecto`, `precio`) VALUES
	(1, 'TN', 5),
	(2, 'TE', 6)
	;");

mysqli_query($conexion, "ALTER TABLE `tmp_ventas` ADD `descripcion` TEXT NULL AFTER `id_producto`;");

mysqli_query($conexion, "CREATE TABLE `cobertura_gintracom` (
	`id_cobertura` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`trayecto` varchar(10) NOT NULL,
	`precio` float NOT NULL
  );");

mysqli_query($conexion, "INSERT INTO `cobertura_gintracom` (`id_cobertura`, `trayecto`, `precio`) VALUES
	(1, 'TN', 5),
	(2, 'TE', 6)
	;");

mysqli_query($conexion, "ALTER TABLE `tmp_ventas` ADD `iva_tmp` INT NULL DEFAULT '0' AFTER `drogshipin_tmp`;");

mysqli_query($conexion, "UPDATE `ciudad_cotizacion` SET `cobertura_servientrega` = '1', `cobertura_laar`='1', `trayecto_laar` ='TE', `trayecto_servientrega`='TE' WHERE `ciudad_cotizacion`.`id_cotizacion` = 674;");

mysqli_query($conexion, "ALTER TABLE `users` CHANGE `cedula_facturacion` `cedula_facturacion` VARCHAR(13) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL, CHANGE `correo_facturacion` `correo_facturacion` VARCHAR(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL, CHANGE `direccion_facturacion` `direccion_facturacion` VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL;");

mysqli_query($conexion, "UPDATE `ciudad_cotizacion` SET `trayecto_laar` = 'TP' WHERE `ciudad_cotizacion`.`id_cotizacion` = 35;");

mysqli_query($conexion, "CREATE TABLE novedades (
	id_novedad int not null primary key auto_increment,
	guia_novedad varchar(10) not null unique,
	cliente_novedad varchar(200) not null,
	estado_novedad int not null,
	novedad text null,
	solucion_novedad text null,
	tracking text not null,
	fecha_novedad datetime not null default current_timestamp
	
);");

mysqli_query($conexion, "CREATE TABLE detalle_novedad (
	id_detalle_novedad int not null primary key auto_increment,
	codigo_novedad int not null,
	guia_novedad varchar(10) not null,
	nombre_novedad text not null,
	detalle_novedad text not null,
	observacion text,
	Foreign key (guia_novedad) REFERENCES novedades(guia_novedad) 
);");

mysqli_query($conexion, "ALTER TABLE `facturas_ventas` DROP INDEX `numero_cotizacion`;");
mysqli_query($conexion, "ALTER TABLE `detalle_fact_ventas` ADD `descripcion_detalle` TEXT NOT NULL AFTER `importe_venta`;");
mysqli_query($conexion, "ALTER TABLE `detalle_fact_ventas` ADD `aplica_iva` INT NOT NULL AFTER `descripcion_detalle`;");
mysqli_query($conexion, "ALTER TABLE `facturas_ventas` ADD `monto_iva` DOUBLE NOT NULL AFTER `plazodias`;");

mysqli_query($conexion, "UPDATE `perfil` SET `autofactura` = '0' WHERE `perfil`.`id_perfil` = 1;");


mysqli_query($conexion, "UPDATE `ciudad_cotizacion` SET `codigo_ciudad_laar` = '201001017006', `codigo_provincia_laar`='201001017' WHERE `ciudad_cotizacion`.`id_cotizacion` = 526;");

mysqli_query($conexion, "ALTER TABLE `ciudad_cotizacion` ADD `id_pais` TINYINT NOT NULL DEFAULT '1' AFTER `codigo_ciudad_servientrega`;");

mysqli_query($conexion, "CREATE TABLE `atributos` (
  `id_atributo` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_atributo` text DEFAULT NULL,
  UNIQUE KEY `id_atributo` (`id_atributo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

mysqli_query($conexion, "INSERT INTO `atributos` (`id_atributo`, `nombre_atributo`) VALUES (NULL, 'TALLA'), (NULL, 'COLOR'), (NULL, 'MARCA'), (NULL, 'MODELO'), (NULL, 'MATERIAL'), (NULL, 'CAPACIDAD');");

mysqli_query($conexion, "CREATE TABLE banner_marketplace ( id bigint(20) unsigned auto_increment NOT NULL PRIMARY KEY, fondo_banner text DEFAULT NULL NULL, titulo text DEFAULT NULL NULL, texto_banner text DEFAULT NULL NULL, texto_boton text DEFAULT NULL NULL, enlace_boton text DEFAULT NULL NULL, alineacion int(11) DEFAULT NULL NULL );");

mysqli_query($conexion, "ALTER TABLE `perfil` ADD `activar_destacados` VARCHAR(100) NOT NULL DEFAULT '1' AFTER `boton_compra_flotante`;");

mysqli_query($conexion, "ALTER TABLE `perfil` ADD `envioGratis_checkout` VARCHAR(100) NOT NULL DEFAULT '1' AFTER `activar_destacados`;");


mysqli_query($conexion, "ALTER TABLE `detalle_fact_cot` CHANGE `desc_venta` `desc_venta` DOUBLE NULL DEFAULT NULL;");


mysqli_query($conexion, "CREATE TABLE shopify ( id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, json json DEFAULT NULL);");




mysqli_close($conexion); // Cerramos la link con la base de datos

echo json_encode("ok");
