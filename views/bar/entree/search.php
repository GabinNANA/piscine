<table class="table table-striped table-bordered add-rows">
    <thead>
        <tr>
            <th>Boisson</th>
            <th>Intitule</th>
            <th>Quantite</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach (Stock::q()->where("type_element=0 and type=0")->execute() as $stock) {
    ?>
        <tr>
            <td><?=Boisson::get($stock->idelement)->intitule?></td>
            <td><?=$stock->intitule?></td>
            <td><?=$stock->quantite?></td>
            <td><?=format_dateDate($stock->date)?></td>
            <td class="text-truncate">
                <?php if(checkPrivilege("edit_entree")){ ?>
                    <a href="javascript:;" class="success p-0 edit-row" data-id="<?=$stock->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modifier"><i class="ft-edit-2 font-medium-3 mr-2"></i></a>
                <?php } ?>
                <?php if(checkPrivilege("delete_entree")){ ?>
                    <a href="javascript:;" class="danger p-0 delete-row" data-id="<?=$stock->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Supprimer"><i class="ft-x font-medium-3"></i></a>
                <?php } ?>
            </td>
        </tr>
    <?php
        }
    ?>
    </tbody>
</table>