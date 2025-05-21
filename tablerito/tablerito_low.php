<?php

    // datos o sistema de informacion del programa, unos dados por usuario
    $limit = 20;
    $mapa = "";
    $mover = isset($_POST['mover']) ? $_POST['mover']: "";
    $posx = isset($_POST['posx']) ? $_POST['posx']: $limit / 2;
    $posy = isset($_POST['posy']) ? $_POST['posy']: $limit / 2;

    // depuracion de los comandos de usuario para movimiento
    switch ($mover) {
        case "W":
        case "w":
            $posx = max(0, $posx - 1);
            break;
        case "S":
        case "s":
            $posx = min($limit - 1, $posx + 1);
            break;
        case "A":
        case "a":
            $posy = max(0, $posy - 1);
            break;
        case "D":
        case "d":
            $posy = min($limit - 1, $posy + 1);
            break;                        
    }

    // se calcula el tablero pero esto aun no se dibuja
    for ($x = 0; $x < $limit; $x++) {
        for ($y = 0; $y < $limit; $y++) {
            if ($x == $posx && $y == $posy) {
                $mapa .= " X ";
            }
            else {
                $mapa .= " . ";
            }
        }
        $mapa .= "<br>";
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>

    <!-- configuracion del documento html -->
    <title>Tablerito</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- aplicacion de estilos para decorar la pagina -->
    <style>
        body {
            font-family: 'Consolas', monospace;
            background-color: black;
            color: white;
        }
        .botoncito {
            background-color: #D3D3D3;
            width: 300px;
        }
        .botoncito:hover {
            background-color: #505050;
        }
    </style>
    
</head>
<body>

    <!-- cabecera o titulo de la pagina -->
    <header><h1>Tablerito</h1></header>

    <!-- pinta el tablero como tal -->
    <p><?php echo $mapa; ?></p>

    <!-- entrada de comandos de usuario -->
    <form action="tablerito_low.php" method="post" autocomplete="off">
        <div>
            <label for="mover">Mover (W S A D)</label>
            <input type="text" id="mover" name="mover" value=""
                autocomplete="off">
        </div>
        <input type="hidden" name="posx" value="<?php echo $posx; ?>">
        <input type="hidden" name="posy" value="<?php echo $posy; ?>">
        <button type="submit" class="botoncito" id="botoncito">GO</button>
    </form>

    <!-- codigo para agregar comportamientos en el cliente -->
    <script>
        // al cargar la pagina la linea de escritura esta enfocada
        window.onload = function() {
            document.getElementById('mover').focus(); 
        };
    </script>

</body>
</html>
