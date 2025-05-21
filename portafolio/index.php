<?php

// enviar mail
$mail = isset($_POST['mail']) ? $_POST['mail'] : "";
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
$texto = isset($_POST['texto']) ? $_POST['texto'] : "";
if ($mail != "") {
  $mail_header = "From: ojorcio@omwekiatl.xyz";
  $mail_subject = "Contactaste Omwekiatl";
  $mail_msj = "Hola, gracias por ponerte en contacto con Omwekiatl.".
    "\n\nDesde la página: https://omwekiatl.xyz has enviado un mensaje.".
    "\n\n$nombre: $texto\n\nEspera a que te contesten...";
  mail($mail, $mail_subject, $mail_msj, $mail_header);
  $mail_subject = "Mensaje Omwekiatl";
  $mail_msj = "Hola, alguien se ha puesto en contacto.".
    "\n\nDesde el mail: $mail enviado a: https://omwekiatl.xyz".
    "\n\n$nombre: $texto";
  mail("ojorcio@gmail.com", $mail_subject, $mail_msj, $mail_header);
}

$descripcion = "I am an electronic engineering of Universidad del Valle, born and resident of Cali - Colombia (my languaje is spanish), in my free time I develop videogames for fun, personally I am an introverted humanoid that try to life healthily.<br><br>I make games, but play a little, because I invert time in creation more than in consumption, and I spend more time in develop / work than in fun / play (so I am exigent with the quality of the games); my favorite videogames are complex estrategic, like RTS (Age of Empires, Mythology, Warcraft III, etc), RimWorld, Don't Starve, Minecraft, sometimes simulations of vehicles (GTA) or city builders (Micro Town) or The Sims...<br><br>I feel boring about smartphone casual games, they are simple and stupid, focused in make money and lost time.<br><br>I dream with make a famous videogame with high complexcity, with strong NPCs AI, with simulation of things, online conectivity, etc, etc; in other words, to create a world, a Matrix.<br><br>Note: many projects here are simulations, tools, and multimedia things more than videogames itself.";

// portafolio de proyectos
$proyectos = [
  ["BotWood", "botwood.png", "https://omwekiatl.itch.io/botwood",
    "party game for 12 players with App gamepad, handle cooperatively a giant bot to fight"],
  ["Joda Monigotica", "jodamonigotica.png", "https://omwekiatl.itch.io/jodamonigotica",
    "multiplayer strategy videogame about build a city and send things"],
  ["PelucAlvas", "pelucalvas.png", "https://omwekiatl.itch.io/pelucalvas",
    "Peluquee obreros hippies en una fábrica"],
  ["Vampiwis", "vampiwis.png", "https://omwekiatl.itch.io/vampiwis",
    "A vampire life simulator, survive as many days as you can"],
  ["Arcade Corredor", "arcadecorredor.png", "https://omwekiatl.itch.io/arcadecorredor",
    "an infinite runner casual game made in Godot, with source code"],
  ["OvniChef", "ovnichef.png", "https://omwekiatl.itch.io/ovnichef",
    "cocine a ciegas para unos alienigenas, oiga sus palabras"],
  ["Bikufir", "bikufir.png", "https://omwekiatl.itch.io/bikufir",
    "dress a character"],
  ["Cuenta Cuentos", "cuentos.png", "https://omwekiatl.itch.io/cuentacuentos",
    "librocuentos, ejemplo y herramienta"],
  ["Mini Avatar War", "avatarwar.png", "https://omwekiatl.itch.io/miniavatarwar",
    "create your avatar in a Google forms, this is a war simulation software"],
  ["Aleatory War 3", "aleatorywar.png", "https://omwekiatl.itch.io/aleatorywar3",
    "simulation of shooter to do bets or choices"],
  ["Dónde Está Mi Esposo", "esposo.png", "https://omwekiatlclass.itch.io/deee",
    "Ginna debe ir a lo profundo del infierno"],
  ["Omicrocity 1", "omicrocity.png", "https://omwekiatl.itch.io/omicrocity1",
    "city builder with amusing citizens and many buildings"],
  ["Univalle Virtual Demo", "uvv.png", "https://omwekiatl.itch.io/univallevirtual",
    "red social campus virtual gamificado"],
  ["DeviantArt", "dibujos.png", "https://www.deviantart.com/omarsaurus/gallery",
    "acá puedes ver mi galería de dibujos, en diferentes estilos"],
  ["Tutoriales", "youtube.png", "https://www.youtube.com/watch?v=xa41gLOSPKg&ab_channel=Omwekiatl",
    "en mi canal de Youtube he subido varios videos enseñando cosas de gamedev"]
];
function setProyecto($ind) {
  global $proyectos;
  $num = $ind + 1;
  $nombre = $proyectos[$ind][0];
  $img = "img_portafolio/". $proyectos[$ind][1];
  $link = $proyectos[$ind][2];
  $texto = $proyectos[$ind][3];
  echo "<!-- Proyecto $num -->".
    "<div class='col-md-4'>".
      "<div class='card mb-4 shadow-sm'>".
        "<a href='$link' target='_blank'>".
        "<img src='$img' class='card-img-top' alt='$nombre'></a>".
        "<div class='card-body'>".
          "<h5 class='card-title'>$nombre</h5>".
          "<p class='card-text'>$texto</p>".
        "</div>".
      "</div>".
    "</div>";
}
function setProyectos() {
  global $proyectos;
  echo "<div class='row'>";
  for ($i = 0; $i < count($proyectos); $i++) {
    setProyecto($i);
  }
  echo "</div>";
}

