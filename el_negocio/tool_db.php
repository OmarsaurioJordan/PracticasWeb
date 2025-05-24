<?php
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $dbname = 'el_negocio';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
        die("Error de conexión: ". $e -> getMessage());
    }

    function doQuery($sql="", $values=[]) {
        // doQuery("SELECT id FROM gente WHERE nombre=? AND edad=?", [$nombre, $edad]);
        // return [exito, data[]]
        global $pdo;
        $stmt = $pdo -> prepare($sql);
        try {
            if ($stmt -> execute($values)) {
                $tipo = strtoupper(strtok(trim($sql), " "));
                return [true, $tipo == "SELECT" ?
                    $stmt -> fetchAll(PDO::FETCH_ASSOC) : []];
            }
            else {
                return [false, []];
            }
        }
        catch (PDOException $e) {
            return [false, []];
        }
    }

    function getList($tabla) {
        $res = doQuery("SELECT nombre FROM $tabla");
        if ($res[0]) {
            $list = [];
            for ($i = 0; $i < count($res[1]); $i++) {
                $list[] = $res[1][$i]['nombre'];
            }
            return $list;
        }
        return [];
    }

    function setClave($clave) {
        return md5($clave. "unacadenasssekreta909090");
    }
?>
