<table class="table table-striped table-bordered add-rows">
    <thead>
        <tr>
            <th>Image</th>
            <th>Nom</th>
            <th>Quantite intitiale</th>
            <th>Prix</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $suite='';
        if (isset($_REQUEST['categorie']) AND strlen($_REQUEST['categorie'])>0) {
            $suite .= ' AND idcategorie = "'.$_REQUEST['categorie'].'" ';
        }
        foreach (Boisson::q()->where("id is not null ".$suite)->execute() as $boisson) {
    ?>
        <tr>
            <td><center><img src="image/<?=strlen($boisson->image)==0 ? 'bouteille.jpg' : 'boisson/'.$boisson->image ?>" alt="product" style="height: 75px;"></center></td>
            <td><?=$boisson->intitule?></td>
            <td><?=$boisson->quantite?></td>
            <td><?=format_money($boisson->prix)?> FCFA</td>
            <td class="text-truncate">
                <?php if(checkPrivilege("edit_boisson")){ ?>
                    <a href="javascript:;" class="success p-0 edit-row" data-id="<?=$boisson->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modifier"><i class="ft-edit-2 font-medium-3 mr-2"></i></a>
                <?php } ?>
                <?php if(checkPrivilege("delete_boisson")){ ?>
                    <a href="javascript:;" class="danger p-0 delete-row" data-id="<?=$boisson->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Supprimer"><i class="ft-x font-medium-3"></i></a>
                <?php } ?>
            </td>
        </tr>
    <?php
        }
    ?>
    </tbody>
</table>