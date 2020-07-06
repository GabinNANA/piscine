<?php
class Produit_commande extends BaseModel {
    public static $tableName='produit_commande';
    public function __construct(){
    	
    }
}
class Commande extends BaseModel {
    public static $tableName='commande';
    public function __construct(){
    	
    }

    public static function ajouter()
    {
        global $BD;
        $stock=1;
        if(isset($_REQUEST["boisson"])){
            $nbre=$_REQUEST["boisson"];
            foreach($nbre as $i){ 
                if(enstock($i)<$_REQUEST["quantiteb".$i]){
                    $stock=0;
                }
            }
        }

        if($stock==1 and (isset($_REQUEST["repas"][0]) or isset($_REQUEST["repas"][0])) ){
            if($_REQUEST["servi"]==1){
                $serveur2=$_REQUEST["servi"];
            }else{
                $serveur2=NULL;
            }
            $sql = $BD->prepare("INSERT INTO `commande`(`idtable`, `type`, `servi`, `paye`,`idserveur1`,`idserveur2`, `date`, `heuredeb`) VALUES (?,?,?,?,?,?,?,?)");
            $sql->execute(array($_REQUEST["table"],1,$_REQUEST["servi"],$_REQUEST["paye"],$_SESSION["idpiscine"],$serveur2,date("Y-m-d"),date("H:i:s")))
            or die("Erreur : " . $sql->errorInfo()[2]);
            $id=$BD->lastInsertId();

            $montant =0;
            if(isset($_REQUEST["repas"])){
                $nbre=$_REQUEST["repas"];
                foreach($nbre as $i){ 
                    $plat=Plat::get($i);
                    $sql = $BD->prepare("INSERT INTO `produit_commande`(`idelement`,`type_element`,`quantite`,`idcommande`) VALUES (?,?,?,?)");
                    $sql->execute(array($i,1,$_REQUEST["quantitep".$i],$id))
                    or die("Erreur : " . $sql->errorInfo()[2]);
                    $montant += $plat->prix * $_REQUEST["quantitep".$i];
                }
            }
            if(isset($_REQUEST["boisson"])){
                $nbre=$_REQUEST["boisson"];
                foreach($nbre as $i){ 
                    $boisson=Boisson::get($i);
                    $sql = $BD->prepare("INSERT INTO `produit_commande`(`idelement`,`type_element`,`quantite`,`idcommande`) VALUES (?,?,?,?)");
                    $sql->execute(array($i,0,$_REQUEST["quantiteb".$i],$id))
                    or die("Erreur : " . $sql->errorInfo()[2]);
                    $montant += $boisson->prix * $_REQUEST["quantiteb".$i];
                }
            }
            if($_REQUEST["paye"]=='1'){
                $caisse=caisse::get($_REQUEST["caisse"]);
                $totalversement = $caisse->totalversement + $montant;
                $actuel = $caisse->solde + $montant;
                $req = $BD->prepare("INSERT INTO mouvement (
                    operation,type_operation,idcaisse,intitule,recette,depense,solde,date,justificatif
                ) VALUES (?,?,?,?,?,?,?,?,?) ");
                $req->execute(array(
                    0,
                    0,
                    $_REQUEST["caisse"],
                    "Paiement d'une commande",
                    $montant,
                    0,
                    $actuel,
                    date("Y-m-d"),
                    ''
                )) or die("Erreur : " . $req->errorInfo()[2]);
                $ido= $BD->lastInsertId();
                
                $req2 = $BD->prepare("UPDATE caisse SET totalversement = ?, solde = ? WHERE id = ?");
                $req2->execute(array(
                    $totalversement,$actuel, $_REQUEST["caisse"]
                )) or die("Erreur : " . $req2->errorInfo()[2]);
            }

            $result['state'] = "success";
        }elseif ($stock==0) {
            $result['reason']='';
            foreach($nbre as $i){ 
                if(enstock($i)<$_REQUEST["quantiteb".$i]){
                    $result['reason'] .=error_stock($i);
                }
            }
            $result['state'] = "error";
        }else{
            $result['state'] = "error";
            $result['reason'] = 'Veuillez préciser le(s) produit(s) à commander';
        }
        echo json_encode($result);
    }

