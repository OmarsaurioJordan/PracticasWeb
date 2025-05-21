<?php
/*
    Basicos:
- nombre, genero, edad, zodiaco
- estudios y carrera o rol en la comunidad, trabajo
- que busca (amistad, pareja) o tipo de relacion (casual)
    Textos:
- frase o cita
- descripcion...
- link opcional
    Intereses:
- intereses (que quiere hacer)
- hobbies (que hace)
- disgustos (que no soporta)
    Físico:
- estatura, complexion, piel, pelo, moda
    Personalidad:
- psicologia (cinco tipos)
- tribu urbana
    Vida:
- tiene o quiere hijos
- fuma o bebe o droga
- habitos de ejercicio
- religión y política
*/

/*
    Basicos:
- estudios y carrera o rol en la comunidad, trabajo
- que busca (amistad, pareja) o tipo de relacion (casual)
*/

function setRadio($name, $value, $text) {
    $id = $name ."_". $value;
    echo "<input type='radio' name='$name' id='$id' value='$value' required>";
    echo "<label for='$id'> $text</label>";
}

function setCheck($name, $value, $text) {
    echo "<input type='checkbox' name='$name' id='$name' value='$value'>";
    echo "<label for='$name'> $text</label>";
}

function setOption($name, $list) {
    echo "<select name='$name' required>";
    for ($i = 0; $i < count($list); $i++) {
        $item = $list[$i];
        echo "<option value='$i'>$item</option>";
    }
    echo "</select>";
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <link rel="stylesheet" href="styles.css"> -->
        <title>Perfil</title>
    </head>
    <body>
        <h1>Editar Perfil</h1>

        <form action="Perfil.php" method="POST" autocomplete="off">
        
            <fieldset>
                <legend><h2>Datos Básicos</h2></legend>
                <!-- nombre, genero, edad, zodiaco -->

                <label>🏷️ Nombre:</label><br>
                <input type="text" name="nombre" maxlength="24" required><br><br>

                <label>Genero:</label><br>
                <?php setRadio("genero", "M", "🚺 Mujer");
                    setRadio("genero", "H", "🚹 Hombre");
                    setRadio("genero", "T", "🚻 No-Binario"); ?><br><br>
                
                <label>📆 Año de Nacimiento:</label><br>
                <input type="number" name="edad" min="1900" max="<?php echo date("Y"); ?>"
                    step="1" value="<?php echo date("Y") - 18; ?>" required><br><br>
                
                <label>Signo del Zodiaco:</label><br>
                <?php setOption("zodiaco", [
                    "♈ Aries", "♉ Tauro", "♊ Géminis", "♋ Cáncer",
                    "♌ Leo", "♍ Virgo", "♎ Libra", "♏ Scorpio",
                    "♐ Sagitario","♑ Capricornio", "♒ Acuario", "♓ Piscis"]); ?>
            </fieldset>

            <fieldset>
                <legend><h2>Personalidad</h2></legend>
                <!-- apertura, escrupulosidad, extraversion, amabilidad, neuroticismo -->
                
                <label>Apertura a la Experiencia:</label><br>
                <label><i>capacidad de cambio, creatividad o explorar nuevos lugares</i></label><br>
                <?php setRadio("apertura", "1", "🏠 Cauteloso/a");
                    setRadio("apertura", "2", "👤 Neutro/a");
                    setRadio("apertura", "3", "🏕️ Curioso/a"); ?><br><br>
                
                <label>Escrupulosidad u Órden:</label><br>
                <label><i>conciencia puesta en las metas o responsabilidades</i></label><br>
                <?php setRadio("escrupulosidad", "1", "🎲 Despreocupado/a");
                    setRadio("escrupulosidad", "2", "👤 Neutro/a");
                    setRadio("escrupulosidad", "3", "📐 Disciplinado/a"); ?><br><br>

                <label>Extraversión o Sociabilidad:</label><br>
                <label><i>energía enfocada en interactuar con otros y divertirlos/se</i></label><br>
                <?php setRadio("extraversion", "1", "🐱 Introvertido/a");
                    setRadio("extraversion", "2", "👤 Neutro/a");
                    setRadio("extraversion", "3", "🐶 Extrovertido/a"); ?><br><br>

                <label>Amabilidad o Agradabilidad:</label><br>
                <label><i>el egoísmo o pragmátismo versus la compasión y cooperación</i></label><br>
                <?php setRadio("amabilidad", "1", "🔪 Insensible");
                    setRadio("amabilidad", "2", "👤 Neutro/a");
                    setRadio("amabilidad", "3", "🤍 Empático/a"); ?><br><br>

                <label>Neuroticismo o Volatibilidad:</label><br>
                <label><i>inteligencia emocional para afrontar situaciónes difíciles</i></label><br>
                <?php setRadio("neuroticismo", "1", "💥 Inestable");
                    setRadio("neuroticismo", "2", "👤 Neutro/a");
                    setRadio("neuroticismo", "3", "🌱 Sereno/a"); ?>
            </fieldset>

            <fieldset>
                <legend><h2>Estilo de Vida</h2></legend>
                <!-- tribu, hijos, fuma, bebe, droga, ejercicio, religion, politica -->

                <label>Tribu o Grupo Social:</label><br>
                <?php setOption("tribu", [
                    "🍺 Fiestero: baile, bebidas, reuniónes sociales",
                    "🍃 Hippie: ama la vida sencilla y en la naturaleza",
                    "🎮 Gamer: adora pasar tiempo jugando videojuegos",
                    "🙏 Religioso: vive para la adoración e iglesia",
                    "✈️ Aventurero: anda en viajes, paseos y excursiónes",
                    "🏀 Deportista: con sudadera siempre, juega o ejercita",
                    "💡 Artista: escribe, dibuja, interpreta, crea contenido",
                    "🔪 Lacra: drogas, pandillas, mafia y deseo de poder",
                    "🦇 Darks: la vida es una melancolía, básicamente sobrevive",
                    "📚 Estudioso: come libros, nerd, siempre aprendiendo",
                    "👥 Comunitario: en eventos sociales, políticos, culturales",
                    "🕰️ Trabajador: lo laboral no le deja tiempo para nada",
                    "💰 Emprendedor: negociante, quiere montar su empresa"]); ?>
            </fieldset>

            <fieldset>
                <legend><h2>Físico</h2></legend>
                <!-- estatura, complexion, piel, pelo, moda -->

                <label>Estatura:</label><br>
                <?php setOption("estatura", [
                    "🐛 Enano/a", "🐁 Bajo/a", "🐵 Medio/a",
                    "🐎 Alto/a", "🦒 Giante"]) ?><br><br>
                
                <label>Complexión:</label><br>
                <?php setOption("complexion", [
                    "🦎 Flaco/a", "🐆 Atlético/a", "🐵 Normal",
                    "🦍 Musculoso/a", "🐖 Grueso/a", "🐘 Gordo/a"]) ?><br><br>
                
                <label>Tono de Piel:</label><br>
                <?php setOption("piel", [
                    "🤍 Blanco/a", "💛 Latino/a", "🧡 Mestizo/a",
                    "❤️ Indio/a", "🤎 Moreno/a", "🖤 Negro/a"]) ?><br><br>
                
                <label>Tipo de Pelo:</label><br>
                <?php setOption("pelo", [
                    "💀 Calvo/a", "🪒 Corto", "✂️ Medio", "🧵 Largo",
                    "🥻 Larguísimo", "🥦 Afro", "⛓️ Trenzas", "🌸 Exótico"]) ?><br><br>
                
                <label>Estilo o Moda:</label><br>
                <?php setOption("moda", [
                    "👕 Normal", "🎽 Deportiva", "🗑️ Grunge", "👟 Callejera", "👘 Ideológica",
                    "🦶 Hippie", "👓 Hippster", "✨ Glamour", "🎩 Formal", "🕴️ Darks"]) ?>
            </fieldset>

            <fieldset>
                <legend><h2>Intereses y Gustos</h2></legend>
                <!-- intereses, hobbies, disgustos -->

            </fieldset>

            <fieldset>
                <legend><h2>Auto Expresón</h2></legend>
                <!-- frase, descripcion, link -->

                <label>💬 Frase o Cita:</label><br>
                <textarea name="frase" rows="3" cols="30"
                    maxlength="150"></textarea><br><br>

                <label>📝 Descripción:</label><br>
                <textarea name="descripcion" rows="12" cols="30"
                    maxlength="900"></textarea><br><br>

                <label>🌐 Link a Redes Sociales:</label><br>
                <input type="url" name="link" maxlength="150"><br><br>
                    
                <label>🎼 Link a Canción Youtube:</label><br>
                <input type="url" name="musica" maxlength="150">
            </fieldset>

            <br><button type="submit"><h3>✅ Guardar</h3></button>
        </form>
    </body>
</html>
