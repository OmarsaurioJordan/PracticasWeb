<?php
$piesito = "Omar Jordan Jordan - ADSO24 - SENA - 2025";
$hostLink = "https://www.omwekiatl.xyz/evaluame";
$hostMail = "ojorcio@omwekiatl.xyz";
$myMail = "ojorcio@gmail.com";

function showMsj($msj, $extra="") {
    switch ($msj) {
        case "mail_ok":
            return [true, "Se ha envíado un e-mail con la clave de acceso!!!"];
        case "mail_test":
            return [true, "Test: sin e-mail, $extra"];
        case "error_mail":
            return [false, "Falla interna enviando e-mail, reinténtalo!!!"];
        case "error_db":
            return [false, "Falla interna en la DB, reinténtalo!!!"];
        case "mal_mail":
            return [false, "Debes escribir un e-mail válido!!!"];
        case "mal_password":
            return [false, "La clave de acceso es incorrecta!!!"];
        case "void":
            return [false, "No se obtuvieron datos!!!"];
    }
    return [true, ""];
}

function encabezado() {
    echo "<meta charset='utf-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<link rel='stylesheet' href='styles.css'>";
    echo "<title>Evalúame</title>";
}

function notaalpie() {
    global $piesito;
    echo "<footer class='piesito'>";
    echo "<hr>";
    echo "<p class='subtitulo'>$piesito</p>";
    echo "</footer>";
}
?>
