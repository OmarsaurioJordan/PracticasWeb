<?php
include "Global.php";
include "DB.php";

function newPassword($longitud) {
    $msk = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
    $password = "";
    for ($i = 0; $i < $longitud; $i++) {
        $password .= $msk[random_int(0, strlen($msk) - 1)];
    }
    return $password;
}

function doMail($email, $password) {
    global $hostMail, $hostLink, $myMail, $db_password;
    if ($db_password == "") {
        return true;
    }
    $mail_header = "From: ". $hostMail;
    $mail_subject = "Evalúame Clave";
    $mail_msj = "Hola, este e-mail proviene de:\n\n". $hostLink.
        "\n\nUna página web para hacer sencillas evaluaciónes ".
        "de diversos temas, con un fín académico, creada por ".
        "Omar Jordán Jordán, del ADSO24 del SENA en 2025\n\n".
        "Aquí tiene su clave de acceso: ". $password.
        "\n\nPodrá modificarla desde el sitio si desea.\n\n".
        "Si tiene inquietudes, comuníquese a: ". $hostMail;
    return mail($email, $mail_subject, $mail_msj, $mail_header);
}

$password = "";
$nombre = "";
$genero = "";
$edad = "";
$descripcion = "";
$haydatos = false;
$msj = "void";

$email = isset($_POST['email']) ? $_POST['email'] : "";
$recuperar = isset($_POST['recuperar']) ? $_POST['recuperar'] : "off";

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $res = doQuery("SELECT id FROM login WHERE email=?", [$email]);
    if (!$res[0]) {
        $msj = "error_db";
    }
    else {
        if (count($res[1]) == 0 || $recuperar != "off") {
            $password = newPassword(8);
            if (doMail($email, $password)) {
                if (count($res[1]) == 0) {
                    $ress = doQuery("INSERT INTO login (email, password) VALUES (?, ?)",
                        [$email, $password]);
                }
                else {
                    $ress = doQuery("UPDATE login SET password=? WHERE email=?",
                        [$password, $email]);
                }
                if (!$ress[0]) {
                    $msj = "error_db";
                }
                else {
                    $msj = $db_password == "" ? "test" : "ok";
                }
            }
            else {
                $msj = "error_mail";
            }
        }
        $va_bien = $msj == "ok" || $msj == "test" || $msj == "";
        if (count($res[1]) != 0 && $va_bien) {
            $row = $res[1][0];
            $data = doQuery("SELECT nombre, genero, edad, descripcion
                FROM usuario WHERE id_login=?", [$row['id']]);
            if ($data[0]) {
                if (count($data[1]) != 0) {
                    $row = $data[1][0];
                    $nombre = $row['nombre'];
                    $genero = $row['genero'];
                    $edad = $row['edad'];
                    $descripcion = $row['descripcion'];
                    $haydatos = true;
                }
                $msj = $db_password == "" ? "test" : "ok";
            }
            else {
                $msj = "error_db";
            }
        }
        if ($msj == "test") {
            $res = doQuery("SELECT password FROM login WHERE email=?", [$email]);
            if (count($res[1]) != 0) {
                $row = $res[1][0];
                $password = $row['password'];
            }
        }
    }
}
else {
    $msj = "mal_mail";
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <title>Evalúame</title>
    </head>
    <body>
        <main class="superior">
            <?php echo showMsj($msj); ?>
            <h1>Evalúame</h1>
            <p class="subtitulo">Haga exámenes de conocimiento variopintos</p>
            <form class="contenedor" action="Perfil.php" method="post">
                <h2>Login y Edición</h2>
                <label><?php echo "hola: ". $email; ?></label><br>
                <label for="password">clave de acceso</label>
                <input type="password" id="password" name="password" required>
                <label for="nombre">escribe tu nombre</label>
                <input type="text" id="nombre" name="nombre" value=
                    "<?php echo $nombre; ?>" required>
                <label>elige tu género</label>
                <select value="genero" required>
                    <option value="M" <?php echo $genero == "M" ? "selected" : ""; ?>
                        >Mujer</option>
                    <option value="H" <?php echo $genero == "H" ? "selected" : ""; ?>
                        >Hombre</option>
                    <option value="T" <?php echo $genero == "T" ? "selected" : ""; ?>
                        >No-binario</option>
                </select>
                <label for="edad">fecha de nacimiento</label>
                <input type="date" id="edad" name="edad" value=
                    "<?php echo $edad; ?>" required>
                <label for="descripcion">descripción</label>
                <textarea id="descripcion" name="descripcion" rows="10" cols="50"
                    maxlength="255"><?php echo $descripcion; ?></textarea>
                <input type="hidden" name="email" value="<?php echo $email; ?>">
                <input type="hidden" name="accion" value="<?php echo $haydatos; ?>">
                <?php
                    echo "<button class='boton' type='submit'";
                    if ($msj != "ok" && $msj != "test") {
                        echo " disabled";
                    }
                    echo ">Guardar</button>";
                ?>
            </form>
            <div class="contenedor">
                <h2>Menú y Resultados</h2>
                <a class="boton" href="index.php">Volver</a>
            </div>
        </main>
        <footer class="piesito">
            <hr>
            <p class="subtitulo"><?php echo $piesito; ?></p>
        </footer>
    </body>
</html>
