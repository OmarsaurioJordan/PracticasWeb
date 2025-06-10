class Player extends Objeto {
    static VELOCIDAD = 200;
    static RADIO = 28;

    constructor(posicion) {
        super(posicion);
        this.vida = 4;
    }

    step(dlt) {

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
        sprites.drawSprite(ctx, this.pos, "player", this.vida);
    }
}
