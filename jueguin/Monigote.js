class Monigote {
    
    constructor(limx, limy, img) {
        this.img = img;
        this.x = Math.random() * limx;
        this.y = Math.random() * limy;
        this.dir = Math.random() * 2 * Math.PI;
        this.mov = Math.random() > 0.5;
        this.vel = 1 + Math.random() * 2;
        this.radio = 12;
        this.relojErrar = 0;
    }

    step(limx, limy, dlt, lisx, lisy, ind, moux, mouy, andar) {
        // reloj para cambio de movimiento
		this.relojErrar -= dlt;
		if (this.relojErrar <= 0) {
		    this.relojErrar = 500 + Math.random() * 2000;
			if (this.mov) {
				this.mov = Math.random() > 0.25;
				let arc = 0.5 * Math.PI;
				this.dir += -arc + Math.random() * 2 * arc;
			}
			else {
				this.mov = Math.random() > 0.666;
				this.dir = Math.random() * 2 * Math.PI;
			}
			this.vel = 1 + Math.random() * 2;
		}
		// buscar colisiones, hallar vector total
		let rex = 0;
		let rey = 0;
		for (let i = 0; i < lisx.length; i++) {
            if (i == ind) {
                continue;
            }
			if (Math.sqrt(
					Math.pow(this.x - lisx[i], 2) +
					Math.pow(this.y - lisy[i], 2)
					) < this.radio * 2) {
				rex += this.x - lisx[i];
				rey += this.y - lisy[i];
			}
        }
		// ejecutar movimiento de colision
		if (rex != 0 || rey != 0) {
			let mag = Math.sqrt(Math.pow(rex, 2) + Math.pow(rey, 2));
			this.x += (rex / mag) * 0.333 * dlt;
			this.y += (rey / mag) * 0.333 * dlt;
		}
		// forzar moverse y dirigirse hacia el mouse
		if (ind == 0) {
			this.mov = andar;
			this.dir = Math.atan2(mouy - this.y, moux - this.x);
		}
		// ejecutar el movimiento autonomo
		if (this.mov) {
			let vx = this.vel * Math.cos(this.dir);
			let vy = this.vel * Math.sin(this.dir);
			this.x += vx;
			this.y += vy;
			// poner limites y hacer rebote
			let antx = this.x;
			let anty = this.y;
			this.x = Math.max(32, Math.min(limx - 32, this.x));
			this.y = Math.max(93, Math.min(limy, this.y));
			if (this.x != antx || this.y != anty) {
				this.dir = Math.random() * 2 * Math.PI;
			}
		}
    }

    draw(ctx) {
	    ctx.drawImage(this.img, this.x - 32, this.y - 93);
	}
}
