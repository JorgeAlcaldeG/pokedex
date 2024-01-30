<?php
$src="";
// Buscamos los pokemons con los filtros que se están pasando
$showPKM = "SELECT pokemon_name, pokemon_id FROM tbl_pokemon ";
// Si el buscadr devuelve un dato
if($_POST["src"]!=""){
    $src = $_POST["src"]."%";
    $showPKM .= " WHERE pokemon_name like :src";
}
include("../conexion.php");
$stmt = $conn -> prepare($showPKM);
if($_POST["src"]!=""){
    // Añadimos el parametro
    $stmt -> bindParam(":src", $src);
}
$stmt -> execute();
$Allpkm = $stmt -> fetchAll();
// Comprobamos si se deveulve algún dato o no
if($stmt ->rowCount()==0){
    echo "Sin resultados";
}else{
    echo json_encode($Allpkm);
}

