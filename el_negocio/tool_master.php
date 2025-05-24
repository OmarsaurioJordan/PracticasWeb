<?php
    session_start();

    $msj = showMsj(isset($_GET['msj']) ? $_GET['msj'] : "");
    echo "<input type='hidden' id='msj' value='$msj'>";

    function showMsj($msj) {
        switch ($msj) {
            case "registrado": // OK
                return "✅ Se ha registrado con éxito!!!";
            case "error_db":
                return "⛔ Falló el acceso a la DB!!!";
            case "mal_login": // OK
                return "⛔ El e-mail o la clave son incorrectos!!!";
            case "existe_mail": // OK
                return "⛔ Posiblemente el e-mail esté ya en el sistema!!!";
            case "mal_estado": // OK
                return "⛔ Este usuario ha sido inhabilitado!!!";
            case "void": // OK
                return "⛔ No se obtuvieron datos!!!";
        }
        return "";
    }

    function meterlo() {
        if (isset($_SESSION['user'])) {
            header("Location:menu.php");
        }
    }

    function sacarlo() {
        if (!isset($_SESSION['user'])) {
            header("Location:index.php");
        }
    }

    function salir() {
        session_unset();
        header("Location:index.php");
    }

    function setHead() {
        ?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>El Negocio</title>
        <link rel="stylesheet" href="style.css">
        <?php
    }

    function setSesion($roles) {
        ?>
        <div class="headpro">
            <div>
                <label>🌐 El Negocio</label>
            </div>
            <div>
                <label><?php echo $_SESSION['nombre']. " (".
                    $roles[$_SESSION['rol'] - 1]. ")" ?></label>
                <a href="logic_salir.php">
                    <button>Salir</button>
                </a>
            </div>
        </div>
        <?php
    }
?>
