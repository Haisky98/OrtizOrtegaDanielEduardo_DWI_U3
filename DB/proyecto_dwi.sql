/*
 Navicat Premium Data Transfer

 Source Server         : 01.proyecto DWI docker
 Source Server Type    : MySQL
 Source Server Version : 80046 (8.0.46)
 Source Host           : 127.0.0.1:3306
 Source Schema         : proyecto_dwi

 Target Server Type    : MySQL
 Target Server Version : 80046 (8.0.46)
 File Encoding         : 65001

 Date: 08/11/2026 17:16:12
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cat_categorias
-- ----------------------------
DROP TABLE IF EXISTS `cat_categorias`;
CREATE TABLE `cat_categorias`  (
  `id_categoria` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `estatus` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`id_categoria`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cat_categorias
-- ----------------------------
INSERT INTO `cat_categorias` VALUES (1, 'Tecnología', 1);
INSERT INTO `cat_categorias` VALUES (2, 'Ropa y Moda', 1);
INSERT INTO `cat_categorias` VALUES (3, 'Hogar y Cocina', 1);
INSERT INTO `cat_categorias` VALUES (4, 'Consolas de Videojuegos', 1);

-- ----------------------------
-- Table structure for cat_roles
-- ----------------------------
DROP TABLE IF EXISTS `cat_roles`;
CREATE TABLE `cat_roles`  (
  `id_rol` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `estatus` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`id_rol`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cat_roles
-- ----------------------------
INSERT INTO `cat_roles` VALUES (1, 'super_admin', 0);
INSERT INTO `cat_roles` VALUES (2, 'admin', 1);
INSERT INTO `cat_roles` VALUES (3, 'cliente', 1);

-- ----------------------------
-- Table structure for detalle_pedidos
-- ----------------------------
DROP TABLE IF EXISTS `detalle_pedidos`;
CREATE TABLE `detalle_pedidos`  (
  `id_detalle` int NOT NULL AUTO_INCREMENT,
  `id_pedido` int NOT NULL,
  `id_producto` int NOT NULL,
  `cantidad` int NOT NULL,
  `precio_unitario` decimal(10, 2) NOT NULL,
  PRIMARY KEY (`id_detalle`) USING BTREE,
  INDEX `fk_detalle_pedido`(`id_pedido` ASC) USING BTREE,
  INDEX `fk_detalle_producto`(`id_producto` ASC) USING BTREE,
  CONSTRAINT `fk_detalle_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `fk_detalle_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of detalle_pedidos
-- ----------------------------
INSERT INTO `detalle_pedidos` VALUES (1, 2, 2, 1, 3482.80);

-- ----------------------------
-- Table structure for pedidos
-- ----------------------------
DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE `pedidos`  (
  `id_pedido` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `total` decimal(10, 2) NOT NULL,
  `estatus` tinyint NULL DEFAULT 1,
  `fecha_pedido` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pedido`) USING BTREE,
  INDEX `fk_pedido_usuario`(`id_usuario` ASC) USING BTREE,
  CONSTRAINT `fk_pedido_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pedidos
-- ----------------------------
INSERT INTO `pedidos` VALUES (1, 2, 3482.80, 1, '2026-11-08 06:01:11');
INSERT INTO `pedidos` VALUES (2, 2, 3482.80, 2, '2026-11-08 06:03:45');

-- ----------------------------
-- Table structure for productos
-- ----------------------------
DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos`  (
  `id_producto` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `precio` decimal(10, 2) NOT NULL,
  `stock` int NOT NULL DEFAULT 0,
  `imagen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT 'assets/media/products/default.png',
  `id_categoria` int NOT NULL,
  `estatus` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`id_producto`) USING BTREE,
  INDEX `fk_producto_categoria`(`id_categoria` ASC) USING BTREE,
  CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `cat_categorias` (`id_categoria`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of productos
-- ----------------------------
INSERT INTO `productos` VALUES (1, 'Mochila Matein 1035 Antirrobo Impermeable Para Laptop 17\" Negra 30 L', 'Mochila De Viaje, Mochila Para Hombres, Regalo Para Hombre, Mochila Escolar con Espacio para Útiles Escolares, Mochila Antirrobo Impermeable', 290.00, 100, 'assets/media/products/b829e156304350b7511c8585853f1d2d.webp', 2, 1);
INSERT INTO `productos` VALUES (2, 'Tablet Infinix XPAD 11 pulgadas', '', 3482.80, 10, 'assets/media/products/default.png', 1, 0);

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios`  (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_rol` int NOT NULL,
  `estatus` tinyint NULL DEFAULT 1,
  `domicilio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usuario`) USING BTREE,
  UNIQUE INDEX `email`(`email` ASC) USING BTREE,
  INDEX `fk_usuario_rol`(`id_rol` ASC) USING BTREE,
  CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`id_rol`) REFERENCES `cat_roles` (`id_rol`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES (1, 'SA_daniel', 'haisky98@admin.com', '$2y$10$Nt0rg.fkzQoHAK1Iy.z5.uZyPvKrF5cAVmG5HDSCKsnN7xIXJrhPq', 1, 1, NULL, '2026-10-29 01:39:28');
INSERT INTO `usuarios` VALUES (2, 'Administrador', 'admin1406@gmail.com', '$2y$10$bVqHsLVcxZ0GaF.aAElRwO7yOk/sYnMN0VmEyEaTw0NhLNrhdwUzO', 2, 1, NULL, '2026-11-08 01:50:28');
INSERT INTO `usuarios` VALUES (3, 'Mario Ortiz', 'mario1407@gmail.com', '$2y$10$8evZ8K1xryM2P6FTOHjW..RAe1Pk.C9wQ4yqIWtbGCfJ33I5mbMLO', 3, 1, NULL, '2026-11-08 19:52:07');
INSERT INTO `usuarios` VALUES (6, 'Lucas Ortiz', 'lucas0607@gmail.com', '$2y$10$aaRpeiiFScPQbpAx8ANE4ezqtvxsB8UNidUg.5hRCKFl056VPacN.', 3, 1, NULL, '2026-11-08 20:05:06');

SET FOREIGN_KEY_CHECKS = 1;
