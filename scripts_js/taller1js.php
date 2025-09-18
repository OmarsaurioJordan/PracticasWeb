<!-- Tareilla de JS para el SENA by Omwekiatl 2025 -->
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JS Práctica</title>
    <style>
        body {
            background-color: black;
            color: white;
            text-align: center;
            display:flex;
            flex-direction: column;
            margin: 0;
        }
        table {
            border-collapse: collapse;
            margin: 0 auto; 
        }
        table, th, td {
            border: 1px solid white;
        }
        th, td {
            padding: 12px;
        }
        main {
            flex: 1;
        }
        .msj {
            color: yellow;
        }
        button:hover {
            background-color: yellow;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <h1>JS Práctica</h1>
    </header>
    <main>
        <div>
            <h2>Registro</h2>
            <div>
                <label id="timer">0</label><br><br>
                <input id="nombre" name="nombre" type="text" placeholder="Nombre"><br><br>
                <input id="generoM" name="genero" type="radio" value="M" checked>
                <label for="generoM">M</label>
                <input id="generoF" name="genero" type="radio" value="F">
                <label for="generoF">F</label><br><br>
                <input id="edad" name="edad" type="number" placeholder="Año nacimiento" min="1900">
                <label id="adultez"></label><br><br>
                <select id="nacion" name="nacion">
                    <option value="CO" selected>Colombian</option>
                    <option value="VE">Venezolan</option>
                    <option value="MX">Mexican</option>
                    <option value="X">Otra</option>
                </select><br><br>
                <input id="saldo" name="saldo" type="number" placeholder="$ Saldo" step="1000"><br><br>
                <textarea id="descripcion" rows="3" cols="50" placeholder="Descripción"></textarea><br>
                <label id="descri_info">0 chars</label><br><br>
                <button onclick="procesar()">Registrar</button><br><br>
                <div class="msj" id="msj1"></div>
            </div>
        </div>
        <div>
            <h2>Estadísticas</h2>
            <div>
                <table>
                    <tr>
                        <th>Votación</th>
                        <th>Banco</th>
                        <th>Balance</th>
                        <th>Promedios</th>
                    </tr>
                    <tr>
                        <td>
                            <p>Registrados: </p><p id="std_registrados">0</p>
                            <p>Votantes: </p><p id="std_votantes">0</p>
                            <p>Porcentaje: </p><p id="std_porcentaje">0 %</p>
                        </td>
                        <td>
                            <p>Ganantes: </p><p id="std_ganantes">0</p>
                            <p>Endeudados: </p><p id="std_endeudados">0</p>
                            <p>Vacíos: </p><p id="std_vacios">0</p>
                            <p>Total: </p><p id="std_total">0</p>
                        </td>
                        <td>
                            <p>Máximo: </p><p id="std_maximo">???</p>
                            <p>Promedio: </p><p id="std_promedio">???</p>
                            <p>Mínimo: </p><p id="std_minimo">???</p>
                        </td>
                        <td>
                            <div id="std_categorias">Categorias:<br><br>???</div>
                        </td>
                    </tr>
                <table>
            </div>
        </div>
        <div>
            <h2>Personas</h2>
            <div>
                <table id="personas">
                    <tr>
                        <th>Nombre</th>
                        <th>Género</th>
                        <th>Nación</th>
                        <th>Edad</th>
                        <th>Categ</th>
                        <th>Vota</th>
                        <th>Saldo</th>
                        <th>Tipo</th>
                    </tr>
                </table>
            </div>
        </div>
        <div>
            <h2>Pagos</h2>
            <div>
                <input id="pago" name="pago" type="number" placeholder="$ Pago" min="0" step="1000"><br><br>
                <button onclick="pagar()">Pagar</button><br><br>
                <div class="msj" id="msj2"></div>
                <p>Total sin descuento: </p><p id="std_sin_descuento">$ 0</p>
                <p>Total con descuento: </p><p id="std_con_descuento">$ 0</p>
                <table id="pagos">
                    <tr>
                        <th>Monto</th>
                        <th>Descuento</th>
                        <th>Paga</th>
                    </tr>
                </table>
            </div>
        </div>
    </main>
    <footer>
        <p>Omwekiatl - SENA - 2025</p>
    </footer>
    <script>
        document.getElementById("nombre").addEventListener("input", () => {
            let nombre_element = document.getElementById("nombre");
            nombre_element.value = nombre_element.value.toUpperCase();
        });

        document.getElementById("edad").addEventListener("input", () => {
            let year = new Date().getFullYear();
            let edad = year - Number(document.getElementById("edad").value);
            let msjage = edad < 18 ? "Menor" : (edad > 65 ? "Viejo" : "");
            document.getElementById("adultez").innerHTML = msjage;
        });

        document.getElementById("descripcion").addEventListener("input", () => {
            let descri_element = document.getElementById("descripcion");
            let descri_length = descri_element.value.length;
            let the_color = descri_length > 100 ? 'orange' : '';
            descri_element.style.backgroundColor = the_color;
            document.getElementById('descri_info').innerHTML = descri_length + " chars";
        });

        setInterval(() => {
            let timer = document.getElementById("timer");
            timer.innerHTML = parseInt(timer.innerHTML) + 1;
        }, 1000);

        document.getElementById("edad").max = new Date().getFullYear() - 1;

        // variables de uso global
        let registrados = 0;
        let votantes = 0;
        let ganantes = 0;
        let endeudados = 0;
        let vacios = 0;
        let nombres = [];
        let saldos = [];
        let categorias = [];

        // la funcion calculara todo el registro
        function procesar() {
            
            // verificar que los campos esten llenos
            setTimeout(() => {
                document.getElementById("msj1").innerHTML = "";
            }, 3000);
            document.getElementById("msj1").innerHTML = "registrado...";
            if (document.getElementById("nombre").value == "" ||
                    document.getElementById("edad").value == "" ||
                    document.getElementById("saldo").value == "") {
                document.getElementById("msj1").innerHTML = "llene los campos...";
                return null;
            }

            // obtener informacion de la tabla
            let tabla = document.getElementById("personas");
            let fila = document.createElement("tr");
            let valor;
            registrados++;

            // agregar el nombre
            valor = document.createElement("td");
            nombres.push(document.getElementById("nombre").value);
            valor.innerHTML = nombres.at(-1);
            document.getElementById("nombre").value = "";
            fila.appendChild(valor);

            // agregar el genero
            valor = document.createElement("td");
            valor.innerHTML = document.querySelector('input[name="genero"]:checked').value;
            fila.appendChild(valor);

            // agregar la nacion
            valor = document.createElement("td");
            let slktr = document.getElementById("nacion");
            let nacion = slktr.options[slktr.selectedIndex].value;
            valor.innerHTML = nacion;
            fila.appendChild(valor);

            // agregar la edad
            valor = document.createElement("td");
            let year = new Date().getFullYear();
            let edad = year - Number(document.getElementById("edad").value);
            document.getElementById("edad").value = "";
            valor.innerHTML = edad;
            fila.appendChild(valor);

            // calcular categoria segun edad
            valor = document.createElement("td");
            if (edad <= 12) {
                valor.innerHTML = "Menor";
                categorias.push(0);
            }
            else if (edad <= 29) {
                valor.innerHTML = "Jóven";
                categorias.push(1);
            }
            else if (edad <= 59) {
                valor.innerHTML = "Adulto";
                categorias.push(2);
            }
            else {
                valor.innerHTML = "Viejo";
                categorias.push(3);
            }
            fila.appendChild(valor);

            // calcular si vota
            valor = document.createElement("td");
            valor.innerHTML = edad >= 18 && nacion == "CO" ? "Si" : "No";
            votantes += valor.innerHTML == "Si" ? 1 : 0;
            fila.appendChild(valor);

            // agregar el saldo
            valor = document.createElement("td");
            let saldo = Number(document.getElementById("saldo").value);
            saldos.push(saldo);
            document.getElementById("saldo").value = "";
            valor.innerHTML = "$ " + Math.abs(saldo);
            fila.appendChild(valor);

            // calcular tipo de saldo
            valor = document.createElement("td");
            if (saldo > 0) {
                valor.innerHTML = "Gana";
                ganantes++;
            }
            else if (saldo < 0) {
                valor.innerHTML = "Deuda";
                endeudados++;
            }
            else {
                valor.innerHTML = "Vacío";
                vacios++;
            }
            fila.appendChild(valor);

            // agregar el registro a la tabla
            tabla.appendChild(fila);

            // acumular estadisticas globales
            document.getElementById("std_registrados").innerHTML = registrados;
            document.getElementById("std_votantes").innerHTML = votantes;
            document.getElementById("std_ganantes").innerHTML = ganantes;
            document.getElementById("std_endeudados").innerHTML = endeudados;
            document.getElementById("std_vacios").innerHTML = vacios;
            let porc = Math.round((votantes / registrados) * 100);
            document.getElementById("std_porcentaje").innerHTML = porc + " %";

            // hallar promedio, maximo y minimo
            let ind_min = 0;
            let ind_max = 0;
            let suma = 0;
            let sum_cat = [0, 0, 0, 0];
            let tot_cat = [0, 0, 0, 0];
            for (let i = 0; i < saldos.length; i++) {
                suma += saldos[i];
                sum_cat[categorias[i]] += saldos[i];
                tot_cat[categorias[i]]++;
                if (saldos[i] < saldos[ind_min]) {
                    ind_min = i;
                }
                if (saldos[i] > saldos[ind_max]) {
                    ind_max = i;
                }
            }
            var prom = suma / saldos.length;
            document.getElementById("std_total").innerHTML = "$ " + suma;
            document.getElementById("std_promedio").innerHTML = "$ " + prom;
            document.getElementById("std_maximo").innerHTML = "$ " + saldos[ind_max] +
                "<br>( " + nombres[ind_max] + ")";
            document.getElementById("std_minimo").innerHTML = "$ " + saldos[ind_min] +
                "<br>( " + nombres[ind_min] + ")";
            let cat_names = ["Menores", "Jóvenes", "Adultos", "Viejos"];
            let std_cat = document.getElementById("std_categorias");
            std_cat.innerHTML = "";
            for (let i = 0; i < tot_cat.length; i++) {
                sum_cat[i] = sum_cat[i] / Math.max(1, tot_cat[i]);
                std_cat.innerHTML += "<p>" + cat_names[i] + ": </p><p>$ " + sum_cat[i] + "</p>";
            }
        }

        // variables globales para pagos
        let pago_total = 0;
        let pago_descontado = 0;

        // calcula los pagos y descuentos al azar
        function pagar() {

            // verificar que los campos esten llenos
            setTimeout(() => {
                document.getElementById("msj2").innerHTML = "";
            }, 3000);
            document.getElementById("msj2").innerHTML = "pago hecho...";
            if (document.getElementById("pago").value == "") {
                document.getElementById("msj2").innerHTML = "ingrese un valor...";
                return null;
            }

            // obtener informacion de la tabla
            let tabla = document.getElementById("pagos");
            let fila = document.createElement("tr");
            let valor;

            // agregar el pago
            valor = document.createElement("td");
            let pago = Number(document.getElementById("pago").value);
            document.getElementById("pago").value = "";
            valor.innerHTML = "$ " + pago;
            pago_total += pago;
            fila.appendChild(valor);

            // obtener un descuento al azar
            let descuento = 0;
            let dado = Math.random();
            let probabilidades = [0.2, 0.4];
            if (dado < probabilidades[0]) {
                descuento = 40;
            }
            else if (dado < probabilidades[0] + probabilidades[1]) {
                descuento = 25;
            }
            valor = document.createElement("td");
            valor.innerHTML = descuento + " %";
            fila.appendChild(valor);

            // aplicar el descuento
            pago *= 1 - descuento / 100;
            pago_descontado += pago;
            valor = document.createElement("td");
            valor.innerHTML = pago;
            fila.appendChild(valor);

            // acumular estadisticas globales
            document.getElementById("std_sin_descuento").innerHTML = "$ " + pago_total;
            document.getElementById("std_con_descuento").innerHTML = "$ " + pago_descontado;

            // agregar el registro a la tabla
            tabla.appendChild(fila);
        }
    
    /*
    Objetivos del Ejercicio:
    1. dados varios números, distinguir si son positivos, negativos, cero y hacer conteos
    2. identificar qué usuarios pueden votar según edad y nacionalidad, cuántos y quiénes son
    3. mostrar números negativos en formato positivo
    4. dados varios números hallar promedio, max y min, y decir a qué usuario pertenecen
    5. compradores pagan con descuento según sorteo (3 posibilidades), obtener total pagado con / sin descuento.
    6. hallar promedios de peso de usuarios categorizados según: menores, jóvenes, adultos y viejos
    7. poner las letras de un input text en mayúsculas en tiempo real
    8. contar caracteres en tiempo real de una descripción ingresada por el usuario, poner a rojo si pasa un límite
    9. indicador de edad, para verificar adultez, al ingresar la edad, resultado en tiempo real
    10. temporizador, no se hizo reinicio de página para no perder los registros locales
    ...
    Por Implementar:
    11. selección aleatoria y radio buttons, para confirmar que es un humano pensante
    ...
    Nota:
    varios objetivos se han modificado para adaptarse a una misma solución software, cumpliendo con las funcionalidades de trasfondo
    */
    </script>
</body>
</html>
