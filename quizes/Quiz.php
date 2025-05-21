<?php
// creado por Omwekiatl 2025
class Quiz {

    // cantidad de preguntas de cada tipo de pregunta
    private $numTotal = 0;
    private $numRound = 0;
    private $numSquare = 0;
    private $numQuest = 0;
    private $numTexto = 0;
    private $numNumber = 0;

    public function setRound($qst) {
        // $qst = ["pregunta", "correcta", "falsa1", "falsa2", ..., "falsaN"];
        // hacer conteos globales
        $this -> numTotal += 1;
        $this -> numRound += 1;
        $t = $this -> numTotal;
        $r = $this -> numRound;
        // mostrar la pregunta con su numero indice
        echo "<label>P$t. " .$qst[0]. "</label><br>";
        // obtener el valor verdadero y crear un pool de indices a mezclar al azar
        $verdad = $qst[1];
        $ind = range(1, count($qst) - 1);
        shuffle($ind);
        // ciclo que crea las preguntas en orden
        for ($i = 0; $i < count($ind); $i++) {
            // crear el boton redondo con su configuracion y valor verdadero
            $id = "round$r" ."_$i";
            echo "<input type='radio' id='$id' name='round$r' required='true'";
            if ($verdad == $qst[$ind[$i]]) {
                echo " value='1'>";
            }
            else {
                echo " value='0'>";
            }
            // poner la pregunta al lado del boton redondo
            echo "<label for='$id'>" .$qst[$ind[$i]]. "</label><br>";
        }
        echo "<br>";
    }

    public function setSquare($qst) {
        // $qst = ["pregunta", "$resp1", "$resp2", ..., "$respN"];
        // donde $ es V o F por ejemplo: "Frespuesta"
        // hacer conteos globales
        $this -> numTotal += 1;
        $this -> numSquare += 1;
        $t = $this -> numTotal;
        $r = $this -> numSquare;
        $buenas = 0;
        // mostrar la pregunta con su numero indice
        echo "<label>P$t. " .$qst[0]. "</label><br>";
        // crear un pool de indices a mezclar al azar
        $ind = range(1, count($qst) - 1);
        shuffle($ind);
        // ciclo que crea las preguntas en orden
        for ($i = 0; $i < count($ind); $i++) {
            $id = "square$r" ."_$i";
            $bool = strtolower(substr($qst[$ind[$i]], 0, 1));
            $resp = substr($qst[$ind[$i]], 1, strlen($qst[$ind[$i]]) - 1);
            if ($bool == "v" || $bool == "t") {
                $buenas++;
                echo "<input type='checkbox' id='$id' name='$id' value='1'>";
            }
            else {
                echo "<input type='checkbox' id='$id' name='$id' value='0'>";
            }
            echo "<label for='$id'>" .$resp. "</label><br>";
        }
        echo "<br>";
        // agregar respuesta oculta para cantidad de cajas
        $tot = count($ind);
        echo "<input type='hidden' name='square$r' value='" .$tot. "'>";
        echo "<input type='hidden' name='squareres$r' value='" .$buenas. "'>";
    }

    public function setQuest($qst) {
        // $qst = ["pregunta", booleano];
        // hacer conteos globales
        $this -> numTotal += 1;
        $this -> numQuest += 1;
        $t = $this -> numTotal;
        $r = $this -> numQuest;
        // mostrar la pregunta con su numero indice
        echo "<label>P$t. " .$qst[0]. "</label><br>";
        // colocar las dos opciones V/F segun el booleano dado
        echo "<select name='quest$r'>";
        echo "<option value='0'>...</option>";
        if ($qst[1]) {
            echo "<option value='1'>Verdadero</option>";
            echo "<option value='0'>Falso</option>";
        }
        else {
            echo "<option value='0'>Verdadero</option>";
            echo "<option value='1'>Falso</option>";
        }
        echo "</select><br><br>";
    }

    public function setTexto($qst) {
        // $qst = ["pregunta", "resp1", "resp2", ..., "respN"];
        // No distingue mayusculas de minusculas, Ni tildes, ej: Mamá = mama
        // hacer conteos globales
        $this -> numTotal += 1;
        $this -> numTexto += 1;
        $t = $this -> numTotal;
        $r = $this -> numTexto;
        // mostrar la pregunta con su numero indice
        echo "<label>P$t. " .$qst[0]. "</label><br>";
        // mostrar cuadro de escritura
        echo "<input type='text' name='texto$r' required='true'><br><br>";
        // agregar respuesta oculta para las respuestas correctas
        echo "<input type='hidden' name='textores$r' value='"
            .$this -> strLis($qst[1]);
        for ($i = 2; $i < count($qst); $i++) {
            echo "|" .$this -> strLis($qst[$i]);
        }
        echo "'>";
    }

    public function setNumber($qst) {
        // $qst = ["pregunta", numeroRespuesta];
        // hacer conteos globales
        $this -> numTotal += 1;
        $this -> numNumber += 1;
        $t = $this -> numTotal;
        $r = $this -> numNumber;
        // mostrar la pregunta con su numero indice
        echo "<label>P$t. " .$qst[0]. "</label><br>";
        // mostrar cuadro de escritura
        echo "<input type='number' name='number$r' required='true'><br><br>";
        // agregar respuesta oculta para la respuesta correcta
        $res = $qst[1];
        echo "<input type='hidden' name='numberres$r' value='$res'";
    }

