<?php
    // conexion con el servidor de DB usando los datos de credenciales
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $dbname = 'salita';
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
        die("Error de conexión: ". $e -> getMessage());
    }

    // dada una solicitud de request post, se depurara una respuesta
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        global $pdo;

        // primero obtener todos los datos posibles, con su valor por defecto
        $id = isset($_POST["id"]) ? $_POST["id"] : "0";
        $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
        $emoji = isset($_POST["emoji"]) ? $_POST["emoji"] : "0";
        $pos_x = isset($_POST["pos_x"]) ? $_POST["pos_x"] : "0";
        $pos_y = isset($_POST["pos_y"]) ? $_POST["pos_y"] : "0";
        $time_out_s = isset($_POST["time_out_s"]) ? $_POST["time_out_s"] : "0";
        $tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";

        // la depuracion procede de una cadena string clave
        switch ($tipo) {

            case "avatar_create":
                // insertara un registro nuevo, devolviendo los datos insertados mas el nuevo id
                $nombre = okNombre($nombre);
                $data = [
                    "id" => 0,
                    "nombre" => $nombre,
                    "emoji" => (int)$emoji,
                    "pos_x" => (int)$pos_x,
                    "pos_y" => (int)$pos_y
                ];
                if ($nombre == "") {
                    echo json_encode($data);
                    break;
                }
                $sql = "INSERT INTO avatares (nombre, emoji, pos_x, pos_y) VALUES (?, ?, ?, ?)";
                $stmt = $pdo -> prepare($sql);
                if ($stmt -> execute([$nombre, $emoji, $pos_x, $pos_y])) {
                    $data["id"] = (int)$pdo -> lastInsertId();
                }
                echo json_encode($data);
                break;

            case "avatar_update":
                // actualiza la posicion en un registro existente
                $sql = "UPDATE avatares SET pos_x = ?, pos_y = ?, activo = NOW() WHERE id = ?";
                $stmt = $pdo -> prepare($sql);
                $data = ["result" => $stmt -> execute([$pos_x, $pos_y, $id])];
                echo json_encode($data);
                break;

            case "avatar_delete_one":
                // elimina al avatar con id dado
                $sql = "DELETE FROM avatares WHERE id = ?";
                $stmt = $pdo -> prepare($sql);
                $data = ["result" => $stmt -> execute([$id])];
                echo json_encode($data);
                break;
            
            case "avatar_delete_all":
                // elimina todos los registros mas antiguos de cierto tiempo en segundos
                $s = max(10, (int)$time_out_s);
                $sql = "DELETE FROM avatares WHERE activo < (NOW() - INTERVAL $s SECOND)";
                $stmt = $pdo -> prepare($sql);
                $data = ["result" => $stmt -> execute()];
                echo json_encode($data);
                break;

            case "avatar_read_all":
                // obtiene array con id y posicion de todos los avatares, la posicion cambia rapido
                $sql = "SELECT id, pos_x, pos_y FROM avatares";
                $stmt = $pdo -> prepare($sql);
                if ($stmt -> execute()) {
                    $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
                    if ($rows) {
                        echo json_encode($rows);
                        break;
                    }
                }
                echo json_encode([]);
                break;

            case "avatar_read_one":
                // dado un id retorna sus datos no posicionales, estos datos cambian lento o no cambian
                $sql = "SELECT nombre, emoji FROM avatares WHERE id = ?";
                $stmt = $pdo -> prepare($sql);
                $data = [
                    "id" => (int)$id,
                    "nombre" => "",
                    "emoji" => 0
                ];
                if ($stmt -> execute([$id])) {
                    $row = $stmt -> fetch(PDO::FETCH_ASSOC);
                    if ($row) {
                        $data["nombre"] = $row["nombre"];
                        $data["emoji"] = (int)$row["emoji"];
                    }
                }
                echo json_encode($data);
                break;
            
            default:
                // por defecto devolvera un json vacio
                echo json_encode([]);
                break;
        }
    }

    // dada una mascara verifica que el texto resultante solo tenga sus caracteres
    function okTexto($texto, $mascara) {
        $res = "";
        for ($i = 0; $i < mb_strlen($texto); $i++) {
            // los mb_ son capaces de procesar utf8, como emoticones, que ocupan mas de un espacio
            $c = mb_substr($texto, $i, 1);
            if (mb_strpos($mascara, $c) !== false) {
                $res .= $c;
            }
        }
        return $res;
    }

    // para nombres evitar emoticones, espacios o caracteres especiales
    function okNombre($nombre) {
        $msk = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ".
            "0123456789áéíóúÁÉÍÓÚ";
        return okTexto($nombre, $msk);
    }

    // para mensajes por ejemplo de chat, hay mas libertad de caracteres
    function okMensaje($mensaje) {
        $msk = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ".
            "0123456789áéíóúÁÉÍÓÚ _\n.:,;<>{}[]^+-*/~'\"¿?¡!\\=()&%$#|°";
        return okTexto($mensaje, $msk);
    }
?>
