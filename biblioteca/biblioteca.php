<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="biblioteca.css">
        <title>Biblioteca</title>
    </head>
    <body>
        
        <div class="bloque">
            <h3>Usuario</h3>
            <input type="text" id="nombre" placeholder="Nombre">
            <input type="mail" id="correo" placeholder="Correo">
            <input type="password" id="password" placeholder="Contraseña">
            <div>
                <input type="checkbox" id="admin" value="">
                <label for="admin">Administrador</label>
            </div>
            <button onclick="newUsuario()">Crear Usuario</button>
        </div>

        <div class="bloque">
            <h3>Libro</h3>
            <input type="text" id="titulo" placeholder="Título">
            <input type="text" id="autor" placeholder="Autor">
            <select id="categoria"></select>
            <button onclick="newLibro()">Crear Libro</button>
        </div>

        <script src="biblioteca.js" type="text/javascript" defer>
            let biblioteca = new Biblioteca();
            
            // inicializar
            let optns = biblioteca.CATEGORIAS;
            let select = document.getElementById("categoria");
            for (let op = 0; op < optns.length; op++) {
                let opti = document.createElement("option");
                opti.value = op;
                opti.textContent = optns[op];
                select.appendChild(opti);
            }

            function newUsuario() {
                alert("Clikkkkk");
            }

            function newLibro() {
                alert("Clikkkkk");
            }

        </script>
    </body>
</html>
