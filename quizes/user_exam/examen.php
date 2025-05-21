<?php
    require "tool_db.php";
    require "../Quiz.php";
    require "ex" .$_POST['examen']. ".php";

    $eval = new Quiz();
    $id = $_POST['id'];
    $examen = $_POST['examen'];
    $nt = "nota". $examen;

    $sql = "SELECT $nt FROM usuarioex WHERE id=? AND password=?";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute([$id, $_POST['password']]);
    $datos = $stmt -> fetch(PDO::FETCH_ASSOC);
    if ($datos) {
        if ($datos[$nt] != -1) {
            $msj = "Ya intentó hacer el exámen...";
            header("location:index.php?msj=$msj");
            exit;
        }
    }
    else {
        $msj = "Clave incorrecta...";
        header("location:index.php?msj=$msj");
        exit;
    }

    $sql = "UPDATE usuarioex SET $nt='-2' WHERE id=?";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute([$id]);
    if ($stmt -> rowCount() == 0) {
        $msj = "No se pudo acceder al exámen...";
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
        <h1><?php echo $titulo; ?></h1>

        <h2 id="contador">...</h2>
        
        <form class="examen" action="logic.php" method="post" id="formulario">
            <?php
                $eval -> setEvaluacion($data);
                $eval -> setCounters();
            ?>
            <input type='hidden' name='id' value=<?php echo $id; ?>>
            <input type='hidden' name='examen' value=<?php echo $examen; ?>>
            <input type='hidden' name='accion' value='X'>
            <button type="submit">Enviar</button>
        </form>
    </body>
</html>

<script>
    let preguntas = parseInt("<?php echo count($data); ?>");
    let segundos = 60 * (preguntas + 1);
    const contador = document.getElementById("contador");
    const formulario = document.getElementById("formulario");
    const reloj = setInterval(() => {
        segundos--;
        let minu = Math.floor(segundos / 60);
        let seg = Math.round((segundos / 60 - minu) * 60);
        contador.textContent = String(minu).padStart(2, '0') +
            " : " + String(seg).padStart(2, '0');
        if (segundos < 0) {
            clearInterval(reloj);
            formulario.submit();
        }
    }, 1000);
</script>
