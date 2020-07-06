<table class="table table-striped table-bordered add-rows">
    <thead>
        <tr>
            <th>Date</th>
            <th>Nombre de personnes</th>
            <th>Montant</th>
            <!-- <th>Action</th> -->
        </tr>
    </thead>
    <tbody>
    <?php
        foreach (Mouvement::query("Select distinct date from mouvement where type_operation=6")->execute() as $mouvement) {
            $count=0; $montant=0;
            foreach(Mouvement::q()->where("date=? and type_operation=6",$mouvement->date)->execute() as $t){
                $count ++;
                $montant +=$t->recette;
            }
    ?>
        <tr>
            <td><?=format_dateDate($mouvement->date)?></td>
            <td><?=$count?></td>
            <td><?=format_money($montant)?></td>
            <!-- <td class="text-truncate">
                <?php if(checkPrivilege("edit_mouvement")){ ?>
                    <a href="javascript:;" class="success p-0 edit-row" data-id="<?=$mouvement->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modifier"><i class="ft-edit-2 font-medium-3 mr-2"></i></a>
                <?php } ?>
                <?php if(checkPrivilege("delete_mouvement")){ ?>
                    <a href="javascript:;" class="danger p-0 delete-row" data-id="<?=$mouvement->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Supprimer"><i class="ft-x font-medium-3"></i></a>
                <?php } ?>
            </td> -->
        </tr>
    <?php
        }
    ?>
    </tbody>
</table>