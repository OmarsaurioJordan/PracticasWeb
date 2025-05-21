<?php

$inicio = isset($_GET['inicio']) ? $_GET['inicio'] : null;
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : null;
$ciudad = isset($_GET['ciudad']) ? $_GET['ciudad'] : null;

$mensaje = "...";
if ($inicio != null && $tipo != null) {
    
    $estudio = "";
    $espera = "0 days";
    switch ($tipo) {
        case "1":
            $espera = "6 months";
            $estudio = "Técnico";
            break;
        case "2":
            $espera = "18 months";
            $estudio = "Tecnólogo";
            break;
        case "3":
            $espera = "5 years";
            $estudio = "Profesional";
            break;
    }

    $final = date_create($inicio);
    $final = date_add($final, date_interval_create_from_date_string($espera));
    
    if ($estudio == "") {
        $mensaje = "No seleccionó estudios, comienza a trabajar de inmediato!!!";
    }
    else {
        $inicio_txt = date_format(date_create($inicio), "d-m-Y");
        $final_txt = date_format($final, "d-m-Y");
        $mensaje = "Estudiando un $estudio que comienza en $inicio_txt " .
            "comenzará a trabajr en $final_txt";
    }
}

if ($ciudad != null) {
    $mensaje .= "<br>...<br>";

    $tempo = "";
    $name_ciudad = "";
    switch ($ciudad) {
        case "1":
            $tempo = "America/Bogota";
            $name_ciudad = "Cali";
            break;
        case "2":
            $tempo = "Europe/Paris";
            $name_ciudad = "París";
            break;
        case "3":
            $tempo = "Asia/Tokyo";
            $name_ciudad = "Tokyo";
            break;
        case "4":
            $tempo = "Africa/Cairo";
            $name_ciudad = "El Cairo";
            break;
        case "5":
            $tempo = "Australia/Sydney";
            $name_ciudad = "Sydney";
            break;
    }

    if ($tempo != "") {
        date_default_timezone_set($tempo);
        $hoy_stamp = new DateTime('now');
        $hoy = $hoy_stamp -> format('r');
        $mensaje .= "la fecha y hora en $name_ciudad es: " . $hoy;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CalIniPra</title>
</head>
<body>
    <header>Calculadora de Fecha de Inicio de Prácticas</header>
    <form action="time_ciudades.php" method="get" autocomplete="off">
        <p>
            <label>Fecha de inicio de etapa lectiva</label><br>
            <input type="date" name="inicio">
        </p>
        <p>
            <label>Seleccione el tipo de curso</label><br>
            <select name="tipo">
                <option value="0">...</option>
                <option value="1">Técnico</option>
                <option value="2">Tecnólogo</option>
                <option value="3">Profesional</option>
            </select>
        </p>
        <p>
            <label>Seleccione su ciudad</label><br>
            <select name="ciudad">
                <option value="0">...</option>
                <option value="1">Cali (Colombia)</option>
                <option value="2">París (Francia)</option>
                <option value="3">Tokio (Japón)</option>
                <option value="4">El Cairo (Egipto)</option>
                <option value="5">Sydney (Australia)</option>
            </select>
        </p>
        <p>
            <button type="submit">Calcular</button>
        </p>
    </form>
    <p>
        <?php echo $mensaje;  ?>
    </p>
</body>
</html>
