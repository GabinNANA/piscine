<table class="table table-striped table-bordered add-rows">
    <thead>
        <tr>
            <th>Intitule</th>
            <th>Prix</th>
            <th>Caisse</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach (prix::q()->execute() as $prix) {
    ?>
        <tr>
            <td><?=$prix->intitule?></td>
            <td><?=$prix->prix?></td>
            <td><?=Caisse::get($prix->idcaisse)->intitule?></td>
            <td class="text-truncate">
                <?php if(checkPrivilege("edit_prix")){ ?>
                    <a href="javascript:;" class="success p-0 edit-row" data-id="<?=$prix->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modifier"><i class="ft-edit-2 font-medium-3 mr-2"></i></a>
                <?php } ?>
                <?php if(checkPrivilege("delete_prix")){ ?>
                    <!-- <a href="javascript:;" class="danger p-0 delete-row" data-id="<?=$prix->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Supprimer"><i class="ft-x font-medium-3"></i></a> -->
                <?php } ?>
            </td>
        </tr>
    <?php
        }
    ?>
    </tbody>
</table>