<?php
echo "<h2><a href='Formulario.php'>Volver al Formulario</a></h2>";

// obtener los pacientes de la base de datos
$sql = new mysqli("localhost", "root", "", "paciente");
if ($sql->connect_errno) {
    echo "Error...";
    exit();
}
$res = $sql->query("SELECT * FROM paciente");
if ($res->num_rows == 0) {
    echo "No hay pacientes";
}
else {
    $i = 0;
    while ($row = $res->fetch_assoc()) {
        $i++;
        echo "<p>" .$i. " - ";
        echo $row['nombre'] . " (" .$row['genero']. ")";
        echo "</p>";
    }
}
?>
