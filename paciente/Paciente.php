<?php
class Paciente {
	private $identificacion;
	private $nombre;
	private $fechaNacimiento;
	private $genero; // M,H
	private $telefono;
	private $estratoSocial;

	function __construct($identificacion, $nombre, $fechaNacimiento,
			$genero, $telefono, $estratoSocial) {
		$this->datosPersonales($identificacion, $nombre, $fechaNacimiento,
			$genero, $telefono, $estratoSocial);
	}
	
	function datosPersonales($identificacion, $nombre, $fechaNacimiento,
			$genero, $telefono, $estratoSocial) {
		$this->identificacion = $identificacion;
		$this->nombre = $nombre;
		$this->fechaNacimiento = $fechaNacimiento;
		$this->genero = $genero;
		$this->telefono = $telefono;
		$this->estratoSocial = $estratoSocial;
	}

	function getIdentificacion() {
		return $this->identificacion;
	}

	function getNombre() {
		return $this->nombre;
	}

	function getFechaNacimiento() {
		return $this->fechaNacimiento;
	}

	function getGenero() {
		return $this->genero;
	}

	function getTelefono() {
		return $this->telefono;
	}

	function getEstrato() {
		return $this->estratoSocial;
	}

	function getEdad() {
		date_default_timezone_set("America/Bogota");
        $nacio = date_create($this->fechaNacimiento);
        $hoy = date_create(date('d-m-Y'));
        $edad = date_diff($nacio, $hoy);
        return $edad->format("%Y");
	}

	function getRangoEdad() {
		$edad = $this->getEdad();
		if ($edad >= 101) {
			return "Fósil";
		}
		else if ($edad >= 61) {
			return "Mayor";
		}
		else if ($edad >= 26) {
			return "Adulto";
		}
		else if ($edad >= 18) {
			return "Jóven";
		}
		else if ($edad >= 0) {
			return "Menor";
		}
		return "Vacío";
	}

	function getPension() {
		// retorna num years faltantes o si pensionado: 0
		$edad = $this->getEdad();
		if ($this->genero == "M") {
			return max(0, 57 - $edad);
		}
		return max(0, 62 - $edad);
	}
}
?>
