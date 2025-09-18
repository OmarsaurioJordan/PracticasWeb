// obtener informacion del lienzo
const canvas = document.getElementById("lienzo");
const ctx = canvas.getContext("2d");
const width = canvas.width;
const height = canvas.height;

// variables para estructuras de datos de la simulacion
const deltaSinc = 250; // milisegundos para efectuar las sincronizaciones
const timeOut = 30; // segundos para eliminar antiguos avatares no utilizados
const objetos = []; // contiene todos los avatares, es un pool de objetos
const emojis = getEmojis(); // array con los emoticones que haran de sprites
const background = createBackground(width * height * 0.02); // canvas de fondo

// inicia la peticion ciclica de actualizaciones de todos los avatares
setInterval(send_solicitud_all, deltaSinc);
setInterval(send_solicitud_one, 1000);

// obtiene todo el texto dentro de los <option>
function getEmojis() {
    let sel = document.getElementById("emoji");
    let emojis = [];
    for (let opt of sel.options) {
        emojis.push(opt.innerHTML);
    }
    return emojis;
}

// genera el background en un canvas
function createBackground(total_tiles) {
    // crear un nuevo canvas y definir variables para la creacion de tiles
    let msk = "\"#_-+*/.:<>=$%&/\\()!?~|°¬";
    let cnvs = document.createElement("canvas");
    cnvs.width = width;
    cnvs.height = height;
    let cctx = cnvs.getContext("2d");
    // dibujar el color de fondo
    cctx.fillStyle = "rgb(160, 200, 220)";
    cctx.fillRect(0, 0, width, height);
    // dibujar los tiles del fondo
    cctx.textAlign = "center";
    cctx.textBaseline = "middle";
    cctx.fillStyle = "rgba(133, 170, 189, 1)";
    for (let i = 0; i < total_tiles; i++) {
        // crear un tile
        let tile = {
            x: Math.random() * width,
            y: Math.random() * height,
            r: Math.random() * 2 * Math.PI,
            s: Math.round(10 + Math.random() * 20),
            c: msk[Math.floor(Math.random() * msk.length)]
        }
        cctx.save();
        cctx.translate(tile.x, tile.y);
        cctx.rotate(tile.r);
        cctx.font = tile.s + "px Arial";
        cctx.fillText(tile.c, tile.x, tile.y);
        cctx.restore();
    }
    return cnvs;
}

// para detectar comandos de teclado, se usaran luego por el avatar del jugador
const teclas = {
    "D": false,
    "A": false,
    "S": false,
    "W": false,
}
window.addEventListener("keydown", e => {
    if (e.key !== undefined) {
        if (e.key.toUpperCase() in teclas) {
            teclas[e.key.toUpperCase()] = true;
        }
    }
});
window.addEventListener("keyup", e => {
    if (e.key !== undefined) {
        if (e.key.toUpperCase() in teclas) {
            teclas[e.key.toUpperCase()] = false;
        }
    }
});

// una funcion maestra para todos los fetch
function getFetch(datos, tipo) {
    fetch("server.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: datos.toString()
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("error solicitud tipo " + tipo);
        }
        return response.json();
    })
    .then(data => {
        // depuracion para ejecutar diferentes funciones con los resultados
        switch (tipo) {
            case "avatar_create":
                avatar_create(data);
                break;
            case "avatar_read_all":
                avatar_read_all(data);
                break;
            case "avatar_read_one":
                avatar_read_one(data);
                break;
        }
    })
    .catch(error => {
        console.error("Error: ", error);
    });
}

// inicia solicitud de crear al player al pulsar el boton
function start() {
    // obtenemos los datos ingresados al formulario
    let nombre = document.getElementById("nombre").value;
    let emoji = document.getElementById("emoji").value;
    if (nombre == "") {
        return false;
    }
    // se arma el paquete a enviar al servidor, con posicion aleatoria
    let data = new URLSearchParams();
    data.append("nombre", nombre);
    data.append("emoji", emoji);
    data.append("pos_x", Math.random() * width);
    data.append("pos_y", Math.random() * height);
    // se hace el envio especificando ademas el tipo de transaccion
    data.append("tipo", "avatar_create");
    getFetch(data, "avatar_create");
}

