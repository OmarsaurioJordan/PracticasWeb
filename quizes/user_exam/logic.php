<?php
    require "tool_db.php";
    require '../Quiz.php';

    $serverMail = "";//"ojorcio@omwekiatl.xyz";

    $msj = "";

    function newPassword($decimales) {
        $pass = "";
        $msk = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        for ($r = 0; $r < $decimales; $r++) {
            $pass .= $msk[random_int(0, strlen($msk) - 1)];
        }
        return $pass;
    }

    function sendPassword($mail_from, $mail_to, $password) {
        global $msj;
        if ($mail_from == "") {
            $msj = "Modo test, clave: ". $password;
        }
        else {
            if (mail($mail_to, "Clave User Exam",
                    "Hola, este e-mail proviene de:\n\nhttps://www.omwekiatl.xyz".
                    "\n\nUna página web para hacer sencillas evaluaciónes ".
                    "de diversos temas, con un fín académico, creada por ".
                    "Omar Jordán Jordán, del ADSO24 del SENA en 2025\n\n".
                    "Aquí tiene su clave de acceso: ". $password.
                    "\n\nSi tiene inquietudes, comuníquese a: ojorcio@gmail.com",
                    "From: $mail_from")) {
                $msj = "Clave enviada a: ". $mail_to;
            }
            else {
                $msj = "No se pudo enviar el mail...";
            }
        }
    }

    switch ($_POST['accion']) {

        case "C":
            $password = newPassword(6);
            $sql = "INSERT INTO usuarioex (correo, password, nombre,
                avatar, link, genero) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $pdo -> prepare($sql);
            $stmt -> execute([
                $_POST['correo'], $password, $_POST['nombre'],
                $_POST['avatar'], $_POST['link'], $_POST['genero']
            ]);
            if ($stmt -> rowCount() > 0) {
                sendPassword($serverMail, $_POST['correo'], $password);
            }
            else {
                $msj = "No se pudo crear...";
            }
            break;
        
        case "U":
            $sql = "UPDATE usuarioex SET nombre=?,
                avatar=?, link=?, genero=? WHERE id=?";
            $stmt = $pdo -> prepare($sql);
            $stmt -> execute([
                $_POST['nombre'], $_POST['avatar'],
                $_POST['link'], $_POST['genero'],
                $_POST['id']
            ]);
            if ($stmt -> rowCount() > 0) {
                $msj = "Usuario actualizado!!!";
            }
            else {
                $msj = "No se pudo actualizar...";
            }
            break;

        case "D":
            $sql = "UPDATE usuarioex SET activo='0' WHERE id=? AND password=?";
            $stmt = $pdo -> prepare($sql);
            $stmt -> execute([
                $_POST['id'], $_POST['password']
            ]);
            if ($stmt -> rowCount() > 0) {
                $msj = "Usuario eliminado!!!";
            }
            else {
                $msj = "No se pudo eliminar...";
            }
            break;
        
        case "S":
            $password = newPassword(6);
            $sql = "UPDATE usuarioex SET password=?, time_recupera=NOW() WHERE
                correo=? AND time_recupera < (NOW() - INTERVAL 60 MINUTE)";
            $stmt = $pdo -> prepare($sql);
            $stmt -> execute([
                $password, $_POST['correo']
            ]);
            if ($stmt -> rowCount() > 0) {
                sendPassword($serverMail, $_POST['correo'], $password);
            }
            else {
                $msj = "Reintenta recuperar la contraseña más tarde...";
            }
            break;

        case "X":
            $eval = new Quiz();
            $eval -> getResponse();
            $nota = $eval -> getNota();
            $nt = "nota". $_POST['examen'];
            $sql = "UPDATE usuarioex SET $nt=? 
                WHERE id=? AND $nt='-2'";
            $stmt = $pdo -> prepare($sql);
            $stmt -> execute([
                $nota, $_POST['id']
            ]);
            if ($stmt -> rowCount() > 0) {
                $msj = "Su nota se ha guardado!!!";
            }
            else {
                $msj = "No se logró salvar la nota...";
            }
            break;
    }

    header("location:index.php?msj=$msj");
?>
