<table class="table table-striped table-bordered add-rows">
    <thead>
        <tr>
            <th>Client</th>
            <th>Montant</th>
            <th>Avance</th>
            <th>Reste</th>
            <th>Servi</th>
            <th>Commande prise par : </th>
            <th>Commande servie par : </th>
            <th>Réservé pour le :</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach (Commande::q()->where("type=0")->execute() as $commande) {
            $prix=0;
            foreach (Produit_commande::q()->where("idcommande=?",$commande->id)->execute() as $prodC) {
                if($prodC->type_element==0){
                    $prix +=Boisson::get($prodC->idelement)->prix * $prodC->quantite;
                }else{
                    $prix +=Plat::get($prodC->idelement)->prix * $prodC->quantite;
                }
            }
            if(strlen($commande->idespace)>0){
                foreach(explode(',',$commande->idespace) as $i){ 
                    $prix+=Espace::get($i)->prix;
                }
            }
    ?>
        <tr>
            <td><?=Client::get($commande->idclient)->nom?></td>
            <td><?=format_money($prix)?> FCFA</td>
            <td><?=format_money($commande->avance)?> FCFA</td>
            <td><?=format_money($prix -$commande->avance)?> FCFA</td>
            <td>
                <?php
                    if ($commande->servi==1) {
                       echo "<span class='badge badge-pill bg-light-success mb-1 mr-2'>Oui</span>";
                    }else{
                        echo "<span class='badge badge-pill bg-light-danger mb-1 mr-2'>Non</span>";
                    }
                ?>
            </td>
            <td><?=strlen($commande->idserveur1)>0 ? Utilisateur::get($commande->idserveur1)->pseudo:''?></td>
            <td><?=strlen($commande->idserveur2)>0 ? Utilisateur::get($commande->idserveur2)->pseudo:''?></td>
            <td><?=format_dateDate($commande->date)?> <?=$commande->heuredeb?> <?=strlen($commande->heurefin)>0 ? '-'.$commande->heurefin:''?></td>
            <td class="text-truncate">
                <?php if(checkPrivilege("detail_reservation")){ ?>
                    <a href="reservation/detail/<?=$commande->id?>" class="primary p-0" data-id="<?=$commande->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Detail d'une reservation"><i class="ft-eye font-medium-3 mr-2"></i></a>
                <?php } ?>
                <?php if(checkPrivilege("edit_reservation") and ($commande->servi!=1 or $commande->reste!=0)){  ?>
                    <a href="javascript:;" class="success p-0 edit-row" data-id="<?=$commande->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modifier"><i class="ft-edit-2 font-medium-3 mr-2"></i></a>
                <?php } ?>
                <?php if(checkPrivilege("delete_reservation")){ ?>
                    <a href="javascript:;" class="danger p-0 delete-row" data-id="<?=$commande->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Supprimer"><i class="ft-x font-medium-3"></i></a>
                <?php } ?>
            </td>
        </tr>
    <?php
        }
    ?>
    </tbody>
</table>