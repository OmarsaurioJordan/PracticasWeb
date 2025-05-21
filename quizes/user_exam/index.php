<?php
    require "tool_db.php";
    require "avatar.php";

    $tot_notas = 6;

    $msj = isset($_GET['msj']) ? $_GET['msj'] : "";

    $btn_id = 0;
    function getBtnPrueba($examen, $id) {
        global $btn_id;
        $btn_ant = $btn_id;
        $btn_id++;
        return "<form action='examen.php' method='post' 
            onsubmit='return isPassword()'>
            <input type='hidden' name='id' value='$id'>
            <input type='hidden' name='examen' value='$examen'>
            <input type='hidden' name='password' value='' 
            id='autoPass_$btn_ant'>
            <button type='submit'>Test $examen</button>
            </form>";
    }

    function getLink($link) {
        $sublink = explode('.', $link);
        if (count($sublink) == 1) {
            return getStrLimi($sublink[0]);
        }
        return getStrLimi($sublink[1]);
    }

    function getShortName($nombre) {
        $partes = explode(' ', $nombre);
        $newName = "";
        for ($i = 0; $i < min(3, count($partes)); $i++) {
            if ($i == 0) {
                $newName .= getStrLimi($partes[$i]);
            }
            else {
                $newName .= "<br>". getStrLimi($partes[$i]);
            }
        }
        return $newName;
    }

    function getStrLimi($str, $limit=12) {
        return strlen($str) > $limit ? substr($str, 0, $limit) . "..." : $str;
    }

    $sql = "SELECT * FROM usuarioex WHERE activo='1' ORDER BY fecha_registro DESC";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute([]);
    $informacion = "";
    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        $informacion .= "<tr>
            <td class='avatar'>" .getAvatar($row['avatar']). "</td>
            <td>" .getShortName($row['nombre']). "</td>
            <td>" .getGenero($row['genero'], true). "</td>";
        $final = 0;
        for ($i = 1; $i <= $tot_notas; $i++) {
            $btn = getBtnPrueba($i, $row['id']);
            $nota = $row["nota$i"];
            switch ($nota) {
                case -2:
                    $nota = "X";
                    break;
                case -1:
                    $nota = $btn;
                    break;
            }
            $final += max(0, $row["nota$i"]);
            $informacion .= "<td>" .$nota. "</td>";
        }
        $final = round(($final / $tot_notas) * 10) / 10;
        $informacion .= "<td>$final</td>
            <td><a href=" .$row['link']. " target='_blank'>".
                getLink($row['link']). "</a></td>
            <td>" .str_replace(" ", "<br>", $row['fecha_registro']). "</td>
            <td><div class='lateral'>
                <form action='edit.php' method='post' onsubmit='return isPassword()'>
                    <input type='hidden' name='id' value='" .$row['id']. "'>
                    <input type='hidden' name='password' value='' id='autoPass1'>
                    <button type='submit'>Editar</button>
                </form>
                <form action='logic.php' method='post' onsubmit='return isPassword()'>
                    <input type='hidden' name='accion' value='D'>
                    <input type='hidden' name='password' value='' id='autoPass2'>
                    <input type='hidden' name='id' value='" .$row['id']. "'>
                    <button class='danger' type='submit'>Eliminar</button>
                </form>
                <form action='logic.php' method='post'>
                    <input type='hidden' name='accion' value='S'>
                    <input type='hidden' name='correo' value='" .$row['correo']. "'>
                    <button type='submit'>Rec.Mail</button>
                </form></div>
            </td>
            </tr>";
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <title>User Exam</title>
    </head>
    <body>
        <h1>Notas de Usuarios</h1>

        <div class='lateral'>
            <button class="danger" onClick="location.href='index.php'">Recargar</button>
            <button onClick="location.href='create.php'">Crear Usuario</button>
        </div>

        <p class="parrafo">Registrese, obtendrá una clave en su correo, con ello podrá hacer
            los exámenes, recuerde que una vez iniciado un exámen, no puede
            recargar ni retroceder la página o perderá el intento, tendrá un tiempo 
            límite para resolverlo, sepa que si elimina su cuenta no podrá reactivarla 
            luego, use el link para compartir alguna web o red social con la comunidad, 
            el botón de Rec.Mail envía una nueva contraseña a su correo
        </p>

        <table>
            <tr>
                <th>Avatar</th>
                <th>Nombre</th>
                <th>Gen</th>
                <?php
                    for ($i = 1; $i <= $tot_notas; $i++) {
                        echo "<th>Nota $i</th>";
                    }
                ?>
                <th>Final</th>
                <th>Link</th>
                <th>Registro</th>
                <th>Acciones</th>
            </tr>
            <?php echo $informacion; ?>
        </table>
        <?php
            if ($informacion == "") {
                echo "<h3>No hay datos</h3>";
            }
        ?>

        <footer>
            <hr>
            <p>Created by Omwekiatl 2025</p>
        </footer>
    </body>
</html>

<script>
    let msj = "<?php echo $msj; ?>";
    if (msj != "") {
        alert(msj);
    }

    function isPassword() {
        let pwd = prompt("Ingresa tu coclave:");
        if (pwd !== null) {
            document.getElementById("autoPass1").value = pwd;
            document.getElementById("autoPass2").value = pwd;
            let btn_id = "<?php echo $btn_id; ?>";
            for (let i = 0; i < btn_id; i++) {
                if (!document.getElementById("autoPass_" + i)) {
                    continue;
                }
                document.getElementById("autoPass_" + i).value = pwd;
            }
            return true;
        }
        return false;
    }
</script>