// crear habilidades lvl: 0 a 5
function setHabilidad($habilidad, $lvl) {
  $nivel = ["Iniciante", "Aprendíz", "Intermedio", "Avanzado", "Experto", "Maestro"];
  $color = ["bg-secondary", "bg-info text-dark", "bg-primary", "bg-success",
    "bg-warning text-dark", "bg-danger"];
  $i = max(0, min(5, $lvl));
  $n = $nivel[$i];
  $c = $color[$i];
  echo "<li class='list-group-item d-flex justify-content-between align-items-center'>".
    "$habilidad<span class='badge $c rounded-pill'>$n</span></li>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Omwekiatl</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .perfil-img {
      width: 200px;
      height: 200px;
      object-fit: cover;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">Omwekiatl gamedev</a>
      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="nav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="#sobre">Sobre mí</a></li>
          <li class="nav-item"><a class="nav-link" href="#habilidades">Habilidades</a></li>
          <li class="nav-item"><a class="nav-link" href="#portafolio">Portafolio</a></li>
          <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <header class="bg-primary text-white text-center py-5 mt-5">
    <div class="container">
      <img src="img_portafolio/icono.png" alt="sello omwekiatl" class="perfil-img mb-3">
      <h1 class="display-4">Omwekiatl</h1>
      <p class="lead">Ing. Electrónico | Gamedev | Creativo</p>
    </div>
  </header>

  <!-- Sobre mí -->
  <section id="sobre" class="py-5">
    <div class="container">
      <h2 class="text-center mb-4">Sobre Mí</h2>
      <div class="row justify-content-center">
        <div class="col-md-8">
          <p style="text-align: center;"><?php echo $descripcion; ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- Habilidades -->
  <section id="habilidades" class="bg-light py-5">
    <div class="container">
      <h2 class="text-center mb-4">Habilidades</h2>
      <div class="row">
        <div class="col-md-6">
          <ul class="list-group">
            <?php setHabilidad("Unity (C#)", 2); ?>
            <?php setHabilidad("Godot (GDScript)", 3); ?>
            <?php setHabilidad("Game Maker (GML)", 4); ?>
            <?php setHabilidad("Blender (3D)", 2); ?>
            <?php setHabilidad("Krita (2D)", 2); ?>
            <?php setHabilidad("Suit Office", 4); ?>
            <?php setHabilidad("Dibujo", 3); ?>
          </ul>
        </div>
        <div class="col-md-6">
          <ul class="list-group">
            <?php setHabilidad("Python", 3); ?>
            <?php setHabilidad("HTML - CSS", 2); ?>
            <?php setHabilidad("PHP - SQL", 3); ?>
            <?php setHabilidad("JavaScript", 3); ?>
            <?php setHabilidad("Java", 4); ?>
            <?php setHabilidad("Matlab", 3); ?>
            <?php setHabilidad("Arduino - C", 4); ?>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- Portafolio -->
  <section id="portafolio" class="py-5">
    <div class="container">
      <h2 class="text-center mb-4">Portafolio</h2>
      <?php setProyectos(); ?>
    </div>
  </section>

  <!-- Contacto -->
  <section id="contacto" class="bg-dark text-white py-5">
    <div class="container">
      <h2 class="text-center mb-4">Contacto</h2>
      <form class="row g-3" action="index.php" method="post">
        <div class="col-md-6">
          <input type="text" class="form-control" name="nombre" placeholder="Nombre" required>
        </div>
        <div class="col-md-6">
          <input type="email" class="form-control" name="mail" placeholder="Correo" required>
        </div>
        <div class="col-12">
          <textarea class="form-control" rows="4" name="texto" placeholder="Mensaje..." required></textarea>
        </div>
        <div class="col-12 text-center">
          <button class="btn btn-success" type="submit">Enviar</button>
        </div>
      </form>
    </div>
  </section>

  <!-- Footer -->
    <footer class="text-center text-white bg-secondary py-3">
    <small>© 2025 Omwekiatl. Todos los derechos reservados.</small>
  </footer>

  <!-- JS Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
