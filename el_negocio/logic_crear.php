<?php
    include "tool_master.php";
    include "tool_db.php";
    
    $mail = $_POST['mail'];
    $nombre = $_POST['nombre'];
    $clave = setClave($_POST['clave']);
    $rol = $_POST['rol'];

    $res = doQuery("INSERT INTO usuarios (mail, nombre, clave, id_rol)
        VALUES (?, ?, ?, ?)", [$mail, $nombre, $clave, $rol]);
    if ($res[0]) {
        header("Location:index.php?msj=registrado");
    }
    else {
        header("Location:index.php?msj=existe_mail");
    }
?>
