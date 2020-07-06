<table class="table table-striped table-bordered add-rows">
    <thead>
        <tr>
            <th>Image</th>
            <th>Nom</th>
            <th>Prix</th>
            <th>Description</th>
            <th>Etat</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $suite='';
        if (isset($_REQUEST['categorie']) AND strlen($_REQUEST['categorie'])>0) {
            $suite .= ' AND idcategorie = "'.$_REQUEST['categorie'].'" ';
        }
        if (isset($_REQUEST['disponible']) AND strlen($_REQUEST['disponible'])>0) {
            $suite .= ' AND etat = "'.$_REQUEST['disponible'].'" ';
        }
        foreach (Plat::q()->where("id is not null ".$suite)->execute() as $plat) {
    ?>
        <tr>
            <td><center><img src="image/<?=strlen($plat->image)==0 ? 'default.png' : 'plat/'.$plat->image ?>" alt="product" style="height: 75px;"></center></td>
            <td><?=$plat->intitule?></td>
            <td><?=format_money($plat->prix)?></td>
            <td><?=$plat->description?></td>
            <td>
                <?php
                    if ($plat->etat==1) {
                       echo "<span class='badge badge-pill bg-light-success mb-1 mr-2'>Disponible</span>";
                    }else{
                        echo "<span class='badge badge-pill bg-light-danger mb-1 mr-2'>Non disponible</span>";
                    }
                ?>
            </td>
            <td class="text-truncate">
                <?php if(checkPrivilege("edit_plat")){ ?>
                    <a href="javascript:;" class="success p-0 edit-row" data-id="<?=$plat->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modifier"><i class="ft-edit-2 font-medium-3 mr-2"></i></a>
                <?php } ?>
                <?php if(checkPrivilege("delete_plat")){ ?>
                    <a href="javascript:;" class="danger p-0 delete-row" data-id="<?=$plat->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Supprimer"><i class="ft-x font-medium-3"></i></a>
                <?php } ?>
            </td>
        </tr>
    <?php
        }
    ?>
    </tbody>
</table>