class Player extends Objeto {
    static VELOCIDAD = 200;
    static RADIO = 28;

    constructor(posicion) {
        super(posicion);
        this.depth = 1;
        this.vida = 4;
    }

    step(dlt) {
        if (this.vida != 0) {
            // moverse con teclas
            let dir = this.getDirManejo();
            this.pos = moveDirVel(this.pos, dir,
                Player.VELOCIDAD * dlt);
            // calcular colision
            let otro = this.isColision();
            console.log(otro);
            if (otro !== null) {
                this.vida--;
                otro.destroy();
            }
        }
    }

    getDirManejo() {
        let dir = {x:0, y:0};
        if (keyData["w"]) dir.y--;
        if (keyData["s"]) dir.y++;
        if (keyData["a"]) dir.x--;
        if (keyData["d"]) dir.x++;
        return normalize(dir);
    }

    isColision() {
        objetos.forEach(obj => {
            if (obj != this) {
                if (pointInCircle(this.pos, obj.pos,
                        Player.RADIO + Rock.RADIO)) {
                    return obj;
                }
            }
        });
        return null;
    }

    draw() {
        sprites.drawSprite(ctx, this.pos, "player", this.vida);
    }
}
