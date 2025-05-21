<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "evaluame";
$cnx = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
$cnx -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function doQuery($sql="", $values=[]) {
    // doQuery("SELECT id FROM gente WHERE nombre=? AND edad=?", [$nombre, $edad]);
    // return [exito, data[]]
    global $cnx;
    $stmt = $cnx -> prepare($sql);
    try {
        if ($stmt -> execute($values)) {
            $tipo = strtoupper(strtok(trim($sql), " "));
            return [true, $tipo == "SELECT" ?
                $stmt -> fetchAll(PDO::FETCH_ASSOC) : []];
            // if ($res[0]) { }
            // if (count($res[1]) > 0) { }
            // foreach ($res[1] as $row) { $row['id']; }
        }
        else {
            return [false, []];
        }
    }
    catch (PDOException $e) {
        return [false, []];
    }
}

function getTipos($tipoActual) {
    global $cnx;
    $optns = "<option value=-1>...</option>";
    $res = doQuery("SELECT * FROM tipo");
    foreach ($res[1] as $row) {
        if ($row['id'] == $tipoActual) {
            $optns .= "<option value=" .$row['id']. " selected>";
        }
        else {
            $optns .= "<option value=" .$row['id']. ">";
        }
        $optns .= $row['nombre']. "</option>";
    }
    return $optns;
}
?>
