<html>
	<head>
		<title>Ejemplito</title>
		<style>
			body {
				background-color:rgb(59, 51, 33);
				color: white;
				display: flex;
				justify-content: center;
				align-items: center;
			}
		</style>
	</head>
	<body>
		<!-- para guardar la imagen, no se aun como se hace de otro modo -->
		<img id="emoticon" src="emoticon.png" hidden>
		<!-- el lienzo donde se dibuja todo -->
		<canvas id="lienzo" width="1000" height="700"
			style="border:1px solid black;"></canvas>
		<br>
		<!-- label por si se necesita imprimir mensajes de debug -->
		<label id="output"></label>
	</body>
</html>

<script>
	// este label llamado out es para imprimir mensajes de debug
	const out = document.getElementById("output");
	// obtenemos la informacion global del mundo del juego
	const cnv = document.getElementById("lienzo");
	const ctx = cnv.getContext("2d");
	const limx = cnv.width;
	const limy = cnv.height;
	// obtenemos la imagen del personaje, pd: no se aun como cargarla de otra forma
	const img = document.getElementById("emoticon");
	// estas son las variables que definen el movimiento el personaje
	let x = Math.random() * limx;
	let y = Math.random() * limy;
	let dir = Math.random() * 2 * Math.PI;
	let mov = Math.random() > 0.5;
	let vel = 1 + Math.random() * 3;
	let reloj = 0;
	// estas son las configuraciones de ejecucion del mundo del juego
	const dlt = 1000 / 60;
	const fps = 30;
	setInterval(step, dlt);
	setInterval(draw, 1000 / fps);
	// esto simplemente lo guarde aqui, es la linea que se usa para escribir debug
	out.innerHTML = "";

	// el main loop o ciclo donde se calcula el movimiento del personaje
	function step() {
		// el reloj cada que se dispara hay un cambio de direccion o mover/quieto
		reloj -= dlt;
		if (reloj <= 0) {
			// reiniciar el reloj con valor al azar
		    reloj = 500 + Math.random() * 2000;
			// si esta en movimiento es posible que siga asi, y gire un poco
			if (mov) {
				mov = Math.random() > 0.25;
				let arc = 0.5 * Math.PI;
				dir += -arc + Math.random() * 2 * arc;
			}
			// si quieto, es posible que siga asi, esoge direccion al azar
			else {
				mov = Math.random() > 0.666;
				dir = Math.random() * 2 * Math.PI;
			}
			vel = 1 + Math.random() * 3;
		}
		// en caso de moverse, aqui se calcula todo ello
		if (mov) {
			// descomponer veloccidad y direccion en x,y
			let vx = vel * Math.cos(dir);
			let vy = vel * Math.sin(dir);
			// actualizar la posicion
			x += vx;
			y += vy;
			// evitar que se salga de los limites del mundo
			let antx = x;
			let anty = y;
			x = Math.max(0, Math.min(limx, x));
			y = Math.max(0, Math.min(limy, y));
			if (x != antx || y != anty) {
				// si llego al limite elegir otra direccion al azar
				dir = Math.random() * 2 * Math.PI;
			}
		}
	}

	// el ciclo de dibujado, se borra todo y luego se dibuja el personaje
	function draw() {
		// dibujar fondo
		ctx.fillStyle = "rgb(133, 162, 204)";
  		ctx.fillRect(0, 0, limx, limy);
		// dibujar personaje
		ctx.fillStyle = "white";
	    ctx.drawImage(img, x - 24, y - 24);
	}
</script>
