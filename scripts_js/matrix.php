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
            flex: 1;
            font-size: 32px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Matrix</h1>
    </header>
    <main>
        <div id="matrix"></div>
    </main>
    <footer>
        <p>Omwekiatl - SENA - 2025</p>
    </footer>
    <script>
        let width = 200;
        let height = 20;
        let matrix = document.getElementById("matrix");
        let labels = []
        for (let x = 0; x < width; x++) {
            let label = document.createElement('label');
            for (let y = 0; y < height; y++) {
                label.innerHTML += "0\n";
            }
            labels.push(label);
            matrix.appendChild(label);
        }
        setInterval(() => {
            labels.forEach(label => {
                if (Math.random() < 0.5) {
                    let bit = Math.random() < 0.25 ? "1\n" : "0\n";
                    let bits = bit + label.innerHTML;
                    label.innerHTML = bits.substring(0, height * 2);
                }
            });
        }, 150);
    </script>
</body>
</html>
