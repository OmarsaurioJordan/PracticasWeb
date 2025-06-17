class Ente {
    constructor(posicion) {
        this.pos = {...posicion};
        this.depth = 0;
    }

    destroy() {
        let i = objetos.indexOf(this);
        if (i != -1) {
            objetos.splice(i, 1);
        }
    }
}
