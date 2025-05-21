<?php

    // configuracion del programa, constantes
    $limit = 20;
    $enemigos = 16;

    // para crear valores aleatorios en el rando del limite
    function randPos() {
        global $limit;
        return mt_rand(0, $limit - 1);
    }

    // dado un texto con las posiciones de enemigos, retorna un array
    function getPosEnemigos($txt) {
        global $enemigos;
        $enexy = [];
        if ($txt == "") {
            // si el texto es vacio, pone valores aleatorios
            for ($i = 0; $i < $enemigos; $i++) {
                $enexy[] = [randPos(), randPos()];
            }
        }
        else {
            // el formato es: x1,y1|x2,y2|x3,y3
            $duplas = explode("|", $txt);
            for ($i = 0; $i < $enemigos; $i++) {
                $xy = explode(",", $duplas[$i]);
                $enexy[] = [$xy[0], $xy[1]];
            }
        }
        return $enexy;
    }

    // convierte el array de duplas x,y en un texto formateado
    function setPosenemigos() {
        global $enemigos, $enexy;
        // el formato es: x1,y1|x2,y2|x3,y3
        $txt = "";
        for ($i = 0; $i < $enemigos; $i++) {
            $txt .= $enexy[$i][0] . "," . $enexy[$i][1];
            if ($i < $enemigos - 1) {
                $txt .= "|";
            }
        }
        return $txt;
    }

    // obtiene las coordenadas x,y del usuario o sino un valor al azar
    function getPosPlayer() {
        $x = isset($_POST['posx']) ? $_POST['posx']: randPos();
        $y = isset($_POST['posy']) ? $_POST['posy']: randPos();
        return [$x, $y];
    }

    // actualiza una posicion x,y segun la direccion dada
    function movimiento($xy, $mov) {
        global $limit;
        switch ($mov) {
            case "w":
                $xy[0] = max(0, $xy[0] - 1);
                break;
            case "s":
                $xy[0] = min($limit - 1, $xy[0] + 1);
                break;
            case "a":
                $xy[1] = max(0, $xy[1]- 1);
                break;
            case "d":
                $xy[1] = min($limit - 1, $xy[1] + 1);
                break;                        
        }
        return $xy;
    }

    // funcion principal, se ejecuta una vez al cargar la pagina web
    function main() {
        global $enexy, $posxy, $enemigos;

        // ejecucion de el movimiento del usuario
        $mov = isset($_POST['mover']) ? $_POST['mover']: "";
        $posxy = movimiento($posxy, strtolower($mov));

        // ejecucion de movimiento de los enemigos
        $opciones = ["w", "s", "a", "d", "", ""];
        for ($i = 0; $i < $enemigos; $i++) {
            $mov = $opciones[array_rand($opciones)];
            if ($mov != "") {
                $enexy[$i] = movimiento($enexy[$i], $mov);
            }
        }
    }

    // se calcula el tablero entregando un texto para ser dibujado
    function mapa() {
        global $enexy, $posxy, $enemigos, $limit;
        $mapa = "";
        for ($x = 0; $x < $limit; $x++) {
            for ($y = 0; $y < $limit; $y++) {
                $isene = false;
                for ($i = 0; $i < $enemigos; $i++) {
                    if ($x == $enexy[$i][0] && $y == $enexy[$i][1]) {
                        $isene = true;
                        break;
                    }
                }
                if ($isene) {
                    if ($x == $posxy[0] && $y == $posxy[1]) {
                        $mapa .= "(X)";
                    }
                    else {
                        $mapa .= ".O.";
                    }
                }
                else if ($x == $posxy[0] && $y == $posxy[1]) {
                    $mapa .= ".X.";
                }
                else {
                    $mapa .= "...";
                }
            }
            $mapa .= "<br>";
        }
        return $mapa;
    }

    $enexy = getPosEnemigos(isset($_POST['posene']) ? $_POST['posene']: "");
    $posxy = getPosPlayer();
    main();
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
    <p><?php echo mapa(); ?></p>

    <!-- entrada de comandos de usuario -->
    <form action="tablerito_med.php" method="post" autocomplete="off">
        <div>
            <label for="mover">Mover (W S A D)</label>
            <input type="text" id="mover" name="mover" value=""
                autocomplete="off">
        </div>
        <input type="hidden" name="posx" value="<?php echo $posxy[0]; ?>">
        <input type="hidden" name="posy" value="<?php echo $posxy[1]; ?>">
        <input type="hidden" name="posene" value="<?php echo setPosenemigos(); ?>">
        <button type="submit" class="botoncito" id="botoncito">GO</button>
    </form>

    <!-- codigo para agregar comportamientos en el cliente -->
    <script>

        // al cargar la pagina la linea de escritura esta enfocada
        window.onload = function() {
            document.getElementById('mover').focus(); 
        };

        // cada cierto tiempo recargar la pagina autopulsando el boton
        function actualizar() {
            document.getElementById("botoncito").click();
        }
        setInterval(actualizar, 3000);

    </script>

</body>
</html>