    public static function modifier()
    {
        global $BD;
        $id=$_REQUEST["id"];
        $commande=Commande::get($id);
        $stock=1;
        if(isset($_REQUEST["boisson"])){
            $nbre=$_REQUEST["boisson"];
            foreach($nbre as $i){ 
                if(enstock($i)<$_REQUEST["quantiteb".$i]){
                    $stock=0;
                }
            }
        }
        if($commande->paye=='1'){
            if($_REQUEST["servi"]==1 and $commande->servi!=1){
                $serveur2=$_SESSION["idpiscine"];
            }else{
                $serveur2=NULL;
            }

            $sql = $BD->prepare("UPDATE `commande` SET `idtable`=?,`servi`=?, `idserveur2`=? WHERE `id`=?");
            $sql->execute(array($_REQUEST["table"],$_REQUEST["servi"],$serveur2,$id))
            or die("Erreur : " . $sql->errorInfo()[2]);
            $result['state'] = "success";
        }else{
            if($stock==1 and (isset($_REQUEST["repas"][0]) or isset($_REQUEST["repas"][0]))){
                if($_REQUEST["servi"]==1 and $commande->servi!=1){
                    $serveur2=$_SESSION["idpiscine"];
                }else{
                    $serveur2=NULL;
                }
                $sql = $BD->prepare("UPDATE `commande` SET `idtable`=?, `servi`=?, `paye`=?,`idserveur2`=? WHERE `id`=? ");
                $sql->execute(array($_REQUEST["table"],$_REQUEST["servi"],$_REQUEST["paye"],$serveur2,$id))
                or die("Erreur : " . $sql->errorInfo()[2]);
                
                $insert = $BD->query("DELETE FROM produit_commande WHERE idcommande IN (".$_REQUEST["id"].")");

                $montant =0;
                if(isset($_REQUEST["repas"])){
                    $nbre=$_REQUEST["repas"];
                    foreach($nbre as $i){ 
                        $plat=Plat::get($i);
                        $sql = $BD->prepare("INSERT INTO `produit_commande`(`idelement`,`type_element`,`quantite`,`idcommande`) VALUES (?,?,?,?)");
                        $sql->execute(array($i,1,$_REQUEST["quantitep".$i],$id))
                        or die("Erreur : " . $sql->errorInfo()[2]);
                        $montant += $plat->prix * $_REQUEST["quantitep".$i];
                    }
                }
                if(isset($_REQUEST["boisson"])){
                    $nbre=$_REQUEST["boisson"];
                    foreach($nbre as $i){ 
                        $boisson=Boisson::get($i);
                        $sql = $BD->prepare("INSERT INTO `produit_commande`(`idelement`,`type_element`,`quantite`,`idcommande`) VALUES (?,?,?,?)");
                        $sql->execute(array($i,0,$_REQUEST["quantiteb".$i],$id))
                        or die("Erreur : " . $sql->errorInfo()[2]);
                        $montant += $boisson->prix * $_REQUEST["quantiteb".$i];
                    }
                }
                if($_REQUEST["paye"]=='1'){
                    $caisse=caisse::get($_REQUEST["caisse"]);
                    $totalversement = $caisse->totalversement + $montant;
                    $actuel = $caisse->solde + $montant;
                    $req = $BD->prepare("INSERT INTO mouvement (
                        operation,type_operation,idcaisse,intitule,recette,depense,solde,date,justificatif
                    ) VALUES (?,?,?,?,?,?,?,?,?) ");
                    $req->execute(array(
                        0,
                        0,
                        $_REQUEST["caisse"],
                        "Paiement d'une commande",
                        $montant,
                        0,
                        $actuel,
                        date("Y-m-d"),
                        ''
                    )) or die("Erreur : " . $req->errorInfo()[2]);
                    $ido= $BD->lastInsertId();
                    
                    $req2 = $BD->prepare("UPDATE caisse SET totalversement = ?, solde = ? WHERE id = ?");
                    $req2->execute(array(
                        $totalversement,$actuel, $_REQUEST["caisse"]
                    )) or die("Erreur : " . $req2->errorInfo()[2]);
                }
    
                $result['state'] = "success";
            }elseif ($stock==0) {
                $result['reason']='';
                foreach($nbre as $i){ 
                    if(enstock($i)<$_REQUEST["quantiteb".$i]){
                        $result['reason'] .=error_stock($i);
                    }
                }
                $result['state'] = "error";
            }else{
                $result['state'] = "error";
                $result['reason'] = 'Veuillez préciser le(s) produit(s) à commander';
            }
        }

        echo json_encode($result);
    }