    public function setCounters() {
        // esto debe ponerse siempre en el forms, llamarlo una vez
        echo "<input type='hidden' name='isResponse' value='1'>";
        echo "<input type='hidden' name='numRound' value='" .$this -> numRound. "'>";
        echo "<input type='hidden' name='numSquare' value='" .$this -> numSquare. "'>";
        echo "<input type='hidden' name='numQuest' value='" .$this -> numQuest. "'>";
        echo "<input type='hidden' name='numTexto' value='" .$this -> numTexto. "'>";
        echo "<input type='hidden' name='numNumber' value='" .$this -> numNumber. "'>";
    }

    public function getResponse() {
        return isset($_POST['isResponse']);
    }

    public function getNota() {
        // obtener la cantidad de preguntas de cada tipo
        $numRound = isset($_POST['numRound']) ? $_POST['numRound'] : 0;
        $numSquare = isset($_POST['numSquare']) ? $_POST['numSquare'] : 0;
        $numQuest = isset($_POST['numQuest']) ? $_POST['numQuest'] : 0;
        $numTexto = isset($_POST['numTexto']) ? $_POST['numTexto'] : 0;
        $numNumber = isset($_POST['numNumber']) ? $_POST['numNumber'] : 0;
        $numTotal = $numRound + $numSquare + $numQuest + $numTexto + $numNumber;
        $suma = 0;
        // agregar los puntajes del tipo round
        for ($i = 1; $i <= $numRound; $i++) {
            $suma += $_POST["round" .$i];
        }
        // agregar los puntajes del tipo square
        for ($i = 1; $i <= $numSquare; $i++) {
            $tot = $_POST['square' .$i];
            $buenas = $_POST['squareres' .$i];
            for ($r = 0; $r < $tot; $r++) {
                if (isset($_POST['square' .$i. '_' .$r])) {
                    $suma += 1 / max(1, $buenas);
                }
            }
        }
        // agregar los puntajes del tipo quest
        for ($i = 1; $i <= $numQuest; $i++) {
            $suma += $_POST["quest" .$i];
        }
        // agregar los puntajes del tipo texto, si lo digitado esta en las respuestas
        for ($i = 1; $i <= $numTexto; $i++) {
            $txt = $this -> strLis($_POST['texto' .$i]);
            $res = explode("|", $_POST['textores' .$i]);
            if (in_array($txt, $res)) {
                $suma += 1;
            }
        }
        // agregar los puntajes del tipo number, si coinciden los valores
        for ($i = 1; $i <= $numNumber; $i++) {
            $txt = $_POST['number' .$i];
            $res = $_POST['numberres' .$i];
            if ($txt == $res) {
                $suma += 1;
            }
        }
        // dar resultado promediando y escalando a nota de 5.0
        return round(($suma / max(1, $numTotal)) * 50) / 10;
    }

    public function setPregunta($qstplus) {
        // $qstplus = [$ind, $qst];
        // donde $ind puede ser "R" "S" "Q" "T" "N" segun tipo de pregunta
        // y luego $qst es el array con los datos de la pregunta como tal
        switch (strtolower($qstplus[0])) {
            case "r":
                $this -> setRound($qstplus[1]);
                break;
            case "s":
                $this -> setSquare($qstplus[1]);
                break;
            case "q":
                $this -> setQuest($qstplus[1]);
                break;
            case "t":
                $this -> setTexto($qstplus[1]);
                break;
            case "n":
                $this -> setNumber($qstplus[1]);
                break;
        }
    }

    public function setEvaluacion($data, $limit=0) {
        // $data = [$qstplus1, $qstplus2, ..., $qstplusN];
        // $qstplus = [$ind, $qst];
        // $data = [[$ind1, $qst1], [$ind2, $qst2], ..., [$indN, $qstN]];
        // donde $ind puede ser "R" "S" "Q" "T" "N" segun tipo de pregunta
        // y luego $qst es el array con los datos de la pregunta como tal
        // $limit hace que se muestren unas cuantas preguntas, o todas si 0
        shuffle($data);
        for ($i = 0; $i < count($data); $i++) {
            $qstplus = $data[$i];
            $this -> setPregunta($qstplus);
            if ($limit > 0 && $limit <= $this -> numTotal) {
                break;
            }
        }
    }

    private function strLis($txt) {
        // elimina acentos, espacios, | y saltos de linea, devuelve minusculas
        $txt = str_replace("Á", "a", str_replace("á", "a", $txt));
        $txt = str_replace("É", "e", str_replace("é", "e", $txt));
        $txt = str_replace("Í", "i", str_replace("í", "i", $txt));
        $txt = str_replace("Ó", "o", str_replace("ó", "o", $txt));
        $txt = str_replace("Ú", "u", str_replace("ú", "u", $txt));
        $txt = str_replace("Ü", "u", str_replace("ü", "u", $txt));
        $txt = str_replace("Ñ", "ñ", str_replace(" ", "_", $txt));
        $txt = str_replace("|", "", str_replace("\n", "", $txt));
        return strtolower($txt);
    }
}
?>
