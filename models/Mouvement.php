<?php
class Mouvement extends BaseModel {
    public static $tableName='mouvement';
    public function __construct(){
    	
    }
    public static function encaiss(){
        global $BD;
        $getid = $BD->query("SELECT max(id) as id FROM mouvement");
        if ($getid->rowCount() == 0) {
            $id=1;
        }
        else{
            $getiid = $getid->fetch();
            $id=$getiid["id"]+1;
        }
        $string=aleatoire(5);
        if (isset($_FILES["image"]) AND strlen($_FILES["image"]["name"])>0) {
            $folder = 'image/transaction/';

            $tmp_name = $_FILES["image"]["tmp_name"];

            $name = $_FILES["image"]["name"];

            $img = pathinfo($_FILES["image"]['name']);
            $image = "document".$id.$string.'.'.$img["extension"];
           move_uploaded_file($tmp_name, $folder.$image);
        }
        else
        {
          $image = "";
        }

        $caisse=caisse::get($_REQUEST["caisse"]);
        $totalversement = $caisse->totalversement + $_REQUEST["montant"];
        $actuel = $caisse->solde + $_REQUEST["montant"];
        $req = $BD->prepare("INSERT INTO mouvement (
            operation,
            type_operation,
            idcaisse,
            intitule,
            recette,
            depense,
            solde,
            date,
            justificatif
        ) VALUES (?,?,?,?,?,?,?,?,?) ");
        $req->execute(array(
            0,
            5,
            $_REQUEST["caisse"],
            $_REQUEST["intitule"],
            $_REQUEST["montant"],
            0,
            $actuel,
            $_REQUEST["date"],
            $image
        )) or die("Erreur : " . $req->errorInfo()[2]);
        $ido= $BD->lastInsertId();
        
        $req2 = $BD->prepare("UPDATE caisse SET totalversement = ?, solde = ? WHERE id = ?");
        $req2->execute(array(
            $totalversement,$actuel, $_REQUEST["caisse"]
        )) or die("Erreur : " . $req2->errorInfo()[2]);
        
        $result['state'] = "success";

        echo json_encode($result);
    }

