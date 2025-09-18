class Avatar {

    static SPEED = 200; // velocidad de desplazamiento
    static RADIO = 16; // radio de colision del objeto
    
    constructor(id, nombre, emoji, pos_x, pos_y) {
        // variables presentes en la DB
        this.id = id
        this.emoji = emoji;
        this.nombre = nombre;
        this.pos = {x: pos_x, y: pos_y};
        // variables de logica interna
        this.manual = false; // true sera manejado por el usurio actual
        this.sinc = {x: pos_x, y: pos_y}; // posicion del server que debe alcanzarce
        this.okSinc = true; // para destruir avatares no sincronizados
    }

    // getters y setters, ademas de funciones para sincronizacion

    getId() {
        return this.id;
    }

    getManual() {
        return this.manual;
    }

    getPos() {
        return this.pos;
    }

    getInvisible() {
        return this.nombre == "" || this.emoji == 0;
    }

    setManual(manual) {
        this.manual = manual;
    }

    setData(nombre, emoji) {
        this.nombre = nombre;
        this.emoji = emoji;
    }

    resetOkSinc() {
        this.okSinc = false;
    }

    getOkSinc() {
        return this.okSinc;
    }

    setSinc(pos_x, pos_y) {
        this.sinc.x = pos_x;
        this.sinc.y = pos_y;
        this.okSinc = true;
    }

    // esto se ejecutara muchas veces por segundo, dlt es el delta de tiempo
    step(dlt) {
        // moverse con teclas
        if (this.manual) {
            let dir = this.getDirKeys();
            this.pos = this.moveDirVel(this.pos, dir, Avatar.SPEED * dlt);
        }
        // movimiento de sincronizacion
        else {
            let dir = this.pointDirection(this.pos, this.sinc);
            let dis = this.pointDistance(this.pos, this.sinc);
            this.pos = this.moveDirVel(this.pos, dir, dis * dlt * 4);
        }
        // calculos fisicos finales
        this.colision(dlt);
        this.limites();
    }

    // devuelve un vector director segun las teclas pulsadas
    getDirKeys() {
        let dir = {x:0, y:0};
        if (teclas["W"]) dir.y--;
        if (teclas["S"]) dir.y++;
        if (teclas["A"]) dir.x--;
        if (teclas["D"]) dir.x++;
        return this.normalize(dir);
    }

    // hace que no pueda traspasar o solaparse con otros avatares
    colision(dlt) {
        let dir = {x:0, y:0};
        for (let obj of objetos) {
            if (obj == this) { continue; }
            if (this.pointInCircle(this.pos, obj.pos, Avatar.RADIO * 2)) {
                let point = this.pointDirection(obj.pos, this.pos);
                dir.x += point.x;
                dir.y += point.y;
            }
        }
        this.pos = this.moveDirVel(this.pos, dir, Avatar.SPEED * dlt);
    }

    // mantiene al avatar dentro del area permitida de la simulacion
    limites() {
        this.pos.x = Math.max(Avatar.RADIO,
            Math.min(width - Avatar.RADIO, this.pos.x));
        this.pos.y = Math.max(Avatar.RADIO * 2,
            Math.min(height - Avatar.RADIO, this.pos.y));
    }

    // estas son las funciones de dibujado, basadas en texto

    drawEmoji() {
        if (!this.getInvisible()) {
            ctx.font = "32px Arial";
            ctx.textAlign = "center";
            ctx.textBaseline = "middle";
            ctx.fillStyle = "white";
            let emo = "❓";
            if (this.emoji - 1 < emojis.length) {
                emo = emojis[this.emoji - 1];
            }
            ctx.fillText(emo, this.pos.x, this.pos.y);
        }
    }

    drawNombre() {
        if (!this.getInvisible()) {
            ctx.font = "18px Arial";
            ctx.textAlign = "center";
            ctx.textBaseline = "bottom";
            ctx.fillStyle = "black";
            ctx.fillText(this.nombre, this.pos.x, this.pos.y - Avatar.RADIO);
        }
    }

    // herramientas para calculo vectorial

    magnitud(vect) {
        return Math.sqrt(
            Math.pow(vect.x, 2) + Math.pow(vect.y, 2));
    }

    normalize(vect) {
        let mag = this.magnitud(vect);
        if (mag == 0) return vect;
        return {
            x: vect.x / mag,
            y: vect.y / mag
        };
    }

    pointDirection(pos1, pos2) {
        return this.normalize({
            x: pos2.x - pos1.x,
            y: pos2.y - pos1.y
        });
    }

    pointDistance(pos1, pos2) {
        return this.magnitud({
            x: pos2.x - pos1.x,
            y: pos2.y - pos1.y
        });
    }

    pointInCircle(pos1, pos2, radio) {
        let dist = this.pointDistance(pos1, pos2);
        return dist <= radio;
    }

    moveDirVel(pos, dir, vel) {
        return {
            x: pos.x + vel * dir.x,
            y: pos.y + vel * dir.y
        };
    }

    // otras funciones vectoriales no usadas

    angulo(vect) {
        return Math.atan2(vect.y, vect.x);
    }

    pointAngle(pos1, pos2) {
        return this.angulo({
            x: pos2.x - pos1.x,
            y: pos2.y - pos1.y
        });
    }

    moveAngVel(pos, angRad, vel) {
        return {
            x: pos.x + vel * Math.cos(angRad),
            y: pos.y + vel * Math.sin(angRad)
        };
    }
}
