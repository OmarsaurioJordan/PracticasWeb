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

// funciones para calculos vectoriales

function angulo(vect) {
    return Math.atan2(vect.y, vect.x);
}

function magnitud(vect) {
    return Math.sqrt(
        Math.pow(vect.x, 2) + Math.pow(vect.y, 2));
}

function normalize(vect) {
    let mag = magnitud(vect);
    if (mag == 0) return vect;
    return {
        x: vect.x / mag,
        y: vect.y / mag
    };
}

function pointDirection(pos1, pos2) {
    return normalize({
        x: pos2.x - pos1.x,
        y: pos2.y - pos1.y
    });
}

function pointAngle(pos1, pos2) {
    return angulo({
        x: pos2.x - pos1.x,
        y: pos2.y - pos1.y
    });
}

function pointDistance(pos1, pos2) {
    return magnitud({
        x: pos2.x - pos1.x,
        y: pos2.y - pos1.y
    });
}

function pointInCircle(pos1, pos2, radio) {
    let dist = pointDistance(pos1, pos2);
    return dist < radio;
}

function pointInRectangle(pos, rec1, rec2) {
    return pos.x > rec1.x && pos.x < rec2.x &&
        pos.y > rec1.y && pos.y < rec2.y;
}

function moveDirVel(pos, dir, vel) {
    return {
        x: pos.x + vel * dir.x,
        y: pos.y + vel * dir.y
    };
}

function moveAngVel(pos, angRad, vel) {
    return {
        x: pos.x + vel * Math.cos(angRad),
        y: pos.y + vel * Math.sin(angRad)
    };
}
