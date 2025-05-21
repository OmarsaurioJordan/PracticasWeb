<?php
include_once "Salario.php";

class SalarioEspecialista extends Salario{
    
    function __construct($tipo, $nombreProfesional, $fechaCita) {
        parent::__construct($tipo, $nombreProfesional, $fechaCita);
    }

    function getSalario($rangoEdadPaciente) {
        $dinero = $this->getSalarioBase($rangoEdadPaciente);
        if ($this->tipo == 1) {
            return $dinero * 1.05;
        }
        else if ($this->tipo == 2) {
            return $dinero * 1.1;
        }
        return $dinero;
    }
}
?>
