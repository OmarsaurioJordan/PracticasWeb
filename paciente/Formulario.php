<?php // jujuju ?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>CitasMed</title>
    </head>
    <body>
        <h2>Registro de Citas Médicas</h2>
        <h3>por Omar Jordan ADSO24</h3>
        <h3><a href="Listado.php">Ver Pacientes</a></h3>
        <form action="Logica.php" method="GET">
            
            <label>Digite su Cédula</label><br>
            <input type="number" name="identificacion" required="true"><br><br>

            <label>Escriba su Nombre</label><br>
            <input type="text" name="nombre" required="true"><br><br>

            <label>Ingrese su Fecha de Nacimiento</label><br>
            <input type="date" name="fechaNacimiento" required="true"><br><br>

            <label>Elija su Género</label><br>
            <select name="genero" required="true">
                <option value="M">Mujer</option>
                <option value="H">Hombre</option>
            </select><br><br>

            <label>Digite su Teléfono</label><br>
            <input type="number" name="telefono" required="true"><br><br>

            <label>Elija su Estrato Social</label><br>
            <select name="estratoSocial" required="true">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
            </select><br><br>

            <label>Elija el Tipo de Cita</label><br>
            <select name="tipo" required="true">
                <option value="0">General</option>
                <option value="1">Odontológica</option>
                <option value="2">Psicológica</option>
            </select><br><br>

            <button type="submit">Enviar</button>
        </form>
    </body>
</html>
