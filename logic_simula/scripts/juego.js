// obtener informacion del lienzo
const canvas = document.getElementById("lienzo");
const ctx = canvas.getContext("2d");
const width = canvas.width;
const height = canvas.height;

// lectura de comandos desde HTML
var modoMouse = document.getElementById("modoMouse").checked;
document.getElementById("modoMouse").addEventListener("change", (event) => {
    modoMouse = event.target.checked;
    document.getElementById("restart").href = modoMouse ?
        "index.php?modoMouse=1" : "index.php";
});

// activar rutinas de lectura de comandos
newMouseListener(canvas);
newKeyboardListener();

// poner musica de fondo
const musica = new Audio("sounds/musica.wav");
musica.volume = 0.333;
musica.loop = true;
musica.addEventListener("canplaythrough", () => {
    setTimeout(miMusica, 20);
});
function miMusica() {
    let tecla = Object.values(keyData).some(key => key);
    if (mouseData.pulsado || tecla) {
        musica.play();
    }
    else {
        setTimeout(miMusica, 20);
    }
}

// estructuras de datos de la simulacion
const objetos = []; // contiene todos los objetos del juego
var puntaje = 0; // segundos sobreviviendo
const respawn_rock = {
    reloj: 0, // segundos para crear nuevo Rock
    espera: 4
};

// crear al Player
objetos.push(new Player({
    x: width / 2,
    y: height / 2
}));

// crear las Rock iniciales
for (let i = 0; i < 10; i++) {
    objetos.push(new Rock());
}

// el main loop del juego
var lastTime = 0;
function loop(currentTime) {
    let dlt = (currentTime - lastTime) / 1000;
    lastTime = currentTime;
    if (!Number.isFinite(dlt)) dlt = 0;
    dlt = Math.min(dlt, 0.1);
    // ejecutar todo usando el delta de tiempo
    step(dlt);
    draw();
    // pedir que se re ejecute de nuevo
    requestAnimationFrame(loop);
}

// se calcula la logica
function step(dlt) {
    // ejecutar la logica de cada objeto
    objetos.forEach(obj => obj.step(dlt));
    // obtener al objeto Player y ver si vive
    let ply = objetos.filter(obj => obj instanceof Player)[0];
    if (ply.vida != 0) {
        // conteo de puntos
        puntaje += dlt;
        // hacer aparecer mas Rock enemigos
        respawn_rock.reloj -= dlt;
        if (respawn_rock.reloj <= 0) {
            respawn_rock.reloj += respawn_rock.espera +
                Math.random();
            objetos.push(new Rock());
        }
    }
}

// se dibuja todo
function draw() {
    // dibujar todo el suelo
    sprites.drawTiled(ctx, "fondo", width, height);
    // ordenar en Y todos los objetos
    objetos.sort((a, b) => a.depth - b.depth);
    // dibujar todos los objetos
    objetos.forEach(obj => obj.draw());
    // dibujar la interfaz grafica
    Sprites.drawTexto(ctx, Math.floor(puntaje),
        {x: width / 2, y: 0});
}

// iniciar el loop cuando los sprites carguen
const sprites = new Sprites();
sprites.loadImg("player", 64, 64);
sprites.loadImg("rock", 64, 64);
sprites.loadImg("fondo", 96, 96);
setTimeout(arranque, 100);
function arranque() {
    if (sprites.getReady()) {
        loop();
    }
    else {
        setTimeout(arranque, 100);
    }
}
