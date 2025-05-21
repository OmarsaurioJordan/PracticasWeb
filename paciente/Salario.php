<?php
class Salario {
    protected $tipos = array("General",
        "Odontólogo", "Psicólogo");
    protected $tipo; // ind de tipos
    protected $nombreProfesional;
    protected $fechaCita;

    function __construct($tipo, $nombreProfesional, $fechaCita) {
        $this->tipo = $tipo;
        $this->nombreProfesional = $nombreProfesional;
        $this->fechaCita = $fechaCita;
    }

    function getNombre() {
		return $this->nombreProfesional;
	}

    function getTipo() {
		return $this->tipos[$this->tipo];
	}

    function getSalarioBase($rangoEdadPaciente) {
        switch ($rangoEdadPaciente ) {
            case "Mayor":
                return 55000;
            case "Adulto":
                return 35000;
            case "Jóven":
                return 25000;    
        }
        return 0;
    }
}
?>
