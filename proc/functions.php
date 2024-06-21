<?php    
    function getEvoData($id){
        include("conexion.php");
        $query = "SELECT m.nom_metodo, o.nom_objeto, evo.evo_level FROM tbl_evolution `evo` LEFT JOIN tbl_evo_metodo `m` ON evo_metodo = m.id_metodo LEFT JOIN tbl_objeto `o` ON evo_objeto = o.id_objeto WHERE evo.evo_poke_id = :id";
        $data = $conn -> prepare($query);
        $data -> bindParam(":id", $id);
        $data -> execute();
        return $data ->fetchAll();
    }
    function formarFraseEvo($array){
        $frase=[];
        $fraseTemp="";
        foreach ($array as $evo) {
            // return "ENTRA";
            if($evo["evo_level"] != NULL){
                $fraseTemp = "Evoluciona al nivel ".$evo["evo_level"];
            }else{
                $fraseTemp = "Evoluciona por ".$evo["nom_metodo"]." ";
                if($evo["nom_objeto"] != NULL){
                    $fraseTemp .=$evo["nom_objeto"];
                }
            }
            array_push($frase, $fraseTemp);
        }
        return $frase;
    }

