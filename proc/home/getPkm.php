<?php
$src="";
$showPKM = "SELECT pokemon_name, pokemon_id FROM tbl_pokemon ";
if($_POST["src"]!=""){
    $src = $_POST["src"]."%";
    $showPKM .= " WHERE pokemon_name like :src";
}
include("../conexion.php");
$stmt = $conn -> prepare($showPKM);
if($_POST["src"]!=""){
    $stmt -> bindParam(":src", $src);
}
$stmt -> execute();
$Allpkm = $stmt -> fetchAll();
if($stmt ->rowCount()==0){
    echo "Sin resultados";
}else{
    echo json_encode($Allpkm);
}