// crear al player al recibir el fetch
function avatar_create(data) {
    if (data.id != 0) {
        // crea al avatar con los datos del jugador, en modo manual y lo pone en la pool
        let ava = new Avatar(data.id, data.nombre, data.emoji, data.pos_x, data.pos_y);
        ava.setManual(true);
        objetos.push(ava);
        // elimina el sistema de registro, se debe recargar la pagna para volver a verlo
        document.getElementById("login").innerHTML = "<h3>hola " + data.nombre + " moverte con WASD</h3>";
        // comienza el ciclo de envio de datos para sincronizacion
        setInterval(send_actualizar, deltaSinc);
    }
}

// ejecuta el envio de la posicion del jugador actual al servidor DB
function send_actualizar() {
    for (let obj of objetos) {
        if (obj.getManual()) {
            // una vez hallado el avatar manual, se arma el paquete con su posicion
            let data = new URLSearchParams();
            data.append("id", obj.getId());
            data.append("pos_x", obj.getPos().x);
            data.append("pos_y", obj.getPos().y);
            // se hace el envio especificando ademas el tipo de transaccion
            data.append("tipo", "avatar_update");
            getFetch(data, "avatar_update");
            break;
        }
    }
}

// ejecuta el envio de la solicitud para recibir actualizaciones de posiciones de avatares
function send_solicitud_all() {
    // se arma el paquete de solicitud, con el tipo especifico para pedir posiciones de avatares
    let data = new URLSearchParams();
    data.append("tipo", "avatar_read_all");
    getFetch(data, "avatar_read_all");
    // opcional y aleatoriamente, hace de vez en cuando solicitud de eliminacion
    // esto podria ir en un schedule de la DB, pero se hara desde aqui
    // teniendo en cuenta el total de avatares, pues todos haran la misma solicitud de impacto global
    if (Math.random() < 0.05 / Math.max(1, objetos.length)) {
        let kill = new URLSearchParams();
        kill.append("time_out_s", timeOut);
        kill.append("tipo", "avatar_delete_all");
        getFetch(kill, "avatar_delete_all");
    }
}

// busca un avatar por ejecucion, que no tenga aun sus datos, para solicitarlos
// nota: la sincronia de posicion carga a todos los avatares, aqui se solicitan sus datos internos
function send_solicitud_one() {
    for (let obj of objetos) {
        if (obj.getInvisible()) {
            // una vez obtenido un avatar invisible o no iniciado, se solicitan sus datos
            let data = new URLSearchParams();
            data.append("id", obj.getId());
            // el paquete se envia teniendo en cuenta el tipo, para su depuracion
            data.append("tipo", "avatar_read_one");
            getFetch(data, "avatar_read_one");
            break;
        }
    }
}

// sincroniza las posiciones de los avatares
function avatar_read_all(data) {
    // coloca a todos los avatares en false para ver cuales reciben sincronizacion
    for (let obj of objetos) {
        obj.resetOkSinc();
    }
    // recorre toda la lista de sincronizacion proveniente del servidor
    for (let row of data) {
        let existe = false;
        // para cara registro busca al avatar por su id en el pool de objetos
        for (let obj of objetos) {
            if (obj.getId() == row.id) {
                // le coloca la nueva posicion a donde deberia de moverse
                obj.setSinc(row.pos_x, row.pos_y);
                existe = true;
                break;
            }
        }
        // si no hay un avatar para el id buscado, crea un avatar nuevo
        if (!existe) {
            let ava = new Avatar(row.id, "", 0, row.pos_x, row.pos_y);
            objetos.push(ava);
        }
    }
    // elimina avatares cuando no recibieron sincronizacion, no estan en la lista
    for (let i = objetos.length - 1; i >= 0; i--) {
        if (!objetos[i].getOkSinc()) {
            objetos.splice(i, 1);
        }
    }
}

// sincroniza la informacion de un avatar
function avatar_read_one(data) {
    for (let obj of objetos) {
        // busca ala vatar en la pool por id y le coloca sus datos
        if (obj.getId() == data.id) {
            obj.setData(data.nombre, data.emoji);
            break;
        }
    }
}

// el main loop del simulador
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
}

// se dibuja todo
function draw() {
    // dibujar el fondo predisennado
    ctx.drawImage(background, 0, 0);
    // ordenar en Y todos los objetos, dibujar emojis y luego nombres
    objetos.sort((a, b) => a.pos.y - b.pos.y);
    objetos.forEach(obj => obj.drawEmoji());
    objetos.forEach(obj => obj.drawNombre());
}

// lanzar la simulacion
requestAnimationFrame(loop);
