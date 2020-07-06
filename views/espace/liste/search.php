<table class="table table-striped table-bordered add-rows">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prix de location</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach (espace::q()->execute() as $espace) {
    ?>
        <tr>
            <td><?=$espace->intitule?></td>
            <td><?=$espace->prix>0 ? format_money($espace->prix):''?></td>
            <td class="text-truncate">
                <?php if(checkPrivilege("edit_espace")){ ?>
                    <a href="javascript:;" class="success p-0 edit-row" data-id="<?=$espace->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modifier"><i class="ft-edit-2 font-medium-3 mr-2"></i></a>
                <?php } ?>
                <?php if(checkPrivilege("delete_espace")){ ?>
                    <a href="javascript:;" class="danger p-0 delete-row" data-id="<?=$espace->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Supprimer"><i class="ft-x font-medium-3"></i></a>
                <?php } ?>
            </td>
        </tr>
    <?php
        }
    ?>
    </tbody>
</table>