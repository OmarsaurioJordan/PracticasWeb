<?php
    include "tool_master.php";
    include "tool_db.php";
    
    $mail = $_POST['mail'];
    $clave = setClave($_POST['clave']);

    $res = doQuery("SELECT id, nombre, id_rol, clave, id_estado
        FROM usuarios WHERE mail=?", [$mail]);
    if ($res[0]) {
        if (count($res[1]) == 0) {
            header("Location:index.php?msj=void");
        }
        else if ($res[1][0]['id_estado'] != 1) {
            header("Location:index.php?msj=mal_estado");
        }
        else if ($clave == $res[1][0]['clave']) {
            $_SESSION['user'] = $res[1][0]['id'];
            $_SESSION['nombre'] = $res[1][0]['nombre'];
            $_SESSION['rol'] = $res[1][0]['id_rol'];
            header("Location:menu.php");
        }
        else {
            header("Location:index.php?msj=mal_login");
        }
    }
    else {
        header("Location:index.php?msj=error_db");
    }
?>
