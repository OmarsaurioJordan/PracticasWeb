<?php

$historial = isset($_POST['historial']) ? $_POST['historial'] : "";
$ant_nombre = isset($_POST['ant_nombre']) ? $_POST['ant_nombre'] : "";
$opt = isset($_POST['opt']) ? $_POST['opt'] : "0";

if ($opt == "1") {
    if ($historial != "") {
        $historial .= ",";
    }
    $historial .= $ant_nombre;
}
if ($historial != "") {
    $list_nombres = explode(",", $historial);
}
else {
    $list_nombres = [];
}

$nombre = [
    "Angy", "Angela", "Alejandra", "Amanda", "Andrea",
    "Ana", "Adriana", "Allison", "Aurora", "Agata",
    "Bonnie", "Bianca", "Barbara", "Bety", "Brenda",
    "Cony", "Camila", "Carolina", "Celeste", "Cindy",
    "Celia", "Catherine", "Cristina", "Coral", "Claudia",
    "Darian", "Diana", "Dafne", "Dora", "Delia",
    "Estefany", "Eliza", "Emily", "Elena", "Esmeralda",
    "Frida", "Florencia", "Fiona", "Fabiola", "Fatima",
    "Guisela", "Gema", "Gloria", "Gabriela", "Ginna",
    "Homura", "Helena", "Hilda", "Heidy", "Harley",
    "Ingrid", "Ines", "Isabella", "Irene", "Iris",
    "Jackie", "Jazmin", "Jade", "Jenny", "Jessica",
    "Karen", "Kimi", "Kala", "Keiko", "Kyoko",
    "Luisa", "Luz", "Luna", "Laura", "Lorena",
    "Maria", "Martha", "Maribel", "Melisa", "Marcela",
    "Marisol", "Melanie", "Miranda", "Monica", "Margarita",
    "Nora", "Nancy", "Nereida", "Natalia", "Nadia",
    "Olivia", "Olga", "Oriana", "Ofelia", "Ovidia",
    "Patricia", "Paula", "Paloma", "Paola", "Priscila",
    "Regina", "Rebeca", "Rocio", "Rosa", "Rubi",
    "Samanta", "Sara", "Susana", "Sonia", "Selina",
    "Tania", "Tamara", "Tatiana", "Teresa", "Trixie",
    "Victoria", "Valentina", "Valery", "Vanessa", "Vania",
    "Wanda", "Wendy", "Willow", "Winny", "Wynona",
    "Ximena", "Yolanda", "Zaira", "Quira", "Ursula"
];
$apellido = [
    "Acosta", "Aguilar", "Aguirre", "Alonso", "Andrade",
    "Báez", "Ballesteros", "Barrios", "Benítez", "Blanco",
    "Cabrera", "Calderón", "Campos", "Cano", "Carrillo",
    "Delgado", "Díaz", "Domínguez", "Duarte", "Durán",
    "Escalante", "Escobar", "Espinosa", "Estrada", "Echeverría",
    "Fernández", "Figueroa", "Flores", "Fonseca", "Franco",
    "Gálvez", "García", "Gil", "Gómez", "Guerrero",
    "Hernández", "Herrera", "Huerta", "Hurtado", "Huertas",
    "Ibáñez", "Iglesias", "Ibarra", "Izquierdo", "Islas",
    "Jáuregui", "Jiménez", "Juárez", "Jaramillo", "Jordán",
    "Lara", "León", "López", "Luján", "Lozano",
    "Maldonado", "Márquez", "Martínez", "Medina", "Molina",
    "Navarro", "Nieto", "Núñez", "Novoa", "Naranjo",
    "Olivares", "Orozco", "Ortega", "Ortiz", "Oviedo",
    "Pacheco", "Padilla", "Palma", "Pérez", "Ponce",
    "Quevedo", "Quintero", "Quiroga", "Quintana", "Quispe",
    "Ramírez", "Ramos", "Reyes", "Ríos", "Romero",
    "Salazar", "Salinas", "Sánchez", "Sandoval", "Soto",
    "Téllez", "Torres", "Trejo", "Trujillo", "Tovar",
    "Urbina", "Ureña", "Uribe", "Ulloa", "Urdiales",
    "Valdés", "Valencia", "Valenzuela", "Vásquez", "Vega",
    "King", "Walker", "Xu", "Yosa", "Werner",
    "Zambrano", "Zapata", "Zavala", "Zúñiga", "Zárate"
];
$zodiaco = [
    "♈","♉","♊","♋","♌","♍","♎","♏","♐","♑","♒","♓"
];
$lugar = [
    "Colombia", "Argentina", "Perú", "Brazil",
    "España", "Puerto Rico", "Panamá", "Venezuela",
    "Chile", "Ecuador", "México", "Uruguay"
];
$fisico = [
    "delgada", "gruesa", "atlética", "normal",
    "flaca", "gorda", "fuerte", "caderona"
];

