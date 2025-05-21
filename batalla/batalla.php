<?php
    // creado por Omwekiatl 2025
    /*
    TAREAS:
    - ralentizar envio formularios actualizando timestamp
    - perdida con notificacion
    - limpieza de antiguos actualizando timestamp
    - poner ciclos de ciudad al lado del nombre
    - hay fallo al pulsar en un boton de accion y no hay enemigos
    - poner temporizador para resetear todos y guardar ultimo ganador
    */

    // datos de conexion al servidor DB
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $dbname = 'minijuegos';

    // conexion con el servidor
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
        echo "<h2>Error de conexión a la base de datos</h2>";
        exit();
    }

    // obtencion de variables del ciclo anterior
    $accion = isset($_POST['accion']) ? $_POST['accion'] : "";
    $yopo = isset($_POST['yopo']) ? $_POST['yopo'] : -1;
    $ally = isset($_POST['ally']) ? $_POST['ally'] : -1;
    $enemy = isset($_POST['enemy']) ? $_POST['enemy'] : -1;
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";

    // variables de funcionamiento interno
    $reboot = false;
    $duplicado = false;
    $peso = 5; // multiplo para sumas y restas de items

    // obtencion de la informacion de la partida, tabla de jugadores
    $stmt = $pdo -> prepare("SELECT id, name, people, soldiers, food FROM batalla
        ORDER BY people + soldiers DESC");
    $stmt -> execute([]);
    $cabecera = "";
    $tabla = "";
    $allies = "";
    $enemies = "";
    // ciclo que lee todas las filas y adecua estructuras html
    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        // la cabecera pone al jugador actual siempre de primero
        if ($row['id'] == $yopo) {
            $cabecera = "<tr>";
            $cabecera .= "<td>✅ " .$row['name']. "</td>";
            $cabecera .= "<td>" .$row['people']. "</td>";
            $cabecera .= "<td>" .$row['soldiers']. "</td>";
            $cabecera .= "<td>" .$row['food']. "</td>";
            $cabecera .= "</tr>";
        }
        // luego se colocan el resto de jugadores en la tabla
        else {
            $tabla .= "<tr>";
            $tabla .= "<td>" .$row['name']. "</td>";
            $tabla .= "<td>" .$row['people']. "</td>";
            $tabla .= "<td>" .$row['soldiers']. "</td>";
            $tabla .= "<td>" .$row['food']. "</td>";
            $tabla .= "</tr>";
        }
        // cuando no es el jugador principal, obtener listado para selectores
        if ($row['id'] != $yopo) {
            // selector de aliado, tener en mira al mismo del ciclo anterior
            if ($row['id'] == $ally) {
                $allies .= "<option value=" .$row['id']. " selected>"
                    .$row['name']. "</option>";
            }
            else {
                $allies .= "<option value=" .$row['id'].
                    ">" .$row['name']. "</option>";
            }
            // selector de enemigo, tener en mira al mismo del ciclo anterior
            if ($row['id'] == $enemy) {
                $enemies .= "<option value=" .$row['id']. " selected>"
                    .$row['name']. "</option>";
            }
            else {
                $enemies .= "<option value=" .$row['id'].
                    ">" .$row['name']. "</option>";
            }
        }
    }
    $tabla = $cabecera . $tabla;

    // obtencion de la informacion de notificaciones
    $stmt = $pdo -> prepare("SELECT a.msj AS msj,
        bs.name AS send, br.name AS recv
        FROM acciones a
        JOIN batalla bs ON a.send = bs.id
        JOIN batalla br ON a.recv = br.id
        ORDER BY a.momento DESC");
    $stmt -> execute([]);
    $noticias = "<ul>";
    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        $t = "❓ ...";
        $f = "❓ ";
        switch ($row['msj']) {
            case "Ap": // apoyar
                $t = "🏃‍♂️ apoyó";
                $f = "🏳️ ";
                break;
            case "De": // defender
                $t = "🛡️ defendió";
                $f = "🏳️ ";
                break;
            case "Al": // alimentar
                $t = "🌽 alimentó";
                $f = "🏳️ ";
                break;
            case "In": // invadir
                $t = "👥 invadió";
                $f = "🏴 ";
                break;
            case "At": // atacar
                $t = "🗡️ atacó";
                $f = "🏴 ";
                break;
            case "As": // asediar
                $t = "💣 asedió";
                $f = "🏴 ";
                break;
        }
        $noticias .= "<li>$f" .$row['send']. " a " .$row['recv']. " $t</li>";
    }
    $noticias .= "</ul>";

    // cuando no hay un jugador activo
    if ($yopo == -1) {
        if ($nombre != "") {
            // verifica si existe un jugador con el nuevo nombre
            $nombre = NombreOk($nombre, 12);
            $stmt = $pdo -> prepare("SELECT id FROM batalla WHERE name=?");
            $stmt -> execute([$nombre]);
            if ($stmt -> rowCount() > 0) {
                // si existe entonces advertir que no pudo ser creado
                $duplicado = true;
            }
            else {
                // insertar nuevo jugador a la tabla
                $stmt = $pdo -> prepare("INSERT INTO batalla (name,
                    people, food) VALUES (?, 5, 10)");
                $stmt -> execute([$nombre]);
                // obtener el id asociado al nuevo insertado
                $stmt = $pdo -> prepare("SELECT id FROM batalla WHERE name=?");
                $stmt -> execute([$nombre]);
                while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
                    // obtener el id para recargar la pagina, inicio sesion
                    $yopo = $row['id'];
                    $reboot = true;
                    break;
                }
            }
        }
    }
    // pero si si hay jugador activo, procede a ejecutar las ordenes
    else if ($accion != "") {
        switch ($accion) {
            case "Co": // procrear
                Transmutar("food", "people");
                break;
            case "Bl": // adiestrar
                Transmutar("people", "soldiers");
                break;
            case "Cu": // cultivar
                $stmt = $pdo -> prepare("UPDATE batalla SET
                    food = food + $peso * 2 WHERE id=?");
                $stmt -> execute([$yopo]);
                $reboot = true;
                break;
            case "Ap": // apoyar
                Intercambio("people", $ally);
                Notificacion($ally, $accion);
                break;
            case "De": // defender
                Intercambio("soldiers", $ally);
                Notificacion($ally, $accion);
                break;
            case "Al": // alimentar
                Intercambio("food", $ally);
                Notificacion($ally, $accion);
                break;
            case "In": // invadir
                Golpiza("people", 1.5, $enemy);
                Notificacion($enemy, $accion);
                break;
            case "At": // atacar
                Golpiza("soldiers", 1, $enemy);
                Notificacion($enemy, $accion);
                break;
            case "As": // asediar
                Golpiza("food", 2, $enemy);
                Notificacion($enemy, $accion);
                break;    
        }
    }

    function Transmutar($item1, $item2) {
        global $stmt, $pdo, $reboot, $yopo, $peso;
        $stmt = $pdo -> prepare("SELECT $item1 FROM batalla WHERE id=?");
        $stmt -> execute([$yopo]);
        while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
            $c = min($row[$item1], $peso);
            if ($c > 0) {
                $stmt = $pdo -> prepare("UPDATE batalla SET
                    $item2 = $item2 + $c,
                    $item1 = $item1 - $c
                    WHERE id=?");
                $stmt -> execute([$yopo]);
                $reboot = true;
            }
            break;
        }
    }

    function Intercambio($item, $quien) {
        global $stmt, $pdo, $reboot, $yopo, $peso;
        $stmt = $pdo -> prepare("SELECT $item FROM batalla WHERE id=?");
        $stmt -> execute([$yopo]);
        while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
            $c = min(max(0, $row[$item] - $peso), $peso);
            if ($c > 0) {
                $stmt = $pdo -> prepare("UPDATE batalla SET
                    $item = CASE
                    WHEN id=? THEN $item - $c
                    WHEN id=? THEN $item + $c
                    ELSE $item
                    END WHERE id IN (?, ?)");
                $stmt -> execute([$yopo, $quien, $yopo, $quien]);
                $reboot = true;
            }
            break;
        }
    }

    function Golpiza($item, $plus, $quien) {
        global $stmt, $pdo, $reboot, $yopo, $peso;
        $stmt = $pdo -> prepare("SELECT id, people, soldiers, food
            FROM batalla WHERE id IN (?, ?)");
        $stmt -> execute([$yopo, $quien]);
        $soldiers = 0;
        $otros = 0;
        while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
            if ($row['id'] == $yopo) {
                $soldiers = min($row['soldiers'], $peso);
            }
            else {
                $otros = $row[$item];
            }
        }
        $fuerza = min($soldiers * $plus, $otros);
        if ($fuerza > 0) {
            $soldiers = ceil($fuerza / $plus);
            $stmt = $pdo -> prepare("UPDATE batalla SET
                soldiers = CASE
                WHEN id=? THEN soldiers - ? ELSE soldiers END,
                $item = CASE
                WHEN id=? THEN $item - ? ELSE $item END
                WHERE id IN (?, ?)");
            $stmt -> execute([$yopo, $soldiers, $quien, $fuerza, $yopo, $quien]);
            $reboot = true;
        }
    }

    function Notificacion($recv, $msj) {
        global $stmt, $pdo, $reboot, $yopo;
        if ($reboot) {
            $stmt = $pdo -> prepare("INSERT INTO acciones (send, recv, msj)
                VALUES (?, ?, ?)");
            $stmt -> execute([$yopo, $recv, $msj]);
        }
    }

    function NombreOk($txt, $limit) {
        // adecua un texto para que no contenga caracteres extrannos
        $txt = str_replace("Á", "A", str_replace("á", "a", $txt));
        $txt = str_replace("É", "E", str_replace("é", "e", $txt));
        $txt = str_replace("Í", "I", str_replace("í", "i", $txt));
        $txt = str_replace("Ó", "O", str_replace("ó", "o", $txt));
        $txt = str_replace("Ú", "U", str_replace("ú", "u", $txt));
        $txt = str_replace("Ñ", "N", str_replace("ñ", "n", $txt));
        $txt = str_replace(" ", "", str_replace("\n", "", $txt));
        $t = "";
        for ($i = 0; $i < strlen($txt); $i++) {
            $c = $txt[$i];
            $m = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890_";
            if (strpos($m, $c) !== false) {
                $t .= $c;
            }
        }
        return substr($t, 0, $limit);
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="batalla.css">
        <title>Batalla</title>
    </head>
    <body>
    <div class="left-section">
    
    <!-- titulo y creditos -->
    <h2>⚔️ BATALLA 🦎 Omwekiatl 🕰️ 2025</h2>

    <!-- formulario para crear al nuevo jugador -->
    <?php
        if ($yopo == -1) {
            echo "<form action='batalla.php' method='POST'>";
            echo "<label>Invente un nombre ✏️</label>";
            echo "<input type='text' class='caja' name='nombre' required=true>";
            echo "<button type='submit'>Crear Tribu 🏷️</button>";
            echo "</form>";
        }
    ?>

    <!-- botones de acciones locales -->
    <p><div class="button-group">
        <button type="button" id="b1" onclick="Accion('Co')">Procrear 🏠 +5 👤 -5 🌽</button>
        <button type="button" id="b2" onclick="Accion('Bl')">Adiestrar 🏛️ +5 🗡️ -5 👤</button>
        <button type="button" id="b3" onclick="Accion('Cu')">Cultivar 🏕️ +10 🌽</button>
    </div></p>

    <!-- botones de accion de envios a aliados -->
    <p><div>
        <label for="ally">Aliado 🏳️</label>
        <select id="ally" name="ally">
            <?php echo $allies; ?>
        </select>
        <button type="button" id="b4" onclick="Accion('Ap')">Apoyar 🏃‍♂️</button>
        <button type="button" id="b5" onclick="Accion('De')">Defender 🛡️</button>
        <button type="button" id="b6" onclick="Accion('Al')">Alimentar 🌽</button>
    </div></p>

    <!-- botones de accion de envios a enemigos -->
    <p><div>
        <label for="enemy">Enemigo 🏴</label>
        <select id="enemy" name="enemy">
            <?php echo $enemies; ?>
        </select>
        <button type="button" id="b7" onclick="Accion('In')">Invadir 👥</button>
        <button type="button" id="b8" onclick="Accion('At')">Atacar 🗡️</button>
        <button type="button" id="b9" onclick="Accion('As')">Asediar 💣</button>
    </div></p>

    <!-- tabla de estado del juego -->
    <table>
        <tr>
            <th>🏷️ Tribus</th>
            <th>👤 Gente</th>
            <th>🗡️ Soldados</th>
            <th>🌽 Comida</th>
        </tr>
        <?php echo $tabla; ?>
    </table>
    </div>

    <!-- listado de acontecimientos -->
    <div class="right-section">
    <h2>✉️ Sucesos:</h2>
    <?php echo $noticias; ?>
    </div>

    <!-- formulario oculto para mantener el estado de variables -->
    <form action="batalla.php" method='POST' id="forMaster">
        <input type="hidden" id="f_accion" name="accion" value="">
        <input type="hidden" id="f_ally" name="ally" value="">
        <input type="hidden" id="f_enemy" name="enemy" value="">
        <input type="hidden" id="f_yopo" name="yopo" value="">
    </form>

    <!-- codigos locos locos -->
    <script>

        // ejecutar todas las acciones de los botones
        function Accion(accion) {
            const yopo = "<?php echo $yopo; ?>";
            const ally = document.getElementById('ally').value;
            const enemy = document.getElementById('enemy').value;
            Send(accion, yopo, ally, enemy);
        }

        // envia por post todos los datos basicos del software
        function Send(accion, yopo, ally, enemy) {
            document.getElementById('f_accion').value = accion;
            document.getElementById('f_ally').value = ally;
            document.getElementById('f_enemy').value = enemy;
            document.getElementById('f_yopo').value = yopo;
            document.getElementById('forMaster').submit();s
        }

        // al iniciar la pagina...
        document.addEventListener("DOMContentLoaded", function() {
            
            // verificar si hay un jugador activo
            const yopo = "<?php echo $yopo; ?>";
            if (yopo == -1) {
                //desactivar botones si no hay jugador activo
                for (let i = 1; i <= 9; i++) {
                    const btn = document.getElementById('b' + i);
                    btn.disabled = true;
                    btn.style.opacity = "0.5";
                    btn.style.cursor = "not-allowed";
                }
                // notificar que ya hay un usuario con el nombre digitado
                if ("<?php echo $duplicado; ?>") {
                    alert("El nombre ya existe en la partida");
                }
            }

            // recargar pagina cuando se crea un jugador nuevo o hay acciones
            if ("<?php echo $reboot; ?>") {
                const ally = "<?php echo $ally; ?>";
                const enemy = "<?php echo $enemy; ?>";
                Send("", yopo, ally, enemy);
            }
        });
    </script>
    </body>
</html>
