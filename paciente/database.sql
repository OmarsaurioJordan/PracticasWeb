# tabla necesaria en la base de datos llamada paciente
CREATE TABLE `paciente` (
  `id` int(10) UNSIGNED NOT NULL,
  `identificacion` int(10) UNSIGNED NOT NULL,
  `nombre` text NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `genero` tinytext NOT NULL,
  `telefono` int(10) UNSIGNED NOT NULL,
  `estratoSocial` tinyint(3) UNSIGNED NOT NULL
);
