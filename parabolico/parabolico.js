function calcular() {
    // datos de entrada
    let gra = document.getElementById("gra").value;
    let ang = document.getElementById("ang").value;
    let vel = document.getElementById("vel").value;
    // labels de salida
    let res_alt = document.getElementById("res_alt");
    let res_dis = document.getElementById("res_dis");
    let res_tim = document.getElementById("res_tim");
    // limpiar todo el lienzo
    limpiar();
    // calcular iterativamente el trayecto
    let x = 0;
    let y = 0;
    let t = 0;
    let dt = 0.01;
    let vx = vel * Math.cos(ang * Math.PI / 180);
    let vy = vel * Math.sin(ang * Math.PI / 180);
    let sube = true;
    let ant_y;
    while (t < 60 && (sube || y > 0)) {
        ant_y = y;
        vy += -gra * dt;
        x += vx * dt;
        y += vy * dt;
        // detectar el nivel mas alto
        if (sube && y <= ant_y) {
            sube = false;
            res_alt.textContent = String(y.toFixed(2)) + " m";
        }
        drawPoint(x, y);
        t += dt;
    }
    // pintar los resultados
    res_dis.textContent = String(x.toFixed(2)) + " m";
    res_tim.textContent = String(t.toFixed(2)) + " s";
}

function limpiar() {
    let pix;
    let width = document.getElementById("width").value;
    let height = document.getElementById("height").value;
    for (let x = 0; x < width; x++) {
        for (let y = 0; y < height; y++) {
            pix = document.getElementById(String(x) + "_" + String(y));
            pix.style.backgroundColor = "rgba(24, 221, 24, 0.5)";
        }
    }
}

function drawPoint(x, y) {
    let pix;
    let width = document.getElementById("width").value;
    let height = document.getElementById("height").value;
    x = Math.round(x);
    y = Math.round(y);
    if (x >= 0 && x < width && y >= 0 && y < height) {
        pix = document.getElementById(String(x) + "_" + String(y));
        pix.style.backgroundColor = "rgba(24, 221, 24, 1)";
    }
}
