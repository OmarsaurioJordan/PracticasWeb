<?php
    require "tool_db.php";
    require "avatar.php";

    $id = $_POST['id'];
    $sql = "SELECT * FROM usuarioex WHERE id=? AND password=?";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute([$id, $_POST['password']]);
    $datos = $stmt -> fetch(PDO::FETCH_ASSOC);
    if (!$datos) {
        $msj = "Clave incorrecta...";
        header("location:index.php?msj=$msj");
        exit;
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
        <h1>Editar Usuario</h1>

        <button onClick="location.href='index.php'">Volver</button>
        
        <form class="cajon" action="logic.php" method="post">
            <input type='hidden' name='accion' value='U'>
            <input type='hidden' name='id' value=<?php echo $id; ?>>
            <select class='avatar' name="avatar">
                <?php
                    for ($i = 0; $i < count($avatar); $i++) {
                        if ($i == $datos['avatar']) {
                            echo "<option class='avatar'
                                value=$i selected>" .getAvatar($i).
                                "</option>";
                        }
                        else {
                            echo "<option class='avatar'
                                value=$i>" .getAvatar($i). "</option>";
                        }
                    }
                ?>
            </select>
            <input type="text" name="nombre" maxlength="255"
                placeholder="Nombre" value=
                "<?php echo $datos['nombre']; ?>" required>
            <select name="genero">
                <?php
                    for ($i = 0; $i < count($generos); $i++) {
                        if ($i == $datos['genero']) {
                            echo "<option value=$i selected>".
                                getGenero($i). "</option>";
                        }
                        else {
                            echo "<option value=$i>".
                                getGenero($i). "</option>";
                        }
                    }
                ?>
            </select>
            <input type="url" name="link" maxlength="255"
                placeholder="Link" value=
                "<?php echo $datos['link']; ?>">
            <button type="submit">Actualizar</button>
        </form>
    </body>
</html>
