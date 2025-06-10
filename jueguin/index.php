<html>
	<head>
		<title>Juego</title>
		<style>
			body {
				background-color:rgb(59, 51, 33);
				color: white;
				display: flex;
				flex-direction: column;
				justify-content: center;
				align-items: center;
			}
		</style>
	</head>
	<body>
		<img id="usr0" src="img/usr0.png" hidden>
		<img id="usr1" src="img/usr1.png" hidden>
		<img id="usr2" src="img/usr2.png" hidden>
		<img id="usr3" src="img/usr3.png" hidden>
		<img id="usr4" src="img/usr4.png" hidden>
		<img id="suelo" src="img/suelo.png" hidden>
		<img id="arbol" src="img/muro0.png" hidden>
		<h3>Jueguin Omi</h3>
		<canvas id="lienzo" width="1000" height="700"
			style="border:1px solid black;"></canvas><br>
		<label>Press Space or L-Clic</label>
		<label id="output"></label>
	</body>
</html>

<script src="Monigote.js"></script>
<script src="Arbol.js"></script>
<script>
	const imgs = [];
	for (let i = 0; i < 5; i++) {
		imgs.push(document.getElementById("usr" + i));
	}
	const imgArbol = document.getElementById("arbol");
	const suelo = document.getElementById("suelo");
	// informacion del lienzo
	const out = document.getElementById("output");
	const cnv = document.getElementById("lienzo");
	const ctx = cnv.getContext("2d");
	const limx = cnv.width;
	const limy = cnv.height;
	// para posicionar el mouse
	let moux = 0;
	let mouy = 0;
	cnv.addEventListener("mousemove", (event) => {
		const rect = cnv.getBoundingClientRect();
		moux = Math.floor(event.clientX - rect.left);
		mouy = Math.floor(event.clientY - rect.top);
		out.innerHTML = moux + "," + mouy;
	});
	// comandos
	let isMouse = false;
	let isSpace = false;
	cnv.addEventListener("mousedown", (e) => {
		if (e.button != 0) { return null; }
		isMouse = true;
		});
	cnv.addEventListener("mouseup", (e) => {
		if (e.button != 0) { return null; }
		isMouse = false;
		});
	document.addEventListener("keydown", (e) => {
		if (e.code == "Space") {
			isSpace = true;
		}
		});
	document.addEventListener("keyup", (e) => {
		if (e.code == "Space") {
			isSpace = false;
		}
		});
	// ejecucion general
	const dlt = 1000 / 60;
	const fps = 30;
	setInterval(step, dlt);
	setInterval(draw, 1000 / fps);
	out.innerHTML = "";
	// crear instancias
	const totMonis = 20;
	let monis = [];
	for (let i = 0; i < totMonis; i++) {
		let u = Math.floor(Math.random() * 5);
		monis.push(new Monigote(limx, limy, imgs[u]));
	}
	// crear arboles
	const totArboles = 30;
	let arboles = [];
	for (let i = 0; i < totArboles; i++) {
		let arb = new Arbol(limx, limy, imgArbol);
		if (!arb.colision(arboles)) {
			arboles.push(arb);
		}
	}
	// fusionarlos
	let objetos = monis.concat(arboles);

	function step() {
		let lisx = [];
		let lisy = [];
		for (let i = 0; i < monis.length ; i++) {
			lisx.push(monis[i].x);
			lisy.push(monis[i].y);
		}
		for (let i = 0; i < arboles.length ; i++) {
			lisx.push(arboles[i].x);
			lisy.push(arboles[i].y);
		}
		for (let i = 0; i < monis.length ; i++) {
			monis[i].step(limx, limy, dlt, lisx, lisy, i,
				moux, mouy, isMouse || isSpace);
		}
	}

	function draw() {
		ctx.drawImage(this.suelo, 0, 0);
		let depth = [];
		for (let i = 0; i < objetos.length ; i++) {
			depth.push([objetos[i], objetos[i].y]);
		}
		depth.sort((a, b) => a[1] - b[1]);
	    for (let i = 0; i < depth.length ; i++) {
			depth[i][0].draw(ctx);
		}
	}
</script>
