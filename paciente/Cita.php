<?php
class Cita {
    private $fechaSolicitud;
    private $tipos = array("General",
        "Odontología", "Psicología");
    private $tipo; // ind de tipos
    private $estratoSocial;
    private $nombre;
    private $genero;

    function __construct($fechaSolicitud, $tipo, $estratoSocial,
            $nombre, $genero) {
        $this->fechaSolicitud = $fechaSolicitud;
        $this->tipo = $tipo;
        $this->estratoSocial = $estratoSocial;
        $this->nombre = $nombre;
        $this->genero = $genero;
    }

    function getCopago() {
        if ($this->estratoSocial <= 2) {
            return 4300;
        }
        else if ($this->estratoSocial <= 4) {
            return 18000;
        }
        return 43000;
    }

    function getFechaCita($conHora) {
        date_default_timezone_set("America/Bogota");
        $inicio = date_create($this->fechaSolicitud);
        if ($this->tipo == 0) {
            $fin = date_add($inicio,
                date_interval_create_from_date_string("7 days"));
        }
        else {
            $fin = date_add($inicio,
                date_interval_create_from_date_string("14 days"));
        }
        $hora = "mañana";
        if ($this->genero == "H") {
            $hora = "tarde";
        }
        if ($conHora) {
            return date_format($fin, "d/m/Y") ." ". $hora;
        }
        return date_format($fin, "d/m/Y");
    }
}
?>
