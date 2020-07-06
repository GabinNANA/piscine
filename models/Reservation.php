<?php
class Reservation extends BaseModel {
    public static $tableName='commande';
    public function __construct(){
    	
    }

    public static function ajouter()
    {
        global $BD;
        $montant=0;
        if(isset($_REQUEST["espace"][0])){
            $nbre=$_REQUEST["espace"];
            $espace='';
            foreach($nbre as $i){ 
                $espace .=','.$i;
                $montant=Espace::get($i)->prix;
            }
            $espace = substr($espace, 1);
        }else{
            $espace=NULL;
        }
        $stock=1;
        if($_REQUEST["servi"]==1){
            $serveur2=$_SESSION["idpiscine"];
        }else{
            $serveur2=NULL;
        }
        if(isset($_REQUEST["repas"])){
            $nbre=$_REQUEST["repas"];
            foreach($nbre as $i){ 
                $plat=Plat::get($i);
                $montant += $plat->prix * $_REQUEST["quantitep".$i];
            }
        }

        if(isset($_REQUEST["boisson"])){
            $nbre=$_REQUEST["boisson"];
            foreach($nbre as $i){ 
                if(enstock($i)<$_REQUEST["quantiteb".$i]){
                    $stock=0;
                }
                $boisson=Boisson::get($i);
                $montant += $boisson->prix * $_REQUEST["quantiteb".$i];
            }
        }
        $reste=$montant-zero($_REQUEST["avance"]);

        if($stock==1 and (isset($_REQUEST["repas"][0]) or isset($_REQUEST["repas"][0]) or isset($_REQUEST["espace"][0]) ) and $montant>=$_REQUEST["avance"]){
            
            $sql = $BD->prepare("INSERT INTO `commande`(`idclient`, `type`, `idespace`, `servi`,`idserveur1`,`idserveur2`, `date`, 
            `heuredeb`, `heurefin`, `avance`,`reste`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
            $sql->execute(array($_REQUEST["client"],0,$espace,$_REQUEST["servi"],$_SESSION["idpiscine"],$serveur2,$_REQUEST["date"],$_REQUEST["heuredeb"],
            $_REQUEST["heurefin"],$_REQUEST["avance"],$reste))
            or die("Erreur : " . $sql->errorInfo()[2]);
            $id=$BD->lastInsertId();

            if(isset($_REQUEST["repas"])){
                $nbre=$_REQUEST["repas"];
                foreach($nbre as $i){ 
                    $plat=Plat::get($i);
                    $sql = $BD->prepare("INSERT INTO `produit_commande`(`idelement`,`type_element`,`quantite`,`idcommande`) VALUES (?,?,?,?)");
                    $sql->execute(array($i,1,$_REQUEST["quantitep".$i],$id))
                    or die("Erreur : " . $sql->errorInfo()[2]);
                }
            }
            if(isset($_REQUEST["boisson"])){
                $nbre=$_REQUEST["boisson"];
                foreach($nbre as $i){ 
                    $boisson=Boisson::get($i);
                    $sql = $BD->prepare("INSERT INTO `produit_commande`(`idelement`,`type_element`,`quantite`,`idcommande`) VALUES (?,?,?,?)");
                    $sql->execute(array($i,0,$_REQUEST["quantiteb".$i],$id))
                    or die("Erreur : " . $sql->errorInfo()[2]);
                }
            }
            if($_REQUEST["avance"]>0){
                $caisse=caisse::get($_REQUEST["caisse"]);
                $totalversement = $caisse->totalversement + $_REQUEST["avance"];
                $actuel = $caisse->solde + $_REQUEST["avance"];
                $req = $BD->prepare("INSERT INTO mouvement (
                    operation,type_operation,idcaisse,intitule,recette,depense,solde,date,justificatif
                ) VALUES (?,?,?,?,?,?,?,?,?) ");
                $req->execute(array(
                    0,
                    1,
                    $_REQUEST["caisse"],
                    "Paiement pour reservation",
                    $_REQUEST["avance"],
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
        }else{
            if($montant<$_REQUEST["avance"]){
                $result['state'] = "error";
                $result['reason'] = 'Votre avance est superieure au coup total de la facture';
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

    public static function modifier()
    {
        
        global $BD;
        $id=$_REQUEST["id"];
        $commande=Commande::get($id);
        
        $montant=0;
        $stock=1;
        if(isset($_REQUEST["espace"][0])){
            $nbre=$_REQUEST["espace"];
            $espace='';
            foreach($nbre as $i){ 
                $espace .=','.$i;
                $montant=Espace::get($i)->prix;
            }
            $espace = substr($espace, 1);
        }else{
            $espace=NULL;
        }
        if($_REQUEST["servi"]==1 and $commande->servi!=1){
            $serveur2=$_SESSION["idpiscine"];
        }else{
            $serveur2=NULL;
        }
        if(isset($_REQUEST["repas"])){
            $nbre=$_REQUEST["repas"];
            foreach($nbre as $i){ 
                $plat=Plat::get($i);
                $montant += $plat->prix * $_REQUEST["quantitep".$i];
            }
        }
        if(isset($_REQUEST["boisson"])){
            $nbre=$_REQUEST["boisson"];
            foreach($nbre as $i){ 
                if(enstock($i)<$_REQUEST["quantiteb".$i]){
                    $stock=0;
                }
                $boisson=Boisson::get($i);
                $montant += $boisson->prix * $_REQUEST["quantiteb".$i];
            }
        }
        $reste=$montant-(zero($commande->avance) + zero($_REQUEST["avance"]));
        

        if($commande->reste=='0'){
            if($_REQUEST["servi"]==1){
                $serveur2=$_SESSION["idpiscine"];
            }else{
                $serveur2=NULL;
            }

            $sql = $BD->prepare("UPDATE `commande` SET `date`=?,`heuredeb`=?,`heurefin`=?,`servi`=?, `idserveur2`=? WHERE `id`=?");
            $sql->execute(array($_REQUEST["date"],$_REQUEST["heuredeb"],$_REQUEST["heurefin"],$_REQUEST["servi"],$serveur2,$id))
            or die("Erreur : " . $sql->errorInfo()[2]);
            $result['state'] = "success";
        }else{
            if($stock==1 and (isset($_REQUEST["repas"][0]) or isset($_REQUEST["repas"][0])) and $montant>=(zero($commande->avance) + zero($_REQUEST["avance"])) ){
                if($_REQUEST["servi"]==1){
                    $serveur2=$_SESSION["idpiscine"];
                }else{
                    $serveur2=NULL;
                }
                $sql = $BD->prepare("UPDATE `commande` SET `idclient`=?, `idespace`=?, `servi`=?,`idserveur2`=?, `date`=?, 
                `heuredeb`=?, `heurefin`=?, `avance`=?,`reste`=? WHERE `id`=? ");
                $sql->execute(array($_REQUEST["client"],$espace,$_REQUEST["servi"],$serveur2,$_REQUEST["date"],$_REQUEST["heuredeb"],
                $_REQUEST["heurefin"],(zero($commande->avance) + zero($_REQUEST["avance"])),$reste,$id))
                or die("Erreur : " . $sql->errorInfo()[2]);
                
                $insert = $BD->query("DELETE FROM produit_commande WHERE idcommande IN (".$_REQUEST["id"].")");

                if(isset($_REQUEST["repas"])){
                    $nbre=$_REQUEST["repas"];
                    foreach($nbre as $i){ 
                        $plat=Plat::get($i);
                        $sql = $BD->prepare("INSERT INTO `produit_commande`(`idelement`,`type_element`,`quantite`,`idcommande`) VALUES (?,?,?,?)");
                        $sql->execute(array($i,1,$_REQUEST["quantitep".$i],$id))
                        or die("Erreur : " . $sql->errorInfo()[2]);
                    }
                }
                if(isset($_REQUEST["boisson"])){
                    $nbre=$_REQUEST["boisson"];
                    foreach($nbre as $i){ 
                        $boisson=Boisson::get($i);
                        $sql = $BD->prepare("INSERT INTO `produit_commande`(`idelement`,`type_element`,`quantite`,`idcommande`) VALUES (?,?,?,?)");
                        $sql->execute(array($i,0,$_REQUEST["quantiteb".$i],$id))
                        or die("Erreur : " . $sql->errorInfo()[2]);
                    }
                }
                if(zero($_REQUEST["avance"])>0){
                    $caisse=caisse::get($_REQUEST["caisse"]);
                    $totalversement = $caisse->totalversement + $_REQUEST["avance"];
                    $actuel = $caisse->solde + $_REQUEST["avance"];
                    $req = $BD->prepare("INSERT INTO mouvement (
                        operation,type_operation,idcaisse,intitule,recette,depense,solde,date,justificatif
                    ) VALUES (?,?,?,?,?,?,?,?,?) ");
                    $req->execute(array(
                        0,
                        1,
                        $_REQUEST["caisse"],
                        "Paiement pour reservation",
                        $_REQUEST["avance"],
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
            }else{
                if($montant<$commande->avance){
                    $result['state'] = "error";
                    $result['reason'] = "Le prix total de votre facture est inférieur a l'avance que vous avez déjà faite. Veuillez prendre d'autres produits";
                }elseif($montant<(zero($commande->avance) + zero($_REQUEST["avance"]) ) ){
                    $result['state'] = "error";
                    $result['reason'] = "La somme des paiements antérieurs et du paiement actuel est supérieur au coût de la facture";
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
        $tableau=""; $prix=0;
        if(isset($_REQUEST['select2']) and strlen($_REQUEST['select2'])>0){
            $select2 = explode(',',$_REQUEST['select2']);
            $tableau .='<thead><tr><th>Espace</th><th>Prix</th><th><center>-</center></th></tr></thead><tbody>';
            foreach ($select2 as $i) {
                $espace=Espace::get($i);
                $tableau .='<tr>';
                $tableau .='<td><label>'. $espace->intitule.'</label></td>';
                $tableau .='<td><label>'. $espace->prix.' FCFA</label></td>';
                $tableau .='<td><center>-</center></td>';
                $tableau .='</tr>';
                $prix +=$espace->prix;
            }
            $tableau .='</tbody>';
        }
        // if(isset($_REQUEST["id"]) and strlen(Commande::get($_REQUEST["id"])->idespace)>0){
        //     $select2 = explode(',',Commande::get($_REQUEST["id"])->idespace);
        //     $tableau .='<thead><tr><th>Espace</th><th>Prix</th><th><center>-</center></th></tr></thead><tbody>';
        //     foreach ($select2 as $i) {
        //         $espace=Espace::get($i);
        //         $tableau .='<tr>';
        //         $tableau .='<td><label>'. $espace->intitule.'</label></td>';
        //         $tableau .='<td><label>'. $espace->prix.' FCFA</label></td>';
        //         $tableau .='<td><center>-</center></td>';
        //         $tableau .='</tr>';
        //     }
        //     $tableau .='</tbody>';
        // }
        if( isset($_REQUEST['select']) and strlen($_REQUEST['select'])>0){
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
                $tableau .='<td><input type="number" name="quantitep'.$i.'" onkeyup="calculateSum()" data-price="'.$boisson->prix.'" value="'.$quantite.'" min=1 class="form-control new" 
                '.$paye.' required /></td>';
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
                $tableau .='<td><input type="number" name="quantiteb'.$i.'"  onkeyup="calculateSum()" data-price="'.$boisson->prix.'"  value="'.$quantite.'" min=1 
                class="form-control new" '.$paye.' required /></td>';
                $tableau .='</tr>';
            }
            $tableau .='</tbody>';
        }
        
        $result = array();
        
        $result['tableau'] =$tableau;
        $result['prix'] =$prix;

        echo json_encode($result);
    }
}