class Sprites {

    constructor() {
        this.cargas = 0;
        this.sprites = [];
    }

    loadImg(filename, width, height) {
        let img = new Image();
        img.src = "sprites/" + filename + ".png";
        img.onload = () => {
            this.cargas += 1;
        };
        this.sprites.push({
            name: filename,
            imagen: img,
            width: width,
            height: height
        });
    }

    getReady() {
        return this.cargas == this.sprites.length;
    }

    drawSprite(ctx, posicion, spritename, subimg) {
        let spr = this.sprites.filter(s => s.name == spritename)[0];
        ctx.drawImage(spr.imagen, // sprite
            subimg * spr.width, 0, // pos sprite
            spr.width, spr.height, // talla sprite
            posicion.x - spr.width / 2, // posicion
            posicion.y - spr.height / 2,
            spr.width, spr.height); // escala
    }

    drawTiled(ctx, spritename, widthMax, heightMax) {
        let spr = this.sprites.filter(s => s.name == spritename)[0];
        let wMax = Math.ceil(widthMax / spr.width);
        let hMax = Math.ceil(heightMax / spr.height);
        for (let w = 0; w < wMax; w++) {
            for (let h = 0; h < hMax; h++) {
                ctx.drawImage(spr.imagen, // sprite
                    w * spr.width, h * spr.height); // posicion
            }
        }
    }

    static drawTexto(ctx, texto, posicion) {
        ctx.font = "32px 'Georgia', 'Times New Roman'";
        ctx.textAlign = "center"; // left, center, right
        ctx.textBaseline = "top"; // top, middle, bottom
        ctx.fillStyle = "red";
        ctx.fillText(texto, posicion.x, posicion.y);
    }
}
