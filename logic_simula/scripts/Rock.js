class Rock extends Objeto {
    static VELOCIDAD = 300;
    static RADIO = 10;
    static RELOJ_INICIA = 2;
    static ARCO_AZAR_RAD = Math.PI / 8;

    constructor() {
        super({x: 0, y: 0});
        this.relojInicia = 0; // temporizador empezar a moverse
        this.anguloRad = 0; // direccion de movimiento
        this.anima = {
            relojMax: 0.1, // tiempo que dura un paso de animacion
            reloj: 0, // contador para hacer cambios
            pasoMax: 3, // numero total de subimagenes - 1
            paso: 0 // subimagen actual de la animacion
        }
        this.reiniciar();
        this.relojInicia = Math.random() * Rock.RELOJ_INICIA;
        this.sndTiro = new Audio("sounds/tiro.wav");
    }

    reiniciar() {
        this.posBordesAzar();
        this.relojInicia = Rock.RELOJ_INICIA;
        let ply = objetos.filter(obj => obj instanceof Player)[0];
        this.anguloRad = pointAngle(this.pos, ply.pos) +
            (Math.random() * 2 - 1) * Rock.ARCO_AZAR_RAD;
    }

    posBordesAzar() {
        if (Math.random() < width / (width + height)) { // width
            this.pos.x = Math.random() * width;
            this.pos.y = Math.random() < 0.5 ? 0 : height;
        }
        else { // height
            this.pos.x = Math.random() < 0.5 ? 0 : width;
            this.pos.y = Math.random() * height;
        }
    }

    getActivo() {
        return this.relojInicia == 0;
    }

    step(dlt) {
        this.stepAnima(dlt);
        if (this.getActivo()) {
            this.pos = moveAngVel(this.pos,
                this.anguloRad, Rock.VELOCIDAD * dlt);
            if (!pointInRectangle(this.pos,
                    {x: 0, y: 0}, {x: width, y: height})) {
                this.reiniciar();
            }
        }
        else {
            this.relojInicia = Math.max(0, this.relojInicia - dlt);
            if (this.relojInicia == 0) {
                this.sndTiro.currentTime = 0;
                this.sndTiro.play();
            }
        }
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

    draw() {
        sprites.drawSprite(ctx, this.pos, "rock", this.anima.paso);
    }
}
