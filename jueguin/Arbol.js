class Arbol {

	constructor(limx, limy, img) {
        this.img = img;
        this.x = Math.random() * limx;
        this.y = Math.random() * limy;
		this.radio = 16;
	}

	colision(arboles) {
		for (let i = 0; i < arboles.length; i++) {
			if (Math.sqrt(
					Math.pow(this.x - arboles[i].x, 2) +
					Math.pow(this.y - arboles[i].y, 2)
					) < this.radio * 2) {
				return true;
			}
		}
		return false;
	}

	draw(ctx) {
	    ctx.drawImage(this.img, this.x - 32, this.y - 93);
	}
}