$tras1 = [
    "Creció en la pobreza absoluta",
    "Nació en una familia adinerada",
    "Tuvo buen núcleo familiar e infancia",
    "Tiene muchos hermanos, una gran familia",
    "Con padres divorciados y aislada"
];
$tras2 = [
    "Era muy rebelde y se metía en problemas",
    "Sufrió bulling masivo en su colegio",
    "Tuvo su primer amor y no quedó preñada",
    "Le gustó mucho la disciplina deportiva",
    "Solamente se la pasó estudiando"
];
$tras3 = [
    "Es estudiante de cursos cortos tecnológicos",
    "Se dedica a trabajar en lo que salga",
    "Administra las tierras de una tía lejana",
    "Cursa una carrera universitaria",
    "Se ha dedicado completamente al arte"
];

$rasgos = [
    "Alegre",
    "Soñadora",
    "Creativa",
    "Nerviosa",
    "Hiperactiva",
    "Dormilona",
    "Conflictiva",
    "Grosera",
    "Habladora",
    "Pensativa",
    "Seria",
    "Disciplinada",
    "Juguetona",
    "Impulsiva",
    "Loca"
];

$salud = [
    "Problemas de visión",
    "Intoxicada por alimentos",
    "Parásitos intestinales",
    "Pierna amputada",
    "Brazo fracturado",
    "Malestar general",
    "Cortes en los brazos",
    "Dientes rotos",
    "Problemas epilépticos"
];

$relacion = [
    "tía", "hermana", "prima",
    "amante", "amiga", "sobrina",
    "jefa", "subdita", "hija"
];

$myNombre = ["", ""];

function getAzar($lista) {
    return $lista[random_int(0, count($lista) - 1)];
}

function getNombe($preApellido="") {
    global $nombre, $apellido, $myNombre;
    if ($myNombre[0] == "") {
        $myNombre[0] = getAzar($nombre);
        $myNombre[1] = getAzar($apellido);
        return $myNombre[0] ." ". $myNombre[1];
    }
    else {
        do {
            $nn = getAzar($nombre);
        }
        while ($nn == $myNombre[0]);
        switch ($preApellido) {
            case "tía":
            case "hermana":
            case "prima":
            case "sobrina":
            case "hija":
                $pp = $myNombre[1];
                break;
            default:
                do {
                    $pp = getAzar($apellido);
                }
                while ($pp == $myNombre[1]);
                break;
        }
        return $nn ." ". $pp;
    }
}

function getData() {
    return "♀️ de ". random_int(18, 30). " años"; 
}

function getFisico() {
    global $fisico;
    return random_int(155, 175) ." cm, ". getAzar($fisico);
}

function getExtra() {
    global $zodiaco, $lugar;
    return getAzar($zodiaco) ." de ". getAzar($lugar);
}

function getTrasfondo() {
    global $tras1, $tras2, $tras3;
    return "<ul>".
        "<li><u>Niñez:</u> " .getAzar($tras1). "</li><br>".
        "<li><u>Adolescencia:</u> " .getAzar($tras2). "</li><br>".
        "<li><u>Adultez:</u> " .getAzar($tras3). "</li>".
        "</ul>";
}

function getRasgos() {
    global $rasgos;
    shuffle($rasgos);
    return "<ul>".
        "<li>" .$rasgos[0]. "</li><br>".
        "<li>" .$rasgos[1]. "</li><br>".
        "<li>" .$rasgos[2]. "</li>".
        "</ul>";
}

function getHabilidades() {
    return "<ul>".
        "<li>Lucha " .getEstrellas(). "</li><br>".
        "<li>Social " .getEstrellas(). "</li><br>".
        "<li>Medicina " .getEstrellas(). "</li><br>".
        "<li>Cultivo " .getEstrellas(). "</li><br>".
        "<li>Manual " .getEstrellas(). "</li>".
        "</ul>";
}

function getEstrellas($total=5) {
    $estrellas = "";
    $level = min(random_int(0, $total),
        random_int(0, $total));
    for ($i = 0; $i < $level; $i++) {
        $estrellas .= "✭";
    }
    for ($i = $level; $i < $total; $i++) {
        $estrellas .= "✰";
    }
    return $estrellas;
}

