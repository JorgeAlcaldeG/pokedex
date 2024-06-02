<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./resources/css/styles.css">
    <link rel='icon' type='image/x-icon' href='./resources/interfaz/mainIcon.png'>
    <title>Pokedex</title>
</head>
<body class="fondo1">
    <?php include("modal.php");?>
    <!-- Marco de la pantalla -->
    <div id="panelfixed"></div>
    <!-- Buscador -->
    <img src="./resources/interfaz/configBtn.png" class="configBtn rotate" data-bs-toggle="modal" data-bs-target="#configModal" id="configBtn">
    <div class="search">
        <input id="searchinput" type="text" name="pokemon" onkeyup="getPkm()" placeholder="Buscar Pokemon...">
    </div>
    <!-- Lista de pokemons -->
    <div id="container">
    </div>
    <!-- Margen de abajo -->
    <br>
    <br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
    <script src="./js/index.js"></script>
    <script src="./js/updateFrame.js"></script>
    <script src="./js/bgMove.js"></script>
</body>
</html>