    public static function decaiss(){
        global $BD;
        $result = array();
        $caisse=caisse::get($_REQUEST["caisse"]);
        $totaldepense = $caisse->totaldepense + $_REQUEST["montant"];
        $actuel = $caisse->solde - $_REQUEST["montant"];
        if($actuel>0){
            $suite='';

            $getid = $BD->query("SELECT max(id) as id FROM mouvement");
            if ($getid->rowCount() == 0) {
                $id=1;
            }
            else{
                $getiid = $getid->fetch();
                $id=$getiid["id"]+1;
            }
            $string=aleatoire(5);
            if (isset($_FILES["image"]) AND strlen($_FILES["image"]["name"])>0) {
                $folder = 'image/transaction/';

                $tmp_name = $_FILES["image"]["tmp_name"];

                $name = $_FILES["image"]["name"];

                $img = pathinfo($_FILES["image"]['name']);
                $image = "document".$id.$string.'.'.$img["extension"];
                move_uploaded_file($tmp_name, $folder.$image);
            }else{
                $image = "";
            }

            $req = $BD->prepare("INSERT INTO mouvement (
                operation,
                type_operation,
                idcaisse,
                intitule,
                recette,
                depense,
                solde,
                date,
                justificatif
            ) VALUES (?,?,?,?,?,?,?,?,?) ");
            $req->execute(array(
                1,
                5,
                $_REQUEST["caisse"],
                $_REQUEST["intitule"],
                0,
                $_REQUEST["montant"],
                $actuel,
                $_REQUEST["date"],
                $image
            )) or die("Erreur : " . $req->errorInfo()[2]);
            $ido= $BD->lastInsertId();
            
            $req2 = $BD->prepare("UPDATE caisse SET totaldepense = ?, solde = ? WHERE id = ?");
            $req2->execute(array(
                $totaldepense,$actuel, $_REQUEST["caisse"]
            )) or die("Erreur : " . $req2->errorInfo()[2]);
            $result['state'] = "success";
        }
        else{

            $result['state'] = "error";
            $result['reason'] = 'La somme retirée est supérieur au solde du compte';
        }      
        echo json_encode($result);
    }
    public static function transfert(){
        global $BD;
        $result = array();
        $caisse=caisse::get($_REQUEST["source"]);
        $totaldepense = $caisse->totaldepense + $_REQUEST["montant"];
        $actuel = $caisse->solde - $_REQUEST["montant"];

        $caissedest=caisse::get($_REQUEST["destination"]);
        $totalversement = $caissedest->totalversement + $_REQUEST["montant"];
        $actueldest = $caissedest->solde + $_REQUEST["montant"];
        if($actuel>0){
            $suite='Transfert de '.$caisse->intitule.' vers '.$caissedest->intitule.' ';

            $getid = $BD->query("SELECT max(id) as id FROM mouvement");
            if ($getid->rowCount() == 0) {
                $id=1;
            }
            else{
                $getiid = $getid->fetch();
                $id=$getiid["id"]+1;
            }
            $string=aleatoire(5);
            if (isset($_FILES["image"]) AND strlen($_FILES["image"]["name"])>0) {
                $folder = 'image/transaction/';

                $tmp_name = $_FILES["image"]["tmp_name"];

                $name = $_FILES["image"]["name"];

                $img = pathinfo($_FILES["image"]['name']);
                $image = "document".$id.$string.'.'.$img["extension"];
            move_uploaded_file($tmp_name, $folder.$image);
            }
            else
            {
            $image = "";
            }

            $req = $BD->prepare("INSERT INTO mouvement (
                operation,
                type_operation,
                idcaisse,
                intitule,
                recette,
                depense,
                solde,
                date,
                justificatif
            ) VALUES (?,?,?,?,?,?,?,?,?) ");
            $req->execute(array(
                2,
                5,
                $_REQUEST["source"],
                $suite,
                0,
                $_REQUEST["montant"],
                $actuel,
                $_REQUEST["date"],
                $image
            )) or die("Erreur : " . $req->errorInfo()[2]);
            $ido= $BD->lastInsertId();
            
            $req2 = $BD->prepare("UPDATE caisse SET totaldepense = ?, solde = ? WHERE id = ?");
            $req2->execute(array(
                $totaldepense,$actuel, $_REQUEST["source"]
            )) or die("Erreur : " . $req2->errorInfo()[2]);

            $req = $BD->prepare("INSERT INTO mouvement (
                operation,
                type_operation,
                idcaisse,
                intitule,
                recette,
                depense,
                solde,
                date,
                justificatif
            ) VALUES (?,?,?,?,?,?,?,?,?) ");
            $req->execute(array(
                2,
                5,
                $_REQUEST["destination"],
                $suite,
                $_REQUEST["montant"],
                0,
                $actueldest,
                $_REQUEST["date"],
                $image
            )) or die("Erreur : " . $req->errorInfo()[2]);
            $ido= $BD->lastInsertId();
            
            $req2 = $BD->prepare("UPDATE caisse SET totalversement = ?, solde = ? WHERE id = ?");
            $req2->execute(array(
                $totalversement,$actueldest, $_REQUEST["destination"]
            )) or die("Erreur : " . $req2->errorInfo()[2]);

            $result['state'] = "success";
        }
        else{

            $result['state'] = "error";
            $result['reason'] = 'La somme retirée est supérieur au solde du compte';
        }      
        echo json_encode($result);
    }
    public static function destination(){
        global $BD;

        $result = array();

        $result['info'] = '';

        foreach (caisse::q()->where("id!=?",$_REQUEST["val"])->execute() as $caisse) { 
            $result['info'] .='<option value="'.$caisse->id.'">'.$caisse->intitule.'</option>';
        } 
        
        echo json_encode($result);
    }

    public static function entree(){
        global $BD;
        $image = "";

        for ($i=0; $i <$_REQUEST["nombre"] ; $i++) { 
            $caisse=caisse::get(Prix::get('1')->idcaisse);
            $totalversement = $caisse->totalversement + Prix::get('1')->prix;
            $actuel = $caisse->solde + Prix::get('1')->prix;
            $req = $BD->prepare("INSERT INTO mouvement (
                operation,
                type_operation,
                idcaisse,
                intitule,
                recette,
                depense,
                solde,
                date,
                justificatif
            ) VALUES (?,?,?,?,?,?,?,?,?) ");
            $req->execute(array(
                0,
                6,
                Prix::get('1')->idcaisse,
                "Payement à l'entrée",
                Prix::get('1')->prix,
                0,
                $actuel,
                date("Y-m-d"),
                $image
            )) or die("Erreur : " . $req->errorInfo()[2]);
            $ido= $BD->lastInsertId();
            
            $req2 = $BD->prepare("UPDATE caisse SET totalversement = ?, solde = ? WHERE id = ?");
            $req2->execute(array(
                $totalversement,$actuel, Prix::get('1')->idcaisse
            )) or die("Erreur : " . $req2->errorInfo()[2]);
        }
        $result['state'] = "success";

        echo json_encode($result);
    }
}