function getRelaciones() {
    global $relacion;
    $dado = random_int(0, 100);
    if ($dado < 75) {
        shuffle($relacion);
        $nn = getNombe($relacion[0]);
        $res = "<ul><li><u>" .$relacion[0]. "</u>: " .$nn. "</li>";
        if ($dado < 50) {
            shuffle($relacion);
            $nn = getNombe($relacion[0]);
            $res .= "<br><li><u>" .$relacion[0]. "</u>: " .$nn. "</li>";
            if ($dado < 25) {
                shuffle($relacion);
                $nn = getNombe($relacion[0]);
                $res .= "<br><li><u>" .$relacion[0]. "</u>: " .$nn. "</li>";
            }
        }
        return $res ."</ul>";
    }
    return "Sin contactos";
}

function getSalud() {
    global $salud;
    shuffle($salud);
    $dado = random_int(0, 100);
    if ($dado < 75) {
        $res = "<ul><li>" .$salud[0]. "</li>";
        if ($dado < 50) {
            $res .= "<br><li>" .$salud[1]. "</li>";
            if ($dado < 25) {
                $res .= "<br><li>" .$salud[2]. "</li>";
            }
        }
        return $res ."</ul>";
    }
    return "Sin problemas";
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="perfil_azar.css">
        <title>Perfil</title>
    </head>
    <body>
    <div class="ficha">
        <h1>Perfil #<?php echo random_int(1, 1000); ?> 
            <button onclick="enviar()">Siguiente</button></h1>
        <p>superviviente #1 al accidente aéreo en la isla de Lesbos...</p>
    </div>
    <div class="big_vert">
        <div class="medio_hori">
            <!-- ficha, trasfondo -->
             <div class="ficha">
                <div class="ficha_vert">
                    <img src="perfil_azar.png"
                        alt="avatar del perfil" width="200" height="200">
                    <div class="ficha_items">
                        <h2><?php echo getNombe(); ?></h2>
                        <h4><?php echo getData(); ?></h4>
                        <h4><?php echo getExtra(); ?></h4>
                        <h4><?php echo getFisico(); ?></h4>
                    </div>
                </div>
            </div>
             <div class="ficha">
                <h3>Trasfondo:</h3>
                <p><?php echo getTrasfondo(); ?></p>
             </div>
        </div>
        <div class="medio_hori">
            <!-- habilidades, rasgos -->
            <div class="ficha">
                <h3>Habilidades:</h3>
                <p><?php echo getHabilidades(); ?></p>
             </div>
            <div class="ficha">
                <h3>Rasgos:</h3>
                <p><?php echo getRasgos(); ?></p>
             </div>
        </div>
        <div class="medio_hori">
            <!-- salud, relaciones -->
            <div class="ficha">
                <h3>Salud:</h3>
                <p><?php echo getSalud(); ?></p>
             </div>
            <div class="ficha">
                <h3>Relaciones:</h3>
                <p><?php echo getRelaciones(); ?></p>
             </div>
        </div>
    </div>
    <form class="ficha" id="envio" action="perfil_azar.php" method="post">
        <h3>Califica:</h3>
        <input type="radio" id="op1" name="opt" value="1">
        <label for="op1">Aceptada</label>
        <input type="radio" id="op2" name="opt" value="0" checked>
        <label for="op2">Rechazada</label><br>
        <input type="hidden" name="historial" value=
            "<?php echo $historial; ?>">
        <input type="hidden" name="ant_nombre" value=
            "<?php echo $myNombre[0] ." ". $myNombre[1]; ?>">
        <button action="submit">Enviar</button>
    </form>
    <div>
        <h3>Seleccionadas:</h3>
        <div class="cuadricula">
            <?php
                if (count($list_nombres) == 0) {
                    echo "<p>Aún no se ha seleccionado alguna</p>";
                }
                else {
                    foreach ($list_nombres as $lis) {
                        echo "<div class='ficha'><h3>$lis</h3></div>";
                    }
                }
            ?>
        </div>
    </div>
    <footer>
        <hr>
        <p>Creado por <a href="https://omwekiatl.itch.io/">Omwekiatl</a>
            , inspirado en <a href="https://store.steampowered.com/app/294100/RimWorld/">RimWorld</a></p>
    </footer>
    </body>

    <script>
        function enviar() {
            document.getElementById("op1").checked = false;
            document.getElementById("op2").checked = true;
            document.getElementById("envio").submit();
        }
    </script>
</html>
