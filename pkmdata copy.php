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
    // Info de la habilidad 1
    $sqlhab = "SELECT ability_desc FROM tbl_ability WHERE ability_name_es = :hab";
    $stmthab = $conn -> prepare($sqlhab);
    $stmthab ->bindParam(":hab",$pkm["Habilidad1"]);
    $stmthab ->execute();
    $hab1 = $stmthab -> fetchColumn();
    if($pkm["Habilidad2"]!=""){
        $hab = $pkm["Habilidad1"]." - ".$pkm["Habilidad2"];
        $sqlhab = "SELECT ability_desc FROM tbl_ability WHERE ability_name_es = :hab";
        $stmthab = $conn -> prepare($sqlhab);
        $stmthab ->bindParam(":hab",$pkm["Habilidad2"]);
        $stmthab ->execute();
        $hab2 = $stmthab -> fetchColumn();
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
        if($pkm["Habilidad2"]!=""){
            $hab = $pkm["Habilidad1"]." - ".$pkm["Habilidad2"];
        }else{
            $hab = $pkm["Habilidad1"];
        }
        $sqlhab = "SELECT ability_desc FROM tbl_ability WHERE ability_name_es = :hab";
        $stmthab = $conn -> prepare($sqlhab);
        $stmthab ->bindParam(":hab",$habOculta);
        $stmthab ->execute();
        $habOc = $stmthab -> fetchColumn();
    }else{
        $habOculta = "No tiene";
    }
    // Stats
    $statsQuery = "SELECT * FROM tbl_stats WHERE stats_id = :id";
    $stmtStats = $conn -> prepare($statsQuery);
    $stmtStats -> bindParam(":id", $id);
    $stmtStats -> execute();
    $stats = $stmtStats ->fetch();

    $natuSQL = "SELECT * FROM tbl_naturalezas";
    $natuStmt = $conn ->prepare($natuSQL);
    $natuStmt -> execute();
    $naturalezas = $natuStmt ->fetchAll();
    // Evoluciones
    $evoSQL = "SELECT e.evo_preevo AS 'preevoID',p1.pokemon_name AS 'preevoName',
    p2.pokemon_name AS 'evoName',e.evo_evoin AS 'evoID' FROM tbl_evolution `e` 
    LEFT JOIN tbl_pokemon `p1` ON e.evo_preevo = p1.pokemon_id 
    LEFT JOIN tbl_pokemon `p2` ON e.evo_evoin = p2.pokemon_id
    WHERE evo_poke_id = :id"; 
    $stmtEvo = $conn -> prepare($evoSQL);
    $stmtEvo -> bindParam(":id", $id);
    $stmtEvo -> execute();
    $evo = $stmtEvo ->fetchAll();
    $preevoId = $evo[0]["preevoID"];
    $preevoName = $evo[0]["preevoName"];
    // $evoId = $evo[0]["evoID"];

    $evoData = '<div id = "evoContainer">';
    $noEvo = "";
    if($preevoId == NULL && $evo[0]["evoID"] == NULL){
        $noEvo = "Este pokemon no tiene linea evolutiva.";
    }
    if($preevoId != NULL && $evo[0]["evoID"] != NULL){
        $style = "fullEvo";
    }else{
        $style = "evo";
    }
    if($preevoId != NULL){
        $evoData .= "<div class='bloqueEvo'><img class='".$style."' src='./resources/sprite/$preevoId.png'></div>";
        $evoData .= "<div class='bloqueEvo'><img class='".$style."' src='./resources/interfaz/flecha.png'></div>";
    }
    $evoData .= "<div class='bloqueEvo'><img class='".$style."' src='./resources/sprite/$id.png'></div>";
    if($stmtEvo ->rowCount() >1){
        $evoData .= "<div class='bloqueEvo'><img class='".$style."' src='./resources/interfaz/flecha.png'></div>";
        foreach ($evo as $evoIn) {
            if($evoIn["evoID"] != NULL){
                $evoID = $evoIn["evoID"];
                $evoData .= "<div class='bloqueEvo'><img class='".$style."' src='./resources/sprite/$evoID.png'></div>";
                $evoData .= "<div class='bloqueEvo'><img class='".$style."' src='./resources/interfaz/flecha.png'></div>";
                $evoData .="</br>";
            }
        }
    }else{
        if($evo[0]["evoID"] != NULL){
            $evoData .= "<div class='bloqueEvo'><img class='".$style."' src='./resources/interfaz/flecha.png'></div>";
            $evoID = $evo[0]["evoID"];
            $evoData .= "<div class='bloqueEvo'><img class='".$style."' src='./resources/sprite/$evoID.png'></div>";
        }
    }
    if($noEvo != ""){
        $evoData .= "<p>$noEvo</p>";
    }
    $evoData .= '</div>';
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
<body class="fondo1">
    <input type="hidden" name="vida" id="vida"value=<?php echo $stats["ps"] ?>>
    <input type="hidden" name="atk" id="atk"value=<?php echo $stats["atk"] ?>>
    <input type="hidden" name="def" id="def"value=<?php echo $stats["def"] ?>>
    <input type="hidden" name="spa" id="spa"value=<?php echo $stats["spa"] ?>>
    <input type="hidden" name="spd" id="spd"value=<?php echo $stats["spd"] ?>>
    <input type="hidden" name="spe" id="spe"value=<?php echo $stats["spe"] ?>>
    <img src="./resources/interfaz/back.png" id="backBtn">
    <!-- Marco y margen de arriba -->
    <div id="panelfixed" class="marco1"></div>
    <div id="margen-topData"></div>
    <!-- contenedor con los datos -->
    <div id="containerData">
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="dataContainer">
                        <!-- INFO GENERAL -->
                        <div class="row">
                            <div class="col-4">
                                <img id="pkIMG" src="./resources/sprite/<?php echo $id ?>.png" alt="" srcset="" onclick="playCry(<?php echo $id ?>)">
                                <p class="info">Pulsa la imagen para reproducir su grito</p>
                            </div>
                            <div class="col-8">
                                <h1 class="pkmTitulo">Información general</h1>
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
                        <div class="row">
                            <div class="col-4">
                                <h1 class="pkmTitulo">Stats base</h1>
                                <div id="statsContainer">
                                    <!-- Vida -->
                                    <p class="infostat">Vida - <strong><?php echo $stats["ps"] ?></strong></p>
                                    <div class="barrita" style="width: <?php echo $stats["ps"]*1.2 ?>px"></div>
                                    <!-- Ataque -->
                                    <p class="infostat">Ataque - <strong><?php echo $stats["atk"] ?></strong></p>
                                    <div class="barrita" style="width: <?php echo $stats["atk"]*1.2 ?>px"></div>
                                    <!-- Defensa -->
                                    <p class="infostat">Defensa - <strong><?php echo $stats["def"] ?></strong></p>
                                    <div class="barrita" style="width: <?php echo $stats["def"]*1.2 ?>px"></div>
                                    <!-- Ataque ESP -->
                                    <p class="infostat">Ataque esp. - <strong><?php echo $stats["spa"] ?></strong></p>
                                    <div class="barrita" style="width: <?php echo $stats["spa"]*1.2 ?>px"></div>
                                    <!-- Defensa ESP -->
                                    <p class="infostat">Defensa esp. - <strong><?php echo $stats["spd"] ?></strong></p>
                                    <div class="barrita" style="width: <?php echo $stats["spd"]*1.2 ?>px"></div>
                                    <!-- Velocidad -->
                                    <p class="infostat">Velocidad - <strong><?php echo $stats["spe"] ?></strong></p>
                                    <div class="barrita" style="width: <?php echo $stats["spe"]*1.2 ?>px"></div>
                                    <!-- Total -->
                                    <p class="infostat">Total - <strong><?php echo $stats["total"] ?></strong></p>
                                    <!-- <div class="barrita" style="width: <?php echo $stats["total"]*1.5 ?>px; background-color:green"></div> -->
                                </div>
                            </div>
                            <div class="col-8">
                                <!-- <h1 class="pkmTitulo">Calculadora de stats</h1>  -->
                                <div id="calContainer">
                                    <select name="natu" id="natu">
                                        <option value="0">Naturalezas</option>
                                        <?php
                                            foreach ($naturalezas as $natu) {
                                                if($natu["sube"] ==""){
                                                    echo'<option value="0">'.$natu["nom_natu"].' (neutra)</strong></option>';
                                                }else{
                                                    echo'<option value="'.$natu["sube"].'-'.$natu["baja"].'">'.$natu["nom_natu"].' (+'.$natu["sube"].'-'.$natu["baja"].')</strong></option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                    <label for="lvl">Nivel:</label>
                                    <input type="number" name="lvl" id="lvl" value="50" class="statsInput">
                                    <br>
                                    <br>
                                    <table class="calctable">
                                        <tr>
                                            <td width="15%"> </td>
                                            <td class="headerTbl">Ivs</td>
                                            <td> </td>
                                            <td> </td>
                                            <td class="headerTbl">Evs</td>
                                            <td class="headerTbl">Total</td>
                                        </tr>
                                        <!-- Vida -->
                                        <tr>
                                            <td><label for="Vida" class="statLabel">Vida</label></td>
                                            <td><input type="number"id="hpIv"value = 31 min=0 max=31 class="statsInputTable"></td>
                                            <td><input type="range"min=0 max=252 value=0 oninput="document.getElementById('hpEv').value = this.value" id="hprange"></td>
                                            <td> </td>
                                            <td><input type="number"value = 0 max=252 id="hpEv" min=0 oninput="document.getElementById('hprange').value = this.value" class="statsInputTable2"></td>
                                            <td><input type="number"value = 0 onKeyDown="return false" class="statsInputTable2" id="hpTotal"></td>
                                        </tr>
                                        <!-- Ataque -->
                                        <tr>
                                            <td><label for="Ataque" class="statLabel">Ataque</label></td>
                                            <td><input type="number"id="AtkIv"value = 31 min=0 max=31 class="statsInputTable"></td>
                                            <td><input type="range"min=0 max=252 value=0 oninput="document.getElementById('AtkEv').value = this.value" id="Atkrange"></td>
                                            <td> </td>
                                            <td><input type="number"value = 0 max=252 id="AtkEv" min=0 oninput="document.getElementById('Atkrange').value = this.value" class="statsInputTable2"></td>
                                            <td><input type="number"value = 0 onKeyDown="return false" class="statsInputTable2" id="AtkTotal"></td>
                                        </tr>
                                        <!-- Defensa -->
                                        <tr>
                                            <td><label for="Defensa" class="statLabel">Defensa</label></td>
                                            <td><input type="number"id="defIv"value = 31 min=0 max=31 class="statsInputTable"></td>
                                            <td><input type="range"min=0 max=252 value=0 oninput="document.getElementById('defEv').value = this.value" id="defrange"></td>
                                            <td> </td>
                                            <td><input type="number"value = 0 max=252 id="defEv" min=0 oninput="document.getElementById('defrange').value = this.value" class="statsInputTable2"></td>
                                            <td><input type="number"value = 0 onKeyDown="return false" class="statsInputTable2" id="defTotal"></td>
                                        </tr>
                                        <!-- Ataque esp -->
                                        <tr>
                                            <td><label for="spA" class="statLabel">Atk esp.</label></td>
                                            <td><input type="number"id="spaIv"value = 31 min=0 max=31 class="statsInputTable"></td>
                                            <td><input type="range"min=0 max=252 value=0 oninput="document.getElementById('spaEv').value = this.value" id="sparange"></td>
                                            <td> </td>
                                            <td><input type="number"value = 0 max=252 id="spaEv" min=0 oninput="document.getElementById('sparange').value = this.value" class="statsInputTable2"></td>
                                            <td><input type="number"value = 0 onKeyDown="return false" class="statsInputTable2" id="spaTotal"></td>
                                        </tr>
                                        <!-- Defensa esp -->
                                        <tr>
                                            <td><label for="spD" class="statLabel">Def esp.</label></td>
                                            <td><input type="number"id="spdIv"value = 31 min=0 max=31 class="statsInputTable"></td>
                                            <td><input type="range"min=0 max=252 value=0 oninput="document.getElementById('spdEv').value = this.value" id="spdrange"></td>
                                            <td> </td>
                                            <td><input type="number"value = 0 max=252 id="spdEv" min=0 oninput="document.getElementById('spdrange').value = this.value" class="statsInputTable2"></td>
                                            <td><input type="number"value = 0 onKeyDown="return false" class="statsInputTable2" id="spdTotal"></td>
                                        </tr>
                                        <!-- Velocidad -->
                                        <tr>
                                            <td><label for="spe" class="statLabel">Velocidad</label></td>
                                            <td><input type="number"id="speIv"value = 31 min=0 max=31 class="statsInputTable"></td>
                                            <td><input type="range"min=0 max=252 value=0 oninput="document.getElementById('speEv').value = this.value" id="sperange"></td>
                                            <td> </td>
                                            <td><input type="number"value = 0 max=252 id="speEv" min=0 oninput="document.getElementById('sperange').value = this.value" class="statsInputTable2"></td>
                                            <td><input type="number"value = 0 onKeyDown="return false" class="statsInputTable2" id="speTotal"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td> </td>
                                            <td class="statLabel">Totales</td>
                                            <td><input type="number" name="totalEv" id="totalEv"class="statsInputTable2"></td>
                                            <td><input type="number" name="total" id="total"class="statsInputTableTotal"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- Habilidades -->
                        <div class="row rowDesc">
                            <div class="col">
                                <p class="habTitulo"><?php echo $pkm["Habilidad1"]; ?></p>
                                <p class="habDesc"><?php echo $hab1; ?></p>
                            </div>
                            <?php
                                if($pkm["Habilidad2"] !=""){
                                    echo'<div class="col">';
                                    echo'<p class="habTitulo">'.$pkm["Habilidad2"].'</p>';
                                    echo '<p class="habDesc">'.$hab2.'</p>';
                                    echo'</div>';
                                }
                                if($pkm["HabilidadOculta"] !=""){
                                    echo'<div class="col">';
                                    echo'<p class="habTitulo">'.$pkm["HabilidadOculta"].'</p>';
                                    echo '<p class="habDesc">'.$habOc.'</p>';
                                    echo'</div>';
                                }

                            ?>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="dataContainer">
                        <!-- EVOLUCIÓN -->
                        <h1>Evoluciones</h1>
                        <div class="row evoRow">
                        <?php echo $evoData; ?>
                        </div>
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
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
    <script src="./js/pkmData.js"></script>
    <script src="./js/updateFrame.js"></script>
    <script src="./js/bgMove.js"></script>
    <script>window.onload = ()=>{ 
        getStats();
        updateFrame();
        }
    </script>
</body>
</html>