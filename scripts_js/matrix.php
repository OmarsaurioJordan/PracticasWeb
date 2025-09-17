<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Matrix</title>
    <style>
        body {
            background-color: black;
            color: lime;
            text-align: center;
            display:flex;
            flex-direction: column;
            margin: 0;
        }
        main {
            font-size: 26px;
        }
        input, button {
            font-size: 20px;
        }
        button:hover {
            background-color: green;
            color: white;
            cursor: pointer;
        }
        .horizontal {
            font-size: 24px;
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-around;
        }
        .matrix {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-around;
        }
    </style>
</head>
<body>
    <header>
        <h1>Matrix</h1>
    </header>
    <main>
        <div class="horizontal">
            <div>
                <label>Width</label><br>
                <input type="number" id="width" min="1" max="1000" step="1">
            </div>
            <div>
                <label>Height</label><br>
                <input type="number" id="height" min="1" max="1000" step="1">
            </div>
            <div>
                <label>Ones %</label><br>
                <input type="number" id="ones" min="0" max="100" step="1">
            </div>
            <div>
                <label>Change %</label><br>
                <input type="number" id="change" min="0" max="100" step="1">
            </div>
            <div>
                <label>Speed ms</label><br>
                <input type="number" id="speed" min="1" max="1000" step="1">
            </div>
            <button onclick="start()">Generate</button>
        </div>
        <div class="matrix" id="matrix"></div>
    </main>
    <footer>
        <p>Omwekiatl - SENA - 2025</p>
    </footer>
    <script>
        // configuracion
        let width = 50;
        let height = 25;
        let prob_ones = 0.25;
        let prob_change = 0.75;
        let speed_ms = 150;
        // cargar valores por defecto
        document.getElementById("width").value = width;
        document.getElementById("height").value = height;
        document.getElementById("ones").value = prob_ones * 100;
        document.getElementById("change").value = prob_change * 100;
        document.getElementById("speed").value = speed_ms;
        // generacion de la matrix
        let labels = [];
        let engine = null;
        function start() {
            let matrix = document.getElementById("matrix");
            // cargar datos de los inputs
            width = document.getElementById("width").value;
            height = document.getElementById("height").value;
            prob_ones = document.getElementById("ones").value / 100;
            prob_change = document.getElementById("change").value / 100;
            speed_ms = document.getElementById("speed").value;
            // eliminar matrix anterior
            labels.forEach(label => label.remove());
            labels = [];
            if (engine !== null) {
                clearInterval(engine);
            }
            // crear matrix nueva
            for (let x = 0; x < width; x++) {
                let label = document.createElement('label');
                for (let y = 0; y < height; y++) {
                    label.innerHTML += "0<br>";
                }
                labels.push(label);
                matrix.appendChild(label);
            }
            engine = setInterval(run, speed_ms);
        }
        // animacion ciclica
        function run() {
            labels.forEach(label => {
                if (Math.random() < prob_change) {
                    let bit = Math.random() < prob_ones ? "1<br>" : "0<br>";
                    let bits = bit + label.innerHTML;
                    label.innerHTML = bits.substring(0, height * 5);
                }
            });
        }
        // iniciar automaticamente
        start();
    </script>
</body>
</html>
