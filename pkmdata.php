<?php
    // comprobamos si se pasa un id
    if(!isset($_GET["id"])){
        header("Location: ./");
        exit;
    }
    include("./proc/conexion.php");
    $id = $_GET["id"];
    // Consulta para sacar datos del pokemon
    $pkmData = "SELECT p.pokemon_name AS 'Nombre',p.pokemon_description AS 'desc', p.pokemon_categoria AS 'Categoría', a.ability_name_es AS 'Habilidad1', a2.ability_name_es AS 'Habilidad2', a3.ability_name_es AS 'HabilidadOculta', t.type_name AS 'Tipo principal',p.pokemon_type1 AS 'tipo1',p.pokemon_type2 AS 'tipo2', t2.type_name AS 'Tipo secundario', r.region_name AS 'Región' FROM tbl_pokemon `p` LEFT JOIN tbl_types `t` ON p.pokemon_type1 = t.type_id LEFT JOIN tbl_types `t2` ON p.pokemon_type2 = t2.type_id LEFT JOIN tbl_region `r` ON p.pokemon_region = r.region_id LEFT JOIN tbl_ability `a` ON p.pokemon_ability1 = a.ability_id LEFT JOIN tbl_ability `a2` ON p.pokemon_ability2 = a2.ability_id LEFT JOIN tbl_ability `a3` ON p.pokemon_ability3 = a3.ability_id WHERE p.pokemon_id = :id LIMIT 1";
    $stmt = $conn -> prepare($pkmData);
    $stmt -> bindParam(":id", $id);
    $stmt -> execute();
    $pkm = $stmt ->fetch();
    $icon = "./resources/icon/$id.png";
    if($pkm["Habilidad1"]!="" && $pkm["Habilidad2"]!=""){
        $hab = $pkm["Habilidad1"]." - ".$pkm["Habilidad2"];
    }else{
        $hab = $pkm["Habilidad1"];
    }
    if($pkm["tipo1"]!="" && $pkm["tipo2"] != ""){
        $tipo1 = $pkm["tipo1"];
        $tipo2 = $pkm["tipo2"];
        $tipo = "<img class='imgTipo' style='margin-right:7%' src='./resources/tipos/$tipo1.png' alt='' srcset=''><img class='imgTipo' src='./resources/tipos/$tipo2.png' alt='' srcset=''>";
    }else{
        $tipo1 = $pkm["tipo1"];
        $tipo = "<img class='imgTipo' src='./resources/tipos/$tipo1.png' alt='' srcset=''>";
    }
    if($pkm["HabilidadOculta"]!=""){
        $habOculta = $pkm["HabilidadOculta"];
    }else{
        $habOculta = "No tiene";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./resources/css/styles.css">
    <link rel='icon' type='image/x-icon' href="<?php echo $icon; ?>">
    <title><?php echo $pkm["Nombre"];?></title>
</head>
<body>
    <!-- Marco y margen de arriba -->
    <div id="panelfixed"></div>
    <div id="margen-top"></div>
    <!-- contenedor con los datos -->
    <div id="containerData">
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="dataContainer">
                        <!-- INFO GENERAL -->
                        <div class="row">
                            <div class="col-4">
                                <img id="pkIMG" src="./resources/sprite/<?php echo $id ?>.png" alt="" srcset="">
                            </div>
                            <div class="col-8">
                                <h1 id="pkmTitulo">Información general</h1>
                                <div class="row">
                                    <div class="col-6">
                                        <h2>Nombre</h2>
                                            <p class="pkmSubTitulo pkmSub1"><?php echo $pkm["Nombre"]; ?></p>
                                        <h2>Categoría</h2>
                                            <p class="pkmSubTitulo pkmSub1"><?php echo $pkm["Categoría"]; ?></p>
                                        <h2>Región</h2>
                                            <p class="pkmSubTitulo pkmSub1"><?php echo $pkm["Región"]; ?></p>
                                    </div>
                                    <div class="col-6">
                                        <h2 class="subtitulo2">Habilidades</h2>
                                            <p class="pkmSubTitulo pkmSub2"><?php echo $hab; ?></p>
                                        <h2 class="subtitulo2">Habilidad oculta</h2>
                                            <p class="pkmSubTitulo pkmSub2"><?php echo $habOculta;?></p>
                                        <h2 class="subtitulo2">Tipos</h2>
                                            <?php echo $tipo; ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <hr>
                        <p id="desTxt"><?php echo $pkm["desc"]; ?></p>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="dataContainer">
                        <!-- STATS -->
                        <h1>prueba2</h1>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="dataContainer">
                        <!-- EVOLUCIÓN -->
                        <h1>prueba3</h1>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</body>
</html>