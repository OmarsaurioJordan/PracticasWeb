<?php
include_once "Salario.php";

class SalarioGeneral extends Salario{
    
    function __construct($tipo, $nombreProfesional, $fechaCita) {
        parent::__construct($tipo, $nombreProfesional, $fechaCita);
    }

    function getSalario($rangoEdadPaciente) {
        return $this->getSalarioBase($rangoEdadPaciente);
    }
}
?>