    public static function supprimer()
    {
        global $BD;
        $result = array();

        $insert = $BD->query("DELETE FROM commande WHERE id IN (".$_REQUEST["id"].")");
        $result['state'] = "success";

        echo json_encode($result);
        
    }

    public static function tableau()
    {
        global $BD;
        $tableau="";

        if(isset($_REQUEST['select1']) and strlen($_REQUEST['select'])>0){
            $select = explode(',',$_REQUEST['select']);
            $tableau .='<thead><tr><th>Repas</th><th>Prix</th><th>Quantité</th></tr></thead><tbody>';
            foreach ($select as $i) {
                $boisson=Plat::get($i);
                if(isset($_REQUEST["id"]) and isset(produit_commande::q()->where("idelement=? and type_element=1 and idcommande=?",$i,$_REQUEST["id"])->execute()[0])){
                    $commande=Commande::get($_REQUEST["id"]);
                    $quantite=produit_commande::q()->where("idelement=? and type_element=1 and idcommande=?",$i,$_REQUEST["id"])->execute()[0]->quantite;
                    $paye=$_REQUEST["paye"];
                }else{
                    $quantite=1;
                    $paye='';
                }
                $tableau .='<tr>';
                $tableau .='<td><label>'. $boisson->intitule.'</label></td>';
                $tableau .='<td><label>'. $boisson->prix.' FCFA</label></td>';
                $tableau .='<td><input type="number" name="quantitep'.$i.'" value="'.$quantite.'" min=1 class="form-control" '.$paye.' required /></td>';
                $tableau .='</tr>';
            }
            $tableau .='</tbody>';
        }
        if(isset($_REQUEST['select1']) and strlen($_REQUEST['select1'])>0){
            $select1 = explode(',',$_REQUEST['select1']);
            $tableau .='<thead><tr><th>Boisson</th><th>Prix</th><th>Quantité</th></tr></thead><tbody>';
            foreach ($select1 as $i) {
                $boisson=Boisson::get($i);
                if(isset($_REQUEST["id"]) and isset(produit_commande::q()->where("idelement=? and type_element=0 and idcommande=?",$i,$_REQUEST["id"])->execute()[0])){
                    $commande=Commande::get($_REQUEST["id"]);
                    $quantite=produit_commande::q()->where("idelement=? and type_element=0 and idcommande=?",$i,$_REQUEST["id"])->execute()[0]->quantite;
                    $paye=$_REQUEST["paye"];
                }else{
                    $quantite=1;
                    $paye='';
                }
                $tableau .='<tr>';
                $tableau .='<td><label>'. $boisson->intitule.'</label></td>';
                $tableau .='<td><label>'. $boisson->prix.' FCFA</label></td>';
                $tableau .='<td><input type="number" name="quantiteb'.$i.'" value="'.$quantite.'" min=1 class="form-control" '.$paye.' required /></td>';
                $tableau .='</tr>';
            }
            $tableau .='</tbody>';
        }
        $result = array();
        
        $result['tableau'] =$tableau;

        echo json_encode($result);
    }
}