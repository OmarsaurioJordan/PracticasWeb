<?php
include_once "Paciente.php";
include_once "Cita.php";
include_once "SalarioGeneral.php";
include_once "SalarioEspecialista.php";

// obtener todos los datos
$identificacion = $_GET['identificacion'];
$nombre = $_GET['nombre'];
$fechaNacimiento = $_GET['fechaNacimiento'];
$genero = $_GET['genero'];
$telefono = $_GET['telefono'];
$estratoSocial = $_GET['estratoSocial'];
$tipo = $_GET['tipo'];

// generar el objeto paciente
$paciente = new Paciente($identificacion, $nombre,
    $fechaNacimiento, $genero, $telefono, $estratoSocial);

// generar el objeto cita con la fecha actual
date_default_timezone_set("America/Bogota");
$fechaSolicitud = date('d-m-Y');
$cita = new Cita($fechaSolicitud, $tipo, $estratoSocial,
    $nombre, $genero);

// generar el objeto salario con la fecha de la cita y el doctor
$fechaCita = $cita->getFechaCita(false);
$salario = null;
$doctores = array("Marlon Garcéz", "Juliana Henao", "Nora Umaña");
$nombreProfesional = $doctores[$tipo];
if ($tipo == 0) {
    $salario = new SalarioGeneral($tipo,
        $nombreProfesional, $fechaCita);
}
else {
    $salario = new SalarioEspecialista($tipo,
        $nombreProfesional, $fechaCita);
}

// pintar los datos del paciente
echo "<h2><a href='Formulario.php'>Volver al Formulario</a></h2>";
echo "<p><h2>Paciente:</h2>";
echo $paciente->getNombre() ." (". $paciente->getEdad() ." ".
    $paciente->getGenero() .")<br>";
echo "c.c. " .$paciente->getIdentificacion(). "<br>";
echo "tel: ". $paciente->getTelefono() ." (est: ".
    $paciente->getEstrato() .")<br>";
$pension = $paciente->getPension();
$rango = $paciente->getRangoEdad();
if ($pension == 0) {
    echo $rango ." (Pensión: pensionado)<br>";
}
else {
    echo $rango ." (Pensión: faltan " .$pension. " años)<br>";
}
echo "</p>";

// pintar los datos de la cita y el medico
echo "<p><h2>Cita:</h2>";
echo "para: " .$cita->getFechaCita(true). "<br>";
echo "debe hacer co-pago: $" .$cita->getCopago(). "<br>";
echo "con: " .$salario->getNombre(). " (" .$salario->getTipo(). ")<br>";
echo "honorarios del profesional: $" .$salario->getSalario($rango);
echo "</p>";

// subir datos a la base de datos
$sql = new mysqli("localhost", "root", "", "paciente");
if ($sql->connect_errno) {
    echo "Error...";
    exit();
}
$res = $sql->query("SELECT id FROM paciente WHERE identificacion = '$identificacion'");
if ($res->num_rows == 0) {
    $sql->query("INSERT INTO paciente (identificacion, nombre, fechaNacimiento,".
        "genero, telefono, estratoSocial) VALUES (".
        "'$identificacion', '$nombre', '$fechaNacimiento',".
        "'$genero', '$telefono', '$estratoSocial')");
}
else {
    $id = $res->fetch_assoc()["id"];
    $sql->query("UPDATE paciente SET nombre='$nombre',".
        "fechaNacimiento='$fechaNacimiento', genero='$genero',".
        "telefono='$telefono', estratoSocial='$estratoSocial' WHERE id='$id'");
}
?>
