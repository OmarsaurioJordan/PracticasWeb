// obtener informacion del lienzo
const canvas = document.getElementById("lienzo");
const ctx = canvas.getContext("2d");
const width = canvas.width;
const height = canvas.height;

// activar rutinas de lectura de comandos
newMouseListener(canvas);
newKeyboardListener();

// estructuras de datos de la simulacion
let objetos = []; // contiene todos los objetos del juego

// crear al player
objetos.push(new Player({
    x: width / 2,
    y: height / 2
}));

// crear unas rocas para test
objetos.push(new Rock());

// el main loop del juego
let lastTime = 0;
function loop(currentTime) {
    let dlt = (currentTime - lastTime) / 1000;
    lastTime = currentTime;
    if (!Number.isFinite(dlt)) dlt = 0;
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
}

// iniciar el loop cuando los sprites carguen
const sprites = new Sprites();
setTimeout(arranque, 100);
function arranque() {
    if (sprites.getReady()) {
        loop();
    }
    else {
        setTimeout(arranque, 100);
    }
}
