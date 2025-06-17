<?php
	$modoMouse = isset($_GET['modoMouse']) ? " checked" : "";
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport"
			content="width=device-width, initial-scale=1.0">
		<style>
			body {
				background-color:rgb(59, 51, 33);
				color: white;
				display: flex;
				flex-direction: column;
				justify-content: center;
				align-items: center;
			}
			a {
				color:rgb(217, 228, 65);
				text-decoration: none;
			}
		</style>
		<title>Logic Game</title>
	</head>
	<body>
		<h1>Logic Game</h1>
		<div>
			<input type="checkbox" id="modoMouse" <?php echo $modoMouse; ?>>
			<label for="modoMouse"> modo Mouse, sino W,A,S,D<br>.</label>
		</div>
		<canvas id="lienzo" width="1000" height="700"
			style="border:1px solid black;"></canvas>
		<h3>by Omwekiatl 2025 <a href="" id="restart">(Restart)</a></h3>
	</body>
	<script src="scripts/tools.js" defer></script>
	<script src="scripts/Sprites.js" defer></script>
	<script src="scripts/Ente.js" defer></script>
	<script src="scripts/Player.js" defer></script>
	<script src="scripts/Rock.js" defer></script>
	<script src="scripts/juego.js" defer></script>
</html>
