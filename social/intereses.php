<?php
// creado por Omwekiatl 2025

$intereses = [["❓", "..."],
    ["🔭", "Ciencia / Investigación"], ["📽️", "Películas / Cine"], ["📺", "Series / Animes"],
    ["🎧", "Música / Melomanía"], ["🎸", "Instrumentos / Cantar"], ["📷", "Fotografía / Video"],
    ["🧠", "Filosofía / Pensamiento"], ["🗿", "Historia / Mitología"], ["🦹", "Cómics / Mangas"],
    ["🧚", "Literatura / Fantasía"], ["📝", "Escritura / Opimión"], ["📚", "Estudio / Académico"],
    ["🖥️", "Tecnología / Gadgets"], ["⚽", "Fútbol / Hinchada"], ["🛹", "Patineta / Patines"],
    ["🏀", "Deportes con Balón"], ["💪", "Gimnasio / Pesas"], ["🤸", "Calistenia / Yoga"],
    ["🏃", "Correr / Atletismo"], ["🚴", "Bicicleta / Ciclismo"], ["🏊", "Natación / Buceo"],
    ["🥋", "Lucha / Arte Marcial"], ["🧗", "Deportes Extremos"], ["🐎", "Equitación / Anim. Granja"],
    ["🐶", "Mascotas: Perros"], ["🐱", "Mascotas: Gatos"], ["🐭", "Mascotas: Otras"],
    ["🐍", "Anim. Salvajes"], ["🌱", "Cultivar / Jardinería"], ["🌲", "Naturaleza / Conservación"],
    ["🥑", "Veganismo / Alimentación"], ["🍝", "Cocinar / Gastronomía"], ["🍰", "Comer / Restaurantes"],
    ["✝️", "Religión: Cristiana"], ["☯️", "Religión: Taoísta"], ["☪️", "Religión: Musulmana"],
    ["🕉️", "Religión: Hinduísta"], ["☮️", "Religión: Otras"], ["🔮", "Espiritualidad / Magia"],
    ["✈️", "Viajar / Hoteles"], ["🏕️", "Excursiónes / Acampar"], ["🚗", "Autos / Carreras"],
    ["🏍️", "Motos / Paseos"], ["💃", "Bailar / Danza"], ["🍻", "Cerveza / Alcohol"],
    ["🎨", "Dibujo / Animación"], ["🎭", "Teatro / Actuación"], ["🎲", "Juegos de Azar"],
    ["🎮", "Videojuegos / J. de Mesa"], ["💡", "Creatividad / Ideas"], ["🏛️", "Museos / Cultura"],
    ["👥", "Socializar / Charlar"], ["💬", "Redes Sociales / Chatear"], ["🎁", "Recibir: Regalos / Dinero"],
    ["💰", "Emprendimiento / Empresa"], ["💼", "Trabajar / Asalariado"], ["🏳️", "Paz / Política: Centro"],
    ["🏳️‍🌈", "Progresismo / LGBTI"], ["📊", "Capitalismo / Libremercado"], ["⚖️", "Comunismo / Socialismo"],
    ["💞", "Romance / Amor"], ["👙", "Desnudez / Erotismo"], ["🍑", "Sexo / Fetiches"],
    ["✂️", "Manualidades / Costura"], ["⚔️", "Seguridad / Justicia"], ["👶", "Familia / Hijos"],
    ["🚬", "Drogas: Sintéticas"], ["🍄", "Drogas: Naturales"], ["🔪", "Pandillas / Mafia"]
];

function setSelect($data, $name) {
    $txt = "<select id='$name' name='$name'>";
    for ($i = 0; $i < count($data); $i++) {
        $txt .= "<option value='$i'>" .$data[$i][0]. " " .$data[$i][1]. "</option>";
    }
    $txt .= "</select>";
    return $txt;
}

function setCalif($name) {
    $calif = ["-2 😭", "-1 ☹️", "-0 😶", "+1 🙂", "+2 😁", "+3 😍"];
    $txt = "<select id='$name' name='$name'>";
    for ($i = 0; $i < count($calif); $i++) {
        if ($i == 2) {
            $txt .= "<option value='$i' selected>" .$calif[$i]. "</option>";
        }
        else {
            $txt .= "<option value='$i'>" .$calif[$i]. "</option>";
        }
    }
    $txt .= "</select>";
    return $txt;
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <link rel="stylesheet" href="styles.css"> -->
        <title>Editar</title>
    </head>
    <body>
    <h1>Editar Gustos</h1>
    <form action="" method="POST">
        <?php
            $ind = ["1️⃣ primero", "2️⃣ segundo", "3️⃣ tercero", "4️⃣ cuarto"];
            for ($i = 0; $i < count($ind); $i++) {
                echo "<p><label>¿Qué es lo " .$ind[$i]. " que más te 👍 gusta?</label><br>";
                echo setSelect($intereses, "like".$i);
                echo "</p>";
            }
            for ($i = 0; $i < count($ind); $i++) {
                echo "<p><label>¿Qué es lo " .$ind[$i]. " que más te 👎 disgusta?</label><br>";
                echo setSelect($intereses, "dislike".$i);
                echo "</p>";
            }
            echo "<p><ul>";
            for ($i = 1; $i < count($intereses); $i++) {
                echo "<li>" .setCalif("cal".$i). " " .$intereses[$i][0]. " " .$intereses[$i][1]. "</li>";
            }
            echo "</ul></p>";
        ?>
    </form>
    </body>
</html>
