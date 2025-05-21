<?php
// ejemplo de uso de la clase Evaluacion

require 'Quiz.php';
$eval = new Quiz();

$qst1 = [
    "¿Qué es una garbimba?",
    "Alguien de calle que oye reggetón",
    "Una persona altamente intelectual",
    "Quién se revienta en el gimnasio",
    "Cualquiera con resentimiento social"
];
$qst2 = [
    "¿A qué sabe el limón?",
    "Ácido hasta lo más insoportable",
    "Igual de dulce que la miel de abeja",
    "Amargo y áspero como el pelaje de oso",
    "A carne, a pura y deliciosa carne",
    "El limón no sabe realmente a nada"
];

$qst3 = ["¿Los Mohicanos ganaron la guerra fría en 1969?", false];
$qst4 = ["¿La vía láctea fué creada por el amamante de Hércules?", true];

$qst5 = [
    "¿Cómo le dicen, al tipo de las garras que se regenera en X-Men?",
    "Wolverine", "Lobezno", "Logan"
];

$qst6 = [
    "¿Cuáles son órganos del cuerpo humano?",
    "VCorazón de dos válculas",
    "VPulmónes terrestres",
    "FVejiga natatoria",
    "FCloroplastos",
    "FCaparazón cutáneo"
];
$qst7 = [
    "¿Cuáles son personajes colombianos?",
    "VHilda Reyes",
    "VGarcía Márquez",
    "FTill Lindeman",
    "FNapoleón Bonaparte"
];

$qst8 = ["¿Cuánto es el doble de 40 / 5?", 16];

$data = [
    ["R", $qst1], ["R", $qst2],
    ["Q", $qst3], ["Q", $qst4],
    ["T", $qst5], ["N", $qst8],
    ["S", $qst6], ["S", $qst7]
];
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Evaluación</title>
    </head>

    <body>
        <h1>Preguntotas</h1>
        
        <!-- asi se hacen las preguntas -->
        <form action="ejemplo.php" method="POST">
            <?php
                // para poner las preguntas mezcladas al azar
                $eval -> setEvaluacion($data);
                /*
                // para poner las preguntas en un orden fijo una por una
                $eval -> setRound($qst1);
                $eval -> setRound($qst2);
                $eval -> setQuest($qst3);
                $eval -> setQuest($qst4);
                $eval -> setTexto($qst5);
                $eval -> setSquare($qst6);
                $eval -> setSquare($qst7);
                $eval -> setNumber($qst8);
                */
                // esto debe ponerse siempre
                $eval -> setCounters();
            ?>
            <button type="submit">Enviar</button>
        </form>

        <!-- asi se obtiene la respuesta -->
        <?php
            if ($eval -> getResponse()) {
                $nota = $eval -> getNota();
                echo "<p>Su nota fué: $nota / 5</p>";
            }
            else {
                echo "<p>Debe responder las preguntas</p>";
            }
        ?>
    </body>
</html>
