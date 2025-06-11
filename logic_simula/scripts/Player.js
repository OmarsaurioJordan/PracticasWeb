class Player extends Objeto {
    static VELOCIDAD = 400;
    static RADIO = 26;

    constructor(posicion) {
        super(posicion);
        this.depth = 1;
        this.vida = 4;
    }

    step(dlt) {
        if (this.vida != 0) {
            // moverse con teclas
            let dir = modoMouse ?
                this.getDirMouse() : this.getDirKeys();
            this.pos = moveDirVel(this.pos, dir,
                Player.VELOCIDAD * dlt);
            this.limites();
            // calcular colision
            let otro = this.isColision();
            if (otro !== null) {
                this.vida--;
                otro.destroy();
            }
        }
    }

    getDirKeys() {
        let dir = {x:0, y:0};
        if (keyData["w"]) dir.y--;
        if (keyData["s"]) dir.y++;
        if (keyData["a"]) dir.x--;
        if (keyData["d"]) dir.x++;
        return normalize(dir);
    }

    getDirMouse() {
        if (pointDistance(this.pos, mouseData) < 4) {
            return {x: 0, y: 0};
        }
        return pointDirection(this.pos, mouseData);
    }

    isColision() {
        for (let obj of objetos) {
            if (obj != this) {
                if (pointInCircle(this.pos, obj.pos,
                        Player.RADIO + Rock.RADIO)) {
                    return obj;
                }
            }
        }
        return null;
    }

    limites() {
        this.pos.x = Math.max(Player.RADIO,
            Math.min(width - Player.RADIO, this.pos.x));
        this.pos.y = Math.max(Player.RADIO,
            Math.min(height - Player.RADIO, this.pos.y));
    }

    draw() {
        sprites.drawSprite(ctx, this.pos, "player", this.vida);
    }
}
