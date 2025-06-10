// pulsacion de mouse
let mouseData = {
    x: 0, // posicion en el lienzo, sin afectarse por escalamiento ni mov
    y: 0,
    pulsado: false, // true el clic izquierdo esta apretado
};

function newMouseListener(miCanvas) {
    miCanvas.addEventListener("mousemove", (event) => {
		let rect = miCanvas.getBoundingClientRect();
		mouseData.x = Math.round(event.clientX - rect.left);
		mouseData.y = Math.round(event.clientY - rect.top);
	});
    document.addEventListener("mousedown", (event) => {
        if (event.button != 0) { return null; }
        mouseData.pulsado = true;
    });
    document.addEventListener("mouseup", (event) => {
        if (event.button != 0) { return null; }
        mouseData.pulsado = false;
    });
}

// funciones para calculos vectoriales

function pointDistance(pos1, pos2) {
    let dif = [
        Math.pow(pos1.x - pos2.x, 2),
        Math.pow(pos1.y - pos2.y, 2),
    ];
    return Math.sqrt(dif[0] + dif[1]);
}

function pointInCircle(pos1, pos2, radio) {
    let dist = pointDistance(pos1, pos2);
    return dist < radio;
}

function pointInRectangle(pos, rec1, rec2) {
    return pos.x > rec1.x && pos.x < rec2.x &&
        pos.y > rec1.y && pos.y < rec2.y;
}

function magnitud(vect) {
    return Math.sqrt(
        Math.pow(vect.x, 2) + Math.pow(vect.y, 2)
    );
}

function normalize(vect) {
    let mag = magnitud(vect);
    if (mag == 0) return vect;
    return {
        x: vect.x / mag,
        y: vect.y / mag
    };
}

function moveDirVel(pos, dir, vel) {
    return {
        x: pos.x + dir.x * vel,
        y: pos.y + dir.y * vel
    };
}

// comandos de teclado, deteccion de pulsaciones
let keyData = {
    "w": false,
    "s": false,
    "a": false,
    "d": false
}

function newKeyboardListener() {
    window.addEventListener('keydown', (event) => {
        if (event.key in keyData) {
            keyData[event.key] = true;
        }
    });
    window.addEventListener('keyup', (event) => {
        if (event.key in keyData) {
            keyData[event.key] = false;
        }
    });
}
