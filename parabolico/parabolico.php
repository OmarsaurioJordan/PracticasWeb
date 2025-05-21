<?php
// poner estos valores tambien en CSS
$width = 64;
$height = 64;
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="parabolico.css">
        <title>Parábola</title>
    </head>
    <body>
        <input type="hidden" id="width" value="<?php echo $width; ?>">
        <input type="hidden" id="height" value="<?php echo $height; ?>">
        <h1>Parábola</h1>
        <div class="rejilla">
            <?php
                for ($y = $height - 1; $y >= 0; $y--) {
                    for ($x = 0; $x < $width; $x++) {
                        echo "<div class='pix' id='" .$x. "_" .$y. "'></div>";
                    }
                }
            ?>
        </div>
        <div class="comps">
            <label>Gravedad (9.8 def):</label>
            <input type="number" min="0" max="90" id="gra" value="9.8">
            <label>Ángulo (0° a 90°):</label>
            <input type="number" min="0" max="90" id="ang" value="60">
            <label>Velocidad (25 m/s):</label>
            <input type="number" min="0" max="90" id="vel" value="25">
            <label>Altura máxima:</label>
            <label id="res_alt">???</label>
            <label>Distancia máxima:</label>
            <label id="res_dis">???</label>
            <label>Tiempo de vuelo:</label>
            <label id="res_tim">???</label>
            <label>...</label>
            <button onclick="calcular()">Calcular</button>
        </div>
        <footer>
            <hr>
            <p>Creado por <a href="https://omwekiatl.itch.io/">Omwekiatl</a></p>
        </footer>
        <script src="parabolico.js"></script>
    </body>
</html>
