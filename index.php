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
<body>
    <!-- Marco de la pantalla -->
    <div id="panelfixed"></div>
    <!-- Buscador -->
    <div class="search">
        <input id="searchinput" type="text" name="pokemon" onkeyup="getPkm()" placeholder="Buscar Pokemon...">
        <input type="image" src="./resources/interfaz/searchButton.png" alt="Submit" id="searchButton">
    </div>
    <!-- Lista de pokemons -->
        <div id="container">
        </div>
        <!-- Margen de abajo -->
        <br>
        <br>
    <script src="./js/index.js"></script>
    <!-- Cargar todos lo spokemons -->
    <script>
        window.onload = getPkm();
    </script>
</body>
</html>