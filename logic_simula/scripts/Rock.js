class Rock extends Objeto {
    static VELOCIDAD = 150;
    static RADIO = 14;

    constructor() {
        super({x: width * 0.75, y: height / 2});
        this.anima = {
            relojMax: 0.1, // tiempo que dura un paso de animacion
            reloj: 0, // contador para hacer cambios
            pasoMax: 3, // numero total de subimagenes - 1
            paso: 0 // subimagen actual de la animacion
        }
    }

    step(dlt) {
        this.stepAnima(dlt);
    }

    stepAnima(dlt) {
        this.anima.reloj -= dlt;
        while (this.anima.reloj <= 0) {
            this.anima.reloj += this.anima.relojMax;
            this.anima.paso++;
            if (this.anima.paso > this.anima.pasoMax) {
                this.anima.paso = 0;
            }
        }
    }

    isColision() {
        objetos.forEach(obj => {
            if (obj != this) {
                if (pointInCircle(this.pos, obj.pos,
                        Player.RADIO + Rock.RADIO)) {
                    return true;
                }
            }
        });
        return false;
    }

    draw() {
        sprites.drawSprite(ctx, this.pos, "rock", this.anima.paso);
    }
}
