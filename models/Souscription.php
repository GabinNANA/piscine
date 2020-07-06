<?php
class Souscription extends BaseModel {
    public static $tableName='souscription';
    public function __construct(){
    	
    }
    public static function ajouter()
    {
    	global $BD;

        $result = array();
        
        $montant=$_REQUEST["montant"];

        if($_REQUEST["type"]==1){
            $montant=$_REQUEST["montant"]*$_REQUEST["nbre"];
        }

        if($montant>=$_REQUEST["avance"]){
            $sql = $BD->prepare("INSERT INTO `souscription`(`idemploye`,`idclient`,`avance`,`type`, `date`,`nbre`, `reste`) VALUES (?,?,?,?,?,?,?)");
            $sql->execute(array(null($_REQUEST["employe"]),$_REQUEST["client"],$_REQUEST["avance"],$_REQUEST["type"],$_REQUEST["date"],
            $_REQUEST["nbre"],($montant-zero($_REQUEST["avance"]))))
            or die("Erreur : " . $sql->errorInfo()[2]);

            if($_REQUEST["avance"]>0){
                $intitule="Avance pour souscription a un abonnement";

                if($_REQUEST["type"]==0){
                    $intitule="Avance pour souscription a une formation";
                }
                $caisse=caisse::get(Prix::get('3')->idcaisse);
                $totalversement = $caisse->totalversement + $_REQUEST["avance"];
                $actuel = $caisse->solde + $_REQUEST["avance"];
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
                    2,
                    Prix::get('3')->idcaisse,
                    $intitule,
                    $_REQUEST["avance"],
                    0,
                    $actuel,
                    date("Y-m-d"),
                    ''
                )) or die("Erreur : " . $req->errorInfo()[2]);
                $ido= $BD->lastInsertId();
                
                $req2 = $BD->prepare("UPDATE caisse SET totalversement = ?, solde = ? WHERE id = ?");
                $req2->execute(array(
                    $totalversement,$actuel, Prix::get('3')->idcaisse
                )) or die("Erreur : " . $req2->errorInfo()[2]);
            }

            $result['state'] = "success";
        }else{

            $result['state'] = "error";
            $result['reason'] = "L'avance est supérieur au cout total";
        }
        echo json_encode($result);

    }

    public static function modifier()
    {
        global $BD;

        $id = $_REQUEST["id"];
        $abonnement=Souscription::get($id);
        $result = array();
        $montant=$abonnement->reste;
        $nbre=$abonnement->nbre;
        if($abonnement->type=='0'){
            $nbre=$_REQUEST["nbre"];
        }

        if($montant>=$_REQUEST["avance"]){
            $avance=$abonnement->avance+zero($_REQUEST["avance"]);

            $sql = $BD->prepare("UPDATE `souscription` SET `idclient`=?,`idemploye`=?,`nbre`=?,`avance`=?,`date`=?, `reste`=? WHERE `id`=?");
            $sql->execute(array($_REQUEST["client"],$_REQUEST["employe"],$nbre,$avance,$_REQUEST["date"],($montant-zero($_REQUEST["avance"])),$id))

            or die("Erreur : " . $sql->errorInfo()[2]);

            if($_REQUEST["avance"]>0){
                $intitule="Avance pour souscription a un abonnement";

                if($_REQUEST["type"]==0){
                    $intitule="Avance pour souscription a une formation";
                }
                $caisse=caisse::get(Prix::get('3')->idcaisse);
                $totalversement = $caisse->totalversement + $_REQUEST["avance"];
                $actuel = $caisse->solde + $_REQUEST["avance"];
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
                    2,
                    Prix::get('3')->idcaisse,
                    $intitule,
                    $_REQUEST["avance"],
                    0,
                    $actuel,
                    date("Y-m-d"),
                    ''
                )) or die("Erreur : " . $req->errorInfo()[2]);
                $ido= $BD->lastInsertId();
                
                $req2 = $BD->prepare("UPDATE caisse SET totalversement = ?, solde = ? WHERE id = ?");
                $req2->execute(array(
                    $totalversement,$actuel, Prix::get('3')->idcaisse
                )) or die("Erreur : " . $req2->errorInfo()[2]);
            }

            $result['state'] = "success";
        }else{

            $result['state'] = "error";
            $result['reason'] = "L'avance est supérieur au reste a payer";
        }
        echo json_encode($result);
    }

    public static function supprimer()
    {
        global $BD;
        $result = array();

        $insert = $BD->query("DELETE FROM souscription WHERE id IN (".$_REQUEST["id"].")");
        $result['state'] = "success";

        echo json_encode($result);
        
    }

}