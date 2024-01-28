<?php
// var_dump($_POST);
$src="";
if($_POST["src"]!=""){
    $src = $_POST["src"]."%";
    $showPKM = "SELECT pokemon_name, pokemon_id FROM tbl_pokemon WHERE pokemon_name like :src";
}else{
    $showPKM = "SELECT pokemon_name, pokemon_id FROM tbl_pokemon";
}
include("../conexion.php");
$stmt = $conn -> prepare($showPKM);
$stmt -> bindParam(":src", $src);
$stmt -> execute();
$Allpkm = $stmt -> fetchAll();
echo json_encode($Allpkm